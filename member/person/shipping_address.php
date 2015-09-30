<?php if(!defined('IN_MEMBER')) exit('Request Error!'); 

$web_name="收货地址";

$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' ORDER BY orderid ASC, datavalue ASC");
while($row = $dosql->GetArray())
{
	$areaArr[$row['datavalue']]=$row['dataname'];
}

//初始化数据
$action='shipping_address_add';
$r['id']="";
$r['username']="";
$r['usermobile']="";
$r['userphone']="";
$r['address_prov']="-1";
$r['address_city']="-1";
$r['address_country']="-1";
$r['address']="";
$r['postcode']="";
$r['isdefault']="";
$r['communityid']="";
$r['title']="";

if($id>0){
	$r = $dosql->GetOne("SELECT * FROM `#@__user_address` WHERE `userid`='".$r_user['id']."' and id='$id'");
	if(!is_array($r)){
		ShowMsg('参数错误！','-1');
		exit();
	}else{
		$action='shipping_address_edit';
	}
}
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

<?php include_once($path.'/Public/js.php'); ?>

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
        	<div class="addAddress">
            	<div class="atitle bgf5"><div class="fl"><a class="red-color">新增收货地址</a></div>
                <div class="fr">电话号码、手机号选填一项,其余均为必填项</div></div>
                	<div class="divclear"></div>
                    <div class="useraddress mt40">
						<ul>
                        	<form name="upmember"  class="upmember" id="form" method="post">
                            <input type="hidden" name="id" value="<?=$r['id']?>" />
                            <input type="hidden" name="action" value="<?php echo $action?>" />
							<li class="address">
                            	<label>所在地区：</label>
                                    <select name="address_prov" id="address_prov"  onchange="showCity(this)"  datatype="*" nullmsg="请选择所在地区！">
                                        <option value="-1">请选择</option><?=list_cas($r['address_prov'],'area')?>
                                    </select>
                                    <select name="address_city" onchange="showCounty(this)" id="address_city"  datatype="*" nullmsg="请选择所在地区！" >
                                        <option value="-1">请选择</option><?=row_cas($r['address_city'],'',$floor='2',$r['address_prov'])?>
                                    </select>
                            		<select name="address_country" id="address_country"  <?=$r['address_country'] == '-1' ? 'style="display:none;"' : ''?>  datatype="*" nullmsg="请选择所在地区！" >
                                        <option value="-1">请选择</option><?=row_cas($r['address_country'],'',$floor='3',$r['address_city'])?>
                                    </select>           
                                
                               
                                <span class="Validform_checktip"></span>
                            </li>   
							<li>
                            	<label>详细地址：</label>
                                <input type="text" name="address" value="<?php echo $r['address']?>"  datatype="*" nullmsg="请输入详细地址！" />
                                <span class="Validform_checktip"></span>
                            </li> 
                            <li>
                            	<label>社区名称：</label>
                                <!--<input type="text" name="communityid" value="<?php echo $r['communityid']?>" />-->
                                <select  name="communityid" id="communityid" >
                                	<option value="-1">请选择社区</option>
                                    <?php
									if($r['communityid'] != ''){
									$dosql->Execute("SELECT id,title FROM `#@__community` WHERE address_city='".$r['address_city']."' and  checkinfo='true' ORDER BY id desc");
									while($row2 = $dosql->GetArray())
									{
										if($row2['id'] === $r['communityid'])
											$selected = 'selected="selected"';
										else
											$selected = '';
				
										echo '<option value="'.$row2['id'].'" '.$selected.'>'.$row2['title'].'</option>';
									}
									}
									?>
                                </select>
                            </li>  
							<li>
                            	<label>邮政编码：</label>
                                <input type="text" name="postcode" value="<?php echo $r['postcode']?>"  >
                            </li>
							<li>
                            	<label>收货人姓名：</label>
                                <input type="text" name="username" value="<?php echo $r['username']?>"  datatype="z2-4" nullmsg="请输入姓名！" errormsg="姓名为2~4个中文字符！" />
                                <span class="Validform_checktip"></span>
                            </li>                                   

                            <li>
                            	<label>手机号码：</label>
                                <input type="text" name="usermobile" class="usermobile" value="<?php echo $r['usermobile']; ?>" datatype="m" nullmsg="请输入手机！" errormsg="手机格式不正确！" ignore="ignore" />
                                <span class="Validform_checktip"></span>
                            </li>   
							<li>
                            	<label>电话号码：</label>
                                <input type="text" name="userphone" value="<?php echo $r['userphone']; ?>" datatype="phone" errormsg="电话号码不正确！" nullmsg="手机与固话至少填写一项！" />
                                <span class="Validform_checktip"></span>
                            </li>
                            <li>
                            	<label>地址别名：</label>
                                <input type="text" name="title" value="<?php echo $r['title']; ?>" datatype="*" nullmsg="请输入地址别名！"  />
                                <span class="Validform_checktip"></span>
                            </li>
							<li><label></label><input type="checkbox" name="isdefault" value="1" <?php if($r['isdefault']=='true'){echo 'checked="checked"';}?>   />设为默认收货地址</li>                               
							<li class="btn"><label></label><input class="btnsubmit" value="提交" type="submit"></li>
                            </form>
                        </ul>
                    </div>
            </div>
            <div class="divclear"></div>
            <div class="mt20"></div>
            <!--新增收货地址结束-->
			<div class="saveAddress bgf5">
            	<div class="atitle ">
                	<div class="fl"><a class="red-color">已保存收货地址 </a></div>
                	<div class="fr"></div>
                </div>
                <div class="addresslist">
                	<ul>
						<?php
                        $dosql->Execute("SELECT * FROM `#@__user_address` WHERE `userid`='".$r_user['id']."' order by isdefault asc ,id desc");
                        while($row = $dosql->GetArray())
                        {
                        ?>
                        <li><h1 class="f14"><?php echo $row['title']?></h1>
                        <p>收货人：<?php echo $row['username']?></p>
                        <p>所在地区：<?php
						if($row['address_prov']!='-1'){
							echo $areaArr[$row['address_prov']].' ';	
						}
						if($row['address_city']!='-1'){
							echo $areaArr[$row['address_city']].' ';	
						}
						if($row['address_country']!='-1'){
							echo $areaArr[$row['address_country']].' ';	
						}
						?>
                        </p>
                        <p>地址：<?php echo $row['address']?></p>
                        <p>手机：<?php echo $row['usermobile']?></p>
                        <p>固定电话：<?php echo $row['userphone']?></p>
                         <div class="close"><a href="?action=shipping_address_del&id=<?php echo $row['id']?>"  onclick="return confirm('确定要删除选中的信息吗？')"><img src="/images/ac.png"></a></div>
                        <div class="btnop"><?php if($row['isdefault']=='false'){echo '<a class="blue_link" href="?action=shipping_address_default&id='.$row['id'].'">设为默认地址</a>';}?><a class="blue_link" href="?action=shipping_address&id=<?php echo $row['id']?>">编辑</a></div>
                        </li>
                        <?php
						}
						?>
                    </ul>
                </div>
            </div>
            <!--已保存收货地址 结束-->
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
			"phone":function(gets,obj,curform,regxp){
				/*参数gets是获取到的表单元素值，
				  obj为当前表单元素，
				  curform为当前验证的表单，
				  regxp为内置的一些正则表达式的引用。*/

				var reg1=regxp["m"],
					reg2=/[\d]{7}/,
					mobile=curform.find(".usermobile");
				
				if(reg1.test(mobile.val())){return true;}
				if(reg2.test(gets)){return true;}
				
				return false;
			}	
		}
	});  //就这一行代码！
	
	$("#address_prov").change(function(){
		$("#communityid").html('<option value="-1">请选择社区</option>');
	});
	
	$("#address_city").change(function(){
		
		$.ajax({
		url : "/ajax.php?a=selectcommunity2&value="+$("#address_city").val(),
		type:'get',
		dataType:'html',
		success:function(data){
			$("#communityid").html(data);
		}
		});
	});
	
	$("#address_country").change(function(){
		
		$.ajax({
		url : "/ajax.php?a=selectcommunity3&value="+$("#address_country").val(),
		type:'get',
		dataType:'html',
		success:function(data){
			$("#communityid").html(data);
		}
		});
	});
})
</script>
</body>
</html>
