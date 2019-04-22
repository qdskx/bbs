<?php

session_start();

include 'verify.php';
include '../common/common.php';


$_SESSION['verify'] = verify();



