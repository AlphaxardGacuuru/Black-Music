<?php
header("Content-Type:application/json");
if (!isset($_GET["token"]))
{
	echo "Technical error";
	exit();
}
if ($_GET["token"]!='4HWjtR6B2UT4'){

	echo "Invalid authorization";
	exit();
}
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);


$fname= $data->first_name; 
$lname= $data->last_name; 
$amount= $data->amount; 
$reference= $data->transaction_reference; 
$sender_phone= $data->sender_phone;
$middle_name= $data->middle_name;
$service_name= $data->service_name;
$business_number= $data->business_number;
$internal_transaction_id= $data->internal_transaction_id;
$transaction_timestamp= $data->transaction_timestamp;
$transaction_type= $data->transaction_type;
$account_number= $data->account_number;
$currency= $data->currency;
$signature= $data->signature;





 // Include config file
//require_once "config.php";
include('variables.php');

$sql1="INSERT INTO kopokopo
( 
	sender_phone,
	reference,
	amount,
	last_name,
	first_name,
	middle_name,
	service_name,
	business_number,
	internal_transaction_id,
	transaction_timestamp,
	transaction_type,
	account_number,
	currency,
	signature
)  
VALUES  
( 
	'$sender_phone', 
	'$reference', 
	'$amount', 
	'$lname', 
	'$fname',
	'$middle_name',
	'$service_name',
	'$business_number',
	'$internal_transaction_id',
	'$transaction_timestamp',
	'$transaction_type',
	'$account_number',
	'$currency',
	'$signature'
)";

if (!mysqli_query($con,$sql1))
{ 
	echo mysqli_error($con); 
} 

//get user info
$getEmail = mysqli_query($con, "SELECT * FROM users WHERE phone = '$sender_phone' ");
if ($fetchEmail = mysqli_fetch_assoc($getEmail)) {
	extract($fetchEmail);
}

//send reciept
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
$mail->Subject = "Payment received";
$mail->Body = "
<div style='box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; margin: 3%; padding: 3%;'>
<center>
<h3 style='font-family: 'Roboto', sans-serif; font-weight: 300;'>Hi there $username,</h3>

<p style='font-family: 'Roboto', sans-serif; font-weight: 300;'>
Payment of <span style='color: green'>KES $amount</span> received.
<br>
Thanks for supporting local Artists.
<br>
</p>

<a href='http://music.black.co.ke/index.php'><button style='
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

//send reciept to Black Music
$mail->Subject = "New payment";
$mail->Body = "
<div style='box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; margin: 3%; padding: 3%;'>
<center>
<h3 style='font-family: 'Roboto', sans-serif; font-weight: 300;'>Hi there Black Music,</h3>

<p style='font-family: 'Roboto', sans-serif; font-weight: 300;'>
$username just payed <span style='color: green'>KES $amount</span>.
<br>
Thanks for supporting local Artists.
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
$mail->AddAddress("info@black.co.ke");
$mail->Send();

	//get transactions to check if there's a balance
	// $checkTrans = mysqli_query($con, "SELECT * FROM transactions WHERE sender_phone = '$sender_phone' ");
	// if ($fetchTrans = mysqli_fetch_assoc($checkTrans)) {
	// 	extract($fetchTrans);
	// 	$amountToAdd = 20-$transaction_amount;
	// 	$updatedAmount = $amountToAdd + $transaction_amount;
	// 	if ($amount == $amountToAdd) {
	// 	$updateTrans = mysqli_query($con, "UPDATE transactions SET transaction_amount = '$updatedAmount' WHERE sender_phone = '$sender_phone' ");
	// 	$amount = $amount-$amountToAdd; 
	// 	echo "<br>$amount";
	// 	}
	// }

	// $bits = intval($amount/20);
	// $rem = $amount%20;
	// echo "<br>$bits, $rem";

	//insert into transactions
	// for ($i=0; $i < $bits; $i++) { 
	// 	mysqli_query($con, "INSERT INTO `transactions` (`id`, `transaction_reference`, `sender_phone`, `first_name`, `middle_name`, `last_name`, `transaction_amount`) VALUES (NULL, '$reference', '$sender_phone', '$fname', '$middle_name', '$lname', '20')");
	// }
	// if ($rem != 0) {
	// if (mysqli_num_rows($checkTrans)==1) {
	// 	extract($fetchTrans);
	// 	$updateTrans = mysqli_query($con, "UPDATE transactions SET transaction_amount = $transaction_amount+$rem WHERE sender_phone = '$sender_phone' ");
	// } else {
	// 	mysqli_query($con, "INSERT INTO `transactions` (`id`, `transaction_reference`, `sender_phone`, `first_name`, `middle_name`, `last_name`, `transaction_amount`) VALUES (NULL, '$reference', '$sender_phone', '$fname', '$middle_name', '$lname', '$rem')");
	// }
	// }
?>