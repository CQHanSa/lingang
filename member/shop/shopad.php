<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="店铺广告";


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
            	<span class="fr"><a href="?action=shopad_edit" class="btn1 mt10">添加店铺广告</a></span>
            	<span class="page_bt"><?php echo $web_name?></span>
                <div class="divclear"></div>
            </div>
            <div style="padding:10px 20px;">
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
                    <tr align="left" class="head">
                        <td width="10%" height="30" class="firstCol">ID</td>
                        <td width="30%">广告标识</td>
                        <td width="30%">广告分类</td>
                        <td width="10%">&nbsp;显示</td>
                        <td width="20%" class="endCol">操作</td>
                    </tr>
                    <?php
            
                    //设置SQL
                    $sql = "SELECT * FROM `#@__shopad` order by orderid desc ,id desc";
            
                    $dopage->GetPage($sql,20);
                    while($row = $dosql->GetArray())
                    {
            
                        //分类名称
                        switch($row['classid'])
                        {
                            case '1':
                                $classname = '店招';
                                break;  
                            case '2':
                                $classname = '店铺banner';
                                break;
                            case '3':
                                $classname = '店铺中间广告位';
                                break;  
                            case '4':
                                $classname = '店铺左侧广告';
                                break;
                            default:
                                $classname = '--';
                        }
                        
            
                    ?>
                    <tr align="left" class="dataTr">
                        <td height="40" class="firstCol"><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $classname; ?></td>
                        <td>
                        <?php
                        if($row['checkinfo']=='true')
						{
							echo '<a href="?action=shopad_check&a='.$row['checkinfo'].'&id='.$row['id'].'"><i class="sh_true" style="margin:0px;"></i></a>';
						}else{
							echo '<a href="?action=shopad_check&a='.$row['checkinfo'].'&id='.$row['id'].'"><i class="sh_false" style="margin:0px;"></i></a>';
						}
						?>
                        </td>
                        <td class="action endCol"><span><a href="?action=shopad_edit&id=<?php echo $row['id']; ?>">修改</a></span> | <span class="nb"><a href="?action=shopad_del&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0)">删除</a></span></td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                <?php echo $dopage->GetList(); ?>
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
