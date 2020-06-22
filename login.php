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
<body style="background-color: #000;  margin: 0; padding: 0; overflow-x: hidden;">
	<div class="row">
		<div class="col-sm-4"></div>
		<div style="text-align: center;" class="col-sm-4">
			<?php
			//Log in User

			//Define variables and set to empty
			$usernameErr = "";
			if (isset($_POST['login_user'])) {
				include('variables.php');
				$username = mysqli_real_escape_string($con, $_POST['username']);
				//Check username format
				if (!preg_match("/^@[a-zA-Z0-9 ]*$/",$username)) {
					$usernameErr = "Username should start with the '@' symbol and include letters or numbers only! <br>";
				} else {
					$usernameQuery = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' ");
					$usernameFetch = mysqli_fetch_assoc($usernameQuery);
					if ($usernameFetch['username'] != $username) {
						$usernameErr = "User does not exist! " . $usernameFetch['username'];
					} else {
						extract($usernameFetch);
						//set cookie for 30 days
						$cookie_time = time() + (86400 * 30);
						setcookie("username", $username, $cookie_time, "/");
						if (empty($phone) && $username != '@blackmusic') {
							header("location: update_phone.php");
						} else {
							if ($username != '@blackmusic') {
								header('location: home.php');
							} else {
								header('location: password.php');
							}
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
						<h6 style="color: white;">Enter Username</h6>
						<small class="error"> <?php echo $usernameErr;?></small><br>
						<label><input style="color: white;" type="text" class="form-control" name="username" value="@" required=""></label>
						<br>
						<br>
						<button type="submit" name="login_user" class="btn sonar-btn white-btn">Login</button>
						<br>
						<br>
						<a href="index.php" class="btn sonar-btn">phone login</a>
					</div>
				</form>
			</div>
		</div>
		<div class="col-sm-4"></div>	
	</div>
</body>
</body>
</html>