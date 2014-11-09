<?php
/***********************************************************
DoDirectPaymentReceipt.php

Submits a credit card transaction to PayPal using a
DoDirectPayment request.

The code collects transaction parameters from the form
displayed by DoDirectPayment.php then constructs and sends
the DoDirectPayment request string to the PayPal server.
The paymentType variable becomes the PAYMENTACTION parameter
of the request string.

After the PayPal server returns the response, the code
displays the API request and response in the browser.
If the response from PayPal was a success, it displays the
response parameters. If the response was an error, it
displays the errors.

Called by DoDirectPayment.php.

Calls CallerService.php and APIError.php.

***********************************************************/
require "../../includes/config.php";
require "../../includes/classes/ccvalidator.class.php";
require_once 'CallerService.php';

/**
 * Get required parameters from the web form for the request
 */
$paymentType =urlencode( $_POST['paymentType']);
$firstName =urlencode( $_POST['firstName']);
$lastName =urlencode( $_POST['lastName']);
$creditCardType =urlencode( $_POST['creditCardType']);
$creditCardNumber = urlencode($_POST['creditCardNumber']);
$expDateMonth =urlencode( $_POST['expDateMonth']);

// Month must be padded with leading zero
$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);

$expDateYear =urlencode( $_POST['expDateYear']);
$cvv2Number = urlencode($_POST['cvv2Number']);
$address1 = urlencode($_POST['address1']);
$address2 = urlencode($_POST['address2']);
$city = urlencode($_POST['city']);
$state =urlencode( $_POST['state']);
$zip = urlencode($_POST['zip']);
$amount = urlencode($_POST['amount']);
$rewardId = $_POST['rewardId'];
$projectId = $_POST['projectId'];
//$currencyCode=urlencode($_POST['currency']);
$currencyCode="USD";
$paymentType=urlencode($_POST['paymentType']);
if($_POST['creditCardType']=='Visa')
{
	$cardType = CCV_VISA;
}
elseif($_POST['creditCardType']=='MasterCard')
{
	$cardType = CCV_MASTER_CARD;
}
elseif($_POST['creditCardType']=='Discover')
{
	$cardType = CCV_DISCOVER;
}
else
{
	$cardType = CCV_AMERICAN_EXPRESS;
}
$ccv = new CCValidator($firstName, $cardType, $creditCardNumber, $padDateMonth, $expDateYear);
 if ($validCard = $ccv->validate())
  {
    if ($validCard & CCV_RES_ERR_HOLDER)
    {
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Card holder\'s name is missing or incorrect.');				
		redirect($base_url."modules/projectBacker/index.php?project=".$projectId);
    }

    if ($validCard & CCV_RES_ERR_TYPE)
    {
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Incorrect credit card type.');				
		redirect($base_url."modules/projectBacker/index.php?project=".$projectId);
    }    
    if ($validCard & CCV_RES_ERR_FORMAT)
    {
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Incorrect credit card number format.');				
		redirect($base_url."modules/projectBacker/index.php?project=".$projectId);      
    }

    if ($validCard & CCV_RES_ERR_NUMBER)
    {
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Invalid credit card number.');				
		redirect($base_url."projectBacker/index.php?project=".$projectId);  
    }

  }

/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";



/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
$resArray=hash_call("doDirectPayment",$nvpstr);

/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
$ack = strtoupper($resArray["ACK"]);

if($ack!="SUCCESS")  {
    $_SESSION['reshash']=$resArray;
	if($ack=="SuccessWithWarning")
	{
		$now = time();
		$inserTransaction = $con->insert("INSERT INTO paypaltransaction(correlationId,amount,transactionId,userId,dateTime,rewardId,projectId)
						VALUES ('".$resArray['CORRELATIONID']."', '".$amount."', '".$resArray['TRANSACTIONID']."', '".$_SESSION['userId']."',".$now.", ".$rewardId.", ".$projectId.")");
		$paypalId = mysql_insert_id();
		$projectBacking = $con->insert("INSERT INTO projectbacking (rewardId, projectId, userId, pledgeAmount, backingTime, paypalId)
					VALUES('".$rewardId."','".$projectId."', ".$_SESSION['userId'].", '".$amount."', ".time().",".$paypalId.");
");
//echo 'back'."UPDATE projectbasics set rewardedAmount = rewardedAmount +".$amount." where projectId =".$projectId. " LIMIT 1";exit;
		
		// jwg - also bump contributor count if first time contributing to this project
		$bumpcontributor = ''; 
		$backedbefore=$this->con->recordselect("SELECT * FROM projectbacking WHERE userId='$userId' and projectId='$projectId'");
		if(mysql_num_rows($backedbefore)<=0) { $bumpcontributor = ', rewardedContributor = rewardedContributor + 1'; }
			
		$updateProjectGoal = $con->update("UPDATE projectbasics set rewardedAmount = rewardedAmount +".$amount."$bumpcontributor where projectId =".$projectId. " LIMIT 1");
		
		$projectCreater = mysql_fetch_array($con->recordselect("SELECT * FROM projects as pro, users as usr, projectbasics as pb where pro.projectId=".$projectId." and pro.userId=usr.userId AND pb.projectId =".$projectId));
		if($projectCreater['pledgeMail']==1)
		{
			$artical1="";
			$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical1.="<body><strong>Hello ".$projectCreater['name'].", </strong><br />";
			$artical1.="<br />";			
			$artical1.= $_SESSION['name']." has pledged on your project <b>".$projectCreater['projectTitle']."</b><br />";
			$artical1.= "Amount: $".$amount."<br />"; 
			$artical1.= "Please visit pledged project by clicking on following link.<br />
			<a href='".$base_url."browseproject/".$projectId."/".Slug($projectCreater['projectTitle']).'/'."' target='_blank'>Click Here</a><br />";
			$artical1.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
			$subject1="Pledge on ".unsanitize_string(ucfirst($projectCreater['projectTitle']));
			$mailbody1=$artical1;
			$headers1 = "MIME-Version: 1.0\r\n";
			$headers1 .= "Content-type: text/html\r\n";
			$headers1 .= FROMEMAILADDRESS;
			@mail(base64_decode($projectCreater['emailAddress']), $subject1, $mailbody1, $headers1);
		}
	/*$inserTransaction = $con->insert("INSERT INO paypaltransaction(correlationId,amount,transactionId,userId)
						VALUES ('".$resArray['CORRELATIONID']."', ".$amount.", '".$resArray['TRANSACTIONID']."', ".$_SESSION['uid'].")");*/
						$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Thank you for backing the project ".$resArray['L_LONGMESSAGE0']);
										
						
						redirect($base_url."browseproject/project/".$projectId."/".Slug($projectCreater['projectTitle']).'/');
	}
	else
	{
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>$resArray['L_LONGMESSAGE0']);				
		redirect($base_url."browseproject/".$projectId."/".Slug($projectCreater['projectTitle']).'/');
		
	}
}
else
{
	/*save the backed details*/
	$now = time();
	$inserTransaction = $con->insert("INSERT INTO paypaltransaction(correlationId,amount,transactionId,userId,dateTime,rewardId,projectId)
						VALUES ('".$resArray['CORRELATIONID']."', '".$amount."', '".$resArray['TRANSACTIONID']."', '".$_SESSION['userId']."',".$now.", ".$rewardId.", ".$projectId.")");
	$paypalId = mysql_insert_id();
	$projectBacking = $con->insert("INSERT INTO projectbacking (rewardId, projectId, userId, pledgeAmount, backingTime, paypalId)
					VALUES('".$rewardId."','".$projectId."', ".$_SESSION['userId'].", '".$amount."', ".time().",".$paypalId.");");

	// jwg - also bump contributor count if first time contributing to this project
	$bumpcontributor = ''; 
	$backedbefore=$this->con->recordselect("SELECT * FROM projectbacking WHERE userId='$userId' and projectId='$projectId'");
	if(mysql_num_rows($backedbefore)<=0) { $bumpcontributor = ', rewardedContributor = rewardedContributor + 1'; }
	//$updateProjectGoal = $con->update("UPDATE projectbasics set rewardedAmount = rewardedAmount +".$amount." where projectId =".$projectId. " LIMIT 1");
	$updateProjectGoal = $con->update("UPDATE projectbasics set rewardedAmount = rewardedAmount +".$amount."$bumpcontributor where projectId =".$projectId. " LIMIT 1");
	
	$projectCreater = mysql_fetch_array($con->recordselect("SELECT * FROM projects as pro, users as usr, projectbasics as pb where pro.projectId=".$projectId." and pro.userId=usr.userId AND pb.projectId =".$projectId));
		if($projectCreater['pledgeMail']==1)
		{
			$artical1="";
			$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical1.="<body><strong>Hello ".$projectCreater['name'].", </strong><br />";
			$artical1.="<br />";			
			$artical1.= $_SESSION['name']." has pledged on your project <b>".$projectCreater['projectTitle']."</b><br />";
			$artical1.= "Amount: $".$amount."<br />"; 
			$artical1.= "Please visit pledged project by clicking on following link.<br />
			<a href='".$base_url."browseproject/".$projectId."/".Slug($projectCreater['projectTitle']).'/'."' target='_blank'>Click Here</a><br />";
			$artical1.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
			$subject1="Pledge on ".unsanitize_string(ucfirst($projectCreater['projectTitle']));
			$mailbody1=$artical1;
			$headers1 = "MIME-Version: 1.0\r\n";
			$headers1 .= "Content-type: text/html\r\n";
			$headers1 .= FROMEMAILADDRESS;
			@mail(base64_decode($projectCreater['emailAddress']), $subject1, $mailbody1, $headers1);
		}
	/*$inserTransaction = $con->insert("INSERT INO paypaltransaction(correlationId,amount,transactionId,userId)
						VALUES ('".$resArray['CORRELATIONID']."', ".$amount.", '".$resArray['TRANSACTIONID']."', ".$_SESSION['uid'].")");*/
						$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Thank you for backing the project");				
						redirect($base_url."browseproject/".$projectId."/".Slug($projectCreater['projectTitle']).'/');
						
}


?>