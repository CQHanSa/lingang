<?php
set_time_limit(30);//无限请求超时时间 
require_once(dirname(dirname(__FILE__)).'/Common/index.php');
$uid = post('uid');
$time = time() - 60*5;
$socket = MysqlRowSelect('lgsc_socket','*'," (  touserid = '$uid' )  and state = '0' order by createTime asc");
$issocket = MysqlOneSelect('lgsc_socket','*',"touserid = '$uid' and state = '0' ");
if($socket == '-1')
{
	sleep(1);
	exit();
}
else
{
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
		if($socket[$i]['touserid'] != $uid)
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
?>