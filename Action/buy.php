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
				if($n != 1){ $n += 1; }
				setcookie("buyCar[$n][id]",AuthCode($post['goodsid'],'ENCODE'),time()*3600*24,'/');
				setcookie("buyCar[$n][num]",AuthCode($post['num'],'ENCODE'),time()*3600*24,'/');
				setcookie("buyCar[$n][shopid]",AuthCode($post['shopid'],'ENCODE'),time()*3600*24,'/');
				echo '添加购物车成功';
			}else{
				echo '已经加入购物车';
			}
		}
		else{
			setcookie('buyCar[0][id]',AuthCode($post['goodsid'],'ENCODE'),time()*3600*24,'/');
			setcookie('buyCar[0][num]',AuthCode($post['num'],'ENCODE'),time()*3600*24,'/');
			setcookie('buyCar[0][shopid]',AuthCode($post['shopid'],'ENCODE'),time()*3600*24,'/');
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
?>