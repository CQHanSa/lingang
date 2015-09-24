<?php
//开启数据库连接
function OpenMysql($db_host,$db_user,$db_pwd,$db_name)
{
	mysql_connect($GLOBALS['db_host'],$GLOBALS['db_user'],$GLOBALS['db_pwd']);
}
/*
//执行单条查询语句
	$table => 表名 双表查询,分割 tableA，tableB
	$field => 查询字段(可数组)
	$where => 执行条件
	$limit => 条数
	//双表关联查询
	SELECT * FROM film, film_actor WHERE film.film_id = film_actor.film_id
//*/
function MysqlOneSelect($table,$field,$where='',$limit=1,$debug='1')
{
	$new_field  = '';
	if(is_array($field))
	{
		$i=0;
		foreach( $field as $k => $v)
		{
			if($i == 0)
				$new_field .= $v;
			else
				$new_field .= ",".$v; 
			$i++;	
		}
	}else{
		$new_field = $field;	
	}
	$sql = "select $new_field from $table ";
	if($where != '')  $sql .= " where $where limit $limit";
	//进入调试模式
	if($debug == '-1')
	{
		echo $sql;
		exit();
	}
	$rest = mysql_query($sql);
	if(!$rest) { die( '查询错误:'.$sql); }
	$row = mysql_fetch_array($rest,MYSQL_ASSOC);
	//$var_field = explode(',',$field);
	if(empty($row)){ return '-1'; }
	foreach($row as $key => $v){ $var_field[$key] = $v; }
	return $var_field;
}

function MysqlRowSelect($table,$field,$where='',$limit=30,$debug='1')
{
		$new_field  = '';
		if(is_array($field))
		{
			$i=0;
			foreach( $field as $k => $v)
			{
				if($i == 0)
					$new_field .= $v;
				else
					$new_field .= ",".$v; 
				$i++;	
			}
		}else{
			$new_field = $field;	
		}
		$sql = "select $new_field from $table ";
		if($where != '')  { $sql .= " where $where limit $limit";}
		else{ $sql .= "limit $limit"; }
		//进入调试模式
		if($debug == '-1'){echo $sql;exit();}
		$rest = mysql_query($sql);
		if(!$rest) { die( '查询错误:'.$sql); }
		while($row = mysql_fetch_array($rest,MYSQL_ASSOC))
		{	
			$r[] = $row;	
		}
		if(empty($r)){ return '-1'; }
		for($i=0,$n=count($r);$i<$n;$i++)
		{
			if(is_array($r[$i]))
			{
				foreach($r[$i] as $key => $v){ $rows[$i][$key] = $v; }
			}
		}
		return $rows;	
}
/*
// 执行单条修改/添加 SQL
	$table => 表名
	$field => 查询字段(可数组)
	$type => 类型 插入 —— insert into | 修改 —— update
	$where => 执行条件
//*/
function MysqlOneExc($table,$field,$type = 'insert into',$where = '')
{
	$new_field  = '';
	if(is_array($field))
	{
		$i=0;
		foreach( $field as $k => $v)
		{
			if($i == 0)
				$new_field .= "$k = '".$v."'";
			else
				$new_field .= ","."$k = '".$v."'"; 
			$i++;	
		}
	}else{
		$new_field = $field;	
	}
	$sql = "$type $table set $new_field ";
	if($where != '')  $sql .= " where $where";
	//echo $sql;
	$rest = mysql_query($sql);
	if(!$rest) { die( '查询错误:'.$sql); }
	return true;
}

/*
//MYSQL 删除记录
	$table => 表名
	$where => 执行条件
//*/
function MysqlDel($table,$where)
{
	$rest = mysql_query("DELETE FROM $table WHERE $where");
	if($rest)
		return true; 
	else 	
		die('错误'."DELETE FROM $table WHERE $where");
	
}

/*
//随机生成查询条数
*/
function MysqlRand($num,$table,$where)
{
	$r = MysqlOneSelect($table,'count( * ) as total',$where);
	$total = $r['total'];
	if($total == 0)
	{
		
	}
}
?>