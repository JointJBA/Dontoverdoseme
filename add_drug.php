<?php

if (empty($_POST)=== false) {
  $add_drug = $_POST['add_drug'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $user_id = $_POST['user_id'];
  $schedule = $_POST['schedule']; //will be replaced 

  echo $add_drug;
  echo "<br>";
  echo $username;
  echo "<br>";
  echo $password;
  echo "<br>";
  echo $user_id;
  echo "<br>";
  echo $schedule;


  $con=mysqli_connect("localhost","root","","mymeds");
// Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


  $sql="INSERT INTO drugs (genName, userid, schedule)
  VALUES ('$add_drug', '$user_id', '$schedule')";

  if (!mysqli_query($con,$sql)) {
    die('Error: ' . mysqli_error($con));
  }
  echo "<br>1 record added";

  mysqli_close($con);
}
?>