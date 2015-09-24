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

function getNowFormatDate(){
    var day = new Date();
    var Year = 0;
    var Month = 0;
    var Day = 0;
    var CurrentDate = "";
    Year= day.getFullYear();//支持IE和火狐浏览器.
    Month= day.getMonth()+1;
    Day = day.getDate();
    CurrentDate += Year+'-';
    if (Month >= 10 ){
     CurrentDate += '-'+Month;
    }
    else{
     CurrentDate += "0" + Month;
    }
    if (Day >= 10 ){
     CurrentDate += '-'+Day ;
    }
    else{
     CurrentDate += '-'+"0" + Day ;
    }
    return CurrentDate;
 } 
