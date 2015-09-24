<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('admin'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>店铺管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
</head>
<body>
<div class="topToolbar"> <span class="title">店铺管理</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
	<tr align="left" class="head">
		<td width="5%" height="36" class="firstCol">ID</td>
		<td width="25%">店铺名称</td>
		<td width="20%">店主姓名</td>
		<td width="20%">店主电话</td>
		<td width="15%">营业状态</td>
		<td width="15%" class="endCol">操作</td>
	</tr>
	<?php

	$sql = "SELECT * FROM `#@__shops`";
	$dopage->GetPage($sql,10);
	while($row = $dosql->GetArray())
	{
		switch($row['checkinfo'])
		{
			case 'true':
				$checkinfo = '营业中';
				break;  
			case 'false':
				$checkinfo = '休息中';
				break;
			default:
				$checkinfo = '--';
		}
		
		$r = $dosql->GetOne("SELECT id,checkinfo FROM `#@__member` where id='".$row['userid']."'");
		if(isset($r['checkinfo'])){
			switch($r['checkinfo'])
			{
				case 'true':
					$checkinfo2 = '已审';
					break;  
				case 'false':
					$checkinfo2 = '未审';
					break;
				default:
					$checkinfo2 = '--';
			}	
		}
	?>
	<tr align="left" class="dataTr">
		<td height="36" class="firstCol"><?php echo $row['id']; ?></td>
		<td><?php echo $row['shopname']; ?></td>
		<td><?php echo $row['shop_username']; ?></td>
		<td><?php echo $row['shop_tel']; ?></td>
		<td><?php echo $checkinfo; ?></td>
		<td class="action endCol"><span><a href="shops_save.php?action=shopscheck&id=<?php echo $r['id']; ?>&checkinfo=<?php echo $r['checkinfo']; ?>" title="点击进行审核操作"><?php echo $checkinfo2; ?></a></span> | <span><a href="shops_update.php?id=<?php echo $row['id']; ?>">修改</a></span> | <span class="nb"><a href="shops_save.php?action=delshops&id=<?php echo $row['id']; ?>" onClick="return confirm('系统会自动删除店铺及会员信息，确定删除吗？')">删除</a></td>
	</tr>
	<?php
	}
	?>
</table>
<?php

//判断无记录样式
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar"> </div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php

//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea">  <span class="pageSmall">
			<?php echo $dopage->GetList(); ?>
			</span></div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>
</body>
</html>