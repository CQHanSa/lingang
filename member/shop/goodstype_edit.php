<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

if($id==''){
	$web_name="添加分类";	
}else{
	$web_name="修改分类";	
}


//初始化数据
$pid = isset($pid) ? $pid : '0';
$action='goodstype_saveadd';
$r['id']="";
$r['parentid']=$pid;
$r['classname']="";
$r['orderid']=GetOrderID('#@__shopstype');
$r['checkinfo']="true";

if($id>0){
	$r = $dosql->GetOne("SELECT * FROM `#@__shopstype` WHERE `shopid`='".$r_shop['id']."' and id='$id'");
	if(!is_array($r)){
		ShowMsg('参数错误！','-1');
		exit();
	}else{
		$action='goodstype_saveedit';
	}
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
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
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
                <input type="hidden" name="id" value="<?=$r['id']?>" />
                <input type="hidden" name="action" value="<?php echo $action?>" />
				<dl>
                	<dt>
                    	<label>所属分类：</label>
                        <select name="parentid" id="parentid" datatype="*" nullmsg="请选择分类！" style="width:100px;">
						<option value="0">一级分类</option>
						<?php
						$dosql->Execute("SELECT * FROM `#@__shopstype` WHERE `shopid`='".$r_shop['id']."' AND parentid=0 ORDER BY orderid ASC, id ASC");
						while($row = $dosql->GetArray())
						{
							if($r['parentid'] === $row['id'])
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
                    	<label>分类名称：</label>
                        <input type="text" name="classname" class="class_input" value="<?php echo $r['classname']?>" datatype="*" nullmsg="请输入分类名称！"  />
                    </dt>  
					
                    <dt>
                    	<label>排序：</label>
                        <input type="text" name="orderid" class="class_input" value="<?php echo $r['orderid']?>" style="width:50px" datatype="n" />
                    </dt> 
                    
					<dt>
                    	<label>是否显示：</label>
                        <input name="checkinfo" type="radio" value="true" <?php if($r['checkinfo'] == 'true') echo 'checked="checked"'; ?>  />
						显示&nbsp;
						<input name="checkinfo" type="radio" value="false" <?php if($r['checkinfo'] == 'false') echo 'checked="checked"'; ?> />
						隐藏    
                    </dt>
				</dl>
                <div class="save_reset"><input type="submit" class="btn1" value="保存" /> <input type="reset" class="btn1" value="重置" /></div>
                </form>
            </div>
            
            <div class="divclear"></div>
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
</script>
</body>
</html>
