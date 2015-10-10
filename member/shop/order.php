<?php
require_once('../../Common/index.php');
$web_name="订单查看";
$shop = MysqlOneSelect('lgsc_shops','id',"userid = '$user[userid]'");
if($shop == '-1'){ die('非法访问'); }


$num = 4;
$addsql = " goodsshopid REGEXP  '([1-9]*,$shop[id])|$shop[id]'";
if(isset($_GET['clientstate'])){ $addsql .= " and userstate = ".get('clientstate'); }
if(isset($_GET['key'])){ $addsql .=" and ddnum = ".intval(get('key')); }
 
$r = MysqlOneSelect('lgsc_dd','count(*) as total ',"$addsql");
$flag_1 = MysqlOneSelect('lgsc_dd','count(*) as total ',"userid=".$user['userid']."  and userstate = -1");
$flag_2 = MysqlOneSelect('lgsc_dd','count(*) as total ',"userid=".$user['userid']."  and userstate = 1");
$flag_3 = MysqlOneSelect('lgsc_dd','count(*) as total ',"userid=".$user['userid']."  and userstate = 2");
$flag_4 = MysqlOneSelect('lgsc_dd','count(*) as total ',"userid=".$user['userid']."  and userstate = 3");
$total = $r['total'];
$flag[0] = $flag_1['total'];
$flag[1] = $flag_2['total'];
$flag[2] = $flag_3['total'];
$flag[3] = $flag_4['total'];
$page = isset($_GET['page']) ? get('page') : '';
$limit = pageLimit($page,$num);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$web_name?></title>

<?php include_once($path.'/Public/css.php'); ?>
<link rel="stylesheet" type="text/css" href="/css/detail.css"/>
<link rel="stylesheet" type="text/css" href="/css/order.css"/>

<?php include_once($path.'/Public/js.php'); ?>
</head>

<body>
<!-- 顶部 -->
<?php require_once($path.'/public/header.php'); ?> 

<!-- 内容 -->
<div class="icontent">
	<div class="icontent_c">
    
    	<!-- 当前位置 -->
    	<div class="order_top">
        	当前位置：<a href="/">首页</a>&gt;<a href="/member.php"><?php echo $web_title?></a>&gt;<?php echo $web_name?>
        </div>
        <?php include_once("./leftinfo.php") ?>
        <div class="order_cont t_right">
        	<div class="sr_ordernum">
            	<span class="t_left">全部订单</span>
                <span class="t_right"><input type="text" placeholder="买家姓名、订单编号"><a>查询</a></span>
                <div class="divclear"></div>
            </div>
            <dl class="orders_dl">
            	<?php
				$rowsDD = MysqlRowSelect('lgsc_dd','*',"$addsql order by  userstate asc ,createTime desc",$limit);
				for($i=0,$n=count($rowsDD);$i<$n;$i++)
				{
					$goods = MysqlRowSelect('lgsc_goods',"*","shopid = '$shop[id]' and  id in (".$rowsDD[$i]['goodsid'].")");
					$state[$i] = $rowsDD[$i]['goodsstate'] + 1;
					if($state[$i] == 0 ){ $state[$i] = 2; }
				?>
            	<dt>
                	<span class="t_left">订单编号: <i><?=$rowsDD[$i]['ddnum']?></i></span>
                    <span class="t_right"><a class="hand" onclick="Open('/socket.php?sid=<?=$shop['id']?>&amp;uid=<?=$rowsDD[$i]['userid']?>')">联系买家</a></span>
                    <div class="divclear"></div>
                </dt>
                <dd>
                    <table class="order_sp" cellpadding="0" cellspacing="0" border="0">
                    	<tbody>
                        	<tr>
                            	<td>
                                	<ul>
                                    	<?php
										for($j=0,$k=count($goods);$j<$k;$j++)
										{
										?>
                                    	<li><a href="/goodsshow.php?id=<?=$goods[$j]['id']?>" target="_blank"><img src="/<?=$goods[$j]['picurl']?>"></a></li>
                                    	<?php
										}
                                        ?>
                                    </ul>
                                </td>
                            	<td><?=$rowsDD[$i]['adress_username']?></td>
                            	<td><i>¥<?=$rowsDD[$i]['sum']?></i><br/>在线支付</td>
                            	<td><em><?=date("Y-m-d",$rowsDD[$i]['createTime'])?><br/><?=date("h:i:s",$rowsDD[$i]['createTime'])?></em></td>
                            	<td>
                                	<?php 
										$clienttage = isGoodsState($rowsDD[$i]['userstate'],$rowsDD[$i]['id']);
										$goodsstate = isGoodsState($state[$i]);
                                	?>
									<i><b><?=$clienttage['tag']; ?></b></i>
                                    <br/><!--<a>跟踪</a>-->
                                </td>
                            	<td>
                                	<span><a onClick="SendGoods(<?=$rowsDD[$i]['id']?>,<?=$rowsDD[$i]['goodsstate']?>,this)" class="hand red"><?=$goodsstate['tag']?></a></span><br/>
                                    <a>取消订单</a><br/>
                                    <a>查看</a><br/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </dd>
                <?php
                }
                ?>
            </dl>
            
        <!-- 分页 -->
        <div class="fy_page">
			<?=$cpage = ListPage($page,$num,$total)?>
            <?php if($cpage!= ''){ ?>
            到第<input type="text" placeholder="1" value="1" id="topage" >页
            <a onclick="page('<?=GetUrl('page')?>')" href="javascript:vide(0)">确定</a>
            <?php } ?>
        </div>
        </div>
    </div>
</div>

<!-- 底部 -->
<?php include_once($path."/public/footer.php") ?>
</body>
</html>
