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

//Deactivate account
if (isset($_POST['Deactivate'])) {
	mysqli_query($con, "DELETE FROM bm_notifies WHERE recipient = '$user' ");
	mysqli_query($con, "DELETE FROM comments WHERE commenter_id = '$user' ");
	/*mysqli_query($con, "DELETE FROM comment_loves WHERE comment_lover = '$user' ");*/
	/*mysqli_query($con, "DELETE FROM decos WHERE deco_to = '$user' ");*/
	mysqli_query($con, "DELETE FROM deco_notifies WHERE dn_to = '$user' ");
	mysqli_query($con, "DELETE FROM follows WHERE follower = '$user' OR followed = '$user' ");
	mysqli_query($con, "DELETE FROM f_notifies WHERE fn_follower = '$user' OR fn_followed = '$user' ");
	//Delete polls
	$postQuer = mysqli_query($con, "SELECT * FROM posts WHERE poster_id = '$user' ");
	while ($postFetch = mysqli_fetch_assoc($postQuer)) {
		extract($postFetch);
		$pollQuer = mysqli_query($con, "SELECT * FROM polls WHERE post_ref = '$post_id' ");
		$pollFetch = mysqli_fetch_assoc($pollQuer);
		extract($pollFetch);
		mysqli_query($con, "DELETE FROM polls WHERE post_ref = '$post_id' ");
	}
	mysqli_query($con, "DELETE FROM posts WHERE poster_id = '$user' ");
	/*mysqli_query($con, "DELETE FROM post_loves WHERE post_lover = '$user' ");*/
	mysqli_query($con, "DELETE FROM users WHERE username = '$user' ");
	/*mysqli_query($con, "DELETE FROM video_loves WHERE video_lover = '$user' ");*/
	mysqli_query($con, "DELETE FROM video_posts WHERE video_poster_id = '$user' ");
	/*mysqli_query($con, "DELETE FROM video_post_loves WHERE video_post_lover = '$user' ");*/
	mysqli_query($con, "DELETE FROM vsong_cart WHERE vs_cart_user = '$user' ");
	/*mysqli_query($con, "DELETE FROM referrals WHERE referee = '$user' OR referrer = '$user' ");*/
	header('location: index.php');
}
?>