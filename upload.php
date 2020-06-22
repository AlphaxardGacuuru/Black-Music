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
  <br>

  <!-- ***** Call to Action Area Start ***** -->
  <div class="sonar-call-to-action-area section-padding-0-100">
    <div class="backEnd-content">
      <h2>Studio</h2>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="contact-form text-center call-to-action-content wow fadeInUp" data-wow-delay="0.5s">
            <?php
            $ft = $valbum = "";
            $video_songErr = $vsongnameErr = $ftErr = $valbumErr = $vArtErr = "";
            $date = date("d-M-Y");
            $time = date("h:ia");
            $errors = array();

            function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $video_song = mysqli_real_escape_string($con, $_POST['video_song']);
              $vsongname = mysqli_real_escape_string($con, $_POST['vsongname']);
              $ft = mysqli_real_escape_string($con, $_POST['ft']);
              $vgenre = mysqli_real_escape_string($con, $_POST['vgenre']);
              $description = mysqli_real_escape_string($con, $_POST['description']);

            //change url to enable embedding
              $vidsource = substr_replace($video_song,'https://www.youtube.com/embed',0,16);

            //Check if link is correct
              if (!preg_match("/^https:\/\/(?:www\.)?youtube.com\/embed\/[A-z0-9]+/", $vidsource)) {
                $video_songErr = "<small class='error'>Wrong Link! Get link from 'copy video url' on YouTube or 'share' on the YouTube App.</small>";
              } else {
            //check if such a video already exists
                $videoSongQuer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong = '$vidsource' ");
                if ($videoSongFetch = mysqli_fetch_assoc($videoSongQuer)) {
                  $video_songErr = "<small class='error'>Video already exists!</small>";  
                } else {
            //check if song already exists
                 $vsong_quer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_name = '$vsongname' AND vsong_artist = '$user' ");
                 if ($vsong_fetch = mysqli_fetch_assoc($vsong_quer)) {
                  $vsongnameErr =  "You already posted a song with the same name!";
                } else {
                //check if ft artist exists
                  if (!empty($ft)) {
                    $ftCheck = mysqli_query($con, "SELECT * FROM users WHERE username = '$ft' ");
                    $ftFetch = mysqli_fetch_assoc($ftCheck);
                    if (mysqli_num_rows($ftCheck) < 1) {
                      $ftErr = "ft artist doesn't exist!";
                      $err = 1;
                    } 
                  } else {
                    $err = 0;
                  }
                  if ($err == 0) {
                    $target_dir = "v_album_art/";
                    $target_file = $target_dir . basename($_FILES["vArt"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $vArt = 'v_album_art/' . time() . '.' .$imageFileType;

                    /*Check file size*/
                    if ($_FILES["vArt"]["size"] > 1999000 || $_FILES["vArt"]["size"] == 0) {
                      $vArtErr = "Sorry, your file cannot be larger than 2MB!<br>";
                    } else {
                      /*Allow certain file formats*/
                      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                        $vArtErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed!<br>";
                    } else {
                      /*Rename and move the uploaded pic*/
                      if (move_uploaded_file($_FILES["vArt"]["tmp_name"], $vArt)) {
                        mysqli_query($con, "INSERT INTO `video_songs` (`vsong_id`, `vsong`, `vsong_name`, `vsong_artist`, `ft`, `vsong_album`, `vgenre`, `v_album_art`, `description`, `vsong_downloads`, `vsong_loves`, `vsong_date`, `vsong_time`) VALUES (NULL, '$vidsource', '$vsongname', '$user', '$ft', '', '$vgenre', '$vArt', '$description', '', '', '$date', '$time')"); 
                        $video_songErr = "<h6 style='color: green;'>Video uploaded!</h6>";
                      } else {
                        $vArtErr = "Album Art not uploaded!";
                      }
                    }
                  }
                }
              }
            }
          }
        }
        ?>
        <h2>Upload your song</h2>
        <h5>It's free</h5>
        <br>
        <div class="form-group">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
           <br>
           <?php echo $video_songErr;?>
           <input type="text" class="form-control" name="video_song" placeholder="Video URL from YouTube" required>
           <br>
           <br>
           <small class="error"> <?php echo $vsongnameErr;?></small>
           <input type="text" class="form-control" name="vsongname" placeholder="Song name" required>
           <br>
           <small class="error"> <?php echo $ftErr;?></small>
           <input type="text" class="form-control" name="ft" placeholder="ft">
           <br>
           <br>
           <select type="text" class="form-control" name="vgenre" required>
            <option value="">Song Genre</option>
            <option value="Afro">Afro</option>
            <option value="Benga">Benga</option>
            <option value="Blues">Blues</option>
            <option value="Boomba">Boomba</option>
            <option value="Country">Country</option>
            <option value="Cultural">Cultural</option>
            <option value="EDM">EDM</option>
            <option value="Genge">Genge</option>
            <option value="Gospel">Gospel</option>
            <option value="Hiphop">Hiphop</option>
            <option value="Jazz">Jazz</option>
            <option value="Music of Kenya">Music of Kenya</option>
            <option value="Pop">Pop</option>
            <option value="R&B">R&B</option>
            <option value="Rock">Rock</option>
            <option value="Sesube">Sesube</option>
            <option value="Taarab">Taarab</option>
          </select>
          <br>
          <br>  
          <small class="error"> <?php echo $vArtErr;?></small>
          <input class="form-control" type="file" name="vArt" accept="image/*" required>
          <br>
          <br>
          <textarea class="form-control" name="description" cols="30" rows="10" placeholder="Say something about your song" required=""></textarea>
          <br>
          <br>
          <br>
          <!-- single accordian area -->
          <div class="panel single-accordion">
            <h6>
              <a role="button" class="collapsed" aria-expanded="true" aria-controls="collapseTwo" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">UPLOAD VIDEO
                <span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
                <span class="accor-close"><i class="fa fa-minus" aria-hidden="true"></i></span>
              </a>
            </h6>
            <div id="collapseTwo" class="accordion-content collapse">
              <br>
              <h3>Before you upload</h3>
              <?php
              $newPhone = substr_replace($phone, "0", 0, -9);
              ?>
              <ol>
                <li><h6>By uploading you agree that you <b>own</b> this song.</h6></li>
                <li><h6>Songs are sold at <b style="color: green;">kes 20</b>, Black Music takes <b style="color: green;">50% (kes 10)</b> and the musician takes <b style="color: green;">50% (kes 10)</b>.</h6></li>
                <li><h6>You will be paid <b>weekly</b>, via Mpesa to <b style='color: dodgerblue;'><?php echo $newPhone; ?></b>.</h6></li>
              </ol>
              <br>
              <button type="submit" name="vupload" class="sonar-btn">Upload Video</button>
            </div>
          </div>
          <br>
          <br>
          <button type="Reset" class="sonar-btn">Reset</button>
        </form>

      </div>
    </div>
  </div>
</div>
</div>
</div>
<br>
<br>


<!--    <button style="border-color: #000;" class="btn btn-lg btn-default" data-toggle="collapse" data-target="#audio-form">Upload Audio</button> -->
<div id="audio-form" class="collapse">
  <br>
  <form action="Upload.php" method="POST">
   <b>Song Audio</b>
   <br>
   <label><input type="text" class="form-control" name="audio_song" placeholder="Song Audio"></label>
   <br>
                 <br><!-- 
                 <b>Album Art</b>
                 <br>
                 <label><input type="file" class="form-control" name="album_art" placeholder="Album Art"></label>
                 <br>
                 <br> -->
                 <label><input type="text" class="form-control" name="asongname" placeholder="Song name"></label>
                 <br>
                 <label><input type="text" class="form-control" name="aartist" placeholder="Song Artist"></label>
                 <br>
                 <label><input type="text" class="form-control" name="aalbum" placeholder="Song Album"></label>
                 <br>
                 <label><input type="text" class="form-control" name="agenre" placeholder="Song Genre"></label>
                 <br>
                 <br>
                 <b>Song Year</b>
                 <br>
                 <label><input type="year" class="form-control" name="asongyear" placeholder="Song Year"></label>
                 <br>
                 <button type="submit" name="aupload" class="btn btn-sm btn-success">Upload Audio</button>
                 <br>
                 <br>
                 <p><span style="font: 50%;">By clicking Upload, you agree to our <a href="#">Terms of use</a>, including our <a href="#">Cookie Use</a> and <a href="#">Privacy Policy</a>.</span></p>
                 <button type="Reset" class="btn btn-sm btn-danger">Reset</button>
               </form>
             </div>

             <?php
             $audio_song = "";
             $asongname = "";
             $aartist = "";
             $aalbum = "";
             $aalbum_art = "";
             $agenre = "";
             $asongyear = "";
             $date = date("d-M-Y");
             $time = date("h:ia");
             if (isset($_POST['aupload'])) {
               extract($_POST);
               $asong_insert = "INSERT INTO `audio_songs` (`asong_id`, `asong`, `asong_name`, `asong_artist`, `asong_album`, `agenre`, `album_art`, `asong_year`, `date`, `time`) VALUES (NULL, '$audio_song', '$asongname', '$aartist', '$aalbum', '$agenre', '$aalbum_art', '$asongyear', '$date', '$time')";
               $aupload_quer = mysqli_query($con, $asong_insert); 
               if ($aupload_quer) {
                echo "Audio uploaded";
              } else {
                echo "Audio failed to upload";
              }
            }
            ?>



            <!-- </body><button onclick="loveSnackbar()">click</button> -->
            <!-- The actual loveSnackbar -->
            <div id="loveSnackbar">Uploaded</div>

            <!-- Footer linked -->
            <?php include('footer.php'); ?>

            </html>