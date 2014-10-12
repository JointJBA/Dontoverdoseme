<?php
$var = $_GET['a'];



$con=mysqli_connect("localhost","root","","mymeds");
// Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

if($var == 'drugs') {
	$publish = "";
	$res = $con->query("SELECT genName, userid, schedule from drugs");
	while($result = $res->fetch_row()) {
		$publish .= $result[1] . '|' . $result[0] . '|' . $result[2] . '|';
	}
	echo $publish;
}
else if($var == "user") {
	$id = $_GET['id'];
	$publish = "";
	$res = $con->query("SELECT username, phone from user WHERE id='" . $id . "'");
	while($result = $res->fetch_row()) {
		$publish .= $result[0] . '|' . $result[1] . '|';
	}
	echo $publish;
}
?>