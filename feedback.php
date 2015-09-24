<?php require_once(dirname(__FILE__).'/Common/index.php'); 

//留言内容处理
if(isset($action) and $action=='add')
{
	if(empty($nickname) or empty($content)  or empty($contact) or  empty($validate))
	{
		header('location:/feedback.php');
		exit();
	}
	
	
	//检测数据正确性
	if(strtolower($validate) != strtolower(GetCkVdValue()))
	{
		ResetVdValue();
		ShowMsg('验证码不正确！','/feedback.php');
		exit();
	}
	else
	{
		$r = $dosql->GetOne("SELECT Max(orderid) AS orderid FROM `#@__message`");
		$orderid  = (empty($r['orderid']) ? 1 : ($r['orderid'] + 1));
		$nickname = htmlspecialchars($nickname);
		$contact  = htmlspecialchars($contact);
		$content  = htmlspecialchars($content);
		$posttime = GetMkTime(time());
		$ip       = gethostbyname($_SERVER['REMOTE_ADDR']);
	
	
		$sql = "INSERT INTO `#@__message` (siteid, nickname, contact, content, orderid, posttime, htop, rtop, checkinfo, ip) VALUES (1, '$nickname', '$contact', '$content', '$orderid', '$posttime', '', '', 'false', '$ip')";
		if($dosql->ExecNoneQuery($sql))
		{
			ShowMsg('提交成功，感谢您的支持！','/feedback.php');
			exit();
		}
	}
}



//初始化参数检测正确性
$cid = isset($cid) ? intval($cid) : 26;


$web_title='';
//检测文档正确性
$row = $dosql->GetOne("SELECT id,classname FROM `#@__infoclass` WHERE id='$cid' AND checkinfo='true'");
if(is_array($row)){
	$classname=$row['classname'];	
}else{
	ShowMsg('抱歉，参数不正确！','-1');
	exit();	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $classname; ?> - <?php echo $cfg_webname; ?></title>
<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link href="/css/order.css" rel="stylesheet" type="text/css" />
<link href="/css/member.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
</head>

<body>
<!-- 顶部信息 -->
<?php require_once(dirname(__FILE__).'/public/header.php'); ?>

<div class="icontent">
	<div class="icontent_c">
    	<!-- 当前位置 -->
    	<div class="order_top">
        	当前位置：<a href="/">首页</a>&gt;<?php echo $classname?>
        </div>
        
        <div class="order_menu t_left">
        	<ul>
            	<?php 
				$dosql->Execute("SELECT id,classname FROM `#@__infoclass` WHERE id in(1,2,3,4) AND checkinfo=true ORDER BY orderid asc, id asc");
				while($row = $dosql->GetArray())
				{
				?>
            	<li>
                	<dl>
                    	<dt><a href="javascript:;"><?php echo $row['classname']?></a></dt>
                        <?php 
						$dosql->Execute("SELECT id,classname,linkurl FROM `#@__infoclass` WHERE parentid='".$row['id']."' AND checkinfo=true ORDER BY orderid asc, id asc",$row['id']);
						while($row2 = $dosql->GetArray($row['id']))
						{
							if($row2['linkurl'] != ''){
								$gourl=	$row2['linkurl'];
							}else{
								$gourl='/help.php?cid='.$row2['id'];	
							}
						?>
                    	<dd><a href="<?php echo $gourl ;?>"><?php echo $row2['classname']?></a></dd>
                        <?php
						}
						?>
                    </dl>
                </li>
                <?php
				}
				?>
            </ul>
        </div>
        
        
        <div class="order_cont1 fr">
        	<div class="sr_ordernum1">
            	<span class="page_bt"><?php echo $classname?></span>
                <div class="divclear"></div>
            </div>
            
            <div class="show_content">
            	<div class="feedback">
                尊敬的用户：<br /> 
                您好！如果您在使用本网站时，有什么好或不好的地方，请大声说出来！我们会关注您的反馈，不断优化产品，为您提供更好的服务！
                </div>
            	<div class="order_set">
                	<form name="upmember" class="upmember" id="form" method="post">
                    <input type="hidden" name="action" value="add" />
                    <dl>
                        <dt>
                            <label>联系姓名：</label>
                            <input type="text" name="nickname" id="nickname" class="class_input" datatype="*" nullmsg="请输入联系姓名！"  />
                            <span class="Validform_checktip">请输入联系姓名</span>
                        </dt>
                    </dl>
                    <dl>
                        <dt>
                            <label>手机号码：</label>
                            <input type="text" name="contact" id="contact" class="class_input" datatype="m" nullmsg="请输入手机号码！"  errormsg="手机号码不正确！"   />
                            <span class="Validform_checktip">请输入手机号码</span>
                        </dt>
                    </dl>
                    <dl>
                        <dt>
                            <label>反馈内容：</label>
                            <textarea name="content" class="class_input" style="width:600px;height:180px;overflow:auto;" id="content" datatype="*" nullmsg="请输入内容！" ></textarea>
                        </dt>
                    </dl>
                    <dl>
                        <dt>
                            <label>验证码：</label>
                            <input name="validate" type="text" id="validate" class="class_input" style="width:120px;margin-right:5px;" datatype="*" nullmsg="请输入验证码！" />
                            <span><img id="ckstr" src="/data/captcha/ckstr.php" title="看不清？点击更换" align="absmiddle" style="cursor:pointer;" onClick="this.src=this.src+'?'" /> <a href="javascript:;" onClick="var v=document.getElementById('ckstr');v.src=v.src+'?';return false;">看不清?</a></span>
                        </dt>
                    </dl>
                    <dl>
                    	<dt>
                        	<label>&nbsp;</label>
                        	<input type="submit" class="btn1" value="提交" /> <input type="reset" class="btn1" value="重置" />
                        </dt>
                    </dl>
                	</form>
                    
                	
                </div>  
                <div class="divclear"></div>
            </div>
            
            <div class="divclear"></div>
        </div>
		<div class="divclear"></div>
    </div>
</div>

<!-- 底部 -->
<?php include_once("./public/footer.php") ?>
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
