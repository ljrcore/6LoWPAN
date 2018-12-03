	<?php
	

	session_start();

	//检测是否登录，若没登录则转向登录界面
	if(!isset($_SESSION['userid'])){
		header("Location:login.html");
		exit();
	}
    $uuid=$_SESSION['userid'];
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
	function validatePassword() {
	var currentPassword,newPassword,confirmPassword,output = true;

	currentPassword = document.frmChange.currentPassword;
	newPassword = document.frmChange.newPassword;
	confirmPassword = document.frmChange.confirmPassword;

	if(!currentPassword.value) {
		currentPassword.focus();
		document.getElementById("currentPassword").innerHTML = "required";
		output = false;
	}
	else if(!newPassword.value) {
		newPassword.focus();
		document.getElementById("newPassword").innerHTML = "required";
		output = false;
	}
	else if(!confirmPassword.value) {
		confirmPassword.focus();
		document.getElementById("confirmPassword").innerHTML = "required";
		output = false;
	}
	if(newPassword.value != confirmPassword.value) {
		newPassword.value="";
		confirmPassword.value="";
		newPassword.focus();
		document.getElementById("confirmPassword").innerHTML = "not same";
		output = false;
	} 	
	return output;
	}
	</script>
	
	
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
                <a class="navbar-brand" href="#">6LoWPAN 物联网数据平台--管理员</a>
            </div>
            <ul class="nav navbar-top-links navbar-right">                               
                <!-- /.dropdown 登录注销-->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="admin.php"><i class="fa fa-user fa-fw"></i>管理中心</a>
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
                        <a href="admin.php"><i class="fa fa-table"></i>系统信息统计</a>
                    </li>
                    <li>
                        <a href="dataadmin.php"><i class="fa fa-qrcode"></i>数据管理</a>
                    </li>
                    
					<li>
                        <a href="nodeadmin.php"><i class="fa fa-qrcode"></i>节点管理</a>
                    </li>
                    
					<li>
                        <a href="useradmin.php"><i class="fa fa-table"></i>用户管理</a>
                    </li>
					<li>
                        <a href="superadmin.php"><i class="fa fa-table"></i>管理员</a>
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
                            <small>用户管理中心</small>
                        </h1>
                    </div>
              </div> 
                 <!-- /. 第一排 -->
             
                <!-- /. ROW  -->

                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-green">
                            <div class="panel-body">
                                <i class="fa fa-bar-chart-o fa-5x"></i>
                                <h3> <?php

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

									$sql = " select id from nodeinfo ";
									//执行SQL语句
									$re = mysqli_query( $conn, $sql );

									if(! $re )
									{
										die('失败' );
									}								
									echo  mysqli_num_rows($re);
									mysqli_close($conn);
									?></h3>
                            </div>
                            <div class="panel-footer back-footer-green">
                                节点数量
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-brown">
                            <div class="panel-body">
                                <i class="fa fa-users fa-5x"></i>
                                <h3> <?php

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

									$sql = " select uid from user ";
									//执行SQL语句
									$re = mysqli_query( $conn, $sql );

									if(! $re )
									{
										die('失败' );
									}								
									echo  mysqli_num_rows($re);
									mysqli_close($conn);
									?></h3>
                            </div>
                            <div class="panel-footer back-footer-brown">
                                用户总量
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">
                   <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-red">
                            <div class="panel-body">
                                <i class="fa fa fa-comments fa-5x"></i>
                                <h3> <?php

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

									$sql = " select id from nodedata ";
									//执行SQL语句
									$re = mysqli_query( $conn, $sql );

									if(! $re )
									{
										die('失败' );
									}								
									echo  mysqli_num_rows($re);
									mysqli_close($conn);
									?></h3>
                            </div>
                            <div class="panel-footer back-footer-red">
                                数据总量
                            </div>
                        </div>
                    </div>
             
                    
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-brown">
                            <div class="panel-body">
                                <i class="fa fa-users fa-5x"></i>
                                <h3> <?php

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

									$sql = " select admin from user where admin='1' ";
									//执行SQL语句
									$re = mysqli_query( $conn, $sql );

									if(! $re )
									{
										die('失败' );
									}								
									echo  mysqli_num_rows($re);
									mysqli_close($conn);
									?></h3>
                            </div>
                            <div class="panel-footer back-footer-brown">
                                管理员总量
                            </div>
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
