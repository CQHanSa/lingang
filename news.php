<?php require_once(dirname(__FILE__).'/Common/index.php'); 

//初始化参数检测正确性
$cid = isset($cid) ? intval($cid) : 25;


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
            	<div class="news_list">
                	<ul>
                    	<?php
						$dopage->GetPage("SELECT * FROM `#@__infolist` WHERE (classid=$cid OR parentstr LIKE '%,$cid,%') AND delstate='' AND checkinfo=true ORDER BY orderid DESC",20);
						while($row = $dosql->GetArray())
						{
							if(!empty($row['linkurl'])){
								$gourl=$row['linkurl'];	
							}else{
								$gourl='newsshow.php?cid='.$row['classid'].'&id='.$row['id'];	
							}
						?>
                    	<li><span><?php echo date('Y-m-d',$row['posttime'])?></span><a href="<?php echo $gourl;?>" target="_blank" title="<?php echo $row['title']?>"><?php echo ReStrLen($row['title'],20); ?></a></li>
                        <?php
						}
						?>
                    </ul>
                </div>  
                <div class="divclear"></div>
                <?php echo $dopage->GetList(); ?>
                <div class="divclear"></div>
            </div>
            
            <div class="divclear"></div>
        </div>
		<div class="divclear"></div>
    </div>
</div>

<!-- 底部 -->
<?php include_once("./public/footer.php") ?>
</body>
</html>
