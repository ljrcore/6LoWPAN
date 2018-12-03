<?php


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

$sql = "select nodeinfo.id,nodeinfo.uid,nodeinfo.nodeName,nodeinfo.nodeLocation,nodeinfo.sensorName1,nodeinfo.sensorName2
        from nodeinfo";
//执行SQL语句
$re = mysqli_query( $conn, $sql );

if(! $re )
{
    die('失败' );
}


echo '<table border="1"><tr><td>编号</td><td>用户账号</td><td>节点名</td><td>节点位置</td><td>传感器1</td><td>传感器2</td><td>操作</td></tr>';

while($row = mysqli_fetch_array($re, MYSQLI_ASSOC))
{
    echo "<tr><td> {$row['id']}</td> ".
         "<td>{$row['uid']} </td> ".
         "<td>{$row['nodeName']} </td> ".
         "<td>{$row['nodeLocation']} </td> ".
		 "<td>{$row['sensorName1']} </td> ".
		 "<td>{$row['sensorName2']} </td> ".
		 "<td> <a href=dbdelete.php?id={$row['uid']}>删除</a>  <a href=update.php?id={$row['uid']}>禁用</a></td> ".
         "</tr>";

}

echo '</table>';
mysqli_close($conn);


?>