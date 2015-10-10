<?php
require_once(dirname(dirname(__FILE__)).'/Common/index.php');
$type  = isset($_GET['type']) ? get('type') : post('type');
if($type == 'buyCar')
{
	$post =  post('array');
	$post['goodsid'] = post('id');
	$post['createTime'] = time();
	unset($post['type'],$post['id']);
	//游客状态
	if($user == '')
	{
		if(isset($_COOKIE['buyCar']))
		{
			$buyCar = $_COOKIE['buyCar'];
			$n=count($buyCar);
			$addCooike = 'false';
			for($i=0;$i<$n;$i++)
			{
				if(AuthCode($buyCar[$i]['id']) == $post['goodsid'])
				{
					$addCooike = 'true';
					if(AuthCode($buyCar[$i]['num']) != $post['num'])
					{
						setcookie("buyCar[$i][num]",AuthCode($post['num'],'ENCODE'),time()*3600*24,'/');
						echo "数量更新成功"; exit();
					}
				}
			}
			if($addCooike != 'true')
			{
				//if($n != 1){ $n += 1; }
				setcookie("buyCar[$n][id]",AuthCode($post['goodsid'],'ENCODE'),time()*3600*24,'/');
				setcookie("buyCar[$n][num]",AuthCode($post['num'],'ENCODE'),time()*3600*24,'/');
				setcookie("buyCar[$n][shopid]",AuthCode($post['shopid'],'ENCODE'),time()*3600*24,'/');
				setcookie("buyCar[$n][price]",AuthCode($post['price'],'ENCODE'),time()*3600*24,'/');
				setcookie("buyCar[$n][weight]",AuthCode($post['weight'],'ENCODE'),time()*3600*24,'/');
				echo '添加购物车成功';
			}else{
				echo '已经加入购物车';
			}
		}
		else{
			setcookie('buyCar[0][id]',AuthCode($post['goodsid'],'ENCODE'),time()*3600*24,'/');
			setcookie('buyCar[0][num]',AuthCode($post['num'],'ENCODE'),time()*3600*24,'/');
			setcookie('buyCar[0][shopid]',AuthCode($post['shopid'],'ENCODE'),time()*3600*24,'/');
			setcookie('buyCar[0][price]',AuthCode($post['price'],'ENCODE'),time()*3600*24,'/');
			setcookie("buyCar[0][weight]",AuthCode($post['weight'],'ENCODE'),time()*3600*24,'/');
			echo '添加购物车成功';
		}
	}else
	{
	//会员登录状态
		$buycar = MysqlOneSelect("lgsc_mybuycar","*","userid='$user[userid]' and goodsid = '$post[goodsid]'");
		if($buycar == '-1' ){
			$post['userid']  = $user['userid'];
			$rest = MysqlOneExc('lgsc_mybuycar',$post);
			if($rest){ echo '添加购物车成功'; }
		}else{
			if($buycar['num'] == $post['num'])
			{
				echo '已经加入购物车';
			}else{
				$rest = MysqlOneExc('lgsc_mybuycar',"num = '$post[num]'",'update',"userid='$user[userid]' and goodsid = '$post[goodsid]'");
				if($rest){ echo '数量更新成功';}
			}
		}
	}	
	
}
//修改购物车商品数量
if($type == 'editorBuyCarNum')
{
	$id = post('id');
	$num = post('num');
	$r = MysqlOneSelect('lgsc_mybuycar','num',"goodsid='$id' and userid= '$user[userid]'");
	if($r == -1){ exit();}
	if($r['num'] == $num){ exit(); }
	//查看商品库存
	$goods = MysqlOneSelect('lgsc_goods','housenum',"id='$id'");
	if($goods['housenum'] >= $num )
	{
		$rest = MysqlOneExc('lgsc_mybuycar',"num = $num",'update',"goodsid='$id'");
	}
}

//删除购物车商品
if($type == 'delBuyCarGoods')
{
	$id = post('id');
	echo "detele lgsc_mybuycar where userid= '$user[userid]' and goodsid in ($id')";
	$rest = MysqlDel('lgsc_mybuycar',"userid= '$user[userid]' and goodsid in ($id) ");
	if($rest){ echo 'success';}	
}
//购物车生成订单
if($type == 'Clearing')
{
	$_SESSION['clearingID'] = post('idArr');
}
//生成订单
if($type == 'createDD')
{
	$post = post('array');
	if($post['useintegral'] == ''){$post['useintegral'] = 0;}
	$post['createTime'] 	= time();
	$post['ddnum'] 			= time().rand(1000,9999);
	$post['userid'] 		= $user['userid'];
	$post['username'] 		= $user['username'];
	$post['goodsprice'] 	= '';
	$post['goodsnum']		= ''; 
	$post['goodsshopid']	= '';
	$post['goodsweight'] 	= '';
	unset($post['type']);
	$buycar = MysqlRowSelect('lgsc_mybuycar','num,price,shopid,weight',"userid = '$user[userid]' and  goodsid in ($post[goodsid])");
	if($buycar == -1){ echo 'error'; exit();}
	//生成商品信息
	for($i=0,$n=count($buycar);$i<$n;$i++)
	{
		$post['goodsprice']  .=  $buycar[$i]['price'].",";
		$post['goodsnum'] 	 .=  $buycar[$i]['num'].",";
		$post['goodsshopid'] .=  $buycar[$i]['shopid'].",";
		$post['goodsweight'] .=  $buycar[$i]['weight'].",";
	}
	$post['goodsnum'] = substr($post['goodsnum'],0,-1);
	$post['goodsprice'] = substr($post['goodsprice'],0,-1);
	$post['goodsshopid'] = substr($post['goodsshopid'],0,-1);
	$post['goodsweight'] = substr($post['goodsweight'],0,-1);
	$rest = MysqlOneExc('lgsc_dd',$post);
	if($rest){ 
		unset($_SESSION['clearingID']);
		//删除购物车
		MysqlDel('lgsc_mybuycar',"goodsid in ($post[goodsid]) and userid = '$user[userid]'");
		$_SESSION['ddnum'] = $post['ddnum'];
		$_SESSION['ddsum'] = $post['sum']; 
		//积分记录操作
		if($post['useintegral'] != 0)
		{
			//增加使用记录
			MysqlOneExc('lgsc_integral',"userid='$user[userid]',btype=2,integral='$post[useintegral]',posttime=".time());
			//积分减少
			MysqlOneExc('lgsc_member',"integral = integral - $post[useintegral]",'update',"id='$user[userid]'");
		}
		//修改优惠卷状态
		if($post['Coupon'] != 0)
		{
			MysqlOneExc('lgsc_user_coupon',"statu=1",'update',"id='$post[Coupon]'");
		}
		echo 'success';
	}
}
//确认发货
if($type == 'SendGoods')
{
	$id = post('id');
	$dd = MysqlOneSelect('lgsc_dd','goodsstate',"userid='$user[userid]' and id = '$id'");
	if($dd != '-1' && $dd['goodsstate'] != 4 )
	{
		if($dd['goodsstate'] == '-1'){ $state = 2; }else{ $state = $dd['goodsstate'] + 1; }
		$GoodsState = isGoodsState($state);
		$NextState = isGoodsState($state+1);
		$rest = MysqlOneExc('lgsc_dd',"goodsstate = '$state'",'update',"id = '$id'");
		$rr = array('GoodsState'=>$GoodsState['tag'],'NextState'=>$NextState['tag']);
		if($rest){ echo json_encode($rr);}
	}
}
//钱包支付
if($type == 'walletPay')
{
	$id 		= post('id'); //订单ID
	$paypswd 	= md5(md5(post('paypswd')));
	$paymoney 	= post('payMoney');
	$falseNum 	= 5; //输入密码错误次数
	date_default_timezone_set('PRC'); //取服务器时间
	//判断秘密是否正确
	$userinfo = MysqlOneSelect('lgsc_member','payfalse,paypswd',"id='$user[userid]'");
	if($userinfo == '-1'){ echo '非法操作';exit(); }
	elseif($paypswd != $userinfo['paypswd'])
	{
		//记录当天错误次数
		if($userinfo['payfalse'] == '')
		{
			$payfalse = date('Y-m-d').",1";
			$rest = MysqlOneExc('lgsc_member',"payfalse = '$payfalse'",'update',"id='$user[userid]'");
			echo '密码输入错误,你还有'.($falseNum-1).'次机会';
			exit();
		}else{
			//查询当天错误次数
			$false = explode(',',$userinfo['payfalse']);
			//不是当天的记录
			if($false[0] != date('Y-m-d'))
			{
				$payfalse = date('Y-m-d').",1";
				$rest = MysqlOneExc('lgsc_member',"payfalse = '$payfalse'",'update',"id='$user[userid]'");
				echo '密码输入错误,你还有'.($falseNum-1).'次机会';
				exit();
			}else
			{
				//当天记录小于falseNum次,继续增加次数
				if($false[1] < $falseNum)
				{
					$payfalse = date('Y-m-d').",".($false[1]+1);
					$rest = MysqlOneExc('lgsc_member',"payfalse = '$payfalse'",'update',"id='$user[userid]'");
					if($false[1] == $falseNum - 1 )
					{
						echo '密码输入错误,请明天尝试';
					}else
					{
						echo '密码输入错误,你还有'.($falseNum - $false[1] - 1).'次机会';
					}
					exit();
				}
				//超过错误次数 禁止支付
				else{
					echo '你已'.$falseNum.'次输入错误,请明天尝试';
					exit();
				}
			}
		}
	}
	elseif($userinfo['payfalse'] != '')
	{
		$false = explode(',',$userinfo['payfalse']);
		if($false[0] == date('Y-m-d') && $false[1] == $falseNum )
		{
			echo '你已'.$falseNum.'次输入错误,请明天尝试';
			exit();
		}
	}
	//减去余额
	$rest = MysqlOneExc('lgsc_member',"money = money - $paymoney",'update',"id='$user[userid]'");
	//记录余额操作记录
	$rest = MysqlOneExc('lgsc_balance',"money = '$paymoney',userid='$user[userid]',btype='2',posttime=".time());
	
	//操作订单客户状态 —— 更改为已付款状态
	$rest = MysqlOneExc('lgsc_dd','userstate = 1,goodsstate = 1','update',"id='$id'");
	/*
	//操作用户积分记录
	$dd = MysqlOneSelect('lgsc_dd','getintegral',"id='$id'");
	$addIntegral = $dd['getintegral'];
	if($addIntegral != 0 )
	{
		//得到积分记录
		MysqlOneExc('lgsc_integral',"userid='$user[userid]',btype=1,integral='$addIntegral',posttime=".time());
		//增加积分
		MysqlOneExc('lgsc_member',"integral = integral + $addIntegral",'update',"id='$user[userid]'");
	}
	*/
	echo 'success';
	
}
?>