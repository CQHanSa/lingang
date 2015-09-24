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
//显示当天的聊天信息
if($type == 'socketShowDay')
{
	$uid = post('userid');
	$userid = AuthCode($_COOKIE['userid'],'DECODE');
	$day = date("Y-m-d",time());
	$minTime = strtotime($day." 0:0:0");
	$maxTime = strtotime($day." 23:59:59");
	$socket = MysqlRowSelect('lgsc_socket','*'," (userid = '$userid' and touserid = '$uid' ) or ( userid = '$uid' and touserid = '$userid' )  and ( createTime >= '$minTime' and createTime <= '$maxTime' ) and state = 1 order by createTime asc");
	if($socket == '-1'){exit();}
	$write = '';
	for($i=0,$n=count($socket);$i<$n;$i++)
	{
		MysqlOneExc('lgsc_socket','state=1','update',"id=".$socket[$i]['id']);
		$member = MysqlOneSelect('lgsc_member','avatar,username,cnname',"id=".$socket[$i]['userid']);
		$shop = MysqlOneSelect('lgsc_shops','shopname,shop_username',"userid=".$socket[$i]['userid']);
		if($shop != -1)
		{
			$name = $shop['shopname']."-".$member['cnname'] ;
		}else
		{
			$name = $member['username'];
		}
		if($socket[$i]['touserid'] != $userid)
		{
			$write .= '<div class="im-item im-me">';
			$td = '<td class="lm"></td>';
		}else
		{
			$write .= '<div class="im-item im-others">';
			$td ='<td class="lm"><span></span></td>';
		}
		$write .= '
        	<div class="im-message clearfix">
                <div class="im-user-area">
                    <a class="im-user-pic" href="#">
                        <img class="userPic" src="/'.$member['avatar'].'" alt="京东客服"><img class="im-user-pic-cap" src="/images/socket/cap48.png" alt=""></a>
                </div>
             	<div class="im-message-detail">
                	<table cellspacing="0" cellpadding="0" border="0" class="im-message-table">
                    	 <tbody>   
                         	<tr>      
                            	<td class="lt"></td>     
                                <td class="tt"></td>     
                                <td class="rt"></td> 
                             </tr>
                             <tr> 
                             	'.$td.'
                                <td class="mm">
                                	<div class="im-message-title">
                                    	<p class="im-message-owner"><span class="im-txt-bold">'.$name.'</span></p>	
                                        <span class="im-send-time">'.date("Y-m-d h:i:s",$socket[$i]['createTime']).'</span>
                                     </div> 
                                     <div class="im-message-content"> 	
                                     	<p><div style="color: rgb(0, 0, 0); font-family: 宋体;">'.$socket[$i]['message'].'</div></p> 
                                     </div> 
                                  </td> 
                                  <td class="rm"><span></span></td>
                             </tr>
                             <tr>        
                             	<td class="lb"></td>           
                                <td class="bm"></td>            
                                <td class="rb"></td>        
                             </tr>     
                         	</tbody>   
                    </table>
               </div>
            </div>
        </div>';
	}
	echo $write;
	
	
}

//全站显示会员聊天信息
if($type == 'queryMessage')
{
	$user['userid']  = AuthCode($_COOKIE['userid'],'DECODE');
	$socket = MysqlRowSelect('lgsc_socket','userid,toshopid',"touserid = '$user[userid]' and state = '0' group by userid",'1000');
	if($socket == '-1') { echo 'error'; exit();}
	for($i=0,$n=count($socket);$i<$n;$i++)
	{
		$socketUser = MysqlOneSelect('lgsc_member','username,cnname',"id=".$socket[$i]['userid']);
		$socketShop = MysqlOneSelect('lgsc_shops','shopname',"id=".$socket[$i]['userid']);
		$name =  $socketUser['cnname'] != '' ? $socketUser['cnname']  : $socketUser['username'];
		if($socketShop != '-1'){ $name = $socketShop['shopname'];}
		$r = MysqlOneSelect('lgsc_socket','count(*) as total',"state = '0' and touserid='$user[userid]' and userid=".$socket[$i]['userid']);
		$socketTotal = $r['total'];
	?>
    <li>
        <a class="hand" onclick="Open('/socket.php?sid=<?=$socket[$i]['toshopid']?>&uid=<?=$socket[$i]['userid']?>')">
        <?=$name?><font color="#FF0000">(<?=$socketTotal?>条未读消息)</font></a>
    </li>
    <?php
    }        
}
?>