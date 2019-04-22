<?php

include 'home.php';
//前台模板文件目录
define('TPL_PATH', DOC_ROOT.'views/home/');
//前台模板缓存目录
define('TPL_CACHE', DOC_ROOT.'caches/home/');

if(WEB_ISCLOSE == 'true')
{
      
    echo '<h3 style="color:pink;">站点已关闭,管理员可进入后台首页开启站点</h3>';
    echo '<meta http-equiv="Refresh" content="2;http://bbs.skxto9314.com/admin/adminLogin.php">';
      
	die;

	
}