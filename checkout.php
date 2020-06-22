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
  <br>
  <br class="hidden">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-3">
      <div class="card">
        <div class='myrow'>
          <a style='color: purple;' href='#'><h5>Your Cart</h5></a>
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
          <h6 style='padding: 0px 0px 0 0; margin: 0 0; width: 160px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$vs_cart_songname</h6>
          <h6 style='padding: 0px 0px 0px 0px; margin: 0 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$vs_cart_songartist</small></h6>
          <br>
          <a href='cart_delete.php?from=checkout&vs_cart_id=$vs_cart_id' style='float: left;'>
          <span class='fa fa-trash'></span>
          </a>
          <h6 style='float: right; color: green;'>KES 20</h6>
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
        <table class="table">
          <tr>
            <th colspan="2" style="border-top: none;"><h5>Cart Total</h5></th>
          </tr>
          <tr>
            <td>Songs</td>
            <td><?php echo $cart_count; ?></td>
          </tr>
          <tr style="color: green;">
            <td>TOTAL</td>
            <td>KES <?php $total = $cart_count*20; echo $total; ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card">
        <div class="myrow">
          <h5>Payment</h5>
        </div>
        <div class="contact-form form-group">
          <center>
            <label><input type='text' class='form-control' value='613289' id='myInput'></label><br>
            <button class='btn sonar-btn' onclick='copyText()'>copy till number</button>
          </center>
        </div>
        <?php
        if (!empty($phone)) {
          $phone = substr_replace($phone, "0", 0, -9);
          echo "
          <div class='myrow'>
          <center>
          <h5>Ensure you pay with <h4 style='color: dodgerblue;'>$phone!</h4></h5>
          <h5>Go to Mpesa on your phone</h5>
          <h5>Lipa na Mpesa</h5>
          <h5>Buy Goods and Services</h5>
          <h5>Mpesa Till No:</h5>
          <h3 id='myInput' style='color: green;'>613289
          </h3>
          <h5 style='color: green;'>HAVI Lab Equipment</h5>
          <h5>Amount: KES <b style='color: green;'>$total</b></h5>
          <h5>Proceed to receipt after recieving Mpesa confirmation message</h5>
          <a href='reciept.php'><button class='btn mysonar-btn'>reciept</button></a>
          </center>
          </div>
          ";
        } else {
          echo "
          <div class='myrow'>
          <center>
          <h4 class='error'>Phone number empty!</h4>  
          <h5>Please update it to a <b style='color: green;'>Safaricom Number</b> and make sure it is the same number you use for every transaction in Black Music.</h5>
          <a href='settings.php'><button class='btn sonar-btn'>update phone number</button></a>
          </div>
          ";
        }
        ?>

      </div>
    </div>
    <div class="col-sm-1"></div>
  </div>

  <!-- Footer linked -->
  <?php include('footer.php'); ?>

</body>

</html>