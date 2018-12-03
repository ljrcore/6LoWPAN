<?php

	session_start();

	//检测是否登录，若没登录则转向登录界面
	if(!isset($_SESSION['userid'])){
		header("Location:../login.html");
		exit();
	}
	
require_once("dbcontroller.php");
$db_handle = new DBController();

if(!empty($_POST['id'])) {
	$id = $_POST['id'];
	$sql = "DELETE FROM  nodeinfo WHERE id = '$id' ";
	$db_handle->executeQuery($sql);
}
?>