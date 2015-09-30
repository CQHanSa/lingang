<?php 
if(!defined('IN_MEMBER')) exit('Request Error!'); 
$userinfo = MysqlOneSelect('lgsc_member','money',"id='$user[userid]'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $cfg_webname; ?> - <?php echo $web_title?></title>
<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/css/order.css"/>
<link rel="stylesheet" type="text/css" href="/css/member.css">
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="/templates/default/js/member.js"></script>
<script type="text/javascript" src="/js/click.js"></script>

</head>

<body>
<!-- 顶部信息 -->
<?php include_once("../../public/top.php") ?>

<!-- logo+搜索 -->
<?php include_once("../../public/logo_search.php") ?>

<!-- 导航菜单栏 -->
<?php include_once("../../public/menu.php") ?>

<div class="icontent">
	<div class="icontent_c">
    	<!-- 当前位置 -->
    	<div class="order_top">
        	当前位置：<a href="/">首页</a>&gt;<a href="/member/person/"><?php echo $web_title?></a>
        </div>
        
        <?php include_once("./leftinfo.php") ?>
        
        <div class="w985 fr">
        	<!--会员基本信息-->
        		<div class="memberinfo">
                	<div class="mem_photo fl">
                    	<dl>
                        	<?php 
							if(!empty($r_user['avatar'])){
								$avatar=$r_user['avatar'];
							}else{
								$avatar='images/default_avatar.jpg';	
							}
							?>
                        	<dt><img src="/<?php echo $avatar?>"></dt>
                        	<dd><strong class="name f18"><?php echo $r_user['username']?></strong></dd>
                            <dd>
                            <?php
							$userstars=1;
                            $dosql->Execute("SELECT * FROM `#@__usergroup`");
							while($row2 = $dosql->GetArray())
							{
								if($r_user['expval'] >= $row2['expvala'] and $r_user['expval'] <= $row2['expvalb'])
								{
									//$usergroup = $row2['groupname'];
									$userstars = $row2['stars'];
								}
							}
							for($i=1;$i<=$userstars;$i++){
								echo '<img src="/images/xin.png">';
							}
							?>
                            </dd>
                            <?php
                            if($r_user['password_strength']=='1'){
								$password_strength=' style="width:30%;"';	
							}else if($r_user['password_strength']=='2'){
								$password_strength=' style="width:80%;"';	
							}else if($r_user['password_strength']=='3'){
								$password_strength=' style="width:100%;"';	
							}else{
								$password_strength=' style="width:10%;"';	
							}
							?>
                            <dd>账户安全<span><div <?php echo $password_strength;?>></div></span><?php if($r_user['password_strength']<3){echo '<a href="?action=editpswd" class="blue_link">提升</a>';}?></dd>
                        </dl>
                    </div>
                    <div class="mem_orderdetail fr">
                    	<ul><li><a><img src="/images/ms01.png"><p>待付款<span class="red-color f14">4</span></p></a></li>
                        <li><a><img src="/images/ms02.png"><p>待收货<span class="red-color f14">0</span></p></a></li>
                        <li><a><img src="/images/ms03.png"><p>待自提<span class="red-color f14">0</span></p></a></li>
                        <li><a><img src="/images/ms04.png"><p>待评价<span class="red-color f14">0</span></p></a></li>
                        </ul>
                        <div class="mem_money">
                        	<p><a href="?action=balance">钱包余额：<?=$userinfo['money']?></a></p>
                            <p><a href="?action=coupon">优惠券：<?=CollectionNums($user,'coupon')?></a></p>
                        </div>
                    </div>
                </div>
        	<!--会员基本信息结束-->
            <!--我的订单-->
            <div class="divclear"></div>
            <div class="mt20"></div>
            <div class="myorder fl bgf5">
            	<div class="title"><strong class="f16 fl">我的订单</strong><a class="fr">查看全部订单</a></div>
            	<div class="divclear"></div>
                <div class="myorderlist  w660">
            		<ul><li>
                    <table border="0" cellpadding="0" cellspacing="0">
                		<tr class="line">
                    		<td width="210"><a><img src="/images/mo01.jpg"></a></td>
                            <td width="85">李丽丽</td>
                           	<td width="80"><span class="red-color">￥58.00</span><br>
                            <a>在线支付</a>
                            </td>
                            <td width="100"><span class="time">2015-07-27 15:51:47</span></td>
                            <td width="110"><a class="fk">等待付款</a><br/>
							<a class="gz">跟踪</a></td>
                            <td><a class="blue_link">查看</a></td>
                        </tr>
                    </table>
                    </li>
                    <li>
                    <table border="0" cellpadding="0" cellspacing="0">
                		<tr class="line">
                    		<td width="210"><a><img src="/images/mo01.jpg"></a></td>
                            <td width="85">李丽丽</td>
                           	<td width="80"><span class="red-color">￥58.00</span><br>
                            <a>在线支付</a>
                            </td>
                            <td width="100">2015-07-27 15:51:47</td>
                             <td width="110"><a class="fk">等待付款</a><br/>
							<a class="gz">跟踪</a></td>
                            <td><a class="blue_link">查看</a></td>
                        </tr>
                    </table>
                    </li>
                    <li>
                    <table border="0" cellpadding="0" cellspacing="0">
                		<tr class="line">
                    		<td width="210"><a><img src="/images/mo01.jpg"></a></td>
                            <td width="85">李丽丽</td>
                           	<td width="80"><span class="red-color">￥58.00</span><br>
                            <a>在线支付</a>
                            </td>
                            <td width="100">2015-07-27 15:51:47</td>
                            <td width="110"><a class="fk">等待付款</a><br/>
							<a class="gz">跟踪</a></td>
                            <td><a class="blue_link">查看</a></td>
                        </tr>
                    </table>
                    </li>
                    </ul>
                </div>
            </div>
            	<!--我的订单结束-->
                  <!--会员推荐-->
            <div class="fr w305 bgf5">
            	<div class="title"><strong class="fl f16">会员推荐</strong></div>
                <div class="divclear"></div>
                <div class="hytj">
                	<ul>
                    	<?php
                    	$temp='<li><a href="/goodsshow.php?id=[!--id--]" title="[!--title--]"><img src="/[!--picurl--]" width="67" height="67"><span>[!--title--]</span></a></li>';
						$sql = goodsShowAI($user,"lgsc_goodscollection");
						if($sql != '-1'){
							echo listTemp($temp,'lgsc_goods',$sql);
						}						
						?>
                    </ul>
                </div>
            </div>
            <div class="divclear"></div>
            <div class="mt20"></div>
               <div class="mycollect fl bgf5">
                    <div class="title"><strong class="f16 fl">我收藏的商品</strong><a class="fr" href="?action=goodsCollection">查看全部收藏</a></div>
                    <div class="divclear"></div>
                    <div class="mycollectlist w660">
                    	<ul>
                        <?php 
						$temp='
                        <li><a href="/goodsshow.php?id=[!--id--]"><img src="/[!--picurl--]" width="140" height="140" >
                        <p>[!--title--]...</p>
                        <strong class="f16 red-color">￥[!--salesprice--]</strong>
                        </a></li>';
						echo listTemp($temp,'lgsc_goodscollection,lgsc_goods',"( lgsc_goodscollection.goodsid = lgsc_goods.id ) and lgsc_goodscollection.userid='$user[userid]'",$limit='4');
						?>
                        </ul>
                    </div>
               </div>
               <!--我收藏的商品结束-->
               
               <div class="fr w305 bgf5">
                    <div class="title"><strong class="fl f16">浏览历史</strong><!--<a class="fr">查看更多</a>--></div>
                    <div class="divclear"></div>
                    <div class="history">
                    <ul>
                    <?php
                   	$temp2='<li><a href="/goodsshow.php?id=[!--id--]"><img src="/[!--picurl--]" width="60" height="60" /><p>￥[!--salesprice--]</p></a></li>';
					echo listTemp($temp2,'lgsc_scanlog,lgsc_goods',"( lgsc_scanlog.goodsid = lgsc_goods.id ) and lgsc_scanlog.userid='$user[userid]'",'8');
                    ?>
                    </ul>
                    </div>
               </div>
        	<!--推荐商品-->
            <div class="divclear"></div>
             <div class="splb_ul tj_goods mt20 bgf5">
             <div class="title">
             <strong class="f16 fl">推荐商品</strong>
             <a class="fr">查看全部推荐</a>
             <div class="divclear"></div>
             </div>
        	<ul>
            	<?php
				$temp='
            	<li><a href="/goodsshow.php?id=[!--id--]">
                	<div class="sp_pic"><img src="/[!--picurl--]" width="210" height="200"></div>
                    <div class="sp_jg">¥[!--salesprice--]</div>
                    <div class="sp_wb">[!--title--]...</div>
                    <div class="sp_xl">
                    	<span class="t_left">销量：<i>[!--salenum--]</i></span>
                        <span class="t_right">累计评价：<i>[!--assess--]</i></span>
                        <div class="divclear"></div>
                    </div>
                    <div class="sp_jrgwc"><a>加入购物车</a></div>
                </a></li>';
				$sql = goodsShowAI($user,"lgsc_scanlog");
				if($sql != '-1'){
					echo listTemp($temp,'lgsc_goods',$sql,4);
				}
				?>
             </ul><div class="divclear"></div>
             </div>
             
            <!--推荐商品结束-->
        </div>
    </div>
</div>

<!-- 底部 -->
<?php include_once("../../public/footer.php") ?>
</body>
</html>
