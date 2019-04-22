<?php

include '../common/common_admin.php';

$title = WEB_NAME . '-帖子管理-帖子回收站';

if(empty($_SESSION['username']))
{
	$notice = false;
	$msg = '<i class="zi_red">抱歉,请您先去登录</i>';
	$url = 'admin_login.php';
	include 'notice.php';
	die;

}else{

	// 分页查询帖子信息
	$elseTable = DB_PREFIX . 'details' . ',' . DB_PREFIX . 'category';
	$table = DB_PREFIX . 'user' . ',' . DB_PREFIX . 'details' . ',' . DB_PREFIX . 'category';
	$fields = '*';
	$elseWhere = 'tidtype = 1 and isdel = 1 and isdisplay = 0 and 9314_category.cid = 9314_details.cid';
	$where = 'tidtype = 1 and isdel = 1 and isdisplay = 0 and 9314_details.authorid = 9314_user.uid and 9314_category.cid = 9314_details.cid';
	$paging = lit($link , $elseTable , $table , $fields , $elseWhere , $where , 5);

	
	if(!empty($_POST['tid']))
	{
		$mulDelTid = join(',' , $_POST['tid']);

		// 删除主题
		if(!empty($_POST['sub_del']))
		{
		
                         

			$mulDel = del($link , DB_PREFIX . 'details' , "tid in ($mulDelTid)");

                       // 查询当前板块的帖子数    
                       // foreach($_POST['tid'] as $val)
                       // {
                       //        // 被删的帖子所在板块
                       //        $postCid = select($link , DB_PREFIX . 'details' , 'cid' , "tid = $val");
                       //         //小版块cid
                       //         $postcid = $postCid[0]['cid'];

                       //         $postNum = select($link , DB_PREFIX . 'category' , 'postnum' , "cid = $postcid");
                       //        $nowPostnum['postnum'] = $postNum[0]['postnum'] - 1;

                       //        //做修改(小版块)
                       //        $delRes = update($link , DB_PREFIX . 'category' , $nowPostnum , "cid = $postcid");

                       //        // 根据小版块cid查询出来大板块cid
                       //         $bigCid = select($link , DB_PREFIX  . 'category' , 'parentid' , "cid = $postcid");

                       //         $bigcid = $bigCid[0]['parentid'];

                       //        // 查询大板块的postnum
                       //         $bigPostnum = select($link , DB_PREFIX . 'category' , 'postnum' , "cid = $bigcid");

                       //        $bigpostnum['postnum'] = $bigPostnum[0]['postnum'];

                       //        $delBig = update($link , DB_PREFIX . 'category' , $bigpostnum , "cid = $bigcid");

                       //        $mulDel = del($link , DB_PREFIX . 'details' , "tid = $val");
                       // }

			// if($mulDel && $delRes && $delBig)
			if($mulDel)
			{
				$notice = true;
				$msg = '<i class="zi_green">删除主题成功</i>';
				include 'notice.php';
				die;
			}else
			{
				$notice = false;
				$msg = '<i class="zi_red">删除主题失败</i>';
				include 'notice.php';
				die;
			}
		
		}

		// 恢复主题
		if(!empty($_POST['sub_recover']))
		{
			$mulRecover['isdel'] = 0;

			$mulrecover = update($link , DB_PREFIX . 'details' , $mulRecover , "tid in ($mulDelTid)");

			if($mulrecover)
			{
				$notice = true;
				$msg = '<i class="zi_green">恢复主题成功</i>';
				include 'notice.php';
				die;
			}else
			{
				$notice = false;
				$msg = '<i class="zi_red">恢复主题失败</i>';
				include 'notice.php';
				die;
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

		header("location:adminPostdel.php?page=$page_num");
		die;
	}	

	

	display('adminPostdel.html' , compact('dir' , 'title' , 'paging'));

}

