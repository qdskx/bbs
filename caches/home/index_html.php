<html>
	<head>
		<meta charset="utf-8" />
		<title><?=$title;?></title>
		<link rel="stylesheet" href="<?=$dir;?>/css/base.css" />
		<link rel="stylesheet" href="<?=$dir;?>/css/header.css" />
		<link rel="stylesheet" href="<?=$dir;?>/css/index.css" />
		<link rel="stylesheet" href="<?=$dir;?>/css/footer.css" />
	</head>

	<body>
		<div class="box clearFix">
			<?php include '/www/web/bbs/public_html/caches/home/headerIndex_html.php';?>



			<!-- 头部下边的一角 start -->
			<div class="talk clearFix">
				<div class="fl">
					<i class="home"></i>
					<i class="gt">></i>
					<a href="#" class="forum">论坛</a>
				</div>
				<div class="talk_r fr">
					<ul class="clearFix">
						<li class="flow"></li>
						<li class="post">帖子：</li>
						<li class="num"><?=$postNum;?></li>
						<li class="vip">会员：</li>
						<li class="num"><?=$memNum;?></li>
						<li class="vip">欢迎新会员：</li>
						<li class="num mem"><?=$newMem;?></li>
					</ul>
				</div>
			</div>
			<!-- 头部下边的一角 end -->



			<!-- 主体内容 start -->
			<!-- PHP技术交流 Start -->
			<?php if(!empty($bigCate)):?>
			<?php foreach($bigCate as $value):?>
			<div class="main">
				<div class='main_up'>
					<a href="./index.php?bigid=<?=$value['cid'];?>" class="mp_color"><?=$value['classname'];?></a>
				</div>
				<?php if(!empty($smallCate)):?>
				<?php foreach($smallCate as $val):?>
				<?php if($val['parentid'] == $value['cid']):?>
				<!-- 一组 start -->
				<div class="main_down">
					<div class="down_l fl">						
						<img src="<?=$dir;?>/img/forum.gif" alt="" class="down_bg fl" />
						<p class="down_cont fl">
							<a href="./home/list.php?cid=<?=$val['cid'];?>" ><?=$val['classname'];?></a><br />版主：
							<i class="down_color">
								<?php if(!empty($compere)):?>
									<?php foreach($compere as $v):?>
										<?php if($v['cid'] == $val['cid']):?>
											<?=$v['username'];?>
										<?php endif;?>
									<?php endforeach;?>
								<?php endif;?>
							</i>
						</p>
					</div>
					<div class="down_m fr">
						<p class="dm_l fl">
							<i class="l_hei"><?=$val['replynum'];?></i>
							<i class="l_grey">/ <?=$val['postnum'];?></i>
						</p>
						<?php if(empty($val['postnum'])):?>
							<p class="never fl">从未</p>
						<?php else: ?>
							<?php if(!empty($recentNew)):?>
								<?php foreach($recentNew as $vv):?>
									<?php if($vv['cid'] == $val['cid']):?>
										<p class="fl dm_r">
											<a href="./home/returnCard.php?cid=<?=$val['cid'];?>&tid=<?=$vv['tid'];?>"><?=$vv['title'];?></a><br />
											<cite><?php echo date('Y-m-d H:i:s ' , $vv['postime']);?> <?=$vv['username'];?></cite>
										</p>
									<?php endif;?>
								<?php endforeach;?>
							<?php endif;?>
						<?php endif;?>	
					</div>
				</div>
				<!-- 一组 end -->
				<?php endif;?>
				<?php endforeach;?>
				<?php endif;?>
			</div>
			<?php endforeach;?>
			<?php endif;?>
			<!-- PHP技术交流 end -->			
			<!-- 主体内容 end -->



			<!-- 友情链接 start -->
			<?php if(!empty($friendLink)):?>
			<div class="myLinks">			
				<?php foreach($friendLink as $value):?>
					<?php if($value['showorder'] == $value['lid']):?>
					<div class="link_up">
						<img src="<?=$value['logo'];?>" alt="" class="fl" />
						<p class="lup_cont fl">
							<a href="#" class="official"><?=$value['name'];?></a><br />
							<i><?=$value['description'];?></i>
						</p>
					</div>
					<?php else: ?>			
					<p class="else fl">				
						<a href="<?=$value['url'];?>" class='fl'><?=$value['name'];?></a>				
					</p>
					<?php endif;?>
				<?php endforeach;?>			
			</div>
			<?php endif;?>
			<!-- 友情链接 end -->


			<?php include '/www/web/bbs/public_html/caches/home/footer_html.php';?>
			



		</div>
	</body>
</html>