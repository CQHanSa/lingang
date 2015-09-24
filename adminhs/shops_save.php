<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('member');

/*
**************************
(C)2010-2014 phpMyWind.com
update: 2014-5-30 17:16:14
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__shops';
$gourl  = 'shops.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加会员
if($action == 'add')
{
	header("location:$gourl");
	exit();
}


//修改会员信息
else if($action == 'update')
{
	
	$sql = "UPDATE `#@__shops` SET shopname='$shopname', shop_username='$shop_username', shopcompany='$shopcompany', shop_tel='$shop_tel', shop_prov='$shop_prov', shop_city='$shop_city', shop_town='$shop_town' , shop_address='$shop_address', checkinfo='$checkinfo' WHERE id=$id";

	if($dosql->ExecNoneQuery($sql))
	{
		$dosql->ExecNoneQuery("UPDATE `#@__member` SET `checkinfo`='$shopcheck' WHERE `id`=$userid");
		header("location:$gourl");
		exit();
	}
}

//店铺审核
else if($action == 'shopscheck'){
	if($checkinfo == 'true')
	{
		$dosql->ExecNoneQuery("UPDATE `#@__member` SET `checkinfo`='false' WHERE `id`=$id");
		header("location:$gourl");
		exit();
	}

	if($checkinfo == 'false')
	{
		$dosql->ExecNoneQuery("UPDATE `#@__member` SET `checkinfo`='true' WHERE `id`=$id");
		header("location:$gourl");
		exit();
	}
}

//店铺删除
else if($action == 'delshops'){
		
	if(empty($id) || $id<0){
		ShowMsg('参数错误！','-1');
		exit();
	}
	
	$r = $dosql->GetOne("SELECT id,userid FROM `#@__shops` where id='$id'");
	if(!isset($r['id'])){
		ShowMsg('参数错误！','-1');
		exit();
	}else{
		$dosql->ExecNoneQuery("DELETE FROM `#@__member` WHERE id='".$r['userid']."'");
		$dosql->ExecNoneQuery("DELETE FROM `#@__shops` WHERE id='$id'");
	}
	
	header("location:$gourl");
	exit();
}




//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>