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
	<?php
	/*Define variables and set to empty values*/
	$name = $username = $phonenumber = $email = $password_1 = $acc_type = "";
	$nameErr = $usernameErr = $numberErr = $emailErr =$passwordErr = $picErr = "";
	$nameEcho = $phoneEcho = $emailEcho = $bioEcho = $locEcho = $picEcho = "";
	$date = date("Y:m:d");
	$time = date("h:ia");
	$errors = array();

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	/*Profile Pic upload*/
	/*Compress image function*/
	/*function compressImage($source, $destination, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

	}*/

	if (isset($_POST['edit_pic'])) {
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$finalImg = 'uploads/'.$user_id . '.' .$imageFileType;

		/*Check file size*/
		if ($_FILES["profile_pic"]["size"] > 1999000 || $_FILES["profile_pic"]["size"] == 0) {
			$picErr = "Sorry, your file cannot be larger than 2MB!<br>";
		} else {
			/*Allow certain file formats*/
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				$picErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed!<br>";
		} else {
			/*Delete existing pic from folder*/
			if ($pp_path != "img/male_avatar.png" && $pp_path != "img/female_avatar.png") {
				unlink($pp_path);
			}

			/*Rename and move the uploaded pic*/
				//compressImage($_FILES["profile_pic"]["tmp_name"], $destination_img, 50);
			if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $finalImg)) {
				$quer = mysqli_query($con, "UPDATE users SET pp_path = '$finalImg' WHERE username = '$user'");
				$picEcho = "The file ". basename( $_FILES["profile_pic"]["name"]). " has been uploaded!<br>";
			} else {
				$picErr = "File failed to upload!";
			}
		}
	}
}

	//Update Name
if (!empty($_POST['name'])) {
		//Prevent strings from being entered eg apostrophe in the word Brian's
	$upd_name = mysqli_real_escape_string($con, $_POST['name']); 
	$update_p = "UPDATE users SET name = IFNULL('$upd_name',0) WHERE username = '$user'";
	$quer = mysqli_query($con, $update_p);
	$nameEcho = "Name Updated!<br>";
}

	//Update phone
if (!empty($_POST['phonenumber'])) {
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
		} else {
			$upd_phone = "UPDATE users SET phone = '+$phone' WHERE username = '$user'";
			$phone_quer = mysqli_query($con, $upd_phone);
			$phoneEcho = "Phone Updated!<br>";
		}
	}
}

//Update email
if (!empty($_POST['email'])) {
	$emailInput = mysqli_real_escape_string($con, $_POST['email']);
		//check if e-mail address is well-formed
	$emailInput = test_input($_POST["email"]);
	if (!filter_var($emailInput, FILTER_VALIDATE_EMAIL)) {
		$emailErr = "Invalid email format, must have an '@' and a '.'!";
	} else { 
			//Check DB to see if email already exists
		$emailCheck = mysqli_query($con, "SELECT * FROM users WHERE email = '$emailInput' ");
		$emailCheckFetch = mysqli_fetch_assoc($emailCheck);
		if($user['email'] === $emailInput) {
			$emailErr = "Email already exists!";
		} else {
			$emailQuery = mysqli_query($con, "UPDATE users SET email = '$emailInput' WHERE username = '$user' ");
			$emailEcho = "Email Updated!<br>";
		}
	} 
}

	//Update bio
if (!empty($_POST['bio'])) {
		//Prevent strings from being entered eg apostrophe in the word Brian's
	$upd_bio = mysqli_real_escape_string($con, $_POST['bio']);
	$update_b = "UPDATE users SET bio = IFNULL('$upd_bio',0) WHERE username = '$user'";
	$bio_quer = mysqli_query($con, $update_b);
	$bioEcho = "Bio Updated!<br>";
}

	//Update location
if (!empty($_POST['loc'])) {
	$loc = mysqli_real_escape_string($con, $_POST['loc']);
		//Prevent strings from being entered eg apostrophe in the word Brian's
	$upd_loc = mysqli_real_escape_string($con, $_POST['loc']);
	$update_l = "UPDATE users SET location = IFNULL('$upd_loc',0) WHERE username = '$user'";
	$loc_quer = mysqli_query($con, $update_l);
	$locEcho = "Location Updated!<br>";
}

?>
<div class="row">
	<div class="col-sm-4"></div>
	<div style="text-align: center;" class="col-sm-4">
		<?php
		extract($row);
		?>
		<br>
		<br>
		<br class="hidden">
		<br class="hidden">
		<h1>INVITES</h1>
		<br>
		<h5>Invite your friends to Black Music and <i style="color: green;">earn!</i>.</h5>
		<h5>It's easy!</h5>
		<br>
		<a href='invites.php' class="btn sonar-btn">go to invites</a>
		<br>
		<br>
		<br>
		<br>
		<?php
		//Get updated user info
		$quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$user'");
		$row = mysqli_fetch_assoc($quer);
		extract($row);
		?>

		<!-- Profile Pic Form -->
		<br id="pp">
		<hr>
		<br>
		<div class="contact-form form-group">
			<h1>UPDATE PROFILE PIC</h1>
			<br>
			<form method="POST" action="<?php echo htmlspecialchars('settings.php#pp');?>" enctype="multipart/form-data"> 	
				<small style="color: green;"><?php echo $picEcho; ?></small>
				<small class="error"> <?php echo $picErr;?></small>
				<input class="form-control" type="file" name="profile_pic" placeholder="Profile Pic" accept="image/*">
				<br>
				<button type="reset" class="btn sonar-btn">reset</button>
				<br class="anti-hidden">
				<br class="anti-hidden">
				<button type="submit" name="edit_pic" class="btn sonar-btn">update profile pic</button>
			</form>
		</div>
		<!-- Profile Pic Form End -->

		<!-- Account Form -->
		<br id="account">
		<hr>
		<br>
		<div class="contact-form form-group">
			<h1>UPDATE ACCOUNT</h1>
			<br>
			<small style="color: green;"><?php echo $nameEcho; ?></small>
			<small style="color: green;"><?php echo $phoneEcho; ?></small>
			<small style="color: green;"><?php echo $emailEcho; ?></small>
			<small style="color: green;"><?php echo $bioEcho; ?></small>
			<small style="color: green;"><?php echo $locEcho; ?></small>
			<form method="POST" action="<?php echo htmlspecialchars('settings.php#account');?>"> 
				<small style="float: left;">Name</small><small class="error"> <?php echo $nameErr;?></small>
				<input class="form-control" type="text" name="name" placeholder="<?php echo $name; ?>">
				<br>
				<small style="float: left;">Phone</small><small style="color: red;"> <?php echo $numberErr;?></small>
				<input type="text" class="form-control" name="phonenumber" placeholder="<?php echo $phone; ?>">
				<br>
				<small style="float: left;">Email</small><small style="color: red;"> <?php echo $emailErr;?></small>
				<input type="text" class="form-control" name="email" placeholder="<?php echo $email; ?>">
				<br>
				<small style="float: left;">Bio</small>
				<input class="form-control" name="bio" placeholder="<?php echo $bio; ?>">
				<br>
				<small style="float: left;">Location</small>
				<input class="form-control" name="loc" placeholder="<?php echo $location; ?>">
				<br>
				<button type="reset" class="btn sonar-btn">reset</button>
				<br class="anti-hidden">
				<br class="anti-hidden">
				<button type="submit" name="reg_user" class="btn sonar-btn">update profile</button>
			</form>
		</div>
		<!-- Account Form End -->

		<!-- Password Form -->
		<br id="password">
		<hr>
		<br>
		<!-- Password Area -->
		<div class="contact-form form-group">
			<h1>CHANGE PASSWORD</h1>
			<?php
			$cur_pwd = $upd_pwd_1 = $upd_pwd_2 = $passwordErr = $passwordErr2 = "";

				//fetch data from form
			if (isset($_POST['updb_pwd'])) {
				$current = md5(mysqli_real_escape_string($con, $_POST['cur_pwd']));
				$password_1 = mysqli_real_escape_string($con, $_POST['upd_pwd_1']);
				$password_2 = mysqli_real_escape_string($con, $_POST['upd_pwd_2']);

				//check if current passwords match
				$pwd_check = "SELECT * FROM users WHERE username = '$user'";
				$pwd_quer = mysqli_query($con, $pwd_check);
				$pwd_fetch = mysqli_fetch_assoc($pwd_quer);
				extract($pwd_fetch);
				if ($current != $password) {
					$passwordErr = "Current Password does not match! $current";
				} else {

				//Check if passwords match
					if ($password_1 != $password_2) {
						$passwordErr2 = "Passwords do not match!";
					} else {
						$password_2 = md5($password_2);
						$upd_pwd = "UPDATE users SET password = '$password_2' WHERE username = '$user'";
						$upd_quer = mysqli_query($con, $upd_pwd);
						echo "<small style='color: green'>Password Updated!</small><br>";
					}
				}
			}
			?>
			<form action="settings.php#password" method="post" enctype="multipart/form-data">
				<small class="error"><?php echo $passwordErr; ?></small>
				<input type="password" class="form-control" name="cur_pwd" placeholder="Current Password">
				<br>
				<input type="password" class="form-control" name="upd_pwd_1" placeholder="New Password" required>
				<br>
				<small class="error"><?php echo $passwordErr2; ?></small>
				<input type="password" class="form-control" name="upd_pwd_2" placeholder="Confirm Password" required>
				<br>
				<button type="reset" class="sonar-btn">reset</button>
				<br class="anti-hidden">
				<br class="anti-hidden">
				<button type="submit" name="updb_pwd" class="sonar-btn">change</button>
			</form>
		</div>
		<!-- Password Form End -->

		<!-- Withdrawal Area Start -->
		<?php
		if ($acc_type == 'musician') {
			$withdrawalErr = '';
			if (isset($_GET['withdrawalBtn'])) {
				$withdrawal = mysqli_real_escape_string($con, $_GET['withdrawal']);
				$withdrawalQuer = mysqli_query($con, "UPDATE users SET withdrawal = 'KES $withdrawal' WHERE username = '$user' ");
				if ($withdrawalQuer) {
					$withdrawalErr = "<small style='color: green'>Minimum withdrawal Updated!</small><br>";
				} else {
					$withdrawalErr = "<small class='error'>Failed to Update Minimum Withdrawal!</small>";
				}
		//Get updated user info
				$quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$user'");
				$row = mysqli_fetch_assoc($quer);
				extract($row);
			}
			echo "
			<br id='withdrawal'>
			<hr>
			<br>
			<div class='contact-form form-group'>
			<h1>SET MINIMIUM WITHDRAWAL</h1>
			$withdrawalErr
			<form action='settings.php#withdrawal' method='GET' enctype='multipart/form-data'>
			<input type='number' class='form-control' name='withdrawal' placeholder='$withdrawal'>
			<br>
			<button type='submit' name='withdrawalBtn' class='sonar-btn'>set</button>
			</form>
			</div>
			";
		}
		?>
		<!-- Withdrawal Area End -->

		<!-- Deactivate Area -->
		<!-- Modal for Deactivating Account -->
		<div id="deleteModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><b style="color: red;">WARNING</b> Account Deactivation!</h4>
						<button type="button" style="float: right;" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<h4>Are you sure you want to <b>DEACTIVATE</b> your <b>Black Music Account</b>.</h4>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
						<form action="deactivate.php" method="POST">
							<button type="submit" style="float: left;" class="btn btn-sm btn-danger" name="Deactivate">Deactivate</button>
						</form>
					</div>
				</div>

			</div>
		</div>
		<br>
		<hr>
		<br>
		<h1>DEACTIVATE ACCOUNT</h1>
		<br>
		<br>
		<br>
		<button type="button" class="sonar-btn" data-toggle="modal" data-target="#deleteModal">Deactivate</button>
		<div class="col-sm-4"></div>
	</div>
	<!-- End of Deactivate Area -->
</div>
<div class="col-sm-4"></div>

<!-- Footer linked -->
<?php include('footer.php'); ?>
</body>
</html>