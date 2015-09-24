<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('member'); 

$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' ORDER BY orderid ASC, datavalue ASC");
while($row = $dosql->GetArray())
{
	$areaArr[$row['datavalue']]=$row['dataname'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改店铺</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getarea.js"></script>
<script type="text/javascript">
var xmlHttp;

function xmlhttprequest(){
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	else if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}
	else{
		alert('您的浏览器不支持Ajax技术！');
	}
}


//用户名检测
function CheckUser(){
	if(document.form.username.value == ''){
		document.getElementById('usernote').innerHTML = '　';
	}
	else{
		if(document.form.username.value.length < 4){
			document.getElementById('usernote').innerHTML = '<span class="regnotenok">用户名小于4位</span>';
			return;
		}
		xmlhttprequest();
		var username = document.getElementById('username').value;
		var url = "ajax_do.php?"+parseInt(Math.random()*(15271)+1)+'&action=checkuser&username='+username;
		xmlHttp.open("GET", url, true);
		xmlHttp.onreadystatechange = check_done;
		xmlHttp.send(null);
	}
}


function check_done(){
	if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
		document.getElementById('usernote').innerHTML = xmlHttp.responseText;
		if('<span class="regnotenok">用户名已存在</span>' == xmlHttp.responseText){
			document.getElementById('isuser').value = '0';
		}
		else{
			document.getElementById('isuser').value = '';
		}
	}
}
</script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__shops` WHERE `id`=$id");
$r   = $dosql->GetOne("SELECT id,checkinfo FROM `#@__member` where id='".$row['userid']."'");
?>
<div class="formHeader"> <span class="title">修改店铺</span> <a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="shops_save.php" onsubmit="return cfm_upshops();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
			<td width="25%" height="40" align="right">店铺名称：</td>
			<td width="75%"><input type="text" name="shopname" id="shopname" class="input" value="<?php echo $row['shopname']; ?>" /></td>
		</tr>
		
		<tr>
			<td height="40" align="right">店主姓名：</td>
			<td><input type="text" name="shop_username" id="shop_username" class="input" value="<?php echo $row['shop_username']; ?>" /></td>
		</tr>
        <tr>
			<td height="40" align="right">公司名称：</td>
			<td><input type="text" name="shopcompany" id="shopcompany" class="input" value="<?php echo $row['shopcompany']; ?>" /></td>
		</tr>
        
        <tr>
			<td height="40" align="right">店铺电话：</td>
			<td><input type="text" name="shop_tel" id="shop_tel" class="input" value="<?php echo $row['shop_tel']; ?>" /></td>
		</tr>
		
		<tr>
			<td height="40" align="right">店铺地址：</td>
			<td><select name="shop_prov" id="address_prov" onchange="SelProv(this.value,'address');">
					<option value="-1">请选择</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=0 ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['shop_prov'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';

						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select>
				<select name="shop_city" id="address_city" onchange="SelCity(this.value,'address');">
					<option value="-1">--</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=1 AND datavalue>".$row['shop_prov']." AND datavalue<".($row['shop_prov'] + 500)." ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['shop_city'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';

						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select>
				<select name="shop_town" id="address_country">
					<option value="-1">--</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=2 AND datavalue LIKE '".$row['shop_city'].".%%%' ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['shop_town'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';

						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select></td>
		</tr>
		<tr>
			<td height="40" align="right">&nbsp;</td>
			<td><input type="text" name="shop_address" id="shop_address" class="input" value="<?php echo $row['shop_address']; ?>" /></td>
		</tr>
		<tr>
			<td height="40" align="right">营业状态：</td>
			<td><input name="checkinfo" type="radio" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked="checked"'; ?> />
				营业中&nbsp;
				<input name="checkinfo" type="radio" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked="checked"'; ?> />
				休息中</td>
		</tr>
        <tr>
			<td height="40" align="right">配送区域：</td>
			<td style="line-height:20px;">
            <?php
			$arr=array();
            $sql = "SELECT address_city,title FROM `#@__community` WHERE id in(".$row['delivery_area'].") and checkinfo='true' ";
			$row=$dosql->Execute($sql);
			while($row = $dosql->GetArray()){
				$arr[]=$row;
			}
			
									
			$arr2 = array();
			foreach($arr as $k1 => $v1) {
				if(empty($arr2)) {
					$arr2[] = $v1;
				}else {
					foreach ($arr2 as &$v2) {
						if($v1['address_city'] == $v2['address_city']) {
							$v2['title'] .= '，'.$v1['title'];   
						} else {
							$arr2[] = $v1;
						}
					}
				}
			}
									
			foreach($arr2 as $k => $v){
				echo '<div>'.$areaArr[$v['address_city']].'（'.$v['title'].'）</div>';
			}								
			?>
            </td>
		</tr>
        <tr>
			<td height="40" align="right">审核：</td>
			<td><input name="shopcheck" type="radio" value="true" <?php if($r['checkinfo'] == 'true') echo 'checked="checked"'; ?> />
				已审&nbsp;
				<input name="shopcheck" type="radio" value="false" <?php if($r['checkinfo'] == 'false') echo 'checked="checked"'; ?> />
				未审</td>
		</tr>
	</table>
	<div class="formSubBtn">
		<input type="submit" class="submit" value="提交" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
        <input type="hidden" name="userid" id="userid" value="<?php echo $r['id']; ?>" />
	</div>
</form>
</body>
</html>