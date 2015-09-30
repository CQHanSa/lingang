<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $cfg_webname; ?> - <?php echo $web_title?></title>

<?php include_once($path.'/Public/css.php'); ?>

<link rel="stylesheet" type="text/css" href="/css/syle.css"/>
<link rel="stylesheet" type="text/css" href="/css/order.css"/>

<?php include_once($path.'/Public/js.php'); ?>

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
    	
		<!--内容-->       
		<div class="contain">

            <!-- 当前位置 -->
            <div class="order_top">
                当前位置：<a href="/">首页</a>&gt;<a href="/member/shop"><?php echo $web_title?></a>
            </div>
            
            <?php include_once("./leftinfo.php") ?>
            
            <div class="contain_r">
                <div class="contain_rt">
                    <div class="contain_rl">
                        <div class="t_left"><div class="avatar">
                        <?php 
						if(!empty($r_shop['shop_logo'])){
							$avatar=$r_shop['shop_logo'];
						}else{
							$avatar='images/default_avatar.jpg';	
						}
						?>
                        <img src="/<?php echo $avatar?>">
                        </div></div>
                        <div class="t_left" style="margin-left:10px; display:inline; line-height:30px; padding-top:5px;">
                            <p style="font-size:18px;"><?php echo $r_shop['shopname']?></p>
                            <p>公司名称：<?php echo $r_shop['shopcompany']?></p>
                            <p>店铺状态：<?php
                            if($r_user['checkinfo']=='true'){
								if($r_shop['checkinfo']=='true'){
									echo '营业中';
								}else{
									echo '休息中';	
								}
							}else{
								echo '审核中';	
							}
							?></p>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="contain_rr">
                        <ul>
                            <li><img src="/images/zhongxin3.png"><p>商品描述<font>0分</font></p></li>
                            <li><img src="/images/zhongxin4.png"><P>时效评分<font>0分</font></P></li>
                            <li><img src="/images/zhongxin5.png"><P>服务评分<font>0分</font></P></li>
                        </ul>
                    </div>
                    <div class="contain_ra">
                        <font>联系方式</font>
                        <p>店主：<?php echo $r_shop['shop_username']?></p>
                        <p>电话：<?php echo $r_shop['shop_tel']?></p>
                        <p>邮箱：<?php echo $r_user['email']?></p>
                    </div>
                    <div class="clear"></div>
                </div>
                
                <div class="shopinfo_title">店铺提示</div>
                <div class="shopinfo_list">
                	<div class="shopinfo_list_title">您需要关注的店铺情况</div>
                    <div class="shopinfo_list_info">商品提示：
                        待审核的商品（<span><?php
						$dosql->Execute("SELECT `id` FROM `#@__goods` WHERE `checkinfo`='false'");
						echo $dosql->GetTotalRow();
						?></span>）&nbsp;&nbsp;
                        仓库中的商品（<span><?php
						$dosql->Execute("SELECT `id` FROM `#@__goods` WHERE `issale`='false'");
						echo $dosql->GetTotalRow();
						?></span>）&nbsp;&nbsp;
                        出售中的商品（<span><?php
						$dosql->Execute("SELECT `id` FROM `#@__goods` WHERE `checkinfo`='true'");
						echo $dosql->GetTotalRow();
						?></span>）
                    </div>
                </div>
                
                <div class="shopinfo_title">交易提示</div>
                <div class="shopinfo_list">
                	<div class="shopinfo_list_title">您需要立即处理的交易订单</div>
                    <div class="shopinfo_list_info">订单提示：
                        等待确认的订单（<span>0</span>）&nbsp;&nbsp;
                        等待付款的订单（<span>0</span>）&nbsp;&nbsp;
                        等待发货的订单（<span>0</span>）&nbsp;&nbsp;
                        等待收货的订单（<span>0</span>）&nbsp;&nbsp;
                        已完成的订单（<span>0</span>）
                    </div>
                </div>
                
            </div>
            
            <div class="clear"></div>
		</div>
    </div>
</div>

<!-- 底部 -->
<?php include_once("../../public/footer.php") ?>
</body>
</html>
