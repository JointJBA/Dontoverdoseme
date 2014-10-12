<?php

if (empty($_POST)=== false) {
  $add_drug = $_POST['add_drug'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $user_id = $_POST['user_id'];
  $schedule = $_POST['schedule']; //will be replaced 



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

<form action="index.php" method="post">
<input type="hidden" name="username" value="<?php echo $username?>">
          <input type="hidden" name="password" value="<?php echo $password?>">
          <input type="submit" class="button radius" value="Go back">
</form>