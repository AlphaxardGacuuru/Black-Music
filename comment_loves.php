<?php
$user = $_COOKIE['username'];
$date = date("d-M-Y");
$time = date("h:ia");
include('variables.php');
if (isset($_GET['comment_id'])) {
	extract($_GET);
	//Check if comment is already loved
	$love_check = mysqli_query($con, "SELECT * FROM comment_loves WHERE comment_lover = '$user' AND loved_comment = '$comment_id'");
	$love_checker = mysqli_fetch_assoc($love_check);
	//check if post is loved
	if (mysqli_num_rows($love_check)===0) {
		$love = "INSERT INTO comment_loves (`comment_love_id`, `loved_comment`, `comment_lover`, `comment_love_date`, `comment_love_time`) VALUES (NULL, '$comment_id', '$user', '$date', '$time')";
		$quer = mysqli_query($con, $love);

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
	//Get post_ref in order to go back to commenting page with post_id
	$postref_quer = mysqli_query($con, "SELECT * FROM comments WHERE comment_id = '$comment_id'");
	$postref_fetch = mysqli_fetch_assoc($postref_quer);
	extract($postref_fetch);
	header('location: commenting.php?post_id=' . $post_ref);
}
?>	