<?php
require_once('../../Common/index.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>购物车</title>
<?php include_once($path.'/Public/css.php'); ?>

<?php include_once($path.'/Public/js.php'); ?>
<script type="text/javascript" src="/js/gwc_js.js"></script>
<script type="text/javascript" src="/js/style.buy.js"></script>

</head>

<body>
<!-- 顶部 -->
<?php require_once($path.'/public/header.php'); ?> 

<div class="icontent">
	<div class="icontent_c">
    	<!-- 购买流程 顺序 -->
    	<div class="gmlc_sx">
        	<ul>
            	<li class="on">
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
        <!-- 购物车商品列表 -->
        <div>
        	
        	<table id="cartTable" class="gwc_dplb" cellpadding="0" cellspacing="0" border="0">
            	<!-- table 头部字段 -->
            	<thead>
                	<tr><td><div class="all_check"><label><input type="checkbox" >全选</label></div></td>
                    <td>商品</td>
                    <td>规格</td>
                    <td>单价</td>
                    <td>数量</td>
                    <td>小计（元）</td>
                    <td>操作</td></tr>
                </thead>
                <tbody>
            <?php 
			//会员状态
			if($user != '')
			{
				$rows = MysqlRowSelect('lgsc_mybuycar',"*","userid='$user[userid]' group by shopid order by createTime desc");
				if($rows != '-1'){
					//print_r($rows);
					for($i=0,$n=count($rows);$i<$n;$i++)
					{
						$shop = MysqlOneSelect('lgsc_shops','shopname',"id=".$rows[$i]["shopid"]);
						echo 
						'<tr>
							<td colspan="7">
								<!-- table 店铺商品列表 -->
								<table class="gwc_splb" cellpadding="0" cellspacing="0" border="0">
								<thead><tr><td colspan="7"><samp class="dp_check"><label><input type="checkbox" >'.$shop['shopname'].'</label></samp></td></tr></thead>
								<tbody>';
						$goods = MysqlRowSelect('lgsc_mybuycar,lgsc_goods','lgsc_goods.id,lgsc_goods.picurl,lgsc_goods.title,lgsc_mybuycar.price,lgsc_mybuycar.weight,lgsc_mybuycar.num',"lgsc_mybuycar.goodsid = lgsc_goods.id and lgsc_mybuycar.userid = '$user[userid]'");
						for($j=0,$k=count($goods);$j<$k;$j++)
						{
							//echo $k;
								echo '
                                <tr>
                                    	<td colspan="2">
                                        	<div class="gwc_sp_img">
                                            <samp class="sp_check"><label><input type="checkbox" autocomplete="off" value="'.$goods[$j]['id'].'" ></label></samp>
                                            <span><img src="/'.$goods[$j]['picurl'].'"></span>
                                            <div class="t_right">
                                                <dl>
                                                    <dt style="text-align:left">'.$goods[$j]['title'].'</dt>
                                                    <dd><a href="/goods.php?id='.$goods[$j]['id'].'">［查看详情］</a></dd>
                                                </dl>
                                            </div>
                                            <div class="divclear"></div>
                                        </div>
                                    </td>
                                    	<td><font>'.$goods[$j]['weight'].'</font></td>
                                        <td>
                                            <div class="gwc_dj">
                                                <div class="price">'.$goods[$j]['price'].'</div>
                                                <span>赠'.Redeem($goods[$j]['price'],$user).'积分</span>
                                            </div>
                                        </td>
                                        <td><div class="gwc_sp_num">
                                            <span onclick="updatedProducts(-1, this,'.$goods[$j]['id'].');" class="reduce">-</span>
                                            <input type="text" value="'.$goods[$j]['num'].'" class="num" autocomplete="off" ">
                                            <span onclick="updatedProducts(1, this,'.$goods[$j]['id'].');" class="add">+</span>
                                            <div class="divclear"></div>
                                        </div></td>
                                        <td><i class="small_j">0.00</i></td>
                                        <td><a class="hand" onclick="delRow(this,'.$goods[$j]['id'].')">删除商品</a></td>
                                    </tr>';
							}
					?>
                        </tbody>
                        </table>
				<?php
                       }
                	}
				}
				//非会员 --- statr
				else
				{
					if(isset($_COOKIE['buyCar']))
					{
					$buycar = $_COOKIE['buyCar'];		
					foreach($buycar as $k => $v)
					{
						$i=0;
						$tempShopid = $v['shopid'];
						if(isset($shops)){
							foreach($shops as $k2 => $v2)
							{
								if(AuthCode($v2) == AuthCode($tempShopid)){$i++;}
							}
						}
						if($i < 1 || !is_array($shops))
						{
							$shops[] = $v['shopid'];
						}
					}
					foreach($shops as $k => $v)
					{
						$shop = MysqlOneSelect('lgsc_shops',"*","id = ".AuthCode($v));
						
				?>
                    <tr>
                    <td colspan="7">
                        <!-- table 店铺商品列表 -->
                        <table class="gwc_splb" cellpadding="0" cellspacing="0" border="0">
                        <thead><tr><td colspan="7"><samp class="dp_check"><label><input type="checkbox" ><?=$shop['shopname']?></label></samp></td></tr></thead>
                         <tbody>
                 <?php
						for($i=0,$n=count($buycar);$i<$n;$i++)
						{
							//print_r($buycar[$i]['id']."<br/>");
							$goods = MysqlOneSelect('lgsc_goods','*',"id=".AuthCode($buycar[$i]['id'])." and shopid = '".AuthCode($v)."'");
				?>
                                    <tr>
                                    	<td colspan="2">
                                        <div class="gwc_sp_img">
                                            <samp class="sp_check"><label><input type="checkbox" autocomplete="off" ></label></samp>
                                            <span><img src="/<?=$goods['picurl']?>"></span>
                                            <div class="t_right">
                                                <dl>
                                                    <dt style="text-align:left"><?=$goods['title']?></dt>
                                                    <dd><a href="/goods.php?id=<?=$goods['id']?>">［查看详情］</a></dd>
                                                </dl>
                                            </div>
                                            <div class="divclear"></div>
                                        </div>
                                    </td>
                                    	<td><font><?=AuthCode($buycar[$i]['weight'])?></font></td>
                                        <td>
                                            <div class="gwc_dj">
                                                <div class="price"><?=AuthCode($buycar[$i]['price'])?></div>
                                                <span>赠<?=Redeem($buycar[$i]['price'],$user)?>积分</span>
                                            </div>
                                        </td>
                                        <td><div class="gwc_sp_num">
                                            <span onclick="updatedProducts(-1, this);" class="reduce">-</span>
                                            <input type="text" value="<?=AuthCode($buycar[$i]['num'])?>" class="num" autocomplete="off">
                                            <span onclick="updatedProducts(1, this);" class="add">+</span>
                                            <div class="divclear"></div>
                                        </div></td>
                                        <td><i class="small_j">0.00</i></td>
                                        <td><a>删除商品</a></td>
                                    </tr>
                        
                   	<?php
						}
					?>
						</tr>
                        </tbody>
                        </table>
				<?php
						}
					}
				}
				?>
                </tbody>
            </table>
            <div class="gwc_js">
            	<span class="t_left">
                	<div class="all_check"><label><input type="checkbox">全选</label></div><a class="hand" onClick="delRows()">删除选中的商品</a>
                </span>
                <span class="t_right">
                	<span>
                    	已选择<i class="totalNum">0</i>件商品<br/>
						总价（不含运费）：<em id="total_price">0.00</em>
                    </span>
                    <div style="display:none" id="checkedGoods"></div>
                    <a class="hand" onClick="Clearing()">立即结算</a>
                </span>
                <div class="divclear"></div>
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
                <li><a href="/goodsshow.php?id=[!--id--]" target="_blank">
                	<div><img src="/[!--picurl--]" width="208" height="200"></div>
                    	<dl>
                        	<dt>[!--title--]</dt>
                            <dd>￥[!--salesprice--]</dd>
                        </dl>
                </a></li>';
				$r = MysqlOneSelect("lgsc_goods","count(*) as total"," id != ''");
				$total = $r['total'];
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
</div>





<!-- 底部 -->
<?php include_once($path."/public/footer.php") ?>
</body>
</html>