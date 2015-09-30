<div class="itop">
    <!--top 2-->
    <?php
    $week= array('日','一','二','三','四','五','六');
	?>
	<div class="itop_login">
    	<div class="itop_loginc">
        	<span class="t_left">送货至&nbsp; <span class="send_address"><span><?php
            $row = $dosql->GetOne("SELECT dataname FROM `#@__cascadedata` WHERE `datagroup`='area' and level='0' and datavalue='$city'");
			if(isset($row['dataname']) && is_array($row)){
				echo ReStrLen($row['dataname'],3,''); 	
			}
			?></span>
            <div class="ads_lb">
                	<ul>
                    	<?php
                        $dosql->Execute("SELECT datavalue,dataname FROM `#@__cascadedata` WHERE `datagroup`='area' and level='0'  ORDER BY orderid ASC, datavalue ASC");
						while($row = $dosql->GetArray())
						{
						?>
                    	<li <?php if($city==$row['datavalue']){echo ' class="on"';}?>><a href="javascript:;" onclick="changecity(<?php echo $row['datavalue']?>)"><?php echo ReStrLen($row['dataname'],3,''); ?></a></li>
                        <?php
						}
						?>
                    </ul>
                    <div class="divclear"></div>
                </div>
             </span>&nbsp; &nbsp; &nbsp; &nbsp; 您好！欢迎进入临港大市场&nbsp; &nbsp;  <span><?php echo date('Y年m月d日');?></span>&nbsp; <?php echo '星期'.$week[date('w')];?></span>   
            <span class="t_right">
            	<ul>
                	<?php
                    if(!empty($_COOKIE['username']) && !empty($_COOKIE['lastlogintime']) && !empty($_COOKIE['lastloginip'])){
						echo '<li><a href="/member.php">'.AuthCode($_COOKIE['username']).'</a> <a href="/member.php?a=logout">退出</a></li>';
						$c_uname = AuthCode($_COOKIE['username']);
						$usertype=@$_COOKIE['usertype'];
						$usertype = isset($usertype)  ? $usertype : 1;
						$r_usertype = $dosql->GetOne("SELECT usertype FROM `#@__member` WHERE `username`='$c_uname'");
						if($r_usertype['usertype']=='1'){
							if(substr(dirname($_SERVER['SCRIPT_NAME']),8) =='shop'){
								echo '<li><a href="/member/person/">买家中心</a></li>';
							}else{
								echo '<li><a href="/member/shop/">商家中心</a></li>';
							}
						}
					}else{
						echo '<li>请<a href="/member.php?c=login"><i>登录</i></a> <a href="/member.php?c=reg">免费注册</a></li>';	
					}
					?>
                	<li><a href="/member.php">我的订单</a></li>
                	<li><a href="/help.php">帮助中心</a><a><span><?php echo $cfg_hotline?></span></a><a class="tub_bg tub_sj" href="/wap/">手机</a></li>
                	<li><a href="/member.php" class="tub_bg tub_sc">收藏</a></li>
                </ul>
            </span>
            <div class="divclear"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
function changecity(val){
	$.ajax({
		url : "/ajax.php?a=changecity&val="+val+"",
		type:'get',
		dataType:'html',
		success:function(data){
			if(data==1){
				window.location.reload();
			}else{
				alert("参数错误！");	
			}	
		}
	})
}
</script>