<?php require "../config.php";

	wrtlog("NOTIFY.PHP CALLED");
	fct_show_trace(debug_backtrace(),"backtrace");
	// THIS IS NO LONGER USED... TBD ...
	
	// This is called by PayPal as a POST request at completion of a payment request.
	// The actual url used by PayPal is specified by us in takePreApprovalFromBacker and contains a query string
	// with relevant tracking information.
	// Combine the two pieces of information (from query string and post variables) log in preapproval_detail and pass to _notify 
	$get_arry=array();
	$post_arry=$_POST;
	parse_str($_GET['q'],$get_arry);
	//print_r($get_arry);
	$PayPalConfig = array(
						  'Sandbox' => $sandbox,
						  'DeveloperAccountEmail' => $developer_account_email,
						  'ApplicationID' => $application_id,
						  'DeviceID' => $device_id,
						  'IPAddress' => $_SERVER['REMOTE_ADDR'],
						  'APIUsername' => $api_username,
						  'APIPassword' => $api_password,
						  'APISignature' => $api_signature,
						  'APISubject' => $api_subject
						);
	$Pay=new Payment($PayPalConfig);
	$result = array_merge($post_arry,$get_arry);
	$final_arr=array();
	foreach($result as $K=>$P)
	{
		$final_arr[addslashes($K)]=addslashes((is_array($P)?json_encode($P):$P));
	}
	$final_arr['url']=get_url();;
	$con->insert("insert into preapproval_detail (detail) values ('".json_encode($final_arr)."')");
	if(strtolower($_POST['status'])!='error')
	{
		$Pay->takePreApprovalFromBacker_notify($result);
	}
?>