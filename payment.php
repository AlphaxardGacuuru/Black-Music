
<?php
$user = $_COOKIE['username'];
include('variables.php');
$fname= "first_name"; 
$lname= "last_name"; 
$amount= "20.0"; 
$reference= "ODT2TA2060"; 
$sender_phone= "+254700123008";
$middle_name= "middle_name";
$service_name= "service_name";
$business_number= "business_number";
$internal_transaction_id= "internal_transaction_id";
$transaction_timestamp= "transaction_timestamp";
$transaction_type= "transaction_type";
$account_number= "account_number";
$currency= "currency";
$signature= "signature";


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

?>