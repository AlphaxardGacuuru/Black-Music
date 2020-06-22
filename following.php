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
  <br>
  <br>

  <!-- Profile info area -->
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-3">
     <div class="card">
       <table class="table table-hover">
         <tr>
           <td style="border: none;">
             <a href='profile.php'>
               <img src='<?php echo $pp_path; ?>' style='vertical-align: top; width: 100px; height: 100px; border-radius: 50%;' alt='avatar' class='avatar'>
             </a>
           </td>
           <td style="border: none;">
            <span style="font-size: 30px;">

              <?php
              $username = $_COOKIE['username'];
              $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' ");
              while ($row = mysqli_fetch_assoc($quer)) {
                extract($row);
                echo "<a href='profile.php'>$name</a>";
              } ?>

            </span>
            <br>
            <i><?php echo $username; ?></i>
            <br>
            <span style='color: gold; padding-top: 10px;' class='fa fa-circle-o'></span>
            <span style='padding-left: 10px; font-size: 10px;'><?php echo $deco; ?></span>
          </td>
        </tr>
        <tr>
          <td>
            <b>Posts</b>
            <br>

            <?php
            $user = $_COOKIE['username'];
            $quer = mysqli_query($con, "SELECT * FROM posts WHERE poster_id = '$user' ");
            while ($poster = mysqli_fetch_assoc($quer)) {
              extract($poster);
            }
            echo mysqli_num_rows($quer);
            ?>

          </td>
          <?php 
          if ($acc_type=="musician") {
            echo "
            <td style='color: purple;'>
            <a href='fans.php'>
            <b>Fans</b>
            <br>

            $fans

            </a>
            </td>";
          }?>
        </tr>
      </table>
    </div>
  </div>
  <!-- Profile info area End -->

  <!-- Following Area -->
  <div class="col-sm-4">
    <div class="card">
      <table class="table table-hover">
        <?php
                      //Fetch Fans from DB
        $quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user'");
        while ($fetch = mysqli_fetch_assoc($quer)) {
          extract($fetch);
          $f_quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$followed' ");
          while ($poster = mysqli_fetch_assoc($f_quer)) {
            extract($poster);
            if ($muted == "show") {
              $mute = "<a style='color: black;' href='mute.php?username=$username' class='dropdown-item'><h6>Mute</h6></a>";
            } else {
              $mute = "<a style='color: black;' href='mute.php?username=$username' class='dropdown-item'><h6>Unmute</h6></a>";
            }
            if ($username != $user && $username != "@blackmusic") {
              echo "
              <tr>            
              <td>
              <div class='media'>
              <div class='media-left'>
              <img src='$pp_path' style='float: right; vertical-align: top; width: 30px; height: 30px; border-radius: 50%;' alt='avatar' class='avatar'>
              </div>
              <div class='media-body'>
              <b class='media-heading'>$name</b><small><i> $username</i></small>    
              <span style='font-size: 10px; color: gold;' class='fa fa-circle-o'></span><span style='padding-left: 5px; font-size: 10px;'>$deco</span>

              <a href='follows.php?username=$username' style='border-color: purple;' class='btn btn-sm btn-default'><b style='color: purple;'>Unfollow </b></a>

              <span class='dropup'>
              <span style='cursor: pointer; float: right;' class='fa fa-ellipsis-v' data-toggle='dropdown'></span>

              <ul class='dropdown-menu dropdown-menu-right'>
              <table class='table table-hover'>
              $mute
              </table>
              </ul>
              </span> 

              </div>
              </div>
              </td>   
              </tr>
              ";
            }
          }
        } ?>
      </table>
    </div>
  </div>
  <!-- Following Area End -->

  <div class="col-sm-3"></div>
  <div class="col-sm-1"></div>
</div>

<!-- Footer linked -->
<?php include('footer.php'); ?>

</body>
</html>