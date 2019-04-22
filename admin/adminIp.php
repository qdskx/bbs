<?php

include '../common/common_admin.php';

$title = WEB_NAME . '-用户管理-禁止IP';

if(empty($_SESSION['username']))
{
	$notice = false;
	$msg = '<i class="zi_red">抱歉,请您先去登录</i>';
	$url = 'adminLogin.php';
	include 'notice.php';
	die;

}else{

	$all_ip = select($link , DB_PREFIX . 'closeip' , '*');

	if(!empty($_POST['sub_ip']))
	{
		// 拼接用户输入的ip
		$ip1 = $_POST['ip1'];
		$ip2 = $_POST['ip2'];
		$ip3 = $_POST['ip3'];
		$ip4 = $_POST['ip4'];
		$ip = $ip1 . $ip2 . $ip3  . $ip4;

		// 判断输入的禁止日期是否是纯数字,是否为空,为空的话最大禁止20年
		if(empty($_POST['ban_day']))
		{
			$ban_day = 60*60*24*30*12*20;

		}else if(checkNum($_POST['ban_day']))
		{
			$day = $_POST['ban_day'];
			$ban_day = $day * 60*60*24;

		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">请确认您输入的是纯数字</i>';
			include 'notice.php';
			die;
		}

		// 判断输入的禁止IP是否是纯数字
		if(checkNum($ip))
		{
			$ip = $ip1 . '.' . $ip2 . '.' . $ip3 . '.' . $ip4;


			$ip = ip2long($ip);
			$IP = select($link , DB_PREFIX . 'user' , 'regip, undertype' , "regip = $ip");

			if($IP && $IP[0]['undertype'] == 0)
			{
				$data['ip'] = $ip;
				$data['addtime'] = time();
				$data['overtime'] = time() + $ban_day;

				$ban_ip = insert($link , DB_PREFIX . 'closeip' , $data);

				if($ban_ip)
				{
					$notice = true;
					$msg = '<i class="zi_green">禁止IP成功</i>';
					include 'notice.php';
					die;
				}else
				{
					$notice = false;
					$msg = '<i class="zi_red">禁止IP失败</i>';
					include 'notice.php';
					die;
				}

			}else if($IP && $IP[0]['undertype'] == 1)
			{
				$notice = false;
				$msg = '<i class="zi_red">管理员IP不能被禁止,请确认并重新输入</i>';
				include 'notice.php';
				die;
			}
			else
			{
				$notice = false;
				$msg = '<i class="zi_red">抱歉,不存在此IP,请确认并重新输入</i>';
				include 'notice.php';
				die;
			}

		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">请输入规范的IP地址</i>';
			include 'notice.php';
			die;
		}
	}

	if(isset($_GET['pid']) )
	{
		$pid = $_GET['pid'];

		if($_GET['unlock'] && $_GET['unlock'] == 1)
		{
				
			// $unlock['unlock'] = 1;
			$unlockIp = del($link , DB_PREFIX . 'closeip' ,"pid = $pid");

			if($unlockIp)
			{
				$notice = true;
				$msg = '<i class="zi_green">解除IP禁止成功</i>';
				include 'notice.php';
				die;
			}
			
		}

	}

	display('adminIp.html' , compact('dir' , 'title' , 'all_ip'));
}