<?php
include '../common/common_index.php';


$title =  WEB_NAME . '-个人资料';


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


// 查询当前用户的基本信息
$res = select($link , DB_PREFIX . 'user' , '*' , "uid = $uid");

// 判断用户是否要修改信息
if(!empty($_POST['sub_data']))
{
	$data['realname'] = $_POST['realname'];
	$data['sex'] = $_POST['sex'];

	
	$birth = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
	$data['birthday'] = $birth;


	$data['address'] = $_POST['place'];
	$data['qq'] = $_POST['qq'];

	$result = update($link , DB_PREFIX . 'user' , $data , "uid = $uid");

	if($result)
	{
		$notice = true;
		$msg = "<i class='zi_green'>修改个人资料成功<i>";
		include 'notice.php';
		die;
	}else
	{
		$notice = false;
		$msg = "<i class='zi_red'>修改个人资料失败,请联系管理员<i>";

		include 'notice.php';
		die;
	}

}


$updateData = select($link , DB_PREFIX . 'user' , '*' , "uid = $uid");

display('personalData.html' , compact('dir' , 'title' , 'most' , 'webBtm' , 'webUrl' , 'webIcp' , 'now' , 'updateData'));