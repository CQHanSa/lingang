<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('goodsbrand'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品品牌管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
</head>
<body>
<div class="topToolbar"> <span class="title">商品品牌管理</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>
<form id="form" name="form" method="post" action="">
	<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="dataTable">
		<tr align="left" class="head">
			<td width="5%" height="36" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheclAll(this.checked);"></td>
			<td width="3%">ID</td>
			<td width="40%">品牌名称</td>
			<td width="20%" align="center" abbr="center">排序</td>
			<td width="32%" class="endCol">操作</td>
		</tr>
	</table>
	<?php
	
	$dosql->Execute("SELECT * FROM `#@__goodstype` WHERE parentid=0 and checkinfo='true' ORDER BY orderid asc ,id ASC");
	while($r_pid = $dosql->GetArray()){
	?>
	<div rel="rowpid_0">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
			<tr align="left" class="dataTrOn">
				<td width="5%" height="36" class="firstCol"></td>
				<td width="3%"><?php echo $r_pid['id']?></td>
				<td width="40%"><span class="minusSign" id="rowid_<?php echo $r_pid['id']?>" onclick="DisplayRows(<?php echo $r_pid['id']?>);"><?php echo $r_pid['classname']?></span></td>
				<td width="20%" align="center"></td>
				<td width="32%" class="action endCol"></td>
			</tr>
		</table>
	</div>
    <?php
	$dosql->Execute("SELECT * FROM `#@__goodsbrand` where parentid='$r_pid[id]'  ORDER BY orderid asc ,id ASC",$r_pid['id']);
	while($row = $dosql->GetArray($r_pid['id']))
	{
			$classname= $row['classname'];

			switch($row['checkinfo'])
			{
				case 'true':
					$checkinfo = '显示';
					break;  
				case 'false':
					$checkinfo = '隐藏';
					break;
				default:
					$checkinfo = '没有获取到参数';
			}
	?>
	<div rel="rowpid_<?php echo $r_pid['id']?>">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
			<tr align="left" class="dataTr">
				<td width="5%" height="36" class="firstCol"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id'] ?>" /></td>
				<td width="3%"><?php echo $row['id']; ?>
					<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" /></td>
				<td width="40%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="subType"><?php echo $classname; ?></span></td>
				<td width="20%" align="center"><a href="goodsbrand_save.php?action=up&id=<?php echo $row['id']; ?>&parentid=<?php echo $row['parentid']; ?>&orderid=<?php echo $row['orderid']; ?>" class="leftArrow" title="提升排序"></a>
					<input type="text" name="orderid[]" id="orderid[]" class="inputls" value="<?php echo $row['orderid']; ?>" />
					<a href="goodsbrand_save.php?action=down&id=<?php echo $row['id']; ?>&parentid=<?php echo $row['parentid']; ?>&orderid=<?php echo $row['orderid']; ?>" class="rightArrow" title="下降排序"></a></td>
				<td width="32%" class="action endCol"><span><a href="goodsbrand_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行显示与隐藏操作"><?php echo $checkinfo; ?></a></span> | <span><a href="goodsbrand_update.php?id=<?php echo $row['id']; ?>">修改</a></span> | <span class="nb"><a href="goodsbrand_save.php?action=del&id=<?php echo $row['id'] ?>" onclick="return ConfDel(2);">删除</a></span></td>
			</tr>
		</table>
	</div>	
	<?php
	}
	}
	

	
	
	//判断类别页是否折叠
	if($cfg_typefold == 'Y')
	{
		echo '<script>HideAllRows();</script>';
	}
	?>
</form>
<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAll('goodsbrand_save.php');" onclick="return ConfDelAll(2);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('goodsbrand_save.php');">排序</a> - <a href="javascript:ShowAllRows();">展开</a> - <a href="javascript:HideAllRows();">隐藏</a></span> <a href="goodsbrand_add.php" class="dataBtn">添加商品品牌</a></div>
<div class="page">
	<div class="pageText">共有<span><?php echo $dosql->GetTableRow('#@__goodsbrand'); ?></span>条记录</div>
</div>
<?php

//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAll('goodsbrand_save.php');" onclick="return ConfDelAll(2);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('goodsbrand_save.php');">排序</a> - <a href="javascript:ShowAllRows();">展开</a> - <a href="javascript:HideAllRows();">隐藏</a></span> <a href="goodsbrand_add.php" class="dataBtn">添加商品品牌</a> <span class="pageSmall">
			<div class="pageText">共有<span><?php echo $dosql->GetTableRow('#@__goodsbrand'); ?></span>条记录</div>
			</span></div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>
</body>
</html>