
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <title>用户注册</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Oleo+Script:400,700'>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">

    </head>

    <body>

        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="logo span6">
                        <h1><a href="#">6LoWPAN 物联网数据平台 <span class="red"></span></a></h1>
                    </div>
                </div>
            </div>
        </div>
		
        <div class="register-container container">
            <div class="row">              
                <div class="register span6">
                    <form name="LoginForm" method="post" action="login.php" onSubmit="return InputCheck(this)">
                        <h2>注册信息错误<span class="red"></span></h2>
					      <?php

							//随机生成6位字符串
							function create_key($pw_length)
							{ 
								$randpwd = ""; 
								for ($i = 0; $i < $pw_length; $i++) 
								{ 
								$randpwd .= chr(mt_rand(48, 57)); 
								} 
								return $randpwd; 
							} 

							if(!isset($_POST['submit'])){
								exit('非法访问!');
							}
							$username = $_POST['username'];
							$password = $_POST['password'];
							$email = $_POST['email'];
							//注册信息判断
							if(!preg_match('/^[\w\x80-\xff]{3,15}$/', $username)){
								exit('错误：用户名不符合规定。<a href="javascript:history.back(-1);">返回</a>');
							}
							if(strlen($password) < 6){
								exit('错误：密码长度不符合规定。<a href="javascript:history.back(-1);">返回</a>');
							}
							if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $email)){
								exit('错误：电子邮箱格式错误。<a href="javascript:history.back(-1);">返回</a>');
							}
							//包含数据库连接文件
							include('conn.php');
							//检测用户名是否已经存在
							$check_query = mysql_query("select uid from user where username='$username' limit 1");
							if(mysql_fetch_array($check_query)){
								echo '错误：用户名 ',$username,' 已存在。<a href="javascript:history.back(-1);">返回</a>';
								exit;
							}
							//写入数据
							$password = MD5($password);

							// 调用该函数，传递长度参数$pw_length = 6 
							$nodekey= create_key(10);
							 
							$sql = "INSERT INTO user(username,password,email,nodekey)VALUES('$username','$password','$email','$nodekey')";
							if(mysql_query($sql,$conn)){
								header("Location: login.html");
                                exit;								
							} else {
								echo 'fail by insert data：',mysql_error(),'<br />';
								echo 'click <a href="javascript:history.back(-1);">return </a> and retry';
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
        <script src="assets/js/scriptss.js"></script>

    </body>

</html>

