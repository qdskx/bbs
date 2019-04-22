			<!-- 头部 start -->
			<header>
				<div class='top'>
					<div class='upper'>
						<p class='coll'>
							<a href="#">设为首页</a>
							<a href="#">收藏本站</a>
						</p>
						<div class='h_mid clearFix'>
							<h1 class='fl'>
								<img src="<?=$dir;?>/img/logo.png" title="首页-10分钟学院">
							</h1>
							<?php if(isset($_SESSION['username'])):?>
							<div class='login_h fr clearFix'>
								<p class='manage fl clearFix'>
									<i class='online fl'></i>
									<a href="#" class='mar_left name_bold fl'><?=$_SESSION['username'];?></a>
									<i class='fl ver_bar'>|</i>
									<a href="./home/personalData.php" class='mar_left fl'>设置</a>
									<?php if($_SESSION['undertype'] == 1):?>
									<i class='fl ver_bar'>|</i>
									<a href="./admin/adminLogin.php" class='mar_left fl'>管理中心</a>
									<?php endif;?>
									<i class='fl ver_bar'>|</i>
									<a href="./home/loginOut.php" class='mar_left fl'>
										退出
									</a>
									<br />
									<i class='mar_left fr mar_top'>用户权限:
									<?php if($_SESSION['undertype'] == 1):?>
									管理员
									<?php else: ?>
									普通用户
									<?php endif;?>
									</i>					
									<i class='fr ver_bar mar_top'>|</i>
									<a href="#" class='mar_left mar_top fr'>积分:<?=$_SESSION['grade'];?></a>
								</p>
								<p class='avatar fl'>
									<img src="<?php echo substr($_SESSION['pic'] , 1);?>" alt="">
								</p><br />
							</div>
							<?php else: ?>
							<div class='login fr clearFix'>
								<div class="big_form fl">
									<form action="./home/login.php" method="post" enctype="multipart/form-data">
										<i class='u_cs'>用户名</i><input type="text" name='username' class='uname'/>
										<input type="checkbox" name='cbox' class="cbox" />自动登录<br />
										<i class='u_cs'>密码</i><input type="password" name='pass' class='uname' />
										<input type="submit" name="subLogin" value="登录" class='sub' />
									</form>
								</div>
								<div class="g_pass fl">
									<a href='./home/getpass.php' class="gp_up">找回密码</a>
									<a href='./home/register.php' class="gp_down">
									立即注册</a>
								</div>
							</div>
							<?php endif;?>							
						</div>
						<div class="h_bot">
							<div class='hb_up clearFix'>
								<p class="up_one fl">
									<a href="index.php" class="one_cs" title="10分钟学院">首页</a>
								</p>
								<?php if(!empty($most)):?>
								<?php foreach($most as $val):?>
								<p class="up_two fl">
									<a href="index.php?bigid=<?=$val['cid'];?>" class="two_cs" title="Space"><?=$val['classname'];?></a>
								</p>
								<?php endforeach;?>
								<?php endif;?>
							</div>
							<div class='hb_down clearFix'>
								<i class="icon_search fl"></i>
								<div class="fl">
									<form action="./home/search.php" method="post" enctype="multipart/form-data" class="clearFix">
										<input type="text" name='search' class="search fl" placeholder="请输入搜索内容" />
										<input type="submit" class="go_search fl" value="" />
									</form>
								</div>
								<div class="hot fl">
									<i class="hot_1">热搜:</i>
									<a href='#' class="hot_2">活动</a>
									<a href='#' class="hot_2">交友</a>
									<a href='#' class="hot_2">教程</a>
								</div>
							</div>
						</div>								
					</div>
				</div>
			</header>
			<!-- 头部 end -->