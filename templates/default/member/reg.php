<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_title="会员注册";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg_webname; ?> - <?php echo $web_title?></title>
<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/css/register.css"/>
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script> 
<script type="text/javascript" src="/templates/default/js/member.js"></script>
<script type="text/javascript" src="/js/click.js"></script>
</head>

<body>
<?php require_once(dirname(__FILE__).'/../../../public/top.php'); ?>

<!--头部-->

<div class="bgf7">
	<div class="warpper">
        <div class="itop_logo top_logo"><a href="/"><img src="images/logo.png"></a><span class="itop_name1"><?php echo $web_title?></span></div>
    </div>
	<div class="warpper registerbox">
        <h1 class="lg_title">
        	<ul>
            	<li <?php if($t!='1'){echo ' class="cur"';}?>><a href="/member.php?c=reg">会员注册</a></li>
                <li <?php if($t=='1'){echo ' class="cur"';}?>><a href="/member.php?c=reg&t=1">商家注册</a></li>
            </ul>
            <span>我已经是临港大市场会员？<a href="/member.php?c=login" class="blue_link">直接登录</a></span>
        </h1>
        <div class="registerform">
        	<div class="reg_form reg_form_step1">
            	<form id="form" method="post" class="registerform2" action="/member.php?a=reg" >
                <input type="hidden" value="<?php echo $t;?>" name="t" />
                <div class="reg_row ie_myemail">
                    <label>用户名：</label>
                    <input type="text" name="username" id="username" class="form-control u_name" ajaxurl="/ajax.php" datatype="uname" nullmsg="请输入用户名！" errormsg="用户名只能以字母开头，包含数字或下划线，长度6~16位！" />
                </div>
                <div class="reg_row">
                    <label>请设置密码：</label>
                    <input type="password" name="password" id="password" class="form-control u_ps" datatype="*6-16" nullmsg="请设置密码！" errormsg="请输入6~16位任意字符！" />
                </div>
                <div class="reg_row">
                    <label>请确认密码：</label>
                    <input type="password" name="repassword" class="form-control u_ps " datatype="*" recheck="password" nullmsg="请再输入一次密码！" errormsg="两次输入的密码不一致！" />
                </div>
                <div class="reg_row">
                    <label id="userlabel">验证手机：</label>
                    <input type="text" id="mobile" name="mobile" class="form-control u_tel" datatype="m" nullmsg="请输入手机号码！" errormsg="手机号码不正确！"  ajaxurl="/ajax.php" />
                    <input type="hidden" id="email" name="email" class="form-control" datatype="e" nullmsg="请输入邮箱！" errormsg="邮箱格式不正确！"  ajaxurl="/ajax.php"  />
                    <span class="checkemail">或<a href="javascript:;" class="blue_link " id="blue_link">验证邮箱</a></span>
                    
                </div>
                <div class="reg_row">
                	<label id="userl_dx">短信验证：</label>
                    <input id="userTelcode" name="validate"  class="form-control u_telcode " type="text" datatype="*" nullmsg="请输入验证码！" />
                    <input type="button" id="gettelcode" class="gettelcode" value="获取短信验证码" onclick="sendMessage()" />
                </div>
                <div class="">
                	<label class="checkbox">
                	<input type="checkbox" checked="checked" disabled="disabled"><span class="gray">我已阅读并同意<a class="blue_link" href="/agreement.php" target="_blank">《临港大市场注册协议》</a>及隐私</span></label>
                </div>
                
                <div class="mt20">
                	<button type="submit" id="btnSubmit" class="btn btn-primary btn_reg">立即注册</button>
                </div>
                </form>
            </div>
        </div>
	</div>

	
    <!--底部-->
    <footer class="ifooter">
    <?php require_once(dirname(__FILE__).'/../../../public/bottom.php'); ?>
    </footer>
</div>

<script type="text/javascript" src="/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">
$(function(){
	
	$(".registerform2").Validform({
		tiptype:3,
		label:".label",
		showAllError:true,
		ignoreHidden:true,
		datatype:{//传入自定义datatype类型【方式二】;
			"uname": /^[a-zA-Z][a-zA-Z0-9_]{5,15}$/,
		}
	});  //就这一行代码！
})


var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数

function sendMessage() {
	var ckmobile = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/;
	if($("#mobile").val()==""){
		alert("请输入手机号码");
		return false;
	}else if(!ckmobile.test($("#mobile").val())){
		alert("请输入正确的手机号码");
		return false;
	}
  　	curCount = count;
　　//设置button效果，开始计时
     $("#gettelcode").attr("disabled", "true");
     $("#gettelcode").val(curCount + "秒后重新发送");
     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
	 
	//向后台发送处理数据
    $.ajax({
		url : "/ajax.php?a=sendnum&mobile="+$("#mobile").val()+"&uname="+$("#username").val(),
		type:'get',
		dataType:'html',
		success:function(data){
			$("#userTelcode").val(data);
		}
	});
}

function sendMessage2() {
	var ckmobile = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	if($("#email").val()==""){
		alert("请输入邮箱号码");
		return false;
	}else if(!ckmobile.test($("#email").val())){
		alert("请输入正确的邮箱号码");
		return false;
	}
  　	curCount = count;
　　//设置button效果，开始计时
     $("#gettelcode").attr("disabled", "true");
     $("#gettelcode").val(curCount + "秒后重新发送");
     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
	 
	//向后台发送处理数据
    $.ajax({
		url : "/ajax.php?a=sendnum&email="+$("#email").val()+"&uname="+$("#username").val(),
		type:'get',
		dataType:'html',
		success:function(data){
			$("#userTelcode").val(data);
		}
	});
}

//timer处理函数
function SetRemainTime() {
            if (curCount == 0) {                
                window.clearInterval(InterValObj);//停止计时器
                $("#gettelcode").removeAttr("disabled");//启用按钮
                $("#gettelcode").val("重新发送验证码");
            }
            else {
                curCount--;
                $("#gettelcode").val(curCount + "秒后重新发送");
            }
        }
</script>
</body>
</html>
