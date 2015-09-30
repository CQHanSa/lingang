<!-- 顶部通栏广告-->
<?php
$row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='12' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
$gourl = 'javascript:;';
if(is_array($row)){
	if($row['linkurl'] != ''){
		$gourl = $row['linkurl'];
    }
echo '<div class="itop_title" style="background:url(/'.$row['picurl'].') no-repeat center top"><a href="'.$gourl.'"></a></div>';
}
?>

<!-- 顶部会员信息 -->
<?php require_once(dirname(__FILE__).'/top.php'); ?>

<!-- logo+搜索+购物车 -->
<?php require_once(dirname(__FILE__).'/logosearch.php'); ?>

<!-- 菜单栏 -->
<?php require_once(dirname(__FILE__).'/menu.php'); ?>