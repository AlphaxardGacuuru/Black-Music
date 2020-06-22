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
           $video_song = "";
           $video_songErr = $vArtErr = "";
           function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }

          //get vsong name
          if (isset($_GET['vsong_id'])) {
            extract($_GET);
          }

          if (!empty($_GET['video_song'])) {
            $video_song = mysqli_real_escape_string($con, $_GET['video_song']);
            $vsong_id = mysqli_real_escape_string($con, $_GET['vsong_id']);
            $vsong_id = mysqli_real_escape_string($con, $_GET['description']);

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
                $editQuer = mysqli_query($con, "UPDATE video_songs SET vsong = '$vidsource' WHERE vsong_id = '$vsong_id' ");
                if ($editQuer) {
                  $video_songErr = "<h6 style='color: green;'>Video edited!</h6>";
                } else {
                  $video_songErr = "<small class='error'>Video not edited!</small>";
                }
              }
            }
          }

           //Update video genre
          if (!empty($_GET['vgenre'])) {
            $editVgenre = mysqli_query($con, "UPDATE video_songs SET vgenre = '$vgenre' WHERE vsong_id = '$vsong_id' ");
            if ($editVgenre) {
              $video_songErr = "<h6 style='color: green;'>Video edited!</h6>";
            } else {
              $video_songErr = "<small class='error'>Video not edited!</small>";
            }
          }

          /*Update Video Album Art*/
          if (!empty($_FILES["vArt"]["name"])) {
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
                $editVgenre = mysqli_query($con, "UPDATE video_songs SET v_album_art = '$vArt' WHERE vsong_id = '$vsong_id' ");
                if ($editVgenre) {
                  $video_songErr = "<h6 style='color: green;'>Video edited!</h6>";
                } else {
                  $vArtErr = "<small class='error'>Video not edited!</small>";
                }
              }
            }
          }
        }

           //Update video description
        if (!empty($_GET['description'])) {
          $editVgenre = mysqli_query($con, "UPDATE video_songs SET description = '$description' WHERE vsong_id = '$vsong_id' ");
          if ($editVgenre) {
            $video_songErr = "<h6 style='color: green;'>Video edited!</h6>";
          } else {
            $video_songErr = "<small class='error'>Video not edited!</small>";
          }
        }

            //get vsong name
        $nameQuer = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_id = '$vsong_id' ");
        $nameFetch = mysqli_fetch_assoc($nameQuer);
        extract($nameFetch);
        ?>
        <h2>Edit <?php echo $vsong_name; ?></h2>
        <br>
        <div class="form-group">
          <form action="edit_song.php?vsong_id=<?php echo $vsong_id; ?>" method="POST" enctype="multipart/form-data">
           <br>
           <?php echo $video_songErr; ?>
           <input type="hidden" name="vsong_id" value="<?php echo $vsong_id; ?>">
           <input type="text" class="form-control" name="video_song" placeholder="Video URL from YouTube">
           <br>
           <select type="text" class="form-control" name="vgenre">
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
          <input class="form-control" type="file" name="vArt" accept="image/*">
          <br>
          <br>
          <textarea class="form-control" name="description" cols="30" rows="10" placeholder="<?php echo $description; ?>"></textarea>
          <br>
          <br>
          <button type="submit" name="editVid" class="sonar-btn">save changes</button>
        </form>

      </div>
      <a href="play_video.php?vsong_id=<?php echo $vsong_id; ?>" class="btn sonar-btn">check song</a>
    </div>
  </div>

</div>
</div>
</div>

<!-- Footer linked -->
<?php include('footer.php'); ?>

</html>