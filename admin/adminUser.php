<?php

include '../common/common_admin.php';

$title = WEB_NAME . '-用户管理-编辑用户';

if(empty($_SESSION['username']))
{
	$notice = false;
	$msg = '<i class="zi_red">抱歉,请您先去登录</i>';
	$url = 'adminLogin.php';
	include 'notice.php';
	die;

}else{


	// 查询所有用户并分页
	$elseTable = DB_PREFIX . 'user';
	$table = DB_PREFIX . 'user';
	$fields = '*';
	$elseWhere = 'checkdel = 0';
	$where = "checkdel = 0";


	$paging = lit($link , $elseTable , $table , $fields , $elseWhere , $where , 5);
	


	


	// 处理用户的锁定与解除锁定allowlogin
	if(isset($_GET['uid']))
	{
		$uid = $_GET['uid'];
		
		if(isset($_GET['lock']) && $_GET['lock'] == 1)
		{

			$lockAble = select($link , DB_PREFIX . 'user' , '*' , "uid = $uid");

			if($lockAble[0]['undertype'] == 1)
			{
				$notice = false;
				$msg = "<i class='zi_red'>抱歉,管理员不能被锁定</i>";
				include 'notice.php';
				die;
			}


			$AllowLogin['allowlogin'] = 1;

			$allowlogin = update($link , DB_PREFIX . 'user' , $AllowLogin , "uid = $uid");
			header('location:adminUser.php');
		}else
		{
		
			$AllowLogin['allowlogin'] = 0;

			$allowlogin = update($link , DB_PREFIX . 'user' , $AllowLogin , "uid = $uid");
			header('location:adminUser.php');
		}
	}
	





	// 处理form表单提交过来的page
	if(!empty($_POST['sub_page']))
	{
		$page_num = $_POST['page_num'];

		if($page_num > $paging['pageCount'])
		{
			$page_num = $paging['pageCount'];
		}

		if($page_num < 1)
		{
			$page_num = 1;
		}

		if(!empty($key))
		{
			header("location:adminUser.php?page=$page_num&search=$key");
			die;
		}else
		{
			header("location:adminUser.php?page=$page_num");
			die;
		}
		
	}


	// 处理用户的增删改查
	// 1、添加用户
	if(!empty($_POST['sub_addd']))
	{
		$mulAdd['username'] = $_POST['add_uname'];
		$mulAdd['password'] = md5($_POST['add_pass']);
		$mulAdd['regtime'] = time();
		$mulAdd['lastime'] = time();

		$ip = $_SERVER['REMOTE_ADDR'];
		if(!strcmp( $ip , '::1'))
		{
			$ip = '127.0.0.1';
		}
		$ip = ip2long($ip);
		$mulAdd['regip'] = $ip;

		$mulAdd['email'] = $_POST['add_email'];

		if($_POST['add_undertype'] == '管理员')
		{
			$mulAdd['undertype'] = 1;
		}

		$add = insert($link , DB_PREFIX . 'user' , $mulAdd);

		if($add)
		{
			$notice = true;
			$msg = '<i class="zi_green">添加用户成功</i>';
			include 'notice.php';
			die;
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">添加用户失败</i>';
			include 'notice.php';
			die;
		}


	}
	
	if(!empty($_POST['uid']))
	{
		$mulUid = $_POST['uid'];
		$mulDeluid = join(',' , $mulUid);

		// 2、删除用户(伪删除)
		if(!empty($_POST['sub_del']))
		{

			// 判断即将删除的用户是否是管理员
			$isWarden = select($link , DB_PREFIX . 'user' , 'undertype' , "uid in ($mulDeluid) and undertype = 1");

	

			if(!empty($isWarden))
			{
				
				$notice = false;
				$msg = '<i class="zi_red">管理员不能被删除</i>';
				include 'notice.php';
				die;
			}else
			{
				$table = DB_PREFIX . 'user' . ',' . DB_PREFIX . 'details';
				$postTid = select($link , $table , 'tid' , "authorid in ($mulDeluid)");

				



				$mulDel['checkdel'] = 1 ;
				$del = update($link , DB_PREFIX . 'user' , $mulDel , "uid in ($mulDeluid)"); 
				if($del)
				{
					$notice = true;
					$msg = '<i class="zi_green">删除用户成功</i>';
					include 'notice.php';
					die;
				}else
				{
					$notice = false;
					$msg = '<i class="zi_red">删除用户失败</i>';
					include 'notice.php';
					die;
				}
			}

			
		}
		
	}
	

	






	display('adminUser.html' , compact('dir' , 'title' , 'paging' , 'key'));
}