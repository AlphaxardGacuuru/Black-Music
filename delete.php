<?php
include('variables.php');
//deleting posts
if (isset($_GET['post_id'])) {
	extract($_GET);
	$getComments = mysqli_query($con, "SELECT * FROM comments WHERE post_ref = '$post_id'");
	while ($fetchComment = mysqli_fetch_assoc($getComments)) {
		extract($fetchComment);
		mysqli_query($con, "DELETE FROM comment_loves WHERE loved_comment = '$comment_id' ");
	}
	mysqli_query($con, "DELETE FROM comments WHERE post_ref = '$post_id'");
	mysqli_query($con, "DELETE FROM post_loves WHERE loved_post = '$post_id'");
	mysqli_query($con, "DELETE FROM polls WHERE post_ref = '$post_id'");
	mysqli_query($con, "DELETE FROM posts WHERE post_id = '$post_id'");
	header("location: $from.php");
}

//delete video posts
if (isset($_GET['video_post_id'])) {
	extract($_GET);
	$getVideoLoves = mysqli_query($con, "SELECT * FROM video_post_loves WHERE loved_video_post = '$video_post_id' ");
	while ($fetchVideoLoves = mysqli_fetch_assoc($getVideoLoves)) {
		extract($fetchVideoLoves);
		mysqli_query($con, "DELETE FROM video_post_loves WHERE video_post_love_id = '$video_post_love_id' ");
	}
	mysqli_query($con, "DELETE FROM video_posts WHERE video_post_id = '$video_post_id'");
	header("location: $from.php?vsong_id=" . $vsong_id);
}