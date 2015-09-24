<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('coupon'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加优惠券</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getjcrop.js"></script>
<script type="text/javascript" src="/include/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<div class="formHeader"> <span class="title">添加优惠券</span> <a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="coupon_save.php" onsubmit="return cfm_coupon();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		
        <tr>
			<td width="25%" height="40" align="right">使用范围：</td>
			<td width="75%">
            	<select name="classid" id="classid">
					<option value="0">不限</option>
					<?php
                    $dosql->Execute("SELECT id,classname FROM `#@__goodstype` WHERE `parentid`='0' and checkinfo='true' ORDER BY orderid ASC, id ASC");
					while($row = $dosql->GetArray())
					{
						echo '<option value="'.$row['id'].'">'.$row['classname'].'</option>';
					}
					?>
				</select>
				<span class="maroon">*</span></td>
		</tr>
        
		<tr>
			<td height="40" align="right">优惠券名称：</td>
			<td><input type="text" name="title" id="title" class="input" /><span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="40" align="right">优惠券图片：</td>
			<td><input type="text" name="picurl" id="picurl" class="input" /><span class="maroon">*</span>
				<span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span> <span class="cutPicTxt"><a href="javascript:;" onclick="GetJcrop('jcrop','picurl');return false;">裁剪</a></span></span></td>
		</tr>
		<tr>
			<td height="40" align="right">优惠金额：</td>            
            <td><input type="text" name="price" id="price" class="input" onkeyup="value=value.replace(/[^\d]/g,'')" /><span class="maroon">*</span><span class="cnote">请填写数字</span></td>
		</tr>
        
        <tr>
			<td height="40" align="right">使用条件：</td>
			<td><input type="text" name="overprice" id="overprice" class="input" onkeyup="value=value.replace(/[^\d]/g,'')" /><span class="maroon">*</span><span class="cnote">请填写数字，满多少金额才能使用</span></td>
		</tr>
        
        <tr>
			<td height="40" align="right">优惠券数量：</td>
			<td><input type="text" name="num" id="num" class="input" value="0"  onkeyup="value=value.replace(/[^\d]/g,'')" /><span class="maroon">*</span><span class="cnote">数量为0则不限</span></td>
		</tr>
        
        <tr>
			<td height="40" align="right">已领数量：</td>
			<td><input type="text" name="hasnum" id="hasnum" class="input" value="0"  onkeyup="value=value.replace(/[^\d]/g,'')" /></td>
		</tr>
        
        <tr>
			<td height="40" align="right">领取日期：</td>
			<td>
            <input type="text" name="starttime" id="starttime" class="input Wdate" onClick="WdatePicker()" style="width:122px;" value="<?php echo date('Y-m-d',time())?>" /> —&nbsp; 
            <input type="text" name="endtime" id="endtime" class="input Wdate" onClick="WdatePicker()" style="width:122px;" value="<?php echo date('Y-m-d',strtotime("+1 month"))?>"  /><span class="maroon">*</span><span class="cnote">结束日期必须大于开始日期</span>
            </td>
		</tr>
        
        <tr>
			<td height="40" align="right">使用日期：</td>
			<td>
            <input type="text" name="validity_strat" id="validity_strat" class="input Wdate" onClick="WdatePicker()" style="width:122px;" value="<?php echo date('Y-m-d',time())?>" /> —&nbsp;
            <input type="text" name="validity_end" id="validity_end" class="input Wdate" onClick="WdatePicker()" style="width:122px;" value="<?php echo date('Y-m-d',strtotime("+1 month"))?>"  /><span class="maroon">*</span><span class="cnote">结束日期必须大于开始日期</span>
            </td>
		</tr>
        
       
        
		<tr>
			<td height="40" align="right">排列顺序：</td>
			<td><input type="text" name="orderid" id="orderid" class="inputs" value="<?php echo GetOrderID('#@__coupon'); ?>" /></td>
		</tr>
		<tr class="nb">
			<td height="40" align="right">首页推荐：</td>
			<td><input type="radio" name="checkinfo" value="true"  />
				是&nbsp;
				<input type="radio" name="checkinfo" value="false" checked="checked" />
				否</td>
		</tr>
	</table>
	<div class="formSubBtn">
		<input type="submit" class="submit" value="提交" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="add" />
	</div>
</form>
</body>
</html>