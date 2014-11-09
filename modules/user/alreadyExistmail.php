<?php
$valid = 'true';
require_once("../../includes/config.php");
$arrayToJs = array();
$validateId=$_GET['fieldId'];
$arrayToJs[0] = $validateId;

if($validateId=='emailid')
{
	$validateError = "This email is already taken";
    $validateSuccess = "This email is available";
	$uname=$_REQUEST['fieldValue'];
	//$fields = 'email';
	//$table = "users";
	//$condition = array('email'=>$uname);
	//$selectIsValidEmailResult 	= $con->get_record_by_conditions($fields,$table,$condition);

    $email_valid=mysql_query("SELECT `emailAddress` FROM `users` WHERE `emailAddress` = '".base64_encode($uname)."'");
        $selectIsValidEmailResult=mysql_num_rows($email_valid);
         if($selectIsValidEmailResult>0)


	//if(!$selectIsValidEmailResult)
    {
	$arrayToJs[1] = true;			// RETURN TRUE
	echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
	}
     else
	 {
		$arrayToJs[1] = false;
		echo json_encode($arrayToJs);
	 }	
}

//echo $valid;
?>