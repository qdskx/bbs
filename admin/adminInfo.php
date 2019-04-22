<?php

include '../common/common_admin.php';

$title = WEB_NAME . '-站点信息-站点信息';

if(empty($_SESSION['username']))
{
	$msg = '<i class="zi_red">抱歉,请您先去登录</i>';
	$url = 'adminLogin.php';
	include 'notice.php';
	die;
}else
{
	if(!empty($_POST['sub_info'])){
		
		$contents = file_get_contents('../common/config.php');

		foreach ($_POST as $key => $value) {
			
			$pattern = "/define\('$key',.+\)/";
			
			$string = "define('$key','$value')";
			
			$contents = preg_replace($pattern , $string , $contents);
		}

		file_put_contents('../common/config.php' , $contents);



		header('location:adminInfo.php');

	}

	// 是否删除缓存
	if(isset($_GET['del_cache']) && $_GET['del_cache'] == 1)
	{
		del_cache('../caches/home/');
		del_cache('../caches/admin/');
	}


	display('adminInfo.html' , compact('dir' , 'title'));
}