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

  <!-- ***** Call to Action Area Start ***** -->
  <div class="sonar-call-to-action-area section-padding-0-100">
    <div class="backEnd-content">
      <h2>Studio</h2>
    </div>

    <div class="row">
      <div class="col-sm-2">
        <div class="card">
          <table class='table'>
            <tr>
              <th style="border: none;">
                <h5>Songs</h5>
              </th>
              <th style="border: none;">
                <?php
                $songquer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_artist = '$user'");
                while ($songfetch = mysqli_fetch_assoc($songquer)) {
                  extract($songfetch);
                }
                echo "<h5>" . mysqli_num_rows($songquer) . "</h5>";
                ?>
              </th>
            </tr>
            <tr>
              <td>
                <h5>Downloads</h5>
              </td>
              <td>
                <?php
                $result = mysqli_query($con, "SELECT SUM(vsong_downloads) AS value_sum FROM video_songs WHERE vsong_artist = '$user' ");
                $row = mysqli_fetch_assoc($result); 
                $sum = $row['value_sum'];
                echo "<h5>$sum</h5>";
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <h6>Unpaid</h6>
              </td>
              <td>
                <?php
                $result = mysqli_query($con, "SELECT SUM(vsong_downloads) AS value_sum FROM video_songs WHERE vsong_artist = '$user' ");
                $row = mysqli_fetch_assoc($result); 
                $sum = $row['value_sum'];
                $payoutQuer = mysqli_query($con, "SELECT SUM(payout_amount) AS value_sum FROM payouts WHERE payout_artist = '$user' ");
                $payoutFetch = mysqli_fetch_assoc($payoutQuer);
                $payoutSum = $payoutFetch["value_sum"]/10;
                $thisWeekDown = $sum-$payoutSum;
                echo "<h6>$thisWeekDown</h6>";
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <h5>Revenue</h5>
              </td>
              <td>
                <?php
                $totalRevenue = $sum*10;
                echo "<h5 style='color: green;'>KES $totalRevenue</h5>";
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <h6>Unpaid</h6>
              </td>
              <td>
                <?php
                $payoutQuer = mysqli_query($con, "SELECT SUM(payout_amount) AS value_sum FROM payouts WHERE payout_artist = '$user' ");
                $payoutFetch = mysqli_fetch_assoc($payoutQuer);
                $payoutSum = $payoutFetch["value_sum"];
                $totalRevenue = $sum*10;
                $thisWeekRev = $totalRevenue-$payoutSum;
                echo "<h6 style='color: green;'>KES $thisWeekRev</h6>";
                ?>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="col-sm-10">
          <table class="table table-responsive table-hover">
            <tr>
              <th><h5>Song</h5></th>
              <th><h5>Artist</h5></th>
              <th><h5>ft</h5></th>
              <th><h5>Genre</h5></th>
              <th><h5>Downloads</h5></th>
              <th><h5 style="color: green;">Revenue</h5></th>
              <th><h5>Likes</h5></th>
              <th><h5>Date</h5></th>
              <th><h5></h5></th>
            </tr>
            <?php
            $songquer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_artist = '$user'");
            while ($songfetch = mysqli_fetch_assoc($songquer)) {
              extract($songfetch);
              $songRevenue = $vsong_downloads*10;
              echo "
              <tr>
              <td><a href='play_video.php?vsong_id=$vsong_id'>$vsong_name</a></td>
              <td>$vsong_artist</td>
              <td>$ft</td>
              <td>$vgenre</td>
              <td>$vsong_downloads</td>
              <td style='color: green;'>KES $songRevenue</td>
              <td>$vsong_loves</td>
              <td>$date</td>
              <td><a href='edit_song.php?vsong_id=$vsong_id'><button class='mysonar-btn'>edit</button></a></td>
              </tr>"; 
            }
            ?>
          </table>

      </div>
    </div>
  </div>

  <!-- Footer linked -->
  <?php include('footer.php'); ?>

</body>

</html>