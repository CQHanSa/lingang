<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('coupon');

/*
**************************
(C)2010-2014 phpMyWind.com
update: 2014-5-30 16:27:34
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__coupon';
$gourl  = 'coupon.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加
if($action == 'add')
{
	$price  = isset($price)  ? intval($price) : 0;
	$overprice  = isset($overprice)  ? intval($overprice) : 0;
	$num  = isset($num)  ? intval($num) : 0;
	
	if($price == 0){
		ShowMsg('优惠金额不能小于0！','-1');
		exit();		
	}
	
	if($overprice == 0){
		ShowMsg('使用条件金额不能小于0！','-1');
		exit();		
	}
	
	if($starttime != ''){
		$starttime = strtotime($starttime);
	}
	
	if($endtime != ''){
		$endtime = strtotime($endtime.' 23:59:59');
	}
	
	if($endtime < $starttime){
		ShowMsg('领取结束时间必须大于领取开始时间！','-1');
		exit();	
	}
	
	if($validity_strat != ''){
		$validity_strat = strtotime($validity_strat);
	}
	
	if($validity_end != ''){
		$validity_end = strtotime($validity_end.' 23:59:59');
	}
	
	if($validity_end < $validity_strat){
		ShowMsg('使用结束时间必须大于使用开始时间！','-1');
		exit();	
	}
	
	$sql = "INSERT INTO `$tbname` (classid, title, picurl, price, overprice, num, hasnum, starttime, endtime, validity_strat, validity_end, orderid, checkinfo) VALUES ('$classid', '$title', '$picurl', '$price', '$overprice', '$num', '$hasnum', '$starttime', '$endtime', '$validity_strat', '$validity_end', '$orderid', '$checkinfo')";
	if($dosql->ExecNoneQuery($sql))
	{
    	header("location:$gourl");
		exit();
	}
}


//修改
else if($action == 'update')
{
	$price  = isset($price)  ? intval($price) : 0;
	$overprice  = isset($overprice)  ? intval($overprice) : 0;
	$num  = isset($num)  ? intval($num) : 0;
	
	if($price == 0){
		ShowMsg('优惠金额不能小于0！','-1');
		exit();		
	}
	
	if($overprice == 0){
		ShowMsg('使用条件金额不能小于0！','-1');
		exit();		
	}
	
	if($starttime != ''){
		$starttime = strtotime($starttime);
	}
	
	if($endtime != ''){
		$endtime = strtotime($endtime.' 23:59:59');
	}
	
	if($endtime < $starttime){
		ShowMsg('领取结束时间必须大于领取开始时间！','-1');
		exit();	
	}
	
	if($validity_strat != ''){
		$validity_strat = strtotime($validity_strat);
	}
	
	if($validity_end != ''){
		$validity_end = strtotime($validity_end.' 23:59:59');
	}
	
	if($validity_end < $validity_strat){
		ShowMsg('使用结束时间必须大于使用开始时间！','-1');
		exit();	
	}
	
	
	$sql = "UPDATE `$tbname` SET classid='$classid', title='$title', picurl='$picurl', price='$price', overprice='$overprice', num='$num',  hasnum='$hasnum',starttime='$starttime', endtime='$endtime', validity_strat='$validity_strat', validity_end='$validity_end', orderid='$orderid', checkinfo='$checkinfo' WHERE id=$id";
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