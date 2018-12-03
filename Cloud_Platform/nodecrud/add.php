<?php

	session_start();

	//检测是否登录，若没登录则转向登录界面
	if(!isset($_SESSION['userid'])){
		header("Location:../login.html");
		exit();
	}
	$uuid=$_SESSION['userid'];
	
	require_once("dbcontroller.php");
	$db_handle = new DBController();

if(!empty($_POST["nodeName"])) {
	$nodeName = $_POST["nodeName"];  //mysqli_real_escape_string($conn,"dfdsf");//strip_tags());
	$nodeLocation = $_POST["nodeLocation"];   //mysqli_real_escape_string($conn,"ddfd");//strip_tags());
	$sensorName1 = $_POST["sensorName1"];   //mysqli_real_escape_string($conn,"ddfd");//strip_tags());
	$sensorName2 = $_POST["sensorName2"];   //mysqli_real_escape_string($conn,"ddfd");//strip_tags());
	$uid = $_POST["uid"];   //mysqli_real_escape_string($conn,"ddfd");//strip_tags());
  $sql = "INSERT INTO nodeinfo (nodeName,nodeLocation,sensorName1,sensorName2,uid) VALUES ('" . $nodeName . "','" . $nodeLocation . "','" . $sensorName1 . "','" . $sensorName2 . "','" . $uuid . "')";
  $faq_id = $db_handle->executeInsert($sql);
    if(!empty($faq_id)) {
		$sql = "SELECT * from nodeinfo WHERE id = '$faq_id' and uid='$uuid'";
		$nodeinfo = $db_handle->runSelectQuery($sql);
	}
?>
<tr class="table-row" id="table-row-<?php echo $nodeinfo[0]["id"]; ?>">
<td><?php echo $nodeinfo[0]["id"]; ?></td>
<td contenteditable="true" onBlur="saveToDatabase(this,'nodeName','<?php echo $nodeinfo[0]["id"]; ?>')" onClick="editRow(this);"><?php echo $nodeinfo[0]["nodeName"]; ?></td>
<td contenteditable="true" onBlur="saveToDatabase(this,'nodeLocation','<?php echo $nodeinfo[0]["id"]; ?>')" onClick="editRow(this);"><?php echo $nodeinfo[0]["nodeLocation"]; ?></td>
<td contenteditable="true" onBlur="saveToDatabase(this,'sensorName1','<?php echo $nodeinfo[0]["id"]; ?>')" onClick="editRow(this);"><?php echo $nodeinfo[0]["sensorName1"]; ?></td>
<td contenteditable="true" onBlur="saveToDatabase(this,'sensorName2','<?php echo $nodeinfo[0]["id"]; ?>')" onClick="editRow(this);"><?php echo $nodeinfo[0]["sensorName2"]; ?></td>
<td><a class="ajax-action-links" onclick="deleteRecord(<?php echo $nodeinfo[0]["id"]; ?>);">删除</a></td>
</tr>  
<?php } ?>