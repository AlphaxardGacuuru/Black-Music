<?php
include('variables.php');
	if (isset($_GET['comment_id'])) {
		extract($_GET);
		mysqli_query($con, "DELETE FROM comments WHERE comment_id = '$comment_id'");
	}
	header('location:commenting.php');
?>