<?php 
require_once(dirname(__FILE__).'/Common/index.php'); 

$id = isset($_GET['id']) ? intval(get('id')) : '';
if($id == '' && $type == ''){ message('该页面不存在','javascript:history.go(-1)');exit(); }
$r = MysqlOneSelect('lgsc_goods','*',"id = $id and issale = 'true' and  checkinfo =  'true' ");
if($r == '-1'){ message('商品未上架','javascript:history.go(-1)');exit();}
$shop = MysqlOneSelect('lgsc_shops','*',"id = $r[shopid]");

scanlog($user,$r['id']);

//购买须知
$shopNote = MysqlOneSelect('lgsc_shopsnote','content',"id = $r[shopid] and classid='0'");
$buythings = $shopNote['content'];
//分割店铺价格
$price = explode(',',$r['price']);
$marketprice = explode(',',$r['marketprice']);
$promotions_price = explode(',',$r['promotions_price']);
$guige = explode(',',$r['guige']);
//规格改变价格
if($type == 'changePrice')
{
	$num = get('num');
	$rr['price'] = $price[$num];
	$rr['marketprice'] = $marketprice[$num];
	$rr['promotions_price'] = $promotions_price[$num];
	echo json_encode($rr);
	exit();	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg_webname; ?></title>

<?php include_once($path.'/Public/css.php'); ?>
<link rel="stylesheet" type="text/css" href="css/detail.css"/>

<?php include_once($path.'/Public/js.php'); ?>
<script type="text/javascript" src="js/jquery.jqzoom.js"></script>
<script type="text/javascript" src="js/base.js"></script>
<script type="text/javascript" src="js/countdown.js"></script>
<script>
window.onload = function(){
	<?php
	if($r['promotions_endtime'] != '' && $r['promotions_endtime'] != '0')
	{
	?>
	$('#countdown-root').countdown([{
		endTime: "<?=date('Y-m-d h:i:s',$r['promotions_endtime'])?>",
		isStart: true
	}]);
	<?php
	}
	?>
	
	$("#county").change(function(){
		$.ajax({
			url : "/ajax.php?a=showcommunity&value="+$("#county").val(),
			type:'get',
			dataType:'html',
			success:function(data)
			{
					if(data  == 'null')
					{
						$(".send-content").text('该区域暂无货源');
						$(".detail_btn span").removeClass();
						$(".detail_btn span").addClass('cur1');
					}else{
						$(".send-content").html(data);
					}
					
					$("#community").change(function(){
						$.ajax({
							url : "/ajax.php?a=issendcommunity&value="+$("#community").val()+"&shopid="+<?=$r['shopid']?>,
							type:'get',
							dataType:'html',
							success:function(data)
							{
									if(data  == 'null')
									{
										$(".send-content span").text(' 无货');
										$(".detail_btn span").removeClass();
										$(".detail_btn span").addClass('cur1');
									}else{
										$(".send-content span").html(' '+data+'');
										$(".detail_btn span").removeClass();
										$(".detail_btn span").addClass('cur2');
									}
								
							}
						});
					})	
				
			}
		});
	})
		
}

//替换规格	
function changePrice(num)
{
	$.ajax({
		url:'goodsshow.php',
		type:'get',
		dataType:'json',
		data:'type=changePrice&num='+num+'&id='+<?=$id?>,
		success: function(rr)
		{
			//console.log($(".marketprice font").text());
			$(".marketprice font b").text(rr.marketprice);
			$(".promotions_price i label").text(rr.promotions_price);
			$(".price i label").text(rr.price);
		}
	})
}
</script>

</head>
<body>
	
<!-- 顶部 -->
<?php require_once(dirname(__FILE__).'/public/header.php'); ?> 

<!-- 选择分类 搜索 -->
<div class="icontent">
	<div class="icontent_c">
    	<div class="detail_left">
            <div class="pdetail_left">
            	<?php
				//判断显示缩略图或组图
				if(!empty($r['picarr']))
				{
					$picarr = unserialize($r['picarr']);
					$picarrBig = explode(',',$picarr[0]);
				}
				?>
                <div id="preview" class="spec-preview"> <span class="jqzoom"><img jqimg="<?php echo $picarrBig[0]; ?>" src="<?php echo $picarrBig[0]; ?>" width="420" height="420" /></span> </div>
                <!--缩图开始-->
                <div class="spec-scroll">
                  <div class="items">
                    <ul>
                    <?php
					foreach($picarr as $v)
					{
						$picarrSmall = explode(',',$v);
					?>
              		<li><img bimg="<?php echo $picarrSmall[0]; ?>" src="<?php echo $picarrSmall[0]; ?>" onmousemove="preview(this);"></li>
					<?php
					}
					?>
                    </ul>
                  </div>
                </div>
                <!--缩图结束-->
            </div>
            <div class="pdetail_c">
                <div class="detail_bt"><?=$r['title']?></div>
                <div class="detail_bj">
                    <dl>
                        <dt class="marketprice">价格： <font>¥<b><?=$marketprice[0]?></b></font></dt>
                        <?php if($r['promotions'] == 'true' && $r['promotions_endtime'] >= time() && $r['promotions_starttime'] <= time()  ){ ?>
                        <dt class="promotions_price">促销价：<i>¥<label style=" font-size:24px;"><?=$promotions_price[0]?></label></i>
                        	<div id="countdown-root" style="background:red; color:#fff; padding:0px 5px; width:200px; display:inline-block;" >
                            	<div class="countdown"></div>	
                            	<!--<span class="cx_time" id="dao">促销时间:<span id="RemainD">00</span>天<span id="RemainH">00</span>时<span id="RemainM">00</span>分<span id="RemainS">00</span>秒</span>-->
                        	</div>
                        </dt>
                        <?php }else{ ?>
                        <dt class="price">店铺价：<i>¥<label style=" font-size:24px;"><?=$price[0]?></label></i>
                        <?php } ?>
                        <!--<dt>本店活动：<em>满79元，包邮</em></dt>-->
                         <dt>配送至：
                         	<select name="city" id="city" onchange="showCity(this)" ><option value="-1">请选择</option><?=list_cas('-1','area')?></select>
                        	<select name="county" id="county"  onchange="showCounty(this)" ><option value="-1">请选择</option></select>
                            <select name="town" style="display:none;"><option value="-1">请选择</option></select>
                        </dt>
                        <dt class="send-content"></dt>
                        <dt class="send-content-tip"></dt>
                        <!--<dt>运费：重庆渝中区 至 <span class="fq_xz">重庆巴南区</span> 临港速递：12.00 （<em>自提取货无需运费</em>）</dt>-->
                    </dl>
                </div>
                <div class="detail_xl">
                <span>销量：<i>2864</i></span>|
                <span>累计评价：<i>5684</i></span>|
                <span class="integral">赠送积分：<i>30</i></span></div>
                <div class="detail_guige"><span>选择规格：</span>
                    <ul>
                    	<?Php 
						for($i=0,$n=count($guige);$i<$n;$i++)
						{
						?>
                        <li onclick="changePrice(<?=$i?>)"><?=$guige[$i]?></li>
                        <?php
						}
						?>
                    </ul>
                </div>
                
                <div class="buy_num">
                    <span>购买数量：</span>
                    <span class="num_sr">
                        <input type="text" class="num" value="1" >
                        <span onclick="updatedProducts(1, this);">+</span>
                        <span onclick="updatedProducts(-1, this);">-</span>
                        件
                    </span>
                    <span>库存：5874</span>
                </div>
                <div class="detail_btn">
                    <span class="cur1"><a onclick="addBuy(<?=$id?>,'nowBuy','this')" >立即购买</a></span>
                    <span class="cur1"><a onclick="addBuy(<?=$id?>,'addBuyCar','this')">加入购物车</a></span>
                </div>
                <div class="detail_fxsc">
                    <a>分享</a>
                    <a class="hand" onclick="addGoodsCollection(<?=$id?>)">收藏商品 （已有<?=CollectionNums($id)?>人收藏）</a>
                </div>
                
            </div>
            <div class="divclear"></div>
            <div class="detail_bl">
            	<div class="detail_pf">
                	<div class="detail_pft"><?=$shop['shopname']?></div>
                    <div class="detail_pfb">
                    	<div class="detail_zhpf">综合评分：<img src="images/images/detail_pf.png"> <i>5</i>分</div>
                        <dl class="detail_gzpf">
                        	<dt><span class="t_left"><b>店铺动态评分</b></span><span class="t_right">与行业相比</span>
                            <div class="divclear"></div></dt>
                            <dd><span class="t_left">描述相符&nbsp; 5分</span><span class="t_right">持平</span>
                            <div class="divclear"></div></dd>
                            <dd><span class="t_left">服务态度&nbsp; 5分</span><span class="t_right">持平</span>
                            <div class="divclear"></div></dd>
                            <dd><span class="t_left">发货速度&nbsp; 5分</span><span class="t_right">持平</span>
                            <div class="divclear"></div></dd>
                        </dl>
                        <dl>
                            <dt>联系方式：<?=$shop['shop_tel']?></dt>
                            <dt>所 &nbsp;在&nbsp;地：<?=one_cas($shop['shop_prov'])?> <?=one_cas($shop['shop_city'])?> <?=one_cas($shop['shop_town'])?><?=$shop['shop_address']?></dt>
                        </dl>
                        <div class="detail_jr">
                        	<a href="/shops.php?sid=<?=$shop['id']?>" target="_blank">进入商家店铺</a>
                            <a  class="hand"  onclick="addShopCollcetion(<?=$shop['id']?>)">收藏店铺<font>(<i><?=CollectionNums($shop['id'])?></i>)</font></a>
                        </div>
                    </div>
                </div>
            	<div class="detail_ph">
                    <div class="detail_pft">商品排行</div>
                    <div>
                        <ul class="spph_ul">
                            <li class="on">商品热销排行</li>
                            <li>热门收藏排行</li>
                        </ul>
                    </div>
                    <div>
                        <ul class="spphcont_ul">
                            <?php
							$temp='
                            <li>
                                <a href="/goodsshow.php?id=[!--id--]" target="_blank">
                                    <span class="t_left"><img src="[!--picurl--]" width="57" height="57"></span>
                                    <span class="t_right">
                                        <dl>
                                            <dt>[!--title--]</dt>
                                            <dt><i>¥[!--salesprice--]</i></dt>
                                            <dt>销量：105笔</dt>
                                        </dl>
                                        
                                    </span>
                                    <div class="divclear"></div>
                                </a>
                            </li>';
                            echo listTemp($temp,'lgsc_goods',"shopid=$r[shopid] and flag like '%r%' and issale = 'true' order by posttime desc",$limit='6');
							?>
                        </ul>
                        <ul class="spphcont_ul">
                        <?php
						   echo listTemp($temp,'lgsc_goods',"shopid=$r[shopid] and flag like '%r%' and issale = 'true' order by posttime desc",$limit='6');
						  ?>
                        </ul>
                    </div>
                   <!-- <div>
                        <span class="up_page">上一页</span>
                        <span class="down_page">下一页</span>
                        <div class="divclear"></div>
                    </div>-->
                </div>
            	<div class="detail_tj">
                    <div class="detail_pft">店主推荐商品</div>
                	<div class="detail_tjsp">
                    	<ul>
                        	<?php
							$temp2='
                        	<li><a href="/goodsshow.php?id=[!--id--]" target="_blank"><img src="[!--picurl--]" width="173" height="173">
                                <dl>
                                	<dt><i>¥[!--salesprice--]</i></dt>
                                    <dt>[!--title--]</dt>
                                    <dd>销量：100笔</dd>
                                </dl>
                            </a></li>';
							 echo listTemp($temp2,'lgsc_goods',"shopid=$r[shopid] and flag like '%r%' and issale = 'true' order by posttime desc",$limit='5');
							?>
                        </ul>
                    </div>
                </div>
                <?php
				$dosql->Execute("SELECT linkurl,picurl,target FROM `#@__shopad` WHERE shopid='".$shop['id']."' and classid='4' AND picurl !='' AND checkinfo='true' ORDER BY orderid DESC LIMIT 2");
				while($row = $dosql->GetArray())
				{
					if($row['linkurl'] != ''){
						$gourl = $row['linkurl'];
					}else{
						$gourl = 'javascript:;';
					}
				echo '<div class="detail_gg"><a href="'.$gourl.'" target="'.$row['target'].'"><img src="/'.$row['picurl'].'"></a></div>';			
				}
				?>
            </div>
            <div class="detail_br">
            	<!--<img src="images/images/spxx_01.png">
                <img src="images/images/spxx_02.png">-->
                <div class="pro_fl">
                	<ul>
                    	<li>产品描述</li>
                    	<li>评价详情</li>
                    	<li>购物须知</li>
                    </ul>
                </div>
                <div>
                	<div class="guige_cs">
                    	<!--
                         <dl>
                        	<dt>规格参数1</dt>
                            <dd>
                            	<ul>
                                	<li>生产许可证编号：131009012694</li>
                                	<li>产地: 重庆</li>
                                	<li>品牌: 鲜农乐</li>
                                	<li>系列: 玉米</li>
                                	<li>联系方式：010-60211950</li>
                                	<li>保质期：3 天</li>
                                	<li>净含量: 1600g</li>
                                	<li>包装方式: 散装</li>
                                </ul>
                                <div class="divclear"></div>
                            </dd>
                        </dl>
                        -->
                    	<?=htmlspecialchars_decode($r['content'])?>
                    </div>
                    <div class="guige_cs" style="display:none;">
                        <div class="detail_jspic">
                        <img src="images/images/spxx_01.png">
                		<img src="images/images/spxx_02.png">
                        </div>
                    </div>
                    <div class="guige_cs" style="display:none;">
						<?=$buythings?>
                    </div>
                </div>
            </div>
            <div class="divclear"></div>
        </div>
        <div class="pdetail_right">
        	<div class="pdetail_rightc">
            	<div class="pdetail_rightc_t">
                </div>
                	<ul class="pde_rul">
                        <?php
						$temp3='
						<li><a href="/goodsshow.php?id=[!--id--]" target="_blank">
                        	<img src="[!--picurl--]" width="135" height="135">
                            <dl>
                            	<dt>[!--title--]</dt>
                                <dt>¥[!--salesprice--]</dt>
                                <dd>售出：195523</dd>
                            </dl>
                        </a></li>
						';
						echo listTemp($temp3,'lgsc_goods',"shopid=$r[shopid] and flag like '%r%' and issale = 'true' order by posttime desc",$limit='6');
						?>
                    </ul>
                	
                <div></div>
            </div>
        </div>
        <div class="divclear"></div>
    </div>
</div>

<!-- 底部 -->
<?php require_once($path.'/public/footer.php'); ?>

</body>
</html>
