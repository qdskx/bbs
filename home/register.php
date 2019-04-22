<?php

include '../common/common_index.php';

$title = WEB_NAME . '注册页面';

if(!empty($_POST['subReg']))
{
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$repassword = trim($_POST['repassword']);
	$email = $_POST['email'];
	$verify = $_POST['verify'];

	if(!(strtolower($verify) == strtolower($_SESSION['verify'])))
	{
		$notice = false;
		$msg = '<i class="zi_red">验证码输入错误,请重新输入</i>';
		include 'notice.php';
		die;
	}

	if(stringLen($username))
	{

		// $str = strlen($username);
		$notice = false;
		$msg ='<i class="zi_red">您输入的用户名不合法,用户名由6~12个字符组成,请重新输入</i>';
		include 'notice.php';	
		die;
		
	}else
	{
		$res = select($link , DB_PREFIX . 'user' , 'username' , "username = '$username'");

		if($res)
		{
			$notice = false;
			$msg ='<i class="zi_red">用户名已存在,请重新输入</a>';
			include 'notice.php';
			die;
		}
	}

	if(!strEqual($password , $repassword))
	{
		if(!stringLen($password))
		{
			$notice = false;
			$msg = '<i class="zi_red">您输入的密码不合法,密码由6~12个字符组成,请重新输入</i>';
			include 'notice.php';
			die;
		}else if(checkNum($password))
		{
			$notice = false;
			$msg = '<i class="zi_red">密码不能为纯数字</i>';
			include 'notice.php';
			die;
		}
		
	}else
	{
		$notice = false;
		$msg = '<i class="zi_red">两次输入密码不一致,请重新输入</i>';
		include 'notice.php';
		die;
	}

	if(checkEmail($email))
	{
		$notice = false;
		$msg = '<i class="zi_red">邮箱各式不正确,请重新输入</i>';

		include 'notice.php';
		die;
	}



	$data['username'] = $username;
	$data['password'] = md5($password);
	$data['email'] = $email;
	$data['regtime'] = time();
	$data['lastime'] = time();

	$ip = $_SERVER['REMOTE_ADDR'];
	if(!strcmp( $ip , '::1'))
	{
		$ip = '127.0.0.1';
	}

	$ip = ip2long($ip);

	$data['regip'] = $ip;

	$result = insert($link , DB_PREFIX . 'user' , $data);

	if($result && mysqli_affected_rows($link))
	{
		$uid = mysqli_insert_id($link);

		$res = select($link , DB_PREFIX . 'user' , "*" , "uid = $uid");

		$_SESSION['uid'] = $res[0]['uid'];
		$_SESSION['username'] = $res[0]['username'];
		$_SESSION['password'] = $res[0]['password'];
		$_SESSION['grade'] = $res[0]['grade'] + REWARD_REG;
		$_SESSION['undertype'] = $res[0]['undertype'];
		$_SESSION['pic'] = $res[0]['pic'];

		$plusGrade['grade'] = $_SESSION['grade'];
		$grade = update($link , DB_PREFIX . 'user' , $plusGrade , "uid = $uid");


		$url = '../index.php';
		$notice = true;
		$msg = '<i class="zi_green">感谢您的注册，现在将以会员身份登录站点</i>';

		include 'notice.php';
		die;

	}else
	{
		$notice = false;
		$msg = '<i class="zi_red">注册失败,请联系管理员</i>';

		include 'notice.php';
		die;
	}

}else
{
	display('register.html' , compact('dir' , 'title' , 'most' , 'webBtm' , 'webUrl' , 'webIcp' , 'now'));
}


