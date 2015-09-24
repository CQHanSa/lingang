<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="优惠券管理";

$s = isset($s) ? intval($s) : 0;
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
<script type="text/javascript" src="/templates/default/js/jquery.min.js"></script>
<script type="text/javascript" src="/templates/default/js/member.js"></script>
<script type="text/javascript" src="/templates/default/js/getuploadify.js"></script>
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
        	当前位置：<a href="/">首页</a>&gt;<a href="/member/person"><?php echo $web_title?></a>&gt;<?php echo $web_name?>
        </div>
        
        <?php include_once("./leftinfo.php") ?>
        
        <div class="w985 fr bgf5">
        	<!---->
        	<div class="counp">
            	<div class="coutitle">
                	<div class="fl usestate">
                    <ul>
                        <li <?php if($s=='0')echo 'class="cur"';?>><a href="?action=coupon&s=0">未使用</a></li>
                        <li <?php if($s=='1')echo 'class="cur"';?>><a href="?action=coupon&s=1">已使用</a></li>
                        <li <?php if($s=='2')echo 'class="cur"';?>><a href="?action=coupon&s=2">已过期</a></li>
                    </ul>
                    </div>
                    <div class="fr"><a href="?action=getcoupon" style="color:#F00;">领取优惠卷</a></div>
                    <div class="divclear"></div>
                </div>
				<div class="counplist">
                	<ul>
                        <?php
						
						
                        $sql = "SELECT u.id,c.price,c.overprice,c.classid,c.validity_strat,c.validity_end FROM `#@__user_coupon` as u left join `#@__coupon` c on u.couponid=c.id WHERE u.userid='".$r_user['id']."'";	
						
						if($s=='0') $sql .= " AND u.statu='0'  and c.validity_end > unix_timestamp(now())";
						
						if($s=='1') $sql .= " AND u.statu='1'";
					
						if($s=='2') $sql .= " AND u.statu='0' and c.validity_end < unix_timestamp(now())";
						
						$sql .= " order by u.id desc";
						
						
						$dopage->GetPage($sql,16);
						while($row = $dosql->GetArray())
						{
							//分类名称
							$r = $dosql->GetOne("SELECT `classname` FROM `#@__goodstype` WHERE `id`=".$row['classid']);
							if(isset($r['classname'])){
								$classname = $r['classname'].'类使用';
							}else{
								$classname = '不限';
							}
						?>
                        <li>
                        <div class="coupon_bj">
                        	<div class="coupon_top">
                            	<div class="coupon_price">￥<span><?php echo $row['price']?></span></div>
                            </div>
                            <div class="coupon_tj">
                            使用条件：订单满<?php echo $row['overprice']?>元可用<br />
                            使用范围：<?php echo $classname;?><br />
							有效时间：<?php echo date('Y-m-d',$row['validity_strat'])?>至<?php echo date('Y-m-d',$row['validity_end'])?>
							</div>
                        </div>
                        <div class="del"><a href="?action=coupon_del&id=<?php echo $row['id']?>">删除<img src="/images/del.png"></a></div>
                        </li>
                        <?php
						}
						?>
                    </ul>
                	<div class="divclear"></div>
                </div>
                
                <?php echo $dopage->GetList(); ?>
             </div>
             <div class="divclear"></div>
            <!--推荐商品结束-->
        </div>
        
    </div>
</div>

<!-- 底部 -->
<?php include_once("../../public/footer.php") ?>
<script type="text/javascript">

$(".addtype_ej li").hover(function(){
	$(this).addClass('one');
},function(){
	$(this).removeClass('one');
});
</script>
</body>
</html>
