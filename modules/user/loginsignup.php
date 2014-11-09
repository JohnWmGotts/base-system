<?php
	//require_once("../../includes/config.php");
$curdir = __FILE__;
$x = stripos($curdir,'/modules/');
$basedir = substr($curdir,0,$x);
require_once($basedir.'/includes/config.php');



define('FACEBOOK_SDK_V4_SRC_DIR', "$basedir/includes/Facebook/");
require_once $basedir.'/includes/autoload.php';	

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;

//Facebook App Id and Secret
if ($_SERVER['SERVER_NAME'] == 'emptyrocket.com') {
	$fbappid = '329614567212154';						// emptyrocket test - put these in config
	$fbsecret = 'e86b3b2055f2dd105343ea277c82913c';		//
} else {
	$fbappid = '836466059717946';						// crowdedrocket - put these in config
	$fbsecret = '6b9a7a48b3709b002be3686c5b809ebc';		//
}

FacebookSession::setDefaultApplication($fbappid,$fbsecret);
	
	//$left_panel = false;
	//$cont_mid_cl='-75';
	//print_r($_SESSION);
	/*if(isset($_SESSION["autosessmsg"]) && $_SESSION["autosessmsg"]=="yes" && !isset($_POST["submitLogin"])){
		//echo 'aa';exit;
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Please login to access this page.');
		$_SESSION["autosessmsg"]="";
		//setcookie("messagetype","",time()+3600);
		//print_r($_COOKIE);
		//exit;
		}*/
	$isFacebookSignup = false;
	///// NOTE -- The following title, description and meta are IMPORTANT
	/////         because they appear to the user in fb share as part of their share.
	if(isset($_REQUEST['signup']))
	{
		$title = "Launching great companies";
	} else if (isset($_REQUEST['token'])) {
		$title = "Launching great companies";
		$isFacebookSignup = true;
	} else {
		$title = "Launching great companies";
	}
	$meta = array("description"=>"A new approach to crowd funding!","keywords"=>"crowdfunding crowd funding startups investment rewards ownership");
	

//wrtlog("loginsignup 54"); // DEBUG
	
	
	// jwg
	if (isset($_REQUEST['refid']) && isset($_REQUEST['projid']) && is_numeric($_REQUEST['refid']) && is_numeric($_REQUEST['projid'])) {
		$_SESSION['refid'] = $_REQUEST['refid'];
		$_SESSION['projid'] = $_REQUEST['projid'];
		//wrtlog("Set SESSION refid=".$_SESSION['refid']." and projid=".$_SESSION['projid']);
	}
	$cur_time=time();

    if(isset($_SESSION["userId"]) && ($_SESSION["userId"]!="") && isset($_SESSION["name"]) && ($_SESSION["name"]!=""))
	{
		if ($prelaunch) {
			$qry1=$con->recordselect("SELECT * FROM users WHERE `userId` = ".$_SESSION['userId']." ");
            $valid_user=mysql_fetch_array($qry1);
			if ($valid_user['siteAccess'] != 1) redirect(SITE_URL); 
        }
	

//wrtlog("loginsignup 74"); // DEBUG

		redirect(SITE_URL."index.php");
  	}
	
	
	//$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Please login to access this page.');
		
	// Login Code Start
	$doingLogin = false;
	
	if ($isFacebookSignup) {
		$session = new FacebookSession($_REQUEST['token']);
		$request = new FacebookRequest($session, 'GET', '/me');
		$response = $request->execute();
		$user_profile = $response->getGraphObject()->asArray();	
		//wrtlog("loginsignup.php user_profile=".print_r($user_profile,true)); // DEBUG
		$email = (isset($user_profile['email'])) ? $user_profile['email'] : '';
		if (!empty($email)) {
			$emailid = base64_encode($email);	
			$email_valid=$con->recordselect("SELECT * FROM `users` WHERE `emailAddress` = '".$emailid."'");
			$email_valid1=mysql_num_rows($email_valid);
			if($email_valid1<=0) {
				// new user -- need signup
				$_SESSION["fbuser"] = $user_profile;
			} else {
				// existing user -- need login
				$valid_user=mysql_fetch_array($email_valid);
				$_SESSION["userId"]=$valid_user['userId'];
				$_SESSION["name"]=$valid_user['name']; 
				$_REQUEST["submitLogin"] = 1;
				$_REQUEST["emailid"] = base64_decode($valid_user["emailAddress"]);
				$_REQUEST["passwd"] = base64_decode($valid_user["password"]);
			}
		}
	}


//wrtlog("loginsignup 112"); // DEBUG

	
	if(isset($_REQUEST["submitLogin"]))
    {
	

//wrtlog("loginsignup 119"); // DEBUG

		$doingLogin = true; // to avoid running through signup code
		extract($_REQUEST);

		$obj = new validation();

		$obj->add_fields($emailid, 'req', 'Enter Email Address');
		$obj->add_fields($emailid, 'email', 'Enter valid Email Address');
		$obj->add_fields($passwd, 'req', ER_PSW);
		$error1 = $obj->validate();
		
		if($error1=='')
        {
             $password=base64_encode($passwd);
             $qry1=$con->recordselect("SELECT * FROM users WHERE emailAddress='".base64_encode($emailid)."' and password='".$password."'");
             $tot_rec=mysql_num_rows($qry1);
             $valid_user=mysql_fetch_array($qry1);

			 //wrtlog("loginsignup at 121");
             if($tot_rec>0)
		     {
				//wrtlog("loginsignup at 124");
				//update status
			  	if($valid_user['activated']==1)
	            {
					if (isset($_POST['rememberme'])) {
						/* Set cookie to last 1 year */
						setcookie('emailid',$_POST['emailid']);
						setcookie('passwd',base64_encode($_POST['passwd']));
						setcookie('rememberme',1);
					}				
				
					$accessIp=get_ip_address1();
					  
					//$cur_time=time(); // do above so more widely available in code
					if (empty($valid_user['signupIp'])) { // little fixup for early pre-launch users 
						$con->update("UPDATE users SET status=1, accessIp='$accessIp', signupIp='$accessIp', access='$cur_time' WHERE emailAddress='".base64_encode($emailid)."' and password='$password'");	
					} else {
						$con->update("UPDATE users SET status=1, accessIp='$accessIp', access='$cur_time' WHERE emailAddress='".base64_encode($emailid)."' and password='$password'");
					}
					$_SESSION["userId"]=$valid_user['userId'];
					$_SESSION["name"]=$valid_user['name'];
					if(isset($_REQUEST['parentUrl']) && $_REQUEST["parentUrl"]!='')
					{ // parent url or presence of project id implies the user has already been in the back pages
					  // so presumably we don't need to check prelaunch and siteAccess...
					  
						//wrtlog("loginsignup at 84. parentUrl=$parentUrl");
						$url = $_REQUEST['parentUrl'];
						$arrUrl = (parse_url($url));
 						
						if(strstr($_POST['parentUrl'],"modules/createProject/index.php") == "modules/createProject/index.php"){
							redirect(SITE_URL."createproject");
							exit;
						}
						/*if(strstr($_POST['parentUrl'], SITE_URL."modules/projectBacker/index.php") == SITE_URL."modules/projectBacker/index.php"){
							redirect(SITE_URL."projectBacker".$arrUrl['query']);
							exit;
						}*/
						//wrtlog("loginsignup redirecting to ".$_REQUEST["parentUrl"]." based on parentUrl.");		
						redirect($_REQUEST["parentUrl"]);
						exit; 
						
					} else if (isset($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'],'redirUrl=') !== false)) {
						// in posted good login after signup and redirecting to referred project
						$x = strpos($_SERVER['HTTP_REFERER'],'redirUrl=');
						$c_url = urldecode(substr($_SERVER['HTTP_REFERER'],$x+9));
						while (substr($c_url,0,5) == 'http%') {
							$c_url = urldecode($c_url);
						}
						//wrtlog("loginsignup redirecting to $c_url based on referrer.");		
						redirect($c_url);
						exit;
						
					} else if (isset($_SESSION['refid']) && isset($_SESSION['projid']) && ($_SESSION['projid'] !== 0)) {
						// in posted good login after signup and redirecting to referred project
						$c_url = SITE_URL.'browseproject/'.$_SESSION['projid'];
						//wrtlog("loginsignup redirecting to $c_url based on Session vars.");						
						redirect($c_url);
						exit;
						
					} else {
							if ($prelaunch) { // jwg
								if ($valid_user['siteAccess'] != 1) redirect(SITE_URL); 
							}						  
							redirect(SITE_URL."profile");
					}
				} else {
					if($valid_user['activated']==0)
					{
			   			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Please check your email and activate your '.DISPLAYSITENAME.' account');
					}
					else if($valid_user['activated']==2)
					{
			   			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Your '.DISPLAYSITENAME.' account is Blocked');
					}
				}
			}
		    else
		    {
				$qry1=$con->recordselect("SELECT * FROM users WHERE emailAddress='".base64_encode($emailid)."' ");
				$tot_rec=mysql_num_rows($qry1);
				if ($tot_rec >= 0) {
					$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>ER_INVUP);
				} else {
					$qry2=$con->recordselect("SELECT * FROM prelaunch_signup WHERE emailAddress='$emailid' ");
					$tot_rec=mysql_num_rows($qry2);
					if ($tot_rec <= 0) {
						$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Unknown email address');
					} else {
						// We have an as-yet-unregistered prelaunch signup email address
						// attempting to login... Ask them to register.
						$_SESSION['prelaunch_email'] = $emailid;
						$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'To complete registration enter your name and choose a password.');
					}
				}
			}
        }
	}
    //login Code End
  

//wrtlog("loginsignup 232"); // DEBUG
 
    //Start Signup Code    
    if(isset($_POST) && !$doingLogin && (isset($_POST["submitSignup"])) || isset($_POST['passvalue']))
    {

//wrtlog("loginsignup 238"); // DEBUG

		$_SESSION['msgType']='';
		extract($_POST);
		if (!isset($username)) $username = '';
		if (!isset($emailid)) $emailid = '';
		if (!isset($passwd)) $passwd = '';
		if (!isset($cpasswd)) $cpasswd = '';
		$err = false;
		$obj = new validation();
		$obj->add_fields($username, 'req', ER_USER);
		$obj->add_fields($username, 'name', 'Please enter valid Name');
		$obj->add_fields($username, 'min=4', 'Name should be atleast 4 characters long');
        $obj->add_fields($username, 'max=25', 'Name should not be more than 25 characters long');
		//$obj->add_fields($username, 'alphanumUD', "username".ER_ALPHANUM);
		$obj->add_fields($emailid, 'req', 'Enter Email Address');
  		$obj->add_fields($emailid, 'email', 'Enter valid Email Address');
		$obj->add_fields($passwd, 'req',ER_PSW);
        $obj->add_fields($passwd, 'min=6', 'Enter Password atleast 6 characters long');
        $obj->add_fields($passwd, 'max=25', 'Password should not be more than 25 characters long');
		$obj->add_fields($cpasswd, 'req', ER_CPSW);
		//$obj->add_fields($txtTerms, 'req', 'Term & Condition Check required');
		$error = $obj->validate();		
		
		if(isset($txtTerms) && ($txtTerms !=1)){
			$txtTerms=0;
		}else{
			$txtTerms=1;
		} 
		
		if(!$err && ($passwd!=$cpasswd)) {
			//$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>ER_SAMEPSW);
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"The passwords did not match.");
			$err = true;
		}
		
		
		$emailid = base64_encode($emailid);	
        $email_valid=$con->recordselect("SELECT `emailAddress` FROM `users` WHERE `emailAddress` = '".$emailid."'");
        $email_valid1=mysql_num_rows($email_valid);

        if(!$err && ($email_valid1>0))
        {
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"That email address has already been registered.");
			$err = true;
		}
		
		if( !$err && !preg_match('`[A-Z]`',$passwd) // at least one upper case 
			&& preg_match('`[a-z]`',$passwd) // at least one lower case 
			&& preg_match('`[0-9]`',$passwd) // at least one digit 
			)
		{ 
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"The password must contain a minimum of one lower case character. one upper case character, one digit");
			$err = true;
		}  		
		
		if(!$err && ($_SESSION['msgType'] == '') && ($error == ''))
        {
			$time_add=time();
			$acti_key=base64_encode($time_add);
			$created=date('Ymd');			
			$password = base64_encode($passwd);
			$refid = (isset($_SESSION['refid'])) ? $_SESSION['refid'] : 0; // jwg
			$accessIp = $signupIp = get_ip_address1(); // jwg
			$con->insert("INSERT INTO users (userId, emailAddress, name, password, created, access, status, activated, randomNumber, profilePicture, accessIp, signupIp, newsletter, referrerId) VALUES
			                           (NULL, '$emailid', '".sanitize_string($username)."', '$password', $created, NULL, 0, 0, '$acti_key', NULL, '$accessIp', '$signupIp', '$txtTerms', '$refid' )");
			$lastId = mysql_insert_id();

			// remove prelaunch_signup record for just-registered user - if present
			$sel_prelaunch = $con->recordselect("SELECT * FROM `prelaunch_signup` WHERE `emailAddress` = '".$_POST['emailid']."'");
			if(mysql_num_rows($sel_prelaunch)>0) {
				$con->delete("DELETE FROM `prelaunch_signup` WHERE `emailAddress` = '".$_POST['emailid']."'");
			}
			
			// track referrals
			if (($refid > 0) && isset($_SESSION['projid'])) {
				$projid = $_SESSION['projid'];
				$con->insert("INSERT INTO `referrals` (`newuserId`, `referrerId`, `created`, `projectId`) 
								VALUES ($lastId, $refid, ".time().", $projid) ");
			}
			
			if($txtTerms == 1){
				$sel_newsletter = $con->recordselect("SELECT * FROM newsletter_user WHERE email='".$emailid."'");
				if(mysql_num_rows($sel_newsletter)>0)
				{
					$con->update("UPDATE newsletter_user SET status=1, userId='".$lastId."'  WHERE email='".$emailid."'");
				}
				else
				{
					$cur_time=time();
					$con->insert("INSERT INTO newsletter_user (`id`, `userId`, `email`, `createDate`, `status`) VALUES (NULL, '".$lastId."', '".$emailid."', '".$cur_time."', '1')");
				}
			}
			
			if (isset($_SESSION['fbuser']) && !empty($_SESSION['fbuser']['name'])) {
				redirect(SITE_URL."user_activation/email/".$emailid."/actCode/".base64_encode($time_add));
			} else {
			
				$artical="";
				$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
				$artical.="<body><strong>Hello ".sanitize_string($username).", </strong><br />";
				$artical.="<br />Thank you for creating your account at ".DISPLAYSITENAME.".com.<br /><br />";
				$artical.="<table><tr><td colspan='2'><strong>Account Information</strong></td></tr>";
				$artical.="<tr><td colspan='2'>&nbsp;</td></tr><tr><td><strong>User Id : </strong></td><td>".base64_decode($emailid)."</td></tr>";
				$artical.="<tr><td><strong>Password : </strong></td><td>".$passwd."</td></tr>";
				$artical.="<tr><td colspan='2'>&nbsp;</td></tr></table>";
				$artical.="Activate your account by clicking on following link: <a href='".SITE_URL."user_activation/email/".$emailid."/actCode/".base64_encode($time_add)."' target='_blank'>Activate</a>
				<br /> After activation you may login to manage your account.";
				$artical.="<br /><br />Regards,<br />".DISPLAYSITENAME." Team</body></html>";
				$subject="Registration Details At ".DISPLAYSITENAME."";
				$mailbody=$artical;
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html\r\n";
				$headers .= FROMEMAILADDRESS;
				@mail(base64_decode($emailid), $subject, $mailbody, $headers);
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"You have registered Successfully. Check mail to activate your account");
				
				redirect(SITE_URL."login/");  // jwg - added trailing / ...
				//redirectPage(SITE_ADM."change_password.php?msg=CHANGEPSW");
			}
		}
	}    
    //Signup Code End


//wrtlog("loginsignup 357"); // DEBUG

    
     //forgot pass code start
    if(isset($_POST) && (!isset($_SESSION['msgType']) || ($_SESSION['msgType'] == '')) && (!isset($error) || ($error == '')) && (isset($_POST["submit_forgotpass"]) || isset($_POST['for_email'])))
    {
	

//wrtlog("loginsignup 365"); // DEBUG
	
		//wrtlog("loginsignup at 323");
		extract($_POST);
		$for_email = base64_encode($for_email);
		$email_valid=$con->recordselect("SELECT `emailAddress` FROM `users` WHERE `emailAddress` = '".$for_email."'");
		$email_valid1=mysql_num_rows($email_valid);
		
        if($email_valid1>0)
        {
			$act_key=$con->recordselect("SELECT * FROM `users` WHERE `emailAddress` = '".$for_email."'");
			$act_key1=mysql_fetch_array($act_key);
			$username=$act_key1['name'];
			$rendomNumber = $act_key1['randomNumber'];
			$artical="";
			$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical.="<body><strong>Hello ".sanitize_string($username).", </strong><br />";
			$artical.="Please Reset Password by clicking on following link.<br /><a href='".SITE_URL."resetpassword/email/".$for_email."/actCode/".$rendomNumber."' target='_blank'>Reset password</a><br /> ";
			$artical.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
			$subject="Reset password At ".DISPLAYSITENAME."";
			$mailbody=$artical;
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html\r\n";
			$headers .= FROMEMAILADDRESS;
			@mail(base64_decode($for_email), $subject, $mailbody, $headers);
			
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"We have sent an Email on your email Address with instruction to Reset your Password");
			redirect(SITE_URL."login");
        }
        else
        {
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"You have entered wrong Email Address");
			redirect(SITE_URL."login");
	
        }        
    }
	//wrtlog("loginsignup at 357");
	
	$sel_ContentPage = $con->recordselect("SELECT * FROM `content` WHERE `title` LIKE '%term%' LIMIT 1");
	$sel_ContentPage = mysql_fetch_array($sel_ContentPage);
    
	//wrtlog("at end of loginsignup. ".print_r($_SESSION,true)."<br/>".print_r($_REQUEST,true));
	
	$module='user';
	$page='loginsignup';
	$content=$module.'/'.$page;
//	$fb_login_require = true;
//	require_once('../fb_connect/fb_login.php');
	require_once(DIR_TMP."main_page.tpl.php");
	
?>