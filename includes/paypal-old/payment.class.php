<?php 
class Payment
{
	var $PayPalConfig=array();
	var $con;
	function __construct($Config)
	{
	//	print 'b';
		global $con;
		$this->con=$con;
		$this->PayPalConfig = $Config;
	//	print_r($Config);
		//print $this->PayPalConfig;
	}
	
	// jwg -- added
	function backerPreapprovePayment($array)
	{
		extract($array);
		
		// the following (other than user_amount name change) are a bit redundant
		// but here for a touch of security...
		$backerId = sanitize_string($array['backerId']);
		$user_amount = sanitize_string($array['amount']);
		$projectId = sanitize_string($array['projectId']);
		$rewardId = sanitize_string($array['rewardId']);
		$TrackingID=generate_password(5);
		
		$user = mysql_fetch_array($this->con->recordselect("SELECT * from `users` where `userId` = " . $_SESSION['userId']));			
		//$backer_paypal = base64_decode($user['paypalUserAccount']);
		$backer_email = base64_decode($user['emailAddress']);
		$senderPhoneCountryCode = '';
		$senderPhone = '';
		$project_rcd = mysql_fetch_array($this->con->recordselect("SELECT * from `projects` where `projectId` = $projectId "));		
		$creator = mysql_fetch_array($this->con->recordselect("SELECT * from `users` where `userId` = " . $project_rcd['userId']));			
		$creator_paypal = base64_decode($creator['paypalUserAccount']);
		$project = mysql_fetch_array($this->con->recordselect("SELECT * from `projectbasics` where `projectId` = $projectId "));		
		$Memo = "Support CrowdedRocket project: ".$project['projectTitle'];
		$CurrencyCode='USD';
		$DateOfMonth='0';
		$DayOfWeek='NO_DAY_SPECIFIED';
		$StartingDate=date('Y-m-d',strtotime("+10 minutes",$project['projectEnd']));
		$EndingDate=date('Y-m-d',strtotime("+5 days",$project['projectEnd']));
		$IPNNotificationURL='';
		$MaxAmountPerPayment=$user_amount;
		$MaxNumberOfPayments=1;
		$MaxTotalAmountOfAllPaymentsPerPeriod=$user_amount;
		$MaxTotalAmountOfAllPayments=$user_amount;
		$PaymentPeriod='NO_PERIOD_SPECIFIED';
		$PinType='NOT_REQUIRED';
		$ReturnURL=SITE_URL.'thankyou.php?projectId='.$projectId.'&trackingId='.$TrackingID;
		//$CancelURL =SITE_URL."browseproject/".$projectId."/".Slug($selectProject['projectTitle']).'/';
		$CancelURL=SITE_URL.'precancel.php?projectId='.$projectId.'&trackingId='.$TrackingID;
		//$SenderEmail='admin@'.$_SERVER['SERVER_NAME'];
		$FeesPayer='PRIMARYRECEIVER';
		$DisplayMaxTotalAmount=true;
		$CustomerID=$backerId;
		$CustomerType='Backer';
		$GeoLocation='';
		$Model='1.0';
		$PartnerName=DISPLAYSITENAME;			
		
		$commission = get_commission($projectId,$user_amount,'0','p');
		
		// Prepare request arrays
		$PreapprovalFields = array(
								   'CancelURL' => $CancelURL,  								// Required.  URL to send the browser to after the user cancels.
								   'CurrencyCode' => $CurrencyCode, 							// Required.  Currency Code.
								   'DateOfMonth' => $DateOfMonth, 							// The day of the month on which a monthly payment is to be made.  0 - 31.  Specifying 0 indiciates that payment can be made on any day of the month.
								   'DayOfWeek' => $DayOfWeek, 								// The day of the week that a weekly payment should be made.  Allowable values: NO_DAY_SPECIFIED, SUNDAY, MONDAY, TUESDAY, WEDNESDAY, THURSDAY, FRIDAY, SATURDAY
								   'EndingDate' => $EndingDate, 								// Required.  The last date for which the preapproval is valid.  It cannot be later than one year from the starting date.
								   'IPNNotificationURL' => $IPNNotificationURL, 						// The URL for IPN notifications.
								   'MaxAmountPerPayment' => $MaxAmountPerPayment, 					// The preapproved maximum amount per payment.  Cannot exceed the preapproved max total amount of all payments.
								   'MaxNumberOfPayments' => $MaxNumberOfPayments, 					// The preapproved maximum number of payments.  Cannot exceed the preapproved max total number of all payments. 
								   'MaxTotalAmountOfAllPaymentsPerPeriod' =>$MaxTotalAmountOfAllPaymentsPerPeriod, 	// The preapproved maximum number of all payments per period.
								   'MaxTotalAmountOfAllPayments' => $MaxTotalAmountOfAllPayments, 			// The preapproved maximum total amount of all payments.  Cannot exceed $2,000 USD or the equivalent in other currencies.
								   'Memo' => $Memo, 									// A note about the preapproval.
								   'PaymentPeriod' => $PaymentPeriod, 							// The pament period.  One of the following:  NO_PERIOD_SPECIFIED, DAILY, WEEKLY, BIWEEKLY, SEMIMONTHLY, MONTHLY, ANNUALLY
								   'PinType' => $PinType, 								// Whether a personal identification number is required.  It is one of the following:  NOT_REQUIRED, REQUIRED
								   'ReturnURL' => $ReturnURL, 								// URL to return the sender to after approving at PayPal.
								   'SenderEmail' => $backer_email, 							// Sender's email address.  If not specified, the email address of the sender who logs on to approve is used.
								   'StartingDate' => $StartingDate, 							// Required.  First date for which the preapproval is valid.  Cannot be before today's date or after the ending date.
								   'FeesPayer' => $FeesPayer, 								// The payer of the PayPal fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
								   'DisplayMaxTotalAmount' => $DisplayMaxTotalAmount					// Whether to display the max total amount of this preapproval.  Values are:  true/false
								   );
		$ClientDetailsFields = array(
									 'CustomerID' => $CustomerID, 						// Your ID for the sender.
									 'CustomerType' => $CustomerType, 						// Your ID of the type of customer.
									 'GeoLocation' => $GeoLocation, 						// Sender's geographic location.
									 'Model' => $Model, 							// A sub-id of the application
									 'PartnerName' => $PartnerName						// Your organization's name or ID.
									 );
/*									 
		$Receivers = array();
		$Receiver = array(
						'Amount' => $commission, 											
						'Email' => $this->PayPalConfig["DeveloperAccountEmail"],  												
						'InvoiceID' => '', 											
						'PaymentType' => '', 										
						'PaymentSubType' => '', 									
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), 
						'Primary' => 'FALSE'												
						);
		array_push($Receivers,$Receiver);			
		$Receiver = array(
						'Amount' => $user_amount, 											
						'Email' =>$creator_paypal, 												
						'InvoiceID' => '', 											
						'PaymentType' => '', 										
						'PaymentSubType' => '', 									
						'Phone' => array('CountryCode' => $senderPhoneCountryCode, 'PhoneNumber' => $senderPhone, 'Extension' => ''), 
						'Primary' => 'TRUE'												
						);
		array_push($Receivers,$Receiver);	
		
		$PayPalRequestData = array(
							 'PreapprovalFields' => $PreapprovalFields, 
							 'ClientDetailsFields' => $ClientDetailsFields,
							 'Receivers' => $Receivers
							 );
*/		
		$PayPalRequestData = array(
							 'PreapprovalFields' => $PreapprovalFields, 
							 'ClientDetailsFields' => $ClientDetailsFields
							 );
							 
		// Pass data into class for processing with PayPal and load the response array into $PayPalResult
		$PayPal = new PayPal_Adaptive($this->PayPalConfig);
		
		wrtlog("backerPreapprovePayment requesting Preapproval using: ".print_r($PayPalRequestData,true));
		$PayPalResult = $PayPal->Preapproval($PayPalRequestData);
		wrtlog("backerPreapprovePayment after Preapproval - PayPalResult: ".print_r($PayPalResult,true));
 
		/* ex per paypal doc
		Response
		--------
		responseEnvelope.ack=Success
		&preapprovalKey=PA-5KY19448VE6821234 #Value of the preapproval key, for use in subsequent steps
		
		However, what we get back from paypal.adaptive.class.php is array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'PreapprovalKey' => $PreapprovalKey, 
								   'RedirectURL' => $PreapprovalKey != '' ? $RedirectURL : '', 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse)
		//// expect only the Ack, PreapprovalKey, RedirectURL, XMLRequest and XMLResponse to be filled..
		*/
			if(isset($PayPalResult['Ack']) && (strtolower($PayPalResult['Ack'])=='success'))
			{
				// jwg -- $PayPalResult contains both the current TrackingID and the new CorrelationID
				if (!isset($PayPalResult['PreapprovalKey'])) {
					$errors = "UNEXPECTED - no PreapprovalKey in paypal preapproval response.";
					wrtlog($errors);
					wrtlog("PayPalResult from Preapproval: ".print_r($PayPalResult,true));
					$_SESSION['msgType1'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>$errors);		
					return SITE_URL."projectBacker/".$projectId;
				} else {
					// Create a pre-approved projectbacking record including the preapproval key
					$final_arr=array();
					foreach($PayPalRequestData as $K=>$P)
					{
						$final_arr['request.'.addslashes($K)]=addslashes((is_array($P)?json_encode($P):$P));
					}
					foreach($PayPalResult as $K=>$P)
					{
						$final_arr[addslashes($K)]=addslashes((is_array($P)?json_encode($P):$P));
					}
					$this->con->insert("insert into preapproval_detail (detail) values ('".json_encode($final_arr)."')");
					$preapproval_detail_id=mysql_insert_id();					
					
					// create initial backing record with payment_status='?'
					$this->con->insert("INSERT INTO `projectbacking` ".
						"(rewardId, projectId, userId, pledgeAmount, backingTime, paypalId,preapproval_detail_id,payment_status,preapproval_key,tracking_id,pledgeCommision) ".
						"VALUES('".$rewardId."','".$projectId."', ".$backerId.", '".$user_amount."', ".time().",NULL,'".$preapproval_detail_id."','?','".$PayPalResult['PreapprovalKey']."','".$TrackingID."','".$commission."')");
					
					wrtlog("backerPreapprovePayment redirecting to ". $PayPalResult['RedirectURL']);
					redirect($PayPalResult['RedirectURL']); // This is where user makes actual decision to pre-approve
					// control returns to either ReturnURL (thankyou.php) or CancelURL (precancel.php)
				}
			}
			else
			{
				//$PayPalErrorsSerialized = serialize($PayPalResult['Errors']);
				//$PayPalErrorsUnserialized = unserialize($PayPalErrorsSerialized);
				//print $PayPalErrorsSerialized;
				$error=array();
				foreach($PayPalResult['Errors'] as $er)
				{
					$error[]=$er['Message'];
				}
				$errors=implode("<br/>",$error);
				$_SESSION['msgType1'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>$errors);		
				return SITE_URL."projectBacker/".$projectId;
			}
	
	}
	
	// jwg -- In original code from NCrypted this was called from link in projectBacker/paypalInfo.tpl.php
	// at time that user approved backing amount -- and caused immediate payment from backer to owner.
	// In crowdedrocket revision we trigger proper preapproval by form submission from paypalInfo.tpl.php
	// and save the preapproval key and expected implications in projectbacking table, etc., to show impact
	// on funding goal. There is no actual transaction associated with the backing at that time.
	// Then - at cron job call to check_project_status on success we call pay_to_creator_on_success 
	// which calls payExecute_Successful which calls ExecutePayment paypal api for each preapproval.
	// and on project failure to fund we call pay_to_backers_on_refund which is now changed to 
	// use preapproval keys to call CancelPreapproval paypal api -- rather than refund.
	// The following related set of functions are no longer used.
	/*
	function takePreApprovalFromBacker($array)
	{
		wrtlog("IN takePreApprovalFromBacker with array=".print_r($array,true));
		
		// set defaults (in case not supplied by $array)
		$commision=0;
		$backer_phone='';
		$amount=0;
		$CurrencyCode='USD';
		$FeesPayer='';		
		$userPhoneCountryCode='';
		$Memo='';
		$Pin='';
		$PreapprovalKey='';
		$SenderEmail='';
		$CustomerID='';
		$CustomerType='';
		$GeoLocation='';
		$Model='';
		$PartnerName='';
		$UseCredentials='';
		$senderPhoneExtension='';
		
		extract($array);
		
		$PayPal = new PayPal_Adaptive($this->PayPalConfig);

		$_SESSION['project_ids'][]=$projectId;
		$CancelURL = SITE_URL.'failed/?projectId='.$projectId;
		$querystring='';
		$query_string_array=array('projectId','backer_id','rewardId','amount','commision');
		foreach($array as $q=>$v)
		{
			if(in_array($q,$query_string_array))
			{
				$querystring.="&".$q."=".urlencode($v);
			}
		}

		$user_amount=$amount;
		$creator_amount=$commision;
		$userEmail=$backer_email;
		$ActionType='PAY'; // jwg ... NCrypted error .. should NOT be 'PAY_PRIMARY';
		$CancelURL = SITE_URL.'failed/?projectId='.$projectId;
		$IPNNotificationURL=SITE_URL.'includes/paypal/notify.php?q='.urlencode(substr($querystring,1));
		$ReturnURL=SITE_URL.'thankyou/?projectId='.$projectId;
		$userPhone=$backer_phone;
		$ReverseAllParallelPaymentsOnError=TRUE;
		$TrackingID=generate_password(5);
		$senderPhone=$userPhone;
		$senderPhoneCountryCode=$userPhoneCountryCode;

		$Receivers = array();
		$Receiver = array(
						'Amount' => $creator_amount, 											
						'Email' => $this->PayPalConfig["DeveloperAccountEmail"], 												
						'InvoiceID' => '', 											
						'PaymentType' => '', 										
						'PaymentSubType' => '', 									
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), 
						'Primary' => 'FALSE'												
						);
		array_push($Receivers,$Receiver);			
		$Receiver = array(
						'Amount' => $user_amount, 											
						'Email' =>$creator_paypal, 												
						'InvoiceID' => '', 											
						'PaymentType' => '', 										
						'PaymentSubType' => '', 									
						'Phone' => array('CountryCode' => $senderPhoneCountryCode, 'PhoneNumber' => $senderPhone, 'Extension' => ''), 
						'Primary' => 'TRUE'												
						);
		array_push($Receivers,$Receiver);				
			//	echo '<pre />';
			
		//wrtlog("receivers=" . print_r($Receivers,true)); // DEBUG		
			
			//print_r($Receivers);
		// Prepare request arrays
		$PayRequestFields = array(
								'ActionType' => $ActionType, 								// Required.  Whether the request pays the receiver or whether the request is set up to create a payment request, but not fulfill the payment until the ExecutePayment is called.  Values are:  PAY, CREATE, PAY_PRIMARY
								'CancelURL' => $CancelURL, 									// Required.  The URL to which the sender's browser is redirected if the sender cancels the approval for the payment after logging in to paypal.com.  1024 char max.
								'CurrencyCode' => $CurrencyCode, 								// Required.  3 character currency code.
								'FeesPayer' => $FeesPayer, 									// The payer of the fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
								'IPNNotificationURL' => $IPNNotificationURL, 						// The URL to which you want all IPN messages for this payment to be sent.  1024 char max.
								'Memo' => $Memo, 										// A note associated with the payment (text, not HTML).  1000 char max
								'Pin' => $Pin, 										// The sener's personal id number, which was specified when the sender signed up for the preapproval
								'PreapprovalKey' => $PreapprovalKey, 							// The key associated with a preapproval for this payment.  The preapproval is required if this is a preapproved payment.  
								'ReturnURL' => $ReturnURL, 									// Required.  The URL to which the sener's browser is redirected after approvaing a payment on paypal.com.  1024 char max.
								'ReverseAllParallelPaymentsOnError' => $ReverseAllParallelPaymentsOnError, 			// Whether to reverse paralel payments if an error occurs with a payment.  Values are:  TRUE, FALSE
								'SenderEmail' => $SenderEmail, 								// Sender's email address.  127 char max.
								'TrackingID' => $TrackingID									// Unique ID that you specify to track the payment.  127 char max.
								);
							
		//wrtlog("PayRequestFields=" . print_r($PayRequestFields,true)); // DEBUG	
							
		$ClientDetailsFields = array(
								'CustomerID' => $CustomerID, 								// Your ID for the sender  127 char max.
								'CustomerType' => $CustomerType, 								// Your ID of the type of customer.  127 char max.
								'GeoLocation' => $GeoLocation, 								// Sender's geographic location
								'Model' => $Model, 										// A sub-identification of the application.  127 char max.
								'PartnerName' => $PartnerName									// Your organization's name or ID
								);
								
							
		//wrtlog("ClientDetailsFields=" . print_r($ClientDetailsFields,true)); // DEBUG						
								
		$FundingTypes = array('ECHECK', 'BALANCE', 'CREDITCARD');
		
		
		
		$SenderIdentifierFields = array(
										'UseCredentials' => $UseCredentials						// If TRUE, use credentials to identify the sender.  Default is false.
										);
										
		$AccountIdentifierFields = array(
										'Email' => $SenderEmail, 								// Sender's email address.  127 char max.
										'Phone' => array('CountryCode' => $senderPhoneCountryCode, 'PhoneNumber' => $senderPhone, 'Extension' => $senderPhoneExtension)								// Sender's phone number.  Numbers only.
										);
										
		$PayPalRequestData = array(
							'PayRequestFields' => $PayRequestFields, 
							'ClientDetailsFields' => $ClientDetailsFields, 
							'FundingTypes' => $FundingTypes, 
							'Receivers' => $Receivers, 
							'SenderIdentifierFields' => $SenderIdentifierFields, 
							'AccountIdentifierFields' => $AccountIdentifierFields
							);


			// Pass data into class for processing with PayPal and load the response array into $PayPalResult
			wrtlog("PayPalRequestData: ".print_r($PayPalRequestData,true));
			$PayPalResult = $PayPal->Pay($PayPalRequestData);
			wrtlog("PayPalResult from ->Pay in takePreApprovalFromBacker: ".print_r($PayPalResult,true)); // DEBUG
			
			// Write the contents of the response array to the screen for demo purposes.
			//echo '<pre />';
			
			//print_r($PayPalResult);
			if(strtolower($PayPalResult['Ack'])=='success')
			{
				// jwg -- $PayPalResult contains both the current TrackingID and the new CorrelationID
				if (!isset($PayPalResult['TrackingID']) || !isset($PayPalResult['CorrelationID']) || ($PayPalResult['TrackingID'] != $TrackingID)) {
					$errors = "UNEXPECTED - no matching TrackingID or no CorrelationID in pay response.";
					wrtlog($errors);
					wrtlog("  TrackingID: $TrackingID");
					wrtlog("  request data: ".print_r($PayPalRequestData,true));
					wrtlog("  result: ".print_r($PayPalResult,true));
					$_SESSION['msgType1'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>$errors);		
					return SITE_URL."projectBacker/".$projectId;
				} else {
					$this->con->insert("INSERT INTO `paypaltracking` (`TrackingID`, `correlationID`) VALUES ('".$TrackingID."','".$PayPalResult['CorrelationID']."')");
					//wrtlog("Saved CorrelationID {$PayPalResult['CorrelationID']} for TackingID $TrackingID");
					return $this->takePreApprovalFromBacker_success($PayPalResult);
				}
			}
			else
			{
				//$PayPalErrorsSerialized = serialize($PayPalResult['Errors']);
				//$PayPalErrorsUnserialized = unserialize($PayPalErrorsSerialized);
				//print $PayPalErrorsSerialized;
				$error=array();
				foreach($PayPalResult['Errors'] as $er)
				{
					$error[]=$er['Message'];
				}
				$errors=implode("<br/>",$error);
				$_SESSION['msgType1'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>$errors);		
				return SITE_URL."projectBacker/".$projectId;
			}
	}
	
	function  takePreApprovalFromBacker_success($PayPalResult)
	{		
		return  $PayPalResult['RedirectURL'];
	}
	
	function takePreApprovalFromBacker_notify($array)
	{
		extract($array);

		//wrtlog("takePreApprovalFromBacker_notify at 243");
			if(strtolower($array['status'])!='error' && $array['projectId']>0 && $array['backer_id']>0 && strtoupper($array['action_type'])=='PAY_PRIMARY' && strtolower($array['transaction_type'])=='adaptive payment pay')
			{
				//wrtlog("takePreApprovalFromBacker_notify at 246");
				//check for paykey because this notify is called everytime on any operation like refund/ execute so we are checking paykey if it exists then this is refund or execution and we don't need to do anything on notify.If entry not exists then this payment is backing payment(pay_primary) and we have to add this entry in db from notify
				if (!isset($CorrelationID) || empty($CorrelationID)) { // jwg - the likely case ... barring 'magic happened'
					//wrtlog("takePreApprovalFromBacker_notify at 249");
					// get correlationID from new table based on trackingId
					$check_tracking=$this->con->recordselect("SELECT `correlationID` FROM `paypaltracking` WHERE `TrackingID`='$tracking_id'");
					if(mysql_num_rows($check_tracking)==1) {
						$tracking = mysql_fetch_assoc($check_tracking);
						$correlationId=$tracking['correlationID'];
						//wrtlog("FOUND correlationId $correlationId using trackingId $tracking_id"); // debug
					} else {
						$correlationId='--NO ID--';
						wrtlog("NO correlationID available for tracking id $tracking_id (backer $backer_id, project $projectId)");
					}				
				} else {
					//wrtlog("takePreApprovalFromBacker_notify at 261");
					$correlationId=$CorrelationID;
				}
				//$amount=$amount; // jwg ?? ['amount'] should be in the array and present here as $amount
				
				//$transactionId=$tracking_id; // jwg ... 
				if (!isset($transaction) || !is_array($transaction) || !isset($transaction[1])) {
					$transactionId = '--NO ID--';
					wrtlog("NO transactionId available for tracking id $tracking_id (backer $backer_id, project $projectId)");
					wrtlog("takePreApprovalFromBacker_notify called with: ".print_r($array,true));
				} else {
					$transactionId = $transaction[1];
					//wrtlog("SAVED transactionId: $transactionId"); // DEBUG
				}
				
				$userId	= $backer_id;
				$dateTime=time();
				$rewardId=$rewardId;
				$projectId=$projectId;
				$commision=$commision;
				
				
				$check_paykey=$this->con->recordselect("SELECT backingId FROM projectbacking WHERE preapproval_key='$pay_key' and userId='$userId' and projectId='$projectId' and tracking_id='$tracking_id'");
				if(mysql_num_rows($check_paykey)==0)
				{
					$final_arr=array();
					foreach($array as $K=>$P)
					{
						$final_arr[addslashes($K)]=addslashes((is_array($P)?json_encode($P):$P));
					}
					$final_arr['url']=get_url();;
					$this->con->insert("insert into preapproval_detail (detail) values ('".json_encode($final_arr)."')");
					$preapproval_detail_id=mysql_insert_id();
					
					
					$this->con->insert("INSERT INTO `paypaltransaction` (`correlationId`, `amount`, `transactionId`, `userId`, `dateTime`, `rewardId`, `projectId`,`status`,`commission`,`trackingId`) VALUES ( '".$correlationId."', '".$amount."', '".$transactionId."', '".$userId."', '".$dateTime."', '".$rewardId."', '".$projectId."','".$array['status']."','".$commision."','".$tracking_id."')");
					$paypal_id=mysql_insert_id();
					
					
					$projectBacking = $this->con->insert("INSERT INTO projectbacking (rewardId, projectId, userId, pledgeAmount, backingTime, paypalId,preapproval_detail_id,payment_status,preapproval_key,tracking_id,pledgeCommision) VALUES('".$rewardId."','".$projectId."', ".$backer_id.", '".$amount."', ".time().",'".$paypal_id."','".$preapproval_detail_id."','p','".$pay_key."','".$tracking_id."','".$commision."')");
					
					$sel_amount=mysql_fetch_assoc($this->con->recordselect("SELECT * FROM projectbasics WHERE projectId='$projectId'"));
					// increase the accumulation of backing-to-date
					$amount=$sel_amount['rewardedAmount'] + $amount;
					
					$this->con->update("UPDATE projectbasics SET rewardedAmount='".$amount."' WHERE 	projectId='$projectId'");

					//$updateProjectGoal = $this->con->update("UPDATE projectbasics set rewardedAmount = rewardedAmount +".$amount." where projectId =".$projectId. " LIMIT 1");
					$this->takePreApprovalFromBacker_sendCreatormail($array);
				}
			}	
	}

	function payRefund_Unsuccessful($array)
	{

		extract($array);

			$PayPal = new PayPal_Adaptive($this->PayPalConfig);
			$CurrencyCode='USD';
			$PayKey=$paykey;
			//$TransactionID='';						   //
			//$TrackingID='';							   //
			if (!isset($transactionId)) $transactionId=''; // jwg
			if (!isset($correlationId)) $correlationId=''; // jwg
			if (!isset($trackingId)) $trackingId=''; // jwg
	
			$Receivers = array();		
			// Prepare request arrays
			$RefundFields = array(
								  'CurrencyCode' => $CurrencyCode, 											// Required.  Must specify code used for original payment.  You do not need to specify if you use a payKey to refund a completed transaction.
								  'PayKey' => $PayKey,  													// Required.  The key used to create the payment that you want to refund.
								  'TransactionID' => $transactionId,								  // Required.  The PayPal transaction ID associated with the payment that you want to refund.
								  'CorrelationID' => $correlationId,
								  'TrackingID' => $trackingId												// Required.  The tracking ID associated with the payment that you want to refund.
								  );
	
	
	
			$PayPalRequestData = array(
						 'RefundFields' => $RefundFields, 
						 'Receivers' => $Receivers
						 );
	
	
			// Pass data into class for processing with PayPal and load the response array into $PayPalResult
			$PayPalResult = $PayPal->Refund($PayPalRequestData);
	
			// Write the contents of the response array to the screen for demo purposes.
			//	echo '<pre />';
			//print_r($PayPalResult);
			if(strtolower($PayPalResult['Ack'])=='success')
			{
				
				$this->payRefund_Unsuccessful_backer_dbupdate($array,$PayPalResult);
				$this->payRefund_Unsuccessful_backer_mail($array,$PayPalResult);
			}			
	}
	*/
	
	function takePreApprovalFromBacker_sendCreatormail($array)
	{
		extract($array);
		//$this->con->insert("insert into preapproval_detail (detail) values ('a')");
		if($backer_id!='')
		{
			$projectBacker = mysql_fetch_array($this->con->recordselect("SELECT name FROM users where userId='$backer_id' LIMIT 1"));
			$backer_name=$projectBacker['name'];
		}
		
			$projectCreater = mysql_fetch_array($this->con->recordselect("SELECT * FROM projects as pro, users as usr, projectbasics as pb where pro.projectId=".$projectId." and pro.userId=usr.userId AND pb.projectId =".$projectId));
			if($projectCreater['pledgeMail']==1)
			{
				$artical1="";
				$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
				$artical1.="<body><strong>Hello ".$projectCreater['name'].", </strong><br />";
				$artical1.="<br />";			
				$artical1.= $backer_name." has committed $amount to your project <b>".unsanitize_string(ucfirst($projectCreater['projectTitle']))."</b><br />";

				$artical1.= "You can visit your project page by clicking the following link.<br />
				<a href='".SITE_URL."browseproject/".$projectId."/".Slug($projectCreater['projectTitle']).'/'."' target='_blank'>Click Here</a><br />";
				$artical1.="<br /><br />Regards,<br />".DISPLAYSITENAME." Team</body></html>";
				$subject1="New backing for ".unsanitize_string(ucfirst($projectCreater['projectTitle']));
				$mailbody1=$artical1;
				$headers1 = "MIME-Version: 1.0\r\n";
				$headers1 .= "Content-type: text/html\r\n";
				$headers1 .= FROMEMAILADDRESS;

				@mail(base64_decode($projectCreater['emailAddress']), $subject1, $mailbody1, $headers1);
				@mail('admin@'.$_SERVER['SERVER_NAME'], 'cc: '.$subject1, $mailbody1, $headers1);
			}
	}
		
	
	function payRefund_Unsuccessful_backer_dbupdate($array,$PayPalResult)
	{
		/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_id,$amount,$commision,$rewardId,$backer_email*/
		extract($array);
		extract($PayPalResult);
		$final_arr=array();
		foreach($PayPalResult as $K=>$P)
		{
			$final_arr[addslashes($K)]=addslashes((is_array($P)?json_encode($P):$P));
		}
		$final_arr['url']=get_url();

			$paymentDetail=mysql_fetch_assoc($this->con->recordselect("select paypalId from projectbacking where projectId='".$projectId."' and backingId='".$back_id."'"));
			
			wrtlog("DEBUG payment.class.php at 456 in payRefund_Unsuccessful_backer_dbupdate: projectId=$projectId, backingId=$back_id ");
			wrtlog("... paymentDetail record from select: ".print_r($paymentDetail,true));
			
			//$this->con->update("update paypaltransaction set status='".$RefundStatus."' where paypalId='".$paymentDetail['paypalId']."'");
			$this->con->update("update paypaltransaction set status='REFUNDED' where paypalId='".$paymentDetail['paypalId']."'");			
			$this->con->insert("insert into preapproval_detail (detail) values ('".mysql_real_escape_string(json_encode($final_arr))."')");
			$preapproval_detail_id=mysql_insert_id();
			$this->con->update("update projectbacking set payment_status='r',refund_detail_id='".$preapproval_detail_id."' where backingId='".$back_id."'");
		
	}
	function payRefund_Unsuccessful_backer_mail($array,$PayPalResult)
	{
		/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_id,$amount,$commision,$rewardId,$backer_email*/
		extract($array);
		extract($PayPalResult);
		
		$message="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$message.="<body> Hello ".$backer_name ."<br><Br> Your project ".$project_name." you have pledged for is closed unsuccessfully.
	Money you have pledged for is refunded back into your Account.
	<br><br> Thank you for backing for the projects.<br><br>Thanks, <br><br>".DISPLAYSITENAME." Team";
		$subject1=$project_name.": Project you have pledged for is unsuccessfull.";
		$headers1 = "MIME-Version: 1.0\r\n";
		$headers1 .= "Content-type: text/html\r\n";
		//$headers1 .= "From: admin@fantasticfox.org";
		$headers1 .= FROMEMAILADDRESS;
		$toemail=$backer_email; 
	//	print $message;
		@mail(($toemail), $subject1, $message, $headers1);
		@mail('admin@'.$_SERVER['SERVER_NAME'], 'cc: '.$subject1, $message, $headers1);	
	}
	function payRefund_Unsuccessful_creator_mail($array)
	{
		
		extract($array);
		/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_id,$amount,$commision,$rewardId,$backer_email*/
		$message="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$message.="<body> Hello ".$creator_name ."<br><Br> Your project ".$project_name." is closed unsuccessfully due to less funds than goal. You can see the project in your account but there will no further editing or backing could be done in the same project.<br ><br>
		Thank you for putting projects. Please share more projects to get the better result. <Br><Br>Thanks, <br><br>".DISPLAYSITENAME." Team";
		$subject1=$project_name.": Project unsuccessfull.";
		$headers1 = "MIME-Version: 1.0\r\n";
		$headers1 .= "Content-type: text/html\r\n";
		$headers1 .= FROMEMAILADDRESS;
		$toemail=$creator_email; 
		@mail($toemail, $subject1, $message, $headers1);
		@mail('admin@'.$_SERVER['SERVER_NAME'], 'cc: '.$subject1, $message, $headers1);		
	}


	// called from functions/functions.php pay_to_creator_on_success($projectid)
	function payExecute_Successful($array)
	{
		/* 	amount, commision, paykey, rewardId, back_id, projectId, project_name,
			backer_id, backer_email, backer_name, creator_id, creator_name, creator_email,
			creator_paykey, creator_paypal */

		extract($array);

		wrtlog("In payment.class.php payExecute_Successful with array: ".print_r($array,true));
		
		$CurrencyCode='USD';
		$PayKey=$paykey;
		$FundingPlanID='';
			
			
		$PayPal = new PayPal_Adaptive($this->PayPalConfig);
			
		// Prepare request arrays
		$ExecutePaymentFields = array(
										'PayKey' => $PayKey, 	// The pay key that identifies the payment to be executed.  This is the key returned in the Preapproval response.
										'FundingPlanID' => '' 	// The ID of the funding plan from which to make this payment.
										);
										
		$PayPalRequestData = array('ExecutePaymentFields' => $ExecutePaymentFields);
			
		// Pass data into class for processing with PayPal and load the response array into $PayPalResult
		$PayPalResult = $PayPal->ExecutePayment($PayPalRequestData);
		wrtlog("PayPal->ExecutePayment PayPalResult: ".print_r($PayPalResult,true));
		
		/*	
	    [Errors] => Array
			(
			)
	
		[Ack] => Success
		[Build] => 7935900
		[CorrelationID] => 61cb624f0b5d4
		[Timestamp] => 2013-12-03T04:36:58.662-08:00
		[PaymentExecStatus] => COMPLETED
		[XMLRequest] => ReturnAllen_USAP-87H43938LL9590813
		[XMLResponse] => 2013-12-03T04:36:58.662-08:00Success61cb624f0b5d47935900COMPLETED*/
		
		if(strtolower($PayPalResult['Ack'])=='success')
		{
			$this->payExecute_Successful_backer_dbupdate($array,$PayPalResult);
			$this->payExecute_Successful_backer_mail($array,$PayPalResult);
		} else {
			$this->cancel_preapprovals_backer_dbupdate($array,$PayPalResult,true);
			$this->payExecute_Successful_failed_backer_mail($array,$PayPalResult);
		}
	}
	
	
	function payExecute_Successful_backer_dbupdate($array,$PayPalResult)
	{
		/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_id,$amount,$commision,$rewardId,$backer_email*/
		extract($array);
		extract($PayPalResult);
		$final_arr=array();
		foreach($PayPalResult as $K=>$P)
		{
			$final_arr[addslashes($K)]=addslashes($P);
		}
		$final_arr['url']=get_url();;

		$this->con->insert("insert into preapproval_detail (detail) values ('".mysql_real_escape_string(json_encode($final_arr))."')");
		$preapproval_detail_id=mysql_insert_id();
		$this->con->update("update projectbacking set payment_status='e',executed_detail_id='".$preapproval_detail_id."' where backingId='".$back_id."'");
			
		//$paymentDetail=mysql_fetch_assoc($this->con->recordselect("select paypalId from projectbacking where projectId='".$projectId."' and backingId='".$back_id."'"));
		$pb_r = $this->con->recordselect("select paypalId from projectbacking where projectId='".$projectId."' and backingId='".$back_id."'");
		if (mysql_num_rows($pb_r) > 0) {
			$pb = mysql_fetch_assoc($pb_r);
			if (isset($pb['paypalId']) && !empty($pb['paypalId']) && ($pb['paypalid'] != 0)) {
				$this->con->update("update paypaltransaction set status='".$PaymentExecStatus."' where paypalId='".$pb['paypalId']."'");
			}
		}
	}
	
	function payExecute_Successful_backer_mail($array,$PayPalResult)
	{
		/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_id,$amount,$commision,$rewardId,$backer_email*/
		extract($array);
		extract($PayPalResult);
		
		$message="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$message.="<body> Hello ".$backer_name ."<br><Br> The ".$project_name." project has been successfully funded. Money that you pledged has been conveyed to the project owner. Feel free to contact the project owner by email if you have any questions.
	<br><br>".DISPLAYSITENAME." Team";
		$subject1=$project_name.": project has been successfully funded!";
		$headers1 = "MIME-Version: 1.0\r\n";
		$headers1 .= "Content-type: text/html\r\n";
		$headers1 .= FROMEMAILADDRESS;
		$toemail = $backer_email; 
		@mail($toemail, $subject1, $message, $headers1);
		@mail('admin@'.$_SERVER['SERVER_NAME'], 'cc: '.$subject1, $message, $headers1);				
	}
	
	function payExecute_Successful_failed_backer_mail($array,$PayPalResult)
	{
		// the project was successful, but this backing pledge failed to execute
		
		/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_id,$amount,$commision,$rewardId,$backer_email*/
		extract($array);
		extract($PayPalResult);
		
		$message="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$message.="<body> Hello ".$backer_name ."<br/><br/>
		The ".$project_name." project has been successfully funded.<br/>
		However, money you pledged could not be conveyed to the project owner.<br/><br/>
		Feel free to contact the project owner by email if you have any questions.
		<br><br>".DISPLAYSITENAME." Team";
		$subject1=$project_name.": project backing pledge failed";
		$headers1 = "MIME-Version: 1.0\r\n";
		$headers1 .= "Content-type: text/html\r\n";
		$headers1 .= FROMEMAILADDRESS;
		$toemail = $backer_email; 
		@mail($toemail, $subject1, $message, $headers1);
		@mail('admin@'.$_SERVER['SERVER_NAME'], 'cc: '.$subject1, $message, $headers1);				
	}	
	
	function pay_Execute_Successful_creator_mail($array)
	{	
	/*echo 'aaa';	
	echo '<pre>';print_r($array);echo '</pre>';exit;*/
		extract($array);
		
		/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_id,$amount,$commision,$rewardId,$backer_email*/
			
		$message="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$message.="<body> Hello ".$creator_name ."<br><Br> Your project ".$project_name." has been successfully funded! PayPal has been instructed to transfer funds to your account.<br/><br/>
		You can view your project in your account, but there can be no further editing or backing of that project.<br ><br>
		<br/><br/>Regards, <br><br>".DISPLAYSITENAME." Team";
		$subject1=$project_name.": project successfully funded!";
		$headers1 = "MIME-Version: 1.0\r\n";
		$headers1 .= "Content-type: text/html\r\n";
		$headers1 .= FROMEMAILADDRESS;
		$toemail = $creator_email; 
		@mail($toemail, $subject1, $message, $headers1);	
		@mail('admin@'.$_SERVER['SERVER_NAME'], 'cc: '.$subject1, $message, $headers1);		
	}
	
	function pay_Execute_Successful_secondaryUser_mail($array)
	{		
		extract($array);
		
		/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_id,$amount,$commision,$rewardId,$backer_email*/
	
		$message="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$message.="<body> The project ".$project_name." was successfully funded.";
		$subject1=$project_name.": Project commission added successfully.";
		$headers1 = "MIME-Version: 1.0\r\n";
		$headers1 .= "Content-type: text/html\r\n";
		$headers1 .= FROMEMAILADDRESS;
		$toemail=$creator_email; 
		@mail($toemail, $subject1, $message, $headers1);	
		@mail('admin@crowdedrocket.com', 'cc: '.$subject1, $message, $headers1);		
	}
	
	function cancel_preapprovals($sel_backing)
	{
		// $sel_backing is preapproved backing record to be cancelled
		$DataArray = array();
		$CancelPreapprovalFields = array('PreapprovalKey' => $sel_backing['preapproval_key']);
		$DataArray['CancelPreapprovalFields'] = $CancelPreapprovalFields;
		$PayPal = new PayPal_Adaptive($this->PayPalConfig);
		$PayPalResult = $PayPal->CancelPreapproval($DataArray);
		// $PayPalResult array(
		//	'Errors' => $Errors, 
		//	'Ack' => $Ack, 
		//	'Build' => $Build, 
		//	'CorrelationID' => $CorrelationID, 
		//	'Timestamp' => $Timestamp, 
		//	'XMLRequest' => $XMLRequest, 
		//	'XMLResponse' => $XMLResponse
		// }
		if(strtolower($PayPalResult['Ack'])=='success')
		{
			$this->cancel_preapprovals_backer_dbupdate($array,$PayPalResult);
			$this->cancel_preapprovals_backer_mail($array,$PayPalResult);
		} else {
			wrtlog("WARNING: project #{$sel_backing['projectId']} backing #{$sel_backing['backingId']} could not be cancelled: ".print_r($PayPalResult,true)); 
			$this->cancel_preapprovals_backer_dbupdate($array,$PayPalResult); // still mark it cancelled
			// at this point - we are silent on outcome to the backer... tbd
		}
	}
	
	function cancel_preapprovals_backer_dbupdate($array,$PayPalResult,$wasFunded=false)
	{
		// jwg - note: if $wasFunded=true it means that we tried to execute payment
		//       for a backing pledge, but the execute failed, so we are marking that pledge 
		//       as cancelled.
	
		/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_id,$amount,$commision,$rewardId,$backer_email*/
		extract($array);
		extract($PayPalResult);
		$final_arr=array();
		foreach($PayPalResult as $K=>$P)
		{
			$final_arr[addslashes($K)]=addslashes((is_array($P)?json_encode($P):$P));
		}
		$final_arr['url']=get_url();
		$this->con->insert("insert into preapproval_detail (detail) values ('".mysql_real_escape_string(json_encode($final_arr))."')");
		$preapproval_detail_id=mysql_insert_id();
		$this->con->update("update projectbacking set payment_status='c',refund_detail_id='".$preapproval_detail_id."' where backingId='".$back_id."'");
				
		$pb_r = $this->con->recordselect("select paypalId from projectbacking where projectId='".$projectId."' and backingId='".$back_id."'");
		if (mysql_num_rows($pb_r) > 0) {
			$pb = mysql_fetch_assoc($pb_r);
			if (isset($pb['paypalId']) && !empty($pb['paypalId']) && ($pb['paypalid'] != 0)) {
				$this->con->update("update paypaltransaction set status='CANCELLED' where paypalId='".$pb['paypalId']."'");
			}
		}
	}
	function cancel_preapprovals_backer_mail($array,$PayPalResult)
	{
		// jwg - note: if $wasFunded=true it means that we tried to execute payment
		//       for a backing pledge, but the execute failed, so we are marking that pledge 
		//       as cancelled.
		
		/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_id,$amount,$commision,$rewardId,$backer_email*/
		extract($array);
		extract($PayPalResult);
		
		$message="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$message.="<body> Hello ".$backer_name ."<br><Br> Project ".$project_name." to which you pledged support failed to reach its goal.
	Your pledge has been cancelled. No funds will be taken from your account.
	<br><br> On behalf of the project owner thank you for your support.<br><br>".DISPLAYSITENAME." Team";
		$subject1=$project_name.": project was unsuccessful in reaching its goal.";
		$headers1 = "MIME-Version: 1.0\r\n";
		$headers1 .= "Content-type: text/html\r\n";
		$headers1 .= FROMEMAILADDRESS;
		$toemail=$backer_email; 

		@mail(($toemail), $subject1, $message, $headers1);
		@mail('admin@'.$_SERVER['SERVER_NAME'], 'cc: '.$subject1, $message, $headers1);	
	}
	
	function cancel_preapprovals_creator_mail($projectId)
	{
		$message="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$message.="<body> Hello ".$creator_name ."<br><Br> Your project ".$project_name." failed to reach its funding goal by the end date. <br/><br/>
		You can view your project in your account but there can be no further editing or backing of that project.<br ><br>
		<br><br>".DISPLAYSITENAME." Team";
		$subject1=$project_name.": project unsuccessful";
		$headers1 = "MIME-Version: 1.0\r\n";
		
		$headers1 .= "Content-type: text/html\r\n";
		$headers1 .= FROMEMAILADDRESS;
		$toemail=$creator_email; 
		@mail($toemail, $subject1, $message, $headers1);
		@mail('admin@'.$_SERVER['SERVER_NAME'], 'cc: '.$subject1, $message, $headers1);		
	}

}
