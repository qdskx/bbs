<!doctype html>
<html>
	<head>
		<meta charset='utf-8' />
		<title><?=$title;?></title>
		<link rel='stylesheet' type='text/css' href='<?=$dir;?>/css/adminBase.css' />
		<link rel='stylesheet' type='text/css' href='<?=$dir;?>/css/G-index.css' />
		<link rel='stylesheet' type='text/css' href='<?=$dir;?>/css/adminUser.css' />
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
					<li><a href='adminUser.php' class='onclick'>用户管理</a></li>
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
					<a href="adminLoginout.php">[退出]</a>
					<a href='../index.php'><img src="<?=$dir;?>/img/nav.jpg"></a>
					</li>
				</ul>
			</div>
			<div class='left clearFix'>
				<ul class='nav-le clearFix'>
					<li class='on1'>
						<a href="adminUser.php">
							<img src='<?=$dir;?>/img/dot.gif'>编辑用户
						</a>
					</li>
					<li>
						<a href="adminIp.php">
							<img src='<?=$dir;?>/img/dot.gif'>禁止IP
						</a>
					</li>
					<li class='bottom'>
						Powered by 
						<a href="#">phpxy</a> 
						V2© 2012, 
						<a href="#">phpxy</a> 
						Inc.
					</li>
				</ul>
			</div>
		
			<div class='right clearFix'>
				<div class='r-top'>用户管理</div>
				<div class='r1 clearFix'>
					<p class="fl">
						共有 
						<?php if(!empty($paging) && !empty($paging['data'])):?>
						<?=$paging['count'];?>
						<?php else: ?>
						0
						<?php endif;?>
						条用户记录
					</p>
					
				</div>
				<ul class='r2 clearFix'>
					<li style='margin-left:115px'>用户名</li>
					<li style='margin-left:90px'>积分</li>
					<li style='margin-left:80px'>注册时间</li>
					<li style='margin-left:148px'>用户类型</li>
				</ul>
				
				<form action="adminUser.php" method="post" enctype="multipart/form-data">			
					<?php if(!empty($paging) && !empty($paging['data'])):?>
					<?php foreach($paging['data'] as $value):?>
						<div class="r3">
							<input type='checkbox' name="uid[<?=$value['uid'];?>]" value="<?=$value['uid'];?>" class="check" />
							<p class='b1'><?=$value['username'];?></p>
							<p class='b2'><?=$value['grade'];?></p>
							<p class='b3'>	<?php echo date('Y-m-d H:i:s' , $value['regtime'] );?></p>
							<p class='b4'>	
								<?php if($value['undertype'] == 1):?>
								管理员
								<?php else: ?>
								普通用户
								<?php endif;?>
							</p>
							<a href="adminGrade.php?uid=<?=$value['uid'];?>#grade" class='b5'>积分</a>
							<a href="adminGrade.php?uid=<?=$value['uid'];?>" class='b6'>详情</a>
							<?php if($value['allowlogin'] == 0):?>
							<a href="adminUser.php?uid=<?=$value['uid'];?>&lock=1" class='b7' >
								锁定用户
							</a>
							<?php else: ?>
							<a href="adminUser.php?uid=<?=$value['uid'];?>&lock=0" class='b8'>
								解除锁定
							</a>
							<?php endif;?>

							<br />				
						</div>
					<?php endforeach;?>
					<?php endif;?>
			
						<input type='submit' name='sub_del' value='删除' class='submit' />
						<input type='submit' name='sub_add' value='添加' class='submit' />
					</form>
					<div class="r4">
						<!-- 分页 start -->
						<div class='page fr clearFix'>
							<form action="adminUser.php?page=<?=$paging['page'];?>" method='post' class='fr clearFix'>
								<input type="text" name='page_num' value='1' class="page_num fl" />

								<input type="submit" name='sub_page' value='GO' class='sub_page fl' />	

								
								<i class='page_mar fl'><?=$paging['page'];?></i>	

								<a href='adminUser.php?page=1' class='page_mar fl'>首页</i>	


								<a href="adminUser.php?page=<?=$paging['prev'];?>" class='page_mar fl'>上一页</a>		



								<a href="adminUser.php?page=<?=$paging['next'];?>" class='page_mar fl'>下一页</a>


								
								<a href="adminUser.php?page=<?=$paging['pageCount'];?>" class='page_mar fl'>尾页</a>	


								<i class='page_mar fl'>共有<?=$paging['count'];?>条记录 </i>					
								<i class='page_mar fl'> 
									每页显示<?=$paging['num'];?>条,
									本页<?=$paging['count'] == 0 ? 0 : $paging['offset'] + 1;;?>-<?=$paging['offset']+$paging['num'] > $paging['count'] ? $paging['count'] : $paging['offset']+$paging['num'];?>条 
								</i>	

								<i class='page_mar fl'> 1/<?=$paging['pageCount'];?>页 </i>
							</form>				
					

						</div>
						<!-- 分页 end -->
						
					</div>

					<?php if(!empty($_POST['sub_add'])):?>
					<ul class='r2 clearFix' style='margin-top:100px;'>
						<li style='margin-left:70px'>用户名</li>
						<li style='margin-left:90px'>密码</li>
						<li style='margin-left:140px'>用户类型</li>
						<li style='margin-left:148px'>邮箱</li>
					</ul>
					<form action="adminUser.php" method='post'>
						<input type="text" name='add_uname' class='c1' value="" />
						<input type="password" name='add_pass' class='c6' value="" />
						<input type="text" name='add_undertype' class='c4' value='普通用户' />
						<input type="text" name='add_email' class='c5' value='' />
						<input type='submit' name='sub_addd' value='添加' class='submit' />
					</form>
					<?php endif;?>

				
			
			</div>
		</div>
	
	
	</body>
</html>