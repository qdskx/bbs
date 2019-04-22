<?php

include '../common/common_admin.php';

$title = WEB_NAME .'-版块管理-添加板块';

if(empty($_SESSION['username']))
{
	$notice = false;
	$msg = '<i class="zi_red">抱歉,请您先去登录</i>';
	$url = 'adminLogin.php';
	include 'notice.php';
	die;

}else{

	// 遍历大板块
	$bigcate = select($link , DB_PREFIX . 'category' , '*' , 'parentid = 0 and ispass = 1 and isremove = 0');


	// 添加板块
	if(!empty($_POST['sub_add_cate']))
	{
		if(!empty($_POST['choice']))
		{
			$add_cate['parentid'] = $_POST['choice']; 
		}else
		{
			$add_cate['parentid'] = 0;
		}

		if(!empty($_POST['catename'])){
			$add_cate['classname']  = $_POST['catename'];
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">板块名称不能为空</i>';
			include 'notice.php';
			die;
		}

		$addcate = insert($link , DB_PREFIX . 'category' , $add_cate);
		if($addcate)
		{
			$notice = true;
			$msg = '<i class="zi_green">添加板块成功</i>';
			$url = 'adminCate.php';
			include 'notice.php';
			die;
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">添加板块失败</i>';
			include 'notice.php';
			die;
		}

	}


	display('adminCateadd.html' , compact('dir' , 'title' , 'bigcate'));
}