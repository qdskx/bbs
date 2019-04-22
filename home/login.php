<?php

include '../common/common_index.php';

$username = $_POST['username'];
$password = md5($_POST['pass']);

$res = select($link , DB_PREFIX . 'user' , '*' , "username = '$username' and password = '$password'");

if($res)
{	

	$ip = $res[0]['regip'];
	$existsCloseip = select($link , DB_PREFIX . 'closeip' , '*' , "ip = $ip");

	if($res[0]['allowlogin'] == 1)
	{
		$notice = false;
		$msg = '<i class="zi_red">您的账号已被锁定,请联系管理员</i>';
		include 'notice.php';
		die;	
	}else if($existsCloseip)
	{
		$notice = false;
		$msg = '<i class="zi_red">您的账号已被锁定,请联系管理员</i>';
		include 'notice.php';
		die;
	}else
	{

		$_SESSION['uid'] = $res[0]['uid'];
		$_SESSION['username'] = $res[0]['username'];
		$_SESSION['password'] = $res[0]['password'];
		$_SESSION['undertype'] = $res[0]['undertype'];
		$_SESSION['pic'] = $res[0]['pic'];


		$y = date('Y' , time());
		$m = date('m' , time());
		$d = date('d' , time());

		$start = mktime($y , $m , $d , 0 , 0 , 0);
		$end = mktime($y , $m , $d , 23 , 59 , 59);



		// 处理一天中只是第一次登陆的时候加积分
		if(date('Y-m-d' , time()) == date('Y-m-d' , $res[0]['lastime']))
		{
			if(!empty($res[0]['everlogin']))
			{
				$_SESSION['grade'] = $res[0]['grade'];

				$msg = '<i class="zi_green">登陆成功</i>';
			}else
			{
				$_SESSION['grade'] = $res[0]['grade'] + REWARD_LOGIN;

				$uid = $_SESSION['uid'];
				$plusGrade['grade'] = $_SESSION['grade'];
				$plusGrade['everlogin'] = 1;
				$grade = update($link , DB_PREFIX . 'user' , $plusGrade , "uid = $uid");
				
				$msg = '<i class="zi_green">登陆成功,加2积分</i>';
			}
		}else
		{
			$uid = $_SESSION['uid'];
			$yeater['everlogin'] = 0;
			

			$_SESSION['grade'] = $res[0]['grade'] + REWARD_LOGIN;

			
			$plusGrade['grade'] = $_SESSION['grade'];
			$plusGrade['everlogin'] = 1;
			$grade = update($link , DB_PREFIX . 'user' , $plusGrade , "uid = $uid");
			
			$msg = '<i class="zi_green">登陆成功,加2积分</i>';
		}



		


		$url = '../index.php';
		$notice = true;
		include 'notice.php';
		die;
	}


}else
{
	// 查现在正在登录的用户的trynum uid username
	$exists_user = select($link , DB_PREFIX . 'user' , 'username , uid , trynum' , "username = '$username'");
	
	var_dump($exists_user);

	if(empty($exists_user))
	{
		$notice = false;
		$msg = '<i class="zi_red">用户名不存在,请重新输入</i>';
		include 'notice.php';
		die;
	}

	// 得到将锁定的username
	$uname = $exists_user[0]['username'];

	// 将其uid赋值给一个变量
	$lock_uid = $exists_user[0]['uid'];
	// trynum 字段做累加操作
	$TryNum['trynum'] = $exists_user[0]['trynum'] + 1;
	// 执行对此用户的trynum的修改
	$Trynum = update($link , DB_PREFIX . 'user' , $TryNum , "uid = $lock_uid") ;

	// 继续查出当前用户的trynum
	$tryNum = select($link , DB_PREFIX . 'user' , 'trynum' , "uid = $lock_uid");
	// 将其赋值给一个变量 这将作为最后是否锁定账号的重要条件
	$trynum = $tryNum[0]['trynum'];

	if($trynum % 5 == 0)
	{
	
		$lock_acount['allowlogin'] = 1;
		$lock = update($link , DB_PREFIX . 'user' , $lock_acount , "uid = $lock_uid"); 			

		setcookie('uid' , $lock_uid , time()+60*60*24);
		setcookie('username' , $uname , time()+60*60*24);

		$notice = false;
		$msg = '<i class="zi_red">您已经5次登录不成功,账号已被锁定,请联系管理员</i>';
		include 'notice.php';
		die;
		
	}else if($trynum / 5 >= 1)
	{
		$notice = false;
		$msg = '<i class="zi_red">您的账号已经被锁,继续登录将导致更久的禁号处罚</i>';
		include 'notice.php';
		die;
	}
	else
	{
		$notice = false;
		$msg = '<i class="zi_red">用户名或密码错误</i>';
		
		include 'notice.php';
		die;
	}

}

