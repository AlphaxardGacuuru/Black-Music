<?php
$user = $_COOKIE['username'];
$date = date("d-M-Y");
$time = date("h:ia");
include('variables.php');
//Post Ads
if (isset($_GET['post_id'])) {
	extract($_GET);
	$postad = "INSERT INTO `post_ads` (`postad_id`, `postad_ref`, `postad_date`, `postad_time`) VALUES (NULL, '$post_id', '$date', '$time')";
	$postad_quer = mysqli_query($con, $postad);
	header("location:advertise.php");
}
//Video song Ads
if (isset($_GET['vsong_id'])) {
	extract($_GET);
	$vsongad = "INSERT INTO `vsong_ads` (`vsongad_id`, `vsongad_ref`, `vsongad_date`, `vsongad_time`) VALUES (NULL, '$vsong_id', '$date', '$time')";
	$vsongad_quer = mysqli_query($con, $vsongad);
	header("location:advertise.php");
}

//Account Ads
if (isset($_GET['user_id'])) {
	extract($_GET);
	echo $user_id;
	$acc_ad = "INSERT INTO `acc_ads` (`accad_id`, `accad_ref`, `accad_date`, `accad_time`) VALUES (NULL, '$user_id', '$date', '$time')";
	$accad_quer = mysqli_query($con, $acc_ad);
	header("location:advertise.php");
}