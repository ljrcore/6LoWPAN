	<?php

	

	session_start();

	//检测是否登录，若没登录则转向登录界面
	if(!isset($_SESSION['userid'])){
		header("Location:login.html");
		exit();
	}
	$uuid=$_SESSION['userid'];
	
	require_once("nodecrud/dbcontroller.php");
	$db_handle = new DBController();

	$sql = $sql = "SELECT * from nodeinfo WHERE  uid='$uuid'";
	$nodeinfo = $db_handle->runSelectQuery($sql);
	?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>6LoWPAN 物联网数据平台</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />   
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />

	<!-- 引入 echarts.js -->

	<script src="assets/js/echarts.js"></script>
	<script src="assets/js/echarts.min.js"></script>
	<script src="assets/js/jquery-3.3.1.min.js"></script>
	<script src="assets/js/jquery-3.3.1.js"></script>
	    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>     
      <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
	<script>
	//定义变量，用来给php传参数

	function createNew() {
		$("#add-more").hide();
		var data = '<tr class="table-row" id="new_row_ajax">' +
		'<td  id="txt_id" onBlur="addToHiddenField(this,\'id\')" ></td>' +
		'<td contenteditable="true" id="txt_title" onBlur="addToHiddenField(this,\'nodeName\')" onClick="editRow(this);"></td>' +
		'<td contenteditable="true" id="txt_description" onBlur="addToHiddenField(this,\'nodeLocation\')" onClick="editRow(this);"></td>' +
		'<td contenteditable="true" id="txt_sensorName1" onBlur="addToHiddenField(this,\'sensorName1\')" onClick="editRow(this);"></td>' +
		'<td contenteditable="true" id="txt_sensorName2" onBlur="addToHiddenField(this,\'sensorName2\')" onClick="editRow(this);"></td>' +
		'<td><input type="hidden" id="nodeName" /><input type="hidden" id="nodeLocation" /><input type="hidden" id="sensorName1" /><input type="hidden" id="sensorName2" /><span id="confirmAdd"><a onClick="addToDatabase()" class="ajax-action-links">保存</a> / <a onclick="cancelAdd();" class="ajax-action-links">取消</a></span></td>' +	
		'</tr>';
	  $("#table-body").append(data);
	}
	function cancelAdd() {
		$("#add-more").show();
		$("#new_row_ajax").remove();
	}
	function editRow(editableObj) {
	  $(editableObj).css("background","#FFF");
	}

	function saveToDatabase(editableObj,column,id) {
	  $(editableObj).css("background","#FFF url(nodecrud/loaderIcon.gif) no-repeat right");
	  $.ajax({
		url: "nodecrud/edit.php",
		type: "POST",
		data:'column='+column+'&editval='+$(editableObj).text()+'&id='+id,
		success: function(data){
		  $(editableObj).css("background","#FDFDFD");
		}
	  });
	}
	function addToDatabase() {
	  var nodeName = $("#nodeName").val();
	  var nodeLocation = $("#nodeLocation").val();
	  var sensorName1 = $("#sensorName1").val();
	  var sensorName2 = $("#sensorName2").val();
	  
		  $("#confirmAdd").html('<img src="nodecrud/loaderIcon.gif" />');
		  $.ajax({
			url: "nodecrud/add.php",
			type: "POST",
			data:'nodeName='+nodeName+'&nodeLocation='+nodeLocation+'&sensorName1='+sensorName1+'&sensorName2='+sensorName2,  //uid
			success: function(data){
			  $("#new_row_ajax").remove();
			  $("#add-more").show();		  
			  $("#table-body").append(data);
			}
		  });
	}
	function addToHiddenField(addColumn,hiddenField) {
		var columnValue = $(addColumn).text();
		$("#"+hiddenField).val(columnValue);
	}

	function deleteRecord(id) {
		if(confirm("Are you sure you want to delete this row?")) {
			$.ajax({
				url: "nodecrud/delete.php",
				type: "POST",
				data:'id='+id,
				success: function(data){
				  $("#table-row-"+id).remove();
				}
			});
		}
	}
	</script>
	
	
	<style>
	
	.tbl-qa{width: 100%;font-size:0.9em;background-color: #f5f5f5;}
	.tbl-qa th.table-header {padding: 5px;text-align: left;padding:10px;}
	.tbl-qa .table-row td {padding:10px;background-color: #FDFDFD;}
	.ajax-action-links {color: #09F; margin: 10px 0px;cursor:pointer;}
	.ajax-action-button {border:#094 1px solid;color: #09F; margin: 10px 0px;cursor:pointer;display: inline-block;padding: 10px 20px;}
	</style>
</head>

<body>

    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="num.php">6LoWPAN 物联网数据平台</a>
            </div>
            <ul class="nav navbar-top-links navbar-right">                               
                <!-- /.dropdown 登录注销-->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="usercenter.php"><i class="fa fa-user fa-fw"></i>用户中心</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.php?action=logout"><i class="fa fa-sign-out fa-fw"></i>注销  <?php echo("{$_SESSION['username']}");?></a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
 <!--/. NAV TOP左栏列表  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                

				   
				   
					<li>
                        <a class="active-menu" href="chart.html"><i class="fa fa-bar-chart-o"></i>传感器节点列表<span class="fa arrow"></span></a>
						<div id="collapseListGroup1" class="panel-collapse collapse in" role="tabpanel" >
						<?php
							//取得URL参数
							$ids=$_GET["fid"];
							$dbhost = 'localhost:3306';  // mysql服务器主机地址
							$dbuser = 'root';            // mysql用户名
							$dbpass = '123456';          // mysql用户名密码

							$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

							if(! $conn )
							{
								die('数据库连接失败: ' . mysqli_error($conn));
							}

							// 设置编码，防止中文乱码
							mysqli_query($conn , "set names utf8");

							mysqli_select_db( $conn, 'shuju' );

							$sql = "select * from nodeinfo where uid='$uuid'";
							//执行SQL语句
							$re = mysqli_query( $conn, $sql );

							if(! $re )
							{
								die('访问数据库失败' );
							}
							
							echo "<ul class='nav nav-second-level'>";
							while($row = mysqli_fetch_array($re, MYSQLI_ASSOC))
							{
								echo "<li><a href=node.php?fid={$row['id']}>{$row['nodeName']}</a></li>";
							}
							echo '</ul>';

							mysqli_close($conn);

						?>
						</div>
                    </li>
					<li>
                        <a href="datagrid.php"><i class="fa fa-table"></i>原始数据查询</a>
                    </li>
                    <li>
                        <a href="nodeinfo.php"><i class="fa fa-qrcode"></i>传感器节点维护</a>
                    </li>
                    
                    <li>
                        <a href="usercenter.php"><i class="fa fa-table"></i>用户中心</a>
                    </li>
									<li>
                        <a href="help.php"><i class="fa fa-table"></i>使用帮助</a>
                    </li>
					
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                   
				   <div class="col-md-12">
                        <h1 class="page-header">
                            <small>传感节点数据维护</small>
                        </h1>
                    </div>
              </div> 
                 <!-- /. 第一排 -->
             
                <div class="row">                     
                    <div class="col-md-12 col-sm-12 col-xs-12">                     
                         <div class="panel panel-default">
                                      <div class="panel-heading">节点信息（每个节点上可包含多个传感器，目前的设计数量是2个传感器）</div>




                                     <div>
									<table class="tbl-qa">
									  <thead>
										<tr>
										  <th class="table-header">节点编号</th>
										  <th class="table-header">节点名称</th>
										  <th class="table-header">位置描述</th>
										  <th class="table-header">传感器1描述</th>
										  <th class="table-header">传感器2描述</th>
										  <th class="table-header">操作</th>
										</tr>
									  </thead>
									  <tbody id="table-body">
										<?php
										if(!empty($nodeinfo)) { 
										foreach($nodeinfo as $k=>$v) {
										  ?>
										  <tr class="table-row" id="table-row-<?php echo $nodeinfo[$k]["id"]; ?>">
										    <td ><?php echo $nodeinfo[$k]["id"]; ?></td>
											<td contenteditable="true" onBlur="saveToDatabase(this,'nodeName','<?php echo $nodeinfo[$k]["id"]; ?>')" onClick="editRow(this);"><?php echo $nodeinfo[$k]["nodeName"]; ?></td>
											<td contenteditable="true" onBlur="saveToDatabase(this,'nodeLocation','<?php echo $nodeinfo[$k]["id"]; ?>')" onClick="editRow(this);"><?php echo $nodeinfo[$k]["nodeLocation"]; ?></td>
											<td contenteditable="true" onBlur="saveToDatabase(this,'sensorName1','<?php echo $nodeinfo[$k]["id"]; ?>')" onClick="editRow(this);"><?php echo $nodeinfo[$k]["sensorName1"]; ?></td>
											<td contenteditable="true" onBlur="saveToDatabase(this,'sensorName2','<?php echo $nodeinfo[$k]["id"]; ?>')" onClick="editRow(this);"><?php echo $nodeinfo[$k]["sensorName2"]; ?></td>
											<td><a class="ajax-action-links" onclick="deleteRecord(<?php echo $nodeinfo[$k]["id"]; ?>);">删除</a></td>
										  </tr>
										  <?php
										}
										}
										?>
									  </tbody>
									</table>
									</div>
									<div class="ajax-action-button" id="add-more" onClick="createNew();">添加节点</div>
                     </div>            
                </div>
    
                
              </div>
 
              
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>

     <!-- /. WRAPPER  -->	

	           

    
   
</body>
</html>
