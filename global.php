<?php

if (!function_exists("returnArrayValueByKey")) {
	/**
	 * 根据数组key值返回value值
	 *
	 * @param array $arr 数组
	 * @param string|int $key 键值
	 * @param boolean $isReturnKey 是否在没有找到value时返回key值
	 * @return string key|value|''
	 */
	function returnArrayValueByKey($arr,$key,$isReturnKey=false)
	{
		if (is_array($arr)) {
			if (array_key_exists($key, $arr)) {
				return $arr[$key];
			}
		}
		if($isReturnKey)
		{
			return $key;
		}
		return '';
	}
}

/**
 * 读取指定url地址文件数据
 * @param  string $file_url url地址
 * return void
 */
function Read_Url($file_url){
	$str="";
	$handle = @fopen($file_url, "r");
	if ($handle) {
		while (!feof($handle)) {
			$buffer = fgets($handle, 4096);
			printr($buffer);
			// 			$str .= $buffer." ";
		}
		// 		return $str;
		fclose($handle);
	}else{
		exit("文件无法打开");
	}
}

/**
 * 得到某个目录下所有的文件名。
 * @param String $dir
 * @return Array
 *
 */
function getfileName($dir){
	$array=array();
	//1、先打开要操作的目录，并用一个变量指向它
	//打开当前目录下的目录pic下的子目录common。
	$handler = opendir($dir);
	//2、循环的读取目录下的所有文件
	/*其中$filename = readdir($handler)是每次循环的时候将读取的文件名赋值给$filename，为了不陷于死循环，所以还要让$filename !== false。一定要用!==，因为如果某个文件名如果叫’0′，或者某些被系统认为是代表false，用!=就会停止循环*/
	while( ($filename = readdir($handler)) !== false ){
		// 3、目录下都会有两个文件，名字为’.'和‘..’，不要对他们进行操作
		if($filename != '.' && $filename != '..'){
			// 4、进行处理
			array_push($array,$filename);
		}
	}
	closedir($handler);
	return $array;
}

/**
 * 將指定url地址代碼及內容寫入到指定文件
 *
 * @param string  $url       指定的url地址
 * @param string  $filename  要保持的地址及文件名
 * return void
 */
function save_http_url_code($url,$filename){
	$content=file_get_contents($url); //获取html内容
	$handle=fopen($filename,'w');//打开文件并确认可写
	if ($handle){
		fwrite($handle,$content);
		fclose($handle);
		echo "<script>alert('成功地写入到文件$filename');</script>";
	}
}

/**
 * 驗證各傳入的數組，并對各數組進行處理
 *
 * @param array   $arr     需驗證的數組
 * @param string  $default 添加的默認值
 * @return void
 */
function get_nums(&$arr,$default = ''){
	$value = $default !== ''?$default:1;
	isset($arr) ? $arr +=$value:$arr = $value;
}

/**
 * 执行sql语句，并将结果集返回
 * 
 * @param string   $sql   sql语句
 * @param resource $conn  连接db资源句柄
 * return resource
 */
function query($sql,$conn){
	$query = @mysql_query($sql,$conn) or _echo($sql);
	return $query;
}

/**
 * 将sql语句执行的结果以数组形式返回
 * 
 * @param string   $sql   sql语句
 * @param resource $conn  连接db资源句柄
 * return array
 */
function get_sql_result($sql,$conn){
	$query = query($sql,$conn);
	$rs = array();
	while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
		$rs[] = $row;
	}
	$result = count($rs)===1?current($rs[0]):$rs;
	return $result;
}


/**
 * 测试输出print_r
 * @param mixed $value 测试对象或数组等
 * return mixed
 */
function printr($value) {
	echo "<pre>";
	print_r ( $value );
	echo "</pre>";
}
/**
 * 测试输出
 * @param mixed  $value 测试变量等
 * @param string $key   测试变量名
 * return mixed
 */
function _echo($value,$key='') {

	echo '<hr>', $key . " : " . $value, '<hr>';

}

?>
