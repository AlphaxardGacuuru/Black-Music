<?php
$user = $_COOKIE['username'];
if (empty($user)) {
  header('location: index.php');
}

//DB connection for all account info
include 'variables.php';
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
  <?php include 'topnav.php';?>

  <!-- post button -->
  <!-- show post button if user is a musician -->
  <?php
  if ($acc_type == "musician") {
    $fa_send = "<button id='floatBtn' data-toggle='modal' data-target='#myModal'><span style='font-size: 30px;' class='fa fa-pencil'></span></button>";
  } else {
    $fa_send = "";
  }

  echo $fa_send;
  ?>


  <!-- Modal for posting-->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <b>Post Publicly</b>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="contact-form form-group">
            <form action="home.php" method="POST">
              <img src="<?php echo $pp_path ?>" style="vertical-align: middle; width: 5%; height: 5%; border-radius: 50%;" alt="avatar">
              <label>
                <input type="text" name="text" class="form-control" placeholder="What's on your mind" required="">
              </label>
              <button type="submit" name="posty" class="mysonar-btn" onclick="Posted()">POST</button>
              <br>
              <!-- <a><span style="padding-left: 1%;" class="fa fa-align-left"></span></a> -->
              <br>
              <br>
              <h6>Poll</h6>
              <label>
                <input type='text' name='poll_1' class='form-control' placeholder='Parameter 1' oninput='inputPara2()' onkeypress='return AvoidSpace(event)'>
              </label>
              <label id='para-2'></label>
              <label id='para-3'></label>
              <label id='para-4'></label>
              <label id='para-5'></label>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal End -->

  <!-- PHP for inserting post into DB -->
  <?php
  if (isset($_POST['posty'])) {
    include 'variables.php';
    $date = date("d-M-Y");
    $time = date("h:ia");
    $text = mysqli_real_escape_string($con, $_POST['text']);
    //$text = $_POST['text'];
    //$text = str_replace("'","''",$text);
    if (!empty($_POST['poll_1'])) {
      $poll_1 = mysqli_real_escape_string($con, $_POST['poll_1']);
    } else {
      $poll_1 = "";
    }
    if (!empty($_POST['poll_2'])) {
      $poll_2 = mysqli_real_escape_string($con, $_POST['poll_2']);
    } else {
      $poll_2 = "";
    }
    if (!empty($_POST['poll_3'])) {
      $poll_3 = mysqli_real_escape_string($con, $_POST['poll_3']);
    } else {
      $poll_3 = "";
    }
    if (!empty($_POST['poll_4'])) {
      $poll_4 = mysqli_real_escape_string($con, $_POST['poll_4']);
    } else {
      $poll_4 = "";
    }
    if (!empty($_POST['poll_5'])) {
      $poll_5 = mysqli_real_escape_string($con, $_POST['poll_5']);
    } else {
      $poll_5 = "";
    }

    if (!$con) {
      echo "Failed to connect";
    } else {
      extract($_POST);
      $insertme = "INSERT INTO `posts` (`post_id`, `poster_id`, `post_text`, `parameter_1`, `parameter_2`, `parameter_3`, `parameter_4`, `parameter_5`, `post_time`, `post_date`) VALUES (NULL, '$user', '$text', '$poll_1', '$poll_2', '$poll_3', '$poll_4', '$poll_5', '$time', '$date')";
      $bibia = mysqli_query($con, $insertme);
      echo "<script>Posted();</script>";
    }
  }
  ?>
  <br>
  <br>
  <br class="hidden">

  <!-- Profile info area -->
  <div class="row">
    <div class="col-sm-1 hidden"></div>
    <div class="col-sm-3 hidden">
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
                include 'variables.php';
                $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' ");
                while ($row = mysqli_fetch_assoc($quer)) {
                  extract($row);
                  echo "<h5 style='padding: 0px 0px 0 0; margin: 0 0; width: 160px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$name
                  </h5>
                  <h6 style='padding: 0px 0px 0px 0px; margin: 0 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$username</small></h6>";
                }?>
                <span style='color: gold;' class='fa fa-circle-o'></span>
                <span style='font-size: 10px;'><?php echo $deco; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <b>Posts</b>
                <br>

                <?php
                include 'variables.php';
                if (mysqli_connect_errno()) {
                  echo "Failed to connect to MySQL: " . mysqli_connect_error();
                  /*you need to exit the script, if there is an error*/
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
              if ($acc_type == "musician") {
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
        <!-- Profile info area End -->
        <br>
        <!-- Musician suggestions area -->
        <div class="card">
          <table class="table table-hover">
            <tr>
              <th style="border: none;">
                <h2>Musicians to follow</h2>
              </th>
            </tr>

            <?php
            /*Get Account Ad*/
            $accad = mysqli_query($con, "SELECT * FROM acc_ads ORDER BY accad_id ASC LIMIT 1");
            while ($accad_fetch = mysqli_fetch_assoc($accad)) {
              extract($accad_fetch);
              $quer = mysqli_query($con, "SELECT * FROM users WHERE user_id = $accad_ref");
              $row = mysqli_fetch_assoc($quer);
              extract($row);
              $fb_quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user' AND followed = '$username'");
              $fb_fetch = mysqli_fetch_assoc($fb_quer);
              $as_quer = mysqli_query($con, "SELECT * FROM asongs_bought WHERE asong_buyer = '$user' AND asong_bought_artist = '$username'");
              $as_fetch = mysqli_fetch_assoc($as_quer);
              $vs_quer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought_artist = '$username'");
              $vs_fetch = mysqli_fetch_assoc($vs_quer);
              $firstdate = (time() - strtotime($accad_date)) / 86400;
              if ($firstdate >= 1) {
                mysqli_query($con, "DELETE FROM acc_ads WHERE accad_id = $accad_id");
                echo "<script>location.reload();</script>";
              }
              if (mysqli_num_rows($fb_quer) === 0) {
                if (mysqli_num_rows($as_quer) > 0 || mysqli_num_rows($vs_quer) > 0 || $user == "@blackmusic") {
                  $fbutton = "<a href='follows.php?username=$username'><button type='submit' style='float: right;' class='mysonar-btn'>follow</button></a>";
                } else {
                  $fbutton = "<a><button style='float: right;' class='mysonar-btn' onclick='checkerSnackbar()'>follow</button></a>";
                }
                if ($username != $user && $username != "@blackmusic") {
                  echo "
                  <tr>
                  <td>

                  <div class='media'>
                  <div class='media-left'>
                  <a href='musicianpage.php?username=$username'><img src='$pp_path' style='float: right; vertical-align: top; width: 30px; height: 30px; border-radius: 50%;' alt='avatar' ></a>
                  </div>
                  <div class='media-body'>
                  <b>$name</b>
                  <small><i>$username</i></small>
                  $fbutton

                  <br>
                  <small style='color: grey;'><i>promoted</i></small>
                  </div>
                  </div>

                  </td>
                  </tr>

                  <!-- The actual snackbar for following message -->
                  <div id='checker'>You must have bought atleast 1 song by that Musician</div>
                  ";
                }
              }
            }
            /*Get Account Ad End*/

            /*Get Accounts*/
            $quer = mysqli_query($con, "SELECT * FROM users WHERE acc_type = 'musician' ORDER BY username DESC");
            while ($row = mysqli_fetch_assoc($quer)) {
              extract($row);
              $fb_quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user' AND followed = '$username'");
              $fb_fetch = mysqli_fetch_assoc($fb_quer);
              $as_quer = mysqli_query($con, "SELECT * FROM asongs_bought WHERE asong_buyer = '$user' AND asong_bought_artist = '$username'");
              $as_fetch = mysqli_fetch_assoc($as_quer);
              $vs_quer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought_artist = '$username'");
              $vs_fetch = mysqli_fetch_assoc($vs_quer);
              if (mysqli_num_rows($fb_quer) === 0) {
                if (mysqli_num_rows($as_quer) > 0 || mysqli_num_rows($vs_quer) > 0 || $user == "@blackmusic") {
                  $fbutton = "<a href='follows.php?username=$username&from=home'><button type='submit' style='float: right;' class='mysonar-btn'>follow</button></a>";
                } else {
                  $fbutton = "<a><button style='float: right;' class='mysonar-btn' onclick='checkerSnackbar()'>follow</button></a>";
                }
              } else {
                $fbutton = "<a href='follows.php?username=$username&from=home'><button type='submit' style='float: right;' class='btn btn-sm btn-default'><b style='color: grey;'>Followed <span class='fa fa-check'></span></b></button></a>";
              }
              if ($username != $user && $username != "@blackmusic") {
                echo "
                <tr>
                <td>

                <div class='media'>
                <div class='media-left'>
                <a href='musicianpage.php?username=$username'><img src='$pp_path' style='float: right; vertical-align: top; width: 30px; height: 30px; border-radius: 50%;' alt='avatar' ></a>
                </div>
                <div class='media-body'>
                <b>$name</b>
                <small><i>$username</i></small>
                $fbutton
                </div>
                </div>

                </td>
                </tr>

                <!-- The actual snackbar for following message -->
                <div id='checker'>You must have bought atleast 1 song by that Musician</div>
                ";
              }
            }
            ?>

          </table>
        </div>
      </div>
      <!-- Musician suggestion area end -->

      <!-- Posts area -->
      <div class="col-sm-4">

        <div class="card">

          <!-- ****** Songs Area ****** -->
          <div class="myrow">
            <h5>Songs for you</h5>
            <div class="hidden-scroll">
              <?php
              /*Fetch Artist Ad*/
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
                  $bbtn = "<br><a href='vs_cart.php?vsong_id=$vsong_id&from=checkout' class='btn mysonar-btn green-btn' style='margin: 5px 0 0 0;'>buy</a>";
                } else {
                  $bbtn = "<button style='color: grey;' class='btn btn-sm btn-default'>
                  <b style='color: grey'>Owned <span class='fa fa-check'></span></b></button>";
                }
                if (mysqli_num_rows($cart_check) > 0) {
                  $cart = "<button style='color: grey; min-width: 90px;' class='btn btn-sm btn-default'>
                  <span class='fa fa-shopping-cart'></span></button>";
                } else {
                  if (mysqli_num_rows($buyquer) > 0) {
                    $cart = "";
                  } else {
                    $cart = "<a href='vs_cart.php?vsong_id=$vsong_id&from=home' style='min-width: 90px;' class='btn mysonar-btn'><span class='fa fa-shopping-cart'></span></a>";
                  }
                }
                if ($vsong_artist != $user && mysqli_num_rows($buyquer) == 0) {
                  echo "
                  <span style='border: 1px solid lightgrey; padding: 0 0 10px 0; border-radius: 10px;'>
                  <a href='play_video.php?vsong_id=$vsong_id'><img width='150px' height='auto' src='$v_album_art'></a>
                  <h6 style='padding: 10px 5px 0 5px; margin: 0px; width: 150px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$vsong_name</h6>
                  <h6 style='margin: 0px 5px 0px 5px; padding: 0px 5px 0px 5px;'><small>$vsong_artist $ft</small></h6>
                  <h6><small style='color: grey; margin: 0px 5px 0px 5px; padding: 0px 5px 0px 5px;'><i>Promoted</i></small></h6>

                  $cart
                  $bbtn

                  </span>
                  ";
                }
              }
              /*Fetch Artist Ad End*/

              /*Get songs for suggestion*/
              $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_artist != '$user' ORDER BY vsong_id DESC");
              while ($sfetch = mysqli_fetch_assoc($squer)) {
                extract($sfetch);
                $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought = $vsong_id");
                $buyfetch = mysqli_fetch_assoc($buyquer);
                /*Check if song is already in cart*/
                $cart_check = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_song = '$vsong_id' AND vs_cart_user = '$user'");
                $cart_check_quer = mysqli_fetch_assoc($cart_check);
                if (mysqli_num_rows($buyquer) === 0) {
                  $bbtn = "<br><a href='vs_cart.php?vsong_id=$vsong_id&from=checkout' class='btn mysonar-btn green-btn' style='margin: 5px 0 0 0;'>buy</a>";
                } else {
                  $bbtn = "<button style='color: grey;' class='btn btn-sm btn-default'>
                  <b style='color: grey'>Owned <span class='fa fa-check'></span></b></button>";
                }
                if (mysqli_num_rows($cart_check) > 0) {
                  $cart = "<button style='color: grey; min-width: 90px;' class='btn btn-sm btn-default'>
                  <span class='fa fa-shopping-cart'></span></button>";
                } else {
                  if (mysqli_num_rows($buyquer) > 0) {
                    $cart = "";
                  } else {
                    $cart = "<a href='vs_cart.php?vsong_id=$vsong_id&from=home' style='min-width: 90px;' class='btn mysonar-btn'><span class='fa fa-shopping-cart'></span></a>";
                  }
                }
                if (mysqli_num_rows($buyquer) == 0) {
                  echo "
                  <span style='border: 1px solid lightgrey; padding: 0.3rem 0.3rem 10px 0.3rem; border-radius: 10px;'>
                  <a href='play_video.php?vsong_id=$vsong_id'><img width='150px' height='auto' src='$v_album_art'></a>
                  <h6 style='padding: 10px 5px 0 5px; margin: 0px; width: 150px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$vsong_name</h6>
                  <h6 style='margin: 0px 5px 0px 5px; padding: 0px 5px 0px 5px;'><small>$vsong_artist $ft</small></h6>
                  <h6><small style='margin: 0px 5px 0px 5px; padding: 0px 5px 0px 5px;'>$vsong_downloads Downloads</small></h6>

                  $cart
                  $bbtn

                  </span>
                  ";
                }
              }
              ?>
            </div>
            <button id="myCheckOne" class="left mysonar-btn myScrollBtn hidden" style="float: left; left: -1rem;"><</button>
            <button id="myCheckTwo" class="right mysonar-btn myScrollBtn hidden" style="float: right; right: -1rem;">></button>
          </div>
          <!-- ****** Songs Area End ****** -->

          <?php
          /*Getting Ad*/
          $adquery = mysqli_query($con, "SELECT * FROM post_ads ORDER BY postad_id ASC LIMIT 1");
          if ($adfetch = mysqli_fetch_assoc($adquery)) {
            extract($adfetch);
            $postquer = mysqli_query($con, "SELECT * FROM posts WHERE post_id = '$postad_ref'");
            $postfetch = mysqli_fetch_assoc($postquer);
            extract($postfetch);
            $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$poster_id' ");
            $poster = mysqli_fetch_assoc($quer);
            extract($poster);
            /*Function to make time look better*/
            $posttime = postTimeFunction($post_time, $post_date);
            /*Get post loves*/
            $love_check = mysqli_query($con, "SELECT * FROM post_loves WHERE post_lover = '$user' AND loved_post = '$post_id'");
            $love_checker = mysqli_fetch_assoc($love_check);
            /*Check if user has followed poster*/
            $fol = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user'");
            $folpost = mysqli_fetch_assoc($fol);
            extract($folpost);
            $firstdate = (time() - strtotime($postad_date)) / 86400;
            if ($firstdate >= 1) {
              mysqli_query($con, "DELETE FROM post_ads WHERE postad_id = $postad_id");
              echo "<script>location.reload();</script>";
            }
            /*Changing love button*/
            if (mysqli_num_rows($love_check) === 0) {
              $heart = "<a href='post_loves.php?post_id=$post_id' class='fa fa-heart'></a>";
            } else {
              $heart = "<a href='post_loves.php?post_id=$post_id' class='fa fa-heart'style='color: #cc3300'></a>";
            }
            if ($username != $user) {
              echo "
              <div class='myrow'>
              <div class='media'>
              <div class='media-left'>
              <a href='musicianpage.php?username=$username'><img src='$pp_path' style='float: right; vertical-align: top; width: 40px; height: 40px; border-radius: 50%;' alt='avatar' ></a>
              </div>

              <div style='padding-left: 1%;' class='media-body'>
              <b class='media-heading'>$name</b>

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

              <span style='cursor: pointer; float: right; padding: 2%;' class='fa fa-ellipsis-v' data-toggle='dropdown'></span>

              <br>
              <small style='color: grey;'><i>promoted</i></small>

              </div>

              </div>
              </div>
              ";
            }
          }
          ?>

          <?php
          /*Get posts and order by latest*/
          $fetch = mysqli_query($con, "SELECT * FROM posts ORDER BY post_id DESC");
          while ($row = mysqli_fetch_assoc($fetch)) {
            extract($row);
            $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$poster_id' ");
            while ($poster = mysqli_fetch_assoc($quer)) {
              extract($poster);
              /*Function to make time look better*/
              $posttime = postTimeFunction($post_time, $post_date);
              /*Get post loves*/
              $love_check = mysqli_query($con, "SELECT * FROM post_loves WHERE post_lover = '$user' AND loved_post = '$post_id'");
              $love_checker = mysqli_fetch_assoc($love_check);
              /*Check if user has followed poster*/
              $fol = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user'");
              while ($folpost = mysqli_fetch_assoc($fol)) {
                extract($folpost);
                /*Show posts only from followed and unmuted guys*/
                if ($poster_id == $followed && $muted == "show") {
                //Changing love button
                  if (mysqli_num_rows($love_check) === 0) {
                    $heart = "<a href='post_loves.php?post_id=$post_id' class='fa fa-heart'></a>";
                  } else {
                    $heart = "<a href='post_loves.php?post_id=$post_id' class='fa fa-heart'style='color: #cc3300'></a>";
                  }
                  /*Changing mute link*/
                  if ($poster_id != "@blackmusic") {
                    $mute = "<a href='mute.php?username=$username'><h6>Mute</h6></a>";
                  } else {
                    $mute = "";
                  }
                  /*Changing unfollow link*/
                  if ($poster_id != $user && $poster_id != "@blackmusic") {
                    $unfol = "<a href='follows.php?username=$username'><h6>Unfollow $poster_id</h6></a>";
                  } else {
                    $unfol = "";
                  }
                //Changing delete link
                  if ($poster_id == $user) {
                    $del = "<a href='delete.php?from=home&post_id=$post_id'><h6>Delete post</h6></a>";
                  } else {
                    $del = "";
                  }
                //Check total number of votes
                  $poll_check_2 = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id'");
                  $poll_check_fetch_2 = mysqli_fetch_assoc($poll_check_2);
                  $poll_time = (time() - strtotime("$post_time " . "$post_date")) / 3600;
                  if ($poster_id == $user || $poll_time > 24) {
                    $votes = mysqli_num_rows($poll_check_2);
                  } else {
                    $votes = "ongoing...";
                  }
                //Checking if user has voted
                //Get polls
                  $poll = mysqli_query($con, "SELECT * FROM polls WHERE voter = '$user' AND post_ref = '$post_id'");
                  $poll_fetch = mysqli_fetch_assoc($poll);

                //Making the polls look better when they appear
                //Check if there's parameter 1
                  if (!empty($parameter_1)) {
                    //Check number of votes for each paramater
                    $poll_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND parameter = '$parameter_1'");
                    $poll_check_fetch = mysqli_fetch_assoc($poll_check);
                    $poll_time = (time() - strtotime("$post_time " . "$post_date")) / 3600;
                    if ($poster_id == $user || $poll_time > 24) {
                      $votes_2 = ": " . mysqli_num_rows($poll_check);
                    } else {
                      $votes_2 = "";
                    }
                    //Check if user already voted and change the vote button accordingly
                    if (mysqli_num_rows($poll) === 0 && $poll_time < 24) {
                      $vote_button = "<a href='polls.php?post_id=$post_id&parameter_1=$parameter_1' style='float: right;'><button style='height: 20px; font-size: 10px; line-height: 10px;' class='mysonar-btn'>vote</button></a>";
                    } else {
                        //Check if user has voted for this parameter in particular and change vote button accordingly
                      $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_1'");
                      $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
                      if (mysqli_num_rows($poll_para_check) == 1 && $poll_time < 24) {
                        $vote_button = "<a href='polls.php?post_id=$post_id&parameter_1=$parameter_1' style='float: right;'><button style='float: right; height: 20px; font-size: 10px; line-height: 10px;' class='btn btn-sm btn-default'><b style='color: grey'>voted <span class='fa fa-check'></span></b></button></a>";
                      } else {
                        $vote_button = "";
                      }
                    }
                    //Condition to show user's vote after poll expiry
                    $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_1'");
                    $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
                    if (mysqli_num_rows($poll_para_check) == 1 && $poll_time > 24) {
                      $your_vote = "<i style='color: grey;'>your vote</i>";
                    } else {
                      $your_vote = "";
                    }
                    $parameter_1 = "<br><b style='color: orange;'>Poll</b><br>" . $parameter_1 . "<small style='color: orange;'>$votes_2 $your_vote</small> $vote_button<br>";
                    $total_votes = "<small><i style='color: grey;''>Total votes:$votes</i></small>";
                  } else {
                    $parameter_1 = "";
                    $total_votes = "";

                    //Check if there's parameter 2
                  }
                  if (!empty($parameter_2)) {
                    //Check number of votes for each paramater
                    $poll_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND parameter = '$parameter_2'");
                    $poll_check_fetch = mysqli_fetch_assoc($poll_check);
                    $poll_time = (time() - strtotime("$post_time " . "$post_date")) / 3600;
                    if ($poster_id == $user || $poll_time > 24) {
                      $votes_2 = ": " . mysqli_num_rows($poll_check);
                    } else {
                      $votes_2 = "";
                    }
                    //Check if user already voted and change the love button accordingly
                    if (mysqli_num_rows($poll) === 0 && $poll_time < 24) {
                      $vote_button = "<button style='height: 20px; font-size: 10px; line-height: 10px;' class='mysonar-btn'>vote</button>";
                    } else {
                        //Check if user has voted for this parameter in particular and change vote button accordinlgy
                      $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_2'");
                      $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
                      if (mysqli_num_rows($poll_para_check) == 1 && $poll_time < 24) {
                        $vote_button = "<a href='polls.php?post_id=$post_id&parameter_2=$parameter_2' style='float: right;'><button style='float: right; height: 20px; font-size: 10px; line-height: 10px;' class='btn btn-sm btn-default'><b style='color: grey'>voted <span class='fa fa-check'></span></b></button></a>";
                      } else {
                        $vote_button = "";
                      }
                    }
                    //Condition to show user's vote after poll expiry
                    $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_2'");
                    $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
                    if (mysqli_num_rows($poll_para_check) == 1 && $poll_time > 24) {
                      $your_vote = "<i style='color: grey;'>your vote</i>";
                    } else {
                      $your_vote = "";
                    }
                    $parameter_2 = $parameter_2 . "<small style='color: orange;'>$votes_2</small> <a href='polls.php?post_id=$post_id&parameter_2=$parameter_2' style='float: right;'>$vote_button</a><br>";
                    $total_votes = "<small><i style='color: grey;''>Total votes:$votes</i></small>";
                  } else {
                    $parameter_2 = "";
                    $$total_votes = "";

                    //Check if there's parameter 3
                  }
                  if (!empty($parameter_3)) {
                    //Check number of votes for each paramater
                    $poll_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND parameter = '$parameter_3'");
                    $poll_check_fetch = mysqli_fetch_assoc($poll_check);
                    $poll_time = (time() - strtotime("$post_time " . "$post_date")) / 3600;
                    if ($poster_id == $user || $poll_time > 24) {
                      $votes_2 = ": " . mysqli_num_rows($poll_check);
                    } else {
                      $votes_2 = "";
                    }
                    //Check if user already voted and change the love button accordingly
                    if (mysqli_num_rows($poll) === 0 && $poll_time < 24) {
                      $vote_button = "<button style='height: 20px; font-size: 10px; line-height: 10px;' class='mysonar-btn'>vote</button>";
                    } else {
                        //Check if user has voted for this parameter in particular and change vote button accordinlgy
                      $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_3'");
                      $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
                      if (mysqli_num_rows($poll_para_check) == 1 && $poll_time < 24) {
                        $vote_button = "<a href='polls.php?post_id=$post_id&parameter_3=$parameter_3' style='float: right;'><button style='float: right; height: 20px; font-size: 10px; line-height: 10px;' class='btn btn-sm btn-default'><b style='color: grey'>voted <span class='fa fa-check'></span></b></button></a>";
                      } else {
                        $vote_button = "";
                      }
                    }
                    //Condition to show user's vote after poll expiry
                    $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_3'");
                    $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
                    if (mysqli_num_rows($poll_para_check) == 1 && $poll_time > 24) {
                      $your_vote = "<i style='color: grey;'>your vote</i>";
                    } else {
                      $your_vote = "";
                    }
                    $parameter_3 = $parameter_3 . "<small style='color: orange;'>$votes_2</small> <a href='polls.php?post_id=$post_id&parameter_3=$parameter_3' style='float: right;'>$vote_button</a><br>";
                    $total_votes = "<small><i style='color: grey;''>Total votes:$votes</i></small>";
                  } else {
                    $parameter_3 = "";
                    $$total_votes = "";

                    //Check if there's parameter 4
                  }
                  if (!empty($parameter_4)) {
                    //Check number of votes for each paramater
                    $poll_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND parameter = '$parameter_4'");
                    $poll_check_fetch = mysqli_fetch_assoc($poll_check);
                    $poll_time = (time() - strtotime("$post_time " . "$post_date")) / 3600;
                    if ($poster_id == $user || $poll_time > 24) {
                      $votes_2 = ": " . mysqli_num_rows($poll_check);
                    } else {
                      $votes_2 = "";
                    }
                    //Check if user already voted and change the love button accordingly
                    if (mysqli_num_rows($poll) === 0 && $poll_time < 24) {
                      $vote_button = "<button style='height: 20px; font-size: 10px; line-height: 10px;' class='mysonar-btn'>vote</button>";
                    } else {
                        //Check if user has voted for this parameter in particular and change vote button accordinlgy
                      $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_4'");
                      $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
                      if (mysqli_num_rows($poll_para_check) == 1 && $poll_time < 24) {
                        $vote_button = "<a href='polls.php?post_id=$post_id&parameter_4=$parameter_4' style='float: right;'><button style='float: right; height: 20px; font-size: 10px; line-height: 10px;' class='btn btn-sm btn-default'><b style='color: grey'>voted <span class='fa fa-check'></span></b></button></a>";
                      } else {
                        $vote_button = "";
                      }
                    }
                    //Condition to show user's vote after poll expiry
                    $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_4'");
                    $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
                    if (mysqli_num_rows($poll_para_check) == 1 && $poll_time > 24) {
                      $your_vote = "<i style='color: grey;'>your vote</i>";
                    } else {
                      $your_vote = "";
                    }
                    $parameter_4 = $parameter_4 . "<small style='color: orange;'>$votes_2</small> <a href='polls.php?post_id=$post_id&parameter_4=$parameter_4' style='float: right;'>$vote_button</a><br>";
                    $total_votes = "<small><i style='color: grey;''>Total votes:$votes</i></small>";
                  } else {
                    $parameter_4 = "";
                    $$total_votes = "";

                    //Check if there's parameter 5
                  }
                  if (!empty($parameter_5)) {
                    //Check number of votes for each paramater
                    $poll_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND parameter = '$parameter_5'");
                    $poll_check_fetch = mysqli_fetch_assoc($poll_check);
                    $poll_time = (time() - strtotime("$post_time " . "$post_date")) / 3600;
                    if ($poster_id == $user || $poll_time > 24) {
                      $votes_2 = ": " . mysqli_num_rows($poll_check);
                    } else {
                      $votes_2 = "";
                    }
                    //Check if user already voted and change the love button accordingly
                    if (mysqli_num_rows($poll) === 0 && $poll_time < 24) {
                      $vote_button = "<button style='height: 20px; font-size: 10px; line-height: 10px;' class='mysonar-btn'>vote</button>";
                    } else {
                        //Check if user has voted for this parameter in particular and change vote button accordinlgy
                      $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_5'");
                      $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
                      if (mysqli_num_rows($poll_para_check) == 1 && $poll_time < 24) {
                        $vote_button = "<a href='polls.php?post_id=$post_id&parameter_5=$parameter_5' style='float: right;'><button style='float: right; height: 20px; font-size: 10px; line-height: 10px;' class='btn btn-sm btn-default'><b style='color: grey'>voted <span class='fa fa-check'></span></b></button></a>";
                      } else {
                        $vote_button = "";
                      }
                    }
                    //Condition to show user's vote after poll expiry
                    $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_5'");
                    $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
                    if (mysqli_num_rows($poll_para_check) == 1 && $poll_time > 24) {
                      $your_vote = "<i style='color: grey;'>your vote</i>";
                    } else {
                      $your_vote = "";
                    }
                    $parameter_5 = $parameter_5 . "<small style='color: orange;'>$votes_2</small> <a href='polls.php?post_id=$post_id&parameter_5=$parameter_5' style='float: right;'>$vote_button</a><br>";
                    $total_votes = "<small><i style='color: grey;''>Total votes:$votes</i></small>";
                  } else {
                    $parameter_5 = "";
                    $total_votes = "";
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

                  $parameter_1
                  $parameter_2
                  $parameter_3
                  $parameter_4
                  $parameter_5
                  $total_votes

                  <span style='cursor: pointer; float: right; padding: 5%;' class='w3dropup'>
                  <span class='fa fa-ellipsis-v'></span>
                  <span class='w3dropup-content'>
                  $mute
                  $unfol
                  $del
                  </span>
                  </span>

                  </div>

                  </div>
                  </div>
                  ";
                }
              }
            }
          }
          ?>
        </div>
      </div>
      <!-- Posts area end -->

      <!-- Song suggestion area -->
      <div class="col-sm-3 hidden">
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
              <div class='media-left'>
              <a href='play_video.php?vsong_id=$vsong_id'>
              <img width='150px' height='auto' src='$v_album_art'>
              </a>
              </div>

              <div class='media-body'>
              <h6 style='padding: 0px 0px 0 0; margin: 0 0; width: 160px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$vsong_name
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

          /*Get songs for suggestion*/
          $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_artist != '$user'");
          while ($sfetch = mysqli_fetch_assoc($squer)) {
            extract($sfetch);
            $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought = $vsong_id");
            $buyfetch = mysqli_fetch_assoc($buyquer);
            /*Check if song is already in cart*/
            $cart_check = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_song = '$vsong_id' AND vs_cart_user = '$user'");
            $cart_check_quer = mysqli_fetch_assoc($cart_check);
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
            if (mysqli_num_rows($buyquer) == 0) {
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
              <h6><small>$vsong_downloads Downloads</small></h6>

              $cart
              $bbtn

              </div>
              </div>

              </div>
              ";
            }
          }
          ?>
        </div>
        <!-- End of Song Suggestion Area -->

      </div>
      <div class="col-sm-1"></div>
    </div>

    <!-- Footer linked -->
    <?php include 'footer.php';?>

  </body>

  </html>