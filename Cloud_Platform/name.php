<?php

	session_start();

	//检测是否登录，若没登录则转向登录界面
	if(!isset($_SESSION['userid'])){
		header("Location:login.html");
		exit();
	}
	
    //取得URL参数
	$ids=$_GET["id"];
	//定义变量json存储值  
	$data="";  
	$array= array();  
	class GuiZhou{  
		//public $id;  
		public $temp;
		public $humi;		
		public $createtime;
	}		

	$dbhost = 'localhost:3306';  // mysql服务器主机地址
	$dbuser = 'root';            // mysql用户名
	$dbpass = '123456';          // mysql用户名密码

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn )
	{
		die('连接失败: ' . mysqli_error($conn));
	}

	// 设置编码，防止中文乱码
	mysqli_query($conn , "set names utf8");

	mysqli_select_db( $conn, 'shuju' );

	//$sql = "select temp,create_time from nodedata order by id desc limit 10";
	//取出后边的20条数据，用到子查询
	//$sql = "SELECT temp,humi,create_time from nodedata where id > (SELECT MAX(id) FROM nodedata) - 20";
	$sql = "SELECT temp,humi,create_time from nodedata where nodeid ='$ids'";
	//执行SQL语句,0
	$re = mysqli_query( $conn, $sql );

	if(! $re )
	{
		die('失败' );
	}


	while($row = mysqli_fetch_array($re, MYSQLI_ASSOC))
	{
			$gz = new GuiZhou();  
			$gz->temp = $row['temp']; 
			$gz->humi = $row['humi']; 			
			$gz->createtime = $row['create_time']; 
	  
			//数组赋值  
			$array[] = $gz;  

	}

    $data = json_encode($array);  
    echo $data;  

	mysqli_close($conn);
?>