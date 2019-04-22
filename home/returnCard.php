<?php

include '../common/common_index.php';

$title = WEB_NAME . '-回帖';

// 判断是否可以得到小版块的cid
if(isset($_GET['cid']) && isset($_GET['tid']))
{



	// 通过地址栏得到小版块的cid
	$cid = $_GET['cid'];

	// 小版块classname
	$smallCate = select($link , DB_PREFIX . 'category' , 'classname , cid , parentid , compere' , "cid = $cid");

	$bigid = $smallCate[0]['parentid'];
	// 大板块classname
	$bigCate = select($link , DB_PREFIX . 'category' , 'classname , cid' , "cid = $bigid");

	// 当前的帖子id
	$tid = $_GET['tid'];
	$table = DB_PREFIX . 'details' . ',' . DB_PREFIX . 'user';
	$postInfo = select($link , $table , '*' , "tid = $tid and authorid = uid ");

	// 判断用户是否购买过这个帖子
	if($postInfo[0]['price'])
	{
		if(isset($_SESSION['uid']))
		{
			$uid = $_SESSION['uid'];

			$table = DB_PREFIX . 'order';
			$isPurchase = select($link , $table , '*' , "tid = $tid and uid = $uid");
		}

	}


	// 浏览次数增加
	$postViews['views'] = $postInfo[0]['views'] + 1;
	$view = update($link , DB_PREFIX . 'details' , $postViews , "tid = $tid");



	// 查小于当前板块当前帖子的帖子
	$prev_post = select($link , DB_PREFIX . 'details' , 'tid' , "tid < $tid and cid = $cid and isdel = 0 and tidtype = 1" , 'order by tid desc');

	// 当前板块最小的帖子tid(防止越界)
	$min_prev_post = MyMin($link , DB_PREFIX . 'details' , 'tid' , "cid = $cid and isdel = 0 and tidtype = 1");
	if($prev_post)
	{
		$prev_tid = $prev_post[0]['tid'];
	}else
	{
		$prev_tid = $min_prev_post;
	}

	// 查大于当前板块当前帖子的帖子
	$next_post = select($link , DB_PREFIX . 'details' , 'tid' , "tid > $tid and cid = $cid and isdel = 0 and tidtype = 1 ");
	// 当前板块最大的帖子tid(防止越界)
	$max_next_post = MyMax($link , DB_PREFIX . 'details' , 'tid' , "cid = $cid and isdel = 0 and tidtype = 1");
	if($next_post)
	{
		$next_tid = $next_post[0]['tid'];
	}else
	{
		$next_tid = $max_next_post;
	}


	// 分页
	// 查回复的帖子 
	$elseTable = DB_PREFIX . 'details';
	$table = DB_PREFIX . 'user' . ',' . DB_PREFIX . 'details';
	$fields = 'tid';
	$elseWhere = "tidtype = 0 and isdel = 0 and replyid = $tid";
	$where = "tidtype = 0 and isdel = 0 and replyid = $tid and authorid = uid order by istop desc , toptime desc , postime asc ";

	$paging = lit($link , $elseTable , $table , $fields , $elseWhere , $where , 6);



}else
{
	$notice = false;
	$msg = '<i class="zi_red">禁止非法操作</i>';
	$url = '../index.php';
	include 'notice.php';
	die;
}



// 只有管理员才可以删除、置顶、高亮、精华


// 精华 置顶
if(isset($_GET['istop']) || isset($_GET['essence']))
{

	// 精华
	if(isset($_GET['essence']) && $_GET['essence'] == 1)
	{
		$isEssence['essence'] = 1;
		$essence = update($link , DB_PREFIX . 'details' , $isEssence , "tid = $tid" );

		if($essence)
		{
			$notice = true;
			$msg = '<i class="zi_green">此帖子已加入精华帖</i>';
			$url = "list.php?cid=$cid";
			include 'notice.php';
			die;
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">加入精华帖失败</i>';
			include 'notice.php';
			die;
		}
	}


	// 置顶
	if(isset($_GET['istop']) && $_GET['istop'] == 1)
	{
		$isTop['istop'] = 1;
		$isTop['toptime'] = time();
		$istop = update($link , DB_PREFIX . 'details' , $isTop , "tid = $tid" );

		if($istop)
		{
			$notice = true;
			$msg = '<i class="zi_green">帖子置顶成功</i>';
			$url = "list.php?cid=$cid";
			include 'notice.php';
			die;
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">帖子置顶失败</i>';
			include 'notice.php';
			die;
		}
	}else
	{

		$isTop['istop'] = 0;
		$isTop['toptime'] = 0;
		$istop = update($link , DB_PREFIX . 'details' , $isTop , "tid = $tid" );

		if($istop)
		{
			$notice = true;
			$msg = '<i class="zi_green">帖子取消置顶成功</i>';
			$url = "list.php?cid=$cid";
			include 'notice.php';
			die;
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">帖子取消置顶失败</i>';
			include 'notice.php';
			die;
		}
	}


}


// 高亮
if(isset($_GET['ishighlight']) && isset($_GET['ishighlight']) == 1)
{

	$isHighlight['ishighlight'] = 1;
	$ishighlight = update($link , DB_PREFIX . 'details' , $isHighlight , "tid = $tid" );

	if($ishighlight)
	{
		$notice = true;
		$msg = '<i class="zi_green">帖子高亮成功</i>';
		$url = "list.php?cid=$cid";
		include 'notice.php';
		die;
	}else
	{
		$notice = false;
		$msg = '<i class="zi_red">帖子高亮失败</i>';
		include 'notice.php';
		die;
	}	

}



// 两个删除主题区别开来,给不一样的名字
// 删除发帖主题 
if(isset($_GET['isdel']) && $_GET['isdel'] == 1)
{
	// 查询帖子有没有回复贴
	$existsReply = select($link , DB_PREFIX . 'details' , 'replycount' , "tid = $tid");

	$replycount = $existsReply[0]['replycount'];

	if($replycount != 0)
	{
		$notice = false;
		$msg = '<i class="zi_red">此帖子包含回复贴,不可删除</i>';

		include 'notice.php';
		die;		
	}else
	{

		// 先查出所删除的发帖所在的小版块。
		$smallCate = select($link , DB_PREFIX . 'details' , 'cid' , "tid = $tid");
		// 得到小版块的cid($将其赋值给一个变量)
		$smallCate_cid = $smallCate[0]['cid'];
		// 查出小版块的postnum
		$smallCate_postnum = select($link , DB_PREFIX . 'category' , 'postnum' , "cid = $smallCate_cid");
		// 此时小版块的Postnum字段要减1
		$smallCate_postnumRes['postnum'] = $smallCate_postnum[0]['postnum'] - 1; 
		// 做修改 对小版块的postnum
		$smallCate_postnumres = update($link , DB_PREFIX . 'category' , $smallCate_postnumRes , "cid = $smallCate_cid");
		

		// 再查小版块对应的大板块
		$bigCate = select($link , DB_PREFIX . 'category' , 'parentid' , "cid = $smallCate_cid");
		// 得到大板块的cid
		$bigCate_cid = $bigCate[0]['parentid'];
		// 查大板块的Postnum字段
		$bigCate_postnum = select($link , DB_PREFIX . 'category' , 'postnum' , "cid = $bigCate_cid");
		// 对齐postnum字段做减1操作
		$bigCate_postnumRes['postnum'] = $bigCate_postnum[0]['postnum'] - 1;
		// 修改大板块的POstnum
		$bigCate_postnumres = update($link , DB_PREFIX . 'category' , $bigCate_postnumRes , "cid = $bigCate_cid");


		$isDel['isdel'] = 1;
		$isdel = update($link , DB_PREFIX . 'details' , $isDel , "tid = $tid" );
	
		if($isdel)
		{
			$notice = true;
			$msg = '<i class="zi_green">删除主题成功</i>';
			$url = "list.php?cid=$cid";
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


}



// 回复贴的置顶
if(isset($_GET['replytop']))
{

	if($_GET['replytop'] == 1)
	{
		$replyTop['istop'] = 1;
		$replyTop['toptime'] = time();
		$replytop = update($link , DB_PREFIX . 'details' , $replyTop , "tid = $tid" );

		if($replytop)
		{
			$notice = true;
			$msg = '<i class="zi_green">帖子置顶成功</i>';
			include 'notice.php';
			die;
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">帖子置顶失败</i>';
			include 'notice.php';
			die;
		}
	}else
	{
		$replyTop['istop'] = 0;
		$replyTop['toptime'] = 0;
		$replytop = update($link , DB_PREFIX . 'details' , $replyTop , "tid = $tid" );

		if($replytop)
		{
			$notice = true;
			$msg = '<i class="zi_green">帖子取消置顶成功</i>';
			include 'notice.php';
			die;
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">帖子取消置顶失败</i>';
			include 'notice.php';
			die;
		}
	}
	
}

// 删除回帖
if(isset($_GET['replydel']) && $_GET['replydel'] == 1)
{
	
	$ExistsReply = select($link , DB_PREFIX . 'details' , 'replycount' , "tid = $tid");

	$reply_replycount = $ExistsReply[0]['replycount'];

	if($reply_replycount != 0)
	{
		$notice = false;
		$msg = '<i class="zi_red">此回帖包含回复贴,不可删除</i>';

		include 'notice.php';
		die;		
	}else
	{
		// 先查出回帖对应的小版块的cid
		$LitteCateCid = select($link , DB_PREFIX . 'details' , 'cid' , "tid = $tid");
		// 得到小版块的cid
		$LittleCatecid = $LitteCateCid[0]['cid'];
		// 再查出此小版块对应的回帖数量replynum
		$LittleCateReplynum = select($link , DB_PREFIX . 'category' , 'replynum' , "cid = $LittleCatecid");
		// 这个回帖数量要减一
		$LittleCatereplynum['replynum'] = $LittleCateReplynum[0]['replynum'] - 1;
		// 做修改
		$Littlecate = update($link , DB_PREFIX . 'category' , $LittleCatereplynum , "cid = $LittleCatecid");



		// 找到赌赢的大板块的cid
		$GreatCateCid = select($link , DB_PREFIX . 'category' , 'parentid' , "cid = $LittleCatecid");
		// 赋值给一个变量
		$GreateCatecid = $GreatCateCid[0]['parentid'];
		// 查询大板块的replycount
		$GreateCateReplycount = select($link , DB_PREFIX . 'category' , 'replynum' , "cid = $GreateCatecid");
		// 做减一操作
		$GreateCatereplycount['replynum'] = $GreateCateReplycount[0]['replynum'] - 1; 
		// 做修改
		$Greatecate = update($link , DB_PREFIX . 'category' , $GreateCatereplycount , "cid = $GreateCatecid");


		// 修改被回复的帖子即发帖的回复量
		$PostTid = select($link , DB_PREFIX . 'details' , 'replyid' , "tid = $tid");
		// 得到发帖的tid
		$Posttid = $PostTid[0]['replyid'];
		// 得到发帖的回复量replycount
		$PostReplyCount = select($link , DB_PREFIX . 'details' , 'replycount' , "tid = $Posttid");
		// 做减一操作
		$PostReplycount['replycount'] = $PostReplyCount[0]['replycount'] - 1;
		// 做修改
		$postreplycount = update($link , DB_PREFIX . 'details' , $PostReplycount , "tid = $Posttid");



		$replyDel['isdel'] = 1;
		$replydel = update($link , DB_PREFIX . 'details' , $replyDel , "tid = $tid");

		if($replydel)
		{
			$notice = true;
			$msg = '<i class="zi_green">删除回帖成功</i>';
			include 'notice.php';
			die;
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">删除回帖失败</i>';
			include 'notice.php';
			die;
		}

	}

		
}



// 屏蔽	(可以被屏蔽的只能是回复贴)
if(isset($_GET['isdisplay']))
{

	if($_GET['isdisplay'] == 1 )
	{
		// 查询帖子有没有回复贴,
		$existsReplycount = select($link , DB_PREFIX . 'details' , 'replycount' , "tid = $tid");

		$existsreplycount = $existsReplycount[0]['replycount'];

		if($existsreplycount != 0)
		{
			$notice = false;
			$msg = "<i class='zi_red'>此回复贴包含其他的回复贴,不可屏蔽</i>";
			include 'notice.php';
			die;
		}else
		{

			// 被屏蔽的回复贴修改isdisplay=1
			$isDisplay['isdisplay'] = 1;
			$isdisplay = update($link , DB_PREFIX . 'details' , $isDisplay , "tid = $tid" );
			
			// if($isdisplay && $updateDisplay && mysqli_affected_rows($link))
			if($isdisplay)
			{
				$notice = true;
				$msg = '<i class="zi_green">此回帖已屏蔽</i>';
				include 'notice.php';
				$url = "list.php?cid=$cid";
				die;
			}else
			{
				$notice = false;
				$msg = '<i class="zi_red">回帖屏蔽失败</i>';
				include 'notice.php';
				die;
			}

		}
	}

}





// 判断用户是否存在回帖操作
// 如果存在,判断用户是否登录,咩有登陆的话跳转到midLogin,已经登陆过的话直接发回帖
// 如果不存在,显示回帖界面
if(!empty($_POST['subReply']) )
{

	if(isset($_SESSION['username']))
	{
		$data['tidtype'] = 0;
		$data['replyid'] = $tid;
		$data['authorid'] = $_SESSION['uid'];

		if(empty($_POST['content']))
		{
			$notice = false;
			$msg = '<i class="zi_red">请输入评论内容</i>';
			include 'notice.php';
			die;
		}else
		{
			$data['content'] = $_POST['content'];
		}
		
		$data['postime'] = time();

		$ip = $_SERVER['REMOTE_ADDR'];
		if(!strcmp( $ip , '::1'))
		{
			$ip = '127.0.0.1';
		}
		$ip = ip2long($ip);
		$data['postip'] = $ip;

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

		// 开始插入用户发的回帖
		$replyCont = insert($link , DB_PREFIX . 'details' , $data);

		if($replyCont)
		{
			// 回复帖子成功之后被回复的帖子的replycount要加1
			// 查询被回复的帖子的当前回复量(replycount)
			// 首先是帖子表
			$deta_replycount = select($link , DB_PREFIX . 'details' , 'replycount' , "tid = $tid");

			$replycount['replycount'] = $deta_replycount[0]['replycount'] + 1;
			$result = update($link , DB_PREFIX . 'details' , $replycount  , "tid = $tid");

			// 而后是板块表的replynum(注意这要区分是大板块的还是小版块的)
			$cate_replyNum = select($link , DB_PREFIX . 'category' , 'replynum' , "cid = $cid");

			$cate_replynum['replynum'] = $cate_replyNum[0]['replynum'] + 1;

			$replynum = update($link , DB_PREFIX . 'category' , $cate_replynum , "cid = $cid");
			
			// 现在对大板块做回复量的加一操作
			// 先查询出大板块的cid
			$bigCateCid = select($link , DB_PREFIX . 'category' , 'parentid' , "cid = $cid");
			$bigCatecid = $bigCateCid[0]['parentid'];

			// 现在查询大板块的replynum
			$bigCateReplynum = select($link , DB_PREFIX . 'category' , 'replynum' , "cid = $bigCatecid");

			// 做加一操作
			$plusBigCateReplynum['replynum'] = $bigCateReplynum[0]['replynum'] + 1;
			// 左修改
			$plusBigCatereplynum = update($link , DB_PREFIX . 'category' , $plusBigCateReplynum , "cid = $bigCatecid"); 


			$notice = true;
			$msg = '<i class="zi_green">回复成功!</i>';

			$url = "returnCard.php?cid=$cid&tid=$tid";
			include 'notice.php';
			die;

		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">帖子回复失败,请联系管理员</i>';

			$url = 'returnCard.php?cid=$cid&tid=$tid';
			include 'notice.php';
			die;
		}

	}else
	{
		header('location:midLogin.php');
		die;
	}
}





// 购买帖子
if(isset($_GET['purchase']) and $_GET['purchase'] == 1)
{

	if(isset($_SESSION['uid']))
	{
		$uid = $_SESSION['uid'];

		// 查询当前用户的余额是否足以支付购买帖子的费用
		$afford = select($link , DB_PREFIX . 'user' , 'grade' , "uid = $uid");
		$isAfford = $afford[0]['grade'];

		// 查询当前帖子需要花费多少钱才可以购买
		$cost = select($link , DB_PREFIX . 'details' , 'price , authorid' , "tid = $tid");
		$howCost = $cost[0]['price'];


		// 对用户的余额和购买帖子需要花费的金钱作比较
		if($isAfford < $howCost)
		{
			$notice = false;
			$msg = '<i class="zi_red">抱歉,您的余额不足以支付当前帖子的费用</i>';
			include 'notice.php';
			die;
		}else
		{

			$money['uid'] = $uid;
			$money['tid'] = $tid;
			$money['rate'] = $howCost;
			$money['addtime'] = time();
			$money['ispay'] = 1;

			$purChase = insert($link , DB_PREFIX . 'order' , $money);

			// 用户购买帖子之后要减去花费的金额
			$subtrac['grade'] = $isAfford - $howCost;
			$subtracGrade = update($link , DB_PREFIX . 'user' , $subtrac , "uid = $uid");
			


			// 查发金币帖的用户,还要给这个用户加积分
			$postUid = $cost[0]['authorid'];
			$postGrade = select($link , DB_PREFIX . 'user' , 'grade' , "uid = $postUid");

			$plusGrade['grade'] = $postGrade[0]['grade'] + $howCost;
			$finalGrade = update($link , DB_PREFIX . 'user' , $plusGrade , "uid = $postUid");

			if($purChase && $subtracGrade && $finalGrade)
			{
				$notice = true;
				$msg = '<i class="zi_green">购买帖子成功</i>';
				include 'notice.php';
				die;				
			}else
			{
				$notice = false;
				$msg = '<i class="zi_red">抱歉,购买帖子失败,请联系管理员</i>';
				include 'notice.php';
				die;				
			}
		}

	}else
	{
		header('location:midLogin.php');
		die;
	}
	
}



display('returnCard.html' , compact('dir' , 'title' , 'most' , 'webBtm' , 'webUrl' , 'webIcp' , 'now' , 'smallCate' , 'bigCate' , 'url' , 'postInfo' , 'isPurchase' , 'prev_tid' , 'next_tid' , 'paging' , 
		"paging['page']" , "paging['offset']" , 'elevator' , 'link'));



