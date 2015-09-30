<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_title="找回密码";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg_webname; ?> - <?php echo $web_title?></title>
<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="/css/login.css" />
<script type="text/javascript" src="<?php echo $cfg_webpath; ?>/templates/default/js/jquery.min.js"></script>
<script type="text/javascript" src="/templates/default/js/member.js"></script>
</head>

<body>

<?php require_once(dirname(__FILE__).'/../../../public/top.php'); ?>


<!--头部-->
<div class="warpper">
	<div class="itop_logo top_logo"><a href="/"><img src="images/logo.png"></a><span class="itop_name1"><?php echo $web_title?></span></div>
</div>


<div class="warpper">
	<div class="mt40">
    	<div id="sflex04" class="stepflex ">
            <dl class="first">
                <dt class="s-num">1</dt>
                <dd class="s-text">填写账户名<s></s><b></b></dd>
                <dd></dd>
            </dl>
            <dl class="normal">
                <dt class="s-num">2</dt>
                <dd class="s-text">验证身份<s></s><b></b></dd>
            </dl>
            <dl class="normal">
                <dt class="s-num">3</dt>
                <dd class="s-text">设置新密码<s></s><b></b></dd>
            </dl>
            <dl class="last doing">
                <dt class="s-num">&nbsp;</dt>
                <dd class="s-text">完成<s></s><b></b></dd>
            </dl>
        </div>
        
        <div class="findpwd4">
			您的新密码已设置成功，请<a href="/member.php?c=login">登陆</a>。
        </div>
	</div>		
</div>

<!--底部-->
<footer class="ifooter">
	<?php require_once(dirname(__FILE__).'/../../../public/bottom.php'); ?>
</footer>

<script type="text/javascript" src="/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">
$(function(){
	
	$(".findpwd").Validform({
		tiptype:3,
		label:".label",
		showAllError:true,
		ignoreHidden:true,
		datatype:{//传入自定义datatype类型【方式二】;
			"uname": /^[a-zA-Z][a-zA-Z0-9_]{5,15}$/,
		}
	});  //就这一行代码！
})
</script>

</body>
</html>