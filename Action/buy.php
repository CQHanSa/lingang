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
	$post['createTime'] = time();
	$post['ddnum'] = rand(10000000000,9999999999);
	$post['userid'] = $user['userid'];
	$post['username'] = $user['username'];
	$post['goodsprice'] = '';
	$post['goodsnum'] = ''; 
	$buycar = MysqlRowSelect('lgsc_mybuycar','num,price',"goodsid in ($post[goodsid]) and userid = '$user[userid]'");
	unset($post['type']);
	for($i=0,$n=count($buycar);$i<$n;$i++)
	{
		$post['goodsprice'] .=  $buycar[$i]['price'].",";
		$post['goodsnum'] .=  $buycar[$i]['num'].",";
	}
	$post['goodsnum'] = substr($post['goodsnum'],0,-1);
	$post['goodsprice'] = substr($post['goodsprice'],0,-1);
	$rest = MysqlOneExc('lgsc_dd',$post);
	if($rest){ 
		unset($_SESSION['clearingID']);
		MysqlDel('lgsc_mybuycar',"goodsid in ($post[goodsid]) and userid = '$user[userid]'");
		$_SESSION['ddnum'] = $post['ddnum'];
		$_SESSION['ddsum'] = $post['sum']; 
		echo 'success';
	}
}
?>