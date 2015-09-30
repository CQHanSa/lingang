<?php
require_once('../../Common/index.php');
if($user == ''){ header('location:/member/buy/mybuycar.php');}
if(!isset($_SESSION['clearingID'])){ header('location:/member/buy/mybuycar.php');}
$r_user = MysqlOneSelect('lgsc_member','integral',"id='$user[userid]'");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>确认订单信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php include_once($path.'/Public/css.php'); ?>
<link href="/css/title.css" rel="stylesheet" type="text/css" />

<?php include_once($path.'/Public/js.php'); ?>
<script type="text/javascript" src="/js/style.buy.js"></script>
<script>
$(function(){
	SumOrder();
})
</script>

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
            	<li class="on">
                	<span class="t_left">2</span>
                    <span class="t_left">确认订单信息</span>
                    <span class="t_right"></span>
                    <div class="divclear"></div>
                </li>
            	<li>
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
<div class="contain">
<div class="conter">
<div class="frist">
<div class="first_t"><P>请仔细填写并核对订单信息</P></div>
<div class="first_f">
<p>支付方式</p><div class="first_ff on"><a class="hand"><font>在线支付</font></a></div><div class="first_ft"><a class="hand"><font>钱包支付</font></a></div></div>
</div>
<div class="xinxi">
<div class="xinxi_t">
<div class="t_left"><p>收货人信息</p></div><div class="t_right"><a href="#" ><p>新增收货地址</p></a></div></div>
<div class="xinxi_m">
<ul>

<?php
$address = MysqlRowSelect('lgsc_user_address','*',"userid='$user[userid]'");
if($address != -1)
{
	for($i=0,$n=count($address);$i<$n;$i++)
	{
		$class   = '';
		$content = '';
		if($address[$i]['isdefault'] == 'true'){ $class ='class="on"'; $content= '<a class="hand"><div class="xinxi_mm"><font>默认地址</font></div></a>';}
		if($address[$i]['userphone'] != ''){ $address[$i]['userphone'] = ' / '.$address[$i]['userphone']; }
?>
    <li <?=$class?>>
       	<?=$content?>
        <div class="xinxi_mn">
            <div class="xinxi_ml">
            	<p class="hand">
                    <span class="username"><?=$address[$i]['username']?></span>&nbsp;
                    <span class="prov"><?=one_cas($address[$i]['address_prov'])?></span>&nbsp;
                    <span class="city"><?=one_cas($address[$i]['address_city'])?></span>&nbsp;
                    <span class="country"><?=one_cas($address[$i]['address_country'])?></span>&nbsp;
                    <span class="address"><?=$address[$i]['address']?></span>&nbsp;
                    <span class="usermobile"><?=$address[$i]['usermobile']?><?=$address[$i]['userphone'] ?></span>
                </p></div>
            <div class="xinxi_mk"><a href="#">编辑&nbsp;&nbsp;</a><a href="#">删除</a></div>
        </div>
    </li>
<?php
	}
}
?>    

</ul>
</div>
<div class="xinxi_f"><a class="hand">收起地址<img src="/images/jiesuan7.png"></a></div>
</div>
<div class="qindan">
<div class="qindan_t"><div class="t_left"><p>送货清单</p></div><div class="t_right"><a href="#"><p>返回修改购物车</p></a></div></div>
<input type="hidden" value="<?=$_SESSION['clearingID']?>" name="goodsid"  />
<?php
$idArr = $_SESSION['clearingID'];
//unset($_SESSION['clearingID']);
$shop = MysqlRowSelect('lgsc_mybuycar,lgsc_shops','*',"lgsc_shops.id=lgsc_mybuycar.shopid and lgsc_mybuycar.goodsid in ($idArr) and lgsc_mybuycar.userid='$user[userid]' group by shopid");
if($shop != '-1')
{
	for($i=0,$n=count($shop);$i<$n;$i++)
	{
?>
<div class="qindan_n">
	<div class="qindan_ml">
    <div class="qindan_mt"><p>配送方式</p></div>
    <div class="qindan_qh sendway">
        <div class="qindan_mk on"><p>取货点自提</p></div>
        <div class="qindan_mq"><p>送货上门</p></div>
    </div>
<div class="divclear"></div>
<div class="qindan_mm">
<ul>
<li><font>取货地点：重庆后堡站</font><div class="t_right"><a href="#"><font style="color:#005ea7;">修改</font></a></div></li>
<li><font>取货时间：7月25日[周六]</font><div class="t_right"><a href="#"><font style="color:#005ea7;">修改</font></a></div></li>
</ul>
</div>
<div class="qindan_mf"><p>运费：<font style="color:#e4393b;">¥12.00</font></p></div>
</div>
<div class="qindan_mr">
<div class="qindan_mmt"><p>商家：<?=$shop[$i]['shopname']?></p></div>
        <div class="qindan_ma">
        	<?php
			$goodsRows = MysqlRowSelect('lgsc_mybuycar,lgsc_goods','lgsc_goods.id,lgsc_goods.picurl,lgsc_goods.title,lgsc_mybuycar.price,lgsc_mybuycar.weight,lgsc_mybuycar.num',"lgsc_mybuycar.goodsid = lgsc_goods.id and lgsc_mybuycar.userid = '$user[userid]' and lgsc_mybuycar.shopid = ".$shop[$i]['id']);
			?>
            <ul id="first">
            <?php
			for($j=0,$k=count($goodsRows);$j<$k;$j++)
			{
            	echo '<li><img src="/'.$goodsRows[$j]['picurl'].'" width="100" height="84"><p>'.$goodsRows[$j]['title'].'</p></li>';
			}
			?>
            <div class="divclear"></div>
            </ul>
        
            <ul>
            <?php
			for($j=0,$k=count($goodsRows);$j<$k;$j++)
			{
            	echo '<li><div class="red"><p>¥<span>'.$goodsRows[$j]['price'].'</span></p></div><div class="jifen"><p>赠<span>'.Redeem($goodsRows[$j]['price'],$user).'</span>积分</p></div></li>';
			}
			?>
             <div class="divclear"></div>
            </ul>
        
            <ul>
            <?php
			for($j=0,$k=count($goodsRows);$j<$k;$j++)
			{
            	echo '<li><p>x<span>'.$goodsRows[$j]['num'].'</span></p></li>';
			}
			?>
             <div class="divclear"></div>
            </ul>
        
            <ul>
            <?php
			for($j=0,$k=count($goodsRows);$j<$k;$j++)
			{
            	echo '<li><p>有货</p></li>';
			}
			?>
             <div class="divclear"></div>
            </ul>
            
            <div class="divclear"></div>
        </div>
</div>
<div class="divclear"></div>
</div>
<?php
	}
}
?>

<div class="divclear"></div>
<div class="qindan_f">
添加订单备注&nbsp;&nbsp;&nbsp;<input type="text" value="" style=" width:509px; height:30px;">&nbsp;&nbsp;&nbsp;提示：请勿填写有关支付、收货、发票方面的信息

</div>
<div class="divclear"></div>
</div>
<div class="fapiao">
<p>申请发票</p>
<div class="fapiao_l"><input type="submit" value="立即申请" style="width:75px; height:24px;color:#FFF; background:#519409;">
</div>
</div>
<div class="youhui">
<div class="youhui_t"><div class="youhui_tt"><a href="#">+</a></div>&nbsp;<font style="color:#164ac1;">使用优惠券</font></div>
<div class="youhui_f"><div class="youhui_tt"><a href="#">-</a></div>&nbsp;<font style="color:#164ac1;">使用积分</font>
<div class="youhui_ff">

<font style="font-weight:bold;">本次使用&nbsp;&nbsp;<input type="text" value="" style=" width:70px; height:24px;" class="useIntegral" onKeyUp="useIntegral(this)">&nbsp;&nbsp;积分&nbsp;&nbsp;</font>
<!--<input type="submit" value="使用" style="width:62px; height:24px; background:#e77917;border-radius:5px; color:#FFF;">-->
<p>您有积分<font style="font-weight:bold;" class='integral' ><?=$r_user['integral']?></font>个，本次可使用<font style="color:#e77917;"><?=$r_user['integral']?></font>个。</p>

</div>
</div>
</div>


<div class="second">
<div class="second_l">
<ul>
<li><span class="AllNum">3</span>件商品，总商品金额：¥<span class="GoodsPrice">0.00</span></li>
<li>获得积分：+<span class="getIntegral">0</span></li>
<li>使用积分：-<span class="useIntegral">0</span></li>
<li>运费：<font style="color:#e77917;">¥<span class="fare">12.00</span></font></li>
<li>应付总额：¥<span class="sum">0.00</span></li>
</ul>
</div>
</div>
<div class="two">
<div class="two_l">
<p style="font-size:16px;text-align:right;">应付总额：<font style=" color:#F00; font-size:25px; font-weight:bold;">¥<b class="sum" style=" font-size:25px;">200.00</b>&nbsp;&nbsp;</font><input type="submit" value="立即结算" class="hand" id='dd' style="width:117px; height:61px;color:#FFF; background:#519409; font-size:18px;"></p>
<p style="color:#e77917;">您购买的商品中有不属于平台或自提店的，请注意核实！</p>
</div>
</div>
<div class="last">
<div class="last_l">
<p>寄送至：
	<span class="prov"></span>&nbsp;
    <span class="city"></span>&nbsp;
    <span class="country"></span>&nbsp;
    <span class="address"></span>
</p>
<p>
	收货人：
   <span class="username"> </span>&nbsp;
   <span class="usermobile"></span>
 </p></div>
</div>
</div>
</div>
</div>
</div>
    
    <!-- 底部 -->
	<?php include_once($path."/public/footer.php") ?>


<!--弹出框-->
<div id="fullbg">
	<div class="shbox">
    	<h1>选择取货点<span class="close" id="close"><img src="/images/shc.jpg"></span></h1>
    	<div class="shform">
			<div class="shrow"><span>选择区域:</span><select><option>南岸区</option></select></div>
    		<div class="shrow"><span>选择自提点:</span><ul>
            <li><a>重庆后堡站</a><samp>重庆市南岸区宏声路37号洋河南滨花园9栋023-62535336</samp></li><li><a>社区二</a></li><li><a>社区三</a></li><li><a>社区四</a></li>
			<li><a>社区一</a></li>
          
            </ul>
            <span></span><div class="showmore zk"><a>展开更多</a></div><div class="showmore sq"><a>收起</a></div>
            </div>
            <div class="shrow"><span></span><input type="button" id="save" value="确认并保存"><input type="button" value="取消"></div>
    		<div class="endword">温馨提示：
            <p>1、自提货时付款，支持现金自付 查看自提流程</p>
            <p>2、临港根据您的收货地址显示其范围内的自提点，请确保您的收货地址正确填写</p>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="adv">
<!---->
<script>
$(document).ready(function(){
	$('.sq').hide();
	$('.sq').click(function(){
		$(this).hide();
		$('.zk').show();
   		$('.shform .shrow ul').css({'height':'116px','overflow':'hidden'});
    });
	$('.zk').click(function(){
		$(this).hide();
		$('.sq').show();
   		$('.shform .shrow ul').css({'height':'auto','overflow':'auto'});
    });
	
	var thisaddress;
	$('.qindan_mk').click(function(){
		$('.shrow ul li').removeClass('on');
		$('#fullbg').show();
	});
	$('#close').click(function(){
		$('#fullbg').hide();
		});
	$('#save').click(function(){
		if($('#adv').val()!='')
		{
		$('#fullbg').hide();
		$('.set_address').text($('#adv').val());
		}
		else
		{
		alert('请重新选择');
		}
	});
	$('.shrow ul li').click(function(){
		
		$(this).addClass('on').siblings().removeClass('on');
		$('#adv').val($(this).find('a').text());
		
	});
	
	})

</script>



</body>
</html>
