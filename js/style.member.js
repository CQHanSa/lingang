$(function(){
	
});

//获取城市
function showCity(obj)
{
		var county = $(obj).next('select');
		var town = $(obj).next().next('select');
		var city = $(obj).val();
		if(county == 'null'){ return false; }
		$.ajax({
			url:"/Action/member.php",
			type:"GET",
			data:"type=city&city="+city,
			success: function(rr)
			{
				//alert(rr);
				county.html('');
				county.html(rr);
				//获取区县值
				if(town == 'null'){ return false; }
				//var countyValue = county.find("option:selected").next().val();
				var countyValue = county.find("option:selected").val();
				//console.log(countyValue);
				$.ajax({
					url:"/Action/member.php",
					type:"GET",
					data:"type=county&county="+countyValue,
					success: function(ss)
					{
						//alert(ss);
						if(ss != '<option value="-1">请选择</option>' && ss != '')
						{
							town.css('display','');
							town.html('');
							town.html(ss);
						}else
						{
							town.css('display','none');
							//alert(ss);
						}
					}	
				})
				//---end
			}
		})
		
}

function showCounty(obj)
{
		var countyValue = $(obj).val();
		var town = $(obj).next('select');
		$.ajax({
			url:"/Action/member.php",
			type:"GET",
			data:"type=county&county="+countyValue,
			success: function(ss)
			{
				//alert(ss);
				if(ss != '<option value="-1">请选择</option>' && ss != '' )
				{
					town.css('display','');
					town.html('');
					town.html(ss);
				}else
				{
					town.css('display','none');
					//alert(ss);
				}
			}	
		})		
		//---end
}

//添加店铺收藏
function addShopCollcetion(id)
{
	$.post('/Action/member.php','type=addShopCollcetion&shopid='+id,function(rr){
		alert(rr);
	})
}
//删除店铺收藏
function delShopCollection(id,obj)
{
	if(confirm('确认取消该店铺收藏？'))
	{
		$.post('/Action/member.php','type=delShopCollection&shopid='+id,function(rr){
			if(rr == '已取消关注')
			{
				alert(rr);
				$(obj).parent().parent().parent().remove();
			}
		})
	}
	
}
//添加商品收藏
function addGoodsCollection(id)
{
	$.post('/Action/member.php','type=addGoodsCollection&id='+id,function(rr){
		alert(rr);
	})
}
//删除单个商品收藏
function delGoodsCollection(id,obj)
{
	$.post('/Action/member.php','type=delGoodsCollection&id='+id,function(rr){
		if(rr == '已取消关注')
		{
			alert(rr);
			$(obj).parent().parent().remove();
		}
	})
}