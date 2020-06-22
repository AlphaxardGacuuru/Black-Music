<?php
$user = $_COOKIE['username'];
if (empty($user)) {
  header('location: index.php');
}
include('variables.php');
//from follows notification
if (isset($_GET['fn_follower'])) {
  extract($_GET);
  $profiler = $fn_follower;
  mysqli_query($con, "DELETE FROM f_notifies WHERE fn_follower = '$fn_follower'");
}

//from fans
if (isset($_GET["follower"])) {
  extract($_GET);
  $profiler = $follower;
}

//from buys notification
if (isset($_GET['vsn_buyer'])) {
  extract($_GET);
  $profiler = $vsn_buyer;
  mysqli_query($con, "DELETE FROM vs_notifies WHERE vsn_buyer = '$vsn_buyer'");
}

//Function for displaying dynamic post time
function postTimeFunction($sysdate1, $sysdate2)
{
  $sysdate = "$sysdate1 " . "$sysdate2";
  $date = time() - strtotime($sysdate);
  if ($date < 120) {
    $newdate = "Just now";
    return $newdate;
  } elseif ($date < 3600) {
    $newdate = ceil($date / 60) . " mins ago";
    return $newdate;
  } elseif ($date < 86400) {
    $newdate = ceil($date / 3600) . " hrs ago";
    return $newdate;
  } elseif ($date < 172800) {
    $newdate = "Yesterday";
    return $newdate;
  } elseif ($date < 63072000) {
    $newdate_0 = strtotime($sysdate2);
    $newdate = date("j-M-Y", $newdate_0);
    return $newdate;
  } else {
    $newdate_0 = strtotime($sysdate2);
    $newdate = date("j-M-Y", $newdate_0);
    return $newdate;
  }
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

  <!-- Profile pic area -->
  <br>
  <br>
  <br class="hidden">
  <div class="row" style="background-image: url('img/headphones.jpg'); background-position: center; background-size: cover; position: relative; height: 90%;">
    <div class="col-sm-12" style="padding: 0px;">
      <br>
      <br class="hidden">
      <div>
        <div style="margin-top: 100px; top: 80px; left: 10px;" class="avatar-container">
          <?php
          $mquer = mysqli_query($con, "SELECT * FROM users WHERE username = '$profiler'");
          $mrow = mysqli_fetch_assoc($mquer);
          extract($mrow);?>
          <img style="position: absolute; z-index: 99;" class="avatar hover-img" src="<?php echo $pp_path; ?>" alt="Avatar" />
          <div class="overlay"></div>
          <!-- <a href="#"><button class="edit-button mysonar-btn" data-toggle='modal' data-target='#ppModal'> EDIT </button></a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- End of Profile pic area -->

  <!-- Profile area -->
  <br class="anti-hidden">
  <br class="anti-hidden">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-3">
      <div class="card">
        <table class="table">
          <tr>
            <td style="border: none;"><b>Posts</b><br>
              <?php
              $user = $_COOKIE['username'];
              $quer = mysqli_query($con, "SELECT * FROM posts WHERE poster_id = '$profiler' ");
              while ($poster = mysqli_fetch_assoc($quer)) {
                extract($poster);
              }
              echo mysqli_num_rows($quer);

              ?>
            </td>
            <td style="border: none;">
              <b>Following</b>
              <br>
                <?php
                $user = $_COOKIE['username'];
                $quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$profiler' ");
                while ($poster = mysqli_fetch_assoc($quer)) {
                  extract($poster);
                }
                echo mysqli_num_rows($quer)-1;
                ?>
            </td>
            <?php 
            if ($acc_type=="musician") {
              $followers_num = mysqli_query($con, "SELECT * FROM follows WHERE followed = '$profiler' ");
              while ($followers_num_fetch = mysqli_fetch_assoc($followers_num)) {
                extract($followers_num_fetch);
              }
              $num_followers = mysqli_num_rows($followers_num)-1;
              echo "
              <td style='color: purple; border: none;'><b>Fans</b><br>
              $num_followers
              </td>";
            }?>
          </tr>
          <?php
          $username = $_COOKIE['username'];
          $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$profiler' ");
          $row = mysqli_fetch_assoc($quer);
          extract($row);
          ?>
          <tr>
            <td colspan="4" style="border: none;"><small>Name </small><span><?php echo $name; ?></span></td>
          </tr>
          <tr>
            <td><small>Username </small><span><?php echo $username; ?></span></td>
          </tr>
          <tr>
            <td><span style='color: gold;' class='fa fa-circle-o'></span><span style='padding-left: 10px;'><?php echo $deco; ?></span></td>
          </tr>
          <tr>
            <td colspan='4'><span class='fa fa-intersex'></span><span style='padding-left: 10px;'><?php echo $gender; ?></span></td>
          </tr>
          <tr>
            <td><small>Bio </small><span><?php echo $bio;?></span></td>
          </tr>
          <td colspan='4'><span class='fa fa-birthday-cake'></span><span style='padding-left: 10px;'>Birthday <?php echo $dob; ?></span></td>
        </tr>
        <tr>
          <td colspan='4'><span class='fa fa-map-marker'></span><span style='padding-left: 10px;'><?php echo $location; ?></span></td>
        </tr>
        <tr>
          <td colspan='4'><span class='fa fa-calendar'></span><span style='padding-left: 10px;'>Joined <?php echo $date_joined; ?></span></td>
        </tr>
      </table>
    </div>
  </div>
  <!-- End of Profile area -->

  <!-- Posts area -->
  <div class="col-sm-4">
  </div>
  <!-- Posts area end -->

  <!-- About section -->

  <div class="col-sm-3">
  </div>

  <!-- Footer linked -->
  <?php include('footer.php'); ?>

</body>
</html>
