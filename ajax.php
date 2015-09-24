<?php	
require_once(dirname(__FILE__).'/Common/index.php');

	//$_POST["param"] 获取文本框的值;
	//$_POST["name"]  获取文本框的name属性值，通过该值来判断是哪个文本框请求处理，这样当有多个实时验证请求时可以指定同一个文件处理;
	//sleep(3);//效果演示，该句可移除;
	//echo "y" //验证通过输出小写字母"y"，出错则输出相应错误信息;

$a  = isset($a)  ? $a : '';
	
$regtype=@$_POST["name"];

if($regtype=="username"){
	$username=$_POST["param"];
	$r = $dosql->GetOne("SELECT `id` FROM `#@__member` WHERE `username`='$username'");
	if(isset($r['id']))
	{
		echo '{
			"info":"该用户名已被注册！",
			"status":"n"
		 }';
	}else{
		echo '{
				"info":"该用户名可以注册！",
				"status":"y"
			 }';
	}
}else if($regtype=="mobile"){
	$mobile=$_POST["param"];
	$r = $dosql->GetOne("SELECT `id` FROM `#@__member` WHERE `mobile`='$mobile'");
	if(isset($r['id']))
	{
		echo '{
			"info":"该手机号码已被注册！",
			"status":"n"
		 }';
	}else{
		echo '{
				"info":"该手机号码可以注册！",
				"status":"y"
			 }';
	}
}else if($regtype=="email"){
	$email=$_POST["param"];
	$r = $dosql->GetOne("SELECT `id` FROM `#@__member` WHERE `email`='$email'");
	if(isset($r['id']))
	{
		echo '{
			"info":"该邮箱已被注册！",
			"status":"n"
		 }';
	}else{
		echo '{
				"info":"该邮箱可以注册！",
				"status":"y"
			 }';
	}
}

//手机验证码
if($a=="sendnum"){
	$mobilecode=GetRandNum(); //验证码
	if(!isset($_SESSION)) session_start();
	$_SESSION['mobilecode']=$mobilecode;//保存在session中
	//发送验证码		
	//echo $mobilecode; 
	if(!empty($mobile)){
		echo $mobilecode; 	
	}else if(!empty($email)){
		echo $mobilecode;	
	}
}

//商品详情 社区展示
if($a == 'showcommunity')
{	
	$v = isset($value) ? $value : '0';
	$community = MysqlRowSelect('lgsc_community','id,title',"`address_city`=$v and checkinfo='true' ORDER BY id desc");
	if($community == -1){ echo 'null';exit(); }
	echo '选择社区：<select id="community" >';
	echo '<option value="-1" >请选择</option>';
	for($i=0,$n=count($community);$i<$n;$i++)
	{
		echo '<option value="'.$community[$i]['id'].'" >'.$community[$i]['title'].'</potion>';
	}
	echo '</select> <span style="color:red"></span>';
}
//商品详情 判断是否可以配送
if($a == 'issendcommunity')
{	
	$v = isset($value) ? $value : '0';
	$shopid = isset($shopid) ? $shopid : '0';
	$shop = MysqlOneSelect('lgsc_shops','delivery_area',"id = $shopid");
	$community = explode(',',$shop['delivery_area']);
	if(in_array($v,$community))
	{
		echo '有货';
	}else{
		echo 'null';
	}
}


//社区选择
if($a=='selectcommunity'){
	
	$v = isset($value) ? $value : '0';
	$selectval=isset($selectval) ? $selectval:'';
	
	$selectarr = explode(',',$selectval);	

	if($v > 0)
	{
		$str='';
		
		$sql = "SELECT id,title FROM `#@__community` WHERE `address_city`=$v and checkinfo='true' ORDER BY id desc";
		$dosql->Execute($sql);
		while($row = $dosql->GetArray())
		{
			
			if(in_array($row['id'],$selectarr))
			{
				$select_on='class="on"';
			}else{
				$select_on='';	
			}
				
			$str .= '<li '.$select_on.'><a href="javascript:;"; value="'.$row['id'].'" title="'.$row['title'].'">'.ReStrLen($row['title'],10).'</a></li>';
		}
		
		if($str!=''){
			echo '<ul>'.$str.'</ul>';	
		}else{
			echo '该区域暂时社区';
		}		
	}else{
		echo '该区域暂时社区';
	}
	
	exit();	
}

//社区列表
if($a=='communitylist'){
	
	$v = isset($value) ? $value : '';

	if($v != '')
	{
		$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' ORDER BY orderid ASC, datavalue ASC");
		while($row = $dosql->GetArray())
		{
			$areaArr[$row['datavalue']]=$row['dataname'];
		}
		
		
		$arr=array();
        $sql = "SELECT address_city,title FROM `#@__community` WHERE id in($v) and checkinfo='true' ";
		$row=$dosql->Execute($sql);
		while($row = $dosql->GetArray()){
			$arr[]=$row;
		}
									
		$arr2 = array();
		foreach($arr as $k1 => $v1) {
			if(empty($arr2)) {
				$arr2[] = $v1;
			}else {
				foreach ($arr2 as &$v2) {
					if($v1['address_city'] == $v2['address_city']) {
						$v2['title'] .= '，'.$v1['title'];   
					} else {
						$arr2[] = $v1;
					}
				}
			}
		}
		echo '<dl>';						
		foreach($arr2 as $k => $v){
			echo '<dt>'.$areaArr[$v['address_city']].'（'.$v['title'].'）</dt>';
		}
		echo '</dl>';
			
	}
		
	exit();	
}

//获取商品分类
if($a == 'gettype')
{

	//初始化参数
	$level     = isset($level)     ? intval($level) : '2';
	$v         = isset($val)   ? intval($val)       : '0';
	

	if($level == '' or $v < 1)
	{
		header('location:/');
		exit();
	}

	$str = '<option value="0">--</option>';
	$sql = "SELECT * FROM `#@__goodstype` WHERE `parentid`='$v' and checkinfo='true' ORDER BY orderid ASC, id ASC";

	$dosql->Execute($sql);
	while($row = $dosql->GetArray())
	{
		$str .= '<option value="'.$row['id'].'">'.$row['classname'].'</option>';
	}
	
	echo $str;
	exit();
}


//获取商品店铺分类
if($a == 'getshoptype')
{

	//初始化参数
	$shopid    = isset($shopid)   ? intval($shopid)       : '0';
	$v         = isset($val)   ? intval($val)       : '0';
	

	if($shopid < 1 or $v < 1)
	{
		header('location:/');
		exit();
	}

	$str = '<option value="0">--</option>';
	$sql = "SELECT * FROM `#@__shopstype` WHERE shopid='$shopid' and `parentid`='$v' and checkinfo='true' ORDER BY orderid ASC, id ASC";

	$dosql->Execute($sql);
	while($row = $dosql->GetArray())
	{
		$str .= '<option value="'.$row['id'].'">'.$row['classname'].'</option>';
	}
	
	echo $str;
	exit();
}



//获取商品品牌分类
if($a == 'getbrand')
{

	//初始化参数
	$v         = isset($val)   ? intval($val)       : '0';
	

	if($v < 1)
	{
		header('location:/');
		exit();
	}

	$str = '<option value="0">请选择</option>';
	$sql = "SELECT * FROM `#@__goodsbrand` WHERE `parentid`='$v' and checkinfo='true' ORDER BY orderid ASC, id ASC";

	$dosql->Execute($sql);
	while($row = $dosql->GetArray())
	{
		$str .= '<option value="'.$row['id'].'">'.$row['classname'].'</option>';
	}
	
	echo $str;
	exit();
}



//获取优惠卷
if($a == 'getcoupon')
{

	//初始化参数
	$v         = isset($val)   ? intval($val)       : '0';
	$userid         = isset($userid)   ? intval($userid)       : '0';
	

	if($v < 1 || $userid < 1)
	{
		echo '0';
		exit();
	}
	//验证数据准确性
	$row = $dosql->GetOne("SELECT id,num,hasnum FROM `#@__coupon` WHERE id='$v'");
	if(!isset($row['id']) or !is_array($row)){
		echo '1';
		exit;
	}
	
	if($row['num']>0 && $row['hasnum']>=$row['num']){	
		echo '2';
		exit;
	}
	
	//已领取
	$row = $dosql->GetOne("SELECT id FROM `#@__user_coupon` WHERE `userid`='$userid' and couponid='$v' order by id desc");
	if(isset($row['id'])){
		echo '3';
		exit;
	}
	
	//领取
	$posttime=time();
	$sql = "INSERT INTO `#@__user_coupon` (userid, couponid, statu, posttime) VALUES ('$userid', '$v', '0', '$posttime')";	
	if($dosql->ExecNoneQuery($sql)){
		$dosql->ExecNoneQuery("UPDATE `#@__coupon` SET `hasnum`=hasnum+1 WHERE `id`='$v'");
		echo '4';	
	}
	exit();
}

?>