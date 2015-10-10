<?php
//定义入口常量
define('IN_MEMBER', TRUE);

$web_title="商家中心";

$ac  = isset($ac)  ? $ac : '';
$action  = isset($action)  ? $action : '';
$id = isset($id) ? intval($id) : 0;
$pid  = isset($pid)  ? intval($pid) : 0; //项目ID
$aid  = isset($aid)  ? intval($aid) : 0; //广告分类ID
$a  = isset($a)  ? $a : '';
$checkid  = isset($checkid)  ? $checkid : '';


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
if($r_user['usertype']!=1){
	header('location:/member.php');
	exit();
}

//获取店铺信息
$r_shop = $dosql->GetOne("SELECT * FROM `#@__shops` WHERE `userid`='".$r_user['id']."'");
if(!is_array($r_shop)){
	ShowMsg('参数错误！','/');
	exit();	
}


//店铺资料
if($action=="editinfo"){
	require_once('editinfo.php');
}

//店铺资料修改保存
elseif($action=="editinfo_saveedit"){
	
	$shopname    = htmlspecialchars($shopname);
	$shop_username    = htmlspecialchars($shop_username);
	$shopcompany     = htmlspecialchars($shopcompany);
	$shop_logo    = htmlspecialchars($shop_logo);
	$shop_signs   = htmlspecialchars($shop_signs);
	$shop_banner    = htmlspecialchars($shop_banner);
	$shop_ad1    = htmlspecialchars($shop_ad1);
	$shop_ad2     = htmlspecialchars($shop_ad2);
	$shop_ad3     = htmlspecialchars($shop_ad3);
	$shop_tel    = htmlspecialchars($shop_tel);
	$shop_prov   = $address_prov;
	$shop_city   = $address_city;
	$shop_town   = $address_town;
	$shop_address    = htmlspecialchars($shop_address);
	
	
	
	$sql = "UPDATE `#@__shops` SET shopname='$shopname', shop_username='$shop_username', shopcompany='$shopcompany', shop_logo='$shop_logo', shop_signs='$shop_signs', shop_banner='$shop_banner', shop_ad1='$shop_ad1', shop_ad2='$shop_ad2', shop_ad3='$shop_ad3', shop_tel='$shop_tel', shop_prov='$shop_prov', shop_city='$shop_city', shop_town='$shop_town' , shop_address='$shop_address', checkinfo='$checkinfo',delivery_area='$delivery_area' WHERE userid=$userid";

	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('资料修改成功！','?action=editinfo');
		exit();
	}
}
//商品分类
elseif($action=="goodstype"){
	require_once('goodstype.php');
}

//商品分类添加
elseif($action=="goodstype_edit"){
	require_once('goodstype_edit.php');
}

//商品分类添加保存
elseif($action=="goodstype_saveadd"){
	$classname    = htmlspecialchars($classname);
	$sql = "INSERT INTO `#@__shopstype` SET shopid='$r_shop[id]', parentid='$parentid', classname='$classname', orderid='$orderid', checkinfo='$checkinfo'   ";

	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('操作成功！','?action=goodstype');
		exit();
	}
}

//商品分类修改保存
elseif($action=="goodstype_saveedit"){
	$classname    = htmlspecialchars($classname);
	$sql = "UPDATE `#@__shopstype` SET  parentid='$parentid', classname='$classname', orderid='$orderid', checkinfo='$checkinfo' where id='$id' and shopid='".$r_shop['id']."'";

	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('操作成功！','?action=goodstype');
		exit();
	}
}

//商品分类显示
elseif($action=="goodstype_check"){
	
	if($check=='true'){
		$checkinfo='false';
	}else{
		$checkinfo='true';
	}
	$sql = "UPDATE `#@__shopstype` SET checkinfo='$checkinfo' where id='$id' and shopid='".$r_shop['id']."'";

	if($dosql->ExecNoneQuery($sql))
	{
		header('location:?action=goodstype');
		exit();
	}
}
//商品分类删除
elseif($action=="goodstype_del"){
		
	if(empty($id) || $id<0){
		ShowMsg('参数错误！','-1');
		exit();
	}
	
	$sql = "DELETE FROM `#@__shopstype` WHERE id='$id' and shopid='".$r_shop['id']."'";
	if($dosql->ExecNoneQuery($sql))
	{
		header('location:?action=goodstype');
		exit();
	}
	
}

//商品管理
elseif($action=="goods"){
	require_once('goods.php');
}

//商品添加
elseif($action=="goods_edit"){
	require_once('goods_edit.php');
}

//商品添加保存
elseif($action=="goods_saveadd"){

	$title    = htmlspecialchars($title);

	$sqlprice = '';
	$sqlmarketprice = '';
	$sqlpromotions_price = '';
	$sqlguige = '';
	for($i=0,$n=count($price);$i<$n;$i++)
	{
		$price[$i] = number_format(floatval($price[$i]),2);
		$marketprice[$i] = number_format(floatval($marketprice[$i]),2);
		$promotions_price[$i] = number_format(floatval($promotions_price[$i]),2);
		if($price[$i] > 0)
		{
			
			$sqlprice .= $price[$i].",";
			$sqlmarketprice .= $marketprice[$i].",";
			$sqlpromotions_price .= $promotions_price[$i].",";
			$sqlguige .= $guige[$i].",";
		}else
		{
			message('输入价格有误','javascript:history.go(-1)');		
		}
	}
	$sqlprice = substr($sqlprice,0,'-1');
	$sqlmarketprice = substr($sqlmarketprice,0,'-1');
	$sqlpromotions_price = substr($sqlpromotions_price,0,'-1');
	$sqlguige = substr($sqlguige,0,'-1');
	
	if($promotions == 'true')
		$salesprice = htmlspecialchars($promotions_price[0]);
	else
		$salesprice = htmlspecialchars($price[0]);
		
	$picurl    = $picurl == '' ? 'images/nopic.jpg' : htmlspecialchars($picurl);
	$content    = $content;
	
	
	if($promotions_starttime!=''){
		$promotions_starttime = strtotime($promotions_starttime);
	}
	
	if($promotions_endtime!=''){
		$promotions_endtime = strtotime($promotions_endtime);
	}
	
	if($promotions_endtime < $promotions_starttime){
		ShowMsg('结束时间必须大于开始时间！','-1');
		exit();	
	}
	
	
	//文章属性
	if(is_array($flag))
	{
		$flag = implode(',',$flag);
	}
	
	$marketprice=number_format(floatval($marketprice),2);
	$salesprice=number_format(floatval($salesprice),2);

	//文章组图
	if(is_array($picarr) &&
	   is_array($picarr_txt))
	{
		$picarrNum = count($picarr);
		$picarrTmp = '';

		for($i=0;$i<$picarrNum;$i++)
		{
			$picarrTmp[] = $picarr[$i].','.$picarr_txt[$i];
		}

		$picarr = serialize($picarrTmp);
	}
	
	$posttime=time();
	
	
	
	echo $sql = "INSERT INTO `#@__goods` SET shopid='$r_shop[id]', title='$title', marketprice='$sqlmarketprice', salesprice='$salesprice', price='$sqlprice', guige='$sqlguige', housenum='$housenum', typetid='$typetid', typepid='$typepid', typeid='$typeid', shoptype_pid='$shoptype_pid', shoptype_id='$shoptype_id', brandid='$brandid', shop_addressid='$shop_addressid', flag='$flag', picurl='$picurl', content='$content', picarr='$picarr', checkinfo='true', issale='$issale', posttime='$posttime', promotions='$promotions', promotions_price='$sqlpromotions_price', promotions_starttime='$promotions_starttime', promotions_endtime='$promotions_endtime'   ";

	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('操作成功！','?action=goods');
		exit();
	}
}

//商品分类修改保存
elseif($action=="goods_saveedit"){
	
	$sqlprice = '';
	$sqlmarketprice = '';
	$sqlpromotions_price = '';
	$sqlguige = '';
	for($i=0,$n=count($price);$i<$n;$i++)
	{
		$price[$i] = number_format(floatval($price[$i]),2);
		$marketprice[$i] = number_format(floatval($marketprice[$i]),2);
		$promotions_price[$i] = number_format(floatval($promotions_price[$i]),2);
		if($price[$i] > 0)
		{
			
			$sqlprice .= $price[$i].",";
			$sqlmarketprice .= $marketprice[$i].",";
			$sqlpromotions_price .= $promotions_price[$i].",";
			$sqlguige .= $guige[$i].",";
		}else
		{
			message('输入价格有误','javascript:history.go(-1)');		
		}
	}
	$sqlprice = substr($sqlprice,0,'-1');
	$sqlmarketprice = substr($sqlmarketprice,0,'-1');
	$sqlpromotions_price = substr($sqlpromotions_price,0,'-1');
	$sqlguige = substr($sqlguige,0,'-1');

	if($promotions == 'true')
		$salesprice = htmlspecialchars($promotions_price[0]);
	else
		$salesprice = htmlspecialchars($price[0]);
	
	$title    = htmlspecialchars($title);
	$picurl    = $picurl == '' ? 'images/nopic.jpg' : htmlspecialchars($picurl);
	$content    = $content;
	
	if($promotions_starttime!=''){
		$promotions_starttime = strtotime($promotions_starttime);
	}
	
	if($promotions_endtime!=''){
		$promotions_endtime = strtotime($promotions_endtime);
	}
	
	if($promotions_endtime < $promotions_starttime){
		ShowMsg('结束时间必须大于开始时间！','-1');
		exit();	
	}
	
	//文章属性
	
	if(isset($flag) && is_array($flag))
	{
		$flag = implode(',',$flag);
	}else{
		$flag = '';	
	}
	

	//文章组图
	if(isset($picarr))
	{
		if(is_array($picarr) &&
		   is_array($picarr_txt))
		{
			$picarrNum = count($picarr);
			$picarrTmp = '';
	
			for($i=0;$i<$picarrNum;$i++)
			{
				$picarrTmp[] = $picarr[$i].','.$picarr_txt[$i];
			}
	
			$picarr = serialize($picarrTmp);
		}
	}else{
		$picarr = '';
	}
	
	$posttime=time();
	
	
	$sql = "UPDATE `#@__goods` SET  title='$title', marketprice='$sqlmarketprice', salesprice='$salesprice', price='$sqlprice', guige='$sqlguige', housenum='$housenum', typetid='$typetid', typepid='$typepid', typeid='$typeid', shoptype_pid='$shoptype_pid', shoptype_id='$shoptype_id', brandid='$brandid', shop_addressid='$shop_addressid', flag='$flag', picurl='$picurl', content='$content', picarr='$picarr', checkinfo='true', issale='$issale', posttime='$posttime', promotions='$promotions', promotions_price='$sqlpromotions_price', promotions_starttime='$promotions_starttime', promotions_endtime='$promotions_endtime'  where id='$id' and shopid='".$r_shop['id']."'  ";

	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('操作成功！','?action=goods');
		exit();
	}
	
}


//商品属性
elseif($action=="flag"){
	
	if($a != 't' && $a != 'j' && $a != 'x' && $a != 'r'){
		ShowMsg('参数错误！','-1');
		exit();	
	}
		
	$row = $dosql->GetOne("SELECT flag FROM `#@__goods` WHERE id='$id' and shopid='".$r_shop['id']."'");
	if(!is_array($row)){
		ShowMsg('参数错误！','-1');
		exit();	
	}
	
	$flagarr = explode(',',$row['flag']);
	
	if(in_array($a,$flagarr)){
		foreach($flagarr as $k=>$v){
			if($v==$a){
				unset($flagarr[$k]);
			}
		}
	}else{
		$flagarr[]=$a;	
	}
	
	
	$flagarr=array_filter($flagarr);
	
	if(is_array($flagarr))
	{
		$flag = implode(',',$flagarr);
	}
	
	
	
	$sql = "UPDATE `#@__goods` SET flag='$flag' where id='$id' and shopid='".$r_shop['id']."'";

	if($dosql->ExecNoneQuery($sql))
	{
		header('location:?action=goods');
		exit();
	}
}


//商品上架
elseif($action=="issale"){
	
	if(empty($id) || $id<0){
		ShowMsg('参数错误！','-1');
		exit();
	}
	
	if($a=='true'){
		$issale='false';
	}else{
		$issale='true';
	}
	$sql = "UPDATE `#@__goods` SET issale='$issale' where id='$id' and shopid='".$r_shop['id']."'";

	if($dosql->ExecNoneQuery($sql))
	{
		header('location:?action=goods');
		exit();
	}
}


//商品审核
elseif($action=="checkinfo"){
	
	if(empty($id) || $id<0){
		ShowMsg('参数错误！','-1');
		exit();
	}
	
	if($a=='true'){
		$checkinfo='false';
	}else{
		$checkinfo='true';
	}
	$sql = "UPDATE `#@__goods` SET checkinfo='$checkinfo' where id='$id' and shopid='".$r_shop['id']."'";

	if($dosql->ExecNoneQuery($sql))
	{
		header('location:?action=goods');
		exit();
	}
}

//商品删除
elseif($action=="goods_del"){
		
	if(empty($id) || $id<0){
		ShowMsg('参数错误！','-1');
		exit();
	}
	
	$sql = "DELETE FROM `#@__goods` WHERE id='$id' and shopid='".$r_shop['id']."'";
	if($dosql->ExecNoneQuery($sql))
	{
		header('location:?action=goods');
		exit();
	}
	
}

//商品批量删除
elseif($action=="delall"){
	
	if(is_array($checkid))
	{
		foreach($checkid as $v)
		{
			//参数过滤
			$v = intval($v);
			$dosql->ExecNoneQuery("DELETE FROM `#@__goods` where id='$v' and shopid='".$r_shop['id']."'");
		}
	}
	
	header('location:?action=goods');
	exit();
}


//商品批量下架
elseif($action=="shelves"){
	
	if(is_array($checkid))
	{
		foreach($checkid as $v)
		{
			//参数过滤
			$v = intval($v);
			$dosql->ExecNoneQuery("UPDATE `#@__goods` SET issale='false' where id='$v' and shopid='".$r_shop['id']."'");
		}
	}

	header('location:?action=goods');
	exit();
}


//商品属性批量操作
elseif($action=="flagall"){
	
	if(is_array($checkid))
	{
		foreach($checkid as $vid)
		{
			//参数过滤
			$vid = intval($vid);
			
			$row = $dosql->GetOne("SELECT flag FROM `#@__goods` WHERE id='$vid' and shopid='".$r_shop['id']."'");
			if(is_array($row)){
				$flagarr = explode(',',$row['flag']);
				if(in_array($a,$flagarr)){
					foreach($flagarr as $k=>$v){
						if($v==$a){
							unset($flagarr[$k]);
						}
					}
				}else{
					$flagarr[]=$a;	
				}
				
				
				$flagarr=array_filter($flagarr);
				
				if(is_array($flagarr))
				{
					$flag = implode(',',$flagarr);
				}
				
				
				$dosql->ExecNoneQuery("UPDATE `#@__goods` SET flag='$flag' where id='$vid' and shopid='".$r_shop['id']."'");
			}
		}
	}
	
	header('location:?action=goods');
	exit();
}

//购物须知
elseif($action=="shops_note"){
	require_once('shops_note.php');
}

//购物须知保存
elseif($action=="shops_note_save"){
	$posttime  = time();
	
	$r = $dosql->GetOne("SELECT `id` FROM `#@__shopsnote` WHERE shopid=".$r_shop['id']." and classid='0'");
	if(isset($r['id']))
	{
		$sql="UPDATE `#@__shopsnote` SET classid='0', content='$content', posttime='$posttime' WHERE id=".$r['id'];
		if($dosql->ExecNoneQuery($sql))
		{
			ShowMsg('资料更新成功！','?action=shops_note');
			exit();
		}
	}else{
		$sql = "INSERT INTO `#@__shopsnote` (classid, content, posttime, shopid) VALUES ('0', '$content', '$posttime', '$r_shop[id]')";	
		if($dosql->ExecNoneQuery($sql))
		{
			ShowMsg('资料更新成功！','?action=shops_note');
			exit();
		}
	}
}


//店铺公告
elseif($action=="shops_announcement"){
	require_once('shops_announcement.php');
}

//店铺公告保存
elseif($action=="shops_announcement_save"){
	$posttime  = time();
	
	$content    = htmlspecialchars($content);
	
	$r = $dosql->GetOne("SELECT `id` FROM `#@__shopsnote` WHERE shopid=".$r_shop['id']." and classid='1'");
	if(isset($r['id']))
	{
		$sql="UPDATE `#@__shopsnote` SET classid='1', content='$content', posttime='$posttime' WHERE id=".$r['id'];
		if($dosql->ExecNoneQuery($sql))
		{
			ShowMsg('资料更新成功！','?action=shops_announcement');
			exit();
		}
	}else{
		$sql = "INSERT INTO `#@__shopsnote` (classid, content, posttime, shopid) VALUES ('1', '$content', '$posttime', '$r_shop[id]')";	
		if($dosql->ExecNoneQuery($sql))
		{
			ShowMsg('资料更新成功！','?action=shops_announcement');
			exit();
		}
	}
}

//店铺广告
elseif($action=="shopad"){
	require_once('shopad.php');
}

//店铺广告添加
elseif($action=="shopad_edit"){
	require_once('shopad_edit.php');
}

//店铺广告添加保存
elseif($action=="shopad_saveadd"){
	$title    = htmlspecialchars($title);
	$picurl    = htmlspecialchars($picurl);
	$linkurl    = htmlspecialchars($linkurl);
	$posttime=time();
	$sql = "INSERT INTO `#@__shopad` SET shopid='$r_shop[id]', classid='$classid', title='$title', picurl='$picurl', linkurl='$linkurl', target='$target', orderid='$orderid', checkinfo='$checkinfo', posttime='$posttime'   ";

	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('操作成功！','?action=shopad');
		exit();
	}
}

//店铺广告修改保存
elseif($action=="shopad_saveedit"){
	$title    = htmlspecialchars($title);
	$picurl    = htmlspecialchars($picurl);
	$linkurl    = htmlspecialchars($linkurl);
	$posttime=time();
	$sql = "UPDATE `#@__shopad` SET  classid='$classid', title='$title', picurl='$picurl', linkurl='$linkurl', target='$target', orderid='$orderid', checkinfo='$checkinfo', posttime='$posttime' where id='$id' and shopid='".$r_shop['id']."'";

	if($dosql->ExecNoneQuery($sql))
	{
		ShowMsg('操作成功！','?action=shopad');
		exit();
	}
}

//店铺广告显示
elseif($action=="shopad_check"){
	
	if(empty($id) || $id<0){
		ShowMsg('参数错误！','-1');
		exit();
	}
	
	if($a=='true'){
		$checkinfo='false';
	}else{
		$checkinfo='true';
	}
	$sql = "UPDATE `#@__shopad` SET checkinfo='$checkinfo' where id='$id' and shopid='".$r_shop['id']."'";

	if($dosql->ExecNoneQuery($sql))
	{
		header('location:?action=shopad');
		exit();
	}
}
//店铺广告删除
elseif($action=="shopad_del"){
		
	if(empty($id) || $id<0){
		ShowMsg('参数错误！','-1');
		exit();
	}
	
	$sql = "DELETE FROM `#@__shopad` WHERE id='$id' and shopid='".$r_shop['id']."'";
	if($dosql->ExecNoneQuery($sql))
	{
		header('location:?action=shopad');
		exit();
	}
	
}
//店铺订单
elseif($action=="order"){		
	require_once('./order.php');	
}


else{
	require_once('./home.php');	
}



?>