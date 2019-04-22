<!doctype html>
<html>
	<head>
		<meta charset='utf-8' />
		<title><?=$title;?></title>
		<link rel='stylesheet' type='text/css' href='<?=$dir;?>/css/adminBase.css' />
		<link rel='stylesheet' type='text/css' href='<?=$dir;?>/css/G-index.css' />
		<link rel='stylesheet' type='text/css' href='<?=$dir;?>/css/adminInfo.css' />
		<link rel="stylesheet" href="<?=$dir;?>/css/adminNotice.css" />
		<meta http-equiv="Refresh" content="1 ; <?=$url;?>" />	 
	</head>
	<body>
		<div class='box clearFix'>
			<div class='top fl clearFix'>
				<div class='top1'></div>
				<div class='top2'></div>
				<div class='top3'></div>
				<div class='top-le'><i>Discuz!</i><br/>Control Panel</div>
				<div class='top-gang'></div>
				<ul class='nav clearFix'>
					<li><a href='adminInfo.php'>站点信息</a></li>
					<li><a href='adminUser.php'>用户管理</a></li>
					<li><a href='adminCate.php'>版块管理</a></li>
					<li><a href='adminPost.php'>帖子管理</a></li>
				</ul>
				<ul class='exit'>
					<li><p>你好, 创始人 </p>
						<em>&nbsp;&nbsp;
						<?php if(isset($_SESSION['username'])):?>
							<?=$_SESSION['username'];?>
						<?php else: ?>
						admin
						<?php endif;?>
						&nbsp;&nbsp;</em>
					<a href="adminLoginout.php" target='_blank'>[退出]</a>
					<a href='../index.php'><img src="<?=$dir;?>/img/nav.jpg"></a>
					</li>
				</ul>
			</div>	
		<!--  左边 结束   -->


		<!--  右边 开始   -->
			<!--main start-->			
			<div class='key clearFix fl'>			
				<div class='key_cont yanzhengma clearFix'>
				<?php if(empty($notice)):?>
					<i class='key_cont_bg fl' ></i>
				<?php else: ?>
					<?php if($notice):?>
					<i class='loginchenggong_bg fl' ></i>
					<?php else: ?>
					<i class='key_cont_bg fl' ></i>
					<?php endif;?>
				<?php endif;?>
					<p class='key_cont_zi fl clearFix'>
						<i class='zi_red fl'><?=$msg;?></i><br />
						<a href='<?=$url;?>' class='zi_blue fl'>如果你的浏览器没有自动跳转，请点击此链接</a>
					</p>							
				</div>			
			</div>		
			<!--main end-->
		<!--  右边 结束   -->
		</div>
	
	
	</body>
</html>