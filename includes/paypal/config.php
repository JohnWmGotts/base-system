<?php
/**
 * Timezone Setting
 */
date_default_timezone_set('America/Chicago');

/**
  * Enable Sessions
  */
//if(!session_id()) session_start();
	// jwg
	if (version_compare(phpversion(), '5.4.0', '<')) { if(session_id() == '') session_start(); } 
	else { if (session_status() == PHP_SESSION_NONE) session_start(); }

// setup global vars that might still be used by old paypal api
require_once('Configuration.php'); // obtain from new api config
$ppconfig = new Configuration();
$theconfig = $ppconfig->getAcctAndConfig();
$application_id = $theconfig['acct1.AppId'];	
$api_username = $theconfig['acct1.UserName'];	  
$api_password = $theconfig['acct1.Password'];	  
$api_signature =  $theconfig['acct1.Signature'];	

$developer_account_email = 'admin@'.$_SERVER['SERVER_NAME'];	
$sandbox = $theconfig['mode'];
/** 
 * Sandbox Mode - TRUE/FALSE
 */
//$sandbox = TRUE;
// jwg - noopd next
//$domain = $sandbox ? 'http://www.sandbox.paypal.com/' : 'http://www.paypal.com/';

/**
 * Enable error reporting if running in sandbox mode.
 */
if($sandbox)
{
	///error_reporting(0);
	//ini_set('display_errors', '0');	
}

/**
 * API Credentials
 */ 
$api_version = '85.0';
/*
$application_id = $sandbox ? 'APP-80W284485P519543T' : '';	// Only required for Adaptive Payments.  You get your Live ID when your application is approved by PayPal.
$developer_account_email = 'admin@crowdedrocket.com';		// This is what you use to sign in to http://developer.paypal.com.  Only required for Adaptive Payments.
$api_username = $sandbox ? 'developer_api1.crowdedrocket.com' : 'LIVE_API_USERNAME';
$api_password = $sandbox ? 'NCXWTU5VWA2GTB3U' : 'LIVE_API_PASSWORD';
$api_signature = $sandbox ? 'AkUBj7fCpYI6FdSHQSlytehd.GM-AODzrJy1jp1mamZoM0TTAOm2ik.4' : 'LIVE_API_SIGNATURE';
*/

/**
 * Third Party User Values
 * These can be setup here or within each caller directly when setting up the PayPal object.
 */
$api_subject = '';	// If making calls on behalf a third party, their PayPal email address or account ID goes here.
$device_id = '';
//$device_ip_address = $_SERVER['REMOTE_ADDR'];
$device_ip_address = get_ip_address1(); // jwg - although it appears this is not userd anywhere...

?>