<?php


function suoFang($source , $width , $height , $path='../upload' , $type='png' , $isRandName = false)
{
	//打开图片
	$res = open($source);
	//获取图片的信息
	$info = getInfo($source);
	
	
	//用等比缩放的方法算出来新的宽和高度
	$newSize = getNewSize($width , $height , $info);
	
	//处理变黑的问题
	$newRes = kidOfImage($res , $newSize , $info);
	
	//处理路径的问题
	if ($isRandName) {
		$path = rtrim($path , '/') . '/' . date('Y/m/d/') . uniqid();
	} else {
		$path = rtrim($path , '/') . '/' . date('Y/m/d/') . $info['name'];
	}
	
	$func = 'image'.$type;
	//输出图片
	// imagejpeg($newRes , $path);
	
	// $func($newRes , $path);
	
	if(function_exists($func))
	{
		$func($newRes , $path);
	}else
	{
		die('不允许的文件格式');
	}
	
	imagedestroy($newRes);
	
	return $path;
}

//获取信息的方法
function getInfo($path)
{
	$info = getimagesize($path);
	$data['width'] = $info[0];
	$data['height'] = $info[1];

	$name = pathinfo($path);
	$data['name'] = $name['basename'];
	
	return $data;
}

//封装打开函数
function open($path)
{
	//var_dump($path);
	
	//判断这个文件是否存在
	if (!file_exists($path)) {
		return false;
	} 
	$info = getimagesize($path);
	
	switch ($info['mime']) {
		case 'image/jpeg':
		case 'image/jpg':
		case 'image/jpe':
		case 'image/pjpeg':
			$res = imagecreatefromjpeg($path);
			break;
		case 'image/gif';
			$res = imagecreatefromgif($path);
			break;
		case 'image/png';
			$res = imagecreatefrompng($path);
			break;
		case 'image/bmp':
		case 'image/wbmp':
			$res = imagecreatefromwbmp($path);
			break;
	}
	return $res;
}









//等比缩放
function getNewSize($width, $height,$imgInfo){	
	//将原图片的宽度给数组中的$size["width"]
	$size["width"]=$imgInfo["width"]; 
	//将原图片的高度给数组中的$size["height"]		
	$size["height"]=$imgInfo["height"];        
	
	if($width < $imgInfo["width"]){
		//缩放的宽度如果比原图小才重新设置宽度
		$size["width"]=$width;             
	}

	if($height < $imgInfo["height"]){
		//缩放的高度如果比原图小才重新设置高度
		$size["height"]=$height;            
	}

	if($imgInfo["width"]*$size["width"] > $imgInfo["height"] * $size["height"]){
		$size["height"]=round($imgInfo["height"]*$size["width"]/$imgInfo["width"]);
	}else{
		$size["width"]=round($imgInfo["width"]*$size["height"]/$imgInfo["height"]);
	}

	return $size;
}

//这两个方法不用会，直接复制就行
//处理gif变黑
function kidOfImage($srcImg,$size, $imgInfo){
	//传入新的尺寸，创建一个指定尺寸的图片
	$newImg = imagecreatetruecolor($size["width"], $size["height"]);		
	//定义透明色
	$otsc = imagecolortransparent($srcImg);
	if( $otsc >= 0 && $otsc < imagecolorstotal($srcImg)) {
		 //取得透明色
		 $transparentcolor = imagecolorsforindex( $srcImg, $otsc );
			 //创建透明色
			 $newtransparentcolor = imagecolorallocate(
			 $newImg,
			 $transparentcolor['red'],
				 $transparentcolor['green'],
			 $transparentcolor['blue']
		 );
		//背景填充透明
		 imagefill( $newImg, 0, 0, $newtransparentcolor );
		 
		 imagecolortransparent( $newImg, $newtransparentcolor );
	}

	imagecopyresized( $newImg, $srcImg, 0, 0, 0, 0, $size["width"], $size["height"], $imgInfo["width"], $imgInfo["height"] );
	imagedestroy($srcImg);
	//最终新值就解决了透明色的题 
	return $newImg;
}		