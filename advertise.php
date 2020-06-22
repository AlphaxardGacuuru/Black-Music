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

  <!-- Modal for Advert-->
  <div id="adModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

     <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header">
       <b>Post Advert</b>
       <button type="button" class="close" data-dismiss="modal">&times;</button>
     </div>
     <div class="modal-body">
      <div class="contact-form form-group">
       <form action="studio.php" method="POST">
        <img src="<?php echo $pp ?>" style="vertical-align: middle; width: 5%; height: 5%; border-radius: 50%;" alt="avatar" class="avatar">
        <label><input type="text" name="ad-text" class="form-control" placeholder="What's on your mind"></label>
        <br>
        <br>
        <b>Add image</b>
        <br>
        <br>
        <label><input type="file" name="ad-image" class="form-control"></label>
        <br>
        <button type="submit" name="ad-post" style="float: right;" class="mysonar-btn" onclick="Posted()">POST</button>
      </form>
    </div>
  </div>
</div>
</div>
</div>
<!-- Modal End -->

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
    <div class="col-sm-12">
      <div class="contact-form text-center call-to-action-content wow fadeInUp" data-wow-delay="0.5s">
        <h1>Promote Account</h1>
        <br>
        <?php
          //Get queue position
        $accad_queue = mysqli_query($con, "SELECT * FROM acc_ads ORDER BY accad_id ASC");
        if ($accadq_fetch = mysqli_fetch_assoc($accad_queue)) {
         extract($accadq_fetch);
         $first = $accad_id;
       }
       $aquer = mysqli_query($con, "SELECT * FROM users WHERE username = '$user'");
       $afetch = mysqli_fetch_assoc($aquer);
       extract($afetch);
         //Check if song is already promoted
       $accad_check = mysqli_query($con, "SELECT * FROM acc_ads WHERE accad_ref = '$user_id'");
       if ($accad_check_quer = mysqli_fetch_assoc($accad_check)) {
         extract($accad_check_quer);
       }
       if (mysqli_num_rows($accad_check)!=0) {
        $queue = $accad_id-$first+1;
        if ($queue == 1) {
          $queue = "<i>Live</i>";
        }
      } else {
        $queue = "";
      }
      if (mysqli_num_rows($accad_check)===0) {
        $bbtn = "<a href='ads.php?user_id=$user_id'><button class='sonar-btn'>promote</button></a>";
      } else {
        $bbtn = "<button style='color: grey;' class='btn btn-lg btn-default'>
        <small style='color: grey'>Promoted <br> $queue <span class='fa fa-check'></span></small></button>";
      }
      echo "
      $bbtn ";
      ?>

      <br>
      <br>
      <br>
      <br>
    </div>
  </div>
</div>

<!-- Promote post -->
<div class="row">
<div class="col-sm-1"></div>
  <div class="col-sm-4">
    <div class="wow fadeInUp" data-wow-delay="0.5s">
      <!-- Ad Button  -->
      <h1>Promote post</h1>
      <br>
      <br>
      <div class="card">
        <table>
         <?php
               //Get queue position
         $postad_queue = mysqli_query($con, "SELECT * FROM post_ads ORDER BY postad_id ASC");
         if ($postadq_fetch = mysqli_fetch_assoc($postad_queue)) {
           extract($postadq_fetch);
           $first = $postad_id;
         }
               //Get posts
         $fetch = mysqli_query($con, "SELECT * FROM posts WHERE poster_id = '$user' ORDER BY post_id DESC");
         while ($row = mysqli_fetch_assoc($fetch)) {
           extract($row);
                 //Get account info
           $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$poster_id' ");
           while ($poster = mysqli_fetch_assoc($quer)) {
            extract($poster);
            $posttime = postTimeFunction($post_time, $post_date);
                  //Get loves
            $love_check = mysqli_query($con, "SELECT * FROM post_loves WHERE post_lover = '$user' AND loved_post = '$post_id'");
            $love_checker = mysqli_fetch_assoc($love_check);
                  //Check if song is already promoted
            $postad_check = mysqli_query($con, "SELECT * FROM post_ads WHERE postad_ref = '$post_id'");
            if ($postad_check_quer = mysqli_fetch_assoc($postad_check)) {
             extract($postad_check_quer);
           }
           if (mysqli_num_rows($postad_check)!=0) {
            $queue = $postad_id-$first+1;
            if ($queue == 1) {
              $queue = "<i>Live</i>";
            }
          } else {
            $queue = "";
          }
          if (mysqli_num_rows($postad_check)===0) {
            $bbtn = "<a href='ads.php?post_id=$post_id'><button style='float: right;' class='mysonar-btn'>promote</button></a>";
          } else {
            $bbtn = "<button style='color: grey; float: right;' class='btn btn-sm btn-default'>
            <b style='color: grey'>Promoted $queue <span class='fa fa-check'></span></b></button>";
          }
          if (mysqli_num_rows($love_check)===0) {
            $heart = "<a href='post_loves.php?post_id=$post_id' class='fa fa-heart'></a>";
          } else {
            $heart = "<a href='post_loves.php?post_id=$post_id' class='fa fa-heart'style='color: #cc3300'></a>";
          }
          echo "
          <div class='myrow'>
          <div class='media'>
          <div class='media-left'>
          <a href='musicianpage.php?username=$username'><img src='$pp_path' style='float: right; vertical-align: top; width: 40px; height: 40px; border-radius: 50%;' alt='avatar' ></a>
          </div>

          <div style='padding-left: 1%;' class='media-body'>
          <b class='media-heading'>$name</b>
          <span style='color: gold; padding-top: 10px;' class='fa fa-circle-o'></span>
          <span style='font-size: 10px;'>$deco</span>

          <small>
          <i style='float: right; padding-right: 2px;'>$posttime</i>
          <br>

          <i>$poster_id</i>
          </small>

          <div>$post_text</div>

          <br>
          $heart

          <small>$post_numloves</small>

          <a style='padding-left: 20%;' href='commenting.php?post_id=$post_id' class='fa fa-comment'></a>

          <small>$post_numcomments</small>
          <br>
$bbtn
          </div>

          </div>
          </div>
          ";
        }
      }
      ?>
    </table>
  </div>
  <br>
  <br>
  <br>
</div>
</div>
<div class="col-sm-1"></div>

<!-- Promote Song -->
<div class="col-sm-6">
  <div class="contact-form text-center call-to-action-content wow fadeInUp" data-wow-delay="0.5s">
    <h1 style="float: left;">Promote Song</h1>
    <br>
    <br>
    <br>
    <table class="table table-hover table-responsive">
      <tr>
        <th>Song Name</th>
        <th>Song Downloads</th>
        <th>Advert Position</th>
        <th></th>
      </tr>
      <?php
                //Get queue position
      $vsongad_queue = mysqli_query($con, "SELECT * FROM vsong_ads ORDER BY vsongad_id ASC");
      if ($vsongadq_fetch = mysqli_fetch_assoc($vsongad_queue)) {
       extract($vsongadq_fetch);
       $first = $vsongad_id;
     }
     $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_artist = '$user'");
     while ($sfetch = mysqli_fetch_assoc($squer)) {
       extract($sfetch);
               //Check if song is already promoted
       $vsongad_check = mysqli_query($con, "SELECT * FROM vsong_ads WHERE vsongad_ref = '$vsong_id'");
       if ($vsongad_check_quer = mysqli_fetch_assoc($vsongad_check)) {
         extract($vsongad_check_quer);
       }
       if (mysqli_num_rows($vsongad_check)===0) {
        $bbtn = "<a href='ads.php?vsong_id=$vsong_id'><button class='mysonar-btn'>promote</button></a>";
      } else {
        $bbtn = "<button style='float: right; color: grey;' class='btn btn-sm btn-default'>
        <b style='color: grey'>Promoted <span class='fa fa-check'></span></b></button>";
      }
      if (mysqli_num_rows($vsongad_check)!=0) {
        $queue = $vsongad_id-$first+1;
        if ($queue == 1) {
          $queue = "<i>Live</i>";
        }
      } else {
        $queue = "";
      }
      echo "
      <tr>
      <td>$vsong_name</td>
      <td><span style='font-size: 85%;'><span>$vsong_downloads</span></span></td>
      <td>$queue</td>
      <td>$bbtn</td>
      </tr>";
    }
    ?>
  </table>
  <!-- End of Song Suggestion Area -->

</div>
</div>
</div>
</div>

<!-- Footer linked -->
<?php include('footer.php'); ?>

</body>

</html>