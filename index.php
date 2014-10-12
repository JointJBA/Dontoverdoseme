<html lang="en" class="no-js"></html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Foundation | Welcome</title>
  <link rel="stylesheet" href="css/foundation.css"/>
  <link rel="stylesheet" href="css/custom.css"/>
  <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'> 
-->
<script src="js/vendor/modernizr.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
</head>
<body>

  <?php
  $sign_in=false;

  if (empty($_POST)=== false) {
    $username_in = $_POST['username'];
    $password_in = $_POST['password'];
  //test against db and if it passes send on to index with userid as post 

    $con=mysqli_connect("localhost","root","","mymeds");
// Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }


    $result = mysqli_query($con,"SELECT * FROM user
      WHERE username='$username_in'");

    $user_row = mysqli_fetch_array($result);

    if ($user_row["password"]==$password_in){
//SIGNED IN
      $user_id= $user_row["id"];
      $username= $user_row["username"];
      $password= $user_row["password"];
      $phone= $user_row["phone"];
      $sign_in = true;

      $drugs = mysqli_query($con,"SELECT * FROM drugs
      WHERE userid='$user_id'");
      
    }
    mysqli_close($con);
  }

  if($sign_in){
    ?>
    <!-- PHP IF STATEMENT SHOWING LOGIN ONLY IF LOGGED IN -->


    <div class="row fullWidth">
      <div id="drugList" class="text-center large-2 columns">

        <dl class="tabs" data-tab>
          <dd class="drugBox"><a href="#panel1"><h3>Overview</h3></a></dd>
          <?php 
          $count=2;
          foreach($drugs as $drugrow){
            echo "<dd class='drugBox'><a href='#panel".$count."'><h3>".$drugrow['genName']."</h3></a></dd>";
            $count++;
          }


          ?>

        </dl>
        <br>
        <form action="add_drug.php" method="post">
          <input type="text" placeholder="drugs go here" name="add_drug"/>
          <input type="hidden" name="username" value="<?php echo $username?>">
          <input type="hidden" name="password" value="<?php echo $password?>">
          <input type="hidden" name="user_id" value="<?php echo $user_id?>">
          
          <p style="color:white">Take At:</p>
          <select name="schedule">
            <option value="1:00">1:00 </option>
            <option value="2:00">2:00 </option>
            <option value="3:00">3:00 </option>
            <option value="4:00">4:00 </option>
            <option value="5:00">5:00 </option>
            <option value="6:00">6:00 </option>
            <option value="7:00">7:00 </option>
            <option value="8:00">8:00 </option>
            <option value="9:00">9:00 </option>
            <option value="10:00">10:00 </option>
            <option value="11:00">11:00 </option>
            <option value="12:00">12:00 </option>
            <option value="13:00">13:00 </option>
            <option value="14:00">14:00 </option>
            <option value="15:00">15:00 </option>
            <option value="16:00">16:00 </option>
            <option value="17:00">17:00 </option>
            <option value="18:00">18:00 </option>
            <option value="19:00">19:00 </option>
            <option value="20:00">20:00 </option>
            <option value="21:00">21:00 </option>
            <option value="22:00">22:00 </option>
            <option value="23:00">23:00 </option>
            <option value="24:00">24:00 </option>
          </select>
          

          <input type="submit" class="button radius" value="Add Medicine">
        </form><!-- Link to external page where info is added to db and then redirected back to this page with sign in credentials. Fuck. This is potentially the worst code I've ever written-->





      </div>
      <div class="large-6 columns"><br/>
        <h1><?php echo $username."'s Profile "; ?> <a class="button logout radius tiny" href="index.php">Log Out</a></h1>
        <div class="panel large-12 columns">
          <div class="tabs-content">

            <div class="content active" id="panel1">
              <h2> OVERVIEW </h2>
              <p>This is the first panel of the basic tab example. This is the first panel of the basic tab example.</p>
            </div>
            <?php 
            $count2=2;
            foreach($drugs as $drugrow){
            echo "<div class='content' id='panel".$count2."'><p>".$drugrow['genName']."</p></div>";

            $json_link = '<script>$.get("https://api.fda.gov/drug/label.json?search=generic_name:'.$drugrow['genName'] . '", function(res) { $("#panel'. $count2 .'").append("<p>" + (res.results[0].warnings[0].replace(/\./g, ". <br/><br/>")) + "</p>"); }); </script>';
            echo $json_link;
            $count2++;
          }
?>

          </div>
        </div>


      </div>
      <div class="large-3 columns">
        <br>
        <br>
        <br>
        <br>
        <h2>Schedule</h2>
        <div class="panel"></div>
      </div>



      <!-- PHP IF STATEMENT SHOWING LOGIN ONLY IF LOGGED IN (END)-->

      <?php



    }else{

      ?>

      <div class="banner">
        <!-- Navigation Menu - This menu is made specifically for the homepage with the banner -->

        <!-- Banner text -->
        <div class="row fullWidth text-center">
          <br>
          <br>
          <h1>Don't Overdose Me</h1>
        </div>
      </div>
      <div class="row fullWidth90">
        <!--This is the "What Do We Do?" section on the home page-->
        <div class="large-7 columns">
          <br>
          <h1>What Do We Do?</h1>
          <br>
          <p>Bacon ipsum dolor sit amet nulla ham qui sint exercitation
            eiusmod commodo, chuck duis velit. Aute in reprehenderit, dolore
            aliqua non est magna in labore pig pork biltong. Eiusmod swine
            spare ribs reprehenderit culpa. Boudin aliqua adipisicing rump
            corned beef.
          </p>
          <p>Pork drumstick turkey fugiat. Tri-tip elit turducken pork chop
            in. Swine short ribs meatball irure bacon nulla pork belly
            cupidatat meatloaf cow. Nulla corned beef sunt ball tip, qui
            bresaola enim jowl. Capicola short ribs minim salami nulla nostrud
            pastrami.
          </p>
        </div>
        <!-- This is the login panel -->
        <div class="large-4 right panel columns">
          <h1>Login</h1>
          <br>
          <form action="" method="post">
            <div class="row">
              <div class="small-10">
                <div class="row">
                  <div class="small-2 small-offset-1 columns">
                    <label class="right inline" for=
                    "username">Username</label>
                  </div>
                  <div class="small-8 small-offset-1 columns">
                    <!-- Here is the actual textfield -->
                    <input id="username" placeholder="Username"
                    type="text" name="username">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="small-10">
                <div class="row">
                  <div class="small-2 small-offset-1 columns">
                    <label class="right inline" for=
                    "password">Password</label>
                  </div>
                  <div class="small-8 small-offset-1 columns">
                    <!-- Here is the actual textfield -->
                    <input id="password" placeholder="Password"
                    type="password" name="password">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="small-10">
                <div class="row">
                  <div class="small-6 text-center columns">
                    <br>
                    <a class="right" href="register.php">Create an
                      Account</a>
                    </div>
                    <div class="small-4 small-offset-2 columns">
                      <!-- The button here is just a styled link, if this needs to be changed I can do that -->
                      <input class="button radius" type="submit" value="Login">
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <?php 
      }



      ?>
      <!-- footer with the links at the bottom -->
      <footer class="row fullWidth90">
        <div class="large-11 columns">
          <hr>
          <div class="row">
            <div class="large-6 large-offset-6 columns">
              <ul class="inline-list right">
                <li><a href="index.html">Home</a></li>
                <li><a href="about_us.html">About Us</a></li>
                <li><a href="contact_us.html">Contact Us</a></li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
      <script src="js/vendor/jquery.js"></script>
      <script src="js/foundation.min.js"></script>
      <script>$(document).foundation();</script>
    </body>
    </html>