<?php
require("dbcon.php");

$soil_humid = $_REQUEST['soil_humid'];
$air_humid = $_REQUEST['air_humid'];
$temp = $_REQUEST['temp'];

$sql="INSERT INTO plant (soil_humid,air_humid,temp)VALUES($soil_humid,$air_humid,$temp)";
mysqli_query($con,$sql) or die (mysqli_error($con));

?>