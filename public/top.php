<div class="itop">
    <!--top 2-->
    <?php
    $week= array('日','一','二','三','四','五','六');
	?>
	<div class="itop_login">
    	<div class="itop_loginc">
        	<span class="t_left">送货至&nbsp; <span class="send_address"><span>重庆</span>
            <div class="ads_lb">
                	<ul>
                    	<li><a href="javascript:;">北京</a></li>
                    	<li><a href="javascript:;">上海</a></li>
                    	<li><a href="javascript:;">天津市</a></li>
                    	<li class="on"><a href="javascript:;">重庆</a></li>
                    	<li><a href="javascript:;">河北</a></li>
                    	<li><a href="javascript:;">江苏</a></li>
                    	<li><a href="javascript:;">四川</a></li>
                    	<li><a href="javascript:;">湖南</a></li>
                    	<li><a href="javascript:;">江苏</a></li>
                    	<li><a href="javascript:;">四川</a></li>
                    	<li><a href="javascript:;">湖南</a></li>
                    	<li><a href="javascript:;">湖北</a></li>
                    	<li><a href="javascript:;">云南</a></li>
                    	<li><a href="javascript:;">湖北</a></li>
                    	<li><a href="javascript:;">云南</a></li>
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