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
  <meta name="viewport" content="widtd=device-widtd, initial-scale=1, shrink-to-fit=no">
  <!-- tde above 4 meta tags *must* come first in tde head; any otder head content must come *after* tdese tags -->

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

  <!-- Top Nav linked -->
  <?php include('topnav.php'); ?>

  <br>
  <br>
  <br>
  <br class="hidden">

  <!-- Profile info area -->
  <div class="row">
    <div class="col-sm-12">

      <!-- Search Form -->
      <div class="card">
        <div class="contact-form text-center call-to-action-content wow fadeInUp" data-wow-delay="0.5s">
          <form action="analytics.php" method="GET">
            <input style='margin: 0; width: 100%; padding: 10px;' type='text' name='search' class="form-control" placeholder='Search'>
          </form>
        </div>
      </div>
      <table class="table table-responsive table-hover" style="background-color: lightblue;">
        <tr>
          <td>UserID</td>
          <td>Name</td>
          <td>Username</td>
          <td>Email</td>
          <td>Phone</td>
          <td>Gender</td>
          <td>Acc Type</td>
          <td>Bio</td>
          <td>Following</td>
          <td>Fans</td>
          <td>Deco</td>
          <td>DOB</td>
          <td>Location</td>
          <td>Audios Bought</td>
          <td>Videos Bought</td>
          <td>Date Joined</td>
          <td>Time Joined</td>
        </tr>

        <?php
        if (isset($_GET['search'])) {
          $search = mysqli_escape_string($con, $_GET['search']);
              //$search = preg_replace("#[^0-9a-z]#i", "", $search);
          $quer = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '%$search%' OR name LIKE '%$search%' ORDER BY user_id DESC");
          while ($row = mysqli_fetch_assoc($quer)) {
           extract($row);
           echo "<tr>
           <td>$user_id</td>
           <td>$name</td>
           <td>$username</td>
           <td>$email</td>
           <td>$phone</td>
           <td>$gender</td>
           <td><a href='admin_actions.php?user_id=$user_id?&from=analytics'><button class='mysonar-btn'>$acc_type</button></a></td>
           <td>$bio</td>
           <td>$following</td>
           <td>$fans</td>
           <td>$deco</td>
           <td>$dob</td>
           <td>$location</td>
           <td>$asongs_bought</td>
           <td>$vsongs_bought</td>
           <td>$date_joined</td>
           <td>$time_joined</td>
           </tr>"; 
         }
       }
       ?>
     </table>
     </div>
   </div>
   <!-- Search Form End -->

   <div class="row">
    <div class="col-sm-2">
      <!-- Number of Users Start-->
      <div class="card">
        <table class='table'>
          <tr>
            <td>
              <h4>Users</h4>
            </td>
            <td>
              <?php
              $userquer = mysqli_query($con, "SELECT * FROM users WHERE acc_type = 'musician' OR acc_type = 'normal'");
              $userfetch = mysqli_fetch_assoc($userquer);
              extract($userfetch);
              echo mysqli_num_rows($userquer);
              ?>
            </td>
          </tr>
          <!-- Number of Users End -->

          <!-- Number of Musicians Start-->
          <tr>
            <td>
              <h4>Musicians</h4>
            </td>
            <td>
              <?php
              $userquer = mysqli_query($con, "SELECT * FROM users WHERE acc_type = 'musician' ");
              $userfetch = mysqli_fetch_assoc($userquer);
              extract($userfetch);
              echo mysqli_num_rows($userquer);
              ?>
            </td>
          </tr>
          <!-- Number of Musicians End -->

          <!-- Number of Songs Start -->
          <tr>
            <td>
              <h4>Songs</h4>
            </td>
            <td>
              <?php
              $songquer = mysqli_query($con, "SELECT * FROM video_songs");
              $songfetch = mysqli_fetch_assoc($songquer);
              extract($songfetch);
              echo mysqli_num_rows($songquer);
              ?>
            </td>
          </tr>
          <!-- Number of Songs End -->

          <!-- Number of Songs Bought Start -->
          <tr>
            <td>
              <h4>Songs Bought</h4>
            </td>
            <td>
              <?php
              $boughtSongQuer = mysqli_query($con, "SELECT * FROM vsongs_bought");
              $boughtSongFetch = mysqli_fetch_assoc($boughtSongQuer);
              extract($boughtSongFetch);
              echo mysqli_num_rows($boughtSongQuer);
              ?>
            </td>
          </tr>
          <!-- Number of Songs Bought End -->

          <!-- Revenue Start -->
          <tr>
            <td>
              <h4>Revenue</h4>
            </td>
            <td style="color: green;">
              <?php
              $boughtSongQuer = mysqli_query($con, "SELECT * FROM vsongs_bought");
              $boughtSongFetch = mysqli_fetch_assoc($boughtSongQuer);
              extract($boughtSongFetch);
              $totalRevenue = mysqli_num_rows($boughtSongQuer)*20;
              echo "KES $totalRevenue";
              ?>
            </td>
          </tr>
          <tr>
            <td>
              <h6>this week</h6>
            </td>
            <td>
              <?php
              $checkBought = mysqli_query($con, "SELECT * FROM vsongs_bought");
              $fetchBought = mysqli_fetch_assoc($checkBought);
              $sum = mysqli_num_rows($checkBought)*20;
              $payoutQuer = mysqli_query($con, "SELECT SUM(payout_amount) AS value_sum FROM payouts");
              $payoutFetch = mysqli_fetch_assoc($payoutQuer);
              $payoutSum = $payoutFetch["value_sum"]*2;
              $payoutTotal = $sum-$payoutSum;
              echo "<h6>KES $payoutTotal</h6>";
              ?>
            </td>
          </tr>
          <!-- Revenue End -->

          <!-- Profit Start -->
          <tr>
            <td>
              <h4>Profit</h4>
            </td>
            <td style="color: green;">
              <?php
              $boughtSongQuer = mysqli_query($con, "SELECT * FROM vsongs_bought");
              $boughtSongFetch = mysqli_fetch_assoc($boughtSongQuer);
              extract($boughtSongFetch);
              $totalRevenue = mysqli_num_rows($boughtSongQuer)*10;
              echo "KES $totalRevenue";
              ?>
            </td>
          </tr>
          <tr>
            <td>
              <h6>this week</h6>
            </td>
            <td style="color: green;">
              <?php
              $checkBought = mysqli_query($con, "SELECT * FROM vsongs_bought");
              $fetchBought = mysqli_fetch_assoc($checkBought);
              $sum = mysqli_num_rows($checkBought)*10;
              $payoutQuer = mysqli_query($con, "SELECT SUM(payout_amount) AS value_sum FROM payouts");
              $payoutFetch = mysqli_fetch_assoc($payoutQuer);
              $payoutSum = $payoutFetch["value_sum"];
              $payoutTotal = $sum-$payoutSum;
              echo "<h6>KES $payoutTotal</h6>";
              ?>
            </td>
          </tr>
        </table>
      </div>
      <!-- Profit End -->
      <br>
      <!-- <a href="admin_actions.php"><button class="sonar-btn">change</button></a> -->
    </div>
    <div class="col-sm-10">
      <!-- <div class="card"> -->
        <table class="table table-responsive table-hover">
          <tr>
            <td>UserID</td>
            <td>Name</td>
            <td>Username</td>
            <td>Email</td>
            <td>Phone</td>
            <td>Gender</td>
            <td>Acc Type</td>
            <td>Bio</td>
            <td>Following</td>
            <td>Fans</td>
            <td>Deco</td>
            <td>DOB</td>
            <td>Location</td>
            <td>Audios Bought</td>
            <td>Videos Bought</td>
            <td>Date Joined</td>
            <td>Time Joined</td>
          </tr>
          <?php
          $userquer = mysqli_query($con, "SELECT * FROM users WHERE acc_type = 'musician' OR acc_type = 'normal' ORDER BY user_id DESC LIMIT 10");
          while ($userfetch = mysqli_fetch_assoc($userquer)) {
            extract($userfetch);
            echo "<tr>
            <td>$user_id</td>
            <td>$name</td>
            <td>$username</td>
            <td>$email</td>
            <td>$phone</td>
            <td>$gender</td>
            <td><a href='admin_actions.php?user_id=$user_id&from=analytics'><button class='mysonar-btn'>$acc_type</button></a></td>
            <td>$bio</td>
            <td>$following</td>
            <td>$fans</td>
            <td>$deco</td>
            <td>$dob</td>
            <td>$location</td>
            <td>$asongs_bought</td>
            <td>$vsongs_bought</td>
            <td>$date_joined</td>
            <td>$time_joined</td>
            </tr>"; 
          }
          ?>
        </table>
        <!-- </div> -->
      </div>
      <div class="col-sm-1"></div>
    </div>

    <!-- Footer linked -->
    <?php include('footer.php'); ?>

  </body>

  </html>