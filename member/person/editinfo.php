<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="个人资料";

if($r_user['birthday'] != ''){
	$birthday=date('Y-m-d',$r_user['birthday']);
}else{
	$birthday='';	
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

<?php include_once($path.'/Public/js.php'); ?>
<script type="text/javascript" src="/include/My97DatePicker/WdatePicker.js"></script>

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
        	当前位置：<a href="/">首页</a>&gt;<a href="/member/person/"><?php echo $web_title?></a>&gt;<?php echo $web_name?>
        </div>
        
        <?php include_once("./leftinfo.php") ?>
        
        <div class="order_cont1 fr">
        	<div class="sr_ordernum1">
            	<span class="page_bt"><?php echo $web_name?></span>
                <div class="divclear"></div>
            </div>
            
            <div class="order_set">
            	<form name="upmember"  class="upmember" id="form" method="post">
                <input type="hidden" name="id" value="<?=$r_user['id']?>" />
                <input type="hidden" name="action" value="editinfo_saveedit" />
				<dl>
                	<dt>
                    	<label>姓名：</label>
                    	<input type="text" name="cnname" id="cnname" class="class_input" value="<?php echo $r_user['cnname']; ?>" datatype="z2-4" nullmsg="请输入姓名！" errormsg="姓名为2~4个中文字符！"  />
                        <span class="Validform_checktip">请填写真实姓名</span>
                    </dt>
                    <dt>
                    	<label>头像：</label>
                    	<input type="text" name="avatar" id="avatar" class="class_input"  value="<?php echo $r_user['avatar']; ?>" style="width:147px;" /> 
                        <span class="btn2" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,204800,'avatar')">上传</span>
                        <a href="javascript:void(0)" class="btn2" id="showpic" target="_blank">查看</a>
                        <script>
                            	$("#showpic").click(function(){
									var mystring = $(this).siblings('input').val();
									$(this).attr("href",'/' + mystring);
								});
                        </script>
                    </dt>
                	<dt>
                    	<label>性别：</label>
                        <input name="sex" type="radio" value="0" <?php if($r_user['sex'] == '0') echo 'checked="checked"'; ?>  />
						男&nbsp;
						<input name="sex" type="radio" value="1" <?php if($r_user['sex'] == '1') echo 'checked="checked"'; ?> />
						女
                        <span class="Validform_checktip"></span>
                    </dt>
                    <dt>
                    	<label>生日：</label>
                        <input type="text" name="birthday" class="class_input Wdate" onClick="WdatePicker()" value="<?php echo $birthday?>" />
                        <span class="Validform_checktip">时间格式：<?php echo date('Y-m-d')?></span>
                    </dt>
                    
                    <dt>
                    	<label>邮箱：</label>
                        <input type="text" name="email" id="email" class="class_input" value="<?php echo $r_user['email']; ?>" datatype="e" nullmsg="请输入邮箱！" errormsg="邮箱格式不正确！" ignore="ignore"  />
                        <span class="Validform_checktip"></span>
                    </dt>
                    <dt>
                    	<label>手机：</label>
                        <input type="text" name="mobile" id="mobile" class="class_input" value="<?php echo $r_user['mobile']; ?>" datatype="m" nullmsg="请输入手机！" errormsg="手机格式不正确！" ignore="ignore"  />
                        <span class="Validform_checktip"></span>
                    </dt>
                    <dt>
                    	<label>地址：</label>
                            <select name="address_prov" onchange="showCity(this)">
                            	<option value="-1">请选择</option><?=list_cas($r_user['address_prov'],'area')?>
                            </select>
                        	<select name="address_city" onchange="showCounty(this)" >
                            	<option value="-1">请选择</option><?=row_cas($r_user['address_city'],'',$floor='2',$r_user['address_prov'])?>
                            </select>
                            <select name="address_country" <?=$r_user['address_country'] == '-1' ? 'style="display:none;"' : ''?> >
                            	<option value="-1">请选择</option><?=row_cas($r_user['address_country'],'',$floor='3',$r_user['address_city'])?>
                            </select>                        
                        
                        
						
                        <span class="Validform_checktip"></span>
                    </dt>
                    <dt>
                    	<label>街道：</label>
                    	<input type="text" name="address" id="address" class="class_input" value="<?php echo $r_user['address']; ?>" />
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
		}
	});  //就这一行代码！
})
</script>
</body>
</html>
