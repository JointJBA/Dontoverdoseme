<?php
$var = $_GET['a'];



$con=mysqli_connect("localhost","root","","mymeds");
// Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

if($var == 'drugs') {
	$res = $con->query("SELECT brandName, userid, schedule from drugs");
	
}
?>