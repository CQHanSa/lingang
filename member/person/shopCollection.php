<?php
require_once('../../Common/index.php');
$web_title = '店铺收藏';
if($user == ''){  header('location:/member/person/'); exit();}
$shopTotal = MysqlOneSelect('lgsc_shopcollection','count( * ) AS total',"userid = '$user[userid]'");
$num = 3;
$limit=pageLimit($page,$num);
$addsql = "lgsc_shopcollection.shopid = lgsc_shops.id and lgsc_shopcollection.userid = '$user[userid]'";
if(isset($_GET['keyword'])){ $keyword = get('keyword');  $addsql .= " and lgsc_shops.shopname like '%$keyword%'"; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<title><?php echo $cfg_webname; ?> - <?php echo $web_title?></title>
<?php include_once($path.'/Public/css.php'); ?>
<link rel="stylesheet" type="text/css" href="/css/order.css"/>
<link rel="stylesheet" type="text/css" href="/css/member.css">

<?php include_once($path.'/Public/js.php'); ?>

</head>

<body>
<!-- 顶部信息 -->
<?php include_once($path."/public/top.php") ?>

<!-- logo+搜索 -->
<?php include_once($path."/public/logo_search.php") ?>

<!-- 导航菜单栏 -->
<?php include_once($path."/public/menu.php") ?>


<div class="icontent">
	<div class="icontent_c">
    
    	<!-- 当前位置 -->
    	<div class="order_top">
        	当前位置：<a href="/">首页</a>&gt;<a href="/member/person/">个人中心</a>&gt;<?php echo $web_title?>
        </div>
                <?php include_once("./leftinfo.php") ?>
        <div class="w985 fr">
        	<div class="colltitle bgf5">
            	<div class="collcate fl">
                	<ul>
                        <li><a href="?action=goodsCollection">收藏的商品</a></li>
                        <li class="cur"><a href="?action=shopCollection">收藏的店铺</a></li>
                	</ul>
                </div>
            	<div class="coserach fr">
                	<form  method="get">
                    	<input type="hidden" value="shopCollection" name="action"  />
                		<input type="text" value="" placeholder="请输入店铺名称" name="keyword"><input type="submit" value="搜索" >
                	</form>
                </div>
           		<div class="divclear"></div>
                <!--<div class="cateselect">
                	<strong>分类筛选：</strong><span class="catelist"><a class="all cur">全部</a><a class="menu_gs1">时令蔬菜（7）</a><a class="menu_gs2">新鲜水果（3）</a><a class="menu_gs3">粮油米面</a><a class="menu_gs4">肉食蛋类</a><a class="menu_gs5">海鲜水产</a><a class="menu_gs6">干货海味</a><a class="menu_gs7">休闲副食</a></span><span class="more"><a>更多</a></span>
                </div>
                <div class="dpnum">
                	<a class="red-color">全部店铺</a>（10）
                </div>-->
             </div>
             
             <div class="mt20">
        	<!--收藏店铺列表-->
			<div class="collgoods bgf5">
             	<div class="collgtitle">
                <div class="fl">
             		<!--<span class="all_xz"><a><label><input type="checkbox">全选</label></a></span>-->
                    <!--<span class="qx_xz"><a class="blue_link">取消选择</a></span>-->
                </div>
                <div class="fr cpage">
                <!--<span class="red-color"><i>1</i>/1</span><a class="c_left"></a><a class="c_nextpage">下一页</a>-->
                <div class="divclear"></div>
                </div>
                <div class="divclear"></div>
                 </div>
                  <?php
				  $rows  = MysqlRowSelect('lgsc_shopcollection,lgsc_shops','*',$addsql,$limit);
				  if($rows != '-1')
				  { 
					  for($i=0,$n=count($rows);$i<$n;$i++)
					  {
						  $shopinfo = MysqlOneSelect('lgsc_shops','*',"id=".$rows[$i]['shopid']);
				  ?>
                  <div class="shoplist">
                 	<div class="shopinfo fl">
                    	<div class="shoplogo"><div></div><a><img src="/<?=$shopinfo['shop_logo']?>" width="95" height="40"></a><!--<span>品牌直销</span>--></div>
                        <div class="shopname"><?=$shopinfo['shopname']?></div>
                        <div class="gztime">关注时间：<span><?=date("Y-m-d h:i:s",$rows[$i]['createTime'])?></span></div>
                        <div class="btnjr"><a href="/shops.php?sid=<?=$shopinfo['id']?>" target="_blank"><span>进入店铺</span></a></div>
                        <div class="btnb"><a  class="fl cm"><span>联系客服</span></a><a class="fr hand" onclick="delShopCollection(<?=$shopinfo['id']?>,this)"><span>取消收藏</span></a></div>
                    </div>
                    <div class="shopgoods fr">
                            <div class="goodstab"><ul><li class="cur"><a>热销商品</a></li><li><a>最新上架</a></li></ul></div>
                            <div class="goodlistbox">
                                <div class="goodlist">
                                    <ul>
                                    <?php
                                    $temp ='<li><a href="/goods.php?id=[!--id--]"><img src="/[!--picurl--]" width="110" height="110" ><!--[!--title--]--><p class="f16 red-color">￥[!--salesprice--]</p></a></li>';
									 echo listTemp($temp,'lgsc_goods',"shopid=$shopinfo[id] and flag like '%r%' and issale = 'true' order by posttime desc",$limit='5');
									?>
                                    </ul>
                                    <!--热销结束-->
                                    <ul style="display:none;">
                                    <?php
                                    $temp ='<li><a href="/goods.php?id=<?=$shop[!--id--]?>"><img src="/[!--picurl--]" width="110" height="110" ><!--[!--title--]--><p class="f16 red-color">￥[!--salesprice--]</p></a></li>';
									 echo listTemp($temp,'lgsc_goods',"shopid=$shopinfo[id] and flag like '%x%' and issale = 'true' order by posttime desc",$limit='5');
									?>
                                    </ul>
                                       <!--新品结束-->
                                </div>
                            </div>
                    </div>
               		<div class="divclear"></div>
                  </div>
                  <?php
					  }
				  }
				  ?>
                  <!--第一排结束-->
                  
                  <div class="endpage tl_page">
                    <div class="fl">
                        <span class="all_xz"><a><label><input type="checkbox" style="display:none;">全选</label></a></span>
                        <span class="qx_xz"><a class="blue_link hand">取消收藏</a></span>
                    </div>
                
                          <!--分页-->
                          <div class="fy_page tr_page">
                            <?=$cpage = ListPage($page,$num,$shopTotal['total'])?>
							<?php if($cpage!= ''){ ?>
                            到第<input type="text" placeholder="1" value="1" id="topage" >页
                            <a onclick="page('<?=GetUrl('page')?>')" href="javascript:vide(0)">确定</a>
                            <?php } ?>
                        </div>
                        <!--分页结束-->
                        <div class="divclear"></div>
                </div>
                
             </div>
             </div>
            <!--收藏店铺结束-->
            <div class="divclear"></div>
            <div class="mt20"></div>

             <!--推荐商品-->
             <div class="splb_ul tj_goods bgf5">
             <div class="title">
             <strong class="f16 fl">根据您的关注为您推荐</strong>
             <!--<a class="fr">查看更多</a>-->
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
				$sql = goodsShowAI($user,"lgsc_goodscollection");
				if($sql != '-1'){
					echo listTemp($temp,'lgsc_goods',$sql);
				}
				?>
             </ul><div class="divclear"></div>
             </div>
             
            <!--推荐商品结束-->
        </div>
    </div>
</div>


<!-- 底部 -->
<footer class="ifooter">
	<!-- 质量保证 -->
    <div class="bzzl">
        <div class="bzzl_c">
        	<ul>
            	<li><span class="c1"><i>正品</i>质量保障</span></li>
            	<li><span class="c2"><i>服务</i>质量保障</span></li>
            	<li><span class="c3"><i>商品</i>质量保障</span></li>
            	<li><span class="c4"><i>安全</i>质量保障</span></li>
            </ul>
        </div>
    </div>
	<div class="ifooter_c">
	<!-- 链接 -->
    <ul>
    	<li><dl>
        	<dt><a>新手帮助</a></dt>
            <dd><a>用户注册</a></dd>
            <dd><a>购买流程</a></dd>
            <dd><a>订单状态</a></dd>
            <dd><a>订购方式</a></dd>
        </dl>

        </li>
    	<li><dl>
        	<dt><a>支付方式</a></dt>
            <dd><a>支付宝</a></dd>
            <dd><a>货到付款</a></dd>
            <dd><a>网上银行支付</a></dd>
            <dd><a>快捷支付</a></dd>
        </dl>
        </li>
    	<li><dl>
        	<dt><a>售后服务</a></dt>
            <dd><a>服务承诺</a></dd>
            <dd><a>发票制度</a></dd>
            <dd><a>退换货保障</a></dd>
            <dd><a>商品质量</a></dd>
            <dd><a>投诉建议</a></dd>
        </dl>
        </li>
    	<li><dl>
        	<dt><a>帮助中心</a></dt>
            <dd><a>订单管理</a></dd>
            <dd><a>常见问题</a></dd>
            <dd><a>找回密码</a></dd>
            <dd><a>用户协议</a></dd>
        </dl>
        </li>
    </ul>
    <div class="divclear"></div>
	<!-- 版权 -->
    <div class="bq_c">
    	<a href="#">临港简介</a><a href="#">诚聘英才</a><a href="#">联系我们</a><a href="#">网站地图</a><a href="#" class="foot_wb"></a><a href="#" class="foot_qq"></a><a href="#" class="foot_wx"></a> 临港大市场版权所有    业务经营许可证：渝-000000000<br/>
可信网站 中网验证可信网站编码： 123456789111254000000<br/>
企业法人营业执照注册号：000000000000000<br/>
    </div>
    </div>
</footer>
</body>
</html>
