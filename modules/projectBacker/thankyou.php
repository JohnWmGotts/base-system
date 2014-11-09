<?php require_once "../../includes/config.php";
	
	if(isset($_GET['projectId']) && is_numeric($_GET['projectId']))
	{	// new code by jwg to conclude updates after good preapproval
		$projectId = $_GET['projectId'];
		if (!isset($_GET['trackingId'])) {
			wrtlog("WARNING!! No trackingId in call to thankyou.php for project $projectId");
		} else {
			wrtlog("DEBUG projectBacker/thankyou.php called with :".print_r($_GET,true));
			
			// update payment_status from ? (initial) to p (preapproved)
			$con->update("UPDATE projectbacking SET `payment_status` = 'p' WHERE `projectId` = '$projectId' AND `tracking_id` = '{$_GET['trackingId']}' ");
		
			$sel_backing=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbacking` WHERE `projectId` = '$projectId' AND `tracking_id` = '{$_GET['trackingId']}' LIMIT 1"));
			$backerId = $sel_backing['userId'];
			$sel_backers = $con->recordselect("SELECT * FROM `projectbacking` WHERE `projectId` = '$projectId' AND `userId` = '$backerId'");
			$new_backer = (mysql_num_rows($sel_backers) <= 1) ? 1 : 0; 
			
			// increase the accumulation of backing-to-date
			$sel_basics=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbasics` WHERE `projectId` = '$projectId'"));		
			$contributors = $sel_basics['rewardedContributer'] + $new_backer;
			$amount=$sel_basics['rewardedAmount'] + $sel_backing['pledgeAmount'];		
			$con->update("UPDATE projectbasics SET rewardedAmount='".$amount."', rewardedContributer='".$contributors."' WHERE `projectId` = '$projectId' LIMIT 1");

			$projectBacker = mysql_fetch_array($con->recordselect("SELECT name FROM users where userId='$backerId' LIMIT 1"));
			$backer_name=$projectBacker['name'];
			$projectCreater = mysql_fetch_array($con->recordselect("SELECT * FROM projects as pro, users as usr, projectbasics as pb where pro.projectId=".$projectId." and pro.userId=usr.userId AND pb.projectId =".$projectId));
			if($projectCreater['pledgeMail']==1)
			{
				$artical1="";
				$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
				$artical1.="<body><strong>Hello ".$projectCreater['name'].", </strong><br />";
				$artical1.="<br />";			
				$artical1.= $backer_name." has committed {$sel_backing['pledgeAmount']} USD to your project <b>".unsanitize_string(ucfirst($projectCreater['projectTitle']))."</b><br />";

				$artical1.= "You can visit your project page at 
				<a href='".SITE_URL."browseproject/".$projectId."/".Slug($projectCreater['projectTitle']).'/'."' target='_blank'>Click Here</a><br />";
				$artical1.="<br /><br />Regards,<br />".DISPLAYSITENAME." Team</body></html>";
				$subject1="New backing for ".unsanitize_string(ucfirst($projectCreater['projectTitle']));
				$mailbody1=$artical1;
				$headers1 = "MIME-Version: 1.0\r\n";
				$headers1 .= "Content-type: text/html\r\n";
				$headers1 .= FROMEMAILADDRESS;
				@mail(base64_decode($projectCreater['emailAddress']), $subject1, $mailbody1, $headers1);
				@mail('admin@'.$_SERVER['SERVER_NAME'], 'cc: '.$subject1, $mailbody1, $headers1);
			}		
		}
		$selectProject = mysql_fetch_assoc($con->recordselect("SELECT projectTitle from projectbasics where projectId = ".$projectId));
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Thank you for backing the project.");		
		wrtlog("thankyou.php redirecting to browseproject after successful preapproval for ".Slug($selectProject['projectTitle']));
		redirect($base_url."browseproject/".$projectId."/".Slug($selectProject['projectTitle']).'/');		
	}
	wrtlog("WARNING thankyou.php called without expected projectId");
	redirect($base_url.'index.php');
		
?>