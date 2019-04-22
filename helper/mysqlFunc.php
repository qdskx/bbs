<?php
/*
*数据库的增删改查函数
*/

/*
*数据库链接函数
*@param $host string
*@param $user string
*@param $pwd string
*@param $charset string
*@param $dbName string
*@param return object
*/
function connect($host , $user , $pwd , $charset , $dbName)
{
	$link = mysqli_connect($host , $user , $pwd);

	if(!$link)
	{
		// die('数据库链接失败');
		return false;
	}

	mysqli_set_charset($link , $charset);

	if(!mysqli_select_db($link , $dbName))
	{
		return false;
	}

	return $link;

}


/*
*数据库插入函数
*@param $link object
*@param $table string
*@param $data array
*@param return int
*/
function insert($link , $table , $data)
{
	$keys = array_keys($data);

	$fields = join(',' , $keys);

	$values = array_values($data);

	$value = join(',' , parseValue($values));

	$sql = "insert into $table ($fields) values($value)";

	// echo $sql;

	$result = mysqli_query($link , $sql);

	if($result && mysqli_affected_rows($link))
	{
		return mysqli_insert_id($link);
	}else{
		return false;
	}

}


/*
*处理插入的数据的值函数
*@param $value mixed
*@param return string(插入数据的id)
*/
function parseValue($value)
{
	if(is_string($value))
	{
		$value = '\'' . $value . '\'';
	}else if (is_array($value))
	{
		$value = array_map('parseValue' , $value);
	}else if(is_null($value))
	{
		$value = null;
	}

	return $value;
}


/*
*数据库修改函数
*@param $link object
*@param $table string
*@param $data array
*@param $where string
*@param return int(受影响的id)
*/
function update($link , $table , $data , $where)
{
	$set = join(',' , parseSet($data));

	$sql = "update $table set $set where $where ";

	// var_dump($sql);
 
	$result = mysqli_query($link , $sql);

	return $result;
}


/*
*处理要修改的数据函数
*@param $data array
*@param return array
*/
function parseSet($data)
{
	foreach($data as $key => $value)
	{
		$value = parseValue($value);

		if(is_scalar($value))
		{
			$set[] = $key . '=' . $value;
		}
	}

	// var_dump($set);

	return $set;
}


/*
*数据库删除函数
*@param $link object
*@param $table string
*@param $where string
*@param return int(受影响的id)
*/
function del($link , $table , $where)
{
	$sql = "delete from $table where $where";

	// var_dump($sql);

	$result = mysqli_query($link , $sql);

	if($result && mysqli_affected_rows($link))
	{
		return mysqli_affected_rows($link);
	}else{
		return false;
	}

}


/*
*数据库查询函数
*@param $link object
*@param $table string
*@param $fields string
*@param $where string
*@param $else string
*@param return array
*/
function select($link , $table , $fields = '*' , $where = '' , $else = '')
{
	if(empty($where))
	{
		$where = '';
	}else{
		$where = "where $where";
	}

	$sql = "select $fields from $table $where $else";

	// var_dump($sql);

	$result = mysqli_query($link , $sql);

	if($result && mysqli_affected_rows($link))
	{
		while($rows = mysqli_fetch_assoc($result))
		{
			$data[] = $rows;
		}
	}else{
		return false;
	}

	return $data;
}


/*
*数据库分页函数
*@param $link object
*@param $elseTable string
*@param $table string
*@param $fields string
*@param $elseWhere string
*@param $where string
*@param $num int
*@param return array
*/
function lit($link , $elseTable = '' , $table , $fields = '' , $elseWhere = '' , $where = '' ,  $num = 4 )
{
	$page = empty($_GET['page']) ? 1 : $_GET['page'];

	$lis['page'] = $page;
	$lis['num'] = $num;


	$count = MyCount($link , $elseTable , $fields , $elseWhere);

	$pageCount = ceil($count / $num);

	$lis['pageCount'] = $pageCount;
	$lis['count'] = $count;

	$offset = ($page - 1) * $num;
	$lis['offset'] = $offset;

	$prev = $page - 1;
	$next = $page + 1;

	if($prev < 1)
	{
		$prev = 1;
	}

	if($next > $pageCount)
	{
		$next = $pageCount;
	}

	$lis['prev'] = $prev;
	$lis['next'] = $next;

	if(empty($where))
	{
		$where = '';
	}else
	{
		$where = "where $where";
	}

	$sql = "select * from $table $where limit $offset , $num";

	// var_dump($sql);

	$result = mysqli_query($link , $sql);

	if($result && mysqli_affected_rows($link))
	{

		while($rows = mysqli_fetch_assoc($result))
		{
			$data[] = $rows;

			$lis['data'] = $data;
		}
	}

	// var_dump($lis);

	return $lis;

}


/*
*数据库求最大值函数
*@param $link object
*@param $table string
*@param $fields string
*@param $where string
*@param $else string
*@param return int
*/
function MyMax($link , $table , $fields = 'id' , $where = '' , $else = '')
{

	if(empty($where))
	{
		$where = '';
	}else
	{
		$where = "where $where";
	}

	$sql = "select max($fields) as max from $table $where $else";

	// var_dump($sql);

	$result = mysqli_query($link , $sql);

	if($result && mysqli_affected_rows($link))
	{
		return mysqli_fetch_assoc($result)['max'];
	}else{
		return false;
	}

}

function MyMin($link , $table , $fields = 'id' , $where = '')
{

	if(empty($where))
	{
		$where = '';
	}else
	{
		$where = "where $where";
	}

	$sql = "select min($fields) as min from $table $where";

	$result = mysqli_query($link , $sql);

	if($result && mysqli_affected_rows($link))
	{
		return mysqli_fetch_assoc($result)['min'];
	}else
	{
		return false;
	}
}


/*
*数据库求总数函数
*@param $link object
*@param $table string
*@param $fields string
*@param $where string
*@param $else string
*@param return int
*/
function MyCount($link , $table , $fields = 'id' , $where = '' , $else = '')
{

	if(empty($where))
	{
		$where = '';
	}else
	{
		$where = "where $where";
	}

	$sql = "select count($fields) as count from $table $where $else";

	// var_dump($sql);

	$result = mysqli_query($link , $sql);

	if($result && mysqli_affected_rows($link))
	{
		return mysqli_fetch_assoc($result)['count'];
	}else{
		return false;
	}
	
}

function MySum($link , $table , $fields = 'id')
{
	$sql = "select sum($fields) as sum from $table";

	$result = mysqli_query($link , $sql);

	if($result && mysqli_affected_rows($link))
	{
		return mysqli_fetch_assoc($result)['sum'];
	}

}

function MyAvg($link , $table , $fields = 'id')
{
	$sql = "select avg($fields) as avg from $table";

	$result = mysqli_query($link , $sql);

	if($result && mysqli_affected_rows($link))
	{
		return mysqli_fetch_assoc($result)['avg'];
	}else{
		return false;
	}

}




// 递归删除目录
function del_cache($path)
{
	//打开目录
	$dir = opendir($path);

	// 调过两次特殊的目录
	
	// echo $dir;die;

	readdir($dir);

	// echo $dir; die;
	readdir($dir);

	// echo $dir;die;

	while($newFile = readdir($dir))
	{
		$newPath = $path . '/' . $newFile;

		if(is_file($newPath))
		{
			unlink($newPath);
		}else{
			del_cache($newPath);
		}
	}

	rmdir($path);
	closedir($dir);
}





