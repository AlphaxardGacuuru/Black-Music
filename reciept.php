<?php
$user = $_COOKIE['username'];
if (empty($user)) {
  header('location: index.php');
}

//DB connection for all account info
include('variables.php');
$quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$user' ");
$row = mysqli_fetch_assoc($quer);
extract($row);

$permission = "";
//fetch songs from vs_cart
$checkCart = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_user = '$user' ");
while($fetchCart = mysqli_fetch_assoc($checkCart)) {
  extract($fetchCart);
  //fetch vsongs_bought
  $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' ORDER BY vsong_bought_id DESC "); 
  $buyfetch = mysqli_fetch_assoc($buyquer);
  $totalSongs = mysqli_num_rows($buyquer)*20;
  //fetch cash
  $checkKopokopo = mysqli_query($con, "SELECT * FROM kopokopo WHERE sender_phone = '$phone' ORDER BY id DESC "); 
  if ($fetchKopokopo = mysqli_fetch_assoc($checkKopokopo)) {
    $extractKopokopo = extract($fetchKopokopo);
  }
  $checkKopokopoSum = mysqli_query($con, "SELECT SUM(amount) AS value_sum FROM kopokopo WHERE sender_phone = '$phone' "); 
  $fetchKopokopoSum = mysqli_fetch_assoc($checkKopokopoSum); 
  $totalCash = $fetchKopokopoSum['value_sum'];
  $balance = $totalCash-$totalSongs;
  $permission = intval($balance/20);
  if ($permission >= 1) {
    $vsb_quer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought = '$vs_cart_song' ");
    $vsb_fetch = mysqli_fetch_assoc($vsb_quer);
    $vs_quer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_id = '$vs_cart_song' ");
    $vs_fetch = mysqli_fetch_assoc($vs_quer);
    extract($vs_fetch);
    if (mysqli_num_rows($vsb_quer)===0) {
        //add song to vsongs_bought 
      $vsong = "INSERT INTO `vsongs_bought` (`vsong_bought_id`, `vsong_bought`, `vsong_bought_reference`, `vsong_bought_artist`, `vsong_buyer`, `vsong_bought_time`, `vsong_bought_date`) VALUES (NULL, '$vsong_id', '$reference', '$vsong_artist', '$user', '$time', '$date')";
      $vsong_quer = mysqli_query($con, $vsong) or die(mysqli_error($con));

          //Add video song download count
      $vscount_quer = "UPDATE video_songs SET vsong_downloads = vsong_downloads+1 WHERE vsong_id = '$vsong_id'";
      $vscount_fetch = mysqli_query($con, $vscount_quer); 

          //Adding number of video songs bought by user
      $add_vsong_bought = "UPDATE users SET vsongs_bought = vsongs_bought+1 WHERE username = '$user'";
      $vsong_bought_quer = mysqli_query($con, $add_vsong_bought) or die(mysqli_error($con));

          //Showing video song bought notification
      $vs_notify = "INSERT INTO vs_notifies (`vsn_id`, `vsn_bought`, `vsn_bought_artist`, `vsn_bought_name`, `vsn_buyer`) VALUES (NULL, '$vsong_id', '$vsong_artist', '$vsong_name', '$user')";
      $vs_quer = mysqli_query($con, $vs_notify);

          //Add deco if necessary
          //Check if songs are 10
      $deco_checkA = mysqli_query($con, "SELECT * FROM decos WHERE deco_to = '$user' AND deco_from = '$vsong_artist' ");
      $deco_counterA = mysqli_num_rows($deco_checkA);
      $deco_checkB = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought_artist = '$vsong_artist' ");
      $deco_counterB = mysqli_num_rows($deco_checkB)/10;
      $deco_balance = $deco_counterB - $deco_counterA;
      $decoPermission = intval($deco_balance);
          //If songs are 10 then add deco
      if($decoPermission >= 1) {
        $deco_quer = "INSERT INTO `decos` (`deco_id`, `deco_to`, `deco_from`, `deco_time`, `deco_date`) VALUES (NULL, '$user', '$vsong_artist', '$time', '$date')";
        $deco_fetch = mysqli_query($con, $deco_quer);

            //Add deco to user 
        $add_deco = "UPDATE users SET deco = deco+1 WHERE username = '$user'";
        $add_deco_query = mysqli_query($con, $add_deco);

            //Add deco notification
        $dnotif_quer = "INSERT INTO `deco_notifies` (`dn_id`, `dn_to`, `dn_from`) VALUES (NULL, '$user', '$vsong_artist')";
        $dnotif_fetch = mysqli_query($con, $dnotif_quer);
      }

          //Delete from cart
      mysqli_query($con, "DELETE FROM vsong_cart WHERE vs_cart_id = '$vs_cart_id'");
    } 
  }
}
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
  <br>
  <br class="hidden">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-3">
      <div class="card">
        <div class='myrow'>
          <h5>Your Cart</h5>
        </div>
        <?php
        //Get cart items
        $vs_cart_quer = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_user = '$user' ORDER BY vs_cart_id ");
        $cart_count = mysqli_num_rows($vs_cart_quer);
        while($vs_cart_fetch = mysqli_fetch_assoc($vs_cart_quer)) {
          extract($vs_cart_fetch);
          echo "
          <div class='myrow'>
          <div class='media'>
          <div class='media-left'>
          <a href='play_video.php?vs_cart_song=$vs_cart_song'>
          <img width='150px' height='auto' src='img/havi logos-4.png'>
          </a>

          </div>
          <div class='media-body'>
          <b><a href='play_video.php?vs_cart_song=$vs_cart_song'>$vs_cart_songname</a></b>
          <a href='cart_delete.php?vs_cart_id=$vs_cart_id' style='float: right;'>
          <span class='fa fa-trash'></span>
          </a>
          <br>
          $vs_cart_songartist
          <br>
          <br>
          <button style='float: right;' class='mysonar-btn green-btn'>kes 20</button>
          </div>
          </div>

          </div>
          ";
        }
        ?>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card">
        <div class='myrow'>
          <h5>Purchase History</h5>
        </div>
        <div class='myrow'>
          <?php
          //get recently bought songs
          $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' ORDER BY vsong_bought_id DESC "); 
          while ($buyfetch = mysqli_fetch_assoc($buyquer)) {
            extract($buyfetch);
            $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_id = '$vsong_bought' ");
            $sfetch = mysqli_fetch_assoc($squer);
            extract($sfetch);
            if (mysqli_num_rows($buyquer)===0) {
              $bbtn = "<a href='song_bought2.php?vsong_id=$vsong_id' style='float: right; border-color: #339933;' class='btn btn-sm btn-default'>
              <b style='color: #339933'>GET</b></a>";
            } else {
              $bbtn = "<button href='song_bought2.php?vsong_id=$vsong_id' style='float: right; color: grey;' class='btn btn-sm btn-default'>
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

              <b><a href='play_video.php?vsong_id=$vsong_id'>$vsong_name</a></b>
              <small><i style='float: right; padding-right: 2px;'>$vsong_bought_date $vsong_bought_time</i></small>

              <br>

              <small>$vsong_artist</small>
              <br>
              <span style='font-size: 85%;'><span>$vsong_downloads Downloads</span></span>
              <br>

              $bbtn
              </div>
              </div>

              </div>
              ";
            }
          }
          ?>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card">
        <?php
        if ($permission === 0) {
          echo "
          <div class='myrow'>
          <h5 style='color: red;'>Payment not received or is not enough!</h5>
          </div>";
        } elseif ($permission >= 1) {
          echo "
          <div class='myrow'>
          <h5 style='color: green;'>Payment received!</h5>
          </div>";
        }
        ?>
        <div class="myrow">
          <h5>Account Balance</h5>
          <?php
  //fetch vsongs_bought
          $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' ORDER BY vsong_bought_id DESC "); 
          $buyfetch = mysqli_fetch_assoc($buyquer);
          $totalSongs = mysqli_num_rows($buyquer)*20;
  //fetch cash
          $checkKopokopo = mysqli_query($con, "SELECT * FROM kopokopo WHERE sender_phone = '$phone' ORDER BY id DESC "); 
          if ($fetchKopokopo = mysqli_fetch_assoc($checkKopokopo)) {
            $extractKopokopo = extract($fetchKopokopo);
          }
          $checkKopokopoSum = mysqli_query($con, "SELECT SUM(amount) AS value_sum FROM kopokopo WHERE sender_phone = '$phone' "); 
          $fetchKopokopoSum = mysqli_fetch_assoc($checkKopokopoSum); 
          $totalCash = $fetchKopokopoSum['value_sum'];
          $balance = $totalCash-$totalSongs;
          $permission = intval($balance/20);
          echo "<h5 style='color: green;'>KES $balance</h5>";
          ?>
        </div>
      </div>
    </div>
    <div class="col-sm-1"></div>
  </div>

  <!-- Footer linked -->
  <?php include('footer.php'); ?>

</body>

</html>