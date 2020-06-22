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

  <!-- Top Nav linked -->
  <?php include('topnav.php'); ?>
  <br>
  <br>
  <br class="hidden">
  <br class="hidden">

  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
      <div class="card">
        <div class="myrow">My Songs</div>
        <div class="my-row">
          <?php
          $squer = mysqli_query($con, "SELECT * FROM video_songs");
          while ($sfetch = mysqli_fetch_assoc($squer)) {
           extract($sfetch);
           $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought = $vsong_id"); 
           $buyfetch = mysqli_fetch_assoc($buyquer);
           if (mysqli_num_rows($buyquer)===0) {
            $bbtn = "<a href='song_bought.php?vsong_id=$vsong_id'><button style='float: right;' class='mysonar-btn green-btn'>GET</button></a>";
          } else {
            $bbtn = "<button href='song_bought.php?vsong_id=$vsong_id' style='float: right; color: grey;' class='btn btn-sm btn-default'>
            <b style='color: grey'>Owned <span class='fa fa-check'></span></b></button>";
            echo "
            <div class='myrow'>

            <div class='media'>
            <div class='media-left'>
            <a href='play_video.php?vsong_id=$vsong_id'>
            <img width='150px' height='auto' src='img/havi logos-4.png'>
            </a>
            </div>

            <div class='media-body'>
            <h6 style='padding: 0px 0px 0 0; margin: 0 0; width: 160px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$vsong_name
            </h6>
            <h6 style='padding: 0px 0px 0px 0px; margin: 0 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$vsong_artist $ft</small></h6>
            <span style='font-size: 85%;'><span>$vsong_downloads Downloads</span></span>
            <br>

            $bbtn

            </div>
            </div>

            </div>";
          }
        }
        ?>
      </div>
    </div>
    <div class="col-sm-4"></div>
  </div>

  <!-- Footer linked -->
  <?php include('footer.php'); ?>

</body>
</html>