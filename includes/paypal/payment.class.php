<?php

// Sets config file path(if config file is used) and registers the classloader
require_once("PPBootStrap.php");

class Payment
{
	var $config;
	var $con;
	function __construct($Config=null)
	{
		global $con;
		$this->con=$con;
		$configuration = new Configuration();
		$this->config = $configuration->getAcctAndConfig();
	}

	function doPreapproval($array) 
	{
		// $array is $_POST from paypalInfo.tpl.php form submission
		// extract yields: $amount, $rewardId, $projectId, $backerId
		// $backerId has been verified == $_SESSION['userId'] by our caller
		extract($array); 

		$TrackingID=generate_password(5);
		$user = mysql_fetch_array($this->con->recordselect("SELECT * from `users` where `userId` = $backerId "));			
		$senderEmail = base64_decode($user['paypalUserAccount']);	
		if (empty($senderEmail)) {
			$senderEmail = base64_decode($user['emailAddress']);	
		}
		$project_rcd = mysql_fetch_array($this->con->recordselect("SELECT * from `projects` where `projectId` = $projectId "));		
		$project = mysql_fetch_array($this->con->recordselect("SELECT * from `projectbasics` where `projectId` = $projectId "));		
		$memo = "Support CrowdedRocket project: ".$project['projectTitle'];
		$returnUrl=SITE_URL.'modules/projectBacker/thankyou.php?projectId='.$projectId.'&trackingId='.$TrackingID;
		$cancelUrl=SITE_URL.'modules/projectBacker/precancel.php?projectId='.$projectId.'&trackingId='.$TrackingID;
		$currencyCode = 'USD';
		$startingDate=date('Y-m-d',strtotime("+10 minutes",$project['projectEnd']));
		$endingDate=date('Y-m-d',strtotime("+5 days",$project['projectEnd']));
		
		// copied from samples PreapprovalReceipt.php
		$requestEnvelope = new RequestEnvelope("en_US");
		$preapprovalRequest = new PreapprovalRequest($requestEnvelope, $cancelUrl, 
													 $currencyCode, $returnUrl, $startingDate);
		$preapprovalRequest->endingDate = $endingDate;
		$preapprovalRequest->maxAmountPerPayment = $amount;
		$preapprovalRequest->maxNumberOfPayments = 1;
		$preapprovalRequest->maxNumberOfPaymentsPerPeriod = 1;
		$preapprovalRequest->maxTotalAmountOfAllPayments = $amount;
		$preapprovalRequest->memo = $memo;
		$preapprovalRequest->senderEmail = $senderEmail;
		$preapprovalRequest->feesPayer = 'PRIMARYRECEIVER';
		$preapprovalRequest->displayMaxTotalAmount = 'TRUE';

		$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
		try {
			$response = $service->Preapproval($preapprovalRequest);
			//wrtlog("DEBUG payment.class.php service Preapproval response: ".print_r($response,true));

			$ack = strtoupper($response->responseEnvelope->ack);
			if($ack != "SUCCESS"){
				wrtlog("WARNING payment.class.php Preapproval failed. response=".print_r($resonse,true));
				$redirectUrl = (isset($response->redirectUrl)) ? $response->redirectUrl : $cancelUrl; 
			
			} else {

				$token = $response->preapprovalKey;
				$redirectUrl = (isset($response->redirectUrl)) ? $response->redirectUrl : $returnUrl;

				// Create a pre-approved projectbacking record including the preapproval key
				$final_arr=array();
				foreach($preapprovalRequest as $K=>$P)
				{
					$final_arr['request.'.addslashes($K)]=addslashes((is_array($P)?json_encode($P):$P));
				}
				$response_array = dismount($response);
				foreach($response_array as $K=>$P)
				{
					$final_arr[addslashes($K)]=addslashes((is_array($P)?json_encode($P):$P));
				}
				$this->con->insert("insert into preapproval_detail (detail) values ('".json_encode($final_arr)."')");
				$preapproval_detail_id=mysql_insert_id();					
					
				// create initial backing record with payment_status='?'
				
				$commission = get_commission($projectId,$amount);
				$this->con->insert("INSERT INTO `projectbacking` ".
						"(rewardId, projectId, userId, pledgeAmount, backingTime, paypalId,preapproval_detail_id,payment_status,preapproval_key,tracking_id,pledgeCommision) ".
						"VALUES('".$rewardId."','".$projectId."', ".$backerId.", '".$amount."', ".time().",NULL,'".$preapproval_detail_id."','?','".$token."','".$TrackingID."','".$commission."')");

				redirect($redirectUrl); 
				// control returns to either returnUrl (thankyou.php) or cancelUrl (precancel.php)

			}		
			
		} catch(Exception $ex) {
			return $ex; // return error to caller
		}		
	}
	
	
	function doCancelPreapproval($backing) 
	{
		// $backing is projectbacking record
		extract($backing); 
	
		$this->con->update("update projectbacking set payment_status='c' where backingId='".$backingId."'");

		if (isset($paypalId) && !empty($paypalId) && ($paypalid != 0)) {
			$this->con->update("update paypaltransaction set status='CANCELLED' where paypalId='".$paypalId."'");
		}
		
		$requestEnvelope = new RequestEnvelope("en_US");
		$cancelPreapprovalReq = new CancelPreapprovalRequest($requestEnvelope, $preapproval_key);
		wrtlog("DEBUG cancelPreapprovalReq=".print_r($cancelPreapprovalReq,true));
		
		$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
		try {
			$response = $service->CancelPreapproval($cancelPreapprovalReq);
			
			$final_arr=array();			
			$preq = dismount($cancelPreapprovalReq);
			foreach($preq as $K=>$P)
			{
				$final_arr[addslashes($K)]=addslashes((is_array($P)?json_encode($P):$P));
			}
			if (is_object($response)) {
				$newarray = dismount($response);
				$response = $newarray;
			}
			foreach($response as $K=>$P)
			{
				$final_arr[addslashes($K)]=addslashes((is_array($P)?json_encode($P):$P));
			}
			$final_arr['url']=get_url();
			$this->con->insert("insert into preapproval_detail (detail) values ('".mysql_real_escape_string(json_encode($final_arr))."')");
			$cancel_detail_id=mysql_insert_id();
			$this->con->update("update projectbacking set cancel_detail_id='".$cancel_detail_id."' where backingId='".$backingId."'");
							
			wrtlog("DEBUG doCancelPreapproval response for project $projectId : ".print_r($response,true));
		} catch(Exception $ex) {
			wrtlog("DEBUG doCancelPreapproval error: ".$ex->getMessage());
			wrtlog("DEBUG doCancelPreapproval request: ".print_r($cancelPreapprovalReq,true));
			require_once 'Common/Error.php'; /// THIS IS CALLED BY automatic_cron.php ////
											 /// SO TBD IF WE SHOULD STOP IT          ////
			exit;
		}
	
	}
	
	/* from old payment.class.php */
	
	function cancel_preapprovals($sel_backing)
	{
		// $sel_backing is preapproved backing record to be cancelled
		
		// use old sdk
		global $PayPalConfig;
		$PayPal = new PayPal_Adaptive($PayPalConfig);
		
		$DataArray = array();
		$CancelPreapprovalFields = array('PreapprovalKey' => $sel_backing['preapproval_key']);
		$DataArray['CancelPreapprovalFields'] = $CancelPreapprovalFields;
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
		wrtlog("DEBUG in cancel_preapprovals PayPalResult: ".print_r($PayPalResult,true));
		
		if(strtolower($PayPalResult['Ack'])=='success')
		{
			$this->cancel_preapprovals_backer_dbupdate($sel_backing,$PayPalResult);
			$this->cancel_preapprovals_backer_mail($sel_backing,$PayPalResult);
		} else {
			wrtlog("WARNING: project #{$sel_backing['projectId']} backing #{$sel_backing['backingId']} could not be cancelled: ".print_r($PayPalResult,true)); 
			$this->cancel_preapprovals_backer_dbupdate($sel_backing,$PayPalResult); // still mark it cancelled
			// at this point - we are silent on outcome to the backer... tbd
		}
	}
	
	function cancel_preapprovals_backer_dbupdate($array,$PayPalResult,$wasFunded=false)
	{
		// jwg - note: if $wasFunded=true it means that we tried to execute payment
		//       for a backing pledge, but the execute failed, so we are marking that pledge 
		//       as cancelled.
		wrtlog("DEBUG in cancel_preapprovals_backer_dbupdate");
		
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

	
	
	
	
	
	
	
	
	/* example of use
	function doPayRequest($params) {
		... create required call stuff ...
		.
		.
		$payRequest = new PayRequest($requestEnvelope, $actionType, $cancelUrl, 
									  $currencyCode, $receiverList, $returnUrl);
		// Add optional params
		if($_POST["feesPayer"] != "") {
		   $payRequest->feesPayer = $_POST["feesPayer"];
		}
		......

		$service = new AdaptivePaymentsService($config);
		$response = $service->Pay($payRequest);	
		if(strtoupper($response->responseEnvelope->ack == 'SUCCESS') {
			// Success
		}
	}
	*/
}
	