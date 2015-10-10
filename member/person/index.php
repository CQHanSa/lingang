<?php
//定义入口常量
define('IN_MEMBER', TRUE);

$web_title="会员中心";

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
	header('location:/member/person');
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


//个人资料
if($action=="editinfo"){
	require_once('editinfo.php');
}

//个人资料修改保存
elseif($action=="editinfo_saveedit"){
	
	$cnname    = htmlspecialchars($cnname);
	$avatar    = htmlspecialchars($avatar);
	$email     = htmlspecialchars($email);
	$mobile    = htmlspecialchars($mobile);
	$address   = htmlspecialchars($address);
	$address_country = isset($address_country) ? htmlspecialchars($address_country) : '-1';
	
	if($birthday!=''){
		$birthday = strtotime($birthday);
	}
	
	
 	
	if($mobile !=''){
		$r = $dosql->GetOne("SELECT `id` FROM `#@__member` WHERE `mobile`='$mobile' and `username`!='$c_uname'");
		if(isset($r['id']))
		{
			ShowMsg('您填写的手机已被注册！','-1');
			exit();
		}
	}
	if($email !=''){
		$r = $dosql->GetOne("SELECT `id` FROM `#@__member` WHERE `email`='$email' and `username`!='$c_uname'");
		if(isset($r['id']))
		{
			ShowMsg('您填写的邮箱已被注册！','-1');
			exit();
		}
	}
	
	$sql = "UPDATE `#@__member` SET cnname='$cnname', sex='$sex', birthday='$birthday', mobile='$mobile', email='$email', address_prov='$address_prov', address_city='$address_city',address_country='$address_country', address='$address', avatar='$avatar' WHERE id=$id";

	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('资料修改成功！','?action=editinfo');
		exit();
	}
}
//密码修改
elseif($action=="editpswd"){
	require_once('editpswd.php');
}
//密码修改保存
elseif($action=="editpswd_saveedit"){
	//检测旧密码是否正确
	if($password != '' && $oldpassword !='')
	{
		$oldpassword = md5(md5($oldpassword));
		$r = $dosql->GetOne("SELECT `password` FROM `#@__member` WHERE id=$id");
		if($r['password'] != $oldpassword)
		{
			ShowMsg('抱歉，原密码错误！','-1');
			exit();
		}
		
		$password_strength=CheckPassword($password);
		
		$password = md5(md5($password));
		$sql = "UPDATE `#@__member` SET password='$password' ,password_strength='$password_strength' WHERE id='$id'";
		if($dosql->ExecNoneQuery($sql))
		{
			ShowMsg('资料更新成功！','?action=editpswd');
			exit();
		}
	}
}

//收货地址
elseif($action=="shipping_address"){
	require_once('shipping_address.php');
}
//收货地址添加
elseif($action=="shipping_address_add"){
	
	//初始化参数	
	$posttime  = time();
	
	$isdefault   = isset($isdefault)   ? $isdefault : '0';
	
	if($isdefault=='1'){
		$isdefault='true';	
		$dosql->ExecNoneQuery("UPDATE `#@__user_address` SET isdefault='false' WHERE userid='".$r_user['id']."'");
	}else{
		$isdefault='false';
	}
	
	$sql = "INSERT INTO `#@__user_address` (userid, username, usermobile, userphone, address_prov, address_city, address_country, address, postcode, isdefault, communityid, posttime,title) VALUES ('$r_user[id]', '$username', '$usermobile', '$userphone', '$address_prov', '$address_city', '$address_country', '$address', '$postcode', '$isdefault', '$communityid', '$posttime','$title' )";	
	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('资料更新成功！','?action=shipping_address');
		exit();
	}
	
}
//收货地址修改
elseif($action=="shipping_address_edit"){
	
	//初始化参数	
	$posttime  = time();
	
	$isdefault   = isset($isdefault)   ? $isdefault : '0';
	
	if($isdefault=='1'){
		$isdefault='true';	
		$dosql->ExecNoneQuery("UPDATE `#@__user_address` SET isdefault='false' WHERE userid='".$r_user['id']."'");
	}else{
		$isdefault='false';
	}
	
	$sql = "UPDATE `#@__user_address` SET username='$username', usermobile='$usermobile', userphone='$userphone', address_prov='$address_prov', address_city='$address_city', address_country='$address_country', address='$address', postcode='$postcode', isdefault='$isdefault', communityid='$communityid', posttime='$posttime',title='$title' where id='$id'";	
	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('资料更新成功！','?action=shipping_address');
		exit();
	}
	
}
//收货地址修改
elseif($action=="shipping_address_default"){
	
	if(empty($id) || $id<0){
		ShowMsg('参数错误！','-1');
		exit();
	}
	
	$row = $dosql->GetOne("SELECT `id` FROM `#@__user_address` WHERE userid='".$r_user['id']."' and id='$id'");
	if(!is_array($row)){
		ShowMsg('参数错误！','-1');
		exit();	
	}
	$dosql->ExecNoneQuery("UPDATE `#@__user_address` SET isdefault='false' WHERE userid='".$r_user['id']."'");
	$sql = "UPDATE `#@__user_address` SET isdefault='true' WHERE userid='".$r_user['id']."' and id='$id'";
	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('资料更新成功！','?action=shipping_address');
		exit();
	}
	
}
//收货地址删除
elseif($action=="shipping_address_del"){
	
	if(empty($id) || $id<0){
		ShowMsg('参数错误！','-1');
		exit();
	}
	
	$sql = "DELETE FROM `#@__user_address` WHERE id='$id' and userid='".$r_user['id']."'";
	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('删除成功！','?action=shipping_address');
		exit();
	}
}


//我的积分
elseif($action=='integral'){
	require_once('integral.php');
}


//优惠券管理
elseif($action=="coupon"){
	require_once('coupon.php');
}

//优惠券删除
elseif($action=="coupon_del"){
	if(empty($id) || $id<0){
		ShowMsg('参数错误！','-1');
		exit();
	}
	
	$sql = "DELETE FROM `#@__user_coupon` WHERE id='$id' and userid='".$r_user['id']."'";
	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('删除成功！','?action=coupon');
		exit();
	}
}


//优惠券管理
elseif($action=="getcoupon"){
	require_once('getcoupon.php');
}



//帐户余额
elseif($action=='balance'){
	require_once('balance.php');
}

//帐户余额充值
elseif($action=='balance_recharge'){
	require_once('balance_recharge.php');
}


//支付密码管理
elseif($action=="editpaypswd"){
	require_once('editpaypswd.php');
}
//支付密码修改保存
elseif($action=="editpaypswd_saveedit"){
	//检测旧密码是否正确
	if($password != '')
	{
		$password = md5(md5($password));
		$sql = "UPDATE `#@__member` SET paypswd='$password' WHERE id='$userid'";
		
		if($dosql->ExecNoneQuery($sql))
		{
			ShowMsg('资料更新成功！','?action=editpaypswd');
			exit();
		}
	}
}
//店铺收藏
elseif($action=="shopCollection")
{
	require_once('./shopCollection.php');	
}
//商品收藏
elseif($action=="goodsCollection")
{
	require_once('./goodsCollection.php');	
}
//商品收藏
elseif($action=="order")
{
	require_once('./order.php');	
}			
else{
	require_once('./home.php');	
}


?>