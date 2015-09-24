<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="帐户余额";
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
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
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
        
        <div class="w985 fr">
            <div class="balance_top">可用余额：<span>￥<?php echo number_format(floatval($r_user['money']),2)?></span> <a href="?action=balance_recharge" class="btn2 fr">充值</a></div>
            
            <div class="balance_list">
            	<div class="balance_title">收支明细</div>
            	<table class="tb-void" width="100%" cellpadding="0" cellspacing="0">
					<thead>
						<tr bgcolor="#EEE">
                        	<td width="50%" height="40"><span class="pdl10">时间</span></td>
							<td width="20%">操作</td>
							<td width="30%" align="right"><span class="pdr10">金额</span></td>
						</tr>
					</thead>
					<tbody>
                    	<?php
                        $sql = "SELECT * FROM `#@__balance` where userid='".$r_user['id']."' and posttime >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 3 MONTH)) order by id desc";
						$dopage->GetPage($sql,20);
						$i=1;
						while($row = $dosql->GetArray())
						{
							if($row['btype']=='1'){
								$blance_type='充值';
								$blance_icon='+';
								$blance_class='balance_add';
							}else if($row['btype']=='2'){
								$blance_type='支出';
								$blance_icon='-';
								$blance_class='balance_less';
							}elseif($row['btype']=='3'){
								$blance_type='退款';
								$blance_icon='+';
								$blance_class='balance_add';
							}else{
								$blance_type='--';
								$blance_icon='';
								$blance_class='';
							}
						?>
                        <tr <?php if($i%2==0) echo 'bgcolor="#F5F5F5"';?>>
                        	<td height="40"><span class="pdl10"><?php echo date('Y-m-d H:i:s',$row['posttime'])?></span></td>
                            <td><?php echo $blance_type;?></td>
                            <td align="right"><span class="pdr10"><span class="<?php echo $blance_class?>"><span><?php echo $blance_icon;?></span> ￥<?php echo number_format(floatval($row['money']),2)?></span></td>
                        </tr>
                        <?php
						$i++;
						}
						?>	
					</tbody>
				</table>
                <?php echo $dopage->GetList(); ?>
            </div>
            
        </div>
    </div>
</div>

<!-- 底部 -->
<?php include_once("../../public/footer.php") ?>
<script type="text/javascript" src="/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">

$(function(){
	$(".upmember").Validform({
		tiptype:3,
		label:".label",
		showAllError:true,
		ignoreHidden:true,
		datatype:{//传入自定义datatype类型【方式二】;
			"uname": /^[a-zA-Z][a-zA-Z0-9_]*$/,
			"z2-4" : /^[\u4E00-\u9FA5\uf900-\ufa2d]{2,4}$/,
			"oldpassword":function(gets){
				if(gets==$("#oldpassword").val()){
					return "新密码不能与旧密码一致！";	
				}
			}
		}
	});  //就这一行代码！
})
</script>
</body>
</html>
