<?php
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
mysqli_select_db( $conn, 'shuju' );


$sql = "UPDATE user SET ban='1' WHERE uid='$xh'";

//执行SQL语句
$re = mysqli_query( $conn, $sql );
if(! $re )
{
    die('修改失败' );
}
echo "<script>location.href='useradmin.php'</script>";

mysqli_close($conn);


?>