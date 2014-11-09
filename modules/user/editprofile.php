<?php
	require_once("../../includes/config.php");
	
	
	if(isset($_REQUEST["request_token"])) {
		$con->update("UPDATE users SET paypal_request_token='$_REQUEST[request_token]', paypal_verification_code='$_REQUEST[verification_code]', paypal_status='1'
				WHERE `userId` = '".$_SESSION['userId']."'");
	}

	$left_panel=false;
	$cont_mid_cl='-75';
	$title = "Edit profile";
	$meta = array("description"=>"Edit profile","keywords"=>"Edit profile");

	if($_SESSION["userId"]=="" && $_SESSION["name"]=="")
	{
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Please login to access this page.");	
			redirect(SITE_URL."index.php");
			exit;		
  	}
	if(isset($_POST["submit_deleteacc"]))
	{
		$con->update("UPDATE users SET activated=2, status=0 WHERE userId='".$_SESSION['userId']."'");
		$_SESSION["userId"]="";
		$_SESSION["name"]="";
		session_destroy();
		redirect(SITE_URL."index.php");
	}
if(isset($_POST["submitEditprofile"]))
{
	extract($_POST);

	$obj = new validation();

	$obj->add_fields($username, 'req', ER_USER);
	//$obj->add_fields($username, 'username', 'Please enter valid Name');
	//$obj->add_fields($username, 'min=3', 'Name should be atleast 3 characters long');
	//$obj->add_fields($username, 'max=25', 'Name should not be more than 25 characters long');	
	$error = $obj->validate();	
	
    if(isset($_POST["submitEditprofile"]) & $error=='')
    {    
		extract($_POST);
		$username1=sanitize_string(preg_replace('/\s+/', ' ', $username));
		$biograpy1=sanitize_string(preg_replace('/\s+/', ' ', $biography));
		$con->update("UPDATE users SET timezone='$time_zone', biography='".$biograpy1."', name='".$username1."', userLocation='$location_name' WHERE userId='".$_SESSION['userId']."'");
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>EDIT);							
		if(!empty($websiteadd))
		{
		extract($_POST);
			foreach ($websiteadd as $item_id=>$webs_site_add) 
			{
				$con->insert("INSERT INTO userwebsites (siteId, siteUrl, userId) VALUES
													(NULL, '$webs_site_add', '".$_SESSION['userId']."')");
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Web site added Successfuly");	
			}
		}
			
		
    }

	if(isset($_FILES) && isset($_FILES['photo']) && isset($_FILES['photo']['name']) && ($_FILES['photo']['name']!=""))
	{
		if($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/jpg" || $_FILES['photo']['type']=="image/pjpeg" )		
		{
			require("../../includes/cimage.php");
			/////////////////////////
					// Check the upload
					if (!isset($_FILES["photo"]) || !is_uploaded_file($_FILES["photo"]["tmp_name"]) || $_FILES["photo"]["error"] != 0) {
						echo "ERROR:invalid upload";
						exit(0);
					}
				
					// Get the image and create a thumbnail
					$img = imagecreatefromjpeg($_FILES["photo"]["tmp_name"]);
					if (!$img) {
						echo "ERROR:could not create image handle ". $_FILES["photo"]["tmp_name"];
						exit(0);
					}
				
					$width = imageSX($img);
					$height = imageSY($img);
				
					if (!$width || !$height) {
						$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Invalid width or height.");	
						redirect($base_url."profile/edit");
					}
					if ($width<250 || $height<250) {
						//echo "ERROR:Invalid width or height";
						$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Width and Height must be more than 250*250.");	
						redirect($base_url."profile/edit");
						//exit(0);
					}
				
					// Build the thumbnail
					$target_width = 200;
					$target_height = 150;
					$target_ratio = $target_width / $target_height;
				
					$img_ratio = $width / $height;
				
					if ($target_ratio > $img_ratio) {
						$new_height = $target_height;
						$new_width = $img_ratio * $target_height;
					} else {
						$new_height = $target_width / $img_ratio;
						$new_width = $target_width;
					}
				
					if ($new_height > $target_height) {
						$new_height = $target_height;
					}
					if ($new_width > $target_width) {
						$new_height = $target_width;
					}
				
					$new_img = ImageCreateTrueColor(200, 150);
					if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, 0)) {	// Fill the image black
						echo "ERROR:Could not fill new image";
						exit(0);
					}
				
					if (!@imagecopyresampled($new_img, $img, ($target_width-$new_width)/2, ($target_height-$new_height)/2, 0, 0, $new_width, $new_height, $width, $height)) {
						echo "ERROR:Could not resize image";
						exit(0);
					}
				
					if (!isset($_SESSION["file_info"])) {
						$_SESSION["file_info"] = array();
					}
				function save($path) {    
						$input = fopen("php://input", "r");
						$temp = tmpfile();
						$realSize = stream_copy_to_stream($input, $temp);
						fclose($input);
						$target = fopen($path, "w");        
						fseek($temp, 0, SEEK_SET);
						stream_copy_to_stream($temp, $target);
						fclose($target);
						
						return true;
					}
					// Use a output buffering to load the image into a variable
					ob_start();
					imagejpeg($new_img);
					$imagevariable = ob_get_contents();
					ob_end_clean();
					$pathinfo = pathinfo($_FILES["photo"]["tmp_name"]);
						$filename = $_FILES["photo"]["name"];//$pathinfo['filename'];
						//$filename = md5(uniqid());		
						$ext = substr(strrchr($filename, '.'), 1);
					 $qy3="SELECT * FROM photo_dir where dir_type='Project Images'";	
						//image_upload code starts here.	
						$rs3=mysql_query($qy3);
						$uploaddir = DIR_IMG."site/projectImages/photos";
						if(mysql_num_rows($rs3)>0)
						{
							while($rsw3=mysql_fetch_array($rs3))
							{
								$rsw3["files"];
								if($rsw3["files"]>=620)
								{
									$n=1;
									$n=$rsw3["no"]+1;
									mkdir("photos".$n,0770);
									$sql="update photo_dir set currentdir='photos".$n."',files=0,no=".$n." where dir_type='project Images'";					
									mysql_query($sql);				
									$uploaddir =DIR_IMG."site/projectImages/photos".$n;
								}
								else
								{
									$uploaddir = DIR_IMG."site/projectImages/".$rsw3["currentdir"];
								}	
							}
						}
						else
						{
							$uploaddir = DIR_IMG."site/projectImage/photos";
							$sql="insert into photo_dir(currentdir,files,no,dir_type) values('".$uploaddir."',0,0,'Project Images')";
							mysql_query($sql);
						}
						$uploadDirectory = $uploaddir;		
						$img = new Upload();
						$img->dir = $uploaddir;
						//$img->file_new_prefix=$ext;
						$img->file_exetension = $ext;
						$img->file_new_name = $filename;
						$tempPath = $_FILES['photo']['tmp_name'];		
						 if (move_uploaded_file($tempPath,$uploadDirectory ."/". $filename)){
							//return array('success'=>true);
							$flag = 1;
						} else {
							$flag=0;
							
						}		
						if($flag==1)
						{
							$temparr=$img->Gen_File_Dimension($img->dir."/".$img->file_new_name);
							$widthfull = $temparr[0];
							$heightfull = $temparr[1];		
							
							//$filename100_80 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;	
							//$filename40_40 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
							
							$filename220_220=$img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;	
							$filename40_30=$img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;	
							$filename80_60=$img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
							$filename80_80=$img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
							$filename100_100=$img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
							
							
							
							$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename220_220,220,220);
							$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename100_100,100,100);	
							$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename80_60,80,60);	
							$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename80_80,80,80);	
							$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename40_30,40,30);
								
										
							unlink($img->dir."/".$img->file_new_name);
							$filename220_220 = str_replace(DIR_FS,"",$filename220_220);
							$filename100_100 = str_replace(DIR_FS,"",$filename100_100);
							$filename80_60 = str_replace(DIR_FS,"",$filename80_60);
							$filename80_80 = str_replace(DIR_FS,"",$filename80_80);
							$filename40_30 = str_replace(DIR_FS,"",$filename40_30);
							$now = time();
							$userId = $_SESSION['userId'];
							$selectQuery = $con->recordselect("SELECT * from users where userId=".$userId);
							if(mysql_num_rows($selectQuery)>0)
							{
								$imageDetails = mysql_fetch_array($selectQuery);
								if (!empty($imageDetails['profilePicture'])) @unlink(DIR_FS.$imageDetails['profilePicture']);
								if (!empty($imageDetails['profilePicture40_40'])) @unlink(DIR_FS.$imageDetails['profilePicture40_40']);
								if (!empty($imageDetails['profilePicture80_60'])) @unlink(DIR_FS.$imageDetails['profilePicture80_60']);
								if (!empty($imageDetails['profilePicture80_80'])) @unlink(DIR_FS.$imageDetails['profilePicture80_80']);
								if (!empty($imageDetails['profilePicture100_100'])) @unlink(DIR_FS.$imageDetails['profilePicture100_100']);								
							}			
							$update = "UPDATE users SET profilePicture='".$filename220_220."', profilePicture80_60='".$filename80_60."', profilePicture80_80='".$filename80_80."',
								 profilePicture100_100='".$filename100_100."', profilePicture40_40='".$filename40_30."' WHERE userId=".$userId. " LIMIT 1";
							$con->update($update);
									
							//return array('success'=>true);
						}
		}
		else
		{
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Invalid image format selected.");	
		}		
	}
}

if(isset($_POST["submitverifiedstatus"]))
{
	require_once('../../includes/paypal/config.php');
	require_once('../../includes/paypal/paypal.class.php');
	
	// Create PayPal object.
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
	
	$PayPal = new PayPal_Adaptive($PayPalConfig);
	
	// Prepare request arrays
	$GetVerifiedStatusFields = array(
									'EmailAddress' => $_POST['paypalemail'], 					// Required.  The email address of the PayPal account holder.
									'FirstName' => $_POST['paypalfname'], 						// The first name of the PayPal account holder.  Required if MatchCriteria is NAME
									'LastName' => $_POST['paypallname'], 						// The last name of the PayPal account holder.  Required if MatchCriteria is NAME
									'MatchCriteria' => 'NAME'					// Required.  The criteria must be matched in addition to EmailAddress.  Currently, only NAME is supported.  Values:  NAME, NONE   To use NONE you have to be granted advanced permissions
									);
	
	$PayPalRequestData = array('GetVerifiedStatusFields' => $GetVerifiedStatusFields);
	
	// Pass data into class for processing with PayPal and load the response array into $PayPalResult
	$PayPalResult = $PayPal->GetVerifiedStatus($PayPalRequestData);
	
	// Write the contents of the response array to the screen for demo purposes.
	/*echo '<pre />';
	print_r($PayPalResult);
	echo $PayPalResult['AccountStatus'];*/
	if($PayPalResult['AccountStatus']=="VERIFIED") {
		$paypalemail=base64_encode($_POST['paypalemail']);
		$paypalFname=$_POST['paypalfname'];
		$paypalLname=$_POST['paypallname'];
		$con->update("UPDATE users SET paypalUserAccount='$paypalemail', paypalFname='$paypalFname', paypalLname='$paypalLname'
				WHERE `userId` = '".$_SESSION['userId']."'");
		
		/****** Paypal Adaptive REFUND permission code *******/
		
		$PayPal = new PayPal_Adaptive($PayPalConfig);

		// Prepare request arrays
		$Scope = array(
			'REFUND'
		);

		$RequestPermissionsFields = array(
			'Scope' => $Scope, 				// Required.   
			'Callback' => $base_url.'profile/edit/'			// Required.  Your callback function that specifies actions to take after the account holder grants or denies the request.
		);
		
		//print_r($RequestPermissionsFields);	
		$PayPalRequestData = array('RequestPermissionsFields'=>$RequestPermissionsFields);

		// Pass data into class for processing with PayPal and load the response array into $PayPalResult
		$PayPalPer = $PayPal->RequestPermissions($PayPalRequestData);
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Your Paypal Account is Added Successfuly");
		redirect($PayPalPer['RedirectURL']);
		
		//redirect($base_url."profile/edit/");
	} else {
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Problem Verifying your Paypal Business Account, Please Try Again");
		redirect($base_url."profile/edit/");
	}
}

if(isset($_POST["submitaccset"]) && isset($_POST['newpasswd']))
{
    extract($_POST);
	$obj = new validation();
	
		
	$obj->add_fields($newpasswd, 'min=6', 'Enter Password atleast 6. characters long');
	$obj->add_fields($newpasswd, 'max=25', 'Password should not be more than 25 characters long');
	$obj->add_fields($newpasswd, 'alphanumUD', "Passord".ER_ALPHANUM);	
	$obj->add_fields($confpasswd, 'alphanumUD', "Confirmed passord".ER_ALPHANUM);
	$error = $obj->validate();
	if (!isset($error2)) $error2 = '';
	if($newpasswd != '')
	{
	if( preg_match('`[A-Z]`',$newpasswd) // at least one upper case 
			&& preg_match('`[a-z]`',$newpasswd) // at least one lower case 
			&& preg_match('`[0-9]`',$newpasswd) // at least one digit 
			)
		{ 
			
		}
		else
		{ 
			$error2 .= 'The password must contain a minimum of one lower case character. one upper case character, one digit and one special character'.'<br>'; // not valid 
		} 
	}
	if($newpasswd!=$confpasswd)
		$error2 .= ER_SAMEPSW.'<br>';
		
	
		
	if($error2=='')
	{
		/*if($newpasswd!='' && $useremail!='')
		{
			$password = base64_encode($newpasswd);			
			$con->update("UPDATE users SET emailAddress='$useremail', password='$password'
														WHERE `userId` = '".$_SESSION['userId']."'");
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Email and Password Updated Successfuly");
			redirect($base_url."modules/user/editprofile.php?#account_tab");
		}
		else if($useremail!='')
		{			
			$con->update("UPDATE users SET emailAddress='$useremail'
														WHERE `userId` = '".$_SESSION['userId']."'");
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Email Updated Successfuly");
			redirect($base_url."modules/user/editprofile.php?#account_tab");
		}*/
		if($newpasswd!='')
		{
			$password = base64_encode($newpasswd);
			$con->update("UPDATE users SET password='$password'
														WHERE `userId` = '".$_SESSION['userId']."'");
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Password Updated Successfuly");
			redirect($base_url."profile/edit/");
		}
	}
}

    $result=mysql_fetch_array($con->recordselect("SELECT * FROM users WHERE userId='".$_SESSION['userId']."'"));
    $website_res=$con->recordselect("SELECT * FROM userwebsites WHERE userId='".$_SESSION['userId']."'");
if(isset($_POST["submitNotification"]))
{
	//echo $_POST[user];
	if(isset($_POST['send_newsletters']) && ($_POST['send_newsletters']==1))
	{
		
		$con->update("UPDATE users SET newsletter=1 WHERE userId='".$_SESSION['userId']."'");
    	$sel_newsletter=$con->recordselect("SELECT * FROM newsletter_user WHERE email='".$result['emailAddress']."'");
		if(mysql_num_rows($sel_newsletter)>0)
		{
			$con->update("UPDATE newsletter_user SET status=1, userId='".$_SESSION['userId']."'  WHERE email='".$result['emailAddress']."'");
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Notification settings saved successfully');
		}
		else
		{
			$cur_time=time();
			$con->insert("INSERT INTO newsletter_user (`id`, `userId`, `email`, `createDate`, `status`) VALUES (NULL, '".$_SESSION['userId']."', '".$result['emailAddress']."', '".$cur_time."', '1')");
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Notification settings saved successfully');
		}
	}
	else
	{
		$con->update("UPDATE users SET newsletter=0 WHERE userId='".$_SESSION['userId']."'");
		$con->update("UPDATE newsletter_user SET status=0 WHERE userId='".$_SESSION['userId']."'");
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Notification settings saved successfully');
	}
	if(isset($_POST['notify_of_friend_activity']) && ($_POST['notify_of_friend_activity']==1))
	{
		$con->update("UPDATE users SET lanuchProjectNotify='1' WHERE userId='".$_SESSION['userId']."'");
	}
	else
	{
		$con->update("UPDATE users SET lanuchProjectNotify='0' WHERE userId='".$_SESSION['userId']."'");
	}
	if(isset($_POST['notify_of_follower']) && ($_POST['notify_of_follower']==1))
	{
		$con->update("UPDATE users SET newFollower='1' WHERE userId='".$_SESSION['userId']."'");
	}
	else
	{
		$con->update("UPDATE users SET newFollower='0' WHERE userId='".$_SESSION['userId']."'");
	}
	if(isset($_POST['notify_of_updates']) && ($_POST['notify_of_updates']==1))
	{
		$con->update("UPDATE users SET updatesNotifyBackedProject='1' WHERE userId='".$_SESSION['userId']."'");
	}
	else
	{
		$con->update("UPDATE users SET updatesNotifyBackedProject='0' WHERE userId='".$_SESSION['userId']."'");
	}
	if(isset($_POST['notify_of_comments']) && ($_POST['notify_of_comments']==1))
	{
		$con->update("UPDATE users SET createdProjectComment='1' WHERE userId='".$_SESSION['userId']."'");
	}
	else
	{
		$con->update("UPDATE users SET createdProjectComment='0' WHERE userId='".$_SESSION['userId']."'");
	}
	if(isset($_POST['notify_of_pledges']) && ($_POST['notify_of_pledges']==1))
	{
		$con->update("UPDATE users SET pledgeMail='1' WHERE userId='".$_SESSION['userId']."'");
	}
	else
	{
		$con->update("UPDATE users SET pledgeMail='0' WHERE userId='".$_SESSION['userId']."'");
	}
	redirect($base_url."profile/edit/");
}   
	require_once("timezonelist.php");
	$module='user';
	$page='editprofile';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>