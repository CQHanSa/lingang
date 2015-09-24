<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="商品管理";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $cfg_webname; ?> - <?php echo $web_title?></title>

<?php include_once($path.'/Public/css.php'); ?>
<link rel="stylesheet" type="text/css" href="/css/order.css"/>
<link rel="stylesheet" type="text/css" href="/css/member.css">

<?php include_once($path.'/Public/js.php'); ?>
<script type="text/javascript" src="/templates/default/js/getuploadify.js"></script>
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
            	<span class="fr"><a href="?action=goods_edit" class="btn1 mt10">添加商品</a></span>
            	<span class="page_bt"><?php echo $web_name?></span>
                <div class="divclear"></div>
            </div>
            
            <div class="door_type">
            	<form name="goods_form2" method="post" action="?action=goods">
            	<span><b>门店分类：</b></span>
                <span class="door_xz">
                    <select name="shoptype_pid" id="shoptype_pid"   onchange="SelShopType(this.value,<?php echo $r_shop['id']?>);">
					<option value="0">请选择</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__shopstype` WHERE `shopid`='".$r_shop['id']."' AND parentid=0 ORDER BY orderid ASC, id ASC");
					while($row = $dosql->GetArray())
					{
						echo '<option value="'.$row['id'].'" >'.$row['classname'].'</option>';
					}
					?>
					</select>
                    <div class="divclear"></div>
                </span>
                <span class="door_xz">
                    <select name="shoptype_id" id="shoptype_id"  >
						<option value="0">请选择</option>
					</select>
                    <div class="divclear"></div>
                </span>
            	<span><b>商品：</b></span>
                <span class="sp_sr"><input type="text" name="keyword" /></span>
                <span class="select_btn"><input type="submit" value="查询" /</span>
                <div class="divclear"></div>
                </form>
            </div>
            
            <div class="sp_lbcz">
            	<form name="form" id="form" method="post">
            	<div class="sp_btnj">
                    <ul>                        
                        <li class="sp_bg1"><a href="javascript:DelAllNone('?action=delall');" onclick="return ConfDelAll(0);">删除</a></li>
                        <li class="sp_bg2"><a href="javascript:DelAllNone('?action=shelves');">下架</a></li>
                        <li class="sp_bg3"><a href="javascript:DelAllNone('?action=flagall&a=t');">推荐</a></li>
                        <li class="sp_bg4"><a href="javascript:DelAllNone('?action=flagall&a=j');">精品</a></li>
                        <li class="sp_bg5"><a href="javascript:DelAllNone('?action=flagall&a=x');">新品</a></li>
                        <li class="sp_bg6"><a href="javascript:DelAllNone('?action=flagall&a=r');">热销</a></li>
                        <li class="sp_bg7"></li>
                    </ul>
                </div>
                <table class="sp_cz" cellpadding="0" cellspacing="0" border="0">
                	<thead>
                	<tr>
                    	<td><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
                    	<td>商品名称</td>
                    	<td>价格</td>
                    	<td>推荐</td>
                    	<td>精品</td>
                    	<td>新品</td>
                    	<td>热销</td>
                    	<td>上架</td>
                    	<td>审核</td>
                    	<td>库存</td>
                    	<td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //设置sql
					$sql = "SELECT * FROM `#@__goods` WHERE `delstate`=''";	
				
					if(!empty($shoptype_pid)) $sql .= " AND shoptype_pid='$shoptype_pid'";
				
					if(!empty($shoptype_id))     $sql .= " AND shoptype_id='$shoptype_id'";
					
					if(!empty($keyword)) $sql .= " AND title LIKE '%$keyword%'";
				
					$sql .= " order by id desc";
				
					$dopage->GetPage($sql,10);
					while($row = $dosql->GetArray())
					{
					?>
                	<tr>
                    	<td><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
                    	<td><img src="/<?php echo $row['picurl']?>" width="50" height="50"><span><?php echo ReStrLen($row['title'],16); ?></span></td>
                    	<td><?php echo $row['salesprice']?></td>
                    	<td>
                        <?php
                        $flagarr = explode(',',$row['flag']);
						//var_dump($flagarr);
						if(in_array('t',$flagarr))
						{
							echo '<a href="?action=flag&a=t&id='.$row['id'].'"><i class="sh_true"></i></a>';
						}else{
							echo '<a href="?action=flag&a=t&id='.$row['id'].'"><i class="sh_false"></i></a>';
						}
						?>
                        </td>
                    	<td>
                        <?php
                        $flagarr = explode(',',$row['flag']);
						if(in_array('j',$flagarr))
						{
							echo '<a href="?action=flag&a=j&id='.$row['id'].'"><i class="sh_true"></i></a>';
						}else{
							echo '<a href="?action=flag&a=j&id='.$row['id'].'"><i class="sh_false"></i></a>';
						}
						?>
                        </td>
                    	<td>
                        <?php
                        $flagarr = explode(',',$row['flag']);
						if(in_array('x',$flagarr))
						{
							echo '<a href="?action=flag&a=x&id='.$row['id'].'"><i class="sh_true"></i></a>';
						}else{
							echo '<a href="?action=flag&a=x&id='.$row['id'].'"><i class="sh_false"></i></a>';
						}
						?>
                        </td>
                    	<td>
                        <?php
                        $flagarr = explode(',',$row['flag']);
						if(in_array('r',$flagarr))
						{
							echo '<a href="?action=flag&a=r&id='.$row['id'].'"><i class="sh_true"></i></a>';
						}else{
							echo '<a href="?action=flag&a=r&id='.$row['id'].'"><i class="sh_false"></i></a>';
						}
						?>
                        </td>
                    	<td>
                        <?php
                        if($row['issale']=='true')
						{
							echo '<a href="?action=issale&a='.$row['issale'].'&id='.$row['id'].'"><i class="sh_true"></i></a>';
						}else{
							echo '<a href="?action=issale&a='.$row['issale'].'&id='.$row['id'].'"><i class="sh_false"></i></a>';
						}
						?>
                        </td>
                    	<td>
                        <?php
                        if($row['checkinfo']=='true')
						{
							echo '<a href="?action=checkinfo&a='.$row['checkinfo'].'&id='.$row['id'].'"><i class="sh_true"></i></a>';
						}else{
							echo '<a href="?action=checkinfo&a='.$row['checkinfo'].'&id='.$row['id'].'"><i class="sh_false"></i></a>';
						}
						?>
                        </td>
                    	<td><?php echo $row['housenum']?></td>
                    	<td>
                        	<a href="/goods.php?id=<?php echo $row['id']?>" target="_blank">查看</a>|<a href="?action=goods_edit&id=<?php echo $row['id']?>">修改</a>|<a href="?action=goods_del&id=<?php echo $row['id']?>" onClick="return confirm('确定要删除选中的信息吗？')">删除</a>
                        </td>
                    </tr>
                    <?php
					}
					?>
                    </tbody>
                </table>
                <div class="sp_btnj1"><ul>
                	<li class="sp_bg1"><a href="javascript:DelAllNone('?action=delall');" onclick="return ConfDelAll(0);">删除</a></li>
                	<li class="sp_bg2"><a href="javascript:DelAllNone('?action=shelves');">下架</a></li>
                	<li class="sp_bg3"><a href="javascript:DelAllNone('?action=flagall&a=t');">推荐</a></li>
                	<li class="sp_bg4"><a href="javascript:DelAllNone('?action=flagall&a=j');">精品</a></li>
                	<li class="sp_bg5"><a href="javascript:DelAllNone('?action=flagall&a=x');">新品</a></li>
                	<li class="sp_bg6"><a href="javascript:DelAllNone('?action=flagall&a=r');">热销</a></li>
                </ul>
                </div>
                </form>
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
