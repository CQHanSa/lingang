<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('goodsaddress');

/*
**************************
(C)2010-2014 phpMyWind.com
update: 2014-5-30 16:27:34
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__goodsaddress';
$gourl  = 'goodsaddress.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加商品品牌类别
if($action == 'add')
{
	$parentstr = $doaction->GetParentStr();
	
	$sql = "INSERT INTO `$tbname` (parentid, parentstr, classname, picurl, linkurl, orderid, checkinfo) VALUES ('$parentid', '$parentstr', '$classname', '$picurl', '$linkurl', '$orderid', '$checkinfo')";
	if($dosql->ExecNoneQuery($sql))
	{
    	header("location:$gourl");
		exit();
	}
}


//修改商品品牌类型
else if($action == 'update')
{
	$parentstr = $doaction->GetParentStr();
	
	$sql = "UPDATE `$tbname` SET parentid='$parentid', parentstr='$parentstr', classname='$classname', picurl='$picurl', linkurl='$linkurl', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{
    	header("location:$gourl");
		exit();
	}
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>