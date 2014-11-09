<?php
require "../../includes/config.php";
if($_SESSION['userId']=='')
{
	$_SESSION['msg'] = "Please login to start new project.";
	$_SESSION['RedirectUrl'] = get_url();
	header("location:".$login_url);
	exit;
}	
	$uid =$_SESSION['userId'];
	$projectId = $_SESSION['projectId'];
	$projPublished = $con->recordselect("SELECT published FROM projects where projectId= ".$projectId);
	if(mysql_num_rows($projPublished)>0)
	{
		$projectStatus = mysql_fetch_assoc($projPublished);
		if($projectStatus['published']==0)
		{
			if($_POST['current']=='2')
		{
			$projectTitle = sanitize_string($_POST['projectTitle']);
			$projectCategory = sanitize_string($_POST['projectCategory']);
			$projectBlurb = sanitize_string($_POST['shortBlurb']);
			$projectLocation = sanitize_string($_POST['projectLocation']);
			$projectDurationOption = $_POST['duration'];
			$projectFunding = sanitize_string($_POST['fundingGoal']);
			if(isset($_POST['duration']) && $projectDurationOption=='0')
			{		
				$startDate = time();
				$endDate = strtotime($_POST['Selecteddays']);
				
			}
			elseif($projectDurationOption=='1')
			{		
				$days = (int)$_POST['days'];
				$days = $days*24*3600;
				$startDate = time();
				$endDate = $startDate + $days;
				
			}
			else
			{		
				$days = 30*24*3600;
				$projectDurationOption=0;
				$startDate = time();
				$endDate = $startDate + $days;	
			}
			$selectProject = $con->recordselect("SELECT projectTitle from projectbasics where projectId = ".$projectId);
			if(mysql_num_rows($selectProject)>0)
			{							
				$updateBasic = $con->update("UPDATE projectbasics set projectTitle = '".$projectTitle."',projectCategory = ".$projectCategory.",shortBlurb ='".$projectBlurb."',projectLocation = '".$projectLocation."',projectStart = ".$startDate.",projectEnd = ".$endDate." ,durationType = '".$projectDurationOption."' ,fundingGoal =".$projectFunding."  where projectId =".$projectId);
			}
			else
			{
				//insert the things
				/*start the project*/
				$insertQuery = "INSERT INTO projects(`userId`,`acceptTerms`) VALUES(".$uid.",1)";
				$con->insert($insertQuery);
				$projectId = mysql_insert_id();
				$_SESSION['projectId'] = $projectId;
				$insertQuery = "INSERT INTO projectbasics 
				(projectTitle,projectCategory,shortBlurb,projectLocation,projectStart,projectEnd,fundingGoal,projectId) VALUES ('', '', '', '', '','', '',$projectId)";
				$con->insert($insertQuery);
				$insertQuery = "INSERT INTO projectstory(projectVideo,projectDescription,projectId)
				VALUES('','',$projectId)";
				$con->insert($insertQuery);
				$artical="";
				$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
				$artical.="<body><strong>Hello there! </strong><br />";
				$artical.="<br />We noticed you started a project on NCrypted Crowdfunding_Clone — awesome. Whether you've been planning your project for months or you're just toying with the idea, here are some first steps to get you going:<br /><br />";
				$artical.="<br /><strong>1. Check out other projects</strong>";
				$artical.="<br />The easiest way to get inspiration for your own project is to look at others. Explore successful projects in your category, figure out what works and what doesn't, and take notes! <br /><br />";
				$artical.="<br /><strong>2. Become a backer </strong>";
				$artical.="<br />If you haven't done it already, find a project you like, and back it! Backing a project gives you a feel for the experience of supporting someone’s work and going along for the ride. It's also a nice way to participate in the NCrypted Crowdfunding_Clone community.  <br /><br />";
				$artical.="<br /><strong>3. Visit NCrypted Crowdfunding_Clone School</strong>";
				$artical.="<br />We've compiled a series of tips and best practices for every step of your project's progress. At this stage in the game, our advice on Defining Your Project, Making Your Video, and Creating Rewards will probably be the most useful.<br /><br />";
				$artical.="<br /><strong>4. Show your friends</strong>";
				$artical.="<br />If you get stuck or just want a second opinion, having a friend look at what you've got can be really helpful and reassuring. Just click “Get preview link” at the top of your project preview and share the link to your project. <br /><br />";
				$artical.="<br />Keep in mind that every project is the story of someone pursuing something meaningful to them. You just need to tell yours!<br /><br />";
				$artical.="<br /><br />Best of luck with it!<br />NCrypted Crowdfunding_Clone Team</body></html>";
				$subject="You’ve started a project on NCrypted Crowdfunding_Clone!";
				$mailbody=$artical;
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html\r\n";
				$headers .= "From: NCrypted Crowdfunding_Clone [no-reply@NCrypted Crowdfunding_Clone.com]";
				@mail($txtEmail, $subject, $mailbody, $headers);
			}
		}
		elseif($_POST['current']=='3')// save the rewards
		{		
			$rewardQr = $con->delete("delete from projectrewards where projectId=".$projectId);
			$pledgeAmount = $_POST['rewardAmount'];
			$limitAvail = $_POST['avail'] ;
			$rewardDescription = $_POST['rewardDescription'];
			$rewardMonth = $_POST['rewardMonth'];
			$rewardYear = $_POST['rewardYear'];
			$numReward = $_POST['countRewards'];
			if($numReward==0)
			{
				$numReward=1;
			}
			$limitCheck = $_POST['availLimit'];
			print_r($limitCheck);
			for($i=0;$i<$numReward;$i++)
			{				
				if($limitCheck[$i]==true)
				{
					//echo "in if";
					if($limitAvail[$i]=='')
					{
						$limitAvailValue = 0;
					}
					else
					{
						$limitAvailValue = $limitAvail[$i];
					}
				}
				elseif($limitAvail[$i]=='')
				{
					$limitAvailValue = 0;
				}
				else
				{					
					$limitAvailValue = 0;
				}		
				$inserReward = $con->insert("INSERT INTO projectrewards(`pledgeAmount`,`limitAvailable`,`description`,`estimateDeliveryMonth`, `estimateDeliveryYear`,`projectId`) VALUES(".$pledgeAmount[$i].",".$limitAvailValue.",'".$rewardDescription[$i]."', ".$rewardMonth[$i].",".$rewardYear[$i].",$projectId)");
			}
		}
		elseif($_POST['current']=='4')// save story
		{			
			$projectStory = sanitize_string($_POST['projectStory1']);
			$updateStory = $con->update("UPDATE projectstory set `projectDescription` = '".$projectStory."' where projectId=$projectId limit 1");
		}
		elseif($_POST['current']=='5')// about you tab saves the user details
		{
			$userBiography = $_POST['biography'];
			$userLocation = $_POST['userLocation'];
			$updateStory = $con->update("UPDATE users set `biography` = '".$userBiography."', `userLocation` = '".$userLocation."' where userId=$uid limit 1");
		}
		elseif($_POST['current']=='6')// Account tab saves here.
		{		
			$paypalUserAccount = isset($_POST['paypalUserAccount']) ? $_POST['paypalUserAccount'] : '';
			$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';
			if($paypalUserAccount!='')
			{
				$updateStory = $con->update("UPDATE users set `paypalUserAccount` = '".base64_encode($paypalUserAccount)."' where userId=$uid limit 1");	
			}
			if ($phoneNumber != '') {
				$updateStory = $con->update("UPDATE users set `phoneNumber` = '".$phoneNumber."' where userId=$uid limit 1");	
			}
			
		}	
		else
		{
			//no steps are selected.
		}
		}
	}
?>
