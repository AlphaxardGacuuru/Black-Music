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
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<!-- Title  -->
	<title>Black Campus</title>

	<!-- Favicon  -->
	<link rel="icon" href="img/havi logos-4.png">

	<!-- Style CSS -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="black_music.css">

	<!-- black music JS -->
	<script src="black_music.js"></script>
</head>
<body>

	<!-- Top Nav linked -->
	<?php include('topnav.php'); ?>

	<!-- Grids -->
	<div class="grids d-flex justify-content-between">
		<div class="grid1"></div>
		<div class="grid2"></div>
		<div class="grid3"></div>
		<div class="grid4"></div>
		<div class="grid5"></div>
		<div class="grid6"></div>
		<div class="grid7"></div>
		<div class="grid8"></div>
		<div class="grid9"></div>
	</div>

	<div class="row">
		<div class="col-sm-6 contact-form text-center">
			<br>
			<br>
			<br class="hidden">
			<br class="hidden">
			<h2>Welcome to the Help Center</h2>
			<img src="img/havi logos-4.png" width="50%" height="50%">
		</div>
		<div class="col-sm-6">
			<br>
			<br>
			<br class="hidden">
			<br class="hidden">
			<ol>
				<h4>Black Music is an online music store and social network. Musicians can upload songs and post on the home page and users can buy, like or comment. Users can buy songs via mpesa to our Mpesa till. Users can also invite others and earn each time their invites buy songs.</h4><br>

				<h3>Accounts</h3>
				<img src='img/male_musician.png' style='vertical-align: top; width: 50px; height: 50px; border-radius: 50%;' alt='avatar' >
				<img src='img/male_avatar.png' style='vertical-align: top; width: 50px; height: 50px; border-radius: 50%;' alt='avatar' >
				<br>
				<br>
				<li>There are two types of accounts, Musician  and Normal  .<br> 
				Musicians have the ability to post and upload songs.</li><br>

				<h3>Fans</h3>
				<button href="#" class="mysonar-btn">follow</button>
				<br>
				<br>
				<li>Users can follow musicians and see their posts by becoming their fans. To become a fan, users must buy at least one song.</li><br>
				<h3>Decos</h3>
				<span style='color: gold;' class='fa fa-circle-o'></span> 
				<br>
				<br>
				<li>Decos are golden rings that are awarded to fans for every tenth song they buy.</li><br>
			</ol>
		</div>
	</div>
	<div class="row" style="background-image: url('img/bg-img/dots.png'); background-repeat: no-repeat; background-position: right;">
		<div class="col-sm-1"></div>
		<div class="col-sm-6">
			<h2>HOW TO USE BLACK MUSIC</h2>
			<h3>How to Post</h3>
			<ol>
				<li>While on the home page, go to the compose icon <button id='floatBtn' style="position: relative; font-size: 10px; height: 40px; width: 40px; z-index: 0; line-height: 10px; right: 0px; top: 0px;"><span style='font-size: 20px;' class='fa fa-pencil'></span></button></li>
				<br>
				<h3>Managing your account</h3>
				<li>Click on your profile pic.</li>
				<li>Go to settings.</li>
				<br>
				<h3>Uploading songs</h3>
				<li>Click on your profile pic.</li>
				<li>Go to studio.</li>
			</ol>
		</div>
		<div class="col-sm-5"></div>
	</div>
	<br>
	<br>

	<footer style="background-color: #000; background-image: url('');">
		<div class="row">
			<div class="col-sm-12">
			<center>
				<br>
				<br>
				<img src="img/Al.jpg" width="100px" height="100px" style="border-radius: 50%; border: 4px solid white;">
				<br>
				<br>
				<br>
				<a href="https://www.instagram.com/alphaxard_gacuuru" style="color: white; font-size: 30px;" data-toggle="tooltip" data-placement="bottom" title="Instagram">
					<i class="fa fa-instagram" aria-hidden="true"></i></a>
					<br>
					<br>
					<br>
					<a href="https://www.facebook.com/alphaxard.gacuuru" style="color: white; font-size: 30px;" data-toggle="tooltip" data-placement="bottom" title="Facebook">
						<i class="fa fa-facebook" aria-hidden="true"></i></a>
						<br>
						<br>
						<br>
						<a href="https://www.twitter.com/alphaxardG" style="color: white; font-size: 30px;" data-toggle="tooltip" data-placement="bottom" title="Twitter">
							<i class="fa fa-twitter" aria-hidden="true"></i></a>
						</center>
						</div>
					</div>
					<!-- Footer linked -->
					<?php include('footer.php'); ?>
				</footer>

			</body>
			</html>