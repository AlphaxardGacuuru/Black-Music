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
           <img src='<?php echo $pp_path; ?>' style='vertical-align: top; width: 100px; height: 100px; border-radius: 50%;' alt='avatar'>
         </a>
       </td>
       <td style="border: none;">
        <span>

         <?php
         include('variables.php');
         $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' ");
         while ($row = mysqli_fetch_assoc($quer)) {
          extract($row);
          echo "<h5 style='padding: 0px 0px 0 0; margin: 0 0; width: 160px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$name
          </h5>
          <h6 style='padding: 0px 0px 0px 0px; margin: 0 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$username</small></h6>";
        } ?>
        <span style='color: gold;' class='fa fa-circle-o'></span>
        <span style='font-size: 10px;'><?php echo $deco; ?></span>
      </td>
    </tr>
    <tr>
     <td>
      <b>Posts</b>
      <br>

      <?php
      include('variables.php');
      if (mysqli_connect_errno())
      {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    //you need to exit the script, if there is an error
        exit();
      }
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
    <b>Fans</b>
    <br>

    $fans

    </td>";
  }?>
</tr>
</table>
</div>
</div>
<!-- Profile info area End -->

<!-- Fans area -->
<div class="col-sm-4">
 <div class="card">
  <table class="table">
    <?php
            //Fetch Fans from DB
    $quer = mysqli_query($con, "SELECT * FROM follows WHERE followed = '$user' ");
    while ($fetch = mysqli_fetch_assoc($quer)) {
      extract($fetch);
      $f_quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$follower' ");
      while ($poster = mysqli_fetch_assoc($f_quer)) {
        extract($poster);
        if ($follower!=$user) {
          echo "
          <tr>            
          <td>
          <div class='media'>
          <div class='media-left'>
          <a href='fanpage.php?follower=$follower'>
          <img src='$pp_path' style='float: right; vertical-align: top; width: 30px; height: 30px; border-radius: 50%;' alt='avatar'>
          </a>
          </div>
          <div class='media-body'>
          <b class='media-heading'>$name</b><small><i> $username</i></small>  	
          <span style='font-size: 10px; color: gold;' class='fa fa-circle-o'></span><span style='padding-left: 5px; font-size: 10px;'>$deco</span>
          </div>
          </div>
          </td>   
          </tr>
          ";
        }
      }} ?>
    </table>
  </div>
  <div class="col-sm-3"></div>
  <div class="col-sm-1"></div>
</div>
</div>

<!-- Footer linked -->
<?php include('footer.php'); ?>

</body>
</html>