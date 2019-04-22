<?php

include '../common/common_index.php';


$title =  WEB_NAME . '-密码安全';

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


$res = select($link , DB_PREFIX . 'user' , 'password' , "uid = $uid");
if(!empty($_POST['sub_safe']))
{
	// 判断输入的旧密码是否正确
	$oldpass = $res[0]['password'];
	// if(!stringLen($oldpass))
	// {
	// 	$msg = '<i class="zi_red">您输入的旧密码不合法,密码由6~12个字符组成,请重新输入</i>';
	// 	include 'notice.php';
	// 	die;
	// }


	$password = md5($_POST['oldpass']);
	if(strEqual($oldpass , $password))
	{
		$notice = false;
		$msg = '<i class="zi_red">您的旧密码输入错误</i>';

		include 'notice.php';
		die;
	}
	

	// 判断用户是否输入了新的密码,即是否要修改密码
	if(!empty($_POST['newpass'] && !empty($_POST['confirmpass'])))
	{	

		if(!strEqual($_POST['newpass'] , $_POST['confirmpass']))
		{
			if(!stringLen($_POST['newpass']))
			{	
				echo 22222;
				$notice = false;
				$msg = '<i class="zi_red">您输入的密码不合法,密码由6~12个字符组成,请重新输入</i>';
				include 'notice.php';
				die;
			}else
			{
				$data['password'] = md5($_POST['newpass']);
			}

			
			
		}else if(strEqual($_POST['newpass'] , $_POST['confirmpass']))
		{
			$notice = false;
			$msg = '<i class="zi_red">两次输入密码不一致,请重新输入</i>';

			include 'notice.php';
			die;

		}else
		{
			$data['password'] = $_POST['newpass'];
		}

	}

	// 判断用户是否输入了新的邮箱,即是否要修改邮箱
	if(!empty($_POST['email']))
	{
		if(checkEmail($_POST['email']))
		{
			$notice = false;
			$msg = '<i class="zi_red">邮箱各式不正确,请重新输入</i>';

			include 'notice.php';
			die;
		}else
		{
			$data['email'] = $_POST['email'];
		}

	}

	
	// 判断用户是否写入了安全提问,即是否要修改安全提问
	// 两种情况1、安全提问和回答均作了修改
	// 		   2、那个输入了值,就修改哪个的值
	if(!empty($_POST['questionidnew'] && !empty($_POST['answernew'])))
	{

		$data['problem'] = $_POST['questionidnew'];

		$data['anser'] = $_POST['answernew'];
	}else if(empty($_POST['questionidnew']))
	{

		$data['problem']  = $res[0]['problem'];
		$data['anser']  = $_POST['answernew'];
		
	}else if(empty($_POST['questionidnew']))
	{

		$data['problem'] = $_POST['questionidnew'];
		$data['anser'] = $res[0]['anser'];
	}else if(empty($_POST['questionidnew'] && empty($_POST['answernew'])))
	{

		$data['problem']  = $res[0]['problem'];
		$data['anser'] = $res[0]['anser'];
	}


	$result = update($link , DB_PREFIX . 'user' , $data , "uid=  $uid");

	if($result)
	{
		
		//$notice = true;
		//$msg = '<i class="zi_green">修改成功</i>';
		//include 'notice.php';
                 


               $lastLogin['lastime'] = time();
               $uid = $_SESSION['uid'];
               $finalLogin = update($link , DB_PREFIX . 'user' , $lastLogin , "uid = $uid");


                $_SESSION[] = [];

                session_destroy();



                header('location:../index.php');
		die;
	}else
	{
		$notice = false;
		$msg = '<i class="zi_red">修改失败</i>';
		include 'notice.php';
		die;
	}


}

// 查询出来展示的用户信息
$updatePass = select($link , DB_PREFIX . 'user' , '*' , "uid = $uid");

display('passwordSecurity.html' , compact('dir' , 'title' , 'most' , 'webBtm' , 'webUrl' , 'webIcp' , 'updatePass','now'));