<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="购物须知";	


$r = $dosql->GetOne("SELECT `content` FROM `#@__shopsnote` WHERE `shopid`='".$r_shop['id']."' and classid='0'");
if(isset($r['content'])){
	$content=$r["content"];
}else{
	$content="";
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
<script type="text/javascript" src="/include/editor/kindeditor-min.js"></script>
<script type="text/javascript" src="/include/editor/lang/zh_CN.js"></script>
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
            
            <div class="order_set2">
            	<form name="upmember"  class="upmember" id="form" method="post">
                <input type="hidden" name="action" value="shops_note_save" />
				<div style="margin-left:-1px;">
                <textarea name="content" id="content" class="kindeditor"><?php echo $content; ?></textarea>
				<script>
                	var editor;
                	KindEditor.ready(function(K) {
                    	editor = K.create('textarea[name="content"]', {
                        	allowFileManager : true,
                            width:'983px',
                            height:'300px',
                            extraFileUploadParams : {
                                sessionid :  '<?php echo session_id(); ?>'
                            }
                        });
                	});
                </script>
                </div>
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
