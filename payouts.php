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
    <div class="col-sm-1"></div>
    <div class="col-sm-11">
      <h1 style="text-align: center;">Song Payouts</h1>
      <br>
      <table class="table table-responsive table-hover">
        <tr>
          <th>Name</th>
          <th>Artist</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Minimum</th>
          <th>Amount</th>
        </tr>
        <?php
        $getArtists = mysqli_query($con, "SELECT * FROM users WHERE acc_type = 'musician' ");
        while ($fetchArtists = mysqli_fetch_assoc($getArtists)) {
          extract($fetchArtists);
          $checkBought = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_bought_artist = '$username' ");
          $fetchBought = mysqli_fetch_assoc($checkBought);
          $sum = mysqli_num_rows($checkBought)*10;
          $payoutQuer = mysqli_query($con, "SELECT SUM(payout_amount) AS value_sum FROM payouts WHERE payout_artist = '$username' ");
          $payoutFetch = mysqli_fetch_assoc($payoutQuer);
          $payoutSum = $payoutFetch["value_sum"];
          $payoutTotal = $sum-$payoutSum;
          $phonenumber = substr_replace($phone,'0',0,-9);
          if(preg_match( '/^(\d{4})(\d{3})(\d{3})$/', $phonenumber, $matches)) {
            $phone = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3];
          }
          if ($payoutTotal != 0) {
            echo "
            <tr>
            <td>$name</td>
            <td>$username</td>
            <td>$phone</td>
            <td>$email</td>
            <td>$withdrawal</td>
            <td>
            <a href='admin_actions.php?spayout_artist=$username&payout_amount=$payoutTotal'>
            <button class='btn mysonar-btn green-btn'>kes $payoutTotal</button>
            </a>
            </td>
            </tr>
            ";
          }
        }
        ?>
      </table>
      <br>
      <br>
      <h1 style="text-align: center;">Referral Payouts</h1>
      <table class="table table-responsive table-hover">
        <tr>
          <th>Name</th>
          <th>User</th>
          <th>Phone</th>
          <th>Email</th>
          <td><h6 style='color: dodgerblue;'>LEVEL-1</h6></td>
          <td><h6 style='color: dodgerblue;'>LEVEL-2</h6></td>
          <td><h6 style='color: dodgerblue;'>LEVEL-3</h6></td>
          <td><h6 style='color: dodgerblue;'>LEVEL-4</h6></td>
          <th>Amount</th>
        </tr>
        <?php
        $getUsers = mysqli_query($con, "SELECT * FROM users ");
        while ($fetchUsers = mysqli_fetch_assoc($getUsers)) {
          extract($fetchUsers);
        $oneTotal = $twoTotal = $threeTotal = $fourTotal = 0;
          $inviteQuer = mysqli_query($con, "SELECT * FROM referrals WHERE referrer = '$username' ");
          while ($inviteFetch = mysqli_fetch_assoc($inviteQuer)) {
            extract($inviteFetch);
            $oneQuer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$referee' ");
            $oneFetch = mysqli_fetch_assoc($oneQuer);
            $vsongsTotal = mysqli_num_rows($oneQuer);
            $oneRevenue = $vsongsTotal*1;
            $oneTotal += $oneRevenue;
            $twoQuer = mysqli_query($con, "SELECT * FROM referrals WHERE referrer = '$referee' ");
            while ($twoFetch = mysqli_fetch_assoc($twoQuer)) {
              extract($twoFetch);
              $vsongQuer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$referee' ");
              $vsongFetch = mysqli_fetch_assoc($vsongQuer);
              $vsongsTotal = mysqli_num_rows($vsongQuer);
              $twoRevenue = $vsongsTotal*0.5;
              $twoTotal += $twoRevenue;
              $threeQuer = mysqli_query($con, "SELECT * FROM referrals WHERE referrer = '$referee' ");
              while ($threeFetch = mysqli_fetch_assoc($threeQuer)) {
                extract($threeFetch);
                $vsongQuer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$referee' ");
                $vsongFetch = mysqli_fetch_assoc($vsongQuer);
                $vsongsTotal = mysqli_num_rows($vsongQuer);
                $threeRevenue = $vsongsTotal*0.25;
                $threeTotal += $threeRevenue;
                $fourQuer = mysqli_query($con, "SELECT * FROM referrals WHERE referrer = '$referee' ");
                while ($fourFetch = mysqli_fetch_assoc($fourQuer)) {
                  extract($fourFetch);
                  $vsongQuer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$referee' ");
                  $vsongFetch = mysqli_fetch_assoc($vsongQuer);
                  $vsongsTotal = mysqli_num_rows($vsongQuer);
                  $fourRevenue = $vsongsTotal*0.125;
                  $fourTotal += $fourRevenue;
                }
              }
            }
          }
          $totalRevenue = $oneTotal + $twoTotal + $threeTotal + $fourTotal;
          $rpayoutQuer = mysqli_query($con, "SELECT SUM(rpayout_amount) AS amount_sum FROM rpayouts WHERE rpayout_username = '$username' ");
          $rpayoutFetch = mysqli_fetch_assoc($rpayoutQuer);
          $rpayoutSum = $rpayoutFetch["amount_sum"];
          $rpayoutTotal = $totalRevenue-$rpayoutSum;
          $phonenumber = substr_replace($phone,'0',0,-9);
          if(preg_match( '/^(\d{4})(\d{3})(\d{3})$/', $phonenumber, $matches)) {
            $phone = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3];
          }
          if ($rpayoutTotal != 0) {
          echo "
          <tr>
          <td>$name</td>
          <td>$username</td> 
          <td>$phone</td>  
          <td>$email</td> 
          <td style='color: green;'>$oneTotal</td>
          <td style='color: green;'>$twoTotal</td>
          <td style='color: green;'>$threeTotal</td>
          <td style='color: green;'>$fourTotal</td>
          <td><a href='admin_actions.php?rPayoutUsername=$username&rPayoutAmount=$rpayoutTotal'><button class='mysonar-btn green-btn'>KES $rpayoutTotal</button></a></td>
          </tr>";
          }
        }
        ?>
      </table>
    </div>
  </div>

  <!-- Footer linked -->
  <?php include('footer.php'); ?>

</body>

</html>