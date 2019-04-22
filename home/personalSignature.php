<?php

include '../common/common_index.php';

$title = WEB_NAME . '-个人签名';

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

if(!empty($_POST['sub_signature']))
{
	$data['autograph'] = $_POST['content'];

	$result = update($link , DB_PREFIX . 'user' , $data , "uid = $uid");

	if($result)
	{	
		$notice = true;
		$msg = "<i class='zi_green'>修改个性签名成功<i>";
		include 'notice.php';
		die;
	}
	else
	{
		$notice = false;
		$msg = "<i class='zi_red'>修改个性签名失败<i>";
		include 'notice.php';
		die;
	}
}


$sigNature = select($link , DB_PREFIX . 'user' , 'autograph' , "uid = $uid");

display('personalSignature.html' , compact('dir' , 'title', 'most' , 'webBtm' , 'webUrl' , 'webIcp' , 'now' , 'sigNature'));