<?php

include '../common/common_index.php';

$title = WEB_NAME . '-发帖界面';

// 判断用户是否登录,未登录就去登录(midLogin.php),否则就呈现发帖界面
if(empty($_SESSION['username']))
{	
	header('location:midLogin.php');
	die;
}else
{
	if(isset($_GET['cid']))
	{
		$cid = $_GET['cid'];
		// echo $cid;
		// 小版块classname
		$smallCate= select($link , DB_PREFIX . 'category' , 'classname , cid , parentid' , "cid = $cid");

		$bigId = $smallCate[0]['parentid'];
		// 大板块classname
		$bigCate = select($link , DB_PREFIX . 'category' , 'classname , cid' , "cid = $bigId");

	}else
	{
		$notice = false;
		$msg = "<i class='zi_red'>禁止非法操作</i>";
		$url = '../index.php';
		include 'notice.php';
	}



	if(!empty($_POST['postSub']))
	{

		$uid = $_SESSION['uid'];

		$data['authorid'] = $uid;
		$data['title'] = $_POST['title'];
		$data['content'] = $_POST['content'];
		$data['postime'] = time();
		$data['price'] = $_POST['price'];

		$ip = $_SERVER['REMOTE_ADDR'];
		if(!strcmp( $ip , '::1'))
		{
			$ip = '127.0.0.1';
		}
		$ip = ip2long($ip);
		$data['postip'] = $ip;

		$cid = $_GET['cid'];

		$data['cid'] = $cid;


		$verify = $_POST['verify'];
		// 判断用户输入的验证码是否正确
		if(!(strtolower($verify) == strtolower($_SESSION['verify'])))
		{
			$notice = false;
			$msg = '<i class="zi_red">验证码输入错误,请重新输入</i>';
			include 'notice.php';
			die;
		}

		$res = insert($link , DB_PREFIX . 'details' , $data);


		if($res)
		{

			// 发帖插入成功后先修改板块表
			$postNum = select($link , DB_PREFIX . 'category' , 'postnum , lastpost' , "cid = $cid");

			// 还要修改板块表里面的最后发表时间9314_category  lastpost
			// 先查出用户的最后的发帖时间,这个是在帖子表里面,9314_details postime
			$postTime = select($link , DB_PREFIX . 'details' , 'postime , tid' , "" , "order by postime desc limit 1");

			$postnum['postnum'] = $postNum[0]['postnum'] + 1;
			$postnum['lastpost'] = $postTime[0]['postime'];

			$postnum = update($link , DB_PREFIX . 'category' , $postnum , "cid = $cid");



			// 修改大板块的postnum lastnum
			// 查出大板块的cid
			$BigCateCid = select($link , DB_PREFIX . 'category' , 'parentid' , "cid = $cid");
			// 得到大板块的cid
			$BigCatecid = $BigCateCid[0]['parentid'];
			// 查出大板块的postnum lastpost
			$BigCate = select($link , DB_PREFIX . 'category' , 'postnum , lastpost' , "cid = $BigCatecid");
			// 开始加一
			$Bigcate['postnum'] = $BigCate[0]['postnum'] + 1;
			$Bigcate['lastpost'] = $postTime[0]['postime'];
			// 做修改
			$bigcate = update($link , DB_PREFIX . 'category' , $Bigcate , "cid = $BigCatecid");


			// 修改小版块的postnum lastime
			



			// 发帖成功后还要修改用户表,加积分的
			$updateGrade = select($link , DB_PREFIX . 'user' , 'grade' , "uid = $uid");

			$updategrade['grade'] = $updateGrade[0]['grade'] + REWARD_T;

			$grade = update($link , DB_PREFIX . 'user' , $updategrade , "uid = $uid");

			// 查询出发帖用户的积分,更新session信息
			$finalGrade = select($link , DB_PREFIX . 'user' , 'grade' , "uid = $uid");

			$_SESSION['grade'] = $finalGrade[0]['grade'];

			$notice = true;
			$msg = '<i class="zi_green">帖子发表成功,加2积分</i>';
			$tid = $postTime[0]['tid'];
			header("location:returnCard.php?cid=$cid&tid=$tid");
			die;
		}else
		{
			$notice = false;
			$msg = "<i class='zi_red'>帖子发表失败,请联系管理员</i>";
			include 'notice.php';
		}
	}else
	{
		display('posting.html' , compact('dir' , 'title' , 'most' , 'webBtm' , 'webUrl' , 'webIcp' , 'now' , 'bigCate' , 'smallCate'));
	}

	
}