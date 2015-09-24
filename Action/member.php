<?php
require_once(dirname(dirname(__FILE__)).'/Common/index.php');
$type  = isset($_GET['type']) ? get('type') : post('type');
//获取城市2级地址
if($type == 'city')
{
	$city = get('city');
	$maxcity = $city + 499;
	echo row_cas($value='-1'," (datavalue > $city and datavalue < $maxcity) and level=1 ");
}
//获取城市3级地址
if($type == 'county')
{
	$county = get('county');
	$maxcounty = $county + 1;
	echo row_cas($value='-1'," (datavalue > $county and datavalue < $maxcounty) and level=2 ");
}
//添加店铺收藏
if($type == 'addShopCollcetion')
{
	if(!is_user('islogin')){ echo '请先登录';exit();}
	$post['userid'] = AuthCode($_COOKIE['userid'],'DECODE');
	$post['shopid'] = post('shopid');
	$post['createTime'] = time();
	//判断是否已添加
	$r = MysqlOneSelect('lgsc_shopcollection',"shopid","shopid = $post[shopid]");
	if($r != '-1'){ echo '该店铺已收藏';exit();}
	$rest = MysqlOneExc('lgsc_shopcollection',$post);
	if($rest){ echo '加入收藏成功'; }
}
//删除店铺收藏
if($type == 'delShopCollection')
{
	if(!is_user('islogin')){ echo '请先登录';exit();}
	$post['shopid'] = post('shopid');
	//判断是否已添加
	$rest = MysqlDel('lgsc_shopcollection',"shopid = $post[shopid]");
	if($rest){ echo '已取消关注'; }
}
//添加商品收藏
if($type == 'addGoodsCollection')
{
	if(!is_user('islogin')){ echo '请先登录';exit();}
	$post['userid'] = AuthCode($_COOKIE['userid'],'DECODE');
	$post['goodsid'] = post('id');
	$post['createTime'] = time();
	//判断是否已添加
	$r = MysqlOneSelect('lgsc_goodscollection',"shopid","goodsid = '$post[goodsid]'");
	if($r != '-1'){ echo '该商品已收藏';exit();}
	$rest = MysqlOneExc('lgsc_goodscollection',$post);
	if($rest){ echo '加入收藏成功'; }
}
//删除商品收藏
if($type == 'delGoodsCollection')
{
	if(!is_user('islogin')){ echo '请先登录';exit();}
	$post['goodsid'] = post('id');
	//判断是否已添加
	$rest = MysqlDel('lgsc_goodscollection',"goodsid = '$post[goodsid]'");
	if($rest){ echo '已取消关注'; }
}

//添加发送信息
if($type == 'addSocket')
{
	$post['userid'] = AuthCode($_COOKIE['userid'],'DECODE');
	$post['username'] = AuthCode($_COOKIE['username'],'DECODE');
	$post['toshopid'] = post('toshopid');
	$post['touserid'] = post('touserid');
	$post['togoodsid'] = post('togoodsid');
	$post['message'] = $_POST['message'];
	$post['createTime'] = time();
	$rest = MysqlOneExc('lgsc_socket',$post);
	if($rest){ echo '发送成功'; }
}
?>