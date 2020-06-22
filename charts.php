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
/* Function for adding into an array */
function array_push_assoc($array, $key, $value){
 $array[$key] = $value;
 return $array;
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
  <?php
  $newlyClass = $trendClass = $topDownClass = $topLovedClass = $orderBy = $vsong_bought = $minDate = $artistsWHERE = "";
  if (isset($_GET["chart"])) {
    extract($_GET);
    if ($chart == 'newlyReleased') {
      $artistsWHERE = 'video_songs';
      $minDate = 30;
      $orderBy = 'ORDER BY vsong_id DESC';
      $ANDvSong_id = '';
      $newlyClass = "class='active-scrollmenu'";
    } elseif ($chart == 'trending') {
      $artistsWHERE = 'vsongs_bought';
      $minDate = 7;
      $orderBy = '';
      $ANDvSong_id = 'AND vsong_id =';
      $trendClass = "class='active-scrollmenu'";
    } elseif ($chart == 'topDownloaded') {
      $artistsWHERE = 'vsongs_bought';
      $minDate = 1000;
      $orderBy = 'ORDER BY vsong_downloads DESC';
      $ANDvSong_id = '';
      $topDownClass = "class='active-scrollmenu'";
    } elseif ($chart == 'topLoved') {
      $artistsWHERE = 'video_loves';
      $minDate = 100;
      $orderBy = 'ORDER BY vsong_loves DESC';
      $ANDvSong_id = '';
      $topLovedClass = "class='active-scrollmenu'";
    } 
  }

  $AllClass = $AfroClass = $BengaClass = $BluesClass = $BoombaClass = $CountryClass = $CulturalClass = $EDMClass = $GengeClass = $GospelClass = $HiphopClass = $JazzClass = $MoKClass = $PopClass = $RandBClass = $RockClass = $SesubeClass = $TaarabClass = "";
  if (isset($_GET["vGenre"])) {
    extract($_GET);
    if ($vGenre == 'All') {
      $ANDvGenre = "";
      $AllClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Afro') {
      $ANDvGenre = "AND vgenre = 'Afro'";
      $AfroClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Benga') {
      $ANDvGenre = "AND vgenre = 'Benga'";
      $BengaClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Blues') {
      $ANDvGenre = "AND vgenre = 'Blues'";
      $BluesClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Boomba') {
      $ANDvGenre = "AND vgenre = 'Boomba'";
      $BoombaClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Country') {
      $ANDvGenre = "AND vgenre = 'Country'";
      $CountryClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Cultural') {
      $ANDvGenre = "AND vgenre = 'Cultural'";
      $CulturalClass = "class='active-scrollmenu'";
    }elseif ($vGenre == 'EDM') {
      $ANDvGenre = "AND vgenre = 'EDM'";
      $EDMClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Genge') {
      $ANDvGenre = "AND vgenre = 'Genge'";
      $GengeClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Gospel') {
      $ANDvGenre = "AND vgenre = 'Gospel'";
      $GospelClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Hiphop') {
      $ANDvGenre = "AND vgenre = 'Hiphop'";
      $HiphopClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Jazz') {
      $ANDvGenre = "AND vgenre = 'Jazz'";
      $JazzClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'MoK') {
      $ANDvGenre = "AND vgenre = 'Music of Kenya'";
      $MoKClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Pop') {
      $ANDvGenre = "AND vgenre = 'Pop'";
      $PopClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'RandB') {
      $ANDvGenre = "AND vgenre = 'R&B'";
      $RandBClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Rock') {
      $ANDvGenre = "AND vgenre = 'Rock'";
      $RockClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Sesube') {
      $ANDvGenre = "AND vgenre = 'Sesube'";
      $SesubeClass = "class='active-scrollmenu'";
    } elseif ($vGenre == 'Taarab') {
      $ANDvGenre = "AND vgenre = 'Taarab'";
      $TaarabClass = "class='active-scrollmenu'";
    }
  }
  ?>

  <!-- Scroll menu -->
  <div id="chartsMenu" class="hidden-scroll" style="margin: 10px 0 0 0;">
    <span><a href="charts.php?chart=newlyReleased&vGenre=All"><h5 <?php echo $newlyClass; ?>>Newly Released</h5></a></span>
    <span><a href="charts.php?chart=trending&vGenre=All"><h5 <?php echo $trendClass; ?>>Trending</h5></a></span>
    <span><a href="charts.php?chart=topDownloaded&vGenre=All"><h5 <?php echo $topDownClass; ?>>Top Downloaded</h5></a></span>
    <span><a href="charts.php?chart=topLoved&vGenre=All"><h5 <?php echo $topLovedClass; ?>>Top Loved</h5></a></span>
  </div>

  <div id="chartsMenu" class="hidden-scroll" style="margin: 0 0 0 0;">
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=All"><h6 <?php echo $AllClass; ?>>All</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Afro"><h6 <?php echo $AfroClass; ?>>Afro</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Benga"><h6 <?php echo $BengaClass; ?>>Benga</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Blues"><h6 <?php echo $BluesClass; ?>>Blues</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Boomba"><h6 <?php echo $BoombaClass; ?>>Boomba</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Country"><h6 <?php echo $CountryClass; ?>>Country</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Cultural"><h6 <?php echo $CulturalClass; ?>>Cultural</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=EDM"><h6 <?php echo $EDMClass; ?>>EDM</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Genge"><h6 <?php echo $GengeClass; ?>>Genge</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Gospel"><h6 <?php echo $GospelClass; ?>>Gospel</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Hiphop"><h6 <?php echo $HiphopClass; ?>>Hiphop</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Jazz"><h6 <?php echo $JazzClass; ?>>Jazz</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=MoK"><h6 <?php echo $MoKClass; ?>>Music of Kenya</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Pop"><h6 <?php echo $PopClass; ?>>Pop</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=RandB"><h6 <?php echo $RandBClass; ?>>R&B</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Rock"><h6 <?php echo $RockClass; ?>>Rock</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Sesube"><h6 <?php echo $SesubeClass; ?>>Sesube</h6></a>
    </span>
    <span>
      <a href="charts.php?chart=<?php echo $chart; ?>&vGenre=Taarab"><h6 <?php echo $TaarabClass; ?>>Taarab</h6></a>
    </span>
  </div>
  <!-- End of scroll menu -->

  <!-- Chart Area -->
  <div class="row hidden">
    <div class="col-sm-12">

      <!-- ****** Artists Area Start ****** -->
      <h5>Artists</h5>
      <div class="hidden-scroll">
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
          $firstdate = (time() - strtotime($accad_date))/86400;
          if ($firstdate>=1) {
            mysqli_query($con, "DELETE FROM acc_ads WHERE accad_id = $accad_id");
            echo "<script>location.reload();</script>";
          }
          if (mysqli_num_rows($fb_quer)===0) {
            if (mysqli_num_rows($as_quer)>0 || mysqli_num_rows($vs_quer)>0) {
              $fbutton = "<a href='follows.php?username=$username'><button type='submit' class='mysonar-btn'>follow</button></a>";
            } else {
              $fbutton = "<a><button class='mysonar-btn' onclick='checkerSnackbar()'>follow</button></a>";
            }
            if ($username != $user && $username != "@blackmusic") {
              echo "
              <span>
              <a href='musicianpage.php?username=$username'>
              <img src='$pp_path' width='100px' height='100px' alt='' class='avatar'>
              </a>
              <h6 class='compress'>$name</h6>
              <h6><small>$username <i style='color: grey;'>promoted</i></small></h6>
              $fbutton
              </span>
              <!-- The actual snackbar for following message -->
              <div id='checker'>You must have bought atleast 1 song by that Musician</div>
              ";
            }
          }
        }
        /*Get account Ad End*/

        /*Get relevant songs*/
        /*Add to trend_week*/
        $trendWeek = strtotime("next Friday");
        $trendWeek = getdate($trendWeek);
        $d_var = $trendWeek[0];
        $trendingVids = array();
        $downloadQuery = mysqli_query($con, "SELECT * FROM $artistsWHERE");
        while ($downloadFetch = mysqli_fetch_assoc($downloadQuery)) {
          extract($downloadFetch);
          if ($chart == 'trending' || $chart == 'topDownloaded') {
            $tDate = $d_var - strtotime($vsong_bought_date);
          } elseif ($chart == 'topLoved') {
            $tDate = 0;
            $vsong_bought = $loved_video;
          } else {
            $tDate = 0;
            $vsong_bought = $vsong_id;
          }
          $tDate = $tDate/86400;
          if ($tDate < $minDate) {
            if (array_key_exists($vsong_bought, $trendingVids)) {
              $trendingVids[$vsong_bought] += 1;
            } else {
              $trendingVids = array_push_assoc($trendingVids, $vsong_bought, 1);
            }
          }
        }
        arsort($trendingVids);
          /*echo print_r($trendingVids) . '<br>';
          echo count($trendingVids) . "<br>";*/

          /*Create relevant array for artist*/
          $trendingArtists = array();
          foreach($trendingVids as $vsong_bought => $downloads) {
            $getArtist = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_id = '$vsong_bought' ");
            $fetchArtist = mysqli_fetch_assoc($getArtist);
            extract($fetchArtist);
            if (array_key_exists($vsong_artist, $trendingArtists)) {
              $trendingArtists[$vsong_artist] += $downloads;
            } else {
              $trendingArtists = array_push_assoc($trendingArtists, $vsong_artist, $downloads);
            }
          }

          arsort($trendingArtists);
          /*echo print_r($trendingArtists) . '<br>';
          echo count($trendingArtists) . "<br>";*/

          /*Get winner*/
          if ($chart == 'trending') {
            $referralList = array();
            foreach($trendingArtists as $trendingArtist => $userDownloads) {
              $referralQuery = mysqli_query($con, "SELECT * FROM referrals WHERE referrer = '$trendingArtist' ");
              $referralFetch = mysqli_fetch_assoc($referralQuery);
              $referralCount = mysqli_num_rows($referralQuery);
              if ($referralCount >= 2) {
                for ($i=0; $i < $referralCount; $i++) { 
                  extract($referralFetch);
                  $rSongQuery = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_artist = '$referree' ");
                  if ($rSongFetch = mysqli_fetch_assoc($rSongQuery)) {
                    if (array_key_exists($trendingArtist, $trendingArtists)) {
                      $referralList[$trendingArtist] += 1;
                    } else {
                      $referralList = array_push_assoc($referralList, $trendingArtist, 1);
                    }
                  }
                }
              }
            }
            arsort($referralList);
          /*echo print_r($referralList) . '<br>';
          echo count($referralList) . "<br>";
          echo key($referralList) . "<br>";*/
          $winner = key($referralList);
        }

        /* Echo Artists according to most songs sold in one week */
        foreach($trendingArtists as $trendingArtist => $userDownloads) {
          if ($chart == 'trending') {
            if ($trendingArtist == $winner) {
              $position = "<h6 style='background-color: green;'><small style='color: white;'>Top</small></h6>";
            } elseif (array_key_exists($trendingArtist, $referralList)) {
              $position = "<h6 style='background-color: green;'><small style='color: white;'>$userDownloads Downloads</small></h6>";
            }else {
              $position = "<h6 style='background-color: orange;'><small style='color: white;'>$userDownloads Downloads</small></h6>";
            }
          } else {
            $position = "";
          }
          $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$trendingArtist' ");
          while ($row = mysqli_fetch_assoc($quer)) {
           extract($row);
           $fb_quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user' AND followed = '$username'");
           $fb_fetch = mysqli_fetch_assoc($fb_quer);
           $as_quer = mysqli_query($con, "SELECT * FROM asongs_bought WHERE asong_buyer = '$user' AND asong_bought_artist = '$username'");
           $as_fetch = mysqli_fetch_assoc($as_quer);
           $vs_quer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought_artist = '$username'");
           $vs_fetch = mysqli_fetch_assoc($vs_quer);
           if (mysqli_num_rows($fb_quer)===0) {
            if (mysqli_num_rows($as_quer)>0 || mysqli_num_rows($vs_quer)>0 || $user == "@blackmusic") {
              $fbutton = "<a href='follows.php?username=$username&from=charts&chart=$chart'><button type='submit' class='mysonar-btn'>follow</button></a>";
            } else {
              $fbutton = "<a><button class='mysonar-btn' onclick='checkerSnackbar()'>follow</button></a>";
            }
          } else {
            $fbutton = "<a href='follows.php?username=$username&from=charts&chart=$chart'><button type='submit' class='btn btn-sm btn-default'><b style='color: grey;'>Followed <span class='fa fa-check'></span></b></button></a>";
          }
          if ($username != "@blackmusic") {
            echo "
            <span>
            <a href='musicianpage.php?username=$username'>
            <img src='$pp_path' width='100px' height='100px' alt='' class='avatar'>
            </a>
            <h6 class='compress' style='width: 100px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$name</h6>
            <h6 style='width: 100px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$username</small></h6>
            $position
            $fbutton
            </span>

            <!-- The actual snackbar for following message -->
            <div id='checker'>You must have bought atleast 1 song by that Musician</div>
            ";
          }
        }
      }
      ?>
    </div>
    <!-- ****** Artists Area End ****** -->

    <br>
    <!-- ****** Songs Area ****** -->
    <h5>Songs</h5>
    <div>
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
          <span style='border: 1px solid lightgrey; padding: 0 0 10px 0; border-radius: 10px; text-align: center; display: inline-block; margin: 1px 1px 10px 1px;'>
          <a href='play_video.php?vsong_id=$vsong_id'><img width='150px' height='auto' src='$v_album_art'></a>
          <h6 style='padding: 10px 5px 0; margin: 0 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$vsong_name</h6>
          <h6 style='margin: 0px 0px 0px 0px; padding: 0px 5px 5px 5px; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$vsong_artist $ft</small></h6>
          <h6><small style='color: grey; margin: 0px 5px 0px 5px; padding: 0px 5px 0px 5px;'><i>Promoted</i></small></h6>

          $cart
          $bbtn

          </span>
          ";
        }
      }
      /*Fetch Artist Ad End*/

      if ($chart != 'trending') {
        $trendingVids = array(0 => 0);
      }
      foreach($trendingVids as $vsong_bought => $downloads) {
       $fade = "black";
       if ($chart != 'trending') {
        $vsong_bought = "";
        $dThisWeek = "";
      } else {
        $dThisWeek = "<span style='font-size: 1rem; color: green;'>&#x2022;</span> <span style='color: green;'>$downloads</span>";
        $fadeGet = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_bought = '$vsong_bought' ");
        $fadeFetch = mysqli_fetch_assoc($fadeGet);
        extract($fadeFetch);
        $fadeDate = time() - strtotime($vsong_bought_date);
        $fadeDate = $fadeDate/86400;
        if ($fadeDate > 7) {
          $fade = "lightgrey";
        }
      }
      /*Get songs*/
      $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_artist != '' $ANDvGenre $ANDvSong_id '$vsong_bought' $orderBy");
      while ($sfetch = mysqli_fetch_assoc($squer)) {
       extract($sfetch);
       $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought = $vsong_id"); 
       $buyfetch = mysqli_fetch_assoc($buyquer);
       /*Check if song is already in cart*/
       $cart_check = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_song = '$vsong_id' AND vs_cart_user = '$user'");
       $cart_check_quer = mysqli_fetch_assoc($cart_check);
       if (mysqli_num_rows($buyquer)===0) {
        $bbtn = "<br><a href='vs_cart.php?vsong_id=$vsong_id&from=checkout' class='btn mysonar-btn green-btn' style='margin: 5px 0 0 0;'>buy</a>";
      } else {
        $bbtn = "<button style='color: grey;' class='btn btn-sm btn-default'>
        <b style='color: grey'>Owned <span class='fa fa-check'></span></b></button>";
      }
      if (mysqli_num_rows($cart_check)>0) {
        $cart = "<button style='color: grey; min-width: 90px;' class='btn btn-sm btn-default'>
        <span class='fa fa-shopping-cart'></span></button>";
      } else {
        if (mysqli_num_rows($buyquer)>0) {
          $cart = "";
        } else {
          $cart = "<a href='vs_cart.php?vsong_id=$vsong_id&from=charts&chart=$chart&vGenre=$vGenre' style='min-width: 90px;' class='btn mysonar-btn'><span class='fa fa-shopping-cart'></span></a>";
        }
      }
      if (mysqli_num_rows($buyquer)==0) {
        echo "
        <span style='border: 1px solid lightgrey; padding: 0.3rem 0.3rem 10px 0.3rem; border-radius: 10px; text-align: center; display: inline-block; margin: 1px 1px 10px 1px;'>
        <a href='play_video.php?vsong_id=$vsong_id'><img width='160rem' height='90rem' src='$v_album_art'></a>
        <h6 style='color: $fade; padding: 5px 5px 0; margin: 0 0; width: 160px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$vsong_name</h6>
        <h6 style='color: $fade; margin: 0px 0px 0px 0px; padding: 0px 5px 0px 5px; width: 160px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$vsong_artist $ft</small></h6>
        <h6 style='color: $fade;'><small>$vsong_downloads Downloads $dThisWeek</small></h6>

        $cart
        $bbtn

        </span>
        ";
      }
    }
  }
  ?>
</div>
<!-- ****** Songs Area End ****** -->

</div>
</div>
<!-- End of Chart Area -->

<!-- For mobile -->
<div class="row anti-hidden" style="padding: 0;">
  <div class="col-sm-4"></div>
  <div class="col-sm-4">

    <div class="card">
      <!-- ****** Artists Area Start ****** -->
      <div class="myrow">
        <h5>Artists</h5>
        <div class="hidden-scroll">
          <?php
          /*Mobile*/
          /*Get account Ad */
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
            $firstdate = (time() - strtotime($accad_date))/86400;
            if ($firstdate>=1) {
              mysqli_query($con, "DELETE FROM acc_ads WHERE accad_id = $accad_id");
              echo "<script>location.reload();</script>";
            }
            if (mysqli_num_rows($fb_quer)===0) {
              if (mysqli_num_rows($as_quer)>0 || mysqli_num_rows($vs_quer)>0) {
                $fbutton = "<a href='follows.php?username=$username'><button type='submit' class='mysonar-btn'>follow</button></a>";
              } else {
                $fbutton = "<a><button class='mysonar-btn' onclick='checkerSnackbar()'>follow</button></a>";
              }
              if ($username != $user && $username != "@blackmusic") {
                echo "
                <label>
                <a href='musicianpage.php?username=$username'>
                <img src='$pp_path' width='100px' height='100px' alt='' class='avatar'>
                </a>
                <h6 class='compress'>$name</h6>
                <h6><small>$username <i style='color: grey;'>promoted</i></small></h6>
                $fbutton
                </label>
                <!-- The actual snackbar for following message -->
                <div id='checker'>You must have bought atleast 1 song by that Musician</div>
                ";
              }
            }
          }
          /*Get account Ad End*/

          /*Moblie*/
          /* Echo Artists according to most songs sold in one week */
          foreach($trendingArtists as $trendingArtist => $userDownloads) {
            if ($chart == 'trending') {
              if ($trendingArtist == $winner) {
                $position = "<h6 style='background-color: green;'><small style='color: white;'>Top</small></h6>";
              } else {
                $position = "<h6 style='background-color: green;'><small style='color: white;'>$userDownloads Downloads</small></h6>";
              }
            } else {
              $position = "";
            }
            $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$trendingArtist' ");
            while ($row = mysqli_fetch_assoc($quer)) {
             extract($row);
             $fb_quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user' AND followed = '$username'");
             $fb_fetch = mysqli_fetch_assoc($fb_quer);
             $as_quer = mysqli_query($con, "SELECT * FROM asongs_bought WHERE asong_buyer = '$user' AND asong_bought_artist = '$username'");
             $as_fetch = mysqli_fetch_assoc($as_quer);
             $vs_quer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought_artist = '$username'");
             $vs_fetch = mysqli_fetch_assoc($vs_quer);
             if (mysqli_num_rows($fb_quer)===0) {
              if (mysqli_num_rows($as_quer)>0 || mysqli_num_rows($vs_quer)>0 || $user == "@blackmusic") {
                $fbutton = "<a href='follows.php?username=$username&from=charts&chart=$chart'><button type='submit' class='mysonar-btn'>follow</button></a>";
              } else {
                $fbutton = "<a><button class='mysonar-btn' onclick='checkerSnackbar()'>follow</button></a>";
              }
            } else {
              $fbutton = "<a href='follows.php?username=$username&from=charts&chart=$chart'><button type='submit' class='btn btn-sm btn-default'><b style='color: grey;'>Followed <span class='fa fa-check'></span></b></button></a>";
            }
            if ($username != "@blackmusic") {
              echo "
              <span>
              <a href='musicianpage.php?username=$username'>
              <img src='$pp_path' width='100px' height='100px' alt='' class='avatar'>
              </a>
              <h6 class='compress' style='width: 100px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$name</h6>
              <h6 style='width: 100px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$username</small></h6>
              $position
              $fbutton
              </span>

              <!-- The actual snackbar for following message -->
              <div id='checker'>You must have bought atleast 1 song by that Musician</div>
              ";
            }
          }
        }
        ?>
      </div>
    </div>
    <!-- ****** Artists Area End ****** -->

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

    foreach($trendingVids as $vsong_bought => $downloads) {
     $fade = "black";
     if ($chart != 'trending') {
      $vsong_bought = "";
      $dThisWeek = "";
    } else {
      $dThisWeek = "<span style='font-size: 1rem; color: green;'>&#x2022;</span> <span style='color: green;'>$downloads</span>";
      $fadeGet = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_bought = '$vsong_bought' ");
      $fadeFetch = mysqli_fetch_assoc($fadeGet);
      extract($fadeFetch);
      $fadeDate = time() - strtotime($vsong_bought_date);
      $fadeDate = $fadeDate/86400;
      if ($fadeDate > 7) {
        $fade = "lightgrey";
      }
    }
      //Get songs
    $squer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_artist != '' $ANDvGenre $ANDvSong_id '$vsong_bought' $orderBy");
    while ($sfetch = mysqli_fetch_assoc($squer)) {
     extract($sfetch);
     $buyquer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$user' AND vsong_bought = $vsong_id"); 
     $buyfetch = mysqli_fetch_assoc($buyquer);
      //Check if song is already in cart
     $cart_check = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_song = '$vsong_id' AND vs_cart_user = '$user'");
     $cart_check_quer = mysqli_fetch_assoc($cart_check);
     $fade = "black";
     if ($chart == 'trending') {
      $tDate = time() - strtotime($vsong_bought_date);
      $tDate = $tDate/86400;
      if ($tDate > 7) {
        $fade = "lightgrey";
      }
    }
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
        $cart = "<a href='vs_cart.php?vsong_id=$vsong_id&from=charts&chart=$chart&vGenre=$vGenre' style='min-width: 50px; float: left; margin' class='btn mysonar-btn'><span class='fa fa-shopping-cart'></span></a>";
      }
    }
    if (mysqli_num_rows($buyquer)==0) {
      echo "
      <div class='myrow'>

      <div class='media'>
      <div class='media-left' style='padding: 0rem 0.5rem 0rem 0rem;'>
      <a href='play_video.php?vsong_id=$vsong_id'>
      <img src='$v_album_art' width='160rem' height='90rem'>
      </a>
      </div>

      <div class='media-body'>
      <h6 style='color: $fade; padding: 0px 0px 0 0; margin: 0 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'>$vsong_name
      </h6>
      <h6 style='color: $fade; margin: 0; width: 140px; white-space: nowrap; overflow: hidden; text-overflow: clip;'><small>$vsong_artist $ft</small></h6>
      <h6 style='color: $fade;'><small>$vsong_downloads Downloads $dThisWeek</small></h6>

      $cart
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
<div class="col-sm-4"></div>
</div>

<!-- The actual snackbar for following message -->
<div id='checker'>You must have bought atleast 1 song by that Musician</div>

<!-- Footer linked -->
<?php include('footer.php'); ?>

</body>
</html>
