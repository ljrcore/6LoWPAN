<?php
    
	/**
	 * 获取自定义的header数据
	 */
	function get_all_headers(){

		// 忽略获取的header数据
		$ignore = array('host','accept','content-length','content-type');

		$headers = array();

		foreach($_SERVER as $key=>$value){
			if(substr($key, 0, 5)==='HTTP_'){
				$key = substr($key, 5);
				$key = str_replace('_', ' ', $key);
				$key = str_replace(' ', '-', $key);
				$key = strtolower($key);

				if(!in_array($key, $ignore)){
					$headers[$key] = $value;
				}
			}
		}

		return $headers;

	}
	
	
	header('Access-Control-Allow-Origin:*');//注意！跨域要加这个头 上面那个没有
    $post_array = file_get_contents('php://input'); //获取POST内容
	$header = get_all_headers(); //获取HTTP头中的自定义部分
	var_dump($header["wsn-key"]); //显示wsn-key头
	
	$mi = $header["wsn-key"];
    var_dump($post_array); //显示内容

	//--解析Json，获取对应的变量值	
	$obj=json_decode($post_array,TRUE);
	
	$xm = $obj['id'];
	$xb = $obj['temp'];
	$nl = $obj['humi'];

	echo ( "data:" . $xm . $xb . $nl . $xy);

	
	
	
	$dbhost = 'localhost:3306';  // mysql服务器主机地址
	$dbuser = 'root';            // mysql用户名
	$dbpass = '123456';          // mysql用户名密码

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn )
	{
		die('connect failed!' . mysqli_error($conn));
	}

	
	// 设置编码，防止中文乱码
	mysqli_query($conn , "set names utf8");
	mysqli_select_db( $conn, 'shuju' );
    
    $sq = "select * from user where nodekey='$mi'";
	$sql = "INSERT INTO nodedata 
	( nodeid , temp , humi) VALUES ('$xm','$xb','$nl')";
   

	//执行SQL语句
	$u = mysqli_query( $conn, $sq );
	if(! $u )
	{
		die('Run SQL failed!' );
	}
	
	$re = mysqli_query( $conn, $sql );
	if(! $re )
	{
		die('Run SQL failed!' );
	}
	echo"Insert data success";

	mysqli_close($conn);


?>