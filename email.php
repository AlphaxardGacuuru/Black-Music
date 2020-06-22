<?php
$user = $_COOKIE['username'];
$date = date("d-M-Y");
$time = date("h:ia");

require_once("PHPMailer/PHPMailerAutoload.php");

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "ssl://mail.black.co.ke";
$mail->Port = "465";
$mail->Username = "info@black.co.ke";
$mail->Password = "sw[$4#3n{&qu";
$mail->SetFrom("info@black.co.ke", "Black Music");

/*Send via Gmail*/
/*$mail->Host = "ssl://smtp.gmail.com";
$mail->isHTML();
$mail->Username = "alphaxardgacuuru47@gmail.com";
$mail->Password = "Xardis110%Epic";
$mail->SetFrom("alphaxardgacuuru47@gmail.com", "Al");*/

//send email to reset password
if (isset($_GET['forgotPassword'])) {
	extract($_GET);
	$password = md5($user_id);
	include("variables.php");
	$resetPassword = mysqli_query($con, "UPDATE users SET password = '$password' WHERE username = '$username'");
	$mail->Subject = "Password reset";
	$mail->Body = "
	<div style='box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; margin: 3%; padding: 3%;'>
	<center>
	<h3 style='font-family: 'Roboto', sans-serif; font-weight: 300;'>Hi there $username,</h3>

	<p style='font-family: 'Roboto', sans-serif; font-weight: 300;'>
	Your password has been reset. Use the password <b>$user_id</b> to log in and change your password.
	<br>
	</p>

	<a href='http://music.black.co.ke/home.php'><button style='
	position: relative;
	z-index: 1;
	min-width: 180px;
	height: 66px;
	border: 1px solid;
	border-color: #2f2f2f;
	text-transform: uppercase;
	color: #2f2f2f;
	font-size: 12px;
	letter-spacing: 1px;
	border-radius: 0;
	line-height: 64px;
	padding: 0;
	background-color: #ffffff;'>log in</button></a>	

	<h5 style='font-family: 'Roboto', sans-serif; font-weight: 300;'>
	Regards,
	<br>
	<b>Black Music</b>
	</h5>
	</div>
	";
	$mail->AddAddress($forgotPassword);
	$mail->send();
	echo $mail->ErrorInfo . "<br>";
	/*if(!$mail->Send()) {
		$message = $mail->ErrorInfo;
		header("location: password.php?message=$message");
	} else {
		$message = "Email sent!";
		header("location: password.php?message=$message");
	}*/
}

//send email to new users
if (isset($_GET['welcome'])) {
	extract($_GET);
	$mail->Subject = "Welcome to Black Music";
	$mail->Body = "
	<div style='box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; margin: 3%; padding: 3%;'>
	<center>
	<h3 style='font-family: 'Roboto', sans-serif; font-weight: 300;'>Hi there $username,</h3>

	<p style='font-family: 'Roboto', sans-serif; font-weight: 300;'>
	Welcome to Black Music,
	<br>
	Check out your favorite musicians and support them by buying their songs.
	<br>
	</p>

	<a href='http://music.black.co.ke/home.php'><button style='
	position: relative;
	z-index: 1;
	min-width: 90px;
	height: 33px;
	border: 1px solid;
	border-color: #2f2f2f;
	text-transform: uppercase;
	color: #2f2f2f;
	font-size: 12px;
	letter-spacing: 1px;
	border-radius: 0;
	line-height: 32px;
	padding: 0;
	background-color: #ffffff; >check it</button></a>	

	<h5 style='font-family: 'Roboto', sans-serif; font-weight: 300;'>
	Regards,
	<br>
	<b>Black Music</b>
	</h5>
	</div>
	";
	$mail->AddAddress($welcome);
	if (!empty($welcome)) {
		$mail->Send();
	}
		//set cookie for 30 days
	$cookie_time = time() + (86400 * 30);
	setcookie("username", $username, $cookie_time, "/");
	header("location: $from");
}

?>