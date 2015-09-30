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
            <dl class="normal doing">
                <dt class="s-num">2</dt>
                <dd class="s-text">验证身份<s></s><b></b></dd>
            </dl>
            <dl class="normal">
                <dt class="s-num">3</dt>
                <dd class="s-text">设置新密码<s></s><b></b></dd>
            </dl>
            <dl class="last">
                <dt class="s-num">&nbsp;</dt>
                <dd class="s-text">完成<s></s><b></b></dd>
            </dl>
        </div>
        
        <div class="findpwd_form">
			<form id="form" method="post" class="findpwd" action="?c=findpwd3" >
                <input type="hidden" name="a" value="quesfind" />
                <div class="reg_row">
                    <label>用户名：</label>
                    <span style="font-size:14px; font-weight:bold;"><?php echo $find_username;?></span>
                    <input type="hidden" name="uname" value="<?php echo $find_username; ?>">
                </div>
                <?php
                $r = $dosql->GetOne("SELECT id,mobile,email FROM `#@__member` WHERE `username`='$find_username'");
				if($r['mobile'] !='' || $r['email'] !=''){
				?>
                <div class="reg_row">
                    <label>验证方式：</label>
                    <select name="yzfs" id="yzfs" class="class_input" style="width:167px;">
                    	<?php if($r['mobile'] !=''){echo '<option value="mobile">手机验证</option>';}?>
                        <?php if($r['email'] !=''){echo '<option value="email">邮箱验证</option>';}?>
                    </select>
                </div>
                
                <div class="reg_row">
                    <label>验证码：</label>
                    <input type="text" name="validate" id="validate" class="class_input" datatype="*" nullmsg="请输入验证码！"  style="width:155px" />
					<?php 
					if($r['mobile'] !=''){
						echo '<input type="button" id="gettelcode" class="gettelcode" value="获取短信验证码" onclick="sendMessage()" />';
					}else{
						echo '<input type="button" id="gettelcode" class="gettelcode" value="获取邮箱验证码" onclick="sendMessage2()" />';
					}
					?>
                    <span class="Validform_checktip"></span>
                </div>
                <input type="submit" class="btn1" style="margin-left:100px;" value="下一步" />
                <?php
                }else{
					echo '您的帐号暂无任何验证方式，请联系管理员找回密码。';
				}
				?>
            </form>
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
	
	$("#yzfs").change(function(){
		if($(this).val()=="email"){
			$("#gettelcode").attr('onclick','sendMessage2()');
			$("#gettelcode").val("获取邮箱验证码");	
		}else{
			$("#gettelcode").attr('onclick','sendMessage()');
			$("#gettelcode").val("获取手机验证码");	
		}	
	})
	
})

var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数

function sendMessage() {
	
  　	curCount = count;
　　//设置button效果，开始计时
     $("#gettelcode").attr("disabled", "true");
     $("#gettelcode").val(curCount + "秒后重新发送");
     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
	 
	//向后台发送处理数据
    $.ajax({
		url : "/ajax.php?a=sendnum2&mobile=<?php echo $r['mobile']?>&uname=<?php echo $find_username?>",
		type:'get',
		dataType:'html',
		success:function(data){
			$("#userTelcode").val(data);
		}
	});
}

function sendMessage2() {
	
  　	curCount = count;
　　//设置button效果，开始计时
     $("#gettelcode").attr("disabled", "true");
     $("#gettelcode").val(curCount + "秒后重新发送");
     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
	 
	//向后台发送处理数据
    $.ajax({
		url : "/ajax.php?a=sendnum2&email=<?php echo $r['email']?>&uname=<?php echo $find_username?>",
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
