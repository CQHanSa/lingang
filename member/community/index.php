<?php
//定义入口常量
define('IN_MEMBER', TRUE);

$ac  = isset($ac)  ? $ac : '';
$action  = isset($action)  ? $action : '';
$id = isset($id) ? intval($id) : 0;
$pid  = isset($pid)  ? intval($pid) : 0; //项目ID
$aid  = isset($aid)  ? intval($aid) : 0; //广告分类ID



//初始登录信息
if(empty($_COOKIE['username']) || empty($_COOKIE['lastlogintime']) || empty($_COOKIE['lastloginip'])){
	$c_uname     = '';
	$c_logintime = '';
	$c_loginip   = '';
	header('location:/member.php');
	exit();
}
else
{
	require_once('../../Common/index.php');
	$c_uname     = AuthCode($_COOKIE['username']);
	$c_logintime = AuthCode($_COOKIE['lastlogintime']);
	$c_loginip   = AuthCode($_COOKIE['lastloginip']);
}
//获取用户信息
$r_user = $dosql->GetOne("SELECT * FROM `#@__member` WHERE `username`='$c_uname'");

//当记录出现错误，强制跳转
if(!isset($r_user) or !is_array($r_user)){
	header('location:/');
	exit();
}

//判断是否为当前级别会员
if($r_user['usertype'] !=2 ){
	header('location:/member.php');
	exit();
}

echo $c_uname;
echo '<a href="/member.php?a=logout">退出登陆</a>';
?>