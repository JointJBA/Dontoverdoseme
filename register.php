<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Foundation | Welcome</title>
  <link rel="stylesheet" href="css/foundation.css" />
  <script src="js/vendor/modernizr.js"></script>
</head>
<body>


  <?php

  if (empty($_POST)=== false) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    echo $username;
    echo "\n";
    echo $password;
    echo "\n";
    echo $phone;

    $con=mysqli_connect("localhost","root","","mymeds");
// Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }


    $sql="INSERT INTO user (username, password, phone)
    VALUES ('$username', '$password', '$phone')";

    if (!mysqli_query($con,$sql)) {
      die('Error: ' . mysqli_error($con));
    }
    echo "1 record added";

    mysqli_close($con);


  }
  ?>
  
  <div class="row">
    <div class="large-12 text-center columns">
      <h1>Don't Overdose Me</h1>
    </div>
  </div>
  <br>
  <br>
  <br>
  
  <div class="row">
    <div class="large-8 large-centered columns">
     <div class="register panel text-center radius">
      <h2>Register</h2>
      <br>
      <form action="" method="post">
        <div class="large-12 large-centered columns">
          <div class="row">
            <div class="large-3 columns">
              <label class="left inline" for=
              "username">Username:</label>
            </div>
            <div class="large-9 columns">
              <input type="text" name="username">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="large-3 columns">
              <label class="left inline" for=
              "phone">Phone:</label>
            </div>
            <div class="large-9 columns">
              <input type="text" name="phone">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="large-3 columns">
              <label class="left inline" for=
              "username">Password:</label>
            </div>
            <div class="large-9 columns">
              <input type="password" name="password">
            </div>
          </div>
          <br>
        </div>
        <input class="button radius" type="submit" value=
        "Register">
      </form>
    </div>        
  </div>
</div>


</div>

<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script>
$(document).foundation();
</script>
</body>
</html>
