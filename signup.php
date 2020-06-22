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
<body>
	<?php
	// define variables and set to empty values
	$name = $username = $email = $password_1 = $acc_type = $vsong_id = $referrer = "";
	$nameErr = $usernameErr = $emailErr =$passwordErr = $numberErr = "";
	$from = "help.php";
	$date = date("d-M-Y");
	$time = date("h:ia");
	$errors = array();

	//Get from play video 
	if (isset($_GET["from"])) {
		extract($_GET);
		$from = $from . ".php?vsong_id=$vsong_id";
	}

	//Get referral
	if (isset($_GET["referrer"])) {
		extract($_GET);
	}

	// connect to the database
	include('variables.php');
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = mysqli_real_escape_string($con, $_POST['username']);
		$from = $_POST['from'];
		$referrer = $_POST['referral'];

		// check if username only contains letters and numbers with the exception of the @ symbol
		$username = test_input($_POST["username"]);
		if (strlen($username) < 2) {
			$usernameErr = "Username too short. Should be at least 2 characters long!";
			array_push($errors, "1");
		} else {
			if (!preg_match("/^@[a-zA-Z0-9 ]*$/",$username)) {
				$usernameErr = "Username should start with the '@' symbol and include letters or numbers only!"; 
				array_push($errors, "1");
			} else {
				if (preg_match("/[[:space:]]/", $username)) {
					$usernameErr = "No space allowed in this field!"; 
					array_push($errors, "1");
				} else {
			// first check the database to make sure a user does not already exist with the same username
					include('variables.php');
					$user_check_query = "SELECT * FROM users WHERE username = '$username' ";
					$result = mysqli_query($con, $user_check_query);
					$user = mysqli_fetch_assoc($result);
					if (mysqli_num_rows($result) != 0) {
						$usernameErr = "Username already exists!"; 
						array_push($errors, "1");
					}
				}
			}

		}

		// check if e-mail address is well-formed
		// $email = test_input($_POST["email"]);
		// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// 	$emailErr = "Invalid email format, must have an '@' and a '.'!";
		// 	array_push($errors, "1"); 
		// } else { 
		// 	//Check DB to see if email already exists
		// 	include('variables.php');
		// 	$user_check_query = "SELECT * FROM users WHERE email='$email'";
		// 	$result = mysqli_query($con, $user_check_query);
		// 	$user = mysqli_fetch_assoc($result);
		// 	if($user['email'] === $email) {
		// 		$emailErr = "Email already exists!";
		// 		array_push($errors, "1");
		// 	}
		// } 

		// //Check if passwords match
		// if ($password_1 != $password_2) {
		// 	$passwordErr = "Passwords do not match!";
		// 	array_push($errors, "1");
		// }

	//Update phone
		$phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
		$phonenumber = test_input($_POST["phonenumber"]);
		$phone = substr_replace($phonenumber,'254',0,-9);
		//check if phone number only contains numbers
		if (!preg_match("/^07\d{8}$/",$phonenumber)) {
			$numberErr = "Input must be digits, start with '07' and be 10 characters long!";
			array_push($errors, "1");
		} else {
		//check if number already exists
			$phoneCheck = mysqli_query($con, "SELECT * FROM users WHERE phone = '+$phone' ");
			$phoneCheckFetch = mysqli_fetch_assoc($phoneCheck);
			if (mysqli_num_rows($phoneCheck)==1) {
				$numberErr = "Phone already exists";
				array_push($errors, "1");
			} 
		}

    	// Finally, register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5('');
        //Enter path for profile pic
			$pp = "img/male_avatar.png";
			$query = "INSERT INTO users (user_id, name, username, email, gender, acc_type, acc_type_2, pp_path, pb_path, bio, following, fans, phone, password, dob, location, withdrawal, date_joined, time_joined) 
			VALUES(NULL, '$name', '$username', '$email', '', 'normal', '', '$pp', '$pp', '', 0, 0, '+$phone', '$password', '', '', '', '$date', '$time')";
			mysqli_query($con, $query);

        //User should follow self to see their posts
			$follow = "INSERT INTO follows (`follow_id`, `followed`, `follower`, `follow_date`, `follow_time`) VALUES (NULL, '$username', '$username', '$date', '$time')";
			mysqli_query($con, $follow);

        //User should follow Official Black Music account to see posts
			$blackfollow = "INSERT INTO follows (`follow_id`, `followed`, `follower`, `follow_date`, `follow_time`) VALUES (NULL, '@blackmusic', '$username', '$date', '$time')";
			mysqli_query($con, $blackfollow);

        //Insert welcome notification
			$mes = "Welcome $username, to Black Music.";
			$notif_mes = "INSERT INTO `bm_notifies` (`bmn_id`, `message`, `recipient`) VALUES (NULL, '$mes', '$username')";
			mysqli_query($con, $notif_mes); 

        	//Insert into referrals
			if (!empty($referrer)) {
				$referralQuer = mysqli_query($con, "INSERT INTO `referrals` (`referral_id`, `referrer`, `referee`, `referral_date`, `referral_time`) VALUES (NULL, '$referrer', '$username', '$date', '$time')");
				header("location: email.php?welcome=" . $email . "&username=" . $username . "&from=" . $from);
			} else {
				if ($query) {
					header("location: email.php?welcome=" . $email . "&username=" . $username . "&from=" . $from);	
				}
			}
		}
	}
	?>
	<div class="row">
		<div class="col-sm-4"></div>
		<div style="text-align: center;" class="col-sm-4">
			<h1>Create an account</h1>
			<h2>It's free</h2>
			<div class="contact-form form-group">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
					<small class="error"> <?php echo $usernameErr;?></small><br>
					<label><input type="text" class="form-control" name="username" placeholder="@username" required=""></label>
					<br>
					<small style="color: red;"> <?php echo $numberErr;?></small><br>
					<label><input type="text" class="form-control" name="phonenumber" placeholder="07" required=""></label>
					<br>
					<br>
					<input type="hidden" name="from" value="<?php echo $from; ?>">
					<input type="hidden" name="referral" value="<?php echo $referrer; ?>">
					<br class="anti-hidden">
					<br class="anti-hidden">
					<button type="submit" name="reg_user" class="btn sonar-btn">Create account</button>
				</form>
				<br>
				<a href="index.php" class="btn sonar-btn">back to login</a>
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>
</body>
</html>
