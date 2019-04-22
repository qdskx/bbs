<?php

include '../common/common_index.php';

$title =  WEB_NAME . '-修改头像';

if(!empty($_SESSION['uid']))
{
	$uid = $_SESSION['uid'];
}else
{
	$notice = false;
	$msg = '<i class="zi_red">禁止非法操作</i>';
	$url = '../index.php';
	include 'notice.php';
	die;
}

$res = select($link , DB_PREFIX . 'user' , 'pic' , "uid = $uid");

if(!empty($_POST['sub_avatar']))
{
	// 调用上传头像的函数
	$upload = upload('avatar' , '../upload' , [
			'image/png','image/jpeg','image/gif','image/wbmp','image/bmp','image/jpg'
			],
			pow(1024 , 2) * 2,
			[
				'jpeg','png','pjpeg','gif','wbmp','bmp','jpg'
			]
			
		);

	if($upload[0])
	{
		$path = suoFang($upload[1] , 50 , 50);
	}

	$data['pic'] = $path;

	$result = update($link, DB_PREFIX . 'user' , $data , "uid = $uid");

	if($result)
	{
		$notice = true;
		$msg = "<i class='zi_green'>修改头像成功";

		include 'notice.php';
		die;
	}else
	{
		$notice = false;
		$msg = "<i class='zi_red'>修改头像失败";

		include 'notice.php';
		die;
	}

}

$updateHead = select($link , DB_PREFIX . 'user' , 'pic' , "uid = $uid");

display('modifyHead.html' , compact('dir' , 'title' , 'most' , 'webBtm' , 'webUrl' , 'webIcp' , 'now' , 'updateHead'));