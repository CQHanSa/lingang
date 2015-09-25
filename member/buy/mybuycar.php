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
				$rows = MysqlRowSelect('lgsc_mybuycar',"*","userid='$user[userid]' group by shopid order by createTime desc");
				if($rows != '-1'){
					//print_r($rows);
					for($i=0,$n=count($rows);$i<$n;$i++)
					{
						$shop = MysqlOneSelect('lgsc_shops','shopname',"id=".$rows[$i]["shopid"]);
				?>
                	<tr>
                    	<td colspan="7">
                        	<!-- table 店铺商品列表 -->
                            <table class="gwc_splb" cellpadding="0" cellspacing="0" border="0">
                            <thead><tr><td colspan="7"><samp class="dp_check"><label><input type="checkbox" ><?=$shop['shopname']?></label></samp></td></tr></thead>
                             <tbody>
                <?php
						$goods = MysqlRowSelect('lgsc_mybuycar,lgsc_goods','lgsc_goods.id,lgsc_goods.picurl,lgsc_goods.title,lgsc_mybuycar.price,lgsc_mybuycar.weight,lgsc_mybuycar.num',"lgsc_mybuycar.goodsid = lgsc_goods.id and lgsc_mybuycar.userid = '$user[userid]'");
						for($j=0,$k=count($goods);$j<$k;$j++)
						{
				?>
                                    <tr>
                                    	<td colspan="2">
                                        <div class="gwc_sp_img">
                                            <samp class="sp_check"><label><input type="checkbox" autocomplete="off" ></label></samp>
                                            <span><img src="/<?=$goods[$j]['picurl']?>"></span>
                                            <div class="t_right">
                                                <dl>
                                                    <dt style="text-align:left"><?=$goods[$j]['title']?></dt>
                                                    <dd><a href="/goods.php?id=<?=$goods[$j]['id']?>">［查看详情］</a></dd>
                                                </dl>
                                            </div>
                                            <div class="divclear"></div>
                                        </div>
                                    </td>
                                    	<td><font><?=$goods[$j]['weight']?></font></td>
                                        <td>
                                            <div class="gwc_dj">
                                                <div class="price"><?=$goods[$j]['price']?></div>
                                                <span>赠30积分</span>
                                            </div>
                                        </td>
                                        <td><div class="gwc_sp_num">
                                            <span onclick="updatedProducts(-1, this);" class="reduce">-</span>
                                            <input type="text" value="<?=$goods[$j]['num']?>" class="num" autocomplete="off">
                                            <span onclick="updatedProducts(1, this);" class="add">+</span>
                                            <div class="divclear"></div>
                                        </div></td>
                                        <td><i class="small_j">0.00</i></td>
                                        <td><a>删除商品</a></td>
                                    </tr>
                        
                			<tr>
                   	<?php
							}
					?>
						</tr>
                        </tbody>
                        </table>
					<?php
						}
                    }					
					?>
                    <tr>
                    	<td colspan="7">
                        	<!-- table 店铺商品列表 -->
                        	<table class="gwc_splb" cellpadding="0" cellspacing="0" border="0">
                        <thead><tr><td colspan="7"><samp class="dp_check"><label><input type="checkbox" >山之风生鲜旗舰店</label></samp></td></tr></thead>
                        <tbody>
                        <tr>
                                    	<td colspan="2">
                                        <div class="gwc_sp_img">
                                            <samp class="sp_check"><label><input type="checkbox" ></label></samp>
                                            <span><img src="images/cp_02.png"></span>
                                            <div class="t_right">
                                                <dl>
                                                    <dt>鲜佰客冷冻蔬果黄秋葵 即食果蔬脆片 羊角菜 绿色健康有机蔬菜 500g</dt>
                                                    <dd><a>［查看详情］</a></dd>
                                                </dl>
                                            </div>
                                            <div class="divclear"></div>
                                        </div>
                                    </td>
                                    	<td><font>500g</font></td>
                                        <td>
                                            <div class="gwc_dj">
                                                <div class="price">98.00</div>
                                                <span>赠30积分</span>
                                            </div>
                                        </td>
                                        <td><div class="gwc_sp_num">
                                            <span onclick="updatedProducts(-1, this);" class="reduce">-</span>
                                            <input type="text" value="1" class="num" autocomplete="off">
                                            <span onclick="updatedProducts(1, this);" class="add">+</span>
                                            <div class="divclear"></div>
                                        </div></td>
                                        <td><i class="small_j">0.00</i></td>
                                        <td><a>删除商品</a></td>
                                    </tr></tbody>
                    </table>
                    	</td>
                    </tr>
                	<tr>
                    	<td colspan="7">
                        	<!-- table 店铺商品列表 -->
                        	<table class="gwc_splb" cellpadding="0" cellspacing="0" border="0">
                        <thead><tr><td colspan="7"><samp class="dp_check"><label><input type="checkbox" >山之风生鲜旗舰店</label></samp></td></tr></thead>
                        <tbody><tr>
                                    	<td colspan="2">
                                        <div class="gwc_sp_img">
                                            <samp class="sp_check"><label><input type="checkbox" ></label></samp>
                                            <span><img src="images/cp_02.png"></span>
                                            <div class="t_right">
                                                <dl>
                                                    <dt>鲜佰客冷冻蔬果黄秋葵 即食果蔬脆片 羊角菜 绿色健康有机蔬菜 500g</dt>
                                                    <dd><a>［查看详情］</a></dd>
                                                </dl>
                                            </div>
                                            <div class="divclear"></div>
                                        </div>
                                    </td>
                                    	<td><font>500g</font></td>
                                        <td>
                                            <div class="gwc_dj">
                                                <div class="price">98.07</div>
                                                <span>赠30积分</span>
                                            </div>
                                        </td>
                                        <td><div class="gwc_sp_num">
                                            <span onclick="updatedProducts(-1, this);" class="reduce">-</span>
                                            <input type="text" value="1" class="num" autocomplete="off">
                                            <span onclick="updatedProducts(1, this);" class="add">+</span>
                                            <div class="divclear"></div>
                                        </div></td>
                                        <td><i class="small_j">0.00</i></td>
                                        <td><a>删除商品</a></td>
                                    </tr></tbody>
                    </table>
                    	</td>
                    </tr>
                	<tr>
                    	<td colspan="7">
                        	<!-- table 店铺商品列表 -->
                        <table class="gwc_splb" cellpadding="0" cellspacing="0" border="0">
                        <thead><tr><td colspan="7"><samp class="dp_check"><label><input type="checkbox" >山之风生鲜旗舰店end</label></samp></td></tr></thead>
                        <tbody><tr>
                                    	<td colspan="2">
                                        <div class="gwc_sp_img">
                                            <samp class="sp_check"><label><input type="checkbox" autocomplete="off"  ></label></samp>
                                            <span><img src="images/cp_02.png"></span>
                                            <div class="t_right">
                                                <dl>
                                                    <dt>鲜佰客冷冻蔬果黄秋葵 即食果蔬脆片 羊角菜 绿色健康有机蔬菜 500g</dt>
                                                    <dd><a>［查看详情］</a></dd>
                                                </dl>
                                            </div>
                                            <div class="divclear"></div>
                                        </div>
                                    </td>
                                    	<td><font>500g</font></td>
                                        <td>
                                            <div class="gwc_dj">
                                                <div class="price">98.50</div>
                                                <span>赠30积分</span>
                                            </div>
                                        </td>
                                        <td><div class="gwc_sp_num">
                                            <span onclick="updatedProducts(-1, this);" class="reduce">-</span>
                                            <input type="text" value="1" class="num" autocomplete="off" >
                                            <span onclick="updatedProducts(1, this);" class="add">+</span>
                                            <div class="divclear"></div>
                                        </div></td>
                                        <td><i class="small_j">0.00</i></td>
                                        <td><a class="hand" onClick="delRow(this)">删除商品</a></td>
                                    </tr></tbody>
                    </table>
                    	</td>
                    </tr>
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
                    <a>立即结算</a>
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
                <li><a href="#">
                	<div><img src="images/sp_pic.png"></div>
                    	<dl>
                        	<dt>大地仓 有机蔬菜 甘蓝 500g 非转基因无农药 农场直供......</dt>
                            <dd>￥85.6</dd>
                        </dl>
                </a></li>
                <li><a href="#">
                	<div><img src="images/sp_pic.png"></div>
                    	<dl>
                        	<dt>大地仓 有机蔬菜 甘蓝 500g 非转基因无农药 农场直供......</dt>
                            <dd>￥85.6</dd>
                        </dl>
                </a></li>
                <li><a href="#">
                	<div><img src="images/sp_pic.png"></div>
                    	<dl>
                        	<dt>大地仓 有机蔬菜 甘蓝 500g 非转基因无农药 农场直供......</dt>
                            <dd>￥85.6</dd>
                        </dl>
                </a></li>
                <li><a href="#">
                	<div><img src="images/sp_pic.png"></div>
                    	<dl>
                        	<dt>大地仓 有机蔬菜 甘蓝 500g 非转基因无农药 农场直供......</dt>
                            <dd>￥85.6</dd>
                        </dl>
                </a></li>
                <li><a href="#">
                	<div><img src="images/sp_pic.png"></div>
                    	<dl>
                        	<dt>大地仓 有机蔬菜 甘蓝 500g 非转基因无农药 农场直供......</dt>
                            <dd>￥85.6</dd>
                        </dl>
                </a></li>
            </ul>
            <ul style="display:none;">
                <li><a href="#">
                	<div><img src="images/sp_pic.png"></div>
                    	<dl>
                        	<dt>大地仓 有机蔬菜 甘蓝 500g 非转基因无农药 农场直供......</dt>
                            <dd>￥35.6</dd>
                        </dl>
                </a></li>
                <li><a href="#">
                	<div><img src="images/sp_pic.png"></div>
                    	<dl>
                        	<dt>大地仓 有机蔬菜 甘蓝 500g 非转基因无农药 农场直供......</dt>
                            <dd>￥85.6</dd>
                        </dl>
                </a></li>
                <li><a href="#">
                	<div><img src="images/sp_pic.png"></div>
                    	<dl>
                        	<dt>大地仓 有机蔬菜 甘蓝 500g 非转基因无农药 农场直供......</dt>
                            <dd>￥85.6</dd>
                        </dl>
                </a></li>
                <li><a href="#">
                	<div><img src="images/sp_pic.png"></div>
                    	<dl>
                        	<dt>大地仓 有机蔬菜 甘蓝 500g 非转基因无农药 农场直供......</dt>
                            <dd>￥85.6</dd>
                        </dl>
                </a></li>
                <li><a href="#">
                	<div><img src="images/sp_pic.png"></div>
                    	<dl>
                        	<dt>大地仓 有机蔬菜 甘蓝 500g 非转基因无农药 农场直供......</dt>
                            <dd>￥85.6</dd>
                        </dl>
                </a></li>
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