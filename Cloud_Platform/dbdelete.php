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
 
$sql = "delete from nodeinfo where id='$xh'";
 
mysqli_select_db( $conn, 'shuju' );
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
    die('无法删除数据: ' . mysqli_error($conn));
}
echo "<script>location.href='nodeadmin.php'</script>";
mysqli_close($conn);
?>