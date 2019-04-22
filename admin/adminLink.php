<?php

include '../common/common_admin.php';

$title = WEB_NAME . '-站点信息-友情链接';

if(empty($_SESSION['username']))
{
	$notice = false;
	$msg = '<i class="zi_red">抱歉,请您先去登录</i>';
	$url = 'adminLogin.php';
	include 'notice.php';
	die;

}else{

	$link_info = select($link , DB_PREFIX . 'link' , '*' , 'ishow = 0' , 'order by showorder desc '); 

	if(!empty($_POST['lid']))
	{
		$Lid = $_POST['lid'];
		$lid = join(',' , $Lid);

		// 批量删除友情链接
		if(!empty($_POST['sub_del']))
		{
			$Del['ishow'] = 1;
	
			$del = update($link , DB_PREFIX . 'link' , $Del , "lid in ($lid)");
		
			if($del && mysqli_affected_rows($link))
			{
				$notice = true;
				$msg = '<i class="zi_green">删除友情链接成功</i>';
				include 'notice.php';
				die;
			}else
			{
				$notice = false;
				$msg = '<i class="zi_red">删除友情链接失败</i>';
				include 'notice.php';
				die;
			}
		}



		// 批量修改友情链接
		if(!empty($_POST['sub_update']))
		{
			foreach($_POST['lid'] as $key => $value)
			{

				// var_dump($_POST);
				// var_dump($_POST['lid']);

				$update_link['showorder'] = $_POST['showOrder'][$key];
				$update_link['name'] = $_POST['siteName'][$key];
				$update_link['url'] = $_POST['siteUrl'][$key];
				$update_link['description'] = $_POST['siteIntro'][$key];
				$update_link['logo'] = $_POST['siteLogo'][$key];
				$update_link['addtime'] = time();

				// die;
				$updateLink = update($link , DB_PREFIX . 'link' , $update_link , "lid in ($key)");

			}
			
			if($updateLink)
			{	
				$notice = true;
				$msg = '<i class="zi_green">修改友情链接成功</i>';
				include 'notice.php';
				die;
			}else
			{
				$notice = false;
				$msg = '<i class="zi_red">修改友情链接失败</i>';
				include 'notice.php';
				die;
			}
		}

	}



	// 添加友情链接
	if(!empty($_POST['sub_add']))
	{
		$addLink['showorder'] = $_POST['Lorder'];
		$addLink['name'] = $_POST['Lname'];
		$addLink['url'] = $_POST['Lurl'];
		$addLink['description'] = $_POST['Lintro'];
		$addLink['logo'] = $_POST['Llogo'];
		$addLink['addtime'] = time();

		$addlink = insert($link , DB_PREFIX . 'link' , $addLink);

		if($addlink && mysqli_affected_rows($link))
		{	
			$notice = true;
			$msg = '<i class="zi_green">添加友情链接成功</i>';
			include 'notice.php';
			die;
		}else
		{
			$notice = false;
			$msg = '<i class="zi_red">添加友情链接失败</i>';
			include 'notice.php';
			die;
		}

	}




	display('adminLink.html' , compact('dir' , 'title' , 'link_info'));
}