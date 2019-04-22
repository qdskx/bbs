<html>
	<head>
		<meta charset="utf-8" />
		<title><?=$title;?></title>
		<link rel="stylesheet" href="../public/css/base.css" />
		<link rel="stylesheet" href="../public/css/header.css" />
		<link rel="stylesheet" href="../public/css/list.css" />
		<link rel="stylesheet" href="../public/css/footer.css" />
	</head>

	<body>
		<div class="box clearFix">
			<!-- 头部 start -->
			<?php include '/www/web/bbs/public_html/caches/home/header_html.php';?>
			<!-- 头部 end -->



			<!-- 头部下边的一角 start -->
			<div class="list_talk clearFix">
				<i class="home"></i>
				<i class="gt">></i>
				<a href="#" class="forum">论坛</a>
				<i class="gt">></i>
				<a href="../index.php?bigid=<?=$bigCateCid;?>" class="forum"><?=$bigCateClass;?></a>
				<i class="gt">></i>
				<a href="./list.php?cid=<?=$smallCateCid;?>" class="forum"><?=$smallCateClassname;?></a>
			</div>
			<!-- 头部下边的一角 end -->






			<!-- list Start -->
			<div class='list clearFix'>
				<!-- list 左半部分 start -->
				<div class="list_left fl">
					<p class='nav'>
						板块导航
					</p>
					<ul>
						<?php if(!empty($bigCate)):?>
							<?php foreach($bigCate as $value):?>
							<li class='nav_first'><a href="#"><?=$value['classname'];?></a>
							</li>						
								<?php if(!empty($smallCate)):?>
									<?php foreach($smallCate as $val):?>
										<?php if($val['parentid'] == $value['cid']):?>
											<?php if($val['cid'] == $smallCateCid):?>
											<li class='nav_second'><a href="list.php?cid=<?=$smallCateCid;?>"><?=$val['classname'];?></a>
											</li>
											<?php else: ?>
											<li><a href="list.php?cid=<?=$val['cid'];?>"><?=$val['classname'];?></a>
											</li>
											<?php endif;?>
										<?php endif;?>
									<?php endforeach;?>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>					
					</ul>
					<p class='nav_final'>
					</p>
				</div>
				<!-- list 左半部分 end -->
				<!-- list 右半部分 start -->
				<div class="list_right fl">
					<div class='right_top'>
						<p class='upper clearFix'>
							<a href="#" class='fl'>
								<?=$smallCateClassname;?>
							</a>
							<i class='fl'>今日：</i>
							<i class='fl num'><?php if(!empty($todayPost)):?><?=$todayPost;?><?php else: ?>0<?php endif;?></i>
							<i class='fl upper_mar'>|</i>
							<i class='fl'>主题：</i>
							<i class='fl num'><?=$titleNum;?></i>
						</p>
						<p class='down'>
							版主: <i class='test'><?=$compere[0]['username'];?></i>
						</p>
					</div>
					<div class='right_mid clearFix'>
						<a href="posting.php?cid=<?=$smallCateCid;?>" class='fl'>
							<img src="../public/img/post.png" alt="">
						</a>
						<?php if(empty($_SERVER['HTTP_REFERER'])):?>
						<a href="../index.php?bigid=<?=$bigCate[0]['cid'];?>" class='mid_right fr clearFix'>
						<?php else: ?>
						<a href="<?=$url;?>" class='mid_right fr clearFix'>
						<?php endif;?>
							<i class='arw_l fl'></i>
							返回
						</a>
					</div>
					<div class='right_cont'>
						<div class='cont_top clearFix'>
							<p class='fl'>
								<i>筛选</i>
								<a href="list.php?cid=<?=$smallCateCid;?>" class='all'>全部</a>
								<i>|</i>
								<a href="list.php?cid=<?=$smallCateCid;?>&import=1" class='essence'>精华</a>
							</p>
							<p class='fr cont_top_r'>
								<i class='fl author'>作者</i>
								<i class='fl reply'>回复/查看</i>
								<i class='fl'>最后发表</i>
							</p>
						</div>
						<?php if(!empty($paging) && !empty($paging['data'])):?>
						<?php foreach($paging['data'] as $value):?>
						<!-- 一组 start -->
						<div class='cont_cont'>
							<div class='cont_tent clearFix'>
								<p class='fl tent_left clearFix'>
									<?php if($value['postime'] <= $end && $value['postime'] >= $start):?>
									<i class='fl newFolder'></i>
									<?php else: ?>
									<i class='fl folder'></i>
									<?php endif;?>
									<?php if(!empty($value['ishighlight'])):?>
									<a href="returnCard.php?cid=<?=$smallCateCid;?>&tid=<?=$value['tid'];?>" class='fl highlight'>
										<?=$value['title'];?> 
									</a>
									<?php else: ?>
									<a href="returnCard.php?cid=<?=$smallCateCid;?>&tid=<?=$value['tid'];?>" class='fl'>
										<?=$value['title'];?>  
									</a>
									<?php endif;?>
									<?php if($value['price'] <> 0):?>
									<i class='fl'>&nbsp;- [售价 <?=$value['price'];?> 金钱]</i>
									<?php endif;?>
									<?php if($value['essence'] == 1):?>
									<i class='fl digest'></i>
									<?php endif;?>
								</p>
								<p class='fr tent_right clearFix'>	
									<i class='fl author'><?=$value['username'];?></i>
									<span class='fl view'>
										<i class='zero'><?=$value['replycount'];?></i><br />
										<i class='zero2'><?=$value['views'];?></i>
									</span>
									<span class='fl last_up'>
										<?php if($value['replycount'] == 0):?>
										<i><?=$value['username'];?></i><br />
										<i><?php echo date('Y-m-d' , $value['postime']);?></i><br />
										<i><?php echo date('H:i:s' , $value['postime']);?></i>
										<?php else: ?>
											<?php if(!empty($finalPost)):?>
												<?php foreach($finalPost as $val):?>
													<?php if($val['replyid'] == $value['tid'] && $val['cid'] == $value['cid']):?>
													<i><?=$val['username'];?></i><br />
														<i><?php echo date('Y-m-d' , $val['postime']);?></i><br />
														<i><?php echo date('H:i:s' , $val['postime']);?></i>
													<?php endif;?>
												<?php endforeach;?>
											<?php endif;?>
										<?php endif;?>
									</span>
								</p>
							</div>
						</div>
						<?php endforeach;?>
						<?php endif;?>
						<!-- 一组 end -->
					</div>
					<div class='right_mid clearFix'>
						<a href="posting.php?cid=<?=$smallCateCid;?>" class='fl'>
							<img src="../public/img/post.png" alt="">
						</a>
						<?php if(empty($_SERVER['HTTP_REFERER'])):?>
						<a href="../index.php?bigid=<?=$bigCate[0]['cid'];?>" class='mid_right fr clearFix'>
						<?php else: ?>
						<a href="<?=$url;?>" class='mid_right fr clearFix'>
						<?php endif;?>
							<i class='arw_l fl'></i>
							返回
						</a>
					</div>
					<!-- 分页 start -->
					<div class='page clearFix'>
						<form action="list.php?cid=<?=$smallCateCid;?>&page=<?=$paging['page'];?>" method='post' class='fr clearFix'>
							<input type="text" name='page_num' value='1' class="page_num fl" />

							<input type="submit" name='sub_page' value='GO' class='sub_page fl' />	

							
							<i class='page_mar fl'><?=$paging['page'];?></i>	

							<a href="list.php?cid=<?=$smallCateCid;?>&page=1" class='page_mar fl'>首页</i>	


							<a href="list.php?cid=<?=$smallCateCid;?>&page=<?=$paging['prev'];?>" class='page_mar fl'>上一页</a>		



							<a href="list.php?cid=<?=$smallCateCid;?>&page=<?=$paging['next'];?>" class='page_mar fl'>下一页</a>


							
							<a href="list.php?cid=<?=$smallCateCid;?>&page=<?=$paging['pageCount'];?>" class='page_mar fl'>尾页</a>	


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
				<!-- list 右半部分 end -->			
			</div>
			<!-- list end -->


			<!-- footer start -->
			<?php include '/www/web/bbs/public_html/caches/home/footer_html.php';?>
			<!-- footer end -->
		</div>
	</body>
</html>