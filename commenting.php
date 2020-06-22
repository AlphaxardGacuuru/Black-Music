<?php
$user = $_COOKIE['username'];
extract($_GET);
if (isset($_POST['comment_text'])) {

  $user = $_COOKIE['username'];

  include('variables.php');
  $date = date("d-M-Y");
  $time = date("h:ia");
  if (!$con) {
    echo "Failed to connect";
  } else {
    extract($_POST);
            //die($post_id);

    $ins = "INSERT INTO `comments` (`comment_id`, `commenter_id`, `post_ref`, `comment_text`, `comment_date`, `comment_time`) VALUES 
    (NULL, '$user', $post_id, '$comment_text', '$date', '$time')";
    $quer = mysqli_query($con,$ins) or die(mysqli_error($con));

            //Adding number of posts
    $add = "UPDATE posts SET post_numcomments = post_numcomments+1 WHERE post_id = '$post_id'";
    $addquer = mysqli_query($con, $add) or die(mysqli_error($con));

            //Subtracting number of posts
//    $sub = "UPDATE posts SET post_numloves = post_numloves-1 WHERE post_id = '$post_id'";
//    $subquer = mysqli_query($con, $sub) or die(mysqli_error($con));
  }

}

//Function for displaying dynamic post time
function commentTimeFunction($sysdate1, $sysdate2)
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
    $newdate = $sysdate2;
    return $newdate;
  } else {
    $newdate = $sysdate2;
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

  <br>
  <br>
  <br>
  <br>

  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
      <div class="card">
        <table class="table table-hover">
          <tr>
            <td style="border-top: none;">
              <div class="media">
                <div class="media-left">
                  <img src="<?php echo $pp_path?>" style="vertical-align: middle; width: 30px; height: 30px; border-radius: 50%;" alt="avatar">
                </div>
                <div class="media-body">
                  <div class="contact-form form-group">
                    <form action="commenting.php" method="POST">
                      <label style="width: 100%;">
                        <input type="text" name="comment_text" width="100%" class="form-control" placeholder="Comment">
                      </label>
                      <button type="submit" style="float: right;" name="commenter" class="mysonar-btn">COMMENT</button>
                      <input type="hidden" name="post_id" value="<?php echo $post_id?>">
                    </form>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <?php
          $com = mysqli_query($con,"SELECT * FROM comments WHERE post_ref = '$post_id' ORDER BY comment_id DESC");
          while ($commenter = mysqli_fetch_assoc($com)) {
            extract($commenter);
                            //show time posted
            $commenttime = commentTimeFunction($comment_time, $comment_date);
                            //get commenter details
            $quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$commenter_id' ");
            while ($poster = mysqli_fetch_assoc($quer)) {
              extract($poster);
                                //check whether user has loved comments
              $love_check = mysqli_query($con, "SELECT * FROM comment_loves WHERE comment_lover = '$user' AND loved_comment = '$comment_id'");
              $love_checker = mysqli_fetch_assoc($love_check);
              if (mysqli_num_rows($love_check)===0) {
                $heart = "<a href='comment_loves.php?comment_id=$comment_id' class='fa fa-heart'></a>";
              } else {
                $heart = "<a href='comment_loves.php?comment_id=$comment_id' class='fa fa-heart'style='color: #cc3300'></a>";
              }
              if ($commenter_id == $user) {
                $del = "<tr><td><a href='delete_comments.php?comment_id=$comment_id'><h6>delete post</h6></a></td></tr>";
              } else {
                $del = "";
              }
              echo "
              <tr>
              <td>
              <div class='media'>
              <div class='media-left'>
              <img src='$pp_path' style='float: right; vertical-align: top; width: 30px; height: 30px; border-radius: 50%;' alt='avatar'>
              </div>

              <div style='padding-left: 1%;' class='media-body'>
              <b class='media-heading'>$name</b>
              <span style='color: gold; padding-top: 10px;' class='fa fa-circle-o'></span>
              <span style='font-size: 10px;'>$deco</span>

              <small><i style='float: right; padding-right: 2px;'>$commenttime</i><br><i>$commenter_id</i></small>

              <div>$comment_text</div>
              <br>
              $heart

              <small>$comment_numloves</small>

              <span class='dropup'>
              <span style='cursor: pointer; float: right;' class='fa fa-ellipsis-v' data-toggle='dropdown'></span>

              <ul class='dropdown-menu dropdown-menu-right'>
              <table class='table table-hover'>
              $del
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
          ?>
        </table>
      </div>
    </div>
    <div class="col-sm-4"></div>
  </div>

  <!-- Footer linked -->
  <?php include('footer.php'); ?>

</body>
</html>
