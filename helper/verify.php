<?php
/*
*验证码函数
*@param $width int
*@param $height int
*@param $num int
*@param $type int
*@param $imageType string
*@param return string
*/

function verify($width = 100 , $height = 40 , $num = 4 , $type = 3 , $imageType = 'png')
{
	
	//准备画布
	
	$image = imagecreatetruecolor($width , $height);
	
	//准备颜色 深颜色 浅颜色
	
	//准备字符串
	
	$string = '';
	
	switch ($type) {
		
		//代表纯数字
		case 1:
			$str = '0123456789';
			
			$string = substr(str_shuffle($str), 0 , $num);
			
			break;
		//代表纯字母
		case 2:
			$arr = range('a' , 'z');
			shuffle($arr);

			$tmp = array_slice($arr , 0 , $num);

			$string = join('' , $tmp);
			break;
		//字母数字混合
		case 3:
			/*
			$str = 'abcdefghjkmnpqrestuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
			$string = substr(str_shuffle($str), 0 , $num);
			*/
			
			for ($i=0;$i<$num;$i++) {
				$rand = mt_rand(0 , 2);
				
				switch ($rand) {
					case 0:
						$char = mt_rand(48 , 57);
						break;
					case 1:
						$char = mt_rand(97 , 122);
					
						break;
					case 2:
						$char = mt_rand(65 , 90);
					
						break;
				}
				
				$string .= sprintf('%c' , $char);
			}
			
			
			
			break;
	}
	
	
	//填充背景颜色
	imagefilledrectangle($image , 0 , 0 , $width , $height , lightColor($image));
	
	
	
	//把你准好的字符串画上面
	
	//imagechar
	
	for ($i=0;$i<$num;$i++) {
		
		
		//求出来x坐标
		// $x = ceil($width / $num) * $i + 10;
		$x = ceil($width / $num) * $i ;
		
		
		//求出来y坐标
		
		$y = mt_rand(15 , $height - 10);
		
		//开始写字符串
		
		// imagechar($image , 5 , $x , $y , $string[$i] , darkColor($image));

		imagettftext($image , 23 ,0 , $x +5  , $y + 10  , darkColor($image) , TTF_PATH . 'simhei.ttf' , $string[$i] );
		
	}
	
	
	//画干扰线
	//imagearc
	
	for ($i=0;$i<$num;$i++) {
		imagearc($image , mt_rand(10 , $width) , mt_rand(10 , $height) , mt_rand(10 , $width) , mt_rand(10 , $height) , mt_rand(0 , 20) , mt_rand(0 , 270) , darkColor($image));
	}
	
	//画干扰点
	
	for ($i=0;$i<$num*$height;$i++) {
		imagesetpixel($image , mt_rand(0 , $width) , mt_rand(0 , $height) , darkColor($image));
	}
	
	
	
	//告知浏览器类型  //$imageType  //gif jpeg png wbmp
	
	header("Content-type:image/$imageType");  //你们说的这是对的
	
	//输出到浏览器
	
	$func = 'image' . $imageType;
	
	if (function_exists($func)) {
		$func($image);
	} else {
		exit('不支持的图片格式');
	}
	
	//销毁资源
	
	imagedestroy($image);
	
	return $string;
	
}



//深颜色

function darkColor($image)
{
	$color = imagecolorallocate($image , mt_rand(0 , 120) , mt_rand(0 , 120) , mt_rand(0 , 120));
	
	return $color;
}

//浅颜色

function lightColor($image)
{
	
	$color = imagecolorallocate($image , mt_rand(130 , 255) , mt_rand(130 , 255) , mt_rand(130 , 255));
	
	return $color;
}




