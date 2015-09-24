<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="商品分类";


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
        	当前位置：<a href="/">首页</a>&gt;<a href="/member.php"><?php echo $web_title?></a>&gt;<?php echo $web_name?>
        </div>
        
        <?php include_once("./leftinfo.php") ?>
        
        <div class="order_cont1 t_right">
        	<div class="sr_ordernum1">
            	<span class="fr"><a href="?action=goodstype_edit" class="btn1 mt10">添加商品分类</a></span>
            	<span class="page_bt"><?php echo $web_name?></span>
                <div class="divclear"></div>
            </div>
            <div>
                <dl class="add_typedl">
                	<dt>
                    	<ul class="add_typebt">
                        	<li>类别名称</li>
                            <li>排序号</li>
                            <li>是否显示</li>
                            <li>操作&nbsp;</li>
                        </ul>
                        <div class="divclear"></div>
                    </dt>
                    <dt>
                    	<ul>
							<?php
                            $dosql->Execute("SELECT * FROM `#@__shopstype` WHERE `shopid`='".$r_shop['id']."' AND parentid=0 ORDER BY orderid ASC, id ASC");
                            while($row = $dosql->GetArray())
                            {
								if($row['checkinfo']=='true'){
									$checkimg='<img src="/images/sj_bg8.png" />';	
								}else{
									$checkimg='<img src="/images/sj_bg9.png" />';		
								}
                            ?>	
                        	<li>
                                <ul class="add_typecy">
                                    <li><div class="on"><?php echo $row['classname']?></div></li>
                                    <li><?php echo $row['orderid']?></li>
                                    <li><a href="?action=goodstype_check&check=<?php echo $row['checkinfo']?>&id=<?php echo $row['id']?>"><?php echo $checkimg?></a></li>
                                    <li><a href="?action=goodstype_edit&pid=<?php echo $row['id']?>">添加子类别</a>|<a href="?action=goodstype_edit&id=<?php echo $row['id']?>">修改</a>|<a href="?action=goodstype_del&id=<?php echo $row['id']?>">删除</a></li>
                                </ul>
                                <div class="divclear"></div>
                                <ul class="addtype_ej" style="display:;">
                                	<?php
									$dosql->Execute("SELECT * FROM `#@__shopstype` WHERE `parentid`='".$row['id']."' ORDER BY orderid ASC, id ASC",$row['id']);
									while($row2 = $dosql->GetArray($row['id']))
									{
										if($row2['checkinfo']=='true'){
											$checkimg='<img src="/images/sj_bg8.png" />';	
										}else{
											$checkimg='<img src="/images/sj_bg9.png" />';		
										}
									?>	
                                	<li>
                                    	<ul class="add_typecer">
                                            <li><?php echo $row2['classname']?></li>
                                            <li><?php echo $row2['orderid']?></li>
                                            <li><a href="?action=goodstype_check&check=<?php echo $row2['checkinfo']?>&id=<?php echo $row2['id']?>"><?php echo $checkimg?></a></li>
                                            <li><a href="?action=goodstype_edit&id=<?php echo $row2['id']?>">修改</a>|<a href="?action=goodstype_del&id=<?php echo $row2['id']?>">删除</a></li>
                                        </ul>
                                        <div class="divclear"></div>
                                    </li>
                                    <?php
									}
                                    ?>
                                </ul>
                                <div class="divclear"></div>
                            </li>
                            <?php
							}
							?>
                        </ul>
                    </dt>
                </dl>
                
            </div>
        </div>
    </div>
</div>

<!-- 底部 -->
<?php include_once("../../public/footer.php") ?>
<script type="text/javascript">

$(".addtype_ej li").hover(function(){
	$(this).addClass('one');
},function(){
	$(this).removeClass('one');
});
</script>
</body>
</html>
