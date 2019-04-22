<?php
/*
*模板引擎函数
*@param $tplPath string
*@param $tplVal array
*/
function display($tplPath , $tplVal = null)
{
	//组合模板文件的路径，拼接模板文件
	$tplFilePath = rtrim(TPL_PATH , '/') . '/' . $tplPath;
	
	
	// var_dump($tplFilePath);
	
	//检测你的模板文件是否存在
	
	if (!file_exists($tplFilePath)) {
		exit('模板文件不存在');
	}
	
	// include "$tplFilePath";
	
	//开始编译模板文件
	
	$php = compile($tplFilePath);
	
	// var_dump($php);
	
	//开始拼装缓存文件的路径
	$cacheFilePath = rtrim(TPL_CACHE , '/') . '/' . str_replace('.' , '_' , $tplPath) . '.php';
	
	
	//判断文件夹
	
	//检测目录的权限
	
	if (!check_cache_dir(TPL_CACHE)) {
		exit('没有权限写入');
	}
	
	//写入文件
	
	file_put_contents($cacheFilePath , $php);
	
	//分配变量
	
	if (is_array($tplVal)) {
		extract($tplVal);
		include $cacheFilePath;
	}
	
}


//检测目录
function  check_cache_dir($path)
{
	//
	if (!is_dir($path) || !file_exists($path)) {
		return mkdir($path , 0777 , true);
	}
	
	//可以写入
	
	if (!is_writeable($path) || !is_readable($path)) {
		return chmod($path , 0777);
	}
	
	return true;
}


//编译方法
function compile($path)
{
	//把模板文件里面的内容都拿出来
	$file = file_get_contents($path);
	
	// var_dump($file);
	
	//规则  这里面并不是真正的正则
	
	//规则
	$keys = [
		'{$%%}' 			=> '<?=$\1;?>',
		// '<{:%%}>'		    => '<?php echo \1;',
		'{if %%}' 			=> '<?php if(\1):?>',
		'{/if}'				=> '<?php endif;?>',
		'{else}'			=> '<?php else: ?>',
		'{elseif %%}'   	=> '<?php elseif(\1):?>',
		'{else if %%}'  	=> '<?php elseif(\1):?>',
		'{foreach %%}'		=> '<?php foreach(\1):?>',
		'{/foreach}'		=> '<?php endforeach;?>',
		'{while %%}'		=> '<?php while(\1):?>',
		'{/while}'			=> '<?php endwhile;?>',
		'{for %%}'			=> '<?php for(\1):?>',
		'{/for}'			=> '<?php endfor;?>',
		'{continue}'		=> '<?php continue;?>',
		'{break}'			=> '<?php break;?>',
		'{$%%++}'			=> '<?php $\1++;?>',
		'{$%%--}'			=> '<?php $\1--;?>',
		'{/*}'				=> '<?php /*',
		'{*/}'				=> '*/?>',
		'{section}'			=> '<?php ',
		'{/section}'		=> '?>',
		'{$%% = $%%}'		=> '<?php $\1 = $\2;?>',
		'{default}'			=> '<?php default:?>',
		'{include %%}'		=> '<?php include "\1";?>',
	];
	
	
	foreach ($keys as $key => $val) {
		
		
		$pattern = '#'.str_replace('%%' , '(.+)' , preg_quote($key , '#')).'#imsU';
		//echo $pattern.'<br />';
		//#\{\$(.+)\}#imsU
		$replace = $val;
		
		
		//查找include
		
		
		// echo $pattern;
		
		
		// 这有问题,keys里面肯定有include啊 ???
		// pattern应该换成file吧
		if (stripos($pattern , 'include')) {
			//inlucde 区间
			
			$file = preg_replace_callback($pattern , 'parseInclude' , $file);
		} else {
			
			$file = preg_replace($pattern , $replace , $file);
			
		}
		
	
	}
	
	// var_dump($file);
	return $file;
	
}

//处理包含的函数

function parseInclude($data)
{
	
	//var_dump($data);
	
	$path = str_replace(['\''] , '' , $data[1]);
	//echo $path;
	
	display($path);
	
	$cacheFileName = rtrim(TPL_CACHE , '/') . '/' . str_replace('.' , '_' , $path) . '.php';
	
	return "<?php include '$cacheFileName';?>";
}
































