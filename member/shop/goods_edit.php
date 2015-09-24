<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

if($id==''){
	$web_name="添加商品";	
}else{
	$web_name="修改商品";	
}



//初始化数据
$action='goods_saveadd';
$r['id']="";
$r['title']="";
$r['marketprice']="0.00";
$r['price']="0.00";
$r['guige']="";
$r['promotions_price']="0.00";
$r['housenum']="100";
$r['typetid']="";
$r['typepid']="";
$r['typeid']="";
$r['shoptype_pid']="";
$r['shoptype_id']="";
$r['brandid']="";
$r['shop_addressid']="";
$r['flag']="";
$r['issale']="true";
$r['picurl']="";
$r['content']="";
$r['picarr']="";
$r['promotions']="false";
$r['promotions_starttime']="";
$r['promotions_endtime']="";


if($id>0){
	$r = $dosql->GetOne("SELECT * FROM `#@__goods` WHERE `shopid`='".$r_shop['id']."' and id='$id'");
	if(!is_array($r)){
		ShowMsg('参数错误！','-1');
		exit();
	}else{
		$action='goods_saveedit';
		if($r['promotions_starttime'] != 0 && $r['promotions_endtime'] != 0)
		{
			$r['promotions_starttime']=date('Y-m-d H:i:s',$r['promotions_starttime']);
			$r['promotions_endtime']=date('Y-m-d H:i:s',$r['promotions_endtime']);
		}
	}
	//分割店铺价格
	$price = explode(',',$r['price']);
	$marketprice = explode(',',$r['marketprice']);
	$promotions_price = explode(',',$r['promotions_price']);
	$guige = explode(',',$r['guige']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $cfg_webname; ?> - <?php echo $web_title?></title>
<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link href="/adminhs/plugin/calendar/calendar-blue.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/css/order.css"/>
<link rel="stylesheet" type="text/css" href="/css/member.css">
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="/templates/default/js/member.js"></script>
<script type="text/javascript" src="/templates/default/js/getuploadify.js"></script>
<script type="text/javascript" src="/js/click.js"></script>
<script type="text/javascript" src="/include/editor/kindeditor-min.js"></script>
<script type="text/javascript" src="/include/editor/lang/zh_CN.js"></script>
<script type="text/javascript" src="/adminhs/plugin/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="/adminhs/plugin/calendar/calendar.js"></script>
</head>

<body>
<!-- 顶部信息 -->
<?php include_once("../../public/top.php") ?>

<!-- logo+搜索 -->
<?php include_once("../../public/logo_search.php") ?>

<!-- 导航菜单栏 -->
<?php include_once("../../public/menu.php") ?>

<div class="icontent">
	<div class="icontent_c">
    	<!-- 当前位置 -->
    	<div class="order_top">
        	当前位置：<a href="/">首页</a>&gt;<a href="/member.php"><?php echo $web_title?></a>&gt;<?php echo $web_name?>
        </div>
        
        <?php include_once("./leftinfo.php") ?>
        
        <div class="order_cont1 t_right">
        	<div class="sr_ordernum1">
            	<span class="page_bt"><?php echo $web_name?></span>
                <div class="divclear"></div>
            </div>
            
            <div class="order_set">
            	<form name="upmember"  class="upmember" id="form" method="post">
                <input type="hidden" name="id" value="<?=$r['id']?>" />
                <input type="hidden" name="action" value="<?php echo $action?>" />
				<dl>
                
                	<dt>
                    	<label>商品名称：</label>
                        <input type="text" name="title" class="class_input" value="<?php echo $r['title']?>" datatype="*" nullmsg="请输入商品名称！"  />
                        <span class="Validform_checktip">*</span>
                    </dt> 
                    
                   <!-- <dt>
                    	<label>市场价格：</label>
                        <input type="text" name="marketprice" class="class_input" value="<?php echo $r['marketprice']?>" datatype="*" nullmsg="请输入市场价格！"  />
                        <span class="Validform_checktip">*</span>
                    </dt>-->   
                    <?php if(!isset($price)){ ?>
                    <dt>
                    	<label>店铺价格：</label>
                        价格：<input type="text" name="price[]" class="price class_input" value="<?php echo $r['price']?>" datatype="float" nullmsg="请输入店铺价格！"  placeholder="价格" onkeyup="jsmarkprice(this)" />
                        市场价：<input type="text" name="marketprice[]" class="price class_input" value="<?php echo $r['marketprice']?>" datatype="float" nullmsg="请输入市场价格！"  placeholder="市场价格" />
                        促销价格：<input type="text" name="promotions_price[]" class="price class_input" value="<?php echo $r['promotions_price']?>" datatype="float" nullmsg="请输入店铺促销价格！"  placeholder="促销价格" />  
                        规格：<input type="text" name="guige[]" class="price class_input" value="<?php echo $r['guige']?>" datatype="*" nullmsg="请输入规格！" placeholder="规格" /> 
                        <a onclick="addPriceRow(this)" rel='1' style="cursor:pointer;">+添加</a>
                        <span class="Validform_checktip">规格如：100克 / 200kg</span>
                    </dt>
                    <?php  }else{ 
									for($i=0,$n=count($price);$i<$n;$i++)
									{
										if($i==0){ $label='店铺价格：'; $f = '+添加'; $f_type= 'onclick="addPriceRow(this)"'; }
										else{  $label=''; $f = '-删除'; $f_type= 'onclick="delPriceRow(this)"';}
					?>
					 <dt>
                    	<label><?=$label?></label>
                        价格：<input type="text" name="price[]" class="price class_input" value="<?=$price[$i]?>" datatype="float" nullmsg="请输入店铺价格！"  placeholder="价格" onkeyup="jsmarkprice(this)" />
                        市场价：<input type="text" name="marketprice[]" class="price class_input" value="<?=$marketprice[$i]?>" datatype="float" nullmsg="请输入市场价格！"  placeholder="市场价格" />
                        促销价格：<input type="text" name="promotions_price[]" class="price class_input" value="<?=$promotions_price[$i]?>" datatype="float" nullmsg="请输入店铺促销价格！"  placeholder="促销价格" />  
                        规格：<input type="text" name="guige[]" class="price class_input" value="<?=$guige[$i]?>" datatype="*" nullmsg="请输入规格！" placeholder="规格" /> 
                        <a <?=$f_type?>  rel='1' style="cursor:pointer;"><?=$f?></a>
                        <span class="Validform_checktip">规格如：100克 / 200kg</span>
                    </dt>		
                    <?php			}
								}
					 ?>
                    <!--<dt>
                    	<label>商品规格：</label>
                        <input type="text" name="guige" class="class_input" value="<?php echo $r['guige']?>"   />
                        <span class="Validform_checktip">多种规格用英文 | 隔开</span>
                    </dt>-->
                    
                    <dt class="kc">
                    	<label>商品库存：</label>
                        <input type="text" name="housenum" class="class_input" value="<?php echo $r['housenum']?>" datatype="*" nullmsg="请输入商品库存！"  />
                        <span class="Validform_checktip">*</span>
                    </dt> 
                    
                	<dt>
                    	<label>所属分类：</label>
                        <select name="typetid" id="goodstype_id1" datatype="*" nullmsg="请选择分类！" style="width:100px;" onchange="SelType(this.value,2);" >
						<option value="">请选择</option>
						<?php
						$dosql->Execute("SELECT * FROM `#@__goodstype` WHERE parentid=0 and checkinfo='true' ORDER BY orderid ASC, id ASC");
						while($row = $dosql->GetArray())
						{
							if($r['typetid'] === $row['id'])
								$selected = 'selected="selected"';
							else
								$selected = '';
		
							echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['classname'].'</option>';
						}
						?>
						</select>
                        <select name="typepid" id="goodstype_id2" datatype="*" nullmsg="请选择分类！" style="width:100px;" onchange="SelType(this.value,3);" >
						<option value="">--</option>
						<?php
						if($r['typepid'] != ''){
						$dosql->Execute("SELECT * FROM `#@__goodstype` WHERE  parentid=".$r['typetid']." and checkinfo='true' ORDER BY orderid ASC, id ASC");
						while($row = $dosql->GetArray())
						{
							if($r['typepid'] === $row['id'])
								$selected = 'selected="selected"';
							else
								$selected = '';
		
							echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['classname'].'</option>';
						}
						}
						?>
						</select>
                        <select name="typeid" id="goodstype_id3" style="width:100px;">
						<option value="0">--</option>
						<?php
						if($r['typeid'] != ''){
						$dosql->Execute("SELECT * FROM `#@__goodstype` WHERE parentid=".$r['typepid']." and checkinfo='true' ORDER BY orderid ASC, id ASC");
						while($row = $dosql->GetArray())
						{
							if($r['typeid'] === $row['id'])
								$selected = 'selected="selected"';
							else
								$selected = '';
		
							echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['classname'].'</option>';
						}
						}
						?>
						</select>
                        <span class="Validform_checktip"></span>
                    </dt>
                    
                    <dt>
                    	<label>店铺分类：</label>
                        <select name="shoptype_pid" id="shoptype_pid" style="width:100px;"  onchange="SelShopType(this.value,<?php echo $r_shop['id']?>);">
						<option value="0">请选择</option>
						<?php
						$dosql->Execute("SELECT * FROM `#@__shopstype` WHERE `shopid`='".$r_shop['id']."' AND parentid=0 ORDER BY orderid ASC, id ASC");
						while($row = $dosql->GetArray())
						{
							if($r['shoptype_pid'] === $row['id'])
								$selected = 'selected="selected"';
							else
								$selected = '';
		
							echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['classname'].'</option>';
						}
						?>
						</select>
                        <select name="shoptype_id" id="shoptype_id" style="width:100px;" >
						<option value="0">请选择</option>
						<?php
						if($r['shoptype_id'] !=''){
						$dosql->Execute("SELECT * FROM `#@__shopstype` WHERE `shopid`='".$r_shop['id']."' AND parentid='".$r['shoptype_pid']."' ORDER BY orderid ASC, id ASC");
						while($row = $dosql->GetArray())
						{
							if($r['shoptype_id'] === $row['id'])
								$selected = 'selected="selected"';
							else
								$selected = '';
		
							echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['classname'].'</option>';
						}
						}
						?>
						</select>
                        <span class="Validform_checktip"></span>
                    </dt>
                    
                    <dt>
                    	<label>品牌分类：</label>
                        <select name="brandid" id="brandid"  style="width:100px;">
						<option value="0">请选择</option>
						<?php
						if($r['brandid']!='' && $r['typetid']!=''){
						$dosql->Execute("SELECT * FROM `#@__goodsbrand` WHERE parentid='".$r['typetid']."' ORDER BY orderid ASC, id ASC");
						while($row = $dosql->GetArray())
						{
							if($r['brandid'] === $row['id'])
								$selected = 'selected="selected"';
							else
								$selected = '';
		
							echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['classname'].'</option>';
						}
						}
						?>
						</select>
                        <span class="Validform_checktip"></span>
                    </dt>
                    
                    <dt>
                    	<label>商品产地：</label>
                        <select name="shop_addressid" id="shop_addressid" style="width:100px;">
						<option value="0">请选择</option>
						<?php
						$dosql->Execute("SELECT * FROM `#@__goodsaddress` WHERE parentid=0 ORDER BY orderid ASC, id ASC");
						while($row = $dosql->GetArray())
						{
							if($r['shop_addressid'] === $row['id'])
								$selected = 'selected="selected"';
							else
								$selected = '';
		
							echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['classname'].'</option>';
						}
						?>
						</select>
                        <span class="Validform_checktip"></span>
                    </dt>
                    
                    <dt>
                    	<label>商品属性：</label>
                        <?php
						$flagarr = explode(',',$r['flag']);
			
						$dosql->Execute("SELECT * FROM `#@__goodsflag` ORDER BY orderid ASC");
						while($row = $dosql->GetArray())
						{
							echo '<input type="checkbox" name="flag[]" id="flag[]" value="'.$row['flag'].'"';
			
							if(in_array($row['flag'],$flagarr))
							{
								echo 'checked="checked"';
							}
			
							echo ' />'.$row['flagname'].' &nbsp; ';
						}
						?>
                    </dt> 
					
					<dt>
                    	<label>商品状态：</label>
                        <input name="issale" type="radio" value="true" <?php if($r['issale'] == 'true') echo 'checked="checked"'; ?>  />
						上架&nbsp;
						<input name="issale" type="radio" value="false" <?php if($r['issale'] == 'false') echo 'checked="checked"'; ?> />
						下架    
                    </dt>
                    
                    <dt>
                    	<label>商品图片：</label>
                        <input type="text" name="picurl" id="picurl" class="class_input"  value="<?php echo $r['picurl']; ?>" style="width:147px;" /> 
                        <span class="btn2" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,204800,'picurl')">上传</span>
                        <a href="javascript:void(0)" class="btn2 showpic" target="_blank">查看</a>
                        <span class="Validform_checktip">图片大小：200 x 200(px)</span>
                    </dt> 
                    
                    <dt class="mt10">
                    	<label class="fl">商品描述：</label>
                        <div class="textarea_content">
                        <textarea name="content" id="content" class="kindeditor"><?php echo $r['content']; ?></textarea>
						<script>
                        var editor;
                        KindEditor.ready(function(K) {
                            editor = K.create('textarea[name="content"]', {
                                allowFileManager : true,
                                width:'667px',
                                height:'280px',
                                extraFileUploadParams : {
                                    sessionid :  '<?php echo session_id(); ?>'
                                }
                            });
                        });
                        </script>
                        </div>
                        <div class="divclear"></div>
                    </dt> 
                    
                    <dt>
                    	<label class="fl mt10" >商品组图：</label>
                        <fieldset class="picarr">
                            <legend>列表</legend>
                            <div>最多可以上传<strong>10</strong>张图片<span onclick="GetUploadify('uploadify2','组图上传','image','image',10,<?php echo $cfg_max_file_size; ?>,'picarr','picarr_area')">开始上传</span></div>
                            <ul id="picarr_area">
                            <?php
							if($r['picarr'] != '')
							{
								$picarr = unserialize($r['picarr']);
								foreach($picarr as $v)
								{
									$v = explode(',', $v);
									echo '<li rel="'.$v[0].'"><input type="text" name="picarr[]" value="'.$v[0].'"><a href="javascript:void(0);" onclick="ClearPicArr(\''.$v[0].'\')">删除</a><br /><input type="text" name="picarr_txt[]" value="'.$v[1].'"><span>描述</span></li>';
								}
							}
							?>
                            </ul>
                        </fieldset>
                        <div class="divclear"></div>
                    </dt> 
                    
                    <dt>
                    	<label>商品促销：</label>
                        <input name="promotions" type="radio" value="true" <?php if($r['promotions'] == 'true') echo 'checked="checked"'; ?>  />
						是&nbsp;
						<input name="promotions" type="radio" value="false" <?php if($r['promotions'] == 'false') echo 'checked="checked"'; ?> />
						否    
                    </dt>
                    <!--
                    <dt>
                    	<label>促销价格：</label>
                        <input type="text" name="promotions_price" class="class_input" value="<?php echo $r['promotions_price']?>" />
                    </dt>
                    -->
                    <dt>
                    	<label>促销开始时间：</label>
                        <input type="text" id="promotions_starttime" name="promotions_starttime" class="class_input inputms" readonly="readonly"  value="<?php echo $r['promotions_starttime']?>" />
                        <span class="Validform_checktip">时间格式：<?php echo date('Y-m-d h:i:m',time())?></span>
                        <script type="text/javascript">
						date = new Date();
						Calendar.setup({
							inputField     :    "promotions_starttime",
							ifFormat       :    "%Y-%m-%d %H:%M:%S",
							showsTime      :    true,
							timeFormat     :    "24"
						});
						</script>
                    </dt>
                    
                    <dt>
                    	<label>促销结束时间：</label>
                        <input type="text" id="promotions_endtime" name="promotions_endtime" class="class_input inputms" readonly="readonly"  value="<?php echo $r['promotions_endtime']?>" />
                        <span class="Validform_checktip">结束时间必须大于开始时间</span>
                        <script type="text/javascript">
						date = new Date();
						Calendar.setup({
							inputField     :    "promotions_endtime",
							ifFormat       :    "%Y-%m-%d %H:%M:%S",
							showsTime      :    true,
							timeFormat     :    "24"
						});
						</script>
                    </dt>
                    
				</dl>
                <div class="save_reset"><input type="submit" class="btn1" value="保存" /> <input type="reset" class="btn1" value="重置" /></div>
                </form>
            </div>
            
        </div>
    </div>
</div>

<!-- 底部 -->
<?php include_once("../../public/footer.php") ?>
<script type="text/javascript" src="/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">

$(function(){
	$(".upmember").Validform({
		tiptype:3,
		label:".label",
		showAllError:true,
		ignoreHidden:true,
		datatype:{//传入自定义datatype类型【方式二】;
			"uname": /^[a-zA-Z][a-zA-Z0-9_]*$/,
			"z2-4" : /^[\u4E00-\u9FA5\uf900-\ufa2d]{2,4}$/,
			"float":/^\d+(?:\.\d+)?$/,
			"phone":function(gets,obj,curform,regxp){
				/*参数gets是获取到的表单元素值，
				  obj为当前表单元素，
				  curform为当前验证的表单，
				  regxp为内置的一些正则表达式的引用。*/

				var reg1=regxp["m"],
					reg2=/[\d]{7}/,
					mobile=curform.find(".usermobile");
				
				if(reg1.test(mobile.val())){return true;}
				if(reg2.test(gets)){return true;}
				
				return false;
			}	
		}
	});  //就这一行代码！
})

$(".showpic").click(function(){
	var mystring = $(this).siblings('input').val();
	$(this).attr("href",'/' + mystring);
});
</script>
</body>
</html>
