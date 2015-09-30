<?php require_once(dirname(__FILE__).'/Common/index.php'); 

$sid = isset($sid) ? intval($sid) : 0;
$tid = isset($tid) ? intval($tid) : '-1';
$a = isset($a) ? $a : '';

if($sid<1){
	header('location:/');
	exit();	
}

$r_shop = $dosql->GetOne("SELECT * FROM `#@__shops` WHERE id='$sid' and checkinfo='true' ");
if(!is_array($r_shop)){
	header('location:/');
	exit();		
}

if($a=='note'){
	$r_shopsnote = $dosql->GetOne("SELECT content FROM `#@__shopsnote` WHERE shopid='$sid' and classid='0' ");
	if(!is_array($r_shop)){
		header('location:/');
		exit();		
	}
	
}


$num = 12;
$limit = pageLimit($page,$num);


$where='';
$classname='全部商品';
if($tid > 0){
	$where=' and (shoptype_id='.$tid.' or shoptype_pid='.$tid.')';
	$r_shopstype = $dosql->GetOne("SELECT classname FROM `#@__shopstype` WHERE id='$tid' and checkinfo='true' ");
	if(!is_array($r_shopstype)){
		header('location:/');
		exit();		
	}else{
		$classname=$r_shopstype['classname'];
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $r_shop['shopname']?> - <?php echo $cfg_webname; ?></title>
<link href="/css/css.css" rel="stylesheet" type="text/css" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link href="/css/detail.css" rel="stylesheet"  type="text/css" />

<?php include_once($path.'/Public/js.php'); ?>
<script type="text/javascript" src="/templates/default/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.flexslider-min.js"></script> 
<script type="text/javascript" src="/js/click.js"></script>
</head>



<body>

<!-- 顶部会员信息 -->
<?php require_once(dirname(__FILE__).'/public/top.php'); ?>

<!-- logo+搜索+购物车 -->
<?php require_once(dirname(__FILE__).'/public/logosearch.php'); ?>


<div class="itop">
	 <!-- top 3 -->
    <div class="scpf">
    	<div class="scpf_c">
        	<span class="t_right">
            	<span><?php echo $r_shop['shopname']?></span>
            	<span><a class="on"></a><a class="on"></a><a class="on"></a><a class="on"></a><a class="on"></a><a></a> 4.8分</span>
            	<span><a href="javascript:;" onclick="addShopCollcetion(<?=$sid?>)"><i>+收藏店铺</i></a></span>
                <?php if(isset($_COOKIE['userid'])  ){  
					if($r_shop['userid'] == $user['userid']){?>
                  <span><a class="hand" onclick="alert('店主请不要找自己咨询')"><i>在线客服</i></a></span>
                  	<?php
                    }else{
                    ?>
            	<span><a class="hand" onclick="Open('socket.php?sid=<?=$r_shop['id']?>&uid=<?=$r_shop['userid']?>')"><i>在线客服</i></a></span>
                <?php }}else{ ?>
                <span><a class="hand" onclick="alert('请先登录')"><i>在线客服</i></a></span>
                <?php } ?>
            </span>
        </div>
    </div>
    <?php
	$row = $dosql->GetOne("SELECT linkurl,picurl,target FROM `#@__shopad` WHERE shopid='".$r_shop['id']."' and classid='1' AND picurl !='' AND checkinfo='true' ORDER BY orderid asc, id desc");
	$gourl = 'javascript:;';
	if(is_array($row)){
		if($row['linkurl'] != ''){
			$gourl = $row['linkurl'];
		}
		echo '<div class="seller_sc"><a href="'.$gourl.'" target="'.$row['target'].'"><img src="/'.$row['picurl'].'" /></a></div>';
	}
	?>
    <!-- 菜单栏 -->
    <div class="menu">
    	<div class="menu_c">
        	<ul class="navmenu1">
            	<li class="on"><a href="/shops.php?sid=<?php echo $sid?>">店铺首页</a></li>
            	<li><a href="/shops.php?sid=<?php echo $r_shop['id']?>&tid=0">全部商品</a></li>
                <?php
				$dosql->Execute("SELECT id,classname FROM `#@__shopstype` WHERE shopid='".$r_shop['id']."' and parentid='0' AND checkinfo='true' ORDER BY orderid asc ,id asc LIMIT 4");
				while($row = $dosql->GetArray())
				{
				?>
            	<li><a href="/shops.php?sid=<?php echo $r_shop['id']?>&tid=<?php echo $row['id']?>"><?php echo $row['classname']?></a></li>
                <?php
				}
				?>
            	<li><a href="/shops.php?a=note&sid=<?php echo $sid?>">购物须知</a></li>
            </ul>
        </div>
    </div>
    
    <!-- 轮播图 -->
    <div class="banner1">
		<div class="flexslider">
        <ul class="slides">
        	<?php
			$dosql->Execute("SELECT linkurl,picurl,target FROM `#@__shopad` WHERE shopid='".$r_shop['id']."' and classid='2' AND picurl !='' AND checkinfo='true' ORDER BY orderid DESC LIMIT 10");
			while($row = $dosql->GetArray())
			{
				if($row['linkurl'] != ''){
					$gourl = $row['linkurl'];
				}else{
					$gourl = 'javascript:;';
				}
			?>
            <li style="background:url(<?php echo $row['picurl']; ?>) center top no-repeat;"><a href="<?php echo $gourl; ?>" target="<?php echo $row['target']?>"></a></li>
            <?php
			}
			?>
        </ul>
		</div>
      	
	</div>
    
</div>

<!-- 内容 -->
<div class="icontent">
	<div class="icontent_c">
    	<div class="seller_l">
            <!-- 鲜农乐官方旗舰店 -->
            <div class="detail_pf">
                <div class="detail_pft"><?php echo $r_shop['shopname']?></div>
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
                        <dt>联系方式：<?php echo $r_shop['shop_tel']?></dt>
                        <dt>所 &nbsp;在&nbsp;地：<?=one_cas($r_shop['shop_prov'])?> <?=one_cas($r_shop['shop_city'])?> <?=one_cas($r_shop['shop_town'])?><?=$r_shop['shop_address']?></dt>
                    </dl>
                    <div class="detail_jr">
                        <a href="/shops.php?sic=<?php echo $sid?>">进入商家店铺</a>
                        <a class="hand"  onclick="addShopCollcetion(<?=$r_shop['id']?>)">收藏店铺<font>(<i>0</i>)</font></a>
                    </div>
                </div>
            </div>
            <!-- 商品分类 -->
            <div class="seller_spfl">
                <div class="detail_pft">商品分类</div>
                <ul class="spfl_ul">
                	<?php
					$dosql->Execute("SELECT id,classname FROM `#@__shopstype` WHERE shopid='".$r_shop['id']."' and parentid='0' AND checkinfo='true' ORDER BY orderid asc ,id asc");
					while($row = $dosql->GetArray())
					{
					?>
                    <li><div><a href="/shops.php?sid=<?php echo $r_shop['id']?>&tid=<?php echo $row['id']?>"><?php echo $row['classname']?></a></div>
                    	<dl>
                        	<?php
							$dosql->Execute("SELECT id,classname FROM `#@__shopstype` WHERE shopid='".$r_shop['id']."' and parentid='".$row['id']."' AND checkinfo='true' ORDER BY orderid asc ,id asc",$row['id']);
							while($row2 = $dosql->GetArray($row['id']))
							{
							?>
                            <dt><a href="/shops.php?sid=<?php echo $r_shop['id']?>&tid=<?php echo $row2['id']?>"><?php echo $row2['classname']?></a></dt>
                            <?php
							}
							?>
                        </dl>
                    </li>
                    <?php
					}
					?>
                </ul>
            </div>
            <!-- 店主推荐商品 -->
            <div class="detail_tj">
                <div class="detail_pft">店铺热销商品</div>
                <div class="detail_tjsp">
                    <ul>
                    	<?php
						$temp2='
                        <li><a href="/goodsshow.php?id=[!--id--]" title="[!--title--]" target="_blank"><img src="[!--picurl--]" width="173" height="173">
                            <dl>
                            	<dt><i>¥[!--salesprice--]</i></dt>
                                <dt>[!--title--]</dt>
                            </dl>
                        </a></li>';
						echo listTemp($temp2,'lgsc_goods',"shopid=$sid and flag like '%r%' and issale = 'true' order by id desc",5);
						?>
                    </ul>
                </div>
            </div>
            <!-- 广告 -->
            <?php
			$dosql->Execute("SELECT linkurl,picurl,target FROM `#@__shopad` WHERE shopid='".$r_shop['id']."' and classid='4' AND picurl !='' AND checkinfo='true' ORDER BY orderid DESC LIMIT 2");
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
        <div class="seller_sp">
        
        	<div class="seller_spt">
            	<span class="t_left">
					<div class="banner2">
                        <div class="flexslider">
                        <ul class="slides">
                            <?php
                            $dosql->Execute("SELECT linkurl,picurl,target FROM `#@__shopad` WHERE shopid='".$r_shop['id']."' and classid='3' AND picurl !='' AND checkinfo='true' ORDER BY orderid DESC LIMIT 10");
                            while($row = $dosql->GetArray())
                            {
                                if($row['linkurl'] != ''){
                                    $gourl = $row['linkurl'];
                                }else{
                                    $gourl = 'javascript:;';
                                }
                            ?>
                            <li style="background:url(<?php echo $row['picurl']; ?>) center top no-repeat;"><a href="<?php echo $gourl; ?>" target="<?php echo $row['target']?>"></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        </div>
                    </div>
    			</span>
                <span class="t_right">
                	<div class="detail_pft">店铺公告</div>
                    <div class="detail_content">
                    <?php
                    $r_shopgg = $dosql->GetOne("SELECT content FROM `#@__shopsnote` WHERE shopid='$sid' and classid='1' ");
					if(is_array($r_shopgg)){
						echo str_replace(chr(13),'<br />',htmlspecialchars_decode($r_shopgg['content']));	
					}else{
						echo '暂无公告……';	
					}
					?>
                    </div>
                </span>
                <div class="divclear"></div>
            </div>
            <?php
            if($a=='note'){
			?>
            <!-- 购物须知 -->
            <div class="seller_splb">
            	<div class="seller_hyz">
                	<span class="t_left">购物须知</span>
                	<span class="t_right"></span>
                	<div class="divclear"></div>
                </div>
            	<div class="shops_note"><?php echo $r_shopsnote['content']?></div>
            </div>
            <?php	
			}else{
			
            if($tid =='-1'){
			?>
            <!-- 精品推荐 -->
            <div class="seller_splb">
            	<div class="seller_hyz">
                	<span class="t_left">精品推荐</span>
                	<span class="t_right"></span>
                	<div class="divclear"></div>
                </div>
                <div class="splb_ul1">
                    <ul>
                    	<?php
						$temp2='
                        <li><a href="/goodsshow.php?id=[!--id--]" title="[!--title--]" target="_blank">
                            <div class="sp_pic"><img src="[!--picurl--]" width="200" height="200" /></div>
                            <div class="sp_jg">¥[!--salesprice--]</div>
                            <div class="sp_wb">[!--title--]</div>
                        </a></li>';
						echo listTemp($temp2,'lgsc_goods',"shopid=$sid and flag like '%t%' and issale = 'true' order by id desc",8);
						?>
                    </ul>
                    <div class="divclear"></div>
                </div>
            </div>
            <?php
			}
			?>
            <!-- 全部商品 -->
            <div class="seller_splb1">
            	<div class="seller_hyz">
                	<span class="t_left"><?php echo $classname?></span>
                	<span class="t_right"></span>
                	<div class="divclear"></div>
                </div>
                <div class="splb_ul1">
                    <ul>
                    	<?php
						$temp2='
                        <li><a href="/goodsshow.php?id=[!--id--]" title="[!--title--]" target="_blank">
                            <div class="sp_pic"><img src="[!--picurl--]" width="200" height="200" /></div>
                            <div class="sp_jg">¥[!--salesprice--]</div>
                            <div class="sp_wb">[!--title--]</div>
                        </a></li>';
						echo listTemp($temp2,'lgsc_goods',"shopid=$sid and issale = 'true' $where order by id desc",$limit);
						?>
                        
                    </ul>
                    
                    <div class="divclear"></div>
                    
                    <!-- 分页 -->
                    <div class="fy_page">
                        <?=$cpage = ListPage($page,$num)?>
                        
                        <?php if($cpage!= ''){ ?>
                        到第<input type="text" placeholder="1" value="1" id="topage" >页
                        <a onclick="page('<?=GetUrl('page')?>')" href="javascript:vide(0)">确定</a>
                        <?php } ?>
                    </div>
                    
                </div>
            </div>
            <?php
			}
			?>
        </div>
    </div>
</div>



<!-- 底部 -->
<?php require_once(dirname(__FILE__).'/public/footer.php'); ?>



<script type="text/javascript">
$(document).ready(function(){
	$('.flexslider').flexslider({
    	directionNav: true,
        pauseOnAction: false
    });
});
</script> 
</body>
</html>