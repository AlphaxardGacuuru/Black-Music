<?php
$user = $_COOKIE['username'];
if (empty($user)) {
  header('location: index.php');
}

//DB connection for all account info
include('variables.php');
$quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$user'");
$row = mysqli_fetch_assoc($quer);
extract($row);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Black Music, Music">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <!-- Title  -->
  <title>Black Music</title>

  <!-- Favicon  -->
  <link rel="icon" href="img/havi logos-4.png">

  <!-- Style CSS -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="black_music.css">
</head>
<body>
  <div class="row">
    <div class="col-sm-4"></div>
    <div style="text-align: center;" class="col-sm-4">
      <?php
      //Check password

      //Define variables and set to empty
      $passwordErr = "";
      if (isset($_POST['login_user'])) {
        include('variables.php');
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $password = md5($password);
        if ($row['password'] != $password) {
          $passwordErr = "Wrong password!";
        } else {
          header('location: home.php');
        }
      }

      ?>
      <br>
      <h2>Hi there <?php echo $username; ?></h2>
      <h4>Enter your password</h4>
      <div class="contact-form form-group">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <div class="form-group">
            <small class="error"> <?php echo $passwordErr;?></small><br>
            <label><input type="password" class="form-control" name="password" placeholder="password" required=""></label>
            <br>
            <br>
            <button type="submit" name="login_user" class="btn sonar-btn">Login</button>
            <br>
            <br>
            <a href="index.php" class="btn sonar-btn">back</a>
          </div>
        </form>
      </div>

      <!-- single accordian area -->
      <div class="panel single-accordion">
        <h6>
          <a role="button" class="collapsed" aria-expanded="true" aria-controls="collapseTwo" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">FORGOT PASSWORD
            <span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
            <span class="accor-close"><i class="fa fa-minus" aria-hidden="true"></i></span>
          </a>
        </h6>
        <div id="collapseTwo" class="accordion-content collapse">
          <br>
          <h3>Forgot your password?</h3> 
          <h4>No worries we'll send you an email.</h4>
          <br>
          <?php
          echo "
            <span style='color: green;'>The email associated to your account is <b>$email.</b></span>
            <br>
            <br>
            <a href='email.php?forgotPassword=$email&user_id=$user_id&username=$username' class='btn sonar-btn'>send link</a> 
            ";
            ?>
            <br>
            <br>
        </div>
      </div>
      <br>
      <?php 
      if (isset($_GET['message'])) { 
        extract($_GET); 
        echo "<h5 style='color: green;'>$message</h5>";
      } 
      ?>
    </div>
    <div class="col-sm-4"></div>
  </div>
  <!-- jQuery (Necessary for All JavaScript Plugins) -->
  <script src="js/jquery/jquery-2.2.4.min.js"></script>
  <!-- Popper js -->
  <!-- <script src="js/popper.min.js"></script> -->
  <!-- Bootstrap js -->
  <script src="js/bootstrap.min.js"></script>
  <!-- Plugins js -->
  <!-- <script src="js/plugins.js"></script> -->
  <!-- Active js -->
  <script src="js/active.js"></script>

  <!-- black music JS -->
  <script src="black_music.js"></script>
</body>
</html>