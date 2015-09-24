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
<div class="contain_rl"><div class="t_left"><img src="/images/zhongxin2.png"></div><div class="t_right"><p style="font-size:18px;">王大锤</p><p>店铺名称：萌果果cutiefamily旗舰店</p><p>店铺状态：已开启，<a href="#" style="color:#0048b5;">展示中</a></p></div></div>
<div class="contain_rr">
<ul>
<li><img src="/images/zhongxin3.png"><p>商品描述<font>0分</font></p></li>
<li><img src="/images/zhongxin4.png"><P>时效评分<font>0分</font></P></li>
<li><img src="/images/zhongxin5.png"><P>服务评分<font>0分</font></P></li>
</ul>
</div>
<div class="contain_ra">
<font>平台联系方式</font>
<p>电话：15302315624</p>
<p>邮箱：123565@163.com</p>
<p>服务时间：8：00-20:00</p>
</div>
</div>
<div class="contain_rm">
<p>店铺提示</p>
<p>您需要关注的店铺情况</p>
<font>商品提示：<a href="#">待付款商品（<i>0</i>）</a><a href="#">&nbsp;&nbsp;仓库中的商品（<i>0</i>）</a><a href="#">&nbsp;&nbsp;出售中的商品（<i>0</i>）</a><a href="#">&nbsp;&nbsp;买家留言（<i>0</i>）</a></font>
</div>
<div class="contain_rf">
<p>交易提示</p>
<p>您需要立即处理的交易订单：</p>
<font>订单提示：<a href="#">待受理订单（<i>0</i>）</a><a href="#">&nbsp;&nbsp;代发货订单（<i>0</i>）</a><a href="#">&nbsp;&nbsp;待结束订单（<i>0</i>）</a><a href="#">&nbsp;&nbsp;周订量单（<i>0</i>）</a><a href="#">&nbsp;&nbsp;周交易金额（<i>0</i>）</a><a href="#">&nbsp;&nbsp;一个月订单量（<i>0</i>）</a><a href="#">&nbsp;&nbsp;一个月交易金额（<i>0</i>）</a></font>
</div>
</div>
</div>
<!-- 底部 -->
<?php include_once("../../public/footer.php") ?>
</body>
</html>
