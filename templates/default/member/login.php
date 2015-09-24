<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_title="会员登陆";
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

<div class="loginbox" >
	<div class="warpper login_wrap">

		<div class="loginform">
        	<h1><strong class="dc">Hi，欢迎登录！</strong><span>我还不是临港大市场会员？<a href="/member.php?c=reg">免费注册</a></span></h1>
           	<div class="reg_form reg_form_step2">
            	<form id="form" method="post" action="/member.php?a=login" onsubmit="return CheckLog();">
                <div class="reg_row mb20">
                <input name="username" id="username" placeholder="邮箱/手机号/用户名" class="form-control u_name" type="text" />
                </div>
                <div class="reg_row">
                <input type="password" name="password" id="password"  placeholder="登录密码" class="form-control u_ps"  />
                </div>
                <div class="">
                    <div class="fr"><a href="/member.php?c=findpwd" class="gray">忘记密码？</a></div>
                    <div class="clear"></div>
                </div>
                <div class="mt40 autologin">
                	<input type="checkbox" title="两周内免登录" name="autologin" id="autologin" value="1" /> &nbsp;<label for="autologin"><span class="gray">两周内免登录</span></label>
                </div>
                <div>
                <button type="submit" id="btnSubmit" class="btn btn-primary">登录</button>
                </div>
                <div class="quicklogin">
                        <div class="fl">使用快捷方式登录：<a href="/data/api/oauth/connect.php?method=qq_token"><img src="images/btnl02.jpg"></a></div>
                </div>
                </form>
            </div>
        </div>
	</div>
</div>
<!--底部-->
<footer class="ifooter">
	<?php require_once(dirname(__FILE__).'/../../../public/bottom.php'); ?>
</footer>

</body>
</html>
