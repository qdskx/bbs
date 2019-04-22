<!doctype html>
<html>
	<head>
		<meta charset='utf-8' />
		<title><?=$title;?></title>
		<link rel='stylesheet' type='text/css' href='<?=$dir;?>/css/adminBase.css' />
		<link rel='stylesheet' type='text/css' href='<?=$dir;?>/css/G-index.css' />
		<link rel='stylesheet' type='text/css' href='<?=$dir;?>/css/adminCate.css' />
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
					<li><a href='adminCate.php' class='onclick'>版块管理</a></li>
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
					<a href="adminloginout.php">[退出]</a>
					<a href='../index.php'><img src="<?=$dir;?>/img/nav.jpg"></a>
					</li>
				</ul>
			</div>

			<div class='left clearFix'>
				<ul class='nav-le clearFix'>
					<li class='on1'><a href="adminCate.php"><img src='<?=$dir;?>/img/dot.gif'>管理板块</a></li>
					<li><a href="adminCatehid.php"><img src='<?=$dir;?>/img/dot.gif'>雪藏板块</a></li>
					<li><a href="adminCateadd.php"><img src='<?=$dir;?>/img/dot.gif'>添加板块</a></li>
					<li class='bottom'>Powered by <a href="#">phpxy</a> V2© 2012, <a href="#">phpxy</a> Inc.</li>
				</ul>			
			</div>


			<div class='right clearFix'>
				<div class='r-top'>版块管理</div>
				<ul class='r1 clearFix'>
						<li>显示顺序</li>
						<li style='margin-left:22px'>版块名称</li>
						<li style='margin-left:758px'>版主</li>
				</ul>		
				<form action="adminCate.php" method="post" enctype="multipart/form-data" class="clearFix">
			<?php if(!empty($bigCate)):?>
				<?php foreach($bigCate as $value):?>	
					<div class='r3'>
						<input type='checkbox' name="cid[<?=$value['cid'];?>]" value="<?=$value['cid'];?>" class='ban1' />
						<input type='text' name="order[<?=$value['cid'];?>]" value="<?=$value['orderby'];?>" class='ban1' />
						<input type='text' name="name[<?=$value['cid'];?>]" value="<?=$value['classname'];?>"  class='ban2 ban4' />
						<input type="hidden" name="compere[<?=$value['cid'];?>]" value="" class='ban3'>
					</div>	
					<?php if(!empty($smallcate)):?>
						<?php foreach($smallcate as $val):?>
							<?php if($val['parentid'] == $value['cid']):?>
							<div class='r3 r4'>
								<input type='checkbox' name="cid[<?=$val['cid'];?>]" value="<?=$val['cid'];?>" class='ban1'>
								<input type='text' name="order[<?=$val['cid'];?>]" value="<?=$val['orderby'];?>" class='ban1'>
								<img src='<?=$dir;?>/img/bg2.jpg' class='fl'>
								<input type='text' name="name[<?=$val['cid'];?>]"  value="<?=$val['classname'];?>"  class='ban2 mr' />
								<input type='text' name="compere[<?=$val['cid'];?>]"  value="<?=$val['compere'];?>" class='ban3' />			
							</div>
							<?php endif;?>
						<?php endforeach;?>
					<?php endif;?>
				<?php endforeach;?>
			<?php endif;?>






					<input type='submit' name='sub_update' value='修改' class='submit' class='fl' />
					<input type='submit' name='sub_del' value='删除' class='submit' class='fl' />
					<input type='submit' name='sub_hid' value='隐藏板块' class='submit' class='fl' style='width:70px;' />			
						
				</form>



				
			</div>
		</div>
	
	
	</body>
</html>