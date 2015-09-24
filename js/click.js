// JavaScript Document

/* 底部 */
$(function(){
	//商品筛选点击展开
	//console.log($(".price").html());
	
	$(".splb_sq").click(function(){
		var h = parseInt($(this).parent().height());
		
		var true_h = $(this).parent().attr('rel');
		if(true_h > h && (h + 4) != true_h ){
			$(this).parent().animate({'height':true_h + 'px'},500);
			$(this).text('收起');
			//alert(o);
		}
		else if(true_h <= h){
			$(this).parent().animate({'height': '20px'},500);
			$(this).text('展开');
		}
	});
	
	$(".blue_link").click(function(){
		var userlabel = document.getElementById('userlabel');
		var blue_link = document.getElementById('blue_link');
		var yx = document.getElementById('email');
		var sj = document.getElementById('mobile');
		//var gettelcode = document.getElementById('gettelcode');
		var userl_dx = document.getElementById('userl_dx');
		//alert(blue_link.innerHTML);
		if($(this).text() == "验证邮箱"){
			blue_link.text = "验证手机";
			userlabel.innerHTML = "验证邮箱：";
			$(this).parent().siblings('#mobile').attr('type','hidden');
			$(this).parent().siblings('#email').attr('type','text');
			userl_dx.innerHTML ="邮箱验证：";
			$("#gettelcode").attr('onclick','sendMessage2()');
			$("#gettelcode").val("获取邮箱验证码");
		}else if($(this).text() == "验证手机"){
			blue_link.text = "验证邮箱";
			userlabel.innerHTML = "验证手机：";
			$(this).parent().siblings('#email').attr('type','hidden');
			$(this).parent().siblings('#mobile').attr('type','text');
			userl_dx.innerHTML ="短信验证：";
			$("#gettelcode").attr('onclick','sendMessage()');
			$("#gettelcode").val("获取短信验证码");
		}
	});
	
	$(".add_typecy li").click(function(){
		$(this).children().toggleClass('on');
		$(this).parent().siblings('ul').slideToggle('fast');
	});
	
	$(".detail_guige ul li").click(function(){
		$(this).toggleClass('on');
		$(this).siblings().removeClass('on');
	});
	
	$(".pro_fl ul li").click(function(){
		var i = $(this).index();
		$(".guige_cs").eq(i).css('display','block').siblings().css('display','none');
	});
	
	/* 结算页 */
	$(".first_f div").click(function(){
		$(this).addClass('on').siblings('div').removeClass('on');
	});
	
	$(".xinxi_m ul li").click(function(){
		$(this).addClass('on').siblings().removeClass('on');
	});
	
	$(".xinxi_f").click(function(){
		$(".xinxi_m ul li:gt(0)").slideToggle('fast');
	});
	
	$(".qindan_qh div").click(function(){
		$(this).addClass('on').siblings().removeClass('on');
	});
	
	$(".all_xz").click(function(){
		$(".all_xz").addClass('on');
		$(".collgoodslist ul li a div:nth-child(2)").addClass('on');
		$(".collgoods").find('.shoplogo div').addClass('on');
	});
	$(".qx_xz").click(function(){
		$(".all_xz").removeClass('on');
		$(".collgoodslist ul li a div:nth-child(2)").removeClass('on');
		$(".collgoods").find('.shoplogo div').removeClass('on');
	});
	
	$(".goodstab ul li").click(function(){
		 var i = $(this).index();
		 $(this).addClass('cur').siblings().removeClass('cur');
		 $(".goodlist").children().eq(i).css('display','block');
		 $(".goodlist").children().eq(i).siblings().css('display','none');
	});
	
	/* 商品管理 全选 */
	$(".sp_cz thead tr td:first-child div").click(function(){
		$(this).toggleClass('on');
		$(".sp_cz tbody tr td:first-child div").toggleClass('on');
	});
	/* 单选 */
	$(".sp_cz tbody tr td:first-child div").click(function(){
		$(this).toggleClass('on');
		$(".sp_cz thead tr td:first-child div").removeClass('on');
	});
	
	/* 全选 */
	$(".gwc_splb thead td div").click(function(){
		$(this).toggleClass('on');
		$(".gwc_splb").find('samp').toggleClass('on');
		$(".gwc_js span.t_left div").toggleClass('on');
		
	});	
	$(".gwc_js span.t_left div").click(function(){
		$(this).toggleClass('on');
		$(".gwc_splb").find('samp').toggleClass('on');
		$(".gwc_splb thead td div").toggleClass('on');
	});
	
	/* 单选 */
	$(".gwc_splb tbody tr:nth-child(1) td samp").click(function(){
		$(this).toggleClass('on');
		$(this).parent().parent().siblings().find('samp').toggleClass('on');
	});
	/* 单选 */
	$(".gwc_splb tbody tr:nth-child(2) td samp").click(function(){
		$(this).toggleClass('on');
		$(this).parent().parent().parent().siblings().find('samp').toggleClass('on');
	});
	
	/* 首页 菜单栏 */
	$(".all_sp").hover(function(){
		$(this).children('dl').css('display','block');
	},function(){
		$(this).children('dl').css('display','none');
	});
	
	
	/* 向您推荐 | 浏览历史 */
	$(".splb_tjls span").click(function(){
		$(this).addClass('on').siblings().removeClass('on');
		var i = $(this).index();
		$(".splb_tjls_cont").find('ul').eq(i).css('display','block');
		$(".splb_tjls_cont").find('ul').eq(i).siblings().css('display','none');
	});
	
	/* 商家首页 左  商品分类 */
	$(".spfl_ul li div").click(function(){
		$(this).siblings().slideToggle('fast');
	});
	
	//弹出信息
	$(".socketSroll-title .show").click(function(){
			alert(111);
	})
})

function socketShow(obj)
{
		var Aheight = $(".socketSroll").height();
		var Theight = $(".socketSroll-title").height();
		var Cheight = $(".socketSroll-content").height();
		var height = Aheight - Theight;
/*		console.log($(".socketSroll-content").height());
		console.log($(".socketSroll-title").height());
		console.log($(".socketSroll").height());*/
		if($(obj).text() == '-收缩')
		{
			if( height > Cheight )
			{
				$(".socketSroll").animate({'bottom':-height});	
			}else
			{
				$(".socketSroll").animate({'bottom':-Cheight});	
			}
			$(obj).text('+展开');
		}else
		{
			$(".socketSroll").animate({'bottom':0});	
			$(obj).text('-收缩');
		}
		
}

//跳转翻页面
function page(url)
{
	
	var page = parseInt($("#topage").val());
	if(isNaN($("#topage").val())){$("#topage").val('1'); page = 1; }
	//alert(url+"&page="+page);
	if( window.location.href.indexOf('?') > 0)
		window.location.href=url+"&page="+page;
	else
		window.location.href=url+"?page="+page;
}

//选择价格
function toprice(url)
{
	var m = parseFloat($("#m").val());
	var x = parseFloat($("#x").val());
	if(isNaN($("#m").val()) || isNaN($("#x").val())){alert('请填写正确的价格');return false;}
	if( x < m ){ alert('请填写正确的价格');return false;}
	if( window.location.href.indexOf('?') > 0)
	{
		window.location.href=url+"&m="+m+"&x="+x;
	}else
	{
		window.location.href=url+"?m="+m+"&x="+x;
	}
}
//商户添加商品 添加价格
function addPriceRow(obj)
{
	var num = parseInt($(obj).attr('rel'));
	var r = '[]';
	//$(".addprice").css('display','block');
	var content = '<dt class="dt'+num+'">';
		content = content + '<label>&nbsp;</label>';
        content = content + ' 价格：<input type="text" name="price'+r+'" class="price class_input" value="0.00" datatype="float" nullmsg="请输入店铺价格！"  placeholder="价格"  onkeyup="jsmarkprice(this)" />'; 
        content = content + ' 市场价：<input type="text" name="marketprice'+r+'" class="price class_input" value="0.00" datatype="float" nullmsg="请输入市场价格！"  placeholder="市场价格" />';
		content = content + ' 促销价格：<input type="text" name="promotions_price'+r+'" class="price class_input" value="0.00" datatype="float" nullmsg="请输入店铺促销价格！" placeholder="促销价格" />'; 
		content = content + ' 规格：<input type="text" name="guige'+r+'" class="price class_input" value="" datatype="*" nullmsg="请输入商品规格！" placeholder="规格" /> <a style="cursor:pointer;" onclick="delPriceRow(this)">-删除</a>'; 
        content = content + '<span class="Validform_checktip"></span>';
		content = content + '</dt>';
	var add = $(obj).parent().next();
	//alert($(obj).parent().next().attr('class'));
	if(num == 1 ||  $(obj).parent().next().attr('class') == null )
		add.before(content);
	else
		add.after(content);
	num ++;
	$(obj).attr('rel',num);
	//console.log();
	
}

//删除价格行
function delPriceRow(obj)
{
	var dt = add = $(obj).parent().remove();
}

//商户添加商品 就是市场价格 销售价格X1.2为市场价 促销价X0.8
function jsmarkprice(obj)
{
	var price =$(obj).val();
	console.log($(obj).val());
	if(!isNaN($(obj).val())){ $(obj).val(price);}else
	{
		price = 0;
	}
	if($(obj).val() == ''){price = 0;}
	var markprice = ( parseFloat(price) * 1.2).toFixed(2);
	var cxprice = ( parseFloat(price) * 0.8).toFixed(2);
	$(obj).next('input').val(markprice);
	$(obj).next().next('input').val(cxprice);	
}