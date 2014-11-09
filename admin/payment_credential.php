<?php
	require_once("../includes/config.php");
	$pagetitle="Payment Credentials";
	if($_SESSION["admin_user"]=="")
	{
		header('location: login.php');
	}
	/*if($_SESSION["admin_role"] != 0)
	{
		header('location: home.php');
	}*/
	if(isset($_POST["lappid"]) OR isset($_POST["sappid"])) {
		extract($_POST);
		
		$obj = new validation();
		
		if($env_radio == 'sandbox'){
			$obj->add_fields($semail, 'req', 'SandBox Developer Email is Require.');
			$obj->add_fields($semail, 'email', 'Enter valid Email Address');
			$obj->add_fields($sappid, 'req', 'Sandbox Application ID is Require.');
			$obj->add_fields($sapiusernm, 'req', 'Sandbox API Username is Require.');
			$obj->add_fields($sapipsw, 'req', 'Sandbox API Password is Require.');
			$obj->add_fields($sapisgn, 'req', 'Sandbox API Signature is Require.');
		}else{
			$obj->add_fields($lappid, 'req', 'Live Application ID is Require.');
			$obj->add_fields($lemail, 'req', 'Live Admin Email is Require.');
			$obj->add_fields($lemail, 'email', 'Enter valid Email Address');
			$obj->add_fields($lapiusernm, 'req', 'Live API Username is Require.');
			$obj->add_fields($lapipsw, 'req', 'Live API Password is Require.');
			$obj->add_fields($lapisgn, 'req', 'Live API Signature is Require.');
		}		
		$error = $obj->validate();
		
		if($env_radio == 'sandbox'){
			$sandboxEnv = 'y';
			$liveEnv = 'n';
		}else{
			$sandboxEnv = 'n';
			$liveEnv = 'y';
		}
		
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		
		if($error=='') {
			if($env_radio == 'sandbox'){
				$update_qy = "UPDATE site_credential SET sandbox ='".$sandboxEnv."' , live='".$liveEnv."' ,
				sandbox_application_id='".$sappid."' ,
				sandbox_api_username='".base64_encode($sapiusernm)."' , 
				sandbox_api_password='".$sapipsw."' , sandbox_api_signature='".$sapisgn."' , 
				sandbox_developer_account_email='".base64_encode($semail)."'";
				$con->update($update_qy);
				header('location: payment_credential.php?msg=CHNGPC');
			}
			if($env_radio == 'live'){
				$update_qy = "UPDATE site_credential SET sandbox ='".$sandboxEnv."' , live='".$liveEnv."' ,
				live_application_id='".$lappid."' , 
				live_api_username='".base64_encode($lapiusernm)."' , 
				live_api_password='".$lapipsw."' , 
				live_api_signature='".$lapisgn."' , live_admin_account_email='".base64_encode($lemail)."'";
				$con->update($update_qy);
				header('location: payment_credential.php?msg=CHNGPC');
			}
		}
	}	
	
	$qy = "SELECT * FROM site_credential ORDER BY id DESC";
	$rs=$con->recordselect($qy);
	$rsw=mysql_fetch_array($rs);			
	$content="payment_credential";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>