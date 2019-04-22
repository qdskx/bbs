<?php

include '../common/common_index.php';

$title = WEB_NAME . '-模糊查询结果';



if(!empty($_POST['search']))
{

	$key = $_POST['search'];

	$elseTable = '9314_category , 9314_user , 9314_details';
	$table = $elseTable;
	$fields = 'distinct username , classname ,title , content';	
	$elseWhere = "((title like binary '%$key%' ) or (classname like binary '%$key%') or (username like binary '%$key%') or (content like binary '%$key%') ) and 9314_details.cid = 9314_category.cid and 9314_user.uid = 9314_details.authorid and parentid > 0 and tidtype = 1 ";
	$where = $elseWhere;
	$paging = lit($link , $elseTable , $table , $fields , $elseWhere , $where , 8);

}else if(!empty($_REQUEST['key']))
{

	$key = $_REQUEST['key'];	

	$elseTable = '9314_category , 9314_user , 9314_details';
	$table = $elseTable;
	$fields = 'distinct username , classname ,title , content';	
	$elseWhere = "((title like binary '%$key%' ) or (classname like binary '%$key%') or (username like binary '%$key%') or (content like binary '%$key%') ) and 9314_details.cid = 9314_category.cid and 9314_user.uid = 9314_details.authorid and  parentid > 0 and tidtype = 1";
	$where = $elseWhere;
	$paging = lit($link , $elseTable , $table , $fields , $elseWhere , $where , 8);

}else
{
	$key = null;
}






// 通过form表单处理接收到的page
if(!empty($_POST['sub_page']))
{
	$page_num = $_POST['page_num'];

	if($page_num > $paging['pageCount'])
	{
		$page_num = $paging['pageCount'];
	}

	if($page_num < 1)
	{
		$page_num = 1;
	}

	header("location:search.php?page=$page_num");
	die;
}



display('search.html' , compact('dir' , 'title' , 'webBtm' , 'webUrl' , 'paging' , 'key'));