<?php

include '../common/common_admin.php';

$title = WEB_NAME . '-版块管理-隐藏板块';


if(empty($_SESSION['username']))
{
	$notice = false;
	$msg = '<i class="zi_red">抱歉,请您先去登录</i>';
	$url = 'adminLogin.php';
	include 'notice.php';
	die;

}else{

	// 遍历板块
	$bigCate = select($link , DB_PREFIX . 'category' , '*' , "ispass = 0 and isremove = 0 order by orderby desc");
	
	// $smallcate = select($link , DB_PREFIX . 'category' , '*' , "ispass = 0 and parentid <> 0 order by orderby desc");

	// 令板块显示
	if(!empty($_POST['show_cate']))
	{
		if(!empty($_POST['cid']))
		{
			$ShowCid = join(',' , $_POST['cid']);
			$ShowCate['ispass'] = 1;
			$Showcate = update($link , DB_PREFIX . 'category' , $ShowCate , "cid in ($ShowCid)");
		
			if($Showcate)
			{
				$notice = true;
				$msg = '<i class="zi_green">恢复板块显示成功</i>';
				include 'notice.php';
				die;
			}else
			{
				$notice = false;
				$msg = '<i class="zi_red">恢复板块显示失败</i>';
				include 'notice.php';
				die;
			}
		}
	}

	display('adminCatehid.html'  , compact('dir' , 'title' , 'bigCate' , 'smallcate'));
}