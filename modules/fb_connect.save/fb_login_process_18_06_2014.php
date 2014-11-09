<?php 
	require_once("../../includes/config.php");
	require_once("../../includes/cimage.php");
		
	extract($_REQUEST);
	$fb_createProjectId = $fb_createProject;
	$fb_about_me = sanitize_string($fb_about_me);
	$fb_email = base64_encode($fb_email);
	$fb_login_require = $fb_login_require;
	/*echo '<pre>';
	print_r($_REQUEST);
	echo '</pre>';
	echo $fb_createProjectId;
	echo '-'.$fb_login_require;
	echo '-'.$_SESSION['projectId'];
	echo '-'.$_SESSION['userId'];
	exit;*/
	if(($fb_createProjectId >0 && $fb_login_require == TRUE) || (isset($_SESSION['projectId']) && $_SESSION['userId'])){
		$userid = $con->recordselect("SELECT * FROM users WHERE userId='".$_SESSION['userId']."' AND emailAddress='".$fb_email."' LIMIT 1");
		if(mysql_num_rows($userid)>0) {
			$mysqlResult = mysql_fetch_assoc($userid);
			$email123 = (string)$mysqlResult['emailAddress'];
			if($fb_email == $email123){
				$userBioPrj = $con->recordselect("SELECT userBiography FROM projectbasics WHERE projectId='".$fb_createProjectId."' LIMIT 1");
				$mysqlResult1 = mysql_fetch_assoc($userBioPrj);
				if(isset($mysqlResult1['userBiography'])){
					$userBioUpdate = sanitize_string($mysqlResult1['userBiography'].' '.$fb_about_me);
				}else{
					$userBioUpdate = sanitize_string($mysqlResult['biography'].$prj_bio.' '.$fb_about_me);	
				}
				$updateBasic = $con->update("UPDATE projectbasics SET `userBiography` ='".$userBioUpdate."'  WHERE `projectId` = ".$fb_createProjectId);
				/*$updateBasic = $con->update("UPDATE projectbasics SET `userBiography` ='".$userBioUpdate."'  WHERE `projectId` = ".$_SESSION['projectId']);*/
				$updateUserBio = $con->update("UPDATE users SET `biography` ='".$userBioUpdate."'  WHERE `userId` = ".$_SESSION['userId']);
				$fbs_bio_set = true;
				redirect(SITE_URL."createproject/".$fb_createProjectId);	
			}
			$fb_bio_set = false;
			redirect(SITE_URL."createproject/".$fb_createProjectId);
		}
		$fb_bio_set = false;
		redirect(SITE_URL."createproject/".$fb_createProjectId);
		exit;
	}
	if($fb_createProjectId > 0){
		redirect(SITE_URL."createproject/".$fb_createProjectId);
		exit;
	}
	
	//$_SESSION["userId"]=$ses_ver['userId'];
	$_SESSION["name"] = $fname." ".$lname;
	//check if user has already signed up before
	$insert = true;
	$email = base64_encode($email);		
	$userid = $con->recordselect("SELECT * FROM users WHERE emailAddress='".$email."' LIMIT 1");
	if(mysql_num_rows($userid)>0) {
		$insert = false;
	}
		
	// if new user, insert user details in your mysql table
	if($insert)
	{
		
		if($gender=="female")
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
		
		$_SESSION["name"] = sanitize_string($_SESSION["name"]);
		$profilePicture = addslashes($photo_big);
		$profilePicture100_100 = addslashes($photo);
		$profilePicture80_80 = addslashes($photo_small);
		$profilePicture80_60 = addslashes($photo);
		$profilePicture40_40 = addslashes($photo);
		
		$time_add=time();
		$acti_key=base64_encode($time_add);
		
		$con->insert("INSERT INTO users (emailAddress, name, password, created,  status, activated, randomNumber, profilePicture, profilePicture100_100 , profilePicture80_80 ,profilePicture80_60, profilePicture40_40, newsletter) 
		VALUES('".$email."', '".$_SESSION["name"]."', '".$password."', $created, 1, 1,'".$acti_key."', '".$profilePicture."', '".$profilePicture100_100."','".$profilePicture80_80."', '".$profilePicture80_60."', '".$profilePicture40_40."', 1)");
			
		$userid=mysql_insert_id();
		$artical="";
		$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$artical.="<body><strong>Hello ".$_SESSION["name"].", </strong><br />";
		$artical.="<br />Thank you for creating your profile on ".DISPLAYSITENAME.".com.<br /><br />";
		$artical.="<table><tr><td colspan='2'><strong>Account Information</strong></td></tr>";
		$artical.="<tr><td colspan='2'>&nbsp;</td></tr><tr><td><strong>User Id : </strong></td><td>".base64_decode($email)."</td></tr>";
		$artical.="<tr><td><strong>Password : </strong></td><td>".$pass."</td></tr>";
		$artical.="<tr><td colspan='2'>&nbsp;</td></tr></table>";			
		$artical.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
		$subject="Registration Detail At ".DISPLAYSITENAME."";
		$mailbody=$artical;
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html\r\n";
		$headers .= FROMEMAILADDRESS;
		$_SESSION["userId"] = $userid;
		@mail(base64_decode($email), $subject, $mailbody, $headers);
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"You are registered successfully");
	} 
	else 
	{
		$userid = $con->recordselect("SELECT * FROM users WHERE emailAddress='".$email."' LIMIT 1");
		$mysqlResult = mysql_fetch_assoc($userid);
		//print_r($mysqlResult);
		//exit;		
		$_SESSION["userId"] = $mysqlResult['userId'];
		$_SESSION["name"] = $mysqlResult['name'];
	}

if($_SESSION['userId']!="") {
	 redirect(SITE_URL."profile/");
} else {
	 redirect($login_url);
}
exit;
?>