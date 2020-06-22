<?php
$user = $_COOKIE['username'];
if (empty($user)) {
  header('location: index.php');
}
$user = $_COOKIE['username'];
$date = date("d-M-Y");
$time = date("h:ia");
include('variables.php');
if (isset($_GET['post_id'])) {
	extract($_GET);
	//Check which parameter is being voted
	if (!empty($parameter_1)) {
		$tdata = $parameter_1;
	} elseif (!empty($parameter_2)) {
		$tdata = $parameter_2;
	} elseif (!empty($parameter_3)) {
		$tdata = $parameter_3;
	} elseif (!empty($parameter_4)) {
		$tdata = $parameter_4;
	} else {
		$tdata = $parameter_5;
	}
	//Get polls
	$poll = mysqli_query($con, "SELECT * FROM polls WHERE voter = '$user' AND post_ref = '$post_id'");
	$poll_fetch = mysqli_fetch_assoc($poll);
	//Check if user already voted
	if (mysqli_num_rows($poll)===0) {
		$insert_poll = "INSERT INTO `polls` (`poll_id`, `post_ref`, `voter`, `parameter`, `post_time`, `post_date`) VALUES (NULL, '$post_id', '$user', '$tdata', '$time', '$date')";
		$insert_poll_quer = mysqli_query($con, $insert_poll) or die(mysqli_error($con));
	} else {
		//Delete vote
		extract($poll_fetch);
		$dvote = "DELETE FROM polls WHERE poll_id = $poll_id";
		$dvote_query = mysqli_query($con, $dvote) or die(mysqli_error($con));
	}
	header("location: home.php");
}
?>