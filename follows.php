<?php
$user = $_COOKIE['username'];
$date = date("d-M-Y");
$time = date("h:ia");
include('variables.php');
$musician = $chart = $vsong_id = "";
if (isset($_GET["username"])) {
	extract($_GET);
	$fb_quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user' AND followed = '$username'");
	$fb_fetch = mysqli_fetch_assoc($fb_quer);
	if (mysqli_num_rows($fb_quer)===0) {
		$follow = "INSERT INTO follows (`follow_id`, `followed`, `follower`, `follow_date`, `follow_time`) VALUES (NULL, '$username', '$user', '$date', '$time')";
		$quer = mysqli_query($con, $follow) or die(mysqli_error($con));

    //Adding number of fans
		$addfan = "UPDATE users SET fans = fans+1 WHERE username = '$username'";
		$addfan_quer = mysqli_query($con, $addfan) or die(mysqli_error($con));

	//Adding number of following
		$addfollow = "UPDATE users SET following = following+1 WHERE username = '$user'";
		$addfollow_quer = mysqli_query($con, $addfollow) or die(mysqli_error($con));

	//Showing follow notification
		$f_notify = "INSERT INTO f_notifies (`fn_id`, `fn_followed`, `fn_follower`) VALUES (NULL, '$username', '$user')";
		$f_quer = mysqli_query($con, $f_notify);
		//echo "You have followed " . $username;
	} else {
		$dfollow = "DELETE FROM follows WHERE follower = '$user' AND followed = '$username'";
		$dquer = mysqli_query($con, $dfollow) or die(mysqli_error($con));

    //Subtracting number of fans
		$subfan = "UPDATE users SET fans = fans-1 WHERE username = '$username'";
		$subfanquer = mysqli_query($con, $subfan) or die(mysqli_error($con));

   //Subtracting number of following
		$subfollow = "UPDATE users SET following = following-1 WHERE username = '$user'";
		$subfollow_quer = mysqli_query($con, $subfollow) or die(mysqli_error($con));

   //Deleting follow notification
		$df_notify = "DELETE FROM f_notifies WHERE fn_follower = '$user' AND fn_followed = '$username'";
		$df_quer = mysqli_query($con, $df_notify);
		//echo "You have unfollowed " . $username;
	}                 
	header("location: $from.php?musician=" . $musician . "&chart=" . $chart . "&vsong_id=" . $vsong_id);
}
?>	