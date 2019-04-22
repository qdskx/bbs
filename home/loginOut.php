<?php

include '../common/common_index.php';


$lastLogin['lastime'] = time();
$uid = $_SESSION['uid'];
$finalLogin = update($link , DB_PREFIX . 'user' , $lastLogin , "uid = $uid");


$_SESSION[] = [];

session_destroy();



$notice = true;
$url = '../index.php';
$msg = '<i class="zi_green">退出成功,您现在将以游客身份进入站点</i>';

include 'notice.php';