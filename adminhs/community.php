<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('community'); 

$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' ORDER BY orderid ASC, datavalue ASC");
while($row = $dosql->GetArray())
{
	$areaArr[$row['datavalue']]=$row['dataname'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>社区管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/listajax.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
</head>
<body>
<div class="topToolbar"> <span class="title">社区管理</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>
<form name="form" id="form" method="post" action="community_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="left" class="head">
			<td width="5%" height="36" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%">ID</td>
			<td width="20%">社区名称</td>
            <td width="15%">联系人</td>
            <td width="15%">联系电话</td>
            <td width="30%">所属地区</td>
			<td width="10%" class="endCol">操作</td>
		</tr>
		<?php
		$dopage->GetPage("SELECT * FROM `#@__community`");
		while($row = $dosql->GetArray())
		{
			//获取审核状态
			switch($row['checkinfo'])
			{
				case 'true':
					$checkinfo = '已审';
					break;  
				case 'false':
					$checkinfo = '未审';
					break;
				default:
					$checkinfo = '--';
			}
		?>
		<tr align="left" class="dataTr">
			<td height="36" class="firstCol"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['title']; ?></td>
            <td><?php echo $row['cname']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td>
            	<?php
                if($row['address_prov']!='-1'){
					echo $areaArr[$row['address_prov']].' ';	
				}
				if($row['address_city']!='-1'){
					echo $areaArr[$row['address_city']].' ';	
				}
				if($row['address_country']!='-1'){
					echo $areaArr[$row['address_country']].' ';	
				}
				echo $row['address'];
				?>
            </td>
			<td class="action endCol"><!--<span><a href="community_save.php?action=check&checkinfo=<?php echo $row['checkinfo']?>&id=<?php echo $row['id']; ?>"><?php echo $checkinfo?></a></span> | --><span><a href="community_update.php?id=<?php echo $row['id']; ?>">修改</a></span> | <span class="nb"><a href="community_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0)">删除</a></span></td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<?php

//判断无记录样式
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('community_save.php');" onclick="return ConfDelAll(0);">删除</a></span> <a href="community_add.php" class="dataBtn">添加社区</a> </div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php

//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('community_save.php');" onclick="return ConfDelAll(0);">删除</a></span> <a href="community_add.php" class="dataBtn">添加社区</a> <span class="pageSmall"> <?php echo $dopage->GetList(); ?> </span></div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>
</body>
</html>