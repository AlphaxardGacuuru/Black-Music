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

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

	//Update phone
$phoneEcho = $numberErr = "";
if (!empty($_POST['phonenumber'])) {
	$phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
	$phonenumber = test_input($_POST["phonenumber"]);
	$phone = substr_replace($phonenumber,'254',0,-9);
		//check if phone number only contains numbers
	if (!preg_match("/^07\d{8}$/",$phonenumber)) {
		$numberErr = "Input must be digits, start with '07' and be 10 characters long!";
	} else {
		//check if number already exists
		$phoneCheck = mysqli_query($con, "SELECT * FROM users WHERE phone = '+$phone' ");
		$phoneCheckFetch = mysqli_fetch_assoc($phoneCheck);
		if (mysqli_num_rows($phoneCheck)==1) {
			$numberErr = "Phone already exists";
		} else {
			$phone_quer = mysqli_query($con, "UPDATE users SET phone = '+$phone' WHERE username = '$user'");
			header("location: home.php");
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Black Music, Music">
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
</head>
<body>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<center>
				<br>
				<h2>Hi there <?php echo $username; ?></h2>
				<h4>Please update phone for quick login</h4>
				<small style="color: green;"><?php echo $phoneEcho; ?></small>
				<div class="contact-form form-group">
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<small style="color: red;"> <?php echo $numberErr;?></small><br>
						<label><input type="text" class="form-control" name="phonenumber" value="07"></label>
						<br>
						<br>
						<button type="submit" class="btn sonar-btn">update phone</button>
					</form>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</body>
	</html>