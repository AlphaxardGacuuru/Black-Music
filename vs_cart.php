<?php
$user = $_COOKIE['username'];
$date = date("d-M-Y");
$time = date("h:ia");
include('variables.php');
$musician = $chart = $vGenre = $vsong_id = "";
if (isset($_GET["from"])) {
	extract($_GET);
	//Check if song is already in cart
	$cart_check = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_song = '$vsong_id' AND vs_cart_user = '$user'");
	$cart_check_quer = mysqli_fetch_assoc($cart_check);
	extract($cart_check_quer);
	echo $vs_cart_id;
	if (mysqli_num_rows($cart_check)==0) {
		$song_get = mysqli_query($con, "SELECT * FROM video_songs WHERE vsong_id = '$vsong_id'");
		$song_get_fetch = mysqli_fetch_assoc($song_get);
		extract($song_get_fetch);
		echo $vsong_name;
		$vs_cart = "INSERT INTO `vsong_cart` (`vs_cart_id`, `vs_cart_song`, `vs_cart_user`, `vs_cart_songname`, `vs_cart_songartist`) VALUES (NULL, '$vsong_id', '$user', '$vsong_name', '$vsong_artist')";
		$vs_cart_query = mysqli_query($con, $vs_cart);
	}
	header("location: $from.php?musician=" . $musician . "&chart=" . $chart . "&vGenre=" . $vGenre . "&vsong_id=" . $vsong_id);
	
}