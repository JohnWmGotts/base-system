<?php
require "../../includes/config.php";
if($_SESSION['userId']=='') {
	$_SESSION['msg'] = "Please login to start new project.";
	$_SESSION['RedirectUrl'] = get_url();
	header("location:".$login_url);
	exit;
}	
	$uid =$_SESSION['userId'];
	$projectId = $_SESSION['projectId'];
	$projId = $_SESSION['projectId'];
	//$projPublished = $con->recordselect("SELECT published FROM projects where projectId= ".$projectId);
	//if(mysql_num_rows($projPublished)>0) {
	//	$projectStatus = mysql_fetch_assoc($projPublished);
	$proj = $con->recordselect("SELECT * FROM projects where projectId= ".$projectId);
	if(mysql_num_rows($proj)>0) {
		$projectStatus = mysql_fetch_assoc($proj);
		if($projectStatus['published']==0) {
			if (isset($_POST['request']) && ($_POST['request'] == 'delete')) {
				if ($projectStatus['userId'] != $uid) {
					$error = 'You may only delete your own projects';
					wrtlog("Attempt by userId $uid to delete other user project $projId");
				} else {
					wrtlog("userId $uid requesting to delete project $projId");
					require_once('project_del.php');
				}
			} else if($_POST['current']=='2') {
				
				//echo $_POST['current'];			
				$projectTitle = sanitize_string($_POST['projectTitle']);
				$projectCategory = sanitize_string($_POST['projectCategory']);
				$projectBlurb = sanitize_string($_POST['shortBlurb']);
				$projectLocation = sanitize_string($_POST['projectLocation']);

				$selectProject = $con->recordselect("SELECT projectTitle from projectbasics where projectId = ".$projectId);
				if(mysql_num_rows($selectProject)>0) {
					$projectTitle = (isset($projectTitle) ? $projectTitle : "" );
					$projectCategory = (isset($projectCategory) ? $projectCategory : 0 );
					$projectBlurb = (isset($projectBlurb) ? $projectBlurb : "" );
					$projectLocation = (isset($projectLocation) ? $projectLocation : "" );

					$updateBasic = $con->update("UPDATE projectbasics SET `projectTitle` = '".$projectTitle."', 
						`projectCategory` = ".$projectCategory.", `shortBlurb` = '".$projectBlurb."', 
						`projectLocation` = '".$projectLocation."' WHERE `projectId` = ".$projectId);
				
				} else {
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
					$artical.="<br />We noticed you started a project on ".DISPLAYSITENAME." — awesome. Whether you've been planning your project for months or you're just toying with the idea, here are some first steps to get you going:<br /><br />";
					$artical.="<br /><strong>1. Check out other projects</strong>";
					$artical.="<br />The easiest way to get inspiration for your own project is to look at others. Explore successful projects in your category, figure out what works and what doesn't, and take notes! <br /><br />";
					$artical.="<br /><strong>2. Become a backer </strong>";
					$artical.="<br />If you haven't done it already, find a project you like, and back it! Backing a project gives you a feel for the experience of supporting someone’s work and going along for the ride. It's also a nice way to participate in the ".DISPLAYSITENAME." community.  <br /><br />";
					$artical.="<br /><strong>3. Visit ".DISPLAYSITENAME." School</strong>";
					$artical.="<br />We've compiled a series of tips and best practices for every step of your project's progress. At this stage in the game, our advice on Defining Your Project, Making Your Video, and Creating Rewards will probably be the most useful.<br /><br />";
					$artical.="<br /><strong>4. Show your friends</strong>";
					$artical.="<br />If you get stuck or just want a second opinion, having a friend look at what you've got can be really helpful and reassuring. Just click “Get preview link” at the top of your project preview and share the link to your project. <br /><br />";
					$artical.="<br />Keep in mind that every project is the story of someone pursuing something meaningful to them. You just need to tell yours!<br /><br />";
					$artical.="<br /><br />Best of luck with it!<br />".DISPLAYSITENAME." Team</body></html>";
					$subject="You’ve started a project on ".DISPLAYSITENAME."!";
					$mailbody=$artical;
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html\r\n";
					$headers .= FROMEMAILADDRESS;
					//@mail($txtEmail, $subject, $mailbody, $headers);
				}
			} elseif($_POST['current']=='3') { // save funding goals

				$projectDurationOption = $_POST['duration'];

				$projectFunding = (isset($_POST['fundingGoal'])) ? remove_currency(sanitize_string($_POST['fundingGoal'])) : 0; // jwg
				$projectFunding = str_replace(',', '', $projectFunding);
						
				if(isset($_POST['duration']) && $projectDurationOption=='0') {		
					$startDate = time();
					$endDate = strtotime($_POST['Selecteddays']);
				} elseif($projectDurationOption=='1') {		
					$days = (int)$_POST['days'];
					$days = $days*24*3600;
					$startDate = time();
					$endDate = $startDate + $days;
				} else {		
					$days = 30*24*3600;
					$projectDurationOption=0;
					$startDate = time();
					$endDate = $startDate + $days;	
				}			
					
				$projectDurationOption = (isset($projectDurationOption) ? $projectDurationOption : 0 );

				$commision = get_commission($projectId,$projectFunding,'0','p');
				if($commision==""){
				$sel_re_projectcommission=mysql_fetch_array($con->recordselect("SELECT * FROM smallprojectamount"));
						$admincommission=$sel_re_projectcommission['std_cat_commission'];			 
				}
				else {
					$admincommission=$commision;
				}	
				$updateBasic = $con->update("UPDATE projectbasics SET `projectStart` = ".$startDate.", 
						`projectEnd` = ".$endDate." , `durationType` = '".$projectDurationOption."' , 
						`fundingGoal` ='".$projectFunding."', `admincommission` = ".$admincommission."  
						WHERE `projectId` = ".$projectId);

			} elseif($_POST['current']=='4') { // save the rewards 
			
				//echo $_POST['current'];
				$rewardQr = $con->delete("DELETE FROM projectrewards WHERE projectId=".$projectId);
				$pledgeAmount = $_POST['rewardAmount'];
				$limitAvail = $_POST['avail'] ;
				$rewardDescription = $_POST['rewardDescription'];
				$rewardMonth = $_POST['rewardMonth'];
				$rewardYear = $_POST['rewardYear'];
				$numReward = $_POST['countRewards'];
				
				$noReward = (int)$_POST['noReward'];
				
				if($numReward == 0) {
					$numReward = 1;
				}
				$limitCheck = $_POST['availLimit'];
							
				if($noReward > 0) {	
					for($i=0;$i<$numReward;$i++) {				
						if($limitCheck[$i]==true) {
							if($limitAvail[$i]=='') {
								$limitAvailValue = 0;
							} else {
								$limitAvailValue = $limitAvail[$i];
							}
						} elseif($limitAvail[$i]=='') {
							$limitAvailValue = 0;
						} else {					
							$limitAvailValue = 0;
						}		
						$pledgeAmount[$i] = (float)remove_currency($pledgeAmount[$i]);
						$limitAvailValue = (int)$limitAvailValue;
						$rewardDescription[$i] = addslashes($rewardDescription[$i]);
						$inserReward = $con->insert("INSERT INTO projectrewards(`pledgeAmount`,`limitAvailable`,`description`,`estimateDeliveryMonth`, `estimateDeliveryYear`,`projectId`) 
							VALUES(".$pledgeAmount[$i].",".$limitAvailValue.",'".$rewardDescription[$i]."', ".$rewardMonth[$i].",".$rewardYear[$i].",".$projectId.")");
						
					}
				}
			} elseif($_POST['current']=='5') {	// save story
			
				//echo $_POST['current']; 
				$projectStory1 = sanitize_string($_POST['projectStory1']);
				//echo $projectStory1;
				if(!empty($projectStory1)) {
					$updateStory = $con->update("UPDATE projectstory SET `projectDescription` = '".$projectStory1."' where projectId = ".$projectId." LIMIT 1");
				}
				/* project video link -- jwg */
				if(isset($_POST['video_url']) && !empty($_POST['video_url'])) {
					$videourl = $_POST['video_url'];
					if (!preg_match('#youtube#i',$videourl)) {
						wrtlog("Not youtube: $videourl");
						$error = 'We currently support only youtube videos';
					} else {
						if (preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/watch\?v=((?:[a-zA-Z0-9._]|-)+)(?:\&|$)/i',$videourl,$match) ||				
							preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/(?:user\/)?(?:[a-z0-9\_\#\/]|-)*\/[a-z0-9]*\/[a-z0-9]*\/((?:[a-z0-9._]|-)+)(?:[\&\?\w;=\+_\#\%]|-)*/i',$videourl,$match) ||
							preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/embed\/((?:[a-z0-9._]|-)+)(?:\?|$)/i',$videourl,$match)) {	  	

							$videoId = $match[1];
							$imageurl = 'https://img.youtube.com/vi/'.$videoId.'/0.jpg';
							//$thumburl = 'https://img.youtube.com/vi/'.$videoId.'/2.jpg';
							// don't override to embed format here .. do it where video will be used
							//$videourl = 'https://www.youtube.com/embed/'.$videoId; // override to acceptable format 

							$prodId = $_SESSION['projectId'];
							$now = time();
							$userId = $_SESSION['userId'];
							
							// SAVE VIDEO URL AND EXPECTED IMAGE URL OF REMOTELY SOURCED IMAGE
							$update = "update projectstory set projectVideo='".$_POST['video_url']."', projectVideoImage='".$imageurl."' where projectId=".$prodId. " LIMIT 1";
							$con->update($update);
							
						} else {
							$error = 'Unrecognized youtube url';
						}
					}
				}				
				
				
			} elseif($_POST['current']=='6') { // about you tab saves the user details

			//echo $_POST['biography'];exit;
				//echo $_POST['current'];
				//echo $_SESSION['projectId'];exit;
				$userBiography = sanitize_string($_POST['biography']);
				$userLocation = addslashes($_POST['userLocation']);
				//`biography` = '".$userBiography."',
				$projId_bio = sanitize_string($_POST['projectId_bio']);
				$updateStory = $con->update("UPDATE users SET  `userLocation` = '".$userLocation."' WHERE userId = $uid LIMIT 1");
				//echo "UPDATE projectbasics SET `userBiography` = '".$userBiography."' WHERE `projectId` = ".$_SESSION['projectId'];exit;
				//$updateBasic = $con->update("UPDATE projectbasics SET `userBiography` = '".$userBiography."' WHERE `projectId` = ".$projId_bio);
				$updateBasic = $con->update("UPDATE projectbasics SET `userBiography` = '".$userBiography."' WHERE `projectId` = ".$_SESSION['projectId']);
				$updateUserBio = $con->update("UPDATE users SET `biography` = '".$userBiography."' WHERE `userId` = ".$_SESSION['userId']);
				
			} elseif($_POST['current']=='7') {	// Account tab saves here.	
			
				//echo $_POST['current'];	
				$paypalUserAccount = $_POST['paypalUserAccount'];
				$paypalUserAccount = base64_encode($paypalUserAccount);
				
				$phoneNumber = (isset($_POST['phoneNumber'])) ? $_POST['phoneNumber'] : '';
				if($paypalUserAccount!='') {
					$updateStory = $con->update("UPDATE users set `paypalUserAccount` = '".$paypalUserAccount."' where userId=$uid limit 1");	
				}
			} else {
				//echo $_POST['current'];	
				//no steps are selected.
			}
			print $_SESSION['projectId'];
		}
	}
?>