<?php
if (isset($_COOKIE['username'])) {
  $user = $_COOKIE['username'];
} else {
  $user = "";
}

if (isset($_GET["vsong_id"])) {
  extract($_GET);
} 
if (isset($_GET["vs_cart_song"])) {
  extract($_GET);
  $vsong_id = $vs_cart_song;
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
if ($row = mysqli_fetch_assoc($quer)) {
  extract($row);
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

  <!-- Top Nav linked -->
  <?php include('topnav.php'); ?>

  <br>
  <br>
  <br class="hidden">

  <!-- Modal for Deactivating Account -->
  <div id="vidShareModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Share Song</h4>
          <button type="button" style="float: right;" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <center>
            <h5>Copy link</h5> 
            <h6><?php echo 'https://music.black.co.ke/play_video.php?vsong_id=$vsong_id&referrer=$user'; ?></h6>
          </center>
        </div>
        <div class="modal-footer">
        </div>
      </div>

    </div>
  </div>

  <!-- <button type="button" class="sonar-btn" data-toggle="modal" data-target="#vidShareModal">share</button> -->

  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-7">
      <div class="card">
        <div class="resp-container">
          <?php
        //Check if song is already in cart
          $cart_check = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_song = '$vsong_id' AND vs_cart_user = '$user'");
          $cart_check_quer = mysqli_fetch_assoc($cart_check);
        //Get song and it's info
          $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_id = $vsong_id");
          $sfetch = mysqli_fetch_assoc($squer);
          extract($sfetch);
                      //Check if User has already bought song
          $vidquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought = $vsong_id");
          $vidfetch = mysqli_fetch_assoc($vidquer);
                      //Check if User has loved song
          $vidlove_quer = mysqli_query($con, "SELECT * FROM video_loves WHERE loved_video = $vsong_id AND video_lover = '$user'");
          if ($vidlovechecker = mysqli_fetch_assoc($vidlove_quer)) {
            $vidheart = "<span style='color: #cc3300;' class='fa fa-heart'></span>";
          } else {
            $vidheart = "<span class='fa fa-heart'></span>";
          }
                      //Change buy and love button
          if (mysqli_num_rows($vidquer)===1 || $vsong_artist == $user || $user == "@blackmusic") {
            $bbtn = "<button style='float: right; color: grey;' class='btn btn-sm btn-default'>
            <b style='color: grey'>Owned <span class='fa fa-check'></span></b></button>";

            $love_share = "<a href='whatsapp://send?text=https://music.black.co.ke/play_video.php?vsong_id=$vsong_id&referrer=$user' data-action='share/whatsapp/share' style='font-size: 15px; float: right;'><span class='fa fa-share'></span></a>
            <a href='post_loves.php?vsong_id=$vsong_id' style='font-size: 15px; float: right; margin-right: 20px;'>$vidheart
            <small>$vsong_loves</small></a>";
          } else {
            $bbtn = "<a href='vs_cart.php?from=checkout&vsong_id=$vsong_id'><button style='float: right;' class='mysonar-btn green-btn'>buy</button></a>";
            $love_share ="<span style='margin-left: 10%; float:right;'><span class='fa fa-heart'></span> <small>$vsong_loves</small></span>";
          }
          if (mysqli_num_rows($cart_check)>0) {
            if (!empty($user)) {
              $cart = "<button style='color: grey; float: right;' class='btn btn-sm btn-default'>
              <b style='color: grey'>Added to cart</b></button>";
            } else {
              $cart = "<a href='signup.php?from=play_video&vsong_id=$vsong_id' style='float: right;'><button class='mysonar-btn green-btn'>kes 20</button></a>";
            }
          } else {
            if (mysqli_num_rows($vidquer)>0) {
              $cart = "<button style='float: right; color: grey;' class='btn btn-sm btn-default'>
              <b style='color: grey'>Owned <span class='fa fa-check'></span></b></button>";
            } else {
              $cart = "<a href='vs_cart.php?from=play_video&vsong_id=$vsong_id' style='float: right;'><button class='mysonar-btn green-btn'>kes 20</button></a>";
            }
          }
                      //If user has bought song show video
          if (mysqli_num_rows($vidquer)===1 || $vsong_artist == $user || $user == "@blackmusic") {
            echo "
            <iframe class='resp-iframe' width='880px' height='495px' src='$vsong?autoplay=1' frameborder='0' allow='accelerometer'; encrypted-media; gyroscope; picture-in-picture; allowfullscreen></iframe>
            ";
          } else { 
            echo"
            <iframe class='resp-iframe' width='880px' height='495px' src='$vsong?autoplay=1&end=10&controls=0' frameborder='0' allow='accelerometer'; encrypted-media; gyroscope; picture-in-picture; allowfullscreen></iframe>
            ";
          }
          ?>
        </div>
        <div class="myrow">
          <?php echo "
          $love_share
          <h6 style='padding: 0px 0px 0px 0px; margin: 0 0; width: 200px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>Song Name</small> $vsong_name</h6>
          <small>Downloads</small> $vsong_downloads<br>
          <small>Album</small> $vsong_album<br>
          <small>Genre</small> $vgenre<br>
          <small>Posted</small> $vsong_date
          $bbtn";
          ?>
        </div>
        <div class="myrow">
          <?php
          $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$vsong_artist' ");
          if ($row = mysqli_fetch_assoc($quer)) {
           extract($row);
           $fb_quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user' AND followed = '$vsong_artist'");
           $fb_fetch = mysqli_fetch_assoc($fb_quer);
           $as_quer = mysqli_query($con, "SELECT * FROM asongs_bought WHERE asong_buyer = '$user' AND asong_bought_artist = '$vsong_artist'");
           $as_fetch = mysqli_fetch_assoc($as_quer);
           $vs_quer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought_artist = '$vsong_artist'");
           $vs_fetch = mysqli_fetch_assoc($vs_quer);
           if (mysqli_num_rows($fb_quer)===0) {
            if (mysqli_num_rows($as_quer)>0 || mysqli_num_rows($vs_quer)>0 || $user == "@blackmusic") {
              $fbutton = "<a href='follows.php?username=$username&from=play_video&vsong_id=$vsong_id'><button type='submit' style='float: right;' class='mysonar-btn'>follow</button></a>";
            } else {
              $fbutton = "<a><button style='float: right;' class='mysonar-btn' onclick='checkerSnackbar()'>follow</button></a>";
            }
          } else {
            if (!empty($user)) {
              $fbutton = "<a href='follows.php?username=$username&from=play_video&vsong_id=$vsong_id'><button type='submit' style='float: right;' class='btn btn-sm btn-default'><b style='color: grey;'>Followed <span class='fa fa-check'></span></b></button></a>";
            } else {
              $fbutton = "<a><button style='float: right;' class='mysonar-btn' onclick='checkerSnackbar()'>follow</button></a>";
            }
          }
          echo "
          <div class='media'>
          <div class='media-left'>
          <a href='musicianpage.php?username=$username'><img src='$pp_path' style='float: right; vertical-align: top; width: 40px; height: 40px; border-radius: 50%;' alt='avatar' ></a>
          </div>

          <div style='padding-left: 1%;' class='media-body'>
          <h6 style='padding: 0px 0px 0px 0px; margin: 0 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>
          <small>$name $vsong_artist</small>
          </h6>
          <span style='color: gold; padding-top: 10px;' class='fa fa-circle-o'></span>
          <small>$deco</small>
          <span style='font-size: 1rem;'>&#x2022;</span>
          <small>$fans fans</small>
          $fbutton
          </div>
          </div>

          <!-- The actual snackbar for following message -->
          <div id='checker'>You must have bought atleast 1 song by that Musician</div>
          ";
        }
        ?>
      </div>

      <!-- Read more section -->
      <div class="myrow">

        <!-- single accordian area -->
        <div class="panel single-accordion">
          <h6>
            <a role="button" class="collapsed" aria-expanded="true" aria-controls="collapseTwo" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">read more
              <span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
              <span class="accor-close"><i class="fa fa-minus" aria-hidden="true"></i></span>
            </a>
          </h6>
          <div id="collapseTwo" class="accordion-content collapse">
            <h6><?php echo $description; ?></h6>
          </div>
        </div>

      </div>

      <!-- Comment Form -->
      <div class="myrow">
        <div class="media">
          <div class="media-left">
            <?php
            if (!empty($user)) {
              echo "
              <img src='$pp_path' style='vertical-align: top; width: 30px; height: 30px; border-radius: 50%;' alt='avatar' >
              ";
            } else {
              echo "<img src='img/male_avatar.png' style='vertical-align: top; width: 30px; height: 30px; border-radius: 50%;' alt='avatar' >";
            }
            ?>
          </div>
          <div class="media-body">
            <div class="contact-form form-group">

              <?php
                          //Posting comments for videos to DB
              $video_textErr = "";
              if (isset($_POST['video_posty'])) {
                include('variables.php');
                $date = date("d-M-Y");
                $time = date("h:ia");
                if (mysqli_num_rows($vidquer)===1 || $vsong_artist == $user || $user == "@blackmusic") {
                  $video_text = mysqli_real_escape_string($con, $_POST['video_text']);
                  if (!$con) {
                    echo "Failed to connect";
                  } else {
                    extract($_POST);
                    $insertme = "INSERT INTO `video_posts` (`video_post_id`, `video_post_ref`, `video_poster_id`, `video_post_text`, `video_post_time`, `video_post_date`) VALUES (NULL, '$vsong_id', '$user', '$video_text', '$time', '$date')";
                    $bibia = mysqli_query($con, $insertme);
                  }
                } else {
                  $video_textErr = "You can't comment on this song since you haven't bought it!";
                }
              }
              ?>
              <form action="play_video.php?vsong_id=<?php echo $vsong_id;?>" method="POST">
                <small class="error"><?php echo $video_textErr; ?></small>
                <input type="text" style="width: 100%;" name="video_text" class="form-control" placeholder="Comment on Song" required>
                <br>
                <button type="submit" style="float: right;" class="mysonar-btn" name="video_posty">COMMENT</button>
              </form>
            </div>
          </div>
        </div>

      </div>
      <!-- End of Comment Form -->

      <!-- Comment Section -->
      <?php
      if (mysqli_num_rows($vidquer)===1 || $vsong_artist == $user) {
        include('variables.php');
        $fetch = mysqli_query($con, "SELECT * FROM video_posts WHERE video_post_ref = $vsong_id ORDER BY video_post_id DESC");
        while ($row = mysqli_fetch_assoc($fetch)) {
          extract($row);
          $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$video_poster_id' ");
          while ($poster = mysqli_fetch_assoc($quer)) {
            extract($poster);
            $video_posttime = postTimeFunction($video_post_time, $video_post_date);
            $love_check = mysqli_query($con, "SELECT * FROM video_post_loves WHERE video_post_lover = '$user' AND loved_video_post = '$video_post_id'");
            $love_checker = mysqli_fetch_assoc($love_check);
            if (mysqli_num_rows($love_check)===0) {
              $heart = "<a href='post_loves.php?video_post_id=$video_post_id' onclick='mySnackbar()' class='fa fa-heart'></a>";
            } else {
              $heart = "<a href='post_loves.php?video_post_id=$video_post_id' class='fa fa-heart' style='color: #cc3300'></a>";
            }
            if ($video_poster_id == $user) {
              $del = "<a href='delete.php?from=play_video&video_post_id=$video_post_id&vsong_id=$vsong_id'><h6>Delete post</h6></a>";
            } else {
              $del = "";
            }
            echo "
            <div class='myrow'>
            <div class='media'>
            <div class='media-left'>
            <img src='$pp_path' style='float: right; vertical-align: top; width: 30px; height: 30px; border-radius: 50%;' alt='avatar' >
            </div>

            <div style='padding-left: 1%;' class='media-body'>
            <b class='media-heading'>$name</b>
            <span style='color: gold; padding-top: 10px;' class='fa fa-circle-o'></span>
            <span style='font-size: 10px;'>$deco</span>

            <small>
            <i style='float: right; padding-right: 2px;'>$video_posttime</i>
            <br>

            <i>$video_poster_id</i>
            </small>

            <div>$video_post_text</div>

            <br>
            $heart 

            <small>$video_post_numloves</small>

            <span style='cursor: pointer; float: right; padding: 1%;' class='w3dropup'>
            <span class='fa fa-ellipsis-v'></span>
            <span class='w3dropup-content' style='right: 10px; bottom: 30px;'>
            $del
            </span>
            </span>

            </div>

            </div>
            </div>
            ";
          }
        }
      } ?>
      <!-- End of Comment Section -->
    </div>
  </div>

  <div class="col-sm-3">
    <div class="card">
      <div class='myrow'>
        Up Next
      </div>
      <?php
          //get recently bought songs
      $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' "); 
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
          if ($_GET['vsong_id'] != $vsong_id) {
            echo "
            <div class='myrow'>

            <div class='media'>
            <div class='media-left'>
            <a href='play_video.php?vsong_id=$vsong_id'>
            <img width='150px' height='auto' src='$v_album_art'>
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

            </div>
            ";
          }
        }
      }
      ?>
    </div>

    <br>
    <br>


    <!-- Song suggestion area -->
    <div class="card">
      <div class="myrow"><b>Songs to watch</b></div>
      <?php
      /*Fetch song Ad*/
      $vsongad_check = mysqli_query($con, "SELECT * FROM vsong_ads ORDER BY vsongad_id ASC LIMIT 1");
      while ($vsongad_check_quer = mysqli_fetch_assoc($vsongad_check)) {
        extract($vsongad_check_quer);
        $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_id = '$vsongad_ref'");
        $sfetch = mysqli_fetch_assoc($squer);
        extract($sfetch);
        $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought = $vsong_id");
        $buyfetch = mysqli_fetch_assoc($buyquer);
        /*Check if song is already in cart*/
        $cart_check = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_song = '$vsong_id' AND vs_cart_user = '$user'");
        $cart_check_quer = mysqli_fetch_assoc($cart_check);
        $firstdate = (time() - strtotime($vsongad_date)) / 86400;
        if ($firstdate >= 1) {
          mysqli_query($con, "DELETE FROM vsong_ads WHERE vsongad_id = $vsongad_id");
          echo "<script>location.reload();</script>";
        }
        if (mysqli_num_rows($buyquer) === 0) {
          $bbtn = "<a href='vs_cart.php?vsong_id=$vsong_id&from=checkout' class='btn mysonar-btn green-btn' style='float: right;'>buy</a>";
        } else {
          $bbtn = "<a style='color: grey; float: right;' class='btn btn-sm btn-default'>
          <b style='color: grey'>Owned <span class='fa fa-check'></span></b></a>";
        }
        if (mysqli_num_rows($cart_check) > 0) {
          $cart = "<a style='color: grey; min-width: 50px;' class='btn btn-sm btn-default'>
          <span class='fa fa-shopping-cart'></span></a>";
        } else {
          if (mysqli_num_rows($buyquer) > 0) {
            $cart = "";
          } else {
            $cart = "<a href='vs_cart.php?vsong_id=$vsong_id&from=home' style='min-width: 50px; float: left; margin' class='btn mysonar-btn'><span class='fa fa-shopping-cart'></span></a>";
          }
        }
        if ($vsong_artist != $user && mysqli_num_rows($buyquer) == 0) {
          echo "
          <div class='myrow'>
          <div class='media'>
          <div class='media-left' style='padding: 0rem 0.5rem 0rem 0rem;'>
          <a href='play_video.php?vsong_id=$vsong_id'>
          <img src='$v_album_art' width='160rem' height='90rem'>
          </a>
          </div>

          <div class='media-body'>
          <h6 style='padding: 0px 0px 0 0; margin: 0 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$vsong_name
          </h6>
          <h6 style='padding: 0px 0px 0px 0px; margin: 0 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$vsong_artist $ft</small></h6>
          <small style='color: grey;'><i>promoted</i></small>
          <br>

          $cart
          $bbtn

          </div>
          </div>

          </div>
          ";
        }
      }
      /*Fetch song Ad End*/

    //Get songs for suggestion
      //check if cookie is set
      if (!empty($user)) {
        $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_artist != '$user'");
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
            $cart = "<a href='vs_cart.php?from=play_video&vsong_id=$vsong_id' style='min-width: 50px; float: left; margin' class='btn mysonar-btn'><span class='fa fa-shopping-cart'></span></a>";
          }
        }
        if (mysqli_num_rows($buyquer)==0) {
          echo "
          <div class='myrow'>

          <div class='media'>
          <div class='media-left' style='padding: 0rem 0.5rem 0rem 0rem;'>
          <a href='play_video.php?vsong_id=$vsong_id'>
          <img width='150px' height='auto' src='$v_album_art'>
          </a>
          </div>

          <div class='media-body'>
          <h6 style='padding: 0px 0px 0 0; margin: 0 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$vsong_name
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
    }
    ?>
  </div>
  <!-- End of Song Suggestion Area -->
</div>
<div class="col-sm-1"></div>
</div>

<!-- Footer linked -->
<?php include('footer.php'); ?>

</body>
</html>