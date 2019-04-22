<?php
/*
*��֤�뺯��
*@param $width int
*@param $height int
*@param $num int
*@param $type int
*@param $imageType string
*@param return string
*/

function verify($width = 100 , $height = 40 , $num = 4 , $type = 3 , $imageType = 'png')
{
	
	//׼������
	
	$image = imagecreatetruecolor($width , $height);
	
	//׼����ɫ ����ɫ ǳ��ɫ
	
	//׼���ַ���
	
	$string = '';
	
	switch ($type) {
		
		//��������
		case 1:
			$str = '0123456789';
			
			$string = substr(str_shuffle($str), 0 , $num);
			
			break;
		//������ĸ
		case 2:
			$arr = range('a' , 'z');
			shuffle($arr);

			$tmp = array_slice($arr , 0 , $num);

			$string = join('' , $tmp);
			break;
		//��ĸ���ֻ��
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
	
	
	//��䱳����ɫ
	imagefilledrectangle($image , 0 , 0 , $width , $height , lightColor($image));
	
	
	
	//����׼�õ��ַ���������
	
	//imagechar
	
	for ($i=0;$i<$num;$i++) {
		
		
		//�����x����
		// $x = ceil($width / $num) * $i + 10;
		$x = ceil($width / $num) * $i ;
		
		
		//�����y����
		
		$y = mt_rand(15 , $height - 10);
		
		//��ʼд�ַ���
		
		// imagechar($image , 5 , $x , $y , $string[$i] , darkColor($image));

		imagettftext($image , 23 ,0 , $x +5  , $y + 10  , darkColor($image) , TTF_PATH . 'simhei.ttf' , $string[$i] );
		
	}
	
	
	//��������
	//imagearc
	
	for ($i=0;$i<$num;$i++) {
		imagearc($image , mt_rand(10 , $width) , mt_rand(10 , $height) , mt_rand(10 , $width) , mt_rand(10 , $height) , mt_rand(0 , 20) , mt_rand(0 , 270) , darkColor($image));
	}
	
	//�����ŵ�
	
	for ($i=0;$i<$num*$height;$i++) {
		imagesetpixel($image , mt_rand(0 , $width) , mt_rand(0 , $height) , darkColor($image));
	}
	
	
	
	//��֪���������  //$imageType  //gif jpeg png wbmp
	
	header("Content-type:image/$imageType");  //����˵�����ǶԵ�
	
	//����������
	
	$func = 'image' . $imageType;
	
	if (function_exists($func)) {
		$func($image);
	} else {
		exit('��֧�ֵ�ͼƬ��ʽ');
	}
	
	//������Դ
	
	imagedestroy($image);
	
	return $string;
	
}



//����ɫ

function darkColor($image)
{
	$color = imagecolorallocate($image , mt_rand(0 , 120) , mt_rand(0 , 120) , mt_rand(0 , 120));
	
	return $color;
}

//ǳ��ɫ

function lightColor($image)
{
	
	$color = imagecolorallocate($image , mt_rand(130 , 255) , mt_rand(130 , 255) , mt_rand(130 , 255));
	
	return $color;
}




