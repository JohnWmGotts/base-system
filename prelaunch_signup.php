<?php
									/* prelaunch signup */
require_once("includes/config.php");
	// config starts session and connects to database
	// defines several global constants (e.g. SITE_URL) and vars (e.g. $con == db connection obj)
	// also requires once the validation class
	
class crPLS {

	function processRequest() {
		// we can directly reference $_SESSION, $_REQUEST and defined vars set by config;
		global $con; // give access to open db connection object
		$this->sesstoken = fct_session_token(); // from $_SESSION['token'] (may be gen'd new just now)
		$email = (isset($_POST) && isset($_POST['email'])) ? $_POST['email'] : '';
		$email = strtolower(urldecode($email));
		$existing_user = $con->recordselect("SELECT * FROM `prelaunch_signup` WHERE emailAddress='".$email."'");
		if(mysql_num_rows($existing_user)>0) {
			return "That email address is already signed up.";
		} else {
			// new pre-launch signup
			$accessIp=get_ip_address1();
			if (isset($_SESSION['plc'])) {
				// new user has arrived on a referral link containing prelaunch_user created timestamp
				$con->insert("INSERT INTO `prelaunch_signup` 
							(`emailAddress`, `created`, `ipaddress`, `referrerCreated`) 
							VALUES ('$email', ".time().", '".$accessIp."', '".$_SESSION['plc']."') ");	
			} else if (isset($_SESSION['ruid'])) {
				// new user has arrived on a referral link containing a registered user's id
				$referrer = $con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$_SESSION['ruid']."' ");
				if (mysql_num_rows($referrer) >= 1) {
					// Use registered user's "created" timestamp as referrerCreated
					// ... to add a little confusion to understand which "create" we are talking about
					$con->insert("INSERT INTO `prelaunch_signup` 
							(`emailAddress`, `created`, `ipaddress`, `referrerCreated`) 
							VALUES ('$email', ".time().", '".$accessIp."', '".$referrer['created']."') ");	
				} else {
					// strange ... cannot located registered user by id
					wrtlog("DEBUG: could not locate registered user by userId=".$_SESSION['ruid']." from session['ruid'] ");
				}
			} else {		
				$con->insert("INSERT INTO `prelaunch_signup` (`emailAddress`, `created`, `ipaddress`) 
							VALUES ('$email', ".time().", '".$accessIp."') ");
			}
			return "Thank you! We will notify you as soon as we open for business.";
		}
	}
}  
	
$pls = new crPLS();
echo $pls->processRequest();	
		
?>