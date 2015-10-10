<?php
require_once('../../Common/index.php');
$web_name="钱包支付";

if(isset($_GET['id']))
{
	$id = get('id');
	$dd = MysqlOneSelect('lgsc_dd','*',"id='$id' and userid = '$user[userid]'");
}
elseif(isset($_SESSION['ddnum']) && isset($_SESSION['ddsum']) )
{
	$money = $_SESSION['ddsum'];
	$ddnum = $_SESSION['ddnum'];
	$userid = $user['userid'];
	$dd = MysqlOneSelect('lgsc_dd','*',"ddnum='$ddnum' and userid = '$user[userid]'");
}
else{
	header('location:/');
	exit();	
}
if($dd == '-1'){ die('支付出错');}
$userinfo = MysqlOneSelect('lgsc_member','money,paypswd',"id='$dd[userid]'");
if($userinfo['paypswd'] == ''){ Message('请先设置支付密码','/member/person/?action=editpaypswd');}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$web_name?></title>

<?php include_once($path.'/Public/css.php'); ?>
<link href="/css/body.css" rel="stylesheet" type="text/css"  />

<?php include_once($path.'/Public/js.php'); ?>

</head>
<body>
<!-- 顶部 -->
<?php require_once($path.'/public/header.php'); ?> 

<div class="icontent">
<div class="icontent_c"> 
  <!-- 购买流程 顺序 -->
  <div class="gmlc_sx">
        	<ul>
            	<li>
                	<span class="t_left">1</span>
                    <span class="t_left">查看购物车</span>
                    <span class="t_right"></span>
                    <div class="divclear"></div>
                </li>
            	<li>
                	<span class="t_left">2</span>
                    <span class="t_left">确认订单信息</span>
                    <span class="t_right"></span>
                    <div class="divclear"></div>
                </li>
            	<li class="on">
                	<span class="t_left">3</span>
                    <span class="t_left">付款到临港商城</span>
                    <span class="t_right"></span>
                    <div class="divclear"></div>
                </li>
            	<li>
                	<span class="t_left">4</span>
                    <span class="t_left">确认收货</span>
                    <span class="t_right"></span>
                    <div class="divclear"></div>
                </li>
            	<li>
                	<span class="t_left">5</span>
                    <span class="t_left">评价商品</span>
                    <div class="divclear"></div>
                </li>
            </ul>
        </div>
  <!--内容-->
  <div class="contain" style="height:450px;">
    <div class="conter">
<script type="text/javascript">
	$(function(){
		$('.order_tjt span').click(function(){
			if($(this).hasClass('clk1'))
			{
				$(this).addClass('clk2').removeClass('clk1');
			}
			else
			{
				$(this).addClass('clk1').removeClass('clk2');
			}
			$('.ord_ads').stop().slideToggle('fast');
		});
	})
</script>
    	<div class="fk_cont">
      <div class="order_tj">
      	<div class="order_tjt">                
            <div class="t_left">
            	<dl>
                	<dt>订单提交成功，请您尽快付款！订单号：<span class="ord_num"><?=$dd['ddnum']?></span></dt>
                    <dd>请您在提交订单后<i>24</i>小时内完成支付，否则订单会自动取消。 </dd>
                </dl>
            </div>
            <div class="t_right">
            	<div>应付金额<i> <?=$dd['sum']?> </i>元</div>
                <span class="clk1">展开详情</span>
            </div>
            <div class="divclear"></div>
        </div>
        <div class="ord_ads">收货地址：<?=$dd['address_prov'].$dd['address_city'].$dd['address_country'].$dd['address']?>
        					 收货人：<?=$dd['username']?> <?=$dd['usermobile']?><br/>
<!--商品名称：【山之风】番茄/大柿子 密云西红柿500g 生态新鲜蔬菜  【山之风】番茄/大柿子 密云西红柿500g 生态新鲜蔬菜--></div>
      </div>
      <div class="qb_zf">
      	<span class="t_left">
        	<dl>
            	<dt>钱包支付 <a href="/member/person/?action=balance_recharge" style="margin-left:280px;" class="hand" >钱包充值</a></dt>
                <dd><input type="password" placeholder="请输入钱包密码" class="qb_pwd"></dd>
                <dd>
                	<input type="submit" class="sub_zf" value="立即支付" onClick="walletPay(<?=$dd['id']?>)">
                	<input type="button" class="clo_zf" onClick="CloseWebPage();" value="放弃支付">
                </dd>
            	
            </dl>
        </span>
        <span class="t_right">
        	<dl>
            	<dt>支付<i class="sum"> <?=$dd['sum']?> </i>元</dt>
                <dt>钱包余额<i class="walletMoney"> <?=$userinfo['money']?> </i>元</dt>
                <dt style="margin-top:40px;"><input type="button" class="sub_zf" onClick="window.location.href='/data/api/unionpay/unionpay.config2.php?id=<?=$dd['id']?>'" value="在线支付" style="width:170px"></dt>
            </dl>
        </span>
        <div class="divclear"></div>
      </div>
      </div>
    </div>
  </div>
</div>
<!-- 底部 -->
<?php include_once($path."/public/footer.php") ?>
</body>
</html>
