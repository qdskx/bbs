<?php


	/**
	 * 检测用户名和密码长度(不能为空)
	 * @param String $str
	 * @param Intiger $minLen
	 * @param Intiger $maxLen
	 * @return Boolean
	 */
	function stringLen($str, $minLen = 6, $maxLen = 12)
	{
		if(!empty($str))
		{
			$strLen = mb_strlen($str);

			if($strLen >= $minLen && $strLen <= $maxLen){

				return true;
			}else
			{
				return false;
			}
		}else{
			return false;
		}

		
	}

	/**
	 * 检测两次密码输入是否一致
	 * @param String $str1
	 * @param String $str2
	 * @return Boolean
	 */
	function strEqual($str1, $str2)
	{
		if($str1 == $str2){
			return false;
		}else{
			return true;
		}
	}


	/**
	 * 判断密码是否是纯数字
	 * @param String $str1
	 * @return Boolean
	 */
	function checkNum($password)
	{
		// if(preg_match("/^[0-9a-zA-Z]$/",$password)){
		if(preg_match("/^[0-9]*$/",$password)){
			 return true;
		}
	}

	// 验证手机号
	function checkMobile($tel_num)
	{
		if(preg_match("/^1[3|4|5|7|8][0-9]{9}$/" , $tel_num))
		{
			return true;
		}
	}

	//检测邮箱格式
	function checkEmail($mail)
	{
		$pattern='/^[\w-]+@([a-zA-Z0-9-]+\.)+((com)|(cn)|(net)|(edu))$/i';
		if(preg_match($pattern, $mail))
		{
			return false;
		}else{
			return true;
		}
	}

	// "^[\\w-]+(\\.[\\w-]+)*@[\\w-]+(\\.[\\w-]+)+$"　
	


	/**
	 * UNIX时间戳格式化为日期
	 * @param time $addTime
	 * @param bool $gs (true, 无 时:分:秒 | false, 有 时:分:秒)
	 * @return Datetime
	 */
	function formatTime($addTime, $gs = true)
	{
		if($gs){
			return date('Y-m-d',$addTime);
		}else{
			return date('H:i:s',$addTime);
		}
	}


	//用户等级
	function userGrade($grade)
	{
		if($grade == 5){

			echo '小溪小虾';

		}else if($grade <= 10){

			echo '潜底蛟龙';

		}else if($grade <= 15){

			echo '翰海巨鲸';

		}else if($grade <= 20){

			echo '陆上雄狮';

		}else if($grade <= 25){

			echo '沙漠银狐';

		}else if($grade <= 30){

			echo '北极企鹅';

		}else if($grade <= 35){

			echo '蓝天突兀';

		}else
		{

			echo '南冥鲲鹏';

		}
	}

	/**
	 * 魔术转译
	 * @param String $data
	 * @return String
	 */
	function strMagic ($data)
	{
		$toLowerData = strtolower(trim($data));
		if(GPC){
			return addslashes($toLowerData);
		}
		return $toLowerData;
	}

