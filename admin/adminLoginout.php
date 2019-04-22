<?php

include '../common/common_admin.php';

$_SESSION[] = [];
session_destroy();


$notice = true;

$msg = '<i class="zi_green">您已退出管理后台</i>';
$url = '../index.php';
include 'notice.php';
