<?php

include '../common/common_index.php';

$title = WEB_NAME . '找回密码';

display('getpass.html' , compact('dir' , 'title' , 'most' , 'webBtm' , 'webUrl' , 'webIcp' , 'now'));