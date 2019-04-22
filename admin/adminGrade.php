<?php

include '../common/common_admin.php';

$title = WEB_NAME . '-用户管理-编辑用户-详情';

if(empty($_SESSION['username']))
{
	$notice = false;
	$msg = '<i class="zi_red">抱歉,请您先去登录</i>';
	$url = 'adminLogin.php';
	include 'notice.php';
	die;

}else{

	if(isset($_GET['uid']))
	{
		$uid = $_GET['uid'];
		$Details = select($link , DB_PREFIX . 'user' , '*' , " uid = $uid");
	}

	// 管理员点击了修改用户信息的按钮	
	if(!empty($_POST['sub_user']))
	{
		// 判断用户是否需要修改新密码
		if(!empty($_POST['newpass']))
		{
			$password = $_POST['newpass'];
	
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
			}else
			{
				$data['password'] = md5($password);
			}
				
		}else
		{
			$data['password'] = $Details[0]['password'];
		}

		// 判断用户是否需要清除安全提问
		if(!empty($_POST['switch']))
		{
			$data['problem'] = '';
		}else
		{
			$data['problem'] = $Details[0]['problem'];
		}

		// 判断管理员是否需要锁定当前用户,其中管理员不能被锁定
		
			if(!empty($_POST['lock']))
			{
				if($Details[0]['undertype'] == 1)
				{
					$notice = false;
					$msg = "<i class='zi_red'>管理员不能被锁定</i>";
					include 'notice.php';
					die;
				}else
				{
					$data['allowlogin'] = 1;
				}
			}else
			{
				$data['allowlogin'] = 0;
			}			
		


		// 判断是否修改邮箱
		if(!empty($_POST['email']))
		{
			$email = $_POST['email'];
			if(checkEmail($email))
			{
				$notice = false;
				$msg = '<i class="zi_red">邮箱各式不正确,请重新输入</i>';

				include 'notice.php';
				die;
			}else
			{
				$data['email'] = $email;
			}
		}else
		{
			$data['email'] = $Details[0]['email'];
		}

		// 判断是否修改注册IP
		if(!empty($_POST['regip']))
		{
			$ip = $_POST['regip'];

			if(!strcmp( $ip , '::1'))
			{
				$ip = '127.0.0.1';
			}

			$ip = ip2long($ip);

			$data['regip'] = $ip;
		}else
		{
			$data['regip'] = $Details[0]['regip'];
		}

		// 判断是否修改注册时间
		if(!empty($_POST['regtime']))
		{
			$time = $_POST['regtime'];
			$data['regtime'] = strtotime($time);
		}else
		{
			$data['regtime'] = $Details[0]['regtime'];
		}

		// 判断是否修改上次访问的时间
		if(!empty($_POST['visited']))
		{
			$lastime = $_POST['visited'];
			$data['lastime'] = strtotime($lastime);
		}else
		{
			$data['lastime'] = $Details[0]['lastime'];
		}

		// 判断积分
		if(!empty($_POST['grade']))
		{
			$originGrade = $Details[0]['grade'];
			$nowGrade = $_POST['grade'];

			$data['grade'] = $originGrade + $nowGrade;
		}else
		{
			$data['grade'] = $Details[0]['grade'];
		}

		// 判断签名
		if(!empty($_POST['autograph']))
		{
			$data['autograph'] = $_POST['autograph'];
		}else
		{
			if(is_null($Details[0]['autograph']))
			{
				$data['autograph'] = '';
			}else
			{
				$data['autograph'] = $Details[0]['autograph'];
			}
			
		}

		// 判断真是姓名
		if(!empty($_POST['realname']))
		{
			$data['realname'] = $_POST['realname'];
		}else
		{
			if(is_null($Details[0]['realname']))
			{
				$data['realname'] = '';
			}else{
				$data['realname'] = $Details[0]['realname'];
			}
			
		}

		// 判断性别
		if(!empty($_POST['sex']))
		{
			$data['sex'] = $_POST['sex'];
		}else
		{
			if(is_null($Details[0]['sex']))
			{
				$data['sex'] = '';
			}else{
				$data['sex'] = $Details[0]['sex'];
			}		
		}

		// 判断生日
		if(!empty($_POST['year']) && !empty($_POST['month']) && !empty($_POST['day']))
		{
			$birthday = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
			
			var_dump($birthday);

			$data['birthday'] = $birthday;

			echo 'ddddddddddd';

			var_dump($data['birthday']);

		}else
		{
			echo 'rrrrrrrrrr';

			if(isset($Details[0]['birthday']))
			{
				$data['birthday'] = $Details[0]['birthday'];
			}else
			{
				$data['birthday'] = '';
			}
			
		}

		// 判断籍贯
		if(!empty($_POST['place']) && $_POST['place'] <> '省份')
		{
			$data['address'] = $_POST['place'];
		}else
		{
			if(is_null($Details[0]['address']))
			{
				$data['address'] = null;
			}else
			{
				$data['address'] = $Details[0]['address'];
			}
			
		}


		$res = update($link , DB_PREFIX . 'user' , $data , "uid = $uid");

		if($res && mysqli_affected_rows($link))
		{
			header("location:adminGrade.php?uid=$uid#grade");
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">修改失败</i>';

			// include '2.php';
			include 'notice.php';
			die;
		}
			
	}

	display('adminGrade.html' , compact('dir' , 'title' , 'Details'));

}
