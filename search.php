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

  <!-- Top Nav linked -->
  <?php include('topnav.php'); ?>
  <br>
  <br>

  <!-- Song suggestion area -->
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">

      <!-- search form for mobile -->
      <div class="card">
        <div class="contact-form text-center call-to-action-content wow fadeInUp" data-wow-delay="0.5s">
          <form action="search.php" method="GET">
            <input style='margin: 0; width: 100%; padding: 10px;' type='text' name='search' class="form-control anti-hidden" placeholder='Search Songs, Artists'>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="myrow">
          <div class="hidden-scroll">

            <?php
            //Users search
            if (isset($_GET['search'])) {
              $search = mysqli_escape_string($con, $_GET['search']);
              //$search = preg_replace("#[^0-9a-z]#i", "", $search);
              $quer = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '%$search%' AND acc_type = 'musician' OR name LIKE '%$search%' AND acc_type = 'musician' ORDER BY username ASC");
              while ($row = mysqli_fetch_assoc($quer)) {
               extract($row);
               $fb_quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user' AND followed = '$username'");
               $fb_fetch = mysqli_fetch_assoc($fb_quer);
               $as_quer = mysqli_query($con, "SELECT * FROM asongs_bought WHERE asong_buyer = '$user' AND asong_bought_artist = '$username'");
               $as_fetch = mysqli_fetch_assoc($as_quer);
               $vs_quer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought_artist = '$username'");
               $vs_fetch = mysqli_fetch_assoc($vs_quer);
               if (mysqli_num_rows($fb_quer)===0) {
                if (mysqli_num_rows($as_quer)>0 || mysqli_num_rows($vs_quer)>0) {
                  $fbutton = "<a href='follows.php?username=$username'><button type='submit' class='mysonar-btn'>follow</button></a>";
                } else {
                  $fbutton = "<a><button style='float: right;' class='mysonar-btn' onclick='checkerSnackbar()'>follow</button></a>";
                }
              } else {
                $fbutton = "<a href='follows.php?username=$username'><button type='submit' class='btn btn-sm btn-default'><b style='color: grey;'>Followed <span class='fa fa-check'></span></b></button></a>";
              }
              if ($username != $user && $username != "@blackmusic") {
                echo "
                <span>
                <a href='musicianpage.php?username=$username'>
                <img src='$pp_path' width='100px' height='100px' alt='' class='avatar'>
                </a>
                <h6 class='compress' style='width: 100px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$name</h6>
                <h6 style='width: 100px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$username</small></h6>
                $fbutton
                </span>

                <!-- The actual snackbar for following message -->
                <div id='checker'>You must have bought atleast 1 song by that Musician</div>
                ";
              }
            }
          }
          ?>
        </div>
            <button class="left mysonar-btn myScrollBtn hidden" style="float: left; left: -1rem; top: 7rem;"><</button>
            <button class="right mysonar-btn myScrollBtn hidden" style="float: right; right: -1rem; top: 7rem;">></button>
        <?php
        //Song search
        if (isset($_GET['search'])) {
          $search = mysqli_escape_string($con, $_GET['search']);
          $search = preg_replace("#[^0-9a-z]#i", "", $search);
          $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_name LIKE '%$search%' AND vsong_artist != '$user'");
          if (mysqli_num_rows($quer) + mysqli_num_rows($squer) == 0) {
            echo "<div class='myrow'><h5>Nothing found!</h5></div>";
          } else {
            while ($sfetch = mysqli_fetch_assoc($squer)) {
             extract($sfetch);
             $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought = $vsong_id"); 
             $buyfetch = mysqli_fetch_assoc($buyquer);
          //Check if song is already in cart
             $cart_check = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_song = '$vsong_id' AND vs_cart_user = '$user'");
             $cart_check_quer = mysqli_fetch_assoc($cart_check);
             if (mysqli_num_rows($buyquer)===0) {
              $bbtn = "<a href='vs_cart.php?vsong_id=$vsong_id&from=checkout' class='btn mysonar-btn green-btn' style='float: right;'>buy</a>";
            } else {
              $bbtn = "<a style='color: grey; float: right;' class='btn btn-sm btn-default'>
              <b style='color: grey'>Owned <span class='fa fa-check'></span></b></a>";
            }
            if (mysqli_num_rows($cart_check)>0) {
              $cart = "<a style='color: grey; min-width: 50px;' class='btn btn-sm btn-default'>
              <span class='fa fa-shopping-cart'></span></a>";
            } else {
              if (mysqli_num_rows($buyquer)>0) {
                $cart = "";
              } else {
                $cart = "<a href='vs_cart.php?vsong_id=$vsong_id&from=home' style='min-width: 50px; float: left; margin' class='btn mysonar-btn'><span class='fa fa-shopping-cart'></span></a>";
              }
            }
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

            $cart
            $bbtn

            </div>
            </div>

            </div>
            ";
          }
        }
      }
      ?>
    </div>
  </div>
</div>
<div class="col-sm-4"></div>
<!-- End of Song Area -->

<br>
<br>

<!-- <a href="mpesa2.php" class="btn btn-sm btn-default">mpesa</a> -->
</div>
</div>

<!-- Footer linked -->
<?php include('footer.php'); ?>

</body>

</html>