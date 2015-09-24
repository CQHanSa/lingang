<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="安全中心";
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
        	当前位置：<a href="/">首页</a>&gt;<a href="/member/person"><?php echo $web_title?></a>&gt;<?php echo $web_name?>
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
                <input type="hidden" name="action" value="editpswd_saveedit" />
				<dl>
                	<dt>
                    	<label class="label">原密码：</label>
                    	<input type="password" class="class_input"  name="oldpassword" id="oldpassword" datatype="*" nullmsg="请输入原密码！"/>
                        <span class="Validform_checktip">请输入原密码</span>
                    </dt>
                    <dt>
                    	<label class="label">新密码：</label>
                    	<input type="password" name="password" class="class_input" datatype="oldpassword,*6-18" nullmsg="请输入新密码！" errormsg="密码范围在6~15位之间！"  />
                        <span class="Validform_checktip">新密码为空则不修改密码</span>
                    </dt>
                    <dt>
                    	<label class="label">确　认：</label>
                    	<input type="password" name="repassword" class="class_input" datatype="*" recheck="password" nullmsg="请再次输入密码！" errormsg="您两次输入的账号密码不一致！"   />
                        <span class="Validform_checktip"></span>
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
			"oldpassword":function(gets){
				if(gets==$("#oldpassword").val()){
					return "新密码不能与旧密码一致！";	
				}
			}
		}
	});  //就这一行代码！
})
</script>
</body>
</html>
