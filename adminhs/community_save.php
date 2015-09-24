<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('member');

/*
**************************
(C)2010-2014 phpMyWind.com
update: 2014-5-30 17:16:14
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__community';
$gourl  = 'community.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加会员
if($action == 'add')
{
	if(!isset($enteruser)) $enteruser = '';

	if(preg_match("/[^0-9a-zA-Z_@!\.-]/",$username) || preg_match("/[^0-9a-zA-Z_@!\.-]/",$password))
	{
		ShowMsg('用户名或密码非法！请使用[0-9a-zA-Z_@!.-]内的字符！','-1');
		exit();
	}
	if($password != $repassword)
	{
		ShowMsg('两次输入的密码不一样！','-1');
		exit();
	}
	
	$r = $dosql->GetOne("SELECT username FROM `#@__member` WHERE username='$username'");
	if(!empty($r['username']))
	{
		ShowMsg('用户名已存在！','-1');
		exit();
	}

	$password = md5(md5($password));
	$regtime  = time();
	$regip    = GetIP();

	$dosql->ExecNoneQuery("INSERT INTO `#@__member` (username, usertype, password, cnname, telephone, address_prov, address_city, address_country, address, expval, integral, regtime, regip, logintime, loginip, checkinfo) VALUES ('$username', '$usertype', '$password', '$cname', '$phone', '$address_prov', '$address_city', '$address_country', '$address', '0', '0', '$regtime', '$regip', '$regtime', '$regip','$checkinfo')");
		
	$userid=$dosql->GetLastID();
	
	$sql="INSERT INTO `$tbname` (userid, title, cname, phone, address_prov, address_city, address_country, address, checkinfo, posttime) VALUES ('$userid', '$title', '$cname', '$phone', '$address_prov', '$address_city', '$address_country', '$address', '$checkinfo', '$regtime')";
	
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改会员信息
else if($action == 'update')
{
	
	if($password != $repassword)
	{
		ShowMsg('两次输入的密码不一样！','-1');
		exit();
	}
	
	$sql = "UPDATE `#@__member` SET ";
	if($password != '')
	{
		$password = md5(md5($password));
		$sql .= "password='$password', ";
	}
	$sql .= " checkinfo='$checkinfo' WHERE id=$userid";
	$dosql->ExecNoneQuery($sql);
	

	$sql = "UPDATE `$tbname` SET title='$title', address_prov='$address_prov', address_city='$address_city', address_country='$address_country', address='$address', cname='$cname', phone='$birthtype', phone='$phone', checkinfo='$checkinfo' WHERE id=$id";
	
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