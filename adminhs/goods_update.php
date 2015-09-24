<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('goods'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改商品信息</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getjcrop.js"></script>
<script type="text/javascript" src="templates/js/getinfosrc.js"></script>
<script type="text/javascript" src="plugin/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<script type="text/javascript" src="editor/lang/zh_CN.js"></script>
<script type="text/javascript">
function GetAttr(tid)
{
	$.ajax({
		url : "ajax_do.php?action=goodsattr&tid="+tid,
		type:'get',
		dataType:'html',
		beforeSend:function(){
			$("#getattr").html('<div class="loading" style="width:140px;margin:0 auto;">自定义属性读取中...</div>');
		},
		success:function(data){
			$('#getattr').html(data);
		}
	});
}
</script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__goods` WHERE `id`=$id");
?>
<div class="formHeader"> <span class="title">修改商品信息</span> <a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="goods_save.php" onsubmit="return cfm_goods();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr style="display:none;">
			<td width="25%" height="40" align="right">栏　目：</td>
			<td width="75%"><!--<select name="classid" id="classid">
					<option value="-1">请选择所属栏目</option>
					<?php CategoryType(4); ?>
				</select>-->
                <input type="hidden" name="classid" value="27" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
        <tr>
			<td width="25%" height="40" align="right">商品名称：</td>
			<td><input type="text" name="title" id="title" class="input" value="<?php echo $row['title']; ?>" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
        <tr>
			<td width="25%" height="40" align="right">商品价格：</td>
			<td style="line-height:25px;">
            <?php
			//分割店铺价格
			$price = explode(',',$row['price']);
			$marketprice = explode(',',$row['marketprice']);
			$promotions_price = explode(',',$row['promotions_price']);
			$guige = explode(',',$row['guige']);
            for($i=0,$n=count($price);$i<$n;$i++)
			{
			?>
            价格：<input type="text" name="price[]" class="inputs" style="width:50px;" value="<?=$price[$i]?>" datatype="float" nullmsg="请输入店铺价格！"  placeholder="价格" onkeyup="jsmarkprice(this)" />
                        市场价：<input type="text" name="marketprice[]" class="inputs" style="width:50px;" value="<?=$marketprice[$i]?>" datatype="float" nullmsg="请输入市场价格！"  placeholder="市场价格" />
                        促销价格：<input type="text" name="promotions_price[]" class="inputs" style="width:50px;" value="<?=$promotions_price[$i]?>" datatype="float" nullmsg="请输入店铺促销价格！"  placeholder="促销价格" />  
                        规格：<input type="text" name="guige[]" class="inputs" style="width:50px;" value="<?=$guige[$i]?>" datatype="*" nullmsg="请输入规格！" placeholder="规格" /> <br />
            <?php
			}
			?>
            </td>
		</tr>
        <tr>
			<td height="40" align="right">库存数量：</td>
			<td><input type="text" name="housenum" id="housenum" class="input" value="<?php echo $row['housenum']; ?>" /></td>
		</tr>
		<tr>
			<td height="40" align="right">商品分类：</td>
			<td><select name="typeid" id="typeid" onchange="GetAttr(this.value)">
					<option value="-1">请选择所属分类</option>
					<?php GetAllType('#@__goodstype','#@__goods','typeid'); ?>
				</select></td>
		</tr>
        
		<tr>
			<td height="40" align="right">商品品牌：</td>
			<td><select name="brandid" id="brandid">
					<option value="-1">请选择所属品牌</option>
                    <?php
					$dosql->Execute("SELECT id,classname FROM `#@__goodstype` WHERE parentid=0 and checkinfo='true' ORDER BY orderid asc ,id ASC");
					while($r_pid = $dosql->GetArray()){
					?>
                    <optgroup label="<?php echo $r_pid['classname']?>">
                    <?php
                    $dosql->Execute("SELECT * FROM `#@__goodsbrand` WHERE parentid='".$r_pid['id']."' and checkinfo='true' ORDER BY `orderid` ASC",$r_pid['id']);
					while($r_bid = $dosql->GetArray($r_pid['id'])){
					?>
                    <option value="<?php echo $r_bid['id']?>" <?php if($row['brandid']==$r_bid['id']){echo ' selected="selected"';}?>><?php echo $r_bid['classname']?></option>
                    <?php
					}
					?>
                    </optgroup>
                    <?php
					}
					?>
				</select></td>
		</tr>
		<tr>
			<td height="40" align="right">商品产地：</td>
			<td><select name="shop_addressid" id="shop_addressid">
					<option value="-1">请选择所属品牌</option>
					<?php GetAllType('#@__goodsaddress','#@__goods','shop_addressid'); ?>
				</select></td>
		</tr>        
		
		
		<tr class="nb">
			<td height="40" align="right">商品状态：</td>
			<td><input type="radio" name="issale" value="true" <?php if($row['issale'] == 'true') echo 'checked="checked"'; ?> />
				上架 &nbsp;
				<input type="radio" name="issale" value="false" <?php if($row['issale'] == 'false') echo 'checked="checked"'; ?> />
				下架<td>
		</tr>
        
		
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"> </div></td>
		</tr>
		
		<tr>
			<td height="40" align="right">缩略图片：</td>
			<td><input type="text" name="picurl" id="picurl" class="input" value="<?php echo $row['picurl']; ?>" />
				<span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'picurl')">上 传</span> <span class="rePicTxt">
				<input type="checkbox" name="rempic" id="rempic" value="true" />
				远程</span> <span class="cutPicTxt"><a href="javascript:;" onclick="GetJcrop('jcrop','picurl');return false;">裁剪</a></span> </span></td>
		</tr>
		
		<tr>
			<td height="340" align="right">详细内容：</td>
			<td><textarea name="content" id="content" class="kindeditor"><?php echo $row['content']; ?></textarea>
				<script>
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="content"]', {
						allowFileManager : true,
						width:'667px',
						height:'280px',
						extraFileUploadParams : {
							sessionid :  '<?php echo session_id(); ?>'
						}
					});
				});
				</script>
				</td>
		</tr>
		<tr class="nb">
			<td height="124" align="right">组　图：</td>
			<td><fieldset class="picarr">
					<legend>列表</legend>
					<div>最多可以上传<strong>50</strong>张图片<span onclick="GetUploadify('uploadify2','组图上传','image','image',50,<?php echo $cfg_max_file_size; ?>,'picarr','picarr_area')">开始上传</span></div>
					<ul id="picarr_area">
						<?php
					if($row['picarr'] != '')
					{
						$picarr = unserialize($row['picarr']);
						foreach($picarr as $v)
						{
							$v = explode(',', $v);
							echo '<li rel="'.$v[0].'"><input type="text" name="picarr[]" value="'.$v[0].'"><a href="javascript:void(0);" onclick="ClearPicArr(\''.$v[0].'\')">删除</a><br /><input type="text" name="picarr_txt[]" value="'.$v[1].'"><span>描述</span></li>';
						}
					}
					?>
					</ul>
				</fieldset></td>
		</tr>
		<tr class="nb">
			<td colspan="2" height="26"><div class="line"> </div></td>
		</tr>
		
		
        <tr class="nb">
			<td height="40" align="right">商品促销：</td>
			<td><input type="radio" name="promotions" value="true" <?php if($row['promotions'] == 'true') echo 'checked="checked"'; ?> />
				是 &nbsp;
				<input type="radio" name="promotions" value="false" <?php if($row['promotions'] == 'false') echo 'checked="checked"'; ?> />
				否</td>
		</tr>
        
		<tr>
			<td height="40" align="right">促销开始时间：</td>
			<td><input name="promotions_starttime" type="text" id="posttime" class="inputms" value="<?php echo GetDateTime($row['promotions_starttime']); ?>" readonly="readonly" />
				<script type="text/javascript">
				date = new Date();
				Calendar.setup({
					inputField     :    "posttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
        <tr>
			<td height="40" align="right">促销结束时间：</td>
			<td><input name="promotions_endtime" type="text" id="posttime2" class="inputms" value="<?php echo GetDateTime($row['promotions_endtime']); ?>" readonly="readonly" />
				<script type="text/javascript">
				date = new Date();
				Calendar.setup({
					inputField     :    "posttime2",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
		
        <tr class="nb">
			<td height="40" align="right">审核：</td>
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo'] == 'true') echo 'checked="checked"'; ?> />
				是 &nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo'] == 'false') echo 'checked="checked"'; ?> />
				否<span class="cnote">选择“否”则该信息暂时不显示在前台</span></td>
		</tr>
        
	</table>
	<div class="formSubBtn">
		<input type="submit" class="submit" value="提交" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="cid" id="cid" value="<?php echo $row['classid']; ?>" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	</div>
</form>
</body>
</html>