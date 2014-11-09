<?php
require_once("../includes/config.php");
$emailid=$_GET['user_email'];
$id=$_GET['id'];
		$user_name_old=mysql_fetch_array($con->recordselect("SELECT `emailAddress` FROM `users` WHERE userId = '".$id."'"));
		$old=$user_name_old['emailAddress'];
        $user_name_new=$con->recordselect("SELECT `emailAddress` FROM `users` WHERE `emailAddress` = '".$emailid."'");
		$new_nm=mysql_fetch_array($user_name_new);
		$new=$new_nm['emailAddress'];
		if($old!=$new)
		{
			//$email_valid=$con->recordselect("SELECT `emailAddress` FROM `users` WHERE `emailAddress` = '".$emailid."'");
			$email_valid1=mysql_num_rows($user_name_new);
			if($email_valid1>0)
			{
				echo "1";
			}
			else
			{
				echo "0";
			}
		}
		else
		{
			echo "0";
		}
?>
