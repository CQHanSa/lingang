$(function(){
	
	var touserid = $("#sendMsg").attr('touserid');
	var toshopid = $("#sendMsg").attr('toshopid');
	var togoodsid = $("#sendMsg").attr('togoodsid');
	var avatar = $("#sendMsg").attr('avatar');
	var username = $("#sendMsg").attr('username');
	var userid = $("#sendMsg").attr('userid');
	
	
	$('.im-tab-content').hide();
	$('.im-tab-content').eq(0).show();
	
	//$('.dayselect ul li').each(function)
	$('.im-tab li').click(function(){
		var index=$(this).index();
		$('.im-item').removeClass('current');
		$(this).addClass('current');
		$('.im-tab-content').hide();
		$('.im-tab-content').eq(index).show();
	});
	
	$("#sendMsg").click(function()
	{
		addSocket(touserid,toshopid,togoodsid,avatar,username,userid);
	});
	
	$("#text_in").keydown(function(event){
		var web = webVersion();
		if(web == 'firefox')
		{
			keyCode = event.which;
		}else
		{
			keyCode = event.keyCode;
		}
		console.log(keyCode);
		if(event.ctrlKey && keyCode == 13)
		{
			addSocket(touserid,toshopid,togoodsid,avatar,username,userid);
		}
	});
	
	//显示当天聊天记录
	socketShowDay(touserid);
	//轮询
	setInterval("socketPingPolling("+touserid+")",3000);
});


//显示当天的聊天记录
function socketShowDay(uid)
{
	$.post("/Action/member.php","type=socketShowDay&userid="+uid,function(data){
		if(data != '')
		{ 
			$('#scrollDiv').append(data);
			$("#scrollDiv").scrollTop($("#scrollDiv")[0].scrollHeight);
		}
	})
}

//轮询
function socketPingPolling(uid)
{
	var date = getNowFormatDate();
	var message = $("#text_in").html();
		$.ajax({
		url:'/Action/socket.php',
		type:'post',
		data:'type=addSocket&message='+message+"&uid="+uid,
		success:function(data,status)
		{
			if(date == '')
			{
				//setInterval(socketPingPolling(uid),3000);
			}
			if(date != '')
			{
				$('#scrollDiv').append(data);
				$("#scrollDiv").scrollTop($("#scrollDiv")[0].scrollHeight);
				//setInterval(socketPingPolling(uid),3000);
			}
		}
	})
}

//发送信息
function addSocket(touserid,toshopid,togoodsid,avatar,username,userid)
{
	var date = getNowFormatDate();
	var message = $("#text_in").html();
	if(message == ''){ return false;}
	
	var Cmessage = '<div class="im-item im-me"><div class="im-message clearfix"><div class="im-user-area"><a class="im-user-pic" href="#"><img class="userPic" src="/'+avatar+'" alt=""><img class="im-user-pic-cap" src="/images/socket/cap48.png" alt=""></a></div><div class="im-message-detail"><table cellspacing="0" cellpadding="0" border="0" class="im-message-table"><tbody><tr><td class="lt"></td><td class="tt"></td><td class="rt"></td></tr><tr><td class="lm"></td><td class="mm"><div class="im-message-title"><p class="im-message-owner"><span class="im-txt-bold">'+username+'</span></p><span class="im-send-time">'+date+'</span></div><div class="im-message-content"><p style="color: rgb(51, 51, 51);">'+message+'</p></div> </td> <td class="rm"><span></span></td></tr><tr><td class="lb"></td><td class="bm"></td><td class="rb"></td></tr></tbody></table></div></div></div>';
	$('#scrollDiv').append(Cmessage);
	$("#scrollDiv").scrollTop($("#scrollDiv")[0].scrollHeight);
	$("#text_in").html('');
	
	$.ajax({
		url:'/Action/member.php',
		type:'post',
		data:'type=addSocket&message='+message+"&touserid="+touserid+"&toshopid="+toshopid+"&togoodsid="+togoodsid,
		beforeSend: function(){},
		success: function(rr)
		{
			if(rr == '发送成功')
			{
				//$("#text_in").html('');
			}			
		}
	})
}