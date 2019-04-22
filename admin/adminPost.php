<?php

include '../common/common_admin.php';

$title = WEB_NAME . '-帖子管理-帖子管理';

if(empty($_SESSION['username']))
{
	$notice = false;
	$msg = '<i class="zi_red">抱歉,请您先去登录</i>';
	$url = 'adminLogin.php';
	include 'notice.php';
	die;

}else{

	// 分页查询帖子信息
	$elseTable = DB_PREFIX . 'details' . ',' . DB_PREFIX . 'category';
	$table = DB_PREFIX . 'user' . ',' . DB_PREFIX . 'details' . ',' . DB_PREFIX . 'category';
	$fields = '*';
	$elseWhere = 'tidtype = 1 and isdel = 0 and isdisplay = 0 and 9314_category.cid = 9314_details.cid';
	$where = 'tidtype = 1 and isdel = 0 and isdisplay = 0 and 9314_details.authorid = 9314_user.uid and 9314_category.cid = 9314_details.cid';
	$paging = lit($link , $elseTable , $table , $fields , $elseWhere , $where , 7);

	
	if(!empty($_POST['sub_del']))
	{
		if(isset($_POST['tid']))
		{
			$delTid = join(',' , $_POST['tid']);

			$exists_reply = select($link , DB_PREFIX. 'details' , '*' , "replyid in ($delTid)");

			if(!empty($exists_reply))
			{
				$notice = false;
				$msg = '<i class="zi_red">您即将放入回收站的帖子下面包含回复贴,不能放入回收站</i>';
				include 'notice.php';
				die;
			}else
			{

				$deltid['isdel'] = 1;

				$del = update($link , DB_PREFIX . 'details' , $deltid , "tid in ($delTid)");

				if($del)
				{
					$notice = true;
					$msg = '<i class="zi_green">成功放入回收站</i>';
					include 'notice.php';
					die;
				}else
				{
					$notice = false;
					$msg = '<i class="zi_red">放入回收站失败</i>';
					include 'notice.php';
					die;
				}
			}
	
		}
	}


	// 通过form表单处理接收到的page
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

		header("location:adminPost.php?page=$page_num");
		die;
	}
	
	display('adminPost.html' , compact('dir' , 'title' , 'paging'));

}