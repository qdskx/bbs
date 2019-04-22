<?php

include './common/common_index.php';

$title = WEB_NAME;

if(isset($_GET['bigid']))
{
	$bigid = $_GET['bigid'];

	// 查所得到的bigid所对应的大板块的信息
	$bigCate = select($link , DB_PREFIX . 'category' , 'classname , cid' , "cid = $bigid");

	$smallCate = select($link , DB_PREFIX . 'category' , '*' , "parentid = $bigid and ispass = 1 and isremove = 0" , 'order by orderby desc');


}else
{
	$bigCate = select($link , DB_PREFIX . 'category' , 'classname , cid' , "parentid = 0 and ispass  =1 and isremove = 0");

	$smallCate = select($link , DB_PREFIX . 'category' , '*' , "parentid <> 0 and ispass = 1 and isremove = 0" ,  'order by orderby desc');
}


// 查最新加入会员以及会员数量
$new = select($link , DB_PREFIX . 'user' , 'username' , '' , 'order by regtime desc');
$newMem = $new[0]['username'];
$memNum = MyCount($link , DB_PREFIX . 'user' , 'uid');



// 查版主 配合9314_category的compere字段
$table = DB_PREFIX . 'user' . ',' . DB_PREFIX . 'category' ;
$compere = select($link , $table , 'compere , cid , username' , "uid = compere");


// 查每个板块最新的帖子
$table = DB_PREFIX . 'details' . ',' . DB_PREFIX . 'user';
$recentNew = select($link , $table , 'tid , title , postime , cid , username' , "authorid = uid and tidtype = 1 and isdel = 0" , "group by cid order by postime desc");


// 贴子数量
$postNum = MyCount($link , DB_PREFIX . 'details' , 'tid' , 'tidtype = 1 and isdel = 0 and isdisplay = 0');



// 遍历友情链接
$friendLink = select($link , DB_PREFIX . 'link' , '*' , 'ishow = 0 order by showorder');


display('index.html' , compact('dir' , 'title' , 'most' , 'bigCate' , 'smallCate' , 'webBtm' , 'webUrl' , 'webIcp' , 'now' , 'recentNew' , 'postNum' , 'newMem' , 'memNum' , 'friendLink' , 'compere'));