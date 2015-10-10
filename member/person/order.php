<?php
require_once('../../Common/index.php');
$web_name="订单查看";

$num = 4;
$addsql = "";
if(isset($_GET['clientstate'])){ $addsql .= " and userstate = ".get('clientstate'); }
if(isset($_GET['key'])){ $addsql .=" and ddnum = ".intval(get('key')); }
 
$r = MysqlOneSelect('lgsc_dd','count(*) as total ',"userid=".$user['userid']."  $addsql");
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
            <div>
            <!--start-->
            <div class="goods_order">
                    <table class="order-hd"><tr>
                    <th width="320">商品</th><th width="100">单价</th><th width="60">数量</th><th width="225">实付金额</th>
                    <th width="115"><div class="order_status">交易状态</div></th><th>订单操作</th>
                    </tr></table>
                    <?php
					$rowsDD = MysqlRowSelect('lgsc_dd','*',"userid=$user[userid] $addsql order by  userstate asc , createTime desc",$limit);
					//print_r($rowsDD);
					if($rowsDD == -1){ echo '<span style="line-height:55px;"><!--未有订单--></span>';}else
					{
						for($i=0,$n=count($rowsDD);$i<$n;$i++)
						{
							$goodsNum = explode(',',$rowsDD[$i]['goodsnum']);
							$goodsPrice = explode(',',$rowsDD[$i]['goodsprice']);
							$goodsWeight = explode(',',$rowsDD[$i]['goodsweight']);
							$goods = MysqlRowSelect('lgsc_goods','*',"id in(".$rowsDD[$i]['goodsid'].")");
							$goodsRow = count($goods);
					?>
                    <table class="order-bd">
                        <tr ><td colspan="6"><span class="ordertime"><?=date('Y-m-d h:m:s',$rowsDD[$i]['createTime'])?></span><span class="ordernum">订单号：<?=$rowsDD[$i]['ddnum']?>  </span></td></tr>                                
                    </table>
                     <table  class="order_list">	
                        <tr  >
                        <td width="320">
                        <table>
                        	<?php for($j=0;$j<$goodsRow;$j++){ ?>
                        	<tr>
                            <td width="320"><dl><dt><a><img src="/<?=$goods[$j]['picurl']?>" width="112" height="112" /></a></dt><dd><a class="f14"><?=$goods[$j]['title']?></a><P>规格：<?=$goodsWeight[$j]?></P></dd></dl></td>
                            </tr>
							<?php   } ?>
                        </table>
                        </td>
                        <td  width="100"  >
                         	<table>
                         	<?php for($k=0;$k<$goodsRow;$k++){ ?>
                             	<tr>
                             		<td valign="middle" height="152" ><span class="f14 c97">￥<?=$goodsPrice[$k]?></span></td>
                             	</tr>
						 	<?php  } ?>
                         	</table>
                        </td>
                        <th width="60" > 
                        	<table>
                             <?php for($l=0;$l<$goodsRow;$l++){ ?>
                             <tr>
                        	<td valign="middle" height="152"><span class="f14 c97"><?=$goodsNum[$l]?></span></td>
                            </tr>
                            <?php  } ?>
                            </table>
                        </th>
                        <td  width="225" align="center">
                        	<p class="f14">￥<?=$rowsDD[$i]['sum']?></p><P class="f14">（含 <?=$rowsDD[$i]['fare']?> 元运费）</p>
                        </td>
                        <td width="115" align="center"><span class="f14"><? $goodstage = isGoodsState($rowsDD[$i]['goodsstate']); echo $goodstage['tag']; ?></span></td>
                        	<td align="center">
                            	<?php $clienttage = isClientState($rowsDD[$i]['userstate'],$rowsDD[$i]['id'],$rowsDD[$i]['paypost']); ?>
                        		<a  class="btnpay" href="<?=$clienttage['url']?>" target="_blank" ><?=$clienttage['tag']?></a>
                        		<?php if($clienttage['tag'] == '立即支付'){ ?>
                            	<input type="button" value="取消订单" class="btncancle" onclick="delDD(<?=$rowsDD[$i]['id']?>)" />
                        		<?php }else{ ?>
                                <!--<input type="button" value="退货申请" class="btncancle" />-->
                                <?php } ?>
                        	</td>    
                        </tr>
                    </table>
                    <?php
						}
					}
					?>
 
                    <!-- 分页 -->
                    <div class="clear"></div>
                    <div class="fy_page">
						<?=$cpage = ListPage($page,$num,$total)?>
                        <?php if($cpage!= ''){ ?>
                        到第<input type="text" placeholder="1" value="1" id="topage" >页
                        <a onclick="page('<?=GetUrl('page')?>')" href="javascript:vide(0)">确定</a>
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                </div>
            <!--end-->
            </div>
           
     
        </div>
    </div>
</div>

<!-- 底部 -->
<?php include_once($path."/public/footer.php") ?>
</body>
</html>
