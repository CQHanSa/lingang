<?php require_once(dirname(__FILE__).'/Common/index.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg_webname; ?></title>

<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="/js/style.common.js"></script>
<script type="text/javascript" src="/js/click.js"></script>
<script type="text/javascript">
$(function(){
	$(".splb_type_search li").each(function() {
		var h = $(this).height();
		$(this).attr('rel',$(this).height());
		if(h > 15){  $(this).css('height','20px'); }
	})
});
</script>
</head>
<body>
<?php
$symbol =  empty($_GET) ? '?' : '&'; 
$num = 10;
$limit = pageLimit($page,$num);
$cd = isset($_GET['cd']) ? intval(get('cd')) : '';
$brand = isset($_GET['brand']) ? intval(get('brand')) : '';
$m = isset($_GET['m']) ? intval(get('m')) : '';
$x = isset($_GET['x']) ? intval(get('x')) : '';
$order = isset($_GET['order']) ? intval(get('order')) : '';
$addsql = "typetid='$oncid'";
if($oncid == ''){ $addsql = "typetid !=''";}

if(isset($_GET['keyword']))
{ 
	$keyword = preg_replace('/\s+/'," ",get('keyword'));
	$keywordArr = explode(' ',$keyword);
	$addsql =' ( '; 
	for($i=0,$n=count($keywordArr);$i<$n;$i++)
	{
		$addsql .= " title like '%".$keywordArr[$i]."%' or"; 
	} 
	$addsql = substr($addsql,0,'-2').' ) '; 
}

if($twcid != ''){ $addsql .=" and typepid = $twcid "; }
if($thcid != ''){ $addsql .=" and typeid = $thcid "; }
if($cd != ''){ $addsql .=" and shop_addressid = $cd "; }
if($brand != ''){ $addsql .=" and brandid = $brand "; }
if( ($m == '' && $x != '') || ($m != '' && $x == '') || ($m != '' && $x != ''))
{ 
	if($m == ''){ $addsql .= " and salesprice >= $m ";}
	elseif($x == ''){ $addsql .= " and salesprice <= $m ";}
	else{ $addsql .=" and salesprice >= $m and salesprice <= $x "; }
}
$addsql .= " and checkinfo =  'true' and issale = 'true' ";

if($order == '1'){ $addsql .= 'order by salenum desc'; }
if($order == '2'){ $addsql .= 'order by assess desc'; }
if($order == '3'){ $addsql .= 'order by salesprice desc'; }
//echo $addsql;

$price = array(0=>'m',1=>'x');
$price_v = array(
				0=>
					array(
						0=>'<50',
						1=>'50',
						2=>''
					),
				 1=>
					array(
						0=>'51-100',
						1=>'51',
						2=>'100'
					),
				 2=>
					array(
						0=>'101-200',
						1=>'100',
						2=>'200'
					),
				 3=>
					array(
						0=>'201-300',
						1=>'200',
						2=>'300'
					),
				 4=>
					array(
						0=>'301-400',
						1=>'300',
						2=>'400'
					),	
				 5=>
					array(
						0=>'401-500',
						1=>'400',
						2=>'500'
					),
				 6=>
					array(
						0=>'>500',
						1=>'',
						2=>'500'
					),												
				);
				
?>
<!--顶部公共-->
<?php require_once(dirname(__FILE__).'/public/header.php'); ?>


<!-- 选择分类 搜索 -->
<div class="icontent">
	<div class="icontent_c">
		<div class="splb_top">当前位置：<a>首页</a>><a>新鲜水果</a></div>
        <div class="splb_type_search">
    	<ul>
        	<li>
            <span class="splb_searchbt">分类：</span>
            <span class="xz_qb"><span><a href="goods.php" <?=$oncid == '' ? 'class="cur"' : '' ?>>全部</a></span><p>
            	<?php 
					echo listFilter("parentid = 0 and checkinfo = 'true' order by orderid asc",'oncid',$oncid); 
				?>
            </p>
            	
            </span>
            <span class="splb_sq">展开</span>
            <div class="divclear"></div>
            </li>
            <?php if($oncid != '' && listFilter("parentid = '$oncid' and checkinfo = 'true' order by orderid asc",'twcid',$twcid) != ''){?>
        	<li>
            <span class="splb_searchbt">&nbsp;</span>
            <span class="xz_qb"><span><a href="<?=GetUrl('twcid')?>" <?=$twcid == '' ? 'class="cur"' : '' ?>>全部</a></span><p>
            	<?php 
					echo listFilter("parentid = '$oncid' and checkinfo = 'true' order by orderid asc",'twcid',$twcid); 
				?>
            </p>
            	
            </span>
            <span class="splb_sq">展开</span>
            <div class="divclear"></div>
            </li>
            <?php } ?>
            <?php if($twcid != '' && listFilter("parentid = '$twcid' and checkinfo = 'true' order by orderid asc",'thcid',$thcid) != ''){?>
            <li>
            <span class="splb_searchbt">&nbsp;</span>
            <span class="xz_qb"><span><a href="<?=GetUrl('thcid')?>" <?=$thcid == '' ? 'class="cur"' : '' ?>>全部</a></span><p>
            	<?php 
					echo listFilter("parentid = '$twcid' and checkinfo = 'true' order by orderid asc",'thcid',$thcid); 
				?>
            </p>
            </span>
            <span class="splb_sq">展开</span>
            <div class="divclear"></div>
            </li>
            <?php } ?>
        	<li>
            <span class="splb_searchbt">价格：</span>
            <span class="xz_qb"><span><a href="<?=GetUrl($price)?>" <?=$m== '' && $x == '' ? 'class="cur"' : '' ?>>全部</a></span><p>
            	<?php 
					for($i=0,$n=count($price_v);$i<$n;$i++)
					{
						
						$pirce_hot = '';
						if(isset($_GET['m'])&& intval(get('m')) == $price_v[$i][1] ){ $pirce_hot = 'class="cur"'; }
						echo "<a href='".GetUrl($price,"m=".$price_v[$i][1],'2')."&x=".$price_v[$i][2]."' $pirce_hot > ".$price_v[$i][0] ."</a>";
					} 
				?>
            </p></span>
            <span class="splb_sq">展开</span>
            <div class="divclear"></div>
            </li>
        	<li>
            <span class="splb_searchbt">产地：</span>
            <span class="xz_qb"><span><a href="<?=GetUrl('cd')?>" <?=$cd == '' ? 'class="cur"' : '' ?> >全部</a></span><p>
            	<?=listPlace($oncid,$cd,'lgsc_goodsaddress','shop_addressid','cd')?>
            </p>
            </span>
            <span class="splb_sq">展开</span>
            <div class="divclear"></div>
            </li>
        	<li id="bord_b">
            <span class="splb_searchbt">品牌：</span>
            <span class="xz_qb"><span><a href="<?=GetUrl('brand')?>" <?=$brand == '' ? 'class="cur"' : '' ?>>全部</a></span><p>
            	<?=listPlace($oncid,$brand,'lgsc_goodsbrand','brandid','brand')?>
            </p></span>
            <span class="splb_sq">展开</span>
            <div class="divclear"></div>
            </li>
        </ul>
        <div class="divclear"></div>
    </div>
    	<div class="search_xzx">
        	<span class="sp1">自提点</span>
            <a href="<?=isset($_GET['order']) && get('order') == 1 ?  GetUrl('order') : GetUrl('order',"order=1") ?>">
            	<span <?=isset($_GET['order']) && get('order') == 1 ? 'class="sp3-down"' : 'class="sp3-up"' ?>>销量</span>
            </a>
        	<a href="<?=isset($_GET['order']) && get('order') == 2 ?  GetUrl('order') : GetUrl('order',"order=2") ?>">
            	<span <?=isset($_GET['order']) && get('order') == 2 ? 'class="sp3-down"' : 'class="sp3-up"' ?>>评价</span>
            </a>
        	<a href="<?=isset($_GET['order']) && get('order') == 3 ?  GetUrl('order') : GetUrl('order',"order=3") ?>">
            	<span <?=isset($_GET['order']) && get('order') == 3 ? 'class="sp3-down"' : 'class="sp3-up"' ?>>价格</span>
            </a>
        	<input type="text" class="start_jg" id='m'> — <input type="text" class="end_jg" id='x'>
            <a href="javascript:vide(0)" class="btn_true" onclick="toprice('<?=GetUrl($price)?>')" >确定</a>
        </div>
        <div class="splb_ul">
        	<ul>
            	<?php
				$temp='
            	<li><a href="/goodsshow.php?id=[!--id--]">
                	<div class="sp_pic"><img src="/[!--picurl--]"></div>
                    <div class="sp_jg">¥[!--salesprice--]</div>
                    <div class="sp_wb">[!--title--]</div>
                    <div class="sp_xl">
                    	<span class="t_left">月销量：<i>2864</i></span>
                        <span class="t_right">累计评价：<i>568</i></span>
                        <div class="divclear"></div>
                    </div>
                    <div class="sp_jrgwc"><a>加入购物车</a></div>
                </a></li>';
				echo listTemp($temp,'lgsc_goods',$addsql,$limit);
				?>
            </ul>
            <div class="divclear"></div>
        </div>
        
        <script type="text/javascript">
			$(".splb_ul ul li").hover(function(){
				$(this).addClass('on');
			},function(){
				$(this).removeClass('on');
			});
		</script>
        
        <!-- 分页 -->
        <div class="fy_page">
        	<?=$cpage = ListPage($page,$num)?>
            <?php if($cpage!= ''){ ?>
            到第<input type="text" placeholder="1" value="1" id="topage" >页
            <a onclick="page('<?=GetUrl('page')?>')" href="javascript:vide(0)">确定</a>
        	<?php } ?>
        </div>
        
        <!-- 向您推荐 | 浏览历史 -->
        <div class="splb_tjls">
            <span class="on">向您推荐</span>|
            <span>浏览历史</span>
            <div class="divclear"></div>
        </div>
        <div class="splb_tjls_cont">
            <ul style="display:block;">
            	<?php
				$temp2='
                <li><a href="/goodsshow.php?id=[!--id--]">
                	<div><img src="/[!--picurl--]" width="208" height="200"></div>
                    	<dl>
                        	<dt>[!--title--]</dt>
                            <dd>￥[!--salesprice--]</dd>
                        </dl>
                </a></li>';
				$total = $_SESSION['total'];
				$rand = array();
				$randID = 'id in (';
				if($total > 5)
				{
					for($i=0;$i<5;$i++)
					{
						$k=count($rand);
						$num = rand(1,$total);
						for($j=0;$j<$k;$j++)
						{
							if($num == $rand[$j])
							{
								$num = rand(1,$total);
								$j=0;
							}
						}
						if($k == 0 ){  $rand[] = $num; }else{ $rand[] = $num; }
						$randID .= $num.",";
					}
					$randID = substr($randID,0,'-1').")";
					$addsql = $randID;	
				}else
				{
					$addsql ='';
				}
				//print_r($randID);
				echo listTemp($temp2,'lgsc_goods',$addsql,$limit='6');
				?>
            </ul>
            <ul style="display:none;">
            <?php
            	$sqlRest = getsScanlog($user);
				if($sqlRest){ echo listTemp($temp2,'lgsc_goods',$sqlRest,$limit='6');}
			?>
            </ul>
            <div class="divclear"></div>
        </div>
        
        
    </div>
</div>

<!-- 底部 -->
<?php require_once($path.'/public/footer.php'); ?>
</body>
</html>
