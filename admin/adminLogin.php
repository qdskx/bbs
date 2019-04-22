<?php

include '../common/common_admin.php';

$title = WEB_NAME . '-后台管理中心';


// 当管理员点击登录按钮之后,不存在非管理员却进入了后台登录页面的情况
if(!empty($_POST['subLogin']))
{	

	$username = $_POST['username'];
	$password = md5($_POST['password']);

	$check_login = select($link , DB_PREFIX . 'user' , 'uid , undertype , username , password , grade , pic , problem , anser' , "username = '$username' and password = '$password'");

	if($check_login && $check_login[0]['undertype'] == 1)
	{


		// 判断是否有安全提问
		if(!empty($_POST['question']) && !empty($_POST['answer']))
		{
			$problem = $_POST['question'];
			$anser = $_POST['answer'];


			if(!strcmp($problem , $check_login[0]['problem']))
			{	
				$notice = false;
				$msg = '<i class="zi_red">安全提问错误,请重新选择安全提问</i>';
				include 'notice.php';
				die;

			}else if(strcmp($anser , $check_login[0]['anser']))
			{
				$notice = false;
				$msg = '<i class="zi_red">安全提问答案错误,请重新输入</i>';
				include 'notice.php';
				die;
			}else
			{
				$_SESSION['uid'] = $check_login[0]['uid'];
				$_SESSION['username'] = $check_login[0]['username'];
				$_SESSION['undertype'] = $check_login[0]['undertype'];
				$_SESSION['grade'] = $check_login[0]['grade'];
				$_SESSION['pic'] = $check_login[0]['pic'];

				$notice = true;
				$msg = '<i class="zi_green">成功进入bbs后台管理界面</i>';
				$url = 'adminInfo.php';
				include 'notice.php';
				die;
			}

		}else
		{
			$_SESSION['uid'] = $check_login[0]['uid'];
			$_SESSION['username'] = $check_login[0]['username'];
			$_SESSION['undertype'] = $check_login[0]['undertype'];
			$_SESSION['grade'] = $check_login[0]['grade'];
			$_SESSION['pic'] = $check_login[0]['pic'];

			$notice = true;
			$msg = '<i class="zi_green">成功进入bbs后台管理界面</i>';
			$url = 'adminInfo.php';
			include 'notice.php';
			die;
		}

	}else
	{
		$notice = false;
		$msg = '<i class="zi_red">用户名或密码错误</i>';
		// $url = 'admin_login.php';
		include 'notice.php';
		die;
	}

}







display('adminLogin.html',  compact('dir' , 'title'));