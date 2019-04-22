<?php

	/**
	 * 格式化帖子时间, 规则如下:
	 * 如果一小时内，显示分钟，如果大于1小时小于1天显示小时，如果大于天且小于3天，显示天数，否则显示日期时间
	 * @param time $showTime
	 * @return Datetime
	 */
	function getFormatTime($showTime)
	{
		$nowTime = time();	//当前时间
		$dur = $nowTime - $showTime;	//当前时间 - 帖子时间
		if ($dur < 60)
		{
			$overTime = $dur . '秒前';
		} else if ($dur < 3600) {
			$overTime = floor($dur/60) . '分钟前';
		} else if ($dur < 86400) {
			$overTime = floor($dur/3600) . '小时前';
		} else if ($dur < 259200) {//3天内
			$overTime = floor($dur/86400) . '天前';
		} else {
			$overTime = date('Y-m-d H:i:s', $showTime);
		}
		return $overTime;
	}



	/**
	 * 定义楼层
	 * @param Integer $conunt
	 * @return String
	 */
	function storey($count)
	{
		switch($count){
			case 0:
				return '沙发';
				break;
			case 1:
				return '板凳';
				break;
			case 2:
				return '地板';
				break;
			case 3:
				return '地下室';
				break;
			case 4:
				return '地狱';
				break;
			default:
				return '第'.($count+1).'楼';
		}
	}




	/**
	 * 电梯跳转楼层设置
	 * @param Integer $count
	 * @return Integer
	 */
	function setFloor($count)
	{
		return $count+1;
	}



