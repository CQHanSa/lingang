<?php
require_once(dirname(__FILE__).'/func/common.php');
require_once(dirname(__FILE__).'/func/secureUtil.php');
require_once(dirname(__FILE__).'/../../../Common/index.php');

/*foreach($_POST as $k =>  $v)
{
	echo $k.'['.$v.']<br/>';
}
*/
if($_POST['respMsg'] == 'success' && $_POST['orderId'] != '')
{
	$ddnum = $_POST['orderId'];
	$dd = MysqlOneSelect('lgsc_dd','ddnum,userstate',"userid='$user[userid]' and ddnum = '$ddnum' and userstate = '-1'");
	if($dd != '-1')
	{
	 	$rest = MysqlOneExc('lgsc_dd',"userstate = 1,goodsstate = 1",'update',"userid='$user[userid]' and ddnum = '$ddnum'");
		if($rest){ header('/member/person/?action=order'); }	
	}else{
		header('/member/person/?action=order');
	}
}

exit();

?>