<?php
//echo $module.'----'.$page;
//exit;

if($fb_login_require == true && $page=='loginsignup')
{ 
	if($_SESSION["userId"]=='')
	{
if(isset($_SESSION['User']) && $_SESSION['User']["name"] != '')
	{
		//print_r($_SESSION['User']);
		//exit;
		$fbArray = $_SESSION['User'];
		$user_email=base64_encode($fbArray['email']);
		$userid=getValFromTbl('userId','users',"emailAddress='".$user_email."'");
		$fb_about_me = sanitize_string($fbArray['bio']);
		
		if($userid > 0)
		{
			
		}
		else
		{
		
		if(addslashes($fbArray['gender'])=="female")
		{
			$sex="0";
		}
		else
		{
			$sex="1";
		}
		$pass=generate_password(8);
		$password = base64_encode($pass);
		$created=date('Ymd');
		//stor image form facebook
		$profilePicture='http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?width=220&height=165';
		$photo = 'http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?width=100&height=100';
	$photo_small='http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?width=80&height=80';
	$profilePicture80_60_tmp = 'http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?width=80&height=60';
	$profilePicture40_40_tmp = 'http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?width=40&height=40';
		//stor image form facebook end
		
		
		$_SESSION["name"] = sanitize_string(addslashes($fbArray['first_name']).addslashes($fbArray['last_name']));
		$profilePicture = addslashes($profilePicture);
		$profilePicture100_100 = addslashes($photo);
		$profilePicture80_80 = addslashes($photo_small);
		$profilePicture80_60 = addslashes($photo);
		$profilePicture40_40 = addslashes($photo);
		
		$time_add=time();
		$acti_key=base64_encode($time_add);
		$con->insert("INSERT INTO users (emailAddress, name, biography, password, created,  status, activated, randomNumber, profilePicture, profilePicture100_100 , profilePicture80_80 ,profilePicture80_60, profilePicture40_40, newsletter) 
		VALUES('".base64_encode($fbArray['email'])."', '".addslashes($fbArray['first_name'])."', '".$fb_about_me."', '".$password."', $created, 1, 1,'".$acti_key."', '".$profilePicture."', '".$profilePicture100_100."','".$profilePicture80_80."', '".$profilePicture80_60."', '".$profilePicture40_40."', 1)");
			
		$userid=mysql_insert_id();
		$artical="";
		$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$artical.="<body><strong>Hello ".$_SESSION["name"].", </strong><br />";
		$artical.="<br />Thank you for creating your profile on ".DISPLAYSITENAME.".com.<br /><br />";
		$artical.="<table><tr><td colspan='2'><strong>Account Information</strong></td></tr>";
		$artical.="<tr><td colspan='2'>&nbsp;</td></tr><tr><td><strong>User Id : </strong></td><td>".base64_decode(base64_encode($fbArray['email']))."</td></tr>";
		$artical.="<tr><td><strong>Password : </strong></td><td>".$pass."</td></tr>";
		$artical.="<tr><td colspan='2'>&nbsp;</td></tr></table>";			
		$artical.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
		$subject="Registration Detail At ".DISPLAYSITENAME."";
		$mailbody=$artical;
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html\r\n";
		$headers .= FROMEMAILADDRESS;
		$_SESSION["userId"] = $userid;
		@mail(base64_decode(base64_encode($fbArray['email'])), $subject, $mailbody, $headers);
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"You are registered successfully");
	 }
	
		$userid = $con->recordselect("SELECT * FROM users WHERE emailAddress='".base64_encode($fbArray['email'])."' LIMIT 1");
		$mysqlResult = mysql_fetch_assoc($userid);
		//print_r($mysqlResult);
		//exit;		
		$_SESSION["userId"] = $mysqlResult['userId'];
		$_SESSION["name"] = $mysqlResult['name'];
		
		redirect(SITE_URL."profile/");
		unset($_SESSION['User']);
		exit;
		
	}
}
}

else if($fb_login_require == true && $module=='createProject' && $page=='index' && (isset($fb_createProject_Id) && $fb_createProject_Id >0 ))
{
	//global $fb_DONE;
	//global $fb_bio_set;
	
	if(isset($_SESSION['User']) && $_SESSION['User']["name"] != '')
	{
		$fbArray = $_SESSION['User'];
		$fb_createProjectId = $fb_createProject_Id;
		$fb_about_me = sanitize_string($fbArray['bio']);
		$fb_email = base64_encode($fbArray['email']);
		$fb_login_require = $fb_login_require;
		
		if(($fb_createProjectId >0 && $fb_login_require == TRUE) || (isset($_SESSION['projectId']) && $_SESSION['userId'])) {
		
		$userid = $con->recordselect("SELECT * FROM users WHERE userId='".$_SESSION['userId']."' AND emailAddress='".$fb_email."' LIMIT 1");
		
		if(mysql_num_rows($userid)>0) {
			
			$mysqlResult = mysql_fetch_assoc($userid);
			$email123 = (string)$mysqlResult['emailAddress'];
			//echo $email123;
			//echo '<br/>'.$fb_email;exit;
			if($fb_email == $email123) {
				
				$userBioPrj = $con->recordselect("SELECT userBiography FROM projectbasics WHERE projectId='".$fb_createProjectId."' LIMIT 1");
				$mysqlResult1 = mysql_fetch_assoc($userBioPrj);
				
				if(isset($mysqlResult1['userBiography'])) {
					$userBioUpdate = sanitize_string($mysqlResult1['userBiography'].' '.$fb_about_me);
				}else{
					$userBioUpdate = sanitize_string($mysqlResult['biography'].' '.$fb_about_me);	
				}
				
				$updateBasic = $con->update("UPDATE projectbasics SET `userBiography` ='".$userBioUpdate."'  WHERE `projectId` = ".$fb_createProjectId);
				
				$updateUserBio = $con->update("UPDATE users SET `biography` ='".$userBioUpdate."'  WHERE `userId` = ".$_SESSION['userId']);
				$fb_bio_set = true;
				//$fb_DONE = 1;
				$fb_login_require = false;
				$fb_createProject_Id = 0;
				unset($_SESSION['User']);
				//redirect(SITE_URL."createproject/".$fb_createProjectId);
				//exit;	
			}
			$fb_bio_set = false;
			//$fb_DONE = 1;
			$fb_login_require = false;
			$fb_createProject_Id = 0;
			unset($_SESSION['User']);
			//redirect(SITE_URL."createproject/".$fb_createProjectId);
			//exit;
		}
		$fb_bio_set = false;
		//$fb_DONE = 1;
		$fb_login_require = false;
		$fb_createProject_Id = 0;
		unset($_SESSION['User']);
		//redirect(SITE_URL."createproject/".$fb_createProjectId);
		//exit;
	}
	}
	$fb_login_require = false;
	$fb_bio_set = true;
	$fb_createProject_Id = 0;
	unset($_SESSION['User']);
	//exit;
	
}
unset($_SESSION['User']);
/*else 
{
	 unset($_SESSION['User']);
	 //redirect($login_url);
	 //redirect(SITE_URL);
}*/
?>
