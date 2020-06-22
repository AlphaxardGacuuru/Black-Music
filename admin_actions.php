<?php
$user = $_COOKIE['username'];
if (empty($user)) {
	header('location: index.php');
}
include('variables.php');
$date = date("d-M-Y");
$time = date("h:ia");
if (isset($_GET['user_id'])) {
	extract($_GET);
	$check_acctype = mysqli_query($con, "SELECT * FROM users WHERE user_id = '$user_id' ");
	$acc_check_fetch = mysqli_fetch_assoc($check_acctype);
	extract($acc_check_fetch);
	if ($gender == 'female') {
		$pp_new = "img/female_musician.png";
		$pp_new_2 = "img/female_avatar.png";
	} else {
		$pp_new = "img/male_musician.png";
		$pp_new_2 = "img/male_avatar.png";
	}
	if ($acc_type == 'normal') {
		$newPhone = substr_replace($phone, '0', 0, -9);
		$password = md5($newPhone);
		$change_acctype = "UPDATE users SET acc_type = 'musician', password = '$password' WHERE user_id = '$user_id'";
		$acc_query = mysqli_query($con, $change_acctype);
		$change_pp = mysqli_query($con, "UPDATE users SET pp_path = '$pp_new' WHERE user_id = $user_id");
	} else {
		$change_acctype = "UPDATE users SET acc_type = 'normal' WHERE user_id = '$user_id'";
		$acc_query = mysqli_query($con, $change_acctype);
		$change_pp = mysqli_query($con, "UPDATE users SET pp_path = '$pp_new_2' WHERE user_id = $user_id");
	}
	header("location: $from.php");
}

//Song payout to artists
if (isset($_GET["spayout_artist"])) {
	extract($_GET);
	$payoutInfo = mysqli_query($con, "SELECT * FROM users WHERE username = '$payout_artist' ");
	$fetchInfo = mysqli_fetch_assoc($payoutInfo);
	extract($fetchInfo);
	$payoutQuer = mysqli_query($con, "INSERT INTO payouts (`payout_id`, `payout_artist`, `payout_phone`, `payout_email`, `payout_amount`, `payout_date`, `payout_time`) VALUES (NULL, '$spayout_artist', '$phone', '$email', '$payout_amount', '$date', '$time')");

	//Send email 
	require_once("PHPMailer/PHPMailerAutoload.php");

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "mail.black.co.ke";
		//$mail->Host = "smtp.gmail.com";
	$mail->Port = "465";
	$mail->isHTML();
	$mail->Username = "info@black.co.ke";
	$mail->Password = "sw[$4#3n{&qu";
	$mail->SetFrom("info@black.co.ke", "Black Music");
	$mail->Subject = "Payment";
	$mail->Body = "
	<div style='box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; margin: 3%; padding: 3%;'>
	<center>
	<h3 style='font-family: 'Roboto', sans-serif; font-weight: 300;'>Hi there $payout_artist,</h3>

	<p style='font-family: 'Roboto', sans-serif; font-weight: 300;'>
	Payment of <span style='color: green'>KES $payout_amount</span> sent to $phone.
	<br>
	Thanks for being part of Black Music, you are highly appreciated!
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
	background-color: #ffffff; '>check it</button></a>	

	<h5 style='font-family: 'Roboto', sans-serif; font-weight: 300;'>
	Regards,
	<br>
	<b>Black Music</b>
	</h5>
	</div>
	";
	$mail->AddAddress($email);
	$mail->Send();
	header("location: payouts.php");
}

//Referral payout to artists
if (isset($_GET["rPayoutUsername"])) {
	extract($_GET);
	$payoutInfo = mysqli_query($con, "SELECT * FROM users WHERE username = '$rPayoutUsername' ");
	$fetchInfo = mysqli_fetch_assoc($payoutInfo);
	extract($fetchInfo);
	$payoutQuer = mysqli_query($con, "INSERT INTO `rpayouts` (`rpayout_id`, `rpayout_username`, `rpayout_phone`, `rpayout_email`, `rpayout_amount`, `rpayout_date`, `rpayout_time`) VALUES (NULL, '$rPayoutUsername', '$phone', '$email', '$rPayoutAmount', '$date', '$time')");

	//Send email 
	require_once("PHPMailer/PHPMailerAutoload.php");

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "mail.black.co.ke";
		//$mail->Host = "smtp.gmail.com";
	$mail->Port = "465";
	$mail->isHTML();
	$mail->Username = "info@black.co.ke";
	$mail->Password = "sw[$4#3n{&qu";
	$mail->SetFrom("info@black.co.ke", "Black Music");
	$mail->Subject = "Payment";
	$mail->Body = "
	<div style='box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; margin: 3%; padding: 3%;'>
	<center>
	<h3 style='font-family: 'Roboto', sans-serif; font-weight: 300;'>Hi there $rpayout_artist,</h3>

	<p style='font-family: 'Roboto', sans-serif; font-weight: 300;'>
	Payment of <span style='color: green'>KES $payout_amount</span> sent to $phone.
	<br>
	Thanks for being part of Black Music, you are highly appreciated!
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
	background-color: #ffffff; '>check it</button></a>	

	<h5 style='font-family: 'Roboto', sans-serif; font-weight: 300;'>
	Regards,
	<br>
	<b>Black Music</b>
	</h5>
	</div>
	";
	$mail->AddAddress($email);
	$mail->Send();
	header("location: payouts.php");
}

/*Automatically add Trend Date to DB*/
mysqli_query($con, "INSERT INTO `trend_week` (`trend_week_id`, `trend_week_date`, `trend_week_time`) VALUES (NULL, '$trend_week_date', '$trend_week_time')");
?>