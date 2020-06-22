<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<!-- Title  -->
	<title>Black Music</title>

	<!-- Favicon  -->
	<link rel="icon" href="img/havi logos-4.png">

	<!-- Style CSS -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="black_music.css">

	<!-- black music JS -->
	<script src="black_music.js"></script>
</head>
<body style="background-color: #000; margin: 0; padding: 0; overflow-x: hidden;">
	<div class="row">
		<div class="col-sm-4"></div>
		<div style="text-align: center;" class="col-sm-4">
			<?php
			//Log in User

			//Define variables and set to empty
			$phoneErr = "";
			setcookie("username", "", time() - 3600);
			if (isset($_POST['login_user'])) {
				include('variables.php');
				$phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
				//check if phone number only contains numbers
				if (!preg_match("/^07\d{8}$/",$phonenumber)) {
					$phoneErr = "Input must be digits, start with '07' and be 10 characters long!";
				} else {
					$phone = substr_replace($phonenumber,'254',0,-9);
					$phoneQuery = mysqli_query($con, "SELECT * FROM users WHERE phone = '+$phone' ");
					$phoneFetch = mysqli_fetch_assoc($phoneQuery);
					if ($phoneFetch['phone'] != $phone) {
						$phoneErr = "Phone does not exist!";
					} else {
						extract($phoneFetch);
						//set cookie for 30 days
						$cookie_time = time() + (86400 * 30);
						setcookie("username", $username, $cookie_time, "/");
						if ($username != '@blackmusic') {
							header('location: home.php');
						} else {
							header('location: password.php');
						}
					}
				}
			}

			?>
			<br>
			<h2 style="color: white; font-weight: 100;">Black Music</h2>
			<h5 style="color: white; font-weight: 100;">Follow your favorite musicians and enjoy their songs</h5>
			<br>
			<div class="contact-form form-group">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
					<div class="form-group">
						<h6 style="color: white;">Enter Phone</h6>
						<small class="error"> <?php echo $phoneErr;?></small><br>
						<label><input style="color: white;" type="text" class="form-control" name="phonenumber" value="07" required=""></label>
						<br>
						<br>
						<br>
						<button type="submit" name="login_user" class="btn sonar-btn white-btn">Login</button>
						<br>
						<br>
						<a href="signup.php" class="btn sonar-btn white-btn">Sign Up</a>
						<br>
						<br>
						<a href="login.php" class="btn sonar-btn">username login</a>
					</div>
				</form>
			</div>
			<div class="col-sm-4"></div>
		</div>	
	</div>
</body>
</body>
</html>