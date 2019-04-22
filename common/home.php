<?php

session_start();


include 'common.php';
include 'config.php';

header("content-type:text/html; charset=utf-8"); 

if(!empty($_SERVER['HTTP_REFERER'])){
	$url = $_SERVER['HTTP_REFERER'];
}

// 项目安装
if(!file_exists('install.lock') && !file_exists('../install.lock'))
{
	header('location:install/index.php');
	exit;
}
	


//根据调试状态设置错误报告
if (IS_DEBUG) {
	error_reporting(E_ALL);
} else {
	error_reporting(0);
}

//设置默认时区
date_default_timezone_set(TIMEZONE);


//相关文件加载
include DOC_ROOT.'config/database.php';
include DOC_ROOT.'helper/mysqlFunc.php';
include DOC_ROOT.'helper/regUser.php';
include DOC_ROOT.'helper/postFunc.php';
include DOC_ROOT.'helper/tpl.php';
include DOC_ROOT.'helper/upload.php';
include DOC_ROOT.'helper/suoFang.php';

$dir = DOMAIN_RESOURCE;

//连接数据库
$link = connect(DB_HOST,DB_USER,DB_PWD,DB_CHARSET,DB_NAME);
if (!$link) {
	exit('数据库连接失败');
}

if(isset($_SESSION['uid']))
{
	$uid = $_SESSION['uid'];

	$res = select($link , DB_PREFIX . 'user' , '*' , "uid = $uid");

	$_SESSION['uid'] = $res[0]['uid'];
	$_SESSION['username'] = $res[0]['username'];
	$_SESSION['password'] = $res[0]['password'];
	$_SESSION['undertype'] = $res[0]['undertype'];
	$_SESSION['grade'] = $res[0]['grade'];
	$_SESSION['pic'] = $res[0]['pic'];
}


// 首页的导航
$most = select($link , DB_PREFIX . 'category' , 'cid , classname' , "parentid = 0 and ispass = 1 and isremove = 0" , "limit 4");

// 右下角的时间
$now = date('m-d H:i' , time());
//待处理：IP是否禁用，网站是否关闭


$webBtm = WEB_BTM;
$webUrl = WEB_URL;
$webIcp = WEB_ICP;

