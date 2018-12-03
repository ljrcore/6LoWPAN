<?php
$userkey = $_POST["key"];	
$nid = $_POST["nodeid"];
$s1 = $_POST["sensor1"];
$s2 = $_POST["sensor2"];

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
$check_query = mysql_query("select * from user where nodekey='$userkey'");
$sql = "INSERT INTO nodedata (nodeid,temp,humi) VALUES ('$nid ','$s1','$s2')";

//执行SQL语句
$result = mysql_query( $conn, $check_query );
$re = mysqli_query( $conn, $sql );
if(! $result )
{
    die('失败' );
}

mysqli_close($conn);


?>