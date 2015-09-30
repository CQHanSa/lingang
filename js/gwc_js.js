// JavaScript Document


	//计算价格
$(document).ready(function(){
	
	$(".gwc_splb").each(function(){
				$(this).find('tbody tr').each(function() {
					var price  = parseFloat($(this).find('.price').html());
					var num = parseInt($(this).find('.num').val());
					$(this).find('.small_j').text(price);
					var sum_price = unit_price(num,price);
					$(this).find('.small_j').text(sum_price);
                });
		})
	
	total_price();
	
	/* 购物车全选 */
	$('.all_check').click(function(){
		$('.all_check').toggleClass('on');
		if($(this).hasClass('on'))
		{
			$(this).find('input').attr("checked","checked");
			$('samp').addClass('on');
			$('samp input').attr("checked","checked");
			unit_price();
			
			//console.log($(this).parent().parent().parent().parent().find('tbody tbody tr .gwc_sp_img').html());
			//增加ID
			$(this).parent().parent().parent().parent().find('tbody tbody tr .gwc_sp_img input').each(function(){
                 var checkedGoods = stringMatch($("#checkedGoods").text(),$(this).val(),',');
				$("#checkedGoods").text(checkedGoods[1]);
            });
			
		}else
		{
			$(this).find('input').removeAttr("checked");
			$('samp').removeClass('on');
			$('samp input').removeAttr("checked");
			//删除ID
			$(this).parent().parent().parent().parent().find('tbody tbody tr .gwc_sp_img input').each(function(){
                 var checkedGoods = stringMatch($("#checkedGoods").text(),$(this).val(),',');
				$("#checkedGoods").text(checkedGoods[1]);
            });			
		}
		var total = total_price();
		$('#total_price').html(total);
		
	});
	
	//点击店铺列表
	//var dpnum = $(".dp_check").length; //店铺总个数
	//var spnum = $(".sp_check").length; //商品总个数
	$(".dp_check").click(function(){
		$(this).toggleClass('on');
		if($(this).hasClass('on'))
		{
			$(this).find('input').attr("checked","checked");
			$(this).parent().parent().parent().siblings().find('samp').addClass('on');
			$(this).parent().parent().parent().siblings().find('input').attr("checked","checked");
			
			//console.log($(this).parent().parent().parent().parent().find('tbody tr .gwc_sp_img input').html());
			//增加ID			
			$(this).parent().parent().parent().parent().find('tbody tr .gwc_sp_img input').each(function() {
               //alert($(this).val());
			   var checkedGoods = stringMatch($("#checkedGoods").text(),$(this).val(),',');
				$("#checkedGoods").text(checkedGoods[1]);
            });

			
		}else
		{
			$(this).find('input').removeAttr("checked");
			$(this).parent().parent().parent().siblings().find('samp').removeClass('on');
			$(this).parent().parent().parent().siblings().find('input').prop("checked",false);
			$('.all_check').removeClass('on');
			$(this).find('input').removeAttr("checked");
			
			//去除ID
			$(this).parent().parent().parent().parent().find('tbody tr .gwc_sp_img input').each(function() {
               //alert($(this).val());
			   var checkedGoods = stringMatch($("#checkedGoods").text(),$(this).val(),',');
				$("#checkedGoods").text(checkedGoods[1]);
            });			
		}
		var total = total_price();
		$('#total_price').html(total);
	});
	
	//点击商品列表
	$(".sp_check").click(function(){
		
		//增加ID
		var checkedGoods = stringMatch($("#checkedGoods").text(),$(this).find('input').val(),',');
		$("#checkedGoods").text(checkedGoods[1]);
		
		$(this).toggleClass('on');
		if($(this).hasClass('on'))
		{
			$(this).find('input').attr("checked",'checked');
			unit_price();
		
		}else
		{
			//店铺全选状态
			var allShopState = $(this).parent().parent().parent().parent().parent().find('.dp_check');
			if(allShopState.find('input').attr('checked') == 'checked')
			{
				//取消状态
				allShopState.find('input').removeAttr('checked');
				allShopState.removeClass('on');
				//取消顶部全选状态
			}
			//取消顶部全选状态
			$('.all_check').removeClass('on');
			$('.all_check').find('input').removeAttr('checked');
			
			$(this).find('input').removeAttr("checked","checked");
			$(this).parent().parent().parent().siblings().find('.dp_check').removeClass('on');
			$(this).parent().parent().parent().siblings().find('.dp_check input').removeAttr('checked');
		}
		var total = total_price();
		$('#total_price').html(total);
	});
	
	//输入数值的时候
	$(".num").keyup(function(){
		var tr = $(this).parent().parent().parent();
		var price = parseFloat(tr.find(".gwc_dj .price").html());
		var ev = $(this).next();
		var val = parseInt(this.value);
		if (isNaN(val) || val <= 0) {
			val = 1;
		}
		if (this.value != val) {
			this.value = val;
		}
		var sum = ( price * val ).toFixed(2);
		tr.find(".small_j").text(sum);
		var total = total_price();
		$('#total_price').html(total)
	})
	
});
	

function updatedProducts(num,ev,id){
	var ret_num ='';
	var num = parseInt(num);
	var numObj = $(ev).parent().find('input.num');
	var unit_price_obj = $(ev).parent().parent('td').next().find('.small_j');
	var price =parseFloat($(ev).parents('tr').children().eq(2).find(".price").html()).toFixed(2);
	var buyNum = parseInt(numObj.val());
	
	if( num == -1) {
		ret_num = buyNum+num < 1 ? 1 : buyNum+num;
	} else {
		ret_num = buyNum+num;
	} 
	//alert( oldNum);
	numObj.val(ret_num);
	
	//修改产品数量
	$.post('/Action/buy.php',"type=editorBuyCarNum&num="+ret_num+"&id="+id);
	
	
	price = unit_price(ret_num,price);
	unit_price_obj.html(price);
	var total = total_price();
	$('#total_price').html(total);
}


//计算单价
function unit_price(num,price) {
	return parseFloat(num*price).toFixed(2);
} 
 //统计总价
function total_price() {
	 var total 	  = 0;	//总价
	 var totalNum = 0; //总共数量
	$('#cartTable>tbody>tr').each(function(){
		var ev = this;
		$('tbody>tr',ev).each(function(){
			if($(this).find('.sp_check label input').attr("checked") === 'checked')
			{
				//alert($(this).find('.sp_check label input').attr("checked"));
				totalNum  = totalNum + parseInt($('.gwc_sp_num input',this).val());
				total     = total + Number(parseFloat($('.small_j',this).html()));	
			}
		})
	})
	$(".totalNum").text(totalNum);
	return total.toFixed(2);
}

//删除商品
function delRow(ev,id)
{
	if(confirm('确定删除该商品？'))
	{
		var total = total_price();
		var shop = $(ev).parent().parent().parent().parent().find("tbody tr").length
		if(shop == 1)
		{
			$(ev).parent().parent().parent().parent().find('thead').remove();
		}
		$(ev).parent().parent().remove();
		
		//删除商品
		$.post('/Action/buy.php',"type=delBuyCarGoods&id="+id);
		
		var total = total_price();
		$('#total_price').html(total);
	}
}
//删除选中的商品
function delRows()
{
	if(confirm('确定删除选中的商品？'))
	{
		var delID = '';
		$('#cartTable>tbody>tr').each(function(){
			$('tbody>tr',this).each(function(){
				if($(".sp_check input",this).attr('checked') == 'checked')
				{
					delID = delID + $(".sp_check input",this).val() + ','; 
					if($(this).parent().parent().find('tr').length == 2)
					{
						$(this).parent().parent().find('thead').remove();
					}
					//console.log($(this).parent().parent().find('thead').length);
					$(this).remove();
				}
				//console.log($(".sp_check input",this).attr('checked'));
			});
			if($(".dp_check input",this).attr('checked') == 'checked'){$("thead",this).remove();}
		});
		delID = delID.substr(0,delID.length-1);
		console.log(delID);
		$.post('/Action/buy.php',"type=delBuyCarGoods&id="+delID);
		var total = total_price();
		$('#total_price').html(total);
	}
}