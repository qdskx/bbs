<?php
/*
*文件上传函数
*@param $key string
*@param $path string
*@param $allowMime array
*@param $allowSize int
*@param $allowSub array
*@param $isRandName boolean
*@param return string
*/

function upload($key , $path , $allowMime , $allowSize , $allowSub , $isRandName = true)
{
	
	//判断错误信息
	
	$error = $_FILES[$key]['error'];
	
	if ($error) {
		switch ($error) {
			case 1:
				$msg = '其值为 1，上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
				break;
			case 2:
				$msg = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
				break;
			case 3:
				$msg = '文件只有部分被上传。';
				break;
			case 4:
				$msg = '没有文件被上传。 ';
				break;
			case 6:
				$msg = '找不到临时文件夹';
				break;
			case 7:
				$msg = '文件写入失败';
				break;
		}
		//echo $msg;
		return[0 , $msg];
	}
	//判断大小
	if ($_FILES[$key]['size'] > $allowSize) {
		return[0 , '超过了手动指定的大小'];
	}
	
	//判断mime类型
	if (!in_array($_FILES[$key]['type'] , $allowMime)) {
		return [0 , '不是准许的mime类型'];
	}
	
	//判断文件准许的后缀名
	
	$info = pathinfo($_FILES[$key]['name']);
	
	$sub = $info['extension'];
	if (!in_array($sub , $allowSub)) {
		return [0 , '不是准许的mime类型'];
	}
	
	//判断是否启用随机文件名
	if ($isRandName) {
		$newName = uniqid() . '.' . $sub;
	} else {
		$newName = $_FILES[$key]['name'];
	}
	//拼接路径
	$path = rtrim($path , '/') . '/' . date('Y/m/d') . '/';
	
	//创建目录
	
	if (!file_exists($path)) {
		mkdir($path , 0777 , true);
	}
	
	//判断是否是上传文件
	
	if (is_uploaded_file($_FILES[$key]['tmp_name'])) {
	
		//是上传文件的区间
		if (move_uploaded_file($_FILES[$key]['tmp_name'] , $path . $newName)) {
			
			//echo '上传成功';
			
			return [1 , $path . $newName , $_FILES[$key]['type']];
		} else {
			return[0 , '上传失败'];
		}
	
	} else {
		return [0 , '不是上传文件'];
	}
}















