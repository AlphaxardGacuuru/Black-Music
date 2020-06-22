<?php
$user = $_COOKIE['username'];
$date = date("d-M-Y");
$time = date("h:ia");
include('variables.php');?>
<?php 
//Post loves
if (isset($_GET['post_id'])) {
	extract($_GET);
	$love_check = mysqli_query($con, "SELECT * FROM post_loves WHERE post_lover = '$user' AND loved_post = '$post_id'");
	$love_checker = mysqli_fetch_assoc($love_check);
	//check if post is loved
	if (mysqli_num_rows($love_check)===0) {
		$love = "INSERT INTO post_loves (`post_love_id`, `loved_post`, `post_lover`, `post_love_date`, `post_love_time`) VALUES (NULL, '$post_id', '$user', '$date', '$time')";
		$quer = mysqli_query($con, $love) or die(mysqli_error($con));

    //Adding number of loves on post
		$add = "UPDATE posts SET post_numloves = post_numloves+1 WHERE post_id = '$post_id'";
		$addquer = mysqli_query($con, $add) or die(mysqli_error($con));
		//echo "<script>loveSnackbar();</script>You have loved post " . $post_id;
	} else {
		$dlove = "DELETE FROM post_loves WHERE post_lover = '$user' AND loved_post = '$post_id'";
		$dquer = mysqli_query($con, $dlove) or die(mysqli_error($con));

    //Subtracting number of loves on post
		$sub = "UPDATE posts SET post_numloves = post_numloves-1 WHERE post_id = '$post_id'";
		$subquer = mysqli_query($con, $sub) or die(mysqli_error($con));
		//echo "<script>unloveSnackbar();</script>You have unloved post " . $post_id;
	}                 
	//echo "<script>redirectFunction();</script>";
	 header('location:home.php');
}

//Video post loves
if (isset($_GET['video_post_id'])) {
	extract($_GET);
	//Check if video post is loved
	$love_check = mysqli_query($con, "SELECT * FROM video_post_loves WHERE video_post_lover = '$user' AND loved_video_post = '$video_post_id'");
	$love_checker = mysqli_fetch_assoc($love_check);
	if (mysqli_num_rows($love_check)===0) {
		$love = "INSERT INTO video_post_loves (`video_post_love_id`, `loved_video_post`, `video_post_lover`, `video_post_love_date`, `video_post_love_time`) VALUES (NULL, '$video_post_id', '$user', '$date', '$time')";
		$quer = mysqli_query($con, $love) or die(mysqli_error($con));

    //Adding number of loves on video post
		$add = "UPDATE video_posts SET video_post_numloves = video_post_numloves+1 WHERE video_post_id = '$video_post_id'";
		$addquer = mysqli_query($con, $add) or die(mysqli_error($con));
		//echo "<script>loveSnackbar();</script>You have loved video post " . $video_post_id;
	} else {
		$dlove = "DELETE FROM video_post_loves WHERE video_post_lover = '$user' AND loved_video_post = '$video_post_id'";
		$dquer = mysqli_query($con, $dlove) or die(mysqli_error($con));

    //Subtracting number of loves on post
		$sub = "UPDATE video_posts SET video_post_numloves = video_post_numloves-1 WHERE video_post_id = '$video_post_id'";
		$subquer = mysqli_query($con, $sub) or die(mysqli_error($con));
		//echo "<script>unloveSnackbar();</script>You have unloved video post " . $video_post_id;
	}                 
	//Get vsong id
	$vidcheck = mysqli_query($con, "SELECT * FROM video_posts WHERE video_post_id = '$video_post_id' ");
	$vidcheckquer = mysqli_fetch_assoc($vidcheck);
	extract($vidcheckquer);
	//echo "<script>redirectFunction();</script>";
	 header('location: play_video.php?vsong_id='.$video_post_ref);
}

//Video loves
if (isset($_GET['vsong_id'])) {
	extract($_GET);
	$love_check = mysqli_query($con, "SELECT * FROM video_loves WHERE video_lover = '$user' AND loved_video = '$vsong_id'");
	$love_checker = mysqli_fetch_assoc($love_check);
	//check if post is loved
	if (mysqli_num_rows($love_check)===0) {
		$love = "INSERT INTO video_loves (`video_love_id`, `loved_video`, `video_lover`, `video_love_date`, `video_love_time`) VALUES (NULL, '$vsong_id', '$user', '$date', '$time')";
		$quer = mysqli_query($con, $love) or die(mysqli_error($con));

    //Adding number of loves on video
		$add = "UPDATE video_songs SET vsong_loves = vsong_loves+1 WHERE vsong_id = '$vsong_id'";
		$addquer = mysqli_query($con, $add) or die(mysqli_error($con));
	} else {
		$dlove = "DELETE FROM video_loves WHERE video_lover = '$user' AND loved_video = '$vsong_id'";
		$dquer = mysqli_query($con, $dlove) or die(mysqli_error($con));

    //Subtracting number of loves on post
		$sub = "UPDATE video_songs SET vsong_loves = vsong_loves-1 WHERE vsong_id = '$vsong_id'";
		$subquer = mysqli_query($con, $sub) or die(mysqli_error($con));
	}                 
	//echo "<script>redirectFunction();</script>";
	 header('location:play_video.php?vsong_id='.$vsong_id);
}

//Comment loves
if (isset($_GET['comment_id'])) {
	extract($_GET);
	//check if comment is loved
	$love_check = mysqli_query($con, "SELECT * FROM comment_loves WHERE comment_lover = '$user' AND loved_comment = '$comment_id'");
	$love_checker = mysqli_fetch_assoc($love_check);
	//if user has not loved yet then insert
	if (mysqli_num_rows($love_check)===0) {
		$love = "INSERT INTO comment_loves (`comment_love_id`, `loved_comment`, `comment_lover`, `comment_love_date`, `comment_love_time`) VALUES (NULL, '$comment_id', '$user', '$date', '$time')";
		$quer = mysqli_query($con, $love) or die(mysqli_error($con));

    //Adding number of loves on post
		$add = "UPDATE comments SET comment_numloves = comment_numloves+1 WHERE comment_id = '$comment_id'";
		$addquer = mysqli_query($con, $add) or die(mysqli_error($con));
		//echo "<script>loveSnackbar();</script>You have loved comment " . $post_id;
	} else {
		$dlove = "DELETE FROM comment_loves WHERE comment_lover = '$user' AND loved_comment = '$comment_id'";
		$dquer = mysqli_query($con, $dlove) or die(mysqli_error($con));

    //Subtracting number of loves on post
		$sub = "UPDATE comments SET comment_numloves = comment_numloves-1 WHERE comment_id = '$comment_id'";
		$subquer = mysqli_query($con, $sub) or die(mysqli_error($con));
		//echo "<script>unloveSnackbar();</script>You have unloved comment " . $post_id;
	}                 
	header('location:commenting.php?comment_id=$comment_id');
}

?>	