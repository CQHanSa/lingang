<?php
/* 参数解释
	//自制前台会员验证
   $type=islogin => 判断是否登陆
   $type=center =>  用户登录 $username:用户名 | $password:密码
   $type=password => 修改密码  $username:用户名 |  | $password:密码 | $repassword:重复密码
   $type=exit => 退出登陆
   $type=onlyone => 限制只能一个账号登陆
   $type=par => 获取COOKIE参数
   return => true：执行成功 | -1:用户名不存在 | -2：密码错误 | -3:两次密码不一致
*/
function is_user($type,$username='',$password='',$repassword='',$oldpassword='')
{
	global $path;
	$user['userid'] = isset($_COOKIE['userid']) ?  AuthCode($_COOKIE['userid'],'DECODE') : ''; //id
	$user['username'] = isset($_COOKIE['username']) ? AuthCode($_COOKIE['username'],'DECODE') : ''; //会员用户名
	$user['lastlogintime'] = isset($_COOKIE['lastlogintime']) ? AuthCode($_COOKIE['lastlogintime'],'DECODE') : ''; //登陆时间
	$user['lastloginip'] = isset($_COOKIE['lastloginip']) ? AuthCode($_COOKIE['lastloginip'],'DECODE') : ''; //登陆ip
	
	//用户登录
	if($type == 'center')
	{
		
		$user = MysqlOneSelect('lgsc_member','*',"username='$username'"); 
		//echo $user;
		if($user == '-1' ){return '-1'; exit(); }
		if( md5(md5($password)) !== $user['password']){  return '-2'; exit();   }
		//生成登陆认证
		$rnd = makecode(6);
		//生成COOkie
		$cookie_time = time()+3600;
		setcookie('userid',      AuthCode($user['id'],$rnd), $cookie_time,'/');
		setcookie('username',      AuthCode($user['username'],$rnd), $cookie_time,'/');
		setcookie('lastlogintime', AuthCode($user['regtime'],$rnd), $cookie_time,'/');
		setcookie('lastloginip',   AuthCode(GetIP(),$rnd), $cookie_time,'/');
		setcookie("qtrnd",$rnd, $cookie_time,'/');
		//更新最后登陆时间 和 登陆认证 登录IP
		mysql_query("update lgsc_member set logintime =".time()." , loginip=".GetIP()." where userid = ".$user['id']);
		//登录成功
		return true;
	}
	
	//判断是否登陆
	if($type == 'islogin')
	{
		if(!isset($_COOKIE['userid']) && $user['userid'] == ""  )
		{
			return false;
		}
		return true;
	}
	//限制只能一个账号登陆
	if($type == 'onlyone'){
		$OneRow = MysqlOneSelect('phome_enewsmember','rnd',"userid=$user[0]");
		//print_r($OneRow);
		if($_COOKIE["qtrnd"] == '' || $_COOKIE["qtrnd"] != $OneRow['rnd'] )
		{
			//注销Cookie
			setcookie('userid',"",time()-3600*10,'/');
			setcookie('username',"",time()-3600*10,'/');
			setcookie('lastlogintime',"",time()-3600*10,'/');
			setcookie('lastloginip',"",time()-3600*10,'/');
			setcookie('qtrnd',"",time()-3600*10,'/');
			//跳转登陆
			return true;
		}
		return false;
	}
	//退出登陆
	if( $type == "exit")
	{
		//注销Cookie
		setcookie('userid',"",time()-3600*10,'/');
		setcookie('username',"",time()-3600*10,'/');
		setcookie('lastlogintime',"",time()-3600*10,'/');
		setcookie('lastloginip',"",time()-3600*10,'/');
		setcookie('qtrand',"",time()-3600*10,'/');
		//跳转登陆
		return true;
	}
	//修改密码
	if($type == "password")
	{
		$one_user = MysqlOneSelect("lgsc_member","*","username = '$username'");
		//echo "select * from lgsc_member where username = '$username' limit 1";
		//判断是否存在该用户
		if($one_user == '-1'){ return -1; exit(); }			
		//对比密码是否正确
		if($oldpassword !=="")
		{
			if($one_user['password'] !== md5(md5($oldpassword)) ){ return -2;exit();}  
		}
		//获取密码强度
		$password_strength = password_strength($password);
		//密码修改
		if( $password != '')
		{
			//两次密码不一致请从新输入
			if( $password !== $repassword ){ return false;}
			else{
				$newpassword = md5(md5($password));
				$sql_password = "update lgsc_member set password ='$newpassword' , password_strength ='$password_strength' where id = ".$one_user['id'];
				$rest_password = mysql_query($sql_password);
				if(!$rest_password){ return false;}
			}	
		}
		return true;
	}
	//获取参数
	if( $type == 'par' )
	{
		return $user;
	}
}

/*
//---- 会员注册
// mian_field => 主表字段数组 
// of_field => 附表字段数组
// jump_url => 成功后跳转地址
*/
function member_reg($mian_field)
{
	global $path,$dosql;
	//判断用户名是否存在
	//$user = $dosql->GetOne("SELECT `username` FROM `lgsc_member` WHERE id=".$row['classid']);
	$user = MysqlOneSelect('lgsc_member','username',"username='$mian_field[username]'");
	//echo $user;
	if($user != -1 || ( $mian_field['username'] == '' || $mian_field['username'] == 'admin' ) ){ message('用户名已存在','javascript:history.go(-1)');exit();}
	//判断密码位数
	if(strlen($mian_field["password"]) < 5 ){ message("密码必须大于5位","javascript:history.go(-1)"); exit(); }
	//判断密码是否相同
	if( ( $mian_field["password"] != $mian_field["repassword"] ) || $mian_field["password"] == "" || $mian_field["repassword"] == ""){ message("两次密码有误或为空","javascript:history.go(-1)"); exit();}	
	//生成密码 标识码
	$mian_field["password"] = md5(md5($mian_field["password"]));
	//插入主表
	//删除确认密码
	unset($mian_field['repassword']);
	$insert_member = "insert into lgsc_member set id='' , integral = 100  "; 
	foreach($mian_field as $k => $v){	$insert_member .=" , $k= '$v'  "; }
	$insert_member .= " , regtime = ".time();
	//echo $insert_member;
	$rest_member = mysql_query($insert_member);
	if($rest_member){   return true; }
}

//密码强度等级
// $type => numeral 数组表示 | zh 中文表示
function PasswordLevel($str,$type='numeral')
{
	$strength = $str;
	if($strength > 0 && $strength <= 3 )
	{ 
		if($type == 'numeral'){$level = 1;}
		if($type == 'zh'){$level = '低';}
	}
	elseif( $strength > 3 && $strength <= 7 )
	{
	 	if($type == 'numeral'){$level = 2;}
		if($type == 'zh'){$level = '中';}
	}
	else{
		if($type == 'numeral'){$level = 3;}
		if($type == 'zh'){$level = '高';} 
	}
	return $level;
}

//计算资料完整度
// $db_table  => 查询的表
// $post 	  => 需要计算的数组
// $where 	  => 执行条件
function MemberComplete($db_table='lgsc_member',$post,$where)
{
	$user = MysqlOneSelect($db_table,$post,$where);
	$n = count($post);
	$i = 0 ;
	foreach($user as $k => $v)
	{
		if($v != '-1' && $v != '') $i++;
	}
	return sprintf('%.2f',$i/$n)*100; 
}


//验证密码强度
//满分10
function password_strength($password)
{
	$score = 0;
	if(preg_match("/[0-9]+/",$password))
	{
	  $score ++; 
	}
	if(preg_match("/[0-9]{3,}/",$password))
	{
	  $score ++; 
	}
	if(preg_match("/[a-z]+/",$password))
	{
	  $score ++; 
	}
	if(preg_match("/[a-z]{3,}/",$password))
	{
	  $score ++; 
	}
	if(preg_match("/[A-Z]+/",$password))
	{
	  $score ++; 
	}
	if(preg_match("/[A-Z]{3,}/",$password))
	{
	  $score ++; 
	}
	if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/",$password))
	{
	  $score += 2; 
	}
	if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/",$password))
	{
	  $score ++ ; 
	}
	if(strlen($password) >= 10)
	{
	  $score ++; 
	}
	return $score;	
}

//出生年份
function birth($value='-1',$start='',$end='',$zh='年',$list='option')
{
	$year = date('Y',time());
	$cwrite ='';
	for($i=$year;$i>=1930;$i--)
	{
		$selected = '';
		if($value != '-1')
		{
			if($i == $value ){$selected = "selected='selected'";}
			else{$selected = "";}	
		}
		$cwrite .= "<$list value='$i' $selected> $i $zh</$list>";
	}
	
	if($start != '' && $end != '')
	{
		$cwrite = '';
		for($i=$start;$i<=$end;$i++)
		{
			$selected = '';
			if($value != '-1')
			{
				if($i == $value ){$selected = "selected='selected'";}
				else{$selected = "";}	
			}
			$cwrite .= "<$list value='$i' $selected> $i $zh</$list>";
		}
	}
	
	return $cwrite;
}

//显示顶级级联
function list_cas($value='-1',$mark='trade',$list='option')
{
	$rest = mysql_query("SELECT * FROM `lgsc_cascadedata` WHERE `datagroup`='$mark' AND level=0 ORDER BY orderid ASC, datavalue ASC");
	$cwrite = '';
	while($row = mysql_fetch_array($rest))
	{
		$selected = '';
		if($value != '-1')
		{		
			
			if($row['datavalue'] == $value)
				$selected = 'selected="selected"';
			else
				$selected = '';
		}
		$cwrite .= '<'.$list.' value="'.$row['datavalue'].'" '.$selected.'>'.$row['dataname']."</$list>";
	}
	return $cwrite;
}

//获取单条级联数据
function one_cas($datavalue)
{
	if($datavalue != "-1")
	{
		$cas = MysqlOneSelect('lgsc_cascadedata','dataname',"`datavalue`='$datavalue'");
		$a = $cas['dataname'];
	}
	else{ $a = ''; }
	return $a;	
}

//获取多条级联数据
/*
	$hotdata => 当前高亮值
	$where => 查询条件
	$floor => 层级
	$revalue => 上层级值
	$list => 显示类型
*/
function row_cas($hotdata='-1',$where,$floor='',$revalue='',$list='option')
{
	if($floor == 1){ $where = "`datagroup`='$mark' AND level=0";}
	elseif($floor == 2){ $where = " (datavalue > $revalue and datavalue < ".($revalue+499).") and level=1 "; }
	elseif($floor == 3){ $where = " (datavalue > $revalue and datavalue < ".($revalue+1).") and level=2 "; }
	$sql = "select dataname,datavalue from lgsc_cascadedata where $where ORDER BY orderid ASC, datavalue ASC ";
	//echo $sql;
	$rest = mysql_query($sql);
	if(!$rest){ die("查询出错.$sql");}
	$cwrite = '<option value="-1">请选择</option>';
	$cwrite = '';
	while($row = mysql_fetch_array($rest))
	{
		$selected = '';
		if($hotdata === $row['datavalue'])
			$selected = 'selected="selected"';
		else
			$selected = '';
		$cwrite .= '<'.$list.' value="'.$row['datavalue'].'" '.$selected.'>'.$row['dataname']."</$list>";
	}
	return $cwrite;
}


//编辑会员信息
function member_edit($tb,$var,$where)
{
	$sql = "update $tb set ";
	$i=0;
	foreach($var as $k => $v)
	{
		if($i == 0)
			$sql .= "$k = '$v' ";
		else
			$sql .=" , $k = '$v'"; 
		$i++;
	}
	$sql .=" where $where";
	$rest = mysql_query($sql);
	if(!$rest){ die('操作错误: '.$sql);}
	return true;
}

//计算资料完整度
function member_complete($post,$where)
{
	$user = MysqlOneSelect('lgsc_member',$post,$where);
	$n = count($post);
	$i = 0 ;
	foreach($user as $k => $v)
	{
		if($v != '-1' && $v != '') $i++;
	}
	return sprintf('%.2f',$i/$n)*100; 
}


//计算订单数量
function DDnum($user ='')
{
		$DD = MysqlOneSelect('lgsc_DD','count(*) as num',"clientstate <= 2 and userid=$user[userid] and delstate = -1");
		$DDnum = $DD == '-1' ? '0' : $DD['num'];
		return $DDnum;	
}

//支付方式
function payMode($table='lgsc_paymode',$name='paymode',$list='radio',$value='')
{
	$write = '';	
	$rest = mysql_query("select * from $table order by orderid asc");
	while($row = mysql_fetch_array($rest))
	{
		$checked = '';
		$selected = '';
		echo $value;
		if($value == ''){
			if($row['id'] == 1){ $checked = 'checked'; $selected = 'selected="selected"';}
		}else{
			if($row['id'] == $value){  $checked = 'checked';  $selected = 'selected="selected"';}
		}
		
		if($list == 'radio')
			$write .= '<input name="'.$name.'" type="radio" value="'.$row['id'].'" '.$checked.'/> '.$row['classname']." ";
		if($list == 'option')
			$write .= '<option value="'.$row['id'].'" '.$selected.'> '.$row['classname']."</option>";	
	}
	return $write;
}

//送货时间
function getMode()
{
	$write = '';
	$rest = mysql_query("select * from lgsc_getmode order by orderid asc");
	while($row = mysql_fetch_array($rest))
	{
		$checked = '';
		if($row['id'] == 1){ $checked = 'checked';}
		$write .= '<li><input name="getMode" type="radio" value="'.$row['id'].'" '.$checked.'/> '.$row['classname']."</li>";
	}
	return $write;
}

//记录浏览缓存
function scanlog($user = '',$id)
{
	if($user == '')
	{
		//Cookie记录
		if(isset($_COOKIE['goodsid']) )
		{
			//echo strpos($id,$_COOKIE['goodsid']);
			//echo $id;
			$string =AuthCode($_COOKIE['goodsid'],'DECODE');
			if(strpos("$string",$id) === false )
			{
				$_COOKIE['goodsid']  =  AuthCode($_COOKIE['goodsid'],'DECODE');
				$_COOKIE['goodsid'] =  AuthCode($_COOKIE['goodsid']."$id,",'ENCODE'); 
				setcookie('goodsid', $_COOKIE['goodsid'],time()*3600*24,'/');
			}
			//echo AuthCode($_COOKIE['goodsid'],'DECODE');
		}else
		{
			setcookie('goodsid', AuthCode($id.",",'ENCODE'),time()*3600*24,'/');
		}
	}else
	{
		//存入数据库
		$post['goodsid'] = $id;
		$post['userid'] = $user['userid'];
		$post['createTime'] = time();
		if(isset($_COOKIE['goodsid']))
		{
			$goodsid = AuthCode($_COOKIE['goodsid'],'DECODE');
			$goodsid = substr($goodsid,'0','-1');
			$goodsidArr = explode(',',$goodsid);
			for($i=0,$n=count($goodsidArr);$i<$n;$i++)
			{
				$r = MysqlOneSelect("lgsc_scanlog","count(*) as total","userid='$user[userid]'");
				$total = $r['total'];
				if($total == 8 )
				{
					$delRest = MysqlDel('lgsc_scanlog',"userid='$user[id]' order by createTime desc limit 1");
				}
				$post['goodsid'] = $goodsidArr[$i];
				$scanlog = MysqlOneSelect("lgsc_scanlog","*","userid='$user[userid]' and goodsid = '$goodsidArr[$i]'");
				if($scanlog == '-1'){	
					MysqlOneExc('lgsc_scanlog',$post);
				}else
				{
					MysqlOneExc('lgsc_scanlog',"createTime=".time(),'update',"goodsid='$goodsidArr[$i]'");
				}
			}
			setcookie('goodsid', AuthCode($id.",",'ENCODE'),-time()*3600*24,'/');
			return true;
		}
		$r = MysqlOneSelect("lgsc_scanlog","count(*) as total","userid='$user[userid]'");
		$total = $r['total'];
		if($total == 8 )
		{
			$delRest = MysqlDel('lgsc_scanlog',"userid='$user[id]' order by createTime desc limit 1");
		}
		$scanlog = MysqlOneSelect("lgsc_scanlog","*","userid='$user[userid]' and goodsid = '$id'");
		if($scanlog == '-1'){	
			MysqlOneExc('lgsc_scanlog',$post);
		}else
		{
			MysqlOneExc('lgsc_scanlog',"createTime=".time(),'update',"goodsid='$id'");
		}
	}
}
//获取浏览记录
function getsScanlog($user)
{
	if($user == '')
	{
		if(!isset($_COOKIE['goodsid'])){ return false; }
		$goodsid = AuthCode($_COOKIE['goodsid'],'DECODE');
		$goodsid = " id in (".substr($goodsid,0,'-1').")";
		//echo $goodsid;
		return $goodsid;
	}else
	{
		$rows = MysqlRowSelect('lgsc_scanlog','goodsid',"userid='$user[userid]'");
		if($rows == '-1'){ return false; }
		$goodsid = " id in (";
		for($i=0,$n=count($rows);$i<$n;$i++)
		{
			$goodsid .= $rows[$i]['goodsid'].',';
		}
		$goodsid = substr($goodsid,0,'-1').')';
		return $goodsid;
	}
}
//商品收藏数量
function CollectionNums($value,$type='goods')
{
	//商品收藏人数
	if($type == 'goods')
	{
		$r = MysqlOneSelect('lgsc_goodscollection','count( * ) as total',"goodsid='$value'");
	}
	//店铺收藏人数
	elseif($type == 'shop')
	{
		$r = MysqlOneSelect('lgsc_shopscollection','count( * ) as total',"shopid='$value'");
	}
	elseif($type == 'coupon'){
		$r = MysqlOneSelect('lgsc_user_coupon','count( * ) as total',"userid='$value[userid]' and statu = 0");
	}
	if($r == '-1'){ return 0;}
	$total = $r['total'];
	return $total;
}
//分析收藏浏览喜欢
function goodsShowAI($user,$table='lgsc_scanlog')
{
		$addsql = "$table.goodsid = lgsc_goods.id and $table.userid = '$user[userid]' group by typeid";
		$rows = MysqlRowSelect("$table,lgsc_goods",'lgsc_goods.typeid',$addsql);
		if($rows != '-1')
		{
			$addsql = "typeid in (";
			foreach($rows as $key =>  $value)
			{
				$addsql .= $value['typeid'].",";
			}
			$addsql = substr($addsql,0,-1).') order by rand()';
			$row = MysqlRowSelect('lgsc_goods','id',$addsql,5);
			if($row == '-1'){ return false;}
			$addsql = "lgsc_goods.id in(";
			foreach($row as $key =>  $value)
			{
				$addsql .= $value['id'].",";
			}
			$addsql = substr($addsql,0,-1).') ';
			return $addsql;
		}else{
			$row = MysqlRowSelect('lgsc_goods','id',"id != 0 order by rand()",5);
			if($row == '-1'){ return false;}
			$addsql = "lgsc_goods.id in(";
			foreach($row as $key =>  $value)
			{
				$addsql .= $value['id'].",";
			}
			$addsql = substr($addsql,0,-1).') ';
			return $addsql;			
		}
	
}
//
function getBuyCarNum($user)
{
	if($user != '')
	{
		$r = MysqlOneSelect('lgsc_mybuycar','count(*) as total',"userid='$user[userid]'");
		if($r == '-1')
			$total = 0;
		else
			$total = $r['total'];
	}else
	{
		if(isset($_COOKIE['buyCar']))
			$total = count($_COOKIE['buyCar']);
		else
			$total = 0;
	}
	return $total;
}
//切割订单信息
function cutDDInfo($value)
{
	$value = substr($value,0,-3);
	$rows = explode(':::',$value);
	for($i=0,$n=count($rows);$i<$n;$i++)
	{
		$row[$i] = explode('|',$rows[$i]);
		if(is_array($row[$i])){
			$r[$i]['title'] = $row[$i][0];
			$r[$i]['weight'] = $row[$i][1];
			$r[$i]['salesprice'] = $row[$i][2];
			$r[$i]['num'] = $row[$i][3];
			$r[$i]['picurl'] = $row[$i][4];
		}
	}
	//print_r($r);
	return $r;
}

//积分兑换
function Redeem($price,$user)
{
	if($user == ''){ $addsql = 'stars = 1';}
	else
	{
		$r = MysqlOneSelect('lgsc_member','expval',"id = '$user[userid]'");
		$addsql = "expvalb >= '$r[expval]' order by id asc";
	}
	$group = MysqlOneSelect('lgsc_usergroup','color',$addsql,'1');
	$integral = floor($price * ( $group['color'] / 100 ));
	return $integral;
}

//判断订单执行状态
function isClientState($value,$id='')
{
	switch($value)
	{
		case -1:
			$r['tag'] = '立即支付';
			$r['url'] = "/Member/pay.php?id=$id";
			break;
		case 1:
			$r['tag'] = '确认收货';
			$r['url'] = 'javascript:video(0)';
			break;
		case 2:
			$r['tag'] = '评价';
			$r['url'] = 'javascript:video(0)';
			break;
		case 3:
			$r['tag'] = '交易完成';
			$r['url'] = 'javascript:video(0)';					
	}
	return $r;
}

//判断订单执行状态
function DDAdminState($value)
{
	switch($value)
	{
		case '-1':
			$r['tag'] = '等待付款';
			$r['url'] = 'javascript:video(0)';
			break;
		case 1:
			$r['tag'] = '已经付款';
			$r['url'] = 'javascript:video(0)';
			break;
		case 2:
			$r['tag'] = '已确认收货';
			$r['url'] = 'javascript:video(0)';
		case 3:
			$r['tag'] = '已评论,交易完成';
			$r['url'] = 'javascript:video(0)';					
	}
	return $r;
}

//判断订单状态
function isGoodsState($value)
{
	switch($value)
	{
		case -1:
			$r['tag'] = '等待付款';
			$r['url'] = 'javascript:video(0)';
			break;
		case 1:
			$r['tag'] = '等待发货';
			$r['url'] = 'javascript:video(0)';
			break;
		case 2:
			$r['tag'] = '已发货';
			$r['url'] = 'javascript:video(0)';
			break;			
		case 3:
			$r['tag'] = '物流运输中';
			$r['url'] = 'javascript:video(0)';
			break;
		case 4:
			$r['tag'] = '已签收 ';
			$r['url'] = 'javascript:video(0)';
			break;			
		case 5:
			$r['tag'] = '交易成功';
			$r['url'] = 'javascript:video(0)';					
	}
	return $r;
}
?>