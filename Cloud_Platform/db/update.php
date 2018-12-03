<!DOCTYPE HTML>




<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>信息添加</title>
	<style type="text/css">
	.info{
	   font-size:14;
	   color:red;
	 
	
	}
	
	
	</style>
	
</head>

<body>
<h1>信息修改</h1>
<hr />
	<div class="info">
	
	
	<?php
	//header("Content-Type: text/html;charset=utf-8");  
	$xh = $_GET["id"];

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

	mysqli_select_db( $conn, 'student' );

	$sql = "select *  from xuesheng where xuehao='$xh'";

	//执行SQL语句
	$re = mysqli_query( $conn, $sql );

	if(! $re )
	{
		die('失败' );
	}


	echo "<form action='dbup.php' method='POST' >";

	while($row = mysqli_fetch_array($re, MYSQLI_ASSOC))
	{
		
	?>
			学号<br /><input type="text" name="fxh" readonly="true" value=<?php echo "{$row['xuehao']}" ?> />  <br />
			姓名<br /><input type="text" name="fxm" value=<?php echo "{$row['stuname']}"   ?> />  <br />
			性别<br /><input type="text" name="fxb" value=<?php echo "{$row['sex']}" ?> />  <br />
			年龄<br /><input type="text" name="fnl" value=<?php echo "{$row['age']}"  ?> />  <br />
			学院ID<br /><input type="text" name="fxy" value=<?php echo "{$row['xueyuanid']}"?> /> <br />
			<input type="submit" />
			 
	<?php
	}

	echo '</form>';




	mysqli_close($conn);

	?>



	</div>
	
</body>
</html>