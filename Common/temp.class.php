<?php
function listTemp($temp,$table,$where,$limit='')
{
	$limit = $limit == '' ? 15 : $limit;
	$rows = MysqlRowSelect($table,'*',$where,$limit);
	$r = MysqlOneSelect($table,'count(*) as total',$where);
	$total = $r['total'];
	$_SESSION['total'] = (int)$total;
	if($total == 0 ){ return ''; }
	$write = '';
	if($rows == '-1'){ return $write;}
	for($i=0,$n=count($rows);$i<$n;$i++)
	{
		$newTemp = $temp;
		foreach($rows[$i] as $key => $value )
		{
			if($key == 'createTime'){ $value = date('Y-m-d',$value); }
			/*if($key == 'goodsid' && ( $table != 'lgsc_goods' ) )
			{
				$good = MysqlOneSelect("lgsc_goods","*","id=$value");
				if($good != '-1'){
					foreach($good as $k => $v)
					{
						if( $k ==  'salesprice' ) { $salesprice = $v;}
						//显示降价提醒
						if( $k ==  'downprice'  ) 
						{ 
							if($v > 0)
								$v = "商品已降价".$v."元！";	
							else
								$v = "";	
						}
						$newTemp = str_replace("[!--good.$k--]",$v,$newTemp);
					}
				}
			}*/
			if(is_numeric($value)){ $newTemp = str_replace("date:[!--$key--]",date("Y-m-d h:m",$value),$newTemp);}	
			$newTemp = str_replace("nl2br:[!--$key--]",nl2br($value),$newTemp);				
			$newTemp = str_replace("[!--$key--]",$value,$newTemp);
		}
		//计算购物车总价
		if(isset($rows[$i]['goodsnum']))
		{
			$sum = number_format($salesprice * $rows[$i]['goodsnum'],2);
			$newTemp = str_replace("[!--sum--]",$sum,$newTemp);	
		}
		$write .= $newTemp;
	}
	return $write;
}

function pageLimit($page,$num)
{
	if($page != '')
	{
		if($page == 0)
			$limit = "$page,$num";
		elseif($page > 0)
			$limit = ($page-1)*$num.",".$num;
	}else
	{
		$page = 1;
		$limit = "0,$num";
	}
	return $limit;
}
//分页函数
/*
 page => 当前页码
 num => 每夜个数
 total => 总共个数
 showPageFigure => 显示数字页码
*/
function ListPage($page='1',$num,$total='',$showPageFigure='4')
{
	global $_GET;
	//print_r($_GET);
	//echo $total;
	$v =  empty($_GET) || ( count($_GET) == 1 && isset($_GET['page']) )  ? '?' : '&'; 
	if($page == ''){ $page == 1; }

	if($total ==''){ $total = $_SESSION['total']; unset($_SESSION['total']); }

	if($total ==''){ $total = $_SESSION['total']; unset($_SESSION["total"]); }

	if($total == 0){ return '';}
	$allPage = ceil( $total / $num );
	if($page > $allPage){ message('请选择正确的页码','javascript:history.go(-1)');exit();}
	//$showPageFigure = 4;
	$startPage = '1'; 
	$endPage = $allPage;
	if($allPage > $showPageFigure  && $page+$showPageFigure <= $allPage )
	{ 
		if($page == 0){ $startPage = 1; $endPage =  $page  + $showPageFigure; }
		else{ $startPage = $page; $endPage = $page - 1 + $showPageFigure;  }  
	}
	else
	{  
		if( $allPage - $showPageFigure < 0){$startPage = 1; $endPage = $allPage;     }
		else{ $startPage = $allPage - $showPageFigure + 1; $endPage = $allPage;  } 
	}
	$get = $_SERVER['QUERY_STRING'] == '' ? '' : '?'.$_SERVER['QUERY_STRING']; 
	$initialUrl = $_SERVER['PHP_SELF'].$get;
	$initialUrl = preg_replace('/\?page=[0-9]{1,5}/','',$initialUrl);
	$initialUrl = preg_replace('/&page=[0-9]{1,5}/','',$initialUrl);
	$initialUrl = preg_replace('/page=[0-9]{1,5}/','',$initialUrl);
	//echo $_SERVER['PHP_SELF'];
	$pagetop ="<a href='".$initialUrl."'>首页</a>";
	//下一页
	if($allPage > 1 && $page+1 <= $allPage )
	{
		$url = $initialUrl.$v."page=".($page+1);
		$pagetop .= "<a href='$url'>下一页</a>";	
	}
	//数字页
	for($i=$startPage;$i<=$endPage;$i++)
	{
		if($i == $page){ $url = 'javascript:video(0)'; }else{ $url = $initialUrl.$v."page=".$i; }
		$pagetop .= "<a href='$url'>$i</a>";	
	}
	//上一页
	if($page > 1 && $page <=  $allPage )
	{
		$url = $initialUrl.$v."page=".($page-1);
		$pagetop .= "<a href='$url'>上一页</a>";	
	}
	//尾页
	$pagetop .= "<a href='$initialUrl".$v."page=$allPage'>尾页</a>";
	$pagetop .= "<a href='javascript:video(0)'>共 $total 条</a>";
	return $pagetop;		
}

//获取列表页筛选
function listFilter($where,$urlGet,$cid)
{
	$get = $urlGet;
	$url = mb_convert_encoding($_SERVER['REQUEST_URI'],'UTF-8','gbk');
	$url = preg_replace("/&$urlGet=[0-9a-zA-Z]+/iu",'',$url); 
	if($get == 'twcid'){ $url = preg_replace("/&thcid=[0-9a-zA-Z]+/iu",'',$url);  }
	if($get == 'oncid'){ 
		$url = preg_replace("/\?(.*)?/iu",'',$url);  
	}
	$url = preg_replace("/&page=[0-9a-zA-Z]+/iu",'',$url);
	if(strpos($url,'?'))
	{
		$url .= "&";	
	}else
	{
		$url .= "?";	
	}
	$row = MysqlRowSelect('lgsc_goodstype','*',$where);
	if($row == -1){ return '';}
	$write = '';
	$hot = 'style="color:red;dispaly:block;"';
	for($i=0,$n=count($row);$i<$n;$i++)
	{	
		//echo $field;
		//print_r($row[$i]);
	
		$href = $url."$get=".$row[$i]['id'];
		if($row[$i]['id'] == $cid )
			$write .= '<a href="'.$href.'" class="cur">'.$row[$i]['classname'].'</a>';
		else	
			$write .= '<a href="'.$href.'">'.$row[$i]['classname'].'</a>';
	}

	return $write;
}

function listPlace($cid,$curid,$table,$field,$getUrl)
{
	$url = GetUrl($getUrl);
	$goods = MysqlRowSelect('lgsc_goods',$field,"typetid = '$cid'  group by $field");
	if($goods == -1){ return ''; }
	$write = '';
	for($i=0,$n=count($goods);$i<$n;$i++)
	{
		$classHot = '';
		$goodsaddress = MysqlOneSelect($table,"classname,id","id=".$goods[$i][$field]);
		if($curid == $goods[$i][$field]){ $classHot = 'class="cur"'; }
		$write .= "<a href='$url&$getUrl=$goodsaddress[id]' $classHot >$goodsaddress[classname]</a>";
	}
	return $write;
}



?>