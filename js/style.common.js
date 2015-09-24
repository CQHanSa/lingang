$(function(){
	
	//查询是否有新消息
	if(document.cookie.indexOf("username=") > 0){
		queryMessage();
		setInterval("queryMessage()",10000);
	}
})

function CheckKeyword()
{
	if($("#keyword").val() == "")
	{
		//alert("请输入商品关键词！");
		$("#keyword").focus();
		return false;
	}else{
		$("#goodsform").submit();
	}
}

//查询新消息
function queryMessage()
{
	$.ajax({
		url:'/Action/member.php',
		type:'post',
		data:'type=queryMessage',
		success: function(data)
		{
			if(data != 'error')
			{
				$(".socketSroll").css('display','block');
				$(".socketSroll-content ul").html('');
				$(".socketSroll-content ul").html(data);
			}else
			{
				$(".socketSroll").css('display','none');
			}
		}
	})
}

function Open(url)
{
	var agent = navigator.userAgent.toLowerCase() ;
	var regStr_ie = /msie [\d.]+;/gi ;
	var regStr_ff = /firefox\/[\d.]+/gi
	var regStr_chrome = /chrome\/[\d.]+/gi ;
	var regStr_saf = /safari\/[\d.]+/gi ;
	if(agent.indexOf("chrome") > 0)
	{
		window.open(url,'','height=580,width=1000,top=100,left=100,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		return true;
	}else
	{
		window.showModalDialog(url, window , "Width:800px;Height:580px");
		return true;
	}
}

function webVersion()
{
	var agent = navigator.userAgent.toLowerCase() ;
	var regStr_ie = /msie [\d.]+;/gi ;
	var regStr_ff = /firefox\/[\d.]+/gi
	var regStr_chrome = /chrome\/[\d.]+/gi ;
	var regStr_saf = /safari\/[\d.]+/gi ;	
	if(agent.indexOf("chrome") > 0)	
	{
		return 'chrome';
	}
	if(agent.indexOf("firefox") > 0)	
	{
		return 'firefox';
	}
}

function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
            + " " + date.getHours() + seperator2 + date.getMinutes()
            + seperator2 + date.getSeconds();
    return currentdate;
} 
