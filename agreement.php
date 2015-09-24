<?php require_once(dirname(__FILE__).'/include/config.inc.php'); 
$id = isset($id) ? intval($id) : 1;
if(empty($id) or $id<=0){
	$id=1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=GetFragment($id=$id,$t=1)?> - <?php echo $cfg_webname; ?></title>
<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/css/register.css"/>
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script> 
<script type="text/javascript" src="/templates/default/js/member.js"></script>
<script type="text/javascript" src="/js/click.js"></script>
</head>

<body>
<?php require_once('/public/top.php'); ?>

<!--头部-->

<div class="bgf7">
	<div class="warpper">
        <div class="itop_logo top_logo"><a href="/"><img src="images/logo.png"></a><span class="itop_name1"><?=GetFragment($id=$id,$t=1)?></span></div>
    </div>
	<div class="warpper registerbox">
        <h1 class="lg_title"><ul><li class="cur"><a><?=GetFragment($id=$id,$t=1)?></a></li></ul>
        </h1>
        <div class="registerform">
        	<div class="reg_content">
        		<?php echo(GetFragment($id=$id,$t=0));?>  
            	<div class="divclear"></div>
            </div>      	
        </div>
	</div>


    <!--底部-->
    <?php require_once('/public/bottom.php'); ?>
    
</div>
</body>
</html>
