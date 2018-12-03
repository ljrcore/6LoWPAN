<?php

session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.html");
	exit();
}
$uuid=$_SESSION['userid'];

/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "shuju";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'id', 
	1 => 'nodeid',
	2 => 'temp',
	3 => 'humi',
	4=> 'create_time'
);

// getting total number records without any search
$sql = "SELECT
		nodedata.id,
		nodedata.nodeid,
		nodedata.temp,
		nodedata.humi,
		nodeinfo.nodeName,
		nodeinfo.uid
		FROM
		nodedata ,
		nodeinfo
		WHERE
		nodedata.nodeid=nodeinfo.id and nodeinfo.uid = '$uuid'";

$query=mysqli_query($conn, $sql) or die("error: get data");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT
		nodedata.id,
		nodedata.nodeid,
		nodedata.temp,
		nodedata.humi,
		nodedata.create_time 
		FROM
		nodedata ,
		nodeinfo
		WHERE
		nodedata.nodeid=nodeinfo.id and nodeinfo.uid = '$uuid'";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	//$sql.=" AND ( id LIKE '".$requestData['search']['value']."%' ";    
	//$sql.=" OR nodeid LIKE '".$requestData['search']['value']."%' ";
	//$sql.=" OR temp LIKE '".$requestData['search']['value']."%' ";
	//$sql.=" OR humi LIKE '".$requestData['search']['value']."%' ";
	//$sql.=" OR create_time LIKE '".$requestData['search']['value']."%' )";
	//直查传感数据
	$sql.=" AND ( temp LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR humi LIKE '".$requestData['search']['value']."%' )";	
}
$query=mysqli_query($conn, $sql) or die("error: get data");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("error: get data");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["id"];
	$nestedData[] = $row["nodeid"];
	$nestedData[] = $row["temp"];
	$nestedData[] = $row["humi"];
	$nestedData[] = $row["create_time"];
	
	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
