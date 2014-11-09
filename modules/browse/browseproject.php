<?php
	require_once("../../includes/config.php");
	
	if (!isset($_SESSION['userId']) || ($_SESSION['userId'] == '')) {
		$_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "Please login to view any project");
		$_SESSION['RedirectUrl'] = get_url();
		redirect($login_url);
		exit();
	}	
	
	//echo 'adminid'.$_SESSION["admin_user"];exit;
	$perpage 	= 3;
	$limit 		= " LIMIT 0,".$perpage;
	$rec_limit 	= " LIMIT 0,".$perpage;
	$comment_limit = " LIMIT 0,".$perpage;	
	
	if(isset($_GET) && isset($_GET['userid']) && ($_GET['userId'] != '')){
		if(isset($_SERVER['HTTP_REFERER'])){
			$referer = $_SERVER['HTTP_REFERER'];
			$parse = parse_url($_SERVER['HTTP_REFERER']);
			print_r($parse);
			if($parse['host'] == 'www.facebook.com'){
				$socialNet = 'FB';
			}elseif($parse['host'] == 't.co'){
				$socialNet = 'TW';
			}elseif($parse['host'] == 'www.facebook.com'){
				$socialNet = 'LN';
			}
			exit;
		}
		//print_r($_GET);
		//exit;
		/*
		$socialNet = $_GET['sn'];
		$projectId = $_GET['project'];
		$userId = $_GET['userId'];
		$qry1 = $con->recordselect("SELECT * FROM `temp` WHERE `userid`= '".$userId."'");
		$records = mysql_fetch_assoc($qry1); 
		$count_sos = (int)$records['scount']; 
		$count_sos = $count_sos + 1;
		if(mysql_num_rows($qry1) > 0){   
			$con->update("UPDATE temp SET scount='".$count_sos."' WHERE `value` = '".$socialNet."' AND `userid`= '".$userId."'");
		}else{
			$con->insert("INSERT INTO temp (`id` , `value` , `userid` , `scount` , `projectId`) 
			VALUES (NULL , '".$socialNet."' , '".$userId."' , ".$count_sos." , ".$projectId.")");
		}
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Count Increment ".$count_sos.".");
		$selectProject = mysql_fetch_assoc($con->recordselect("SELECT projectTitle from projectbasics where projectId = ".$projectId));
		redirect($base_url."browseproject/".$projectId."/".Slug($selectProject['projectTitle']).'/');
		*/
	}
	
	if(isset($_GET) && isset($_GET['type']) && ($_GET['type']=='comment')) {
		//echo 'project'.$_GET['project'];exit;
		$CommentDel = $con->delete("delete from projectcomments where commentId=".$_GET['commentid']);
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Commented succesfully deleted.');
		$sel_pro_basicdata=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$_GET['project']."'"));
		redirect(SITE_URL."browseproject/".$_GET['project'].'/'.Slug($sel_pro_basicdata['projectTitle']).'/');
	}
	
	if(isset($_GET) && isset($_GET['checkout_id']) && ($_GET['checkout_id']!='') && is_numeric($_GET['checkout_id'])) {
		$checkOutId =$_GET['checkout_id'];
		$findIn =$con->recordselect("SELECT * from paypaltransaction where transactionId=".$checkOutId);
		if(mysql_num_rows($findIn)>0)
		{
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Payment received sucessfully, your transaction id for payment is->'.$_GET['checkout_id']);
		}
	}
	if(isset($_GET) && isset($_GET['type']) && ($_GET['type']=='updatecomment')) {
		//echo 'project'.$_GET['project'];exit;
		$CommentDel = $con->delete("delete from projectupdatecomment where updatecommentId=".$_GET['commentid']);
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Commented succesfully deleted.');
		$sel_pro_basicdata=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$_GET['project']."'"));
		redirect(SITE_URL."browseproject/".$_GET['project'].'/'.Slug($sel_pro_basicdata['projectTitle']).'/');
	}
	if(isset($_GET) && isset($_GET['type']) && ($_GET['type']=='update')) {
		//echo 'project'.$_GET['commentid'];exit;
		$CommentDel = $con->delete("delete from projectupdate where projectupdateId=".$_GET['commentid']);
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Update succesfully deleted.');
		$sel_pro_basicdata=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$_GET['project']."'"));
		redirect(SITE_URL."browseproject/".$_GET['project'].'/'.Slug($sel_pro_basicdata['projectTitle']).'/');
	}
	
	if(isset($_GET) && isset($_GET['checkout_id']) && ($_GET['checkout_id']!='') && is_numeric($_GET['checkout_id'])) {
		$checkOutId =$_GET['checkout_id'];
		$findIn =$con->recordselect("SELECT * from paypaltransaction where transactionId=".$checkOutId);
		if(mysql_num_rows($findIn)>0)
		{
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Payment received sucessfully, your transaction id for payment is->'.$_GET['checkout_id']);
		}
	}
	
	if(isset($_POST) && isset($_POST["submit_forgotpass"]))
    {
		extract($_POST);
		$email_valid=$con->recordselect("SELECT `emailAddress` FROM `users` WHERE `emailAddress` = '".base64_encode($for_email)."'");
		$email_valid1=mysql_num_rows($email_valid);
		
        if($email_valid1>0)
        {
			$act_key=$con->recordselect("SELECT * FROM `users` WHERE `emailAddress` = '".base64_encode($for_email)."'");
			$act_key1=mysql_fetch_array($act_key);
			$username=$act_key1['name'];
			$artical="";
			$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical.="<body><strong>Hello ".sanitize_string($username).", </strong><br />";
			$artical.="Please Reset Password by clicking on following link.<br /><a href='".SITE_URL."resetpassword/email/".base64_encode($for_email)."/actCode/".$act_key1['randomNumber']."' target='_blank'>Reset password</a><br /> ";
			$artical.="<br /><br />Kind Regards,<br />Crowd Zeal Team</body></html>";
			$subject="Reset password At Crowd Zeal";
			$mailbody=$artical;
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html\r\n";
			$headers .= FROMEMAILADDRESS;
			@mail(base64_decode($for_email), $subject, $mailbody, $headers);
			
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"We have sent an Email on your email Address with instruction to Reset your Password");
			redirect(SITE_URL."login/");
        }
        else
        {
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"You have entered wrong Email Address");
			redirect(SITE_URL."login/");
	
        }        
    }
	//$_GET['project'] = str_replace("/","",sanitize_string($_GET['project']));
	if(!isset($_GET) || !isset($_GET['project']) || ($_GET['project']=='')) {
		//$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Sorry, the project you are looking for is removed");			
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"No project specified. Do you need to re-login?");			
		
		redirect($base_url."staff/");
	}
		
	$approved_check1=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".sanitize_string($_GET['project'])."'"));	
	
	if(is_array($approved_check1) && isset($approved_check1['published']) && ($approved_check1['published']==0) && ($approved_check1['accepted']==0) && ($approved_check1['userId'] == $_SESSION['userId'])){
		//echo 'con1';exit;
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Only you can see this project, until it is published.");
	}
	else if($approved_check1['published']==1 && $approved_check1['accepted']==0 && $approved_check1['comming_soon']==1 && $_SESSION["admin_user"]=="")

	{
		//	echo 'con2';exit;

		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Sorry, the project you are looking for will be available in future");			

		redirect($base_url."staffpicks/");

	}
	else if(($approved_check1['published']==0 || $approved_check1['accepted']==0 || $approved_check1['accepted']==3 || !is_numeric($_GET['project'])) && (!isset($_SESSION['admin_user']) || ($_SESSION["admin_user"]=="")))
	{
	//echo 'yes'.$_SESSION["admin_user"];exit;
	
		//$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Sorry, the project you are looking for is removed");			
		if (is_numeric($_GET['project'])) {
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"You must be logged in and Preview the project to see it.");			

		} else {
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"No project specified. Do you need to login and re-select the project?");			
		}	
	
		redirect($base_url."staffpicks/");
	}	
	
	//echo 'no'.$_SESSION["admin_user"];exit;
	
	
	//require_once("pagination.php");
	//require_once("comment_pagination.php");
	//require_once("update_pagination.php");
	function ago($time)
	{
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");

	   $now = time();
	   $difference     = $now - $time;
	   $tense         = "ago";

	   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		   $difference /= $lengths[$j];
	   }

	   $difference = round($difference);

	   if($difference != 1) {
		   $periods[$j].= "s";
	   }
	   return "$difference $periods[$j] ago ";
	}
    		
	if(isset($_GET['project']) && $_GET['project']!='')
	{		
		$last_week=time() - (7 * 24 * 60 * 60); //last week
		$currentTime = time();				
		$ipaddress=$_SERVER['REMOTE_ADDR'];	
		
		$sel_staff12=$con->recordselect("SELECT `hitId` , `projectId` , `hitTime`, `userIp`  FROM `projecthit` WHERE `hitTime` BETWEEN '$last_week' AND '$currentTime' AND userIp='$ipaddress' AND projectId='".$_GET['project']."'");
		$sel_row=mysql_num_rows($sel_staff12);
		if($sel_row==0)
		{
			$sel_staff123=$con->recordselect("SELECT `hitId` , `projectId` , `hitTime`, `userIp`  FROM `projecthit` WHERE `hitTime` NOT BETWEEN '$last_week' AND '$currentTime' AND userIp='$ipaddress' AND projectId='".$_GET['project']."'");
			$sel_update=mysql_fetch_assoc($sel_staff123);
			$ipaddress1=$_SERVER['REMOTE_ADDR'];			
			if($sel_update['userIp']==$ipaddress1 && $sel_update['projectId']==$_GET['project'])
			{
				$con->update("UPDATE projecthit SET hitTime='$currentTime' WHERE userIp='$ipaddress' AND projectId='".$_GET['project']."'");
			}
			else
			{
				$hitTime = time();
				$ipaddress2=$_SERVER['REMOTE_ADDR'];			
				$con->insert("INSERT INTO projecthit(`hitId`, `projectId`, `hitTime`, `userIp`) VALUES(NULL, '".$_GET['project']."', '$hitTime', '$ipaddress2')");
			}
		}
		$sel_pro_basic=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$_GET['project']."'"));
		$sel_pro_cate=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_pro_basic['projectCategory']."'"));
		$sel_pro=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$_GET['project']."'"));
		$sel_pro_user123=$con->recordselect("SELECT * FROM users WHERE userId='".$sel_pro['userId']."'");
		
		$sel_pro_user=mysql_fetch_assoc($sel_pro_user123);
		$website_res = $con->recordselect("SELECT * FROM userwebsites WHERE userId='".$sel_pro_user['userId']."'");
		
		/*if($sel_pro_user['userId'] == $_SESSION['userId']){
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Only you can see this project, until it is published.");
		}else*/
		
		if(mysql_num_rows($sel_pro_user123)<=0 )
		{
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Sorry, the project you are looking for is removed");			
			redirect($base_url."staffpicks/");		
		}
		$sel_backers=mysql_fetch_assoc($con->recordselect("SELECT `backingId` , `rewardId` , `projectId` , `userId` , `pledgeAmount` , `backingTime` , count( `projectId` ) AS total FROM `projectbacking` WHERE `projectId` ='".$_GET['project']."' GROUP BY `projectId`"));
		$sel_usercomment_count=mysql_fetch_assoc($con->recordselect("SELECT count( `projectId` ) AS tot FROM `projectcomments` WHERE `projectId` = '".$_GET['project']."' AND commentstatus ='1'"));
		if($sel_pro['userId'] == $_SESSION["userId"]){
			$sel_userreview_count=mysql_fetch_assoc($con->recordselect("SELECT count( `projectId` ) AS tot FROM `projectreview` WHERE `projectId` = '".$_GET['project']."'"));
		}
		else {
			$sel_userreview_count=mysql_fetch_assoc($con->recordselect("SELECT count( `projectId` ) AS tot FROM `projectreview` WHERE `projectId` = '".$_GET['project']."' AND reviewstatus=1 "));
		}
		
		$sel_pro_image1=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$_GET['project']."'");
		$sel_pro_image=mysql_fetch_assoc($sel_pro_image1);
		$sel_pro_video1=$con->recordselect("SELECT * FROM projectstory WHERE projectId='".$_GET['project']."'");
		$sel_pro_video=mysql_fetch_assoc($sel_pro_video1);
		$sel_onlybackers=$con->recordselect("SELECT * FROM projectbacking WHERE projectId='".$_GET['project']."' AND userId='".$_SESSION['userId']."'");
		$sel_projectcreater=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$_GET['project']."'"));
		$count_backers=mysql_num_rows($sel_onlybackers);
		$title = $sel_pro_basic['projectTitle'].' by '.$sel_pro_user['name'];
		$meta = array("description"=>"Browse Project","keywords"=>"Browse Project");
	}
	
	// Login Code Start
	if(isset($_POST["submitLogin"]))
    {
		extract($_POST);
		$obj = new validation();

		$obj->add_fields($emailid, 'req', 'Enter Email Address');
		$obj->add_fields($emailid, 'email', 'Enter valid Email Address');
		$obj->add_fields($passwd, 'req', ER_PSW);
		$error1 = $obj->validate();
		
		if($error1=='')
        {
             $password=base64_encode($passwd);
             $qry1=$con->recordselect("SELECT * FROM `users` WHERE `emailAddress`= '".base64_encode($emailid)."' AND `password` = '".$password."'");
             $tot_rec=mysql_num_rows($qry1);
             $valid_user=mysql_fetch_array($qry1);

             if($tot_rec>0)
		     {
              //update status
			  	if($valid_user['activated']==1)
	               {	
					  $con->update("UPDATE users SET status=1 WHERE emailAddress='".base64_encode($emailid)."' and password='$password'");
					  $qry=$con->recordselect("SELECT * FROM users WHERE emailAddress='".base64_encode($emailid)."' and password='$password'");
					  $ses_ver=mysql_fetch_array($qry);
					  $_SESSION["userId"]=$ses_ver['userId'];
					  $_SESSION["name"]=$ses_ver['name'];
					  $sel_pro_basic=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$_GET['project']."'"));
					  redirect(SITE_URL."browseproject/".$_GET['project'].'/'.Slug($sel_pro_basic['projectTitle']).'/');
	               }
             	else
				   {
			   			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Please check your email and activate your account');
		           }
             }
		     else
		     {
	   			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>ER_INVUP);
		     }
         }
	}
    //login Code End
	//comment code start
	if(isset($_POST['submitUserComment']) && isset($_GET['project']) && $_GET['project']!='')
	{
		
		extract($_POST);
		$comment_time=time();
		$con->insert("INSERT INTO `projectcomments` (`commentId` ,`userId` ,`projectId` ,`comment` ,`commentTime`)
				VALUES (NULL , '".$_SESSION['userId']."', '".$_GET['project']."', '".sanitize_string($user_comment)."', '$comment_time')");
		$sel_pro=mysql_fetch_assoc($con->recordselect("SELECT userId FROM projects WHERE projectId='".$_GET['project']."'"));
		$sel_pro_user123=$con->recordselect("SELECT * FROM users WHERE userId='".$sel_pro['userId']."'");
		
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Comment succesfully added.');

		$sel_pro_user=mysql_fetch_assoc($sel_pro_user123);
		if($_SESSION['userId']!=$sel_pro['userId'] && $sel_pro_user['createdProjectComment']=='1')
		{
		//echo 'hi'.base64_decode($sel_pro_user['emailAddress']);exit;	
			$artical1="";
			$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical1.="<body><strong>Hello ".$sel_pro_user['name'].", </strong><br />";
			$artical1.="<br />";			
			$artical1.= $_SESSION['name']." commented on <b>".unsanitize_string($sel_pro_basic['projectTitle'])."</b><br />"; 
			$artical1.="<br />";
			$artical1.= "<b>Comment:</b>\"".$user_comment."\"<br />";
			$artical1.= "Please visit commented project by clicking on following link.<br />
			<a href='".$base_url."browseproject/".$_GET['project']."/".Slug($sel_pro_basic['projectTitle'])."/#d' target='_blank'>Click Here</a><br />";
			$artical1.="<br />";
			$artical1.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
			$subject1="Comment on ".unsanitize_string($sel_pro_basic['projectTitle']);
			$mailbody1=$artical1;
			$headers1 = "MIME-Version: 1.0\r\n";
			$headers1 .= "Content-type: text/html\r\n";
			$headers1 .= FROMEMAILADDRESS;
			@mail(base64_decode($sel_pro_user['emailAddress']), $subject1, $mailbody1, $headers1);
		}
		redirect(SITE_URL."browseproject/".$_GET['project'].'/'.Slug($sel_pro_basic['projectTitle']).'/');
	}
	//comment code over
	
	//review code start
	if(isset($_POST['submitUserReview']) && isset($_GET['project']) && $_GET['project']!='')
	{
		
		extract($_POST);
		$review_time=time();
		$con->insert("INSERT INTO `projectreview` (`reviewId` ,`userId` ,`projectId` ,`review` ,`created_date`)
				VALUES (NULL , '".$_SESSION['userId']."', '".$_GET['project']."', '".sanitize_string($user_review)."','".$review_time."')");
		$sel_pro=mysql_fetch_assoc($con->recordselect("SELECT userId FROM projects WHERE projectId='".$_GET['project']."'"));
		$sel_pro_user123=$con->recordselect("SELECT * FROM users WHERE userId='".$sel_pro['userId']."'");
		
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Review added successfully. After approval by admin or creator it will be displayed');

		$sel_pro_user=mysql_fetch_assoc($sel_pro_user123);
		//if($_SESSION['userId']!=$sel_pro['userId'] && $sel_pro_user['createdProjectComment']=='1')
		//{
		//echo 'hi'.base64_decode($sel_pro_user['emailAddress']);exit;	
			//sending mail to creator..
			//echo base64_decode($sel_pro_user['emailAddress']);exit;
			$artical1="";
			$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical1.="<body><strong>Hello ".$sel_pro_user['name'].", </strong><br />";
			$artical1.="<br />";			
			$artical1.= $_SESSION['name']." posted review on <b>".unsanitize_string($sel_pro_basic['projectTitle'])."</b><br />"; 
			$artical1.="<br />";
			$artical1.= "<b>Review:</b>\"".$user_review."\"<br />";
			$artical1.= "Please accept review by visiting following link.<br />
			<a href='".$base_url."browseproject/".$_GET['project']."/".Slug($sel_pro_basic['projectTitle'])."/#e' target='_blank'>Click Here</a><br />";
			$artical1.="<br />";
			$artical1.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
			$subject1="Review on ".unsanitize_string($sel_pro_basic['projectTitle']);
			$mailbody1=$artical1;
			$headers1 = "MIME-Version: 1.0\r\n";
			$headers1 .= "Content-type: text/html\r\n";
			$headers1 .= FROMEMAILADDRESS;
			@mail(base64_decode($sel_pro_user['emailAddress']), $subject1, $mailbody1, $headers1);
			
			//sending mail to admin..
			$artical1="";
			$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical1.="<body><strong>Hello Admin, </strong><br />";
			$artical1.="<br />";			
			$artical1.= $_SESSION['name']." posted review on <b>".unsanitize_string($sel_pro_basic['projectTitle'])."</b><br />"; 
			$artical1.="<br />";
			$artical1.= "<b>Review:</b>\"".$user_review."\"<br />";
			$artical1.= "Please accept review by visiting following link.<br />
			<a href='".SITE_ADM."project_review.php/'>Click Here</a><br />";
			$artical1.="<br />";
			$artical1.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
			$subject1="Review on ".unsanitize_string($sel_pro_basic['projectTitle']);
			$mailbody1=$artical1;
			$headers1 = "MIME-Version: 1.0\r\n";
			$headers1 .= "Content-type: text/html\r\n";
			$headers1 .= FROMEMAILADDRESS;
			@mail(FROMEMAILADDRESS, $subject1, $mailbody1, $headers1);
			@mail('admin@crowdedrocket.com', 'cc: '.$subject1, $mailbody1, $headers1);
		//}
		redirect(SITE_URL."browseproject/".$_GET['project'].'/'.Slug($sel_pro_basic['projectTitle']).'/');
	}
	//review code over

		
	//project update comment code start
	if(isset($_POST['submitProjectUpdateComment']) && isset($_GET['project']) && $_GET['project']!='')
	{
		extract($_POST);
		$updatecomment_time=time();
		$con->insert("INSERT INTO `projectupdatecomment` (`updatecommentId`, `userId`, `projectId`, `updatenumber`, `updateComment`, `updateCommentTime`) 
		VALUES(NULL, '".$_SESSION['userId']."', '".$_GET['project']."', '$updatenumber', '".sanitize_string($projectupdate_comment)."', '$updatecomment_time')");
		$sel_pro=mysql_fetch_assoc($con->recordselect("SELECT userId FROM projects WHERE projectId='".$_GET['project']."'"));
		$sel_pro_user123=$con->recordselect("SELECT * FROM users WHERE userId='".$sel_pro['userId']."'");
		
		$sel_pro_user=mysql_fetch_assoc($sel_pro_user123);
		if($_SESSION['userId']!=$sel_pro['userId'] && $sel_pro_user['createdProjectComment']=='1')
		{
			
			
			$artical1="";
			$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical1.="<body><strong>Hello ".ucfirst($sel_pro_user['name']).", </strong><br />";
			$artical1.="<br />";			
			$artical1.= ucfirst($_SESSION['name'])." commented on <b>".unsanitize_string($sel_pro_basic['projectTitle'])."</b><br />"; 
			$artical1.="<br />";
			$artical1.= "<b>Comment:</b>\"".$projectupdate_comment."\"<br />";
			$artical1.="<br />";
			$artical1.= "Please visit commented project by clicking on following link.<br />
			<a href='".$base_url."browseproject/".$_GET['project']."/".Slug($sel_pro_basic['projectTitle'])."/#b' target='_blank'>Click Here</a><br />";
			$artical1.="<br />";
			$artical1.="<br /><br />Kind Regards,<br />HyperFunder Team</body></html>";
			$subject1="Comment on ".unsanitize_string($sel_pro_basic['projectTitle']);
			$mailbody1=$artical1;
			$headers1 = "MIME-Version: 1.0\r\n";
			$headers1 .= "Content-type: text/html\r\n";
			$headers1 .= FROMEMAILADDRESS;
			//echo base64_decode($sel_pro_user['emailAddress']);exit;
			@mail(base64_decode($sel_pro_user['emailAddress']), $subject1, $mailbody1, $headers1);
		}
		/*redirect(SITE_URL."modules/browse/browseproject.php?project=".$_GET['project']."#tabs-2");*/
		
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Comment succesfully added.');
		
		redirect(SITE_URL."browseproject/".$_GET['project'].'/'.Slug($sel_pro_basic['projectTitle']).'/');
	}
	//project update comment code over
	
	//project update comment code  for single update  start
	if(isset($_POST['submitProjectUpdateComment1']) && isset($_GET['project']) && $_GET['project']!='')
	{
		extract($_POST);
		$updatecomment_time1=time();
		$con->insert("INSERT INTO `projectupdatecomment` (`updatecommentId`, `userId`, `projectId`, `updatenumber`, `updateComment`, `updateCommentTime`) 
		VALUES(NULL, '".$_SESSION['userId']."', '".$_GET['project']."', '$updatenumber1', '".sanitize_string($projectupdate_comment1)."', '$updatecomment_time1')");
		$sel_pro=mysql_fetch_assoc($con->recordselect("SELECT userId FROM projects WHERE projectId='".$_GET['project']."'"));
		$sel_pro_user123=$con->recordselect("SELECT * FROM users WHERE userId='".$sel_pro['userId']."'");
		
		$sel_pro_user=mysql_fetch_assoc($sel_pro_user123);
		if($_SESSION['userId']!=$sel_pro['userId'] && $sel_pro_user['createdProjectComment']=='1')
		{
			
			
			$artical1="";
			$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical1.="<body><strong>Hello ".ucfirst($sel_pro_user['name']).", </strong><br />";
			$artical1.="<br />";			
			$artical1.= ucfirst($_SESSION['name'])." commented on <b>".unsanitize_string($sel_pro_basic['projectTitle'])."</b><br />"; 
			$artical1.="<br />";
			$artical1.= "<b>Comment:</b>\"".$projectupdate_comment."\"<br />";
			$artical1.="<br />";
			$artical1.= "Please visit commented project by clicking on following link.<br />
			<a href='".$base_url."browseproject/".$_GET['project']."/".Slug($sel_pro_basic['projectTitle'])."/#b' target='_blank'>Click Here</a><br />";
			$artical1.="<br />";
			$artical1.="<br /><br />Kind Regards,<br />HyperFunder Team</body></html>";
			$subject1="Comment on ".unsanitize_string($sel_pro_basic['projectTitle']);
			$mailbody1=$artical1;
			$headers1 = "MIME-Version: 1.0\r\n";
			$headers1 .= "Content-type: text/html\r\n";
			$headers1 .= FROMEMAILADDRESS;
			//echo base64_decode($sel_pro_user['emailAddress']);exit;
			@mail(base64_decode($sel_pro_user['emailAddress']), $subject1, $mailbody1, $headers1);
		}
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Comment succesfully added.');
		
		redirect(SITE_URL."browseproject/".$_GET['project'].'/'.Slug($sel_pro_basic['projectTitle']).'/');
	}
	//project update comment code  for single update  over
		
	// message code start	
	if(isset($_POST["user_message"])) // jwg -- prev tested for "submitMessage", but it was not present as expected !?
    {
		extract($_POST);
		$message_time=time();
		$con->insert("INSERT INTO usermessages (`messageId` ,`message` ,`projectId` ,`receiverId` ,`senderId` ,`messageTime`)
		VALUES (NULL , '".sanitize_string($user_message)."', '".$_GET['project']."', '".$sel_pro['userId']."', '".$_SESSION['userId']."', '$message_time')");
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Message succesfully sent.');
	}
	// message code end
	
	if ( isset($_GET['project']) && $_GET['project'] != NULL ) {
		$project_id 			= mysql_real_escape_string($_GET['project']);
		$fill_form_projecttitle	= mysql_fetch_array($con->recordselect("SELECT * FROM projectbasics WHERE projectId ='".$project_id."' "));
	}
	
	if ( isset($_GET['reviewId']) && $_GET['reviewId'] != NULL ) {
		//echo $_GET['status'];
		if($_GET['status'] == 'off') {
			//echo 'hiii';exit;
		$con->update("UPDATE projectreview SET reviewstatus=0 WHERE `reviewId`= '".$_GET['reviewId']."'");
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Review succesfully deactivated.');
	
		}
		else if($_GET['status'] =='on') {
			//echo 'hi';exit;
			$con->update("UPDATE projectreview SET reviewstatus=1 WHERE `reviewId`= '".$_GET['reviewId']."'");
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Review succesfully activated.');
	
		}
		redirect(SITE_URL."browseproject/".$_GET['project'].'/'.Slug($sel_pro_basic['projectTitle']).'/');
		
	}
	

	$ses_user 		= isset($_SESSION['userId']) ? $_SESSION['userId'] : NULL;
	$get_project 	= isset($_GET['project']) ? $_GET['project'] : NULL;
	$get_updates 	= isset($_GET['update']) ? $_GET['update'] : NULL;

	$module='browse';
	$page='browseproject';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>
