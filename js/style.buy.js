$(function(){
	var id = $_GET['id'];
	//立即购买
	$(".nowBuy").click(function(){
		buycar(this,id);
	})
	//加入购物车
	$(".addBuyCar").click(function(){
		buycar(this,id);
	})
	$("#dd").click(function(){
		createDD();
	})
});

function buyCar(ev,id,shopid,type)
{
	if($(ev).attr('state') == null){ return false; }
	else
	{
		var num = parseInt($(".num").val());		//num
		var weight = $(".detail_guige li.on").text(); 		//guige
		var price = $(".promotions_price i label").text()
		
		if(weight == ''){alert('请选择规格'); return false;}
		
		$.post('/Action/buy.php',"type=buyCar&id="+id+"&price="+price+"&shopid="+shopid+"&weight="+weight+"&num="+num,function(rr){

			if(type == 'nowBuy'){ window.location.href="/member/buy/mybuycar.php";}
			if(type == 'addBuyCar'){ alert(rr); }
			
		})
	}
}
//结算
function Clearing()
{
	var sum = parseFloat($("#total_price").text());
	if(sum == 0){alert('请选择商品'); return false; }
	if(document.cookie.indexOf('username=') <= 0){ alert('请先登录'); window.location.href='/member.php?c=login';}
	//var tag = 'id=' + $('#checkedGoods').text();
	$.post('/Action/buy.php','type=Clearing&idArr='+ $('#checkedGoods').text(),function(){
		window.location.href="/member/buy/order.php";
	});
}
//计算可用积分
function useIntegral(ev)
{
	SumOrder();
	var i = parseInt($(".integral").text());
	var val = parseInt($(ev).val());
	var sum = parseFloat($(".second_l .sum").text());	
	if (isNaN(val) || val <= 0 || val > i) {
		val = i;
	}
	if (ev.value != val) {
		ev.value = val;
	}
	$(".useIntegral").text(val);
	sum = parseFloat(sum - val * 0.02).toFixed(2);
	$('.sum').text(sum);
		
}
//结算订单
function SumOrder()
{
	var price = new Array();
	var integral = new Array();
	var num = new Array();
	var AllNum = '';
	var GoodsPrice = '';
	var GetIntegral = '';
	$(".qindan .qindan_n").each(function() {
        var i = 0;
		$(this).find(".qindan_ma ul").eq(1).find('li').each(function(index, element) {
        	price[i] = parseFloat($(this).find(".red p span").text());
			integral[i] = parseInt($(this).find('.jifen p span').text());
    		i++;
		});
		i=0;
		$(this).find(".qindan_ma ul").eq(2).find('li').each(function(index, element) {
        	num[i] = parseInt($(this).find("p span").text());
			i ++ ;
		});
		for(i=0,n=price.length;i<n;i++)
		{
			AllNum = parseInt(AllNum + num[i]);
			GoodsPrice  = parseFloat(GoodsPrice + price[i] * num[i]);
			GetIntegral = parseInt(GetIntegral + integral[i]* num[i]);
		}
    });
	$(".AllNum").text(AllNum);
	$(".getIntegral").text(GetIntegral);
	$(".GoodsPrice").text(GoodsPrice);
	//应付总额
	var sum = parseFloat($(".fare").text()) + GoodsPrice;
	$(".sum").text(sum);
}
//生成订单
function createDD()
{
	var username 		= $('.xinxi_m ul li.on .username').text();
	var address_prov 	= $('.xinxi_m ul li.on .prov').text();
	var address_city 	= $('.xinxi_m ul li.on .city').text();
	var address_country = $('.xinxi_m ul li.on .country').text();
	var address 		= $('.xinxi_m ul li.on .address').text();
	var usermobile  	= $('.xinxi_m ul li.on .usermobile').text();
	var goodsid 		= $("input[name='goodsid']").val();
	var getintegral 	= $(".second_l ul .getIntegral").text();
	var useIntegral 	= $(".second_l ul .useIntegral").text();
	var fare 			= $(".second_l ul .fare").text();
	var remark 			= $(".qindan_f input").val();
	var sum				= $(".second_l ul .sum").text();
	var paypost         = $(".first_f .first_ff.on font").text();
	//获取优惠卷ID
	var Coupon 			= $(".coupon:checked").val();
	
	//console.log(useIntegral);
	//return false;
	
	if(username == ''){ alert('请添加收货地址'); return false;}
	if(goodsid == ''){ alert('订单有误'); return false;}	
	if(sum == 0){ alert('金额有误'); return false;}	
	
	$.ajax({
		url:"/Action/buy.php",
		type:'post',
		data:{'type':'createDD','adress_username':username,'address_prov':address_prov,'address_city':address_city,'address_country':address_country,'address':address,'usermobile':usermobile,'goodsid':goodsid,'getintegral':getintegral,'useintegral':useIntegral,'fare':fare,'remark':remark,'sum':sum,'paypost':paypost,'Coupon':Coupon},
		beforeSend: function(){},
		success:function(data)
		{
			if(data == 'success' && paypost == '在线支付')
			{	
				window.location.href='/data/api/unionpay/unionpay.config2.php';	
			}
			else  if(data == 'success' && paypost == '钱包支付')
			{
				window.location.href='/member/buy/wallet.php';
			}	
		}
	})
	//console.log(paypost);
}
