<?php
	require_once("../../includes/config.php");
	if(isset($_SESSION['userId']) && isset($_GET['projectId']) && $_SESSION['userId']!='' && $_GET['userId']!='' && $_GET['projectId']!='')	
	{		
		$projectId=$_GET['projectId'];
		$userId=$_SESSION['userId'];
		$cur_time=time();
		$sel_alreary_remind_user=$con->recordselect("SELECT * FROM `projectremind` WHERE projectId='$projectId' AND userId='$userId' AND (status=0 OR status=1)");		
		$numofrows_remind=mysql_num_rows($sel_alreary_remind_user);
		$sel_alreary_remind_user_status=mysql_fetch_assoc($sel_alreary_remind_user);
		$sel_ProjTitle=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$projectId."'"));
		if($numofrows_remind<=0) // new user remind
		{
			$con->insert("INSERT INTO projectremind (`projectremindId`,`projectId`, `userId`, `status`, remindTime) VALUES (NULL, '$projectId', '$userId', 1, '$cur_time')");		
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Project added to starred list");
			
			$sel_login_user_email1=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$_SESSION['userId']."'"));
			
			if($sel_login_user_email1['lanuchProjectNotify']==1)
			{
			$artical1="";
			$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical1.="<body><strong>Hello ".$_SESSION['name'].", </strong><br />";
			$artical1.="<br />Thank you for Following project.<br /><br />";			
			$artical1.="Please visit to Follow project by clicking on following link.<br />
			<a href='".$base_url."browseproject/".$projectId."/".Slug($sel_ProjTitle['projectTitle']).'/'."' target='_blank'>Click Here</a><br />";
			$artical1.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
			$subject1="Follow project At ".DISPLAYSITENAME."";
			$mailbody1=$artical1;
			$headers1 = "MIME-Version: 1.0\r\n";
			$headers1 .= "Content-type: text/html\r\n";
			$headers1 .= FROMEMAILADDRESS;
			@mail(base64_decode($sel_login_user_email1['emailAddress']), $subject1, $mailbody1, $headers1);
			}
			
			$sel_project_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='$projectId'"));
			$sel_login_user_email=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_project_user['userId']."'"));
			if($sel_login_user_email['newFollower']==1)
			{
				$artical="";
				$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
				$artical.="<body><strong>Hello ".$sel_login_user_email['name'].", </strong><br />";
				$artical.="<br />".$_SESSION['name']." has Followed your project ".$sel_ProjTitle['projectTitle'].".<br /><br />";			
				$artical.="Please visit to Follow project by clicking on following link.<br />
				<a href='".$base_url."browseproject/".$projectId."/".Slug($sel_ProjTitle['projectTitle']).'/'."' target='_blank'>Click Here</a><br />";
				$artical.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
				$subject=$_SESSION['name']."  follow project at ".DISPLAYSITENAME.".";
				$mailbody=$artical;
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html\r\n";
				$headers .= FROMEMAILADDRESS;
				@mail(base64_decode($sel_login_user_email['emailAddress']), $subject, $mailbody, $headers);
			}
			redirect($base_url."browseproject/".$projectId.'/'.Slug($sel_ProjTitle['projectTitle']).'/');			
		}
		else
		{
			if($sel_alreary_remind_user_status['status']==0) // if status=0
			{
				$con->update("UPDATE projectremind SET status=1, remindTime='$cur_time' WHERE projectId='$projectId' AND userId='$userId'");
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Project added to starred list");
				
				$sel_login_user_email1=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$_SESSION['userId']."'"));
				if($sel_login_user_email1['lanuchProjectNotify']==1)
				{
					$artical1="";
					$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
					$artical1.="<body><strong>Hello ".$_SESSION['name'].", </strong><br />";
					$artical1.="<br />Thank you for Following project.<br /><br />";			
					$artical1.="Please visit to Follow project by clicking on following link.<br />
					<a href='".$base_url."browseproject/".$projectId."/".Slug($sel_ProjTitle['projectTitle']).'/'."' target='_blank'>Click Here</a><br />";
					$artical1.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
					$subject1="Follow project At ".DISPLAYSITENAME."";
					$mailbody1=$artical1;
					$headers1 = "MIME-Version: 1.0\r\n";
					$headers1 .= "Content-type: text/html\r\n";
					$headers1 .= FROMEMAILADDRESS;
					@mail(base64_decode($sel_login_user_email1['emailAddress']), $subject1, $mailbody1, $headers1);
				}
				$sel_project_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='$projectId'"));
				$sel_login_user_email=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_project_user['userId']."'"));
				if($sel_login_user_email['newFollower']==1)
				{
					$artical="";
					$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
					$artical.="<body><strong>Hello ".$sel_login_user_email['name'].", </strong><br />";
					$artical.="<br />".$_SESSION['name']." has Followed your project ".$sel_ProjTitle['projectTitle'].".<br /><br />";			
					$artical.="Please visit to Follow project by clicking on following link.<br />
					<a href='".$base_url."browseproject/".$projectId."/".Slug($sel_ProjTitle['projectTitle']).'/'."' target='_blank'>Click Here</a><br />";
					$artical.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
					$subject=$_SESSION['name']."  follow project at ".DISPLAYSITENAME."";
					$mailbody=$artical;
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html\r\n";
					$headers .= FROMEMAILADDRESS;
					@mail(base64_decode($sel_login_user_email['emailAddress']), $subject, $mailbody, $headers);
				}
				redirect($base_url."browseproject/".$projectId."/".Slug($sel_ProjTitle['projectTitle']).'/');
			}
			else //if status=1
			{
				$con->update("UPDATE projectremind SET status=0, remindTime='$cur_time' WHERE projectId='$projectId' AND userId='$userId'");
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Project removed from starred list");
				
				$sel_login_user_email1=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$_SESSION['userId']."'"));
				if($sel_login_user_email1['lanuchProjectNotify']==1)
				{
					$artical1="";
					$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
					$artical1.="<body><strong>Hello ".$_SESSION['name'].", </strong><br />";
					$artical1.="<br />You have Unfollowed project.<br /><br />";			
					$artical1.="Please visit to Unfollow project by clicking on following link.<br />
					<a href='".$base_url."browseproject/".$projectId."/".Slug($sel_ProjTitle['projectTitle']).'/'."' target='_blank'>Click Here</a><br />";
					$artical1.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
					$subject1="Unfollow project At ".DISPLAYSITENAME."";
					$mailbody1=$artical1;
					$headers1 = "MIME-Version: 1.0\r\n";
					$headers1 .= "Content-type: text/html\r\n";
					$headers1 .= FROMEMAILADDRESS;
					@mail(base64_decode($sel_login_user_email1['emailAddress']), $subject1, $mailbody1, $headers1);
				}
				$sel_project_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='$projectId'"));
				$sel_login_user_email=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_project_user['userId']."'"));
				if($sel_login_user_email['newFollower']==1)
				{
					$artical="";
					$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
					$artical.="<body><strong>Hello ".$sel_login_user_email['name'].", </strong><br />";
					$artical.="<br />".$_SESSION['name']." has Unfollowed your project ".$sel_ProjTitle['projectTitle'].".<br /><br />";			
					$artical.="Please visit to Unfollow project by clicking on following link.<br />
					<a href='".$base_url."browseproject/".$projectId."/".Slug($sel_ProjTitle['projectTitle']).'/'."' target='_blank'>Click Here</a><br />";
					$artical.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
					$subject=$_SESSION['name']."  Unfollow project At ".DISPLAYSITENAME."";
					$mailbody=$artical;
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html\r\n";
					$headers .= FROMEMAILADDRESS;
					@mail(base64_decode($sel_login_user_email['emailAddress']), $subject, $mailbody, $headers);
				}
				redirect($base_url."browseproject/".$projectId."/".Slug($sel_ProjTitle['projectTitle']).'/');
			}
		}
	}
	else
	{
		redirect($base_url."browseproject/".$projectId);
	}	
?>