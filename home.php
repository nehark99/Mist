<!DOCTYPE html>
 <?php 
 session_start(); 
 if (!isset($_SESSION['username'])) {
 	$_SESSION['msg'] = "You must log in first";
 	header('location: index.php');
 }
 if (isset($_GET['logout'])) {
 	session_destroy();
    unset($_SESSION['username']);
 	header("location: index.php");
 }
// include('dbcon.php');
?> 
<html>
<head>
  <title>Mist</title>
   <link rel="shortcut icon" href="images/favicon.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/logo2.jpg">
    
    <link href="css/dashboard.css" rel="stylesheet">

	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- <link href="css/homecss.css" rel="stylesheet" > -->

    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   
</head>
<body>
	
	<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
     <a class="navbar-brand mr-1" href="home.php">Dashboard</a>
     <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
       <i class="fa fa-bars"></i>
     </button>
     <?php
     for($i=1; $i<=255; $i++){
     echo "&nbsp;";
 		}
     ?>
     <a class="btn btn-info" href = "home.php?logout=1" style="float: right;">Logout</a>
     </nav>
     
   
<div id="wrapper">
	<ul class="sidebar navbar-nav">
       <li class="nav-item active">
         <a class="nav-link" href="home.php">
           <i class="fa fa-fw fa-home"></i>
           <span>Dashboard</span>
         </a>
       </li>
       <li class="nav-item">
         <a class="nav-link" href="pred.php">
           <i class="fa fa-fw fa-pencil"></i>
           <span>Prediction</span></a>
       </li>
       
     </ul>


	
	<?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "plantdata";

  // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "SELECT * FROM plant";
    $result = mysqli_query($conn,$sql);

    $moist_arr = array();
    $humid_arr = array();
    $temp_arr = array();


    while($row=$result->fetch_assoc())
    {
    	$moist = $row["soil_humid"];
    	$air = $row["air_humid"];
    	$temp = $row["temp"];
    	$timestamp = $row["time"];
    	
    	$date=date_create($timestamp);
		$time = date_format($date,"U");
		
		
		array_push($moist_arr, array("x" => $time, "y" => $moist));
		array_push($humid_arr, array("x" => $time, "y" => $air));
		array_push($temp_arr, array("x" => $time, "y" => $temp));

    }

    ?>

    <div id="content-wrapper">
    	<div class="container-fluid">

	<button class="btn btn-info" onclick="moisture()">Moisture</button>
	<button class="btn btn-info" onclick="humid()">Humidity</button>
	<button class="btn btn-info" onclick="temp()">Temperature</button>

	<div id="chart" ></div>
	</div>
</div>


	<script>

		function moisture() {
			var dataPoints = <?php echo json_encode($moist_arr, JSON_NUMERIC_CHECK); ?>;
 
			var chart = new CanvasJS.Chart("chart", {
				theme: "light2",
				title: {
					text: "Moisture Analysis"
				},
				axisX:{
					title: "Time in millisecond"
				},
				axisY:{
					includeZero: false,
				},
				data: [{
					type: "line",
					yValueFormatString: "#,##0.0#",
					toolTipContent: "{y}",
					dataPoints: dataPoints
				}]
			});
			chart.render();  
		}	
      
    
     	function humid() {
		
			var dataPoints = <?php echo json_encode($humid_arr, JSON_NUMERIC_CHECK); ?>;
	 
			var chart = new CanvasJS.Chart("chart", {
				theme: "light2",
				title: {
					text: "Humidity Analysis"
				},
				axisX:{
					title: "Time in millisecond"
				},
				axisY:{
					includeZero: false,
				},
				data: [{
					type: "line",
					yValueFormatString: "#,##0.0#",
					toolTipContent: "{y}",
					dataPoints: dataPoints
				}]
			});
			chart.render();
		}

		function temp() {
			var dataPoints = <?php echo json_encode($temp_arr, JSON_NUMERIC_CHECK); ?>;
	 
			var chart = new CanvasJS.Chart("chart", {
				theme: "light2",
				title: {
					text: "Temperature Analysis"
				},
				axisX:{
					title: "Time in millisecond"
				},
				axisY:{
					includeZero: false,
				},
				data: [{
					type: "line",
					yValueFormatString: "#,##0.0#",
					toolTipContent: "{y}",
					dataPoints: dataPoints
				}]
			});
			chart.render();
		}
	</script>
</body>
</html>
