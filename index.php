<?php 
require_once(dirname(__FILE__).'/Common/index.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg_webname; ?></title>
<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/templates/default/js/jquery.min.js"></script>
<script type="text/javascript" src="/templates/default/js/member.js"></script>
</head>


<?php 
	$shop = MysqlRowSelect('lgsc_shops','id',"shop_prov='$city'",'9999');
	$shopid = '';
	$where = '';
	if($shop != '-1')
	{
		for($i=0,$n=count($shop);$i<$n;$i++)
		{
			$shopid .= $shop[$i]['id'].",";
		}
		$shopid = substr($shopid,0,-1);
		$where = "and shopid in ( $shopid )";
	}
?>	
<body>
<!--顶部公共-->
<?php require_once(dirname(__FILE__).'/public/header.php'); ?>
<div class="itop"> 
	<!-- 轮播图 -->   
    <div class="banner">
		<div class="flexslider">
        <ul class="slides">
        	<?php
			$dosql->Execute("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='1' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid DESC LIMIT 0,10");
			while($row = $dosql->GetArray())
			{
				if($row['linkurl'] != ''){
					$gourl = $row['linkurl'];
				}else{
					$gourl = 'javascript:;';
				}
			?>
            <li style="background:url(<?php echo $row['picurl']; ?>) center top no-repeat;"><a href="<?php echo $gourl; ?>"></a></li>
            <?php
			}
			?>
        </ul>
		</div>
      	<script type="text/javascript" src="/js/jquery.flexslider-min.js"></script> 
      	<script type="text/javascript">
                $(document).ready(function(){
                    $('.flexslider').flexslider({
                    directionNav: true,
                    pauseOnAction: false
                    });
                });
		</script> 
	</div>
    
    <!-- banner右图层 -->
    <div class="banner_pos">
        <div class="banner_r">
        	<div class="banner_rc">
            	<ul class="btn_dj">
                	<li class="btn_jdbg1"><a href="/goods.php">我要购买</a></li>
                	<li class="btn_jdbg1"><a href="/member.php?c=reg&t=1">商家入驻</a></li>
                	<li class="btn_jdbg2"><a href="/help.php?cid=19">帮助中心</a></li>
                	<li class="btn_jdbg2"><a href="/feedback.php">投诉建议</a></li>
                </ul>
                <div class="divclear"></div>
                <!--优惠卷-->
                <div class="yhj_pic">
                	<?php
					$dosql->Execute("SELECT id,picurl,title FROM `#@__coupon` WHERE picurl !='' AND checkinfo='true' and starttime <= unix_timestamp(now()) and endtime >= unix_timestamp(now()) and validity_end >= unix_timestamp(now()) and (hasnum<num or num=0) ORDER BY orderid DESC, id desc LIMIT 2");
					while($row = $dosql->GetArray())
					{
                		echo '<a href="javascript:;" onclick="getcoupon('.$row['id'].')" ><img src="'.$row['picurl'].'" width="180" height="80"></a>';
					}
					?>
                </div>
                <div class="tz_qh">
                	<div>
                        <span class="t_left">通知公告</span>
                        <span class="t_right more">
                            <a href="/news.php?cid=25">更多<em>&raquo;</em></a>
                        </span>
                        <div class="divclear"></div>
                    </div>
                    <ul>
                    	<?php 
						$dosql->Execute("SELECT id,classid,title,posttime,linkurl FROM `#@__infolist` WHERE classid ='25' AND delstate='' AND checkinfo=true ORDER BY id DESC LIMIT 8");
						while($row = $dosql->GetArray())
						{
							//获取链接地址
							if($row['linkurl']==''){
								$gourl = 'newsshow.php?cid='.$row['classid'].'&id='.$row['id'];
							}else{
								$gourl = $row['linkurl'];
							}
						?>
						<li><a href="<?php echo $gourl;?>" title="<?php echo $row['title']?>" target="_blank"><?php echo ReStrLen($row['title'],12); ?></a></li>
						<?php
						}
						?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 内容 -->
<div class="icontent">
	<div class="icontent_c">
    	<!-- 优惠 -->
    	<ul class="tj_type">
        	<?php
			$dosql->Execute("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='2' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid DESC LIMIT 4");
			while($row = $dosql->GetArray())
			{
				$gourl = 'javascript:;';
				if($row['linkurl'] != ''){
					$gourl = $row['linkurl'];
				}			
			echo '<li><a href="'.$gourl.'"><img src="'.$row['picurl'].'" /></a></li>';
			}
			?>
        </ul>
        <div class="divclear"></div>
		<!-- 当季热卖 -->
        <div class="tjt">
        	<span class="tjl1">
            <?php
            $row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='4' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
            $gourl = 'javascript:;';
            if(is_array($row)){
                if($row['linkurl'] != ''){
                    $gourl = $row['linkurl'];
                }
				echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" /></a>';
            }
            ?>
            </span>
        	<span class="tjl2">
            	<div class="sg_t1">
                	<?php
					$row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='5' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
					$gourl = 'javascript:;';
					if(is_array($row)){
						if($row['linkurl'] != ''){
							$gourl = $row['linkurl'];
						}
						echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" /></a>';
					}
					?>
                </div>
            	<div class="sg_t2">
                	<?php
					$row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='6' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
					$gourl = 'javascript:;';
					if(is_array($row)){
						if($row['linkurl'] != ''){
							$gourl = $row['linkurl'];
						}
						echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" /></a>';
					}
					?>
                </div>
            </span>
        	<span class="tjl3">
            	<?php
				$row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='7' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
				$gourl = 'javascript:;';
				if(is_array($row)){
					if($row['linkurl'] != ''){
						$gourl = $row['linkurl'];
					}
					echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" /></a>';
				}
				?>
            </span>
        	<span class="tjl2">
            	<div class="sg_t1">
                	<?php
					$row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='8' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
					$gourl = 'javascript:;';
					if(is_array($row)){
						if($row['linkurl'] != ''){
							$gourl = $row['linkurl'];
						}
						echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" /></a>';
					}
					?>
                </div>
            	<div class="sg_t2">
                	<?php
					$row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='9' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
					$gourl = 'javascript:;';
					if(is_array($row)){
						if($row['linkurl'] != ''){
							$gourl = $row['linkurl'];
						}
						echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" /></a>';
					}
					?>
                </div>
            </span>
            <div class="divclear"></div>
        </div>
        <!-- 1F -->
        <div>
        	<div class="floor_bt">
            	<div class="floor_left"><span class="floor_one">1F</span>农产品</div>
                <span class="floor_more"><a href="javascript:;">查看更多</a></span>
                <div class="divclear"></div>
            </div>
            <div class="fl_onetype">
            	<span class="onetype_f1">
                	<a href="/goods.php?oncid=1&twcid=4"><img src="images/ncp_01.png" /></a>
                </span>
            	<span class="onetype_f2">
                	
                	<div class="s1">
                    	<!--广告-->
						<?php
                        $row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='14' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
                        $gourl = 'javascript:;';
                        if(is_array($row)){
                            if($row['linkurl'] != ''){
                                $gourl = $row['linkurl'];
                            }
                            echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" /></a>';
                        }
                        ?>
                    </div>
                    <div class="s2"><a href="/goods.php?oncid=1&twcid=5"><img src="images/ncp_03.png"></a></div>
                </span>
            	<span class="onetype_f3"><a href="/goods.php?oncid=1&twcid=6"><img src="images/ncp_04.png"></a></span>
            	<span class="onetype_f4"><a href="/goods.php?oncid=1&twcid=7"><img src="images/ncp_05.png"></a></span>
            	<span class="onetype_f5"><a href="/goods.php?oncid=1&twcid=8"><img src="images/ncp_06.png"></a></span>
                <div class="divclear"></div>
            </div>
        </div>
        <!-- 2F -->
        <div>
        	<div class="floor_bt">
            	<div class="floor_left"><span class="floor_two">2F</span>食品</div>
                <span class="floor_more"><a href="javascript:;">查看更多</a></span>
                <div class="divclear"></div>
            </div>
            <div class="fl_twotype">
           	  <span class="twotype_f1">
                <div class="s1"><a href="/goods.php?oncid=1&twcid=9"><img src="images/sp_01.png"></a></div>
                <div class="s2"><a href="/goods.php?oncid=1&twcid=10"><img src="images/sp_06.png"></a></div>
              </span>
           	  <span class="twotype_f2">
                <div class="s3">
                	<!--广告-->
					<?php
                    $row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='15' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
                    $gourl = 'javascript:;';
                    if(is_array($row)){
                        if($row['linkurl'] != ''){
                            $gourl = $row['linkurl'];
                        }
                        echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" /></a>';
                    }
                    ?>                    
                </div>
                <div class="s1 t_left"><a href="/goods.php?oncid=1&twcid=11"><img src="images/sp_07.png"></a></div>
                <div class="s2 t_left"><a href="/goods.php?oncid=1&twcid=12"><img src="images/sp_08.png"></a></div>
              </span>
           	  <span class="twotype_f3">
              	<div class="s1"><a href="/goods.php?oncid=1&twcid=13"><img src="images/sp_03.png"></a></div>
                <div class="s2"><a href="/goods.php?oncid=1&twcid=14"><img src="images/sp_09.png"></a></div>
              </span>
           	  <span class="twotype_f4">
              	<div class="s1"><a href="/goods.php?oncid=1&twcid=15"><img src="images/sp_04.png"></a></div>
                <div class="s2"><a href="/goods.php?oncid=1&twcid=16"><img src="images/sp_010.png"></a></div>
              </span>
           	  <span class="twotype_f5">
              	<div class="s1"><a href="/goods.php?oncid=1&twcid=17"><img src="images/sp_05.png"></a></div>
                <div class="s2"><a href="/goods.php?oncid=1&twcid=18"><img src="images/sp_11.png"></a></div>
              </span>
                <div class="divclear"></div>
            </div>
        </div>
        <!-- 3F -->
        <div>
        	<div class="floor_bt">
            	<div class="floor_left"><span class="floor_three">3F</span>小商品</div>
                <span class="floor_more"><a href="javascript:;">查看更多</a></span>
                <div class="divclear"></div>
            </div>
            <div class="fl_threetype">
           	  <span class="threetype_f1">
                <div class="s1"><a href="/goods.php?oncid=1&twcid=19"><img src="images/xsp_01.png"></a></div>
                <div class="s2"><a href="/goods.php?oncid=1&twcid=20"><img src="images/xsp_06.png"></a></div>
              </span>
           	  <span class="threetype_f2">
                <div class="s3">
                	<!--广告-->
					<?php
                    $row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='16' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
                    $gourl = 'javascript:;';
                    if(is_array($row)){
                        if($row['linkurl'] != ''){
                            $gourl = $row['linkurl'];
                        }
                        echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" /></a>';
                    }
                    ?>                   
                </div>
                <div class="s1 t_left"><a href="/goods.php?oncid=1&twcid=21"><img src="images/xsp_07.png"></a></div>
                <div class="s2 t_left"><a href="/goods.php?oncid=1&twcid=22"><img src="images/xsp_08.png"></a></div>
              </span>
           	  <span class="threetype_f3"><a href="/goods.php?oncid=1&twcid=23"><img src="images/xsp_03.png"></a></span>
           	  <span class="threetype_f4">
              	<div class="s1"><a href="/goods.php?oncid=1&twcid=24"><img src="images/xsp_04.png"></a></div>
                <div class="s2"><a href="/goods.php?oncid=1&twcid=25"><img src="images/xsp_09.png"></a></div>
              </span>
           	  <span class="threetype_f5"><a href="/goods.php?oncid=1&twcid=26"><img src="images/xsp_05.png"></a></span>
                <div class="divclear"></div>
            </div>
        </div>
        <!-- 通栏广告位一 -->
		<div class="advert">
        <?php
		$row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='10' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
		$gourl = 'javascript:;';
		if(is_array($row)){
			if($row['linkurl'] != ''){
				$gourl = $row['linkurl'];
			}
			echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" width="1200" height="110" /></a>';
		}
		?>
        </div>
        <!-- 热销、推荐、喜欢 -->
        <div>
        	<div class="type_qhbt">
                <span></span>
                <ul>
                    <li class="on"><a>推荐商品</a></li>
                    <li><a>热销商品</a></li>
                    <li><a>猜你喜欢</a></li>
                </ul>
                <div class="divclear"></div>
            </div>
            <div>
                <div>
                    <ul class="type_qhul">
                    	<?php
						$dosql->Execute("SELECT id,title,description,salesprice,marketprice,linkurl,picurl FROM `#@__goods` WHERE `flag` LIKE '%t%' and checkinfo='true' and `delstate`='' $where ORDER BY orderid desc, id desc limit 12");
						while($row = $dosql->GetArray())
						{
							if(!empty($row['linkurl'])){
								$gourl=$row['linkurl'];	
							}else{
								$gourl='goodsshow.php?id='.$row['id'];	
							}
							if(!empty($row['picurl'])){
								$picurl=$row['picurl'];	
							}else{
								$picurl='/images/nopic.jpg';	
							}
						?>
                        <li>
                        <a href="<?php echo $gourl?>" title="<?php echo $row['title']?>" target="_blank">
                            <div class="type_qhpic"><img src="<?php echo $picurl?>"></div>
                            <div class="type_qhtext">
                                <div class="type_by"><?php echo ReStrLen($row['title'],15); ?></div>
                                <div class="type_ckjg">
                                    <span class="t_left"><i>¥</i><?php echo $row['salesprice']?></span>
                                    <span class="t_right">¥<?php echo $row['marketprice']?></span>
                                    <div class="divclear"></div>
                                </div>
                            </div>
                        </a>
                        </li>
                        <?php
						}
						?>
                    </ul>
                    <div class="divclear"></div>
                </div>
                <div style="display:none;">
                    <ul class="type_qhul">
                        <?php
						$dosql->Execute("SELECT id,title,description,salesprice,marketprice,linkurl,picurl FROM `#@__goods` WHERE  `flag` LIKE '%r%' and checkinfo='true' and `delstate`='' $where ORDER BY orderid desc, id desc  limit 12");
						while($row = $dosql->GetArray())
						{
							if(!empty($row['linkurl'])){
								$gourl=$row['linkurl'];	
							}else{
								$gourl='goodsshow.php?id='.$row['id'];	
							}
							if(!empty($row['picurl'])){
								$picurl=$row['picurl'];	
							}else{
								$picurl='/images/nopic.jpg';	
							}
						?>
                        <li>
                        <a href="<?php echo $gourl?>" title="<?php echo $row['title']?>" target="_blank">
                            <div class="type_qhpic"><img src="<?php echo $picurl?>"></div>
                            <div class="type_qhtext">
                                <div class="type_by"><?php echo ReStrLen($row['title'],15); ?></div>
                                <div class="type_ckjg">
                                    <span class="t_left"><i>¥</i><?php echo $row['salesprice']?></span>
                                    <span class="t_right">¥<?php echo $row['marketprice']?></span>
                                    <div class="divclear"></div>
                                </div>
                            </div>
                        </a>
                        </li>
                        <?php
						}
						?>
                    </ul>
                    <div class="divclear"></div>
                </div>
                <div style="display:none;">
                    <ul class="type_qhul">
                        <?php
						$dosql->Execute("SELECT id,title,description,salesprice,marketprice,linkurl,picurl FROM `#@__goods` WHERE  checkinfo='true' and `delstate`='' $where ORDER BY rand() limit 12");
						while($row = $dosql->GetArray())
						{
							if(!empty($row['linkurl'])){
								$gourl=$row['linkurl'];	
							}else{
								$gourl='goodsshow.php?id='.$row['id'];	
							}
							if(!empty($row['picurl'])){
								$picurl=$row['picurl'];	
							}else{
								$picurl='/images/nopic.jpg';	
							}
						?>
                        <li>
                        <a href="<?php echo $gourl?>" title="<?php echo $row['title']?>" target="_blank">
                            <div class="type_qhpic"><img src="<?php echo $picurl?>"></div>
                            <div class="type_qhtext">
                                <div class="type_by"><?php echo ReStrLen($row['title'],15); ?></div>
                                <div class="type_ckjg">
                                    <span class="t_left"><i>¥</i><?php echo $row['salesprice']?></span>
                                    <span class="t_right">¥<?php echo $row['marketprice']?></span>
                                    <div class="divclear"></div>
                                </div>
                            </div>
                        </a>
                        </li>
                        <?php
						}
						?>
                    </ul>
                    <div class="divclear"></div>
                </div>
            </div>
        </div>
        <div class="divclear"></div>
        <script type="text/javascript">
			$(".type_qhbt ul li").mouseenter(function(){
				$(this).addClass('on').siblings().removeClass('on');
				var i = $(this).index();
				$(".type_qhbt").siblings().children().eq(i).css('display','block');
				$(".type_qhbt").siblings().children().eq(i).siblings().css('display','none');
			});
		</script>
        <!-- 店铺展示 -->
        <div>
        	<div class="dpzs_bt">店铺展示</div>
            <div class="dpzs_lb">
            	<ul>
                	<?php
					$dosql->Execute("SELECT id,shopname,shop_logo FROM `#@__shops` WHERE  indexshow='true' ORDER BY id  desc limit 10");
					while($row = $dosql->GetArray())
					{
						if(!empty($row['shop_logo'])){
							$picurl=$row['shop_logo'];	
						}else{
							$picurl='/images/nopic.jpg';	
						}
					?>
                	<li><a href="/shops.php?id=<?php echo $row['id']?>"><img src="<?php echo $picurl;?>"></a></li>
                    <?php
					}
					?>
                </ul>
                <div class="divclear"></div>
            </div>
        </div>
        <!-- 广告 -->
        <div class="advert">
        <?php
		$row = $dosql->GetOne("SELECT linkurl,picurl FROM `#@__admanage` WHERE classid='11' AND picurl !='' AND admode='image' AND checkinfo='true' ORDER BY orderid asc, id desc");
		$gourl = 'javascript:;';
		if(is_array($row)){
			if($row['linkurl'] != ''){
				$gourl = $row['linkurl'];
			}
			echo '<a href="'.$gourl.'"><img src="'.$row['picurl'].'" width="1200" height="90" /></a>';
		}
		?>
        </div>
    </div>
</div>



<!-- 底部 -->
<?php require_once(dirname(__FILE__).'/public/footer.php'); ?>

<script type="text/javascript">
function getcoupon(val){
	//alert(val);
	<?php
	if(empty($_COOKIE['username']) || empty($_COOKIE['lastlogintime']) || empty($_COOKIE['lastloginip'])){
		echo 'alert("请登陆后再领取！");location.href="/member.php";return false;';				
	}else{
		$c_uname     = AuthCode($_COOKIE['username']);
		$row = $dosql->GetOne("SELECT id FROM `#@__member` WHERE `username`='$c_uname'");
		//当记录出现错误，强制跳转
		if(!isset($row) or !is_array($row)){
			header('location:/');
			exit();
		}
	?>
	$.ajax({
		url : "/ajax.php?a=getcoupon&val="+val+"&userid=<?php echo $row['id']?>",
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
	<?php
	}
	?>
}   
</script>
</body>
</html>