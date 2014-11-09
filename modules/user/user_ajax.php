<?php
	require_once("../../includes/config.php");
	
	if(isset($_GET) && isset($_GET['user_email']) && ($_GET['user_email'] != '')) {
		$emailid = base64_encode($_GET['user_email']);
		$email_valid = $con->recordselect("SELECT `emailAddress` FROM `users` WHERE `emailAddress` = '".$emailid."'");
		$email_valid1 = mysql_num_rows($email_valid);
		if($email_valid1>0)
		{
			echo "1";
		}else{
			echo "0";
		}
	}
	else if(isset($_REQUEST['captcha'])) {
		//	echo 'hi';exit;
		if($_REQUEST['captcha']!=$_SESSION['rand_code']) {
			$valid='false'; // Not Allowed
		} else {
			$valid='true'; // Allowed
		}
	echo $valid;
	}
?>