<?php 
if(!defined('IN_MEMBER')) exit('Request Error!'); 

$user_type= $dosql->GetOne("select usertype from #@__member where username = '$c_uname'");
	

if($user_type['usertype'] == 1){ 
	header('location:/member/shop/');  //商家
	exit();
}else if($user_type['usertype'] == 2){ 
	header('location:/member/community/');  //社区
	exit();
}else{
	header('location:/member/person/');   //个人
	exit();
}
		
?>
