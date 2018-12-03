
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <title>用户登录</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
        <link href='http://fonts.googleapis.com/css?family=Oleo+Script:400,700' rel='stylesheet' type="text/css">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">

    </head>

    <body>

        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="logo span6">
                        <h1><a href="#">6LoWPAN物联网数据平台 <span class="red"></span></a></h1>
                    </div>
                </div>
            </div>
        </div>
		
        <div class="register-container container">
            <div class="row">              
                <div class="register span6">
                    <form name="LoginForm" method="post" action="login.php" onSubmit="return InputCheck(this)">
                        <h2>登录数据平台<span class="red"></span></h2>
						  <?php
								session_start();

								//注销登录
								if($_GET['action'] == "logout"){
									unset($_SESSION['userid']);
									unset($_SESSION['username']);
									echo '注销登录成功！点击此处 <a href="login.html">登录</a>';
									exit;
								}

								//登录
								if(!isset($_POST['submit'])){
									exit('非法访问!');
								}
								$username = htmlspecialchars($_POST['username']);
								$password = MD5($_POST['password']);

								//包含数据库连接文件
								include('conn.php');
								//检测用户名及密码是否正确
								$check_query = mysql_query("select uid from user where username='$username' and password='$password' and admin='0' and ban='0' limit 1");
								$check_queryy = mysql_query("select uid from user where username='$username' and password='$password' and admin='1' and ban='0' limit 1");
								if($result = mysql_fetch_array($check_query)){
									//登录成功
									$_SESSION['username'] = $username;
									$_SESSION['userid'] = $result['uid'];
									header("Location:num.php");
		                            exit();
								}
								elseif($resultt = mysql_fetch_array($check_queryy)){
								    //登录成功
									$_SESSION['username'] = $username;
									$_SESSION['userid'] = $resultt['uid'];
									header("Location:admin.php");
		                            exit();	
								} 
								else {
									exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
								}
								?>
                    </form>
                </div>
            </div>
        </div>

        <!-- Javascript -->
        <script src="assets/js/jquery-1.8.2.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>

    </body>

</html>

