<?php

include '../common/common_admin.php';

$title = WEB_NAME . '-版块管理-管理板块';


if(empty($_SESSION['username']))
{
	$notice = false;
	$msg = '<i class="zi_red">抱歉,请您先去登录</i>';
	$url = 'adminLogin.php';
	include 'notice.php';
	die;

}else{

	// 遍历板块
	$bigCate = select($link , DB_PREFIX . 'category' , '*' , "ispass = 1 and isremove = 0 and parentid = 0 order by orderby desc");

	// 小版块
	$smallcate = select($link , DB_PREFIX . 'category' , '*' , "ispass = 1 and isremove = 0 and parentid <> 0" , 'order by orderby desc');

	// 删除板块
	if(!empty($_POST['sub_del']))
	{
		if(empty($_POST['cid']))
		{
			$notice = false;
			$msg = '<i class="zi_red">很遗憾,您并没有选中要删除的板块</i>';
			include 'notice.php';
			die;
		}else
		{			
		
			$cid = join(',' , $_POST['cid']);

			// 这里面如果是有ispass=0的也属于存在小板块,也是不可以删除的
			$exists_parentid = select($link , DB_PREFIX . 'category' , '*' , "parentid in ($cid)");

			if(!empty($exists_parentid))
			{
				$notice = false;
				$msg = '<i class="zi_red">所选择的板块下边含有板块,不可删除</i>';
				include 'notice.php';
				die;				
			}else
			{

				// 这已经确定了是小版块,s故而要判断小版块里面有没有帖子
				$exists_post = select($link , DB_PREFIX . 'category' , 'cid , postnum' , "cid in ($cid)");

				// var_dump($exists_post);die;
				// D:\wamp\www\program\407\admin\adminCate.php:52:
				// array (size=4)
				//   0 => 
				//     array (size=2)
				//       'postnum' => string '0' (length=1)
				//       'cid' => string '44' (length=2)
				//   1 => 
				//     array (size=2)
				//       'postnum' => string '0' (length=1)
				//       'cid' => string '46' (length=2)
				//   2 => 
				//     array (size=2)
				//       'postnum' => string '0' (length=1)
				//       'cid' => string '52' (length=2)
				//   3 => 
				//     array (size=2)
				//       'postnum' => string '0' (length=1)
				//       'cid' => string '54' (length=2)


				$new_del_cid = '';
				$new_rev_cid = '';
				// 这的思路是通过遍历exists_post,将存在帖子的板块cid存储起来,同时将不存在帖子的cid存储起来
				foreach($exists_post as $val)
				{
					
					if($val['postnum'] == 0)
					{
						$new_del_cid .= $val['cid'] . ',';
						
					}else
					{
						$new_rev_cid .= $val['cid'] . ',';
					}


				}


				if($new_rev_cid)
				{
					$notice = false;
					$msg = '<i class="zi_red">所选择的板块下边含有帖子,不可删除</i>';
					include 'notice.php';
					die;						
				}

				// 这是可以删除的cid
				if($new_del_cid)
				{
					$new_del_cid = trim($new_del_cid , ',');


					$del = del($link , DB_PREFIX . 'category' , "cid in ($new_del_cid)");
	
					if($del)
					{
						$notice = true;
						$msg = '<i class="zi_green">删除板块成功</i>';
						include 'notice.php';
						die;
					}else
					{
						$notice = false;
						$msg = '<i class="zi_red">删除板块失败</i>';
						include 'notice.php';
						die;						
					}					
				}
			}
		}
	}






	// 修改板块 2017-11-22 16:19
	if(!empty($_POST['sub_update']))
	{
		if(empty($_POST['cid']))
		{
			$notice = false;
			$msg = '<i class="zi_red">很遗憾,您并没有选中要修改的板块</i>';
			include 'notice.php';
			die;
		}else
		{	

			// 修改语句一定要在foreach里面,因为要将每一个被选中的cid都修改一遍,即都foreach一遍
			foreach($_POST['cid'] as $key => $val)
			{


				$data['orderby'] = $_POST['order'][$val];
				$data['classname'] = $_POST['name'][$val];
				$data['compere'] = $_POST['compere'][$val];

				$update_cate = update($link , DB_PREFIX . 'category' , $data , "cid = $val");
				
			}

			// 这个不可以放在foreach里面,因为如果这样的话m一旦有修改成功的m就会跳出foreach,最后的结果就是只能修改一个,相反的,如果你放在了外面,等到所有的修改语句都执行完了以后再做判断,就不会有只修改了一条记录的时候了
			if($update_cate)
			{	
				$notice = true;
				$msg = '<i class="zi_green">修改成功</i>';
				include 'notice.php';
				die;
			
			}else
			{
				$notice = false;
				$msg = '<i class="zi_red">修改失败</i>';
				include 'notice.php';
				die;	
			}
		

		}

	}


	// 隐藏板块
	if(!empty($_POST['sub_hid']))
	{
		// 用户没有选中要隐藏的板块的cid时
		if(empty($_POST['cid']))
		{
			$notice = false;
			$msg = '<i class="zi_red">很遗憾,您并没有选中要隐藏的板块</i>';
			include 'notice.php';
			die;
		}else
		{
			
			$hid_cid = join(',' , $_POST['cid']);

			$existsParentid = select($link , DB_PREFIX . 'category' , '*' , "parentid in ($hid_cid)");


			if(!empty($existsParentid))
			{
				$notice = false;
				$msg = '<i class="zi_red">所选择的板块下边含有板块,不能隐藏</i>';
				include 'notice.php';
				die;	
			}else
			{
				// 确定是小板块,那么此时就要看小版块下面有没有帖子
				

				$existsPost = select($link , DB_PREFIX . 'category' , '*' , "cid in ($hid_cid)");

				$hidableCid = '';
				$unhidableCid = '';

				foreach($existsPost as $val)
				{
						
					if($val['postnum'] == 0)
					{
						$hidableCid .= $val['cid'] . ',';
					}else
					{
						$unhidableCid .= $val['cid'] . ',';
					}

				}

				if(!empty($unhidableCid))
				{
					$notice = false;
					$msg = "<i class='zi_red'>您所选择的板块下面包含帖子,不能隐藏</i>";
					include 'notice.php';
					die;
				}


				if(!empty($hidableCid))
				{
					$hidableCid = trim($hidableCid , ',');
					$hidableCid = explode(',', $hidableCid);

					var_dump($hidableCid);

					foreach($hidableCid as $val)
					{
						$hidCate['ispass'] = 0;
						$hidcate = update($link , DB_PREFIX . 'category' , $hidCate , "cid = $val");
					}
					
				}

				if($hidcate)
				{
					$notice = true;
					$msg = '<i class="zi_green">隐藏板块成功</i>';
					include 'notice.php';
					die;
				}else
				{
					$notice = false;
					$msg = '<i class="zi_red">隐藏板块失败</i>';
					include 'notice.php';
					die;			
				}
				

				





			}


			
		}
	}




	display('adminCate.html' , compact('dir' , 'title' , 'bigCate' , 'smallcate'));

}