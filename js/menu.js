// JavaScript Document


$(function(){
	$(".all_sp").hover(function(){
		$("ul",this).css("display","block");
	},function(){
		$("ul",this).css("display","none");
	});
	$(".all_sp ul li").hover(function(){
		$(this).children('.category').css("display","block");
	},function(){
		$(this).children('.category').css("display","none");
	});
	
	
	
	
	
	
	
	
	
	
	
})