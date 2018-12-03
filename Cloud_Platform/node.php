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
							$NodeArr=array();

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
						<?php
							//取得URL参数
							$ids=$_GET["fid"];
							$dbhost = 'localhost:3306';  // mysql服务器主机地址
							$dbuser = 'root';            // mysql用户名
							$dbpass = '123456';          // mysql用户名密码
							$nodenn='';
                            $nodell='';
							$sensorn1='';
							$sensorn2='';
							$conn = mysqli_connect($dbhost, $dbuser, $dbpass);



							// 设置编码，防止中文乱码
							mysqli_query($conn , "set names utf8");

							mysqli_select_db( $conn, 'shuju' );

							$sql = "select * from nodeinfo where id='$ids'";
							//执行SQL语句
							$re = mysqli_query( $conn, $sql );
			
							
							while($row = mysqli_fetch_array($re, MYSQLI_ASSOC))
							{
								$nodenn=$row['nodeName'];
								$nodell=$row['nodeLocation'];
								$sensorn1=$row['sensorName1'];
							    $sensorn2=$row['sensorName2'];
							}	

							mysqli_close($conn);
						?>
						
						
							<small>节点名称：[<?php echo "{$nodenn}"; ?>]
                            &nbsp;&nbsp;&nbsp;&nbsp;安装位置：[<?php echo "{$nodell}"; ?>]</small>
							
                        </h1>
                    </div>
              </div> 
                 <!-- /. 第一排 -->
             
                <div class="row">                     
                    <div class="col-md-12 col-sm-12 col-xs-12">                     
                         <div class="panel panel-default">
                                      <div class="panel-heading">传感器:[<?php echo "{$sensorn1}"; ?>]</div>
                             <div class="panel-body">
                                       <div id="main" style="width: 900px;height:350px;"></div>
                            </div>
                     </div>            
                </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">                     
                          <div class="panel panel-default">
                                      <div class="panel-heading">传感器:[<?php echo "{$sensorn2}"; ?>]</div>
                             <div class="panel-body">
                                      <div id="main2" style="width: 900px;height:350px;"></div>
                           </div>
                     </div>            
                </div> 
                
              </div>
 
              
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
		<?php
			//界面上临时保存URL参数，以便jquery调用，隐藏起来
			echo "<div id='nnid' ids='{$ids}'></div>";
		?>
     <!-- /. WRAPPER  -->	
				 <script type="text/javascript">
       // 基于准备好的dom，初始化echarts实例  
        var myChart = echarts.init(document.getElementById('main'));
		var myChart2 = echarts.init(document.getElementById('main2')); 		
        // 初始化两个数组，盛装从数据库中获取到的数据  
        var temp=[], humi=[], createtime=[];  
        function TestAjax(){ 
            //定义变量，用来给php传参数
            var nid= $("#nnid").attr("ids");			
            $.ajax({  
                type: "post",  
                async: false,     //异步执行  
                url: "name.php?id=" + nid,   //SQL数据库文件   name.php?id=1
                data: {},         //发送给数据库的数据  
                dataType: "json", //json类型  
                success: function(result) {  
                    if (result) { 
                        temp=[],humi=[], createtime=[];					
                        for (var i = 0; i < result.length; i++) {  
                            temp.push(result[i].temp);
                            humi.push(result[i].humi);							
                            createtime.push(result[i].createtime);  
                            console.log(result[i].temp);  
                            console.log(result[i].createtime);  
                        }  
                    }  
                }  
            })  
            return temp, humi, createtime;  
        } 
  
        //执行异步请求   
       TestAjax();  //不加此行就不显示x轴的时间了
  
        // 指定图表的配置项和数据  
        var option = {  
            dataZoom: [
           {
            show: true,
            realtime: true,
            start: 65,
            end: 100
           },
           {
            type: 'inside',
            realtime: true,
            start: 65,
            end: 100
           }
          ],
			tooltip: {  
                show : true  
            },  
            legend: {  
                data:['温度']  
            },  
            xAxis: [{  
               
                type : 'category',  
                data : createtime  
            }],  
            yAxis: {  
                type : 'value',
				max: 40,
				axisLabel: {
					formatter: '{value} °C'
				}				
            }, 
            visualMap: {
				top: 10,
				right: 10,
				pieces: [{
					gt: 0,
					lte: 30,
					color: '#096'
				}, {
					gt: 30,
					lte: 60,
					color: '#ffde33'
				}, {
					gt: 60,
					lte: 90,
					color: '#ff9933'
				}, {
					gt: 90,
					lte: 120,
					color: '#cc0033'
				}, {
					gt: 120,
					lte: 150,
					color: '#660099'
				},{
                    gt: 150,
                    color: '#7e0023'
                } 
				],
				outOfRange: {
					color: '#999'
				}
             },			
            series: [
			{  
                name : "温度",  
                type : "line",  
                data : temp  
           }           			
			]  
        };
 // 指定图表的配置项和数据  
        var option2 = {  
            dataZoom: [
           {
            show: true,
            realtime: true,
            start: 65,
            end: 100
           },
           {
            type: 'inside',
            realtime: true,
            start: 65,
            end: 100
           }
          ],
			tooltip: {  
                show : true  
            },  
            legend: {  
                data:['湿度',]  
            },  
            xAxis: [{  
               
                type : 'category',  
                data : createtime  
            }],  
            yAxis: {  
                type : 'value',
				max: 40,
				axisLabel: {
					formatter: '{value} °C'
				}				
            }, 
            visualMap: {
				top: 10,
				right: 10,
				pieces: [{
					gt: 0,
					lte: 30,
					color: '#096'
				}, {
					gt: 30,
					lte: 60,
					color: '#ffde33'
				}, {
					gt: 60,
					lte: 90,
					color: '#ff9933'
				}, {
					gt: 90,
					lte: 120,
					color: '#cc0033'
				}, {
					gt: 120,
					lte: 150,
					color: '#660099'
				},{
                    gt: 150,
                    color: '#7e0023'
                } 
				],
				outOfRange: {
					color: '#999'
				}
             },			
            series: [			
            {  
                name : "湿度",  
                type : "line",  
                data : humi  
            }			
			]  
        };		
  
        // 使用刚指定的配置项和数据显示图表。  
        myChart.setOption(option); 
		myChart2.setOption(option2);		
		
		setInterval(function () {
		    //data.shift();
			
			TestAjax(); 
			//myChart.setOption(option); 
			
			
			myChart.setOption({
				 xAxis: [{  
					type : 'category',  
					data : createtime  
				}],  
				yAxis: {  
					type : 'value'  
				},  
				series: [{
					data: temp					
				}
				]
			});
			myChart2.setOption({
				 xAxis: [{  
					type : 'category',  
					data : createtime  
				}],  
				yAxis: {  
					type : 'value'  
				},  
				series: [{
					data: humi					
				}
				]
			});
        }, 1000);
		

		
  </script>
  
</body>
</html>
