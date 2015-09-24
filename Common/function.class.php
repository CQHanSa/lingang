<?php
//POST GET 过滤
function post($name)
{
	if($name == "array")
	{
		
		foreach( $_POST as $key => $val )
		{
			$val = trim($val);
			$post[$key] = !get_magic_quotes_gpc() ? htmlspecialchars(addslashes($val),ENT_QUOTES,'UTF-8') : htmlspecialchars($val,ENT_QUOTES,'UTF-8');
		
		}
	
	}else
	{
		if(!isset($_POST["$name"])){ die('POST参不存在：'.$name);}
		$val = trim($_POST["$name"]);
		$post = !get_magic_quotes_gpc() ? htmlspecialchars(addslashes($val),ENT_QUOTES,'UTF-8') : htmlspecialchars($val,ENT_QUOTES,'UTF-8');	
	}

	//return trim($post);
	return $post;
}
function get($name)
{
	if($name == "array")
	{
		
		foreach( $_GET as $key => $val )
		{
			$val = trim($val);
			$get[$key] = !get_magic_quotes_gpc() ? htmlspecialchars(addslashes($val),ENT_QUOTES,'UTF-8') : htmlspecialchars($val,ENT_QUOTES,'UTF-8');
		
		}
	
	}else
	{
		if(!isset($_GET["$name"])){ die('GET参不存在：'.$name);}
		$val = trim($_GET[$name]);
		$get = !get_magic_quotes_gpc() ? htmlspecialchars(addslashes($val),ENT_QUOTES,'UTF-8') : htmlspecialchars($val,ENT_QUOTES,'UTF-8');
	}
	return $get;
}

//弹出消息返回地址
function Message($info,$url)
{
   echo '<script language="javascript">alert("'.$info.'");window.location.href="'.$url.'";</script>';
}


//获取GET参数地址
/*
 value => 需要取消的参数
 getValue=> 需要传的参数（字符串）
 num => 传几个参(数字)	
*/
function GetUrl($value='',$getValue='',$num='1')
{
	global $_GET;
	if(is_array($value)){ $getName = $value[0]; }else{  $getName = $value;  }
	$v =  empty($_GET) || ( count($_GET) == $num && isset($_GET[$getName])) ? '?' : '&'; 
	$url = mb_convert_encoding($_SERVER['REQUEST_URI'],'UTF-8','gbk');	
	if(is_array($value))
	{
		for($i=0,$n=count($value);$i<$n;$i++)
		{
			$url = preg_replace("/&$value[$i]=[0-9a-zA-Z]+/iu",'',$url);
			$url = preg_replace("/&$value[$i]=/",'',$url);
			$url = preg_replace("/\?$value[$i]=[0-9a-zA-Z]+/iu",'',$url);
		}
	}else
	{
		$url = preg_replace("/&$value=[0-9a-zA-Z]+/iu",'',$url);
		$url = preg_replace("/&$value=/",'',$url);
		$url = preg_replace("/\?$value=[0-9a-zA-Z]+/iu",'',$url);
	}
	if($getValue != '')
		return $url.$v.$getValue; 
	else
		return $url;
}
//判断验证是否正确
function is_vdvalue($validate)
{
	if($validate != strtolower(GetCkVdValue()))
	{
		ResetVdValue();
		return false;
	}
	return true;
}

//验证码获取函数
function GetCkVdValue()
{
	if(!isset($_SESSION)) session_start();
	return isset($_SESSION['ckstr']) ? $_SESSION['ckstr'] : '';
}
//验证码重置函数
function ResetVdValue()
{
	if(!isset($_SESSION)) session_start();
	$_SESSION['ckstr'] = '';
}

//随机字母
function makecode($num=6) 
{
	$re ='';
	$s = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	while(strlen($re)<$num) {
		$re .= $s[rand(0, strlen($s)-1)]; //从$s中随机产生一个字符
	}
	return $re;
}

//多维数组转换成一位数组
function arr_foreach ($arr)
{
  static $tmp=array(); 
  if (!is_array ($arr))
  {
	 return false;
  }
  foreach ($arr as $val )
  {
	 if (is_array ($val))
	 {
		arr_foreach ($val);
	 }
	 else
	 {
		$tmp[]=$val;
	 }
  }
  return $tmp;
}

// 模拟提交数据函数
function curl_post($url,$data){ // 模拟提交数据函数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)'); // 模拟用户使用的浏览器
        // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        // curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
}

?>