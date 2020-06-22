<?php 
if (isset($_GET["vs_cart_id"])) {
	extract($_GET);
	include("variables.php");
	mysqli_query($con, "DELETE FROM vsong_cart WHERE vs_cart_id = '$vs_cart_id'");
	header("location: $from.php");
}
