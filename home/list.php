<?php

include '../common/common_index.php';

$title = WEB_NAME . '板块详情';

// 左侧导航条
if(isset($_GET['cid']))
{
	$cid = $_GET['cid'];

	// 求出小版块对应的大板块id
	$bigCateParentid = select($link , DB_PREFIX . 'category' , 'parentid' , "cid = $cid");
	$bigCateCid = $bigCateParentid[0]['parentid'];
	

	// 得到大板块的名字
	$bigCateClassname = select($link , DB_PREFIX . 'category' , 'classname , cid' , "cid = $bigCateCid");
	$bigCateClass = $bigCateClassname[0]['classname'];
	$bigCateCid = $bigCateClassname[0]['cid'];


	// 得到小版块的信息
	$smallCateSingle = select($link , DB_PREFIX . 'category' , 'cid , classname' , "cid = $cid");
	$smallCateClassname = $smallCateSingle[0]['classname'];
	$smallCateCid = $smallCateSingle[0]['cid'];

	// 整体查询大小版块信息
	$bigCate = select($link , DB_PREFIX . 'category' , '*' , "parentid = 0");
	$smallCate = select($link , DB_PREFIX . 'category' , '*' , "parentid <> 0" , 'order by orderby desc ');

	

}else
{
	$notice = false;
	$msg = '<i class="zi_red">禁止非法操作</i>';
	$url = '../index.php';
	include 'notice.php';
}


// 右边部分
// 今日的帖子
$y = date('y' , time());
$m = date('m' , time());
$d = date('d' , time());

$start = mktime(0 , 0 , 0 , $m , $d , $y);
$end = mktime(23 , 59 , 59 , $m , $d , $y);

// 是否精华
if(isset($_GET['import']) && $_GET['import'] == 1)
{	
	$where = "tidtype = 1 and isdel = 0 and postime > $start and postime < $end and cid = $cid and essence = 1";
}else
{
	$where = "tidtype = 1 and isdel = 0 and postime > $start and postime < $end and cid = $cid";
}
$todayPost = MyCount($link , DB_PREFIX . 'details' , 'tid' , $where);

// 主题数
$titleNum = MyCount($link , DB_PREFIX . 'details' , 'tid' , "tidtype = 1 and isdel = 0 and cid = $cid");

// 查询版主
$table = DB_PREFIX . 'user' . ',' . DB_PREFIX . 'category' ;
$compere = select($link , $table , 'compere , cid , username' , "uid = compere and cid = $cid");


// 遍历当前板块的帖子
// 分页
$elseTable = DB_PREFIX . 'details';
$table = DB_PREFIX . 'details' . ',' . DB_PREFIX . 'user';
$fields = 'tid';
$elseWhere = "tidtype = 1 and isdisplay = 0 and isdel = 0 and cid = $cid ";
$where = "tidtype = 1 and isdisplay = 0 and isdel = 0 and authorid = uid and cid = $cid order by istop desc , toptime desc , postime desc ";

// 遍历精华帖部分,改变where条件
if(isset($_GET['import']) && $_GET['import'] == 1)
{
	$elseWhere = $elseWhere . 'and essence = 1';
	$where = "tidtype = 1 and isdisplay = 0 and isdel = 0 and authorid = uid and essence = 1 and cid = $cid order by istop desc , toptime desc , postime desc";
}

$paging = lit($link , $elseTable , $table , $fields , $elseWhere , $where , 6);


// 查最后发表的时间,用户名
$table = DB_PREFIX . 'details' . ',' . DB_PREFIX . 'user';
$finalPost = select($link , $table , 'postime , replyid , username , cid' , "tidtype = 0 and uid = authorid" , ' order by postime desc limit 1');


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

	header("location:list.php?cid=$cid&page=$page_num");
	die;
}


display('list.html' , compact('dir' , 'title' , 'most' , 'webBtm' , 'webUrl' , 'webIcp' , 'now' , 'bigCateClass' , 'bigCateCid' , 'smallCateClassname' , 'smallCateCid' , 'bigCate' , 'smallCate' , 'url' , 'todayPost' , 'titleNum' , 'compereId' , 'compere' , 'paging' , 'start' , 'end' , 'finalPost'));