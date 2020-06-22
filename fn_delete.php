<?php
include('variables.php');
	if (isset($_GET['fn_id'])) {
        extract($_GET);
        mysqli_query($con, "DELETE FROM f_notifies WHERE fn_id = '$fn_id'");
    }
	header('location:fanpage.php');