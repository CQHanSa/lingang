<?php
require_once(dirname(__FILE__).'/func/common.php');
require_once(dirname(__FILE__).'/func/secureUtil.php');


if(isset($_POST ['signature']) && $_POST ['respMsg']=='success' && $_POST ['reqReserved']!='' && $_POST ['txnAmt']!='') {
	
	require_once(dirname(__FILE__).'/../../../Common/index.php');
	
	$userid = AuthCode($_POST ['reqReserved']);
	$price = $_POST ['txnAmt']/100;
	
	$dosql->ExecNoneQuery("UPDATE `#@__member` SET money=money+$price WHERE id='$userid'");
	$posttime=time();
	
	$dosql->ExecNoneQuery("INSERT INTO `#@__balance` (userid, btype, money, posttime) VALUES ('$userid', '1', '$price', '$posttime')");
}

header('location:/member/person/?action=balance');
exit();

?>