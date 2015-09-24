<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('community'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>社区管理</title>
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
		if('<span class="regnotenok">登陆帐号已存在</span>' == xmlHttp.responseText){
			document.getElementById('isuser').value = '0';
		}
		else{
			document.getElementById('isuser').value = '';
		}
	}
}
</script>
</head>

<?php
$row = $dosql->GetOne("SELECT * FROM `#@__community` WHERE `id`=$id");
?>

<body>
<div class="topToolbar"> <span class="title">修改社区</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>
<form name="form" id="form" method="post" action="community_save.php" onsubmit="return cfm_community2();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
			<td width="25%" height="40" align="right">社区名称：</td>
			<td width="75%"><input type="text" name="title" id="title" class="input" value="<?php echo $row['title']?>" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
			</td>
		</tr>
		
		<tr>
			<td height="40" align="right">社区地址：</td>
			<td><select name="address_prov" id="address_prov" onchange="SelProv(this.value,'address');">
					<option value="-1">请选择</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=0 ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['address_prov'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';

						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select>
				<select name="address_city" id="address_city" onchange="SelCity(this.value,'address');">
					<option value="-1">--</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=1 AND datavalue>".$row['address_prov']." AND datavalue<".($row['address_prov'] + 500)." ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['address_city'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';

						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select>
				<select name="address_country" id="address_country">
					<option value="-1">--</option>
					<?php
					$dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=2 AND datavalue LIKE '".$row['address_city'].".%%%' ORDER BY orderid ASC, datavalue ASC");
					while($row2 = $dosql->GetArray())
					{
						if($row['address_country'] === $row2['datavalue'])
							$selected = 'selected="selected"';
						else
							$selected = '';

						echo '<option value="'.$row2['datavalue'].'" '.$selected.'>'.$row2['dataname'].'</option>';
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td height="40" align="right">详情地址：</td>
			<td><input type="text" name="address" id="address" class="input" value="<?php echo $row['address']?>" /> <span class="maroon">*</span></td>
		</tr>
        
        <tr class="nb">
			<td height="40" align="right">联系人：</td>
			<td><input type="text" name="cname" id="cname" class="input" value="<?php echo $row['cname']?>"  /></td>
		</tr>
        
        <tr class="nb">
			<td height="40" align="right">联系电话：</td>
			<td><input type="text" name="phone" id="phone" class="input" value="<?php echo $row['phone']?>"  /></td>
		</tr>
        
        <tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
        
        
        
        <tr>
			<td height="40" align="right">密　码：</td>
			<td><input name="password" type="password" id="password" class="input" />
				<span class="maroon">*</span><span class="cnote">若不修改密码请留空</span></td>
		</tr>
		<tr>
			<td height="40" align="right">确　认： </td>
			<td><input name="repassword" type="password" id="repassword" class="input" />
				<span class="maroon">*</span></td>
		</tr>
        
        <tr class="nb">
			<td colspan="2" height="26"><div class="line"></div></td>
		</tr>
        
        <tr>
			<td height="40" align="right">审核：</td>
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked="checked"'; ?> />
				是 &nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked="checked"'; ?> />
				否</td>
		</tr>
		
	</table>
	<div class="formSubBtn">
		<input type="submit" class="submit" value="提交" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" name="userid" id="userid" value="<?php echo $row['userid']?>" />
        <input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
	</div>
</form>
</body>
</html>