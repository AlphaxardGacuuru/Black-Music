<?php
$user = $_COOKIE['username'];
if (empty($user)) {
  header('location: index.php');
}

//If link is from deco notification
if (isset($_GET['dn_from'])) {
  extract($_GET);
  $musician = $dn_from;
  include('variables.php');
  mysqli_query($con, "DELETE FROM deco_notifies WHERE dn_from = '$dn_from' AND dn_to = '$user'");
}

//If link is from musician image 
if (isset($_GET['username'])) {
  extract($_GET);
  $musician = $username;
}

// If link is from Black Music notification
if (isset($_GET['bmn_id'])) {
  extract($_GET);
  include('variables.php');
  mysqli_query($con, "DELETE FROM bm_notifies WHERE bmn_id = '$bmn_id'");
}

// getting musician name when followed
if (isset($_GET['musician'])) {
  extract($_GET);
  $musician = $musician;
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
        <div style="margin-top: 100px; top: 100px; left: 10px;" class="avatar-container">
          <?php
          $mquer = mysqli_query($con, "SELECT * FROM users WHERE username = '$musician'");
          $mrow = mysqli_fetch_assoc($mquer);
          extract($mrow);?>
          <img style="position: absolute; z-index: 99;" class="avatar hover-img" src="<?php echo $pp_path; ?>" alt="Avatar">
          <div class="overlay"></div>
          <!-- <a href="#"><button class="edit-button mysonar-btn" data-toggle='modal' data-target='#ppModal'> EDIT </button></a> -->
        </div>
        <?php
        $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$musician' ");
        if ($row = mysqli_fetch_assoc($quer)) {
         extract($row);
         $fb_quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user' AND followed = '$musician'");
         $fb_fetch = mysqli_fetch_assoc($fb_quer);
         $as_quer = mysqli_query($con, "SELECT * FROM asongs_bought WHERE asong_buyer = '$user' AND asong_bought_artist = '$musician'");
         $as_fetch = mysqli_fetch_assoc($as_quer);
         $vs_quer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought_artist = '$musician'");
         $vs_fetch = mysqli_fetch_assoc($vs_quer);
         if (mysqli_num_rows($fb_quer)===0) {
          if (mysqli_num_rows($as_quer)>0 || mysqli_num_rows($vs_quer)>0 || $user == "@blackmusic") {
            $fbutton = "<a href='follows.php?username=$username&from=musicianpage&musician=$musician'><button type='submit' class='mysonar-btn'>follow</button></a>";
          } else {
            $fbutton = "<a><button class='mysonar-btn' onclick='checkerSnackbar()'>follow</button></a>";
          }
        } else {
          $fbutton = "<a href='follows.php?username=$username&from=musicianpage&musician=$musician'><button type='submit' class='btn btn-sm btn-default'><b style='color: grey;'>Followed <span class='fa fa-check'></span></b></button></a>";
        }
        if ($username != $user && $username != "@blackmusic") {
          echo "<span style='margin-right: 10px; float: right;'>$fbutton</span>

          <!-- The actual snackbar for following message -->
          <div id='checker'>You must have bought atleast 1 song by that Musician</div>";
        }
      }
      ?>
    }
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
          <td style="border: none;"><b>Posts</b>
            <br>
            <?php
            $quer = mysqli_query($con_2, "SELECT * FROM posts WHERE poster_id = '$musician' ");
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
            $quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$musician' ");
            while ($poster = mysqli_fetch_assoc($quer)) {
              extract($poster);
            }
            echo mysqli_num_rows($quer)-1;
            ?>
          </a>
        </td>
        <td style='color: purple; border: none;'><b>Followers</b>
          <br>
          <?php 
          $followers_num = mysqli_query($con, "SELECT * FROM follows WHERE followed = '$musician' ");
          while ($followers_num_fetch = mysqli_fetch_assoc($followers_num)) {
            extract($followers_num_fetch);
          }
          $num_followers = mysqli_num_rows($followers_num)-1;
          echo "
          $num_followers
          </td>";
          ?>
        </tr>
        <?php
        $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$musician' ");
        $row = mysqli_fetch_assoc($quer);
        extract($row);
        ?>
        <tr>
          <td colspan="3" style="border: none;"><small>Name </small><span><?php echo $name; ?></span></td>
        </tr>
        <tr>
          <td colspan="3"><small>Username </small><span><?php echo $username; ?></span></td>
        </tr>
        <tr>
          <td><span style='color: gold;' class='fa fa-circle-o'></span><span style='padding-left: 10px;'><?php echo $deco; ?></span></td>
        </tr>
        <tr>
          <td colspan='3'><span class='fa fa-intersex'></span><span style='padding-left: 10px;'><?php echo $gender; ?></span></td>
        </tr>
        <tr>
          <td><small>Bio </small><span><?php echo $bio;?></span></td>
        </tr>
        <td colspan='3'><span class='fa fa-birthday-cake'></span><span style='padding-left: 10px;'>Birthday <?php echo $dob; ?></span></td>
      </tr>
      <tr>
        <td colspan='3'><span class='fa fa-map-marker'></span><span style='padding-left: 10px;'><?php echo $location; ?></span></td>
      </tr>
      <tr>
        <td colspan='3'><span class='fa fa-calendar'></span><span style='padding-left: 10px;'>Joined <?php echo $date_joined;?></span></td>
      </tr>
    </table>
  </div>
</div>
<!-- End of Profile area -->

<!-- Posts area -->
<div class="col-sm-4">
  <div class="card">

    <?php
 //Get posts and order by latest
    $fetch = mysqli_query($con, "SELECT * FROM posts WHERE poster_id = '$musician' ORDER BY post_id DESC");
    while ($row = mysqli_fetch_assoc($fetch)) {
     extract($row);
     $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$poster_id' ");
     while ($poster = mysqli_fetch_assoc($quer)) {
      extract($poster);
    //Function to make time look better
      $posttime = postTimeFunction($post_time, $post_date);
    //Get post loves
      $love_check = mysqli_query($con, "SELECT * FROM post_loves WHERE post_lover = '$user' AND loved_post = '$post_id'");
      $love_checker = mysqli_fetch_assoc($love_check);
    //Check if user has followed poster
      $fol = mysqli_query($con, "SELECT * FROM follows WHERE followed = '$musician'");
      while ($folpost = mysqli_fetch_assoc($fol)) {
        extract($folpost);
      //Show posts only from followed and unmuted guys
        if ($poster_id == $followed && $muted == "show" && $follower == $user) {
        //Changing love button
          if (mysqli_num_rows($love_check)===0) {
            $heart = "<a href='post_loves.php?post_id=$post_id' class='fa fa-heart'></a>";
          } else {
            $heart = "<a href='post_loves.php?post_id=$post_id' class='fa fa-heart'style='color: #cc3300'></a>";
          }
        //Changing unfollow link
          if ($poster_id!=$user && $poster_id!="@blackcampus") {
            $unfol = "<a href='follows.php?username=$username' class='dropdown-item'><h6>Unfollow $poster_id</h6></a>";
          } else {
            $unfol = "";
          }
        //Changing delete link
          if ($poster_id == $user) {
            $del = "<a href='delete.php?post_id=$post_id' class='dropdown-item'><h6>Delete post</h6></a>";
          } else {
            $del = "";
          }
          //Check total number of votes
          $poll_check_2 = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id'");
          $poll_check_fetch_2 = mysqli_fetch_assoc($poll_check_2);
          $poll_time = (time() - strtotime("$post_time " . "$post_date"))/3600;
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
            $poll_time = (time() - strtotime("$post_time " . "$post_date"))/3600;
            if ($poster_id == $user || $poll_time > 24) {
              $votes_2 = ": " . mysqli_num_rows($poll_check);
            } else {
              $votes_2 = "";
            }
            //Check if user already voted and change the vote button accordingly
            if (mysqli_num_rows($poll)===0 && $poll_time < 24) {
              $vote_button = "<a href='polls.php?post_id=$post_id&parameter_1=$parameter_1' style='float: right;'><button style='height: 20px; font-size: 10px; line-height: 10px;' class='mysonar-btn'>vote</button></a>";
            } else {
          //Check if user has voted for this parameter in particular and change vote button accordingly
              $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_1'");
              $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
              if (mysqli_num_rows($poll_para_check)==1 && $poll_time < 24) {
                $vote_button = "<a href='polls.php?post_id=$post_id&parameter_1=$parameter_1' style='float: right;'><button style='float: right; height: 20px; font-size: 10px; line-height: 10px;' class='btn btn-sm btn-default'><b style='color: grey'>voted <span class='fa fa-check'></span></b></button></a>";
              } else {
                $vote_button = "";
              }
            }
            //Condition to show user's vote after poll expiry
            $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_1'");
            $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
            if (mysqli_num_rows($poll_para_check)==1 && $poll_time > 24) {
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
          } if (!empty($parameter_2)) {
          //Check number of votes for each paramater
            $poll_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND parameter = '$parameter_2'");
            $poll_check_fetch = mysqli_fetch_assoc($poll_check);
            $poll_time = (time() - strtotime("$post_time " . "$post_date"))/3600;
            if ($poster_id == $user || $poll_time > 24) {
              $votes_2 = ": " . mysqli_num_rows($poll_check);
            } else {
              $votes_2 = "";
            }
            //Check if user already voted and change the love button accordingly
            if (mysqli_num_rows($poll)===0 && $poll_time < 24) {
              $vote_button = "<button style='height: 20px; font-size: 10px; line-height: 10px;' class='mysonar-btn'>vote</button>";
            } else {
          //Check if user has voted for this parameter in particular and change vote button accordinlgy
              $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_2'");
              $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
              if (mysqli_num_rows($poll_para_check)==1 && $poll_time < 24) {
                $vote_button = "<a href='polls.php?post_id=$post_id&parameter_2=$parameter_2' style='float: right;'><button style='float: right; height: 20px; font-size: 10px; line-height: 10px;' class='btn btn-sm btn-default'><b style='color: grey'>voted <span class='fa fa-check'></span></b></button></a>";
              } else {
                $vote_button = "";
              }
            }
            //Condition to show user's vote after poll expiry
            $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_2'");
            $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
            if (mysqli_num_rows($poll_para_check)==1 && $poll_time > 24) {
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
          } if (!empty($parameter_3)) {
          //Check number of votes for each paramater
            $poll_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND parameter = '$parameter_3'");
            $poll_check_fetch = mysqli_fetch_assoc($poll_check);
            $poll_time = (time() - strtotime("$post_time " . "$post_date"))/3600;
            if ($poster_id == $user || $poll_time > 24) {
              $votes_2 = ": " . mysqli_num_rows($poll_check);
            } else {
              $votes_2 = "";
            }
            //Check if user already voted and change the love button accordingly
            if (mysqli_num_rows($poll)===0 && $poll_time < 24) {
              $vote_button = "<button style='height: 20px; font-size: 10px; line-height: 10px;' class='mysonar-btn'>vote</button>";
            } else {
          //Check if user has voted for this parameter in particular and change vote button accordinlgy
              $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_3'");
              $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
              if (mysqli_num_rows($poll_para_check)==1 && $poll_time < 24) {
                $vote_button = "<a href='polls.php?post_id=$post_id&parameter_3=$parameter_3' style='float: right;'><button style='float: right; height: 20px; font-size: 10px; line-height: 10px;' class='btn btn-sm btn-default'><b style='color: grey'>voted <span class='fa fa-check'></span></b></button></a>";
              } else {
                $vote_button = "";
              }
            }
            //Condition to show user's vote after poll expiry
            $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_3'");
            $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
            if (mysqli_num_rows($poll_para_check)==1 && $poll_time > 24) {
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
          } if (!empty($parameter_4)) {
          //Check number of votes for each paramater
            $poll_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND parameter = '$parameter_4'");
            $poll_check_fetch = mysqli_fetch_assoc($poll_check);
            $poll_time = (time() - strtotime("$post_time " . "$post_date"))/3600;
            if ($poster_id == $user || $poll_time > 24) {
              $votes_2 = ": " . mysqli_num_rows($poll_check);
            } else {
              $votes_2 = "";
            }
            //Check if user already voted and change the love button accordingly
            if (mysqli_num_rows($poll)===0 && $poll_time < 24) {
              $vote_button = "<button style='height: 20px; font-size: 10px; line-height: 10px;' class='mysonar-btn'>vote</button>";
            } else {
          //Check if user has voted for this parameter in particular and change vote button accordinlgy
              $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_4'");
              $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
              if (mysqli_num_rows($poll_para_check)==1 && $poll_time < 24) {
                $vote_button = "<a href='polls.php?post_id=$post_id&parameter_4=$parameter_4' style='float: right;'><button style='float: right; height: 20px; font-size: 10px; line-height: 10px;' class='btn btn-sm btn-default'><b style='color: grey'>voted <span class='fa fa-check'></span></b></button></a>";
              } else {
                $vote_button = "";
              }
            }
            //Condition to show user's vote after poll expiry
            $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_4'");
            $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
            if (mysqli_num_rows($poll_para_check)==1 && $poll_time > 24) {
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
          } if (!empty($parameter_5)) {
          //Check number of votes for each paramater
            $poll_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND parameter = '$parameter_5'");
            $poll_check_fetch = mysqli_fetch_assoc($poll_check);
            $poll_time = (time() - strtotime("$post_time " . "$post_date"))/3600;
            if ($poster_id == $user || $poll_time > 24) {
              $votes_2 = ": " . mysqli_num_rows($poll_check);
            } else {
              $votes_2 = "";
            }
            //Check if user already voted and change the love button accordingly
            if (mysqli_num_rows($poll)===0 && $poll_time < 24) {
              $vote_button = "<button style='height: 20px; font-size: 10px; line-height: 10px;' class='mysonar-btn'>vote</button>";
            } else {
          //Check if user has voted for this parameter in particular and change vote button accordinlgy
              $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_5'");
              $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
              if (mysqli_num_rows($poll_para_check)==1 && $poll_time < 24) {
                $vote_button = "<a href='polls.php?post_id=$post_id&parameter_5=$parameter_5' style='float: right;'><button style='float: right; height: 20px; font-size: 10px; line-height: 10px;' class='btn btn-sm btn-default'><b style='color: grey'>voted <span class='fa fa-check'></span></b></button></a>";
              } else {
                $vote_button = "";
              }
            }
            //Condition to show user's vote after poll expiry
            $poll_para_check = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' AND voter = '$user' AND parameter = '$parameter_5'");
            $poll_para_check_fetch = mysqli_fetch_assoc($poll_para_check);
            if (mysqli_num_rows($poll_para_check)==1 && $poll_time > 24) {
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

          <small>
          <i style='float: right; padding-right: 2px;'>$posttime</i>
          <br>

          <i>$poster_id</i>
          </small>

          <div>$post_text</div>

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

<!-- Musician song section -->
<div class="col-sm-3">
  <div class="card">
    <div class="myrow"><h5>Songs by <?php echo $musician; ?></h5></div>
    <?php
    //Get songs for suggestion
    $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_artist = '$musician'");
    if ($squer) {
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
          $cart = "<a href='vs_cart.php?vsong_id=$vsong_id&from=musicianpage&musician=$musician' style='min-width: 50px; float: left; margin' class='btn mysonar-btn'><span class='fa fa-shopping-cart'></span></a>";
        }
      }
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

<!-- Footer linked -->
<?php include('footer.php'); ?>

</body>
</html>
