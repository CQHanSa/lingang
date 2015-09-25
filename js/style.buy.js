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
});

function buyCar(ev,id,shopid,type)
{
	if($(ev).attr('state') == null){ return false; }
	else
	{
		var num = parseInt($(".num").val());		//num
		var weight = $(".detail_guige li.on").text(); 		//guige
		var price = $(".promotions_price i").text()
		$.post('/Action/buy.php',"type=buyCar&id="+id+"&price="+price+"&shopid="+shopid+"&weight="+weight+"&num="+num,function(rr){

			if(type == 'nowBuy'){ window.location.href="/member/buy/mybuycar.php";}
			if(type == 'addBuyCar'){ alert(rr); }
			
		})
	}
}