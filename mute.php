<?php
$user = $_COOKIE['username'];
if (isset($_GET["username"])) {
	extract($_GET);
	include("variables.php");
	$f_quer = mysqli_query($con, "SELECT * FROM follows WHERE follower = '$user' AND followed = '$username'");
	$f_fetch = mysqli_fetch_assoc($f_quer);
	if ($muted == "show") {
		$mute_quer = mysqli_query($con, "UPDATE follows SET muted = 'mute' WHERE followed = '$username' AND follower = '$user'");
		$mute_fetch = mysqli_fetch_assoc($mute_quer);
	} else {
		$unmute_quer = mysqli_query($con, "UPDATE follows SET muted = 'show' WHERE followed = '$username' AND follower = '$user'");
		$unmute_fetch = mysqli_fetch_assoc($unmute_quer);
	}
	header("location: home.php");
}
	