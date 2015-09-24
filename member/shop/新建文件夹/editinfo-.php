<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="店铺资料";

$r = $dosql->GetOne("SELECT * FROM `#@__shops` WHERE `userid`='".$r_user['id']."'");
if(!is_array($r)){
	ShowMsg('参数错误！','-1');
	exit();	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $cfg_webname; ?> - <?php echo $web_title?></title>
<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/css/order.css"/>
<link rel="stylesheet" type="text/css" href="/css/member.css">
<script type="text/javascript" src="/templates/default/js/jquery.min.js"></script>
<script type="text/javascript" src="/templates/default/js/member.js"></script>
<script type="text/javascript" src="/templates/default/js/getuploadify.js"></script>
<script type="text/javascript" src="/js/click.js"></script>

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
        
        <div class="order_cont1 fr">
        	<div class="sr_ordernum1">
            	<span class="page_bt"><?php echo $web_name?></span>
                <div class="divclear"></div>
            </div>
            
            <div class="order_set">
            	<form name="upmember"  class="upmember" id="form" method="post">
                <input type="hidden" name="userid" value="<?=$r_user['id']?>" />
                <input type="hidden" name="action" value="editinfo_saveedit" />
				<dl>
                	<dt>
                    	<label>店铺名称：</label>
                    	<input type="text" name="shopname" id="shopname" class="class_input" value="<?php echo $r['shopname']; ?>" datatype="*" nullmsg="请输入店铺名称！"   />
                        <span class="Validform_checktip">请填写店铺名称</span>
                    </dt>
                    <dt>
                    	<label>店主姓名：</label>
                    	<input type="text" name="shop_username" id="shop_username" class="class_input" value="<?php echo $r['shop_username']; ?>" datatype="*" nullmsg="请输入店主姓名！"  />
                        <span class="Validform_checktip">请填写店主姓名</span>
                    </dt>
                    <dt>
                    	<label>公司名称：</label>
                    	<input type="text" name="shopcompany" id="shopcompany" class="class_input" value="<?php echo $r['shopcompany']; ?>"  />
                        <span class="Validform_checktip"></span>
                    </dt>
                    <dt>
                    	<label>店铺图标：</label>
                    	<input type="text" name="shop_logo" id="shop_logo" class="class_input"  value="<?php echo $r['shop_logo']; ?>" style="width:147px;" /> 
                        <span class="btn2" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,204800,'shop_logo')">上传</span>
                        <a href="javascript:void(0)" class="btn2 showpic" target="_blank">查看</a>
                        <span class="Validform_checktip">图片大小：150 x 150(px)</span>
                    </dt>
                    <dt>
                    	<label>店招：</label>
                    	<input type="text" name="shop_signs" id="shop_signs" class="class_input"  value="<?php echo $r['shop_signs']; ?>" style="width:147px;" /> 
                        <span class="btn2" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,204800,'shop_signs')">上传</span>
                        <a href="javascript:void(0)" class="btn2 showpic" target="_blank">查看</a>
                        <span class="Validform_checktip">图片大小：1920 x 110(px)</span>
                    </dt>
                    <dt>
                    	<label>店铺banner：</label>
                    	<input type="text" name="shop_banner" id="shop_banner" class="class_input"  value="<?php echo $r['shop_banner']; ?>" style="width:147px;" /> 
                        <span class="btn2" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,204800,'shop_banner')">上传</span>
                        <a href="javascript:void(0)" class="btn2 showpic" target="_blank">查看</a>
                        <span class="Validform_checktip">图片大小：1920 x 500(px)</span>
                    </dt>
                    <dt>
                    	<label>店铺中间广告位：</label>
                    	<input type="text" name="shop_ad1" id="shop_ad1" class="class_input"  value="<?php echo $r['shop_ad1']; ?>" style="width:147px;" /> 
                        <span class="btn2" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,204800,'shop_ad1')">上传</span>
                        <a href="javascript:void(0)" class="btn2 showpic" target="_blank">查看</a>
                        <span class="Validform_checktip">图片大小：760 x 240(px)</span>
                    </dt>
                    <dt>
                    	<label>店铺左侧广告一：</label>
                    	<input type="text" name="shop_ad2" id="shop_ad2" class="class_input"  value="<?php echo $r['shop_ad2']; ?>" style="width:147px;" /> 
                        <span class="btn2" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,204800,'shop_ad2')">上传</span>
                        <a href="javascript:void(0)" class="btn2 showpic" target="_blank">查看</a>
                        <span class="Validform_checktip">图片大小：宽度195(px)</span>
                    </dt>
                    <dt>
                    	<label>店铺左侧广告二：</label>
                    	<input type="text" name="shop_ad3" id="shop_ad3" class="class_input"  value="<?php echo $r['shop_ad3']; ?>" style="width:147px;" /> 
                        <span class="btn2" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,204800,'shop_ad3')">上传</span>
                        <a href="javascript:void(0)" class="btn2 showpic" target="_blank">查看</a>
                        <span class="Validform_checktip">图片大小：宽度195(px)</span>
                    </dt>
                    <dt>
                    	<label>店铺电话：</label>
                    	<input type="text" name="shop_tel" id="shop_tel" class="class_input" value="<?php echo $r['shop_tel']; ?>" datatype="*" nullmsg="请输入店铺电话！" />
                        <span class="Validform_checktip">请填写店铺电话</span>
                    </dt>
                    <dt>
                    	<label>店铺地址：</label>
                        <select name="address_prov" id="address_prov" onchange="SelProv(this.value,'address');" datatype="*" nullmsg="请选择店铺地址！">
							<option value="">请选择</option>
							<?php
							$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=0 ORDER BY orderid ASC, datavalue ASC");
							while($row = $dosql->GetArray())
							{
								if($r['shop_prov'] === $row['datavalue'])
									$selected = 'selected="selected"';
								else
									$selected = '';
		
								echo '<option value="'.$row['datavalue'].'" '.$selected.'>'.$row['dataname'].'</option>';
							}
							?>
						</select>
						<select name="address_city" id="address_city" datatype="*" nullmsg="请选择店铺地址！">
							<option value="">--</option>
							<?php
							$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=1 AND datavalue>".$r['shop_prov']." AND datavalue<".($r['shop_prov'] + 500)." ORDER BY orderid ASC, datavalue ASC");
							while($row = $dosql->GetArray())
							{
								if($r['shop_city'] === $row['datavalue'])
									$selected = 'selected="selected"';
								else
									$selected = '';
		
								echo '<option value="'.$row['datavalue'].'" '.$selected.'>'.$row['dataname'].'</option>';
							}
							?>
						</select>
                        <span class="Validform_checktip"></span>
                    </dt>
                    <dt>
                    	<label></label>
                    	<input type="text" name="shop_address" id="shop_address" class="class_input" value="<?php echo $r['shop_address']; ?>"  datatype="*" nullmsg="请选输入铺地址！" />
                    </dt>
                	<dt>
                    	<label>营业状态：</label>
                        <input name="checkinfo" type="radio" value="true" <?php if($r['checkinfo'] == 'true') echo 'checked="checked"'; ?>  />
						营业中&nbsp;
						<input name="checkinfo" type="radio" value="false" <?php if($r['checkinfo'] == 'false') echo 'checked="checked"'; ?> />
						休息中
                        <span class="Validform_checktip"></span>
                    </dt>
                    
                    
                    <dt>
                    	<label class="fl">配送区域：</label>
                        <span class="psqy">
                        	<input type="button" class="btn1 set_xz" value="点击此处选择配送区域" />
                        	<input type="hidden" name="delivery_area" id="delivery_area" >
                            <div class="divclear"></div>
                            <div class="community_list2">
                            	<dl>
                                	<dt>江北区（观音桥、红旗河沟、大庙、五里店）</dt>
                                	<dt>南岸区（南坪、四公里、六公里、四小区、五小区、光电路、万寿路、铜元局）</dt>
                                	<dt>渝中区（解放碑、朝天门）</dt>
                                </dl>
                            </div>
                        </span>
                    </dt>
                </dl>	
                <div class="divclear"></div>
                <div class="save_reset"><input type="submit" class="btn1" value="保存" /> <input type="reset" class="btn1" value="重置" /></div>
                </form>
            </div>
            
        </div>
    </div>
</div>

<!-- 底部 -->
<?php include_once("../../public/footer.php") ?>

<!--弹出框-->
<div id="fullbg"></div>
<div class="shbox">
    	<h1>选择送货点<span class="close" id="close"><img src="/images/shc.jpg"></span></h1>
    	<div class="shform">
			<div class="shrow">
            	<span>选择城市：</span>
                <select name="community_prov" id="community_prov" onchange="SelProv(this.value,'community');" >
				<option value="">请选择</option>
				<?php
				$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=0 ORDER BY orderid ASC, datavalue ASC");
				while($row = $dosql->GetArray())
				{
					echo '<option value="'.$row['datavalue'].'" '.$selected.'>'.$row['dataname'].'</option>';
				}
				?>
				</select>
                <select name="community_city" id="community_city" onchange="SelectCommunity(this.value)" >
				<option value="">请选择</option>
				</select>
            </div>
    		<div class="shrow">
            	<span>选择送货点：</span>
            	<div class="community_list">
                    请选择社区
                </div>
            	<span></span><div class="showmore zk"><a>展开更多</a></div><div class="showmore sq"><a>收起</a></div>
            </div>
            <div class="shrow"><span></span><input type="button" id="save" value="保存送货点"><input type="button" id="qxbc" value="取消"></div>
    	</div>
    </div>
    


<script type="text/javascript" src="/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">

$(function(){
	
	$('.sq').hide();
	$('.sq').click(function(){
		$(this).hide();
		$('.zk').show();
   		$('.shform .shrow ul').css({'height':'124','overflow':'hidden'});
    });
	$('.zk').click(function(){
		$(this).hide();
		$('.sq').show();
   		$('.shform .shrow ul').css({'height':'200','overflow':'auto'});
    });
	
	var thisaddress;
	$('.set_xz').click(function(){
		$('.shrow ul li a').css({'color':''});
		$('#fullbg').show();
		$('.shbox').show();
	});
	$('#close,#qxbc').click(function(){
		$('#fullbg').hide();
		$('.shbox').hide();
		});
	$('#save').click(function(){
		$('#fullbg').hide();
		$('.shbox').hide();
		
	});
	
	
	
	$(".upmember").Validform({
		tiptype:3,
		label:".label",
		showAllError:true,
		ignoreHidden:true,
		datatype:{//传入自定义datatype类型【方式二】;
			"uname": /^[a-zA-Z][a-zA-Z0-9_]*$/,
			"z2-4" : /^[\u4E00-\u9FA5\uf900-\ufa2d]{2,4}$/,
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
