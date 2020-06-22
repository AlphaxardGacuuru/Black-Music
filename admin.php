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
  <meta name="description" content="">
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
  <!-- Preloader Start -->
  <div id="preloader">
    <div class="preload-content">
      <div id="sonar-load"></div>
    </div>
  </div>
  <!-- Preloader End -->

  <!-- Grids -->
  <div class="grids d-flex justify-content-between">
    <div class="grid1"></div>
    <div class="grid2"></div>
    <div class="grid3"></div>
    <div class="grid4"></div>
    <div class="grid5"></div>
    <div class="grid6"></div>
    <div class="grid7"></div>
    <div class="grid8"></div>
    <div class="grid9"></div>
  </div>

  <!-- Top Nav linked -->
  <?php include('topnav.php'); ?>

  <br>
  <br>
  <br>
  <br class="hidden">
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
      <center>
        <a href="analytics.php"><button class="btn sonar-btn">analytics</button></a>
        <br>
        <br>
        <a href="payouts.php"><button class="btn sonar-btn">payouts</button></a>
      </center>
    </div>
    <div class="col-sm-4"></div>
  </div>

  <!-- Footer linked -->
  <?php include('footer.php'); ?>

</body>

</html>