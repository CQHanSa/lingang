<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="领取优惠券";

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
                        <li><a>领取优惠卷</a></li>
                    </ul>
                    </div>
                    <div class="divclear"></div>
                </div>
				<div class="coupon_list">
                	<ul>
                        <?php
						$couponid='0';
						$dosql->Execute("SELECT couponid FROM `#@__user_coupon` WHERE  userid='".$r_user['id']."' ORDER BY id  desc");
						while($row = $dosql->GetArray())
						{
							$couponid .=','.$row['couponid'];
						}
											
						$sql="SELECT id,picurl,title FROM `#@__coupon` WHERE picurl !='' AND checkinfo='true' and starttime <= unix_timestamp(now()) and endtime >= unix_timestamp(now()) and validity_end >= unix_timestamp(now()) and (hasnum<num or num=0) and id not in($couponid) ORDER BY orderid DESC, id desc";
						$dopage->GetPage($sql,50);
						while($row = $dosql->GetArray())
						{
						?>
                        <li><a href="javascript:;" onclick="getcoupon(<?php echo $row['id']?>)" ><img src="/<?php echo $row['picurl']?>" width="180" height="80"></a></li>
                        <?php
						}
						?>
                    </ul>
                	<div class="divclear"></div>
                </div>
                <?php
                if($dosql->GetTotalRow() == 0)
				{
					echo '<div style="padding:20px;">暂时没有优惠卷可领。</div>';
				}else{
					echo $dopage->GetList();
				}
				?>
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

function getcoupon(val){
	
	$.ajax({
		url : "/ajax.php?a=getcoupon&val="+val+"&userid=<?php echo $r_user['id']?>",
		type:'get',
		dataType:'html',
		success:function(data){
			if(data==2){
				alert("此优惠券已被领完！");		
			}else if(data==3){
				alert("您已领取该优惠券！");		
			}else if(data==4){
				alert("领取成功！");			
			}else{
				alert("参数错误！");	
			}
		}
	})
}   
</script>
</body>
</html>
