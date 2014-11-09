<?php
require_once "../../includes/config.php";
$_SESSION["file_info"] = array();
$title = "Create new project";
$meta = array("description"=>"create new project","keywords"=>"create new project");

if(!isset($_SESSION['userId']) || ($_SESSION['userId']=='')) {	
	$_SESSION['RedirectUrl'] = get_url();
	$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Please login to access this page");										
    redirect($login_url);
    exit();
}

//echo '<pre>';print_r($_SESSION);echo '</pre>';exit;
/*project publish code here*/
if(isset($_POST) && isset($_POST['projectCreate']) && ($_POST['projectCreate']==1)) {
	
	/*project Basic save*/
	$obj = new validation();
	$obj->add_fields($_POST['projectTitle'], 'req', 'Project title required');
	$error = $obj->validate();		
	if($error=="") {		
		$obj->add_fields($_POST['shortBlurb'], 'req', 'Project short blurb required');
		$error = $obj->validate();
	}
	if($error=="") {		
		$obj->add_fields($_POST['fundingGoal'], 'req', 'Project funding goal required');
		$error = $obj->validate();
	}
	/*if($error=="" && $_POST['days']!='')
	{		
		
		$obj->add_fields($_POST['days'], 'num', 'Invalid days.');
		$error = $obj->validate();
	}
	if($error=="" && $_POST['days']!='')
	{		
		
		$obj->add_fields($_POST['days'], 'max', 'Invalid days.');
		$error = $obj->validate();
	}*/
	/*if($error=="")
	{		
		$fundingGoalOption = (isset($_POST['fundingGoal_amount']) OR !empty($_POST['fundingGoal_amount'])) ? $_POST['fundingGoal_amount'] : -1;
		$fundingGoalOption = (isset($_POST['fundingGoal_people']) OR !empty($_POST['fundingGoal_people'])) ? $_POST['fundingGoal_people'] : -1;
		
		if(isset($_POST['goalType']) && $_POST['goalType'] == 1){
			if($fundingGoalOption > 0){
				$obj->add_fields($fundingGoalOption, 'req', 'Project funding goal required');
				$error = $obj->validate();
			}
		}
	}*/
	/*if($error=="")
	{		
		$obj->add_fields($_POST['fundingGoal'], 'num', 'Indvalid Project funding goal.');
		$error = $obj->validate();
	}	
	if($error=="")
	{		
		$obj->add_fields($_POST['fundingGoal'], 'max', 'Indvalid Project funding goal.');
		$error = $obj->validate();
	}*/		
	if($error=="") {		
		$obj->add_fields($_POST['projectStory1'], 'req', 'Project story required');
		$error = $obj->validate();
	}		
	/*if($error=="")
	{		
		$obj->add_fields($_POST['biography'], 'req', 'User biography required.');
		$error = $obj->validate();
	}*/
	if($error) {
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>$error);
		redirect($base_url."createproject/".$_SESSION['projectId']);
		die();
	}
		
	$userBiography = sanitize_string($_POST['biography']);
	
	$projectId = $_SESSION['projectId'];
	$projectTitle = sanitize_string($_POST['projectTitle']);
	$projectCategory = sanitize_string($_POST['projectCategory']);
	$projectBlurb = sanitize_string($_POST['shortBlurb']);
	$projectLocation = sanitize_string($_POST['projectLocation']);
	$projectDurationOption = $_POST['duration'];
	//$projectGoalAmountOption = $_POST['goalType']; // 'a'==amount, 'b'==percent (we only do amount)
	
	$projectFunding = remove_currency(sanitize_string($_POST['fundingGoal']));
	$projectFunding = str_replace(',', '', $projectFunding);
	$projectFunding = number_format($projectFunding,2,'.','');							
	//$projectFundingAmount = (isset($_POST['fundingGoal_amount']) OR !empty($_POST['fundingGoal_amount'])) ? $_POST['fundingGoal_amount'] : 0;
	//$projectFundingPeople = (isset($_POST['fundingGoal_people']) OR !empty($_POST['fundingGoal_people'])) ? $_POST['fundingGoal_people'] : 0;
	
	/*if($projectFundingAmount > 0 && !empty($projectFundingAmount)){
		$projectFundindGoalOption = 0;
		$projectFunding = sanitize_string($projectFundingAmount);
		$projectFunding = number_format($projectFundingAmount,2,'.','');
		$minimumContributors = 0;
	}elseif($projectFundingPeople > 0 && !empty($projectFundingPeople)){
		$projectFundindGoalOption = 1;
		$minimumContributors = sanitize_string($projectFundingPeople);
		$minimumContributors = number_format($projectFundingPeople,2,'.','');
		$projectFunding = 0;
	}*/
	/*if($projectFundindGoalOption==1 && $minimumContributors<=0)
	{
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Enter Minimum Contributors greater than zero.');
		redirect($base_url."createproject/".$_SESSION['projectId']);
		die();
	}
	else if($projectFundindGoalOption==0 && $projectFunding<=0 )
	{
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Enter Minimum Cost greater than zero.');
		redirect($base_url."createproject/".$_SESSION['projectId']);
		die();
	}*/
	
	//For paypal verification..
	$selectProjectUser = mysql_fetch_array($con->recordselect("SELECT * from users where userId = ".$_SESSION['userId']));
	if($selectProjectUser['paypal_verification_code']==''){
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"You must verify your funding account in your user profile to publish project");										
	redirect(SITE_URL."index.php");
	}
	
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
		$startDate = time();
		$endDate = $startDate + $days;	
	}
	$selectProject = $con->recordselect("SELECT projectTitle from projectbasics where projectId = ".$projectId);
	if(mysql_num_rows($selectProject)>0) {							
		$updateBasic = $con->update("UPDATE projectbasics set `userBiography` = '".$userBiography."', projectTitle = '".$projectTitle."',projectCategory = '".$projectCategory."',
				shortBlurb ='".$projectBlurb."', projectLocation = '".$projectLocation."',projectStart = ".$startDate.",projectEnd = ".$endDate." ,
				durationType = ".(int)$projectDurationOption." ,
				fundingGoal =".(int)$projectFunding."  where projectId =".$projectId);
	
		/*$updateBasic = $con->update("UPDATE projectbasics SET `userBiography` = '".$userBiography."',`projectTitle` = '".$projectTitle."', `projectCategory` = ".$projectCategory.",
						`shortBlurb` = '".$projectBlurb."', `projectLocation` = '".$projectLocation."', `projectStart` = ".$startDate.", `projectEnd` = ".$endDate." , 
						`fundingGoalType` = '".(int)$projectFundindGoalOption."' , 
						`minimumContributer` = '".(int)$minimumContributors."' ,
						`durationType` = '".(int)$projectDurationOption."' , `fundingGoal` ='".(int)$projectFunding."'  WHERE `projectId` = ".$projectId);*/
		
	}
	
	/*project rewards save here*/
	if (!isset($_POST)) $_POST=array();
	$noReward = (isset($_POST['noReward'])) ? (int)$_POST['noReward'] : 0;//Hiddent Field.
	if($noReward > 0){
		//print_r($_POST);exit;
		$rewardQr = $con->delete("delete from projectrewards where projectId=".$projectId);
	} else { // jwg - logic fixup
		$pledgeAmount = (isset($_POST['rewardAmount'])) ? $_POST['rewardAmount'] : '';
		if (is_array($pledgeAmount) && (sizeof($pledgeAmount) > 0)) {
			for ($i=0; $i < sizeof($pledgeAmount); $i++) {
				$pledgeAmount[$i] = remove_currency($pledgeAmount[$i]);
			}
		} else {
			$pledgeAmount = remove_currency($pledgeAmount);
		}
		$rewardDescription = (isset($_POST['rewardDescription'])) ? $_POST['rewardDescription'] : '';
		$rewardMonth = (isset($_POST['rewardMonth'])) ? $_POST['rewardMonth'] : '';
		$rewardYear = (isset($_POST['rewardYear'])) ? $_POST['rewardYear'] : '';
		$numReward = (isset($_POST['countRewards'])) ? $_POST['countRewards'] : '';
		if($numReward==0) {
			$numReward=1;
		}
		$limitCheck = (isset($_POST['availLimit'])) ? $_POST['availLimit'] : '';
		$rewardAmount = (isset($_POST['rewardAmount'])) ? $pledgeAmount : '';
		$limitAvail = (isset($_POST['avail'])) ? $_POST['avail'] : '';
		//print_r($limitAvail);exit;
		for($i=0;$i<$numReward;$i++) {
			//if($limitCheck[$i]==true) {
				/*if($limitAvail[$i]=='') {*/
					//$limitAvailValue = 0;
				/*} else {*/
					$limitAvailValue = $limitAvail[$i];
				//}
			/*} elseif($limitAvail[$i]=='') {
				$limitAvailValue = 0;
			} else {					
				$limitAvailValue = 0;
			}*/
			//echo "INSERT INTO projectrewards(`pledgeAmount`,`limitAvailable`,`description`,`estimateDeliveryMonth`, `estimateDeliveryYear`,`projectId`) VALUES(".$pledgeAmount[$i].",".$limitAvailValue.",'".$rewardDescription[$i]."', ".$rewardMonth[$i].",".$rewardYear[$i].",$projectId)";.
			if($error=="") {		
				$obj->add_fields($pledgeAmount[$i], 'req', 'Pledge amount required');
				$error = $obj->validate();
			}
			if($error=="") {		
				$obj->add_fields($rewardMonth[$i], 'req', 'Reward month required');
				$error = $obj->validate();
			}
			if($error=="") {		
				$obj->add_fields($rewardYear[$i], 'req', 'Reward year required');
				$error = $obj->validate();
			}
			if($error=="") {		
				$obj->add_fields($rewardDescription[$i], 'req', 'Reward descripton required');
				$error = $obj->validate();
			}
			if($error) {
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>$error);
				redirect($base_url."createproject/".$_SESSION['projectId']);
				die();
			}
			$inserReward = $con->insert("INSERT INTO projectrewards(`pledgeAmount`,`limitAvailable`,`description`,`estimateDeliveryMonth`, `estimateDeliveryYear`,`projectId`) VALUES(".(int)$pledgeAmount[$i].",".(int)$limitAvailValue.",'".sanitize_string($rewardDescription[$i])."', ".$rewardMonth[$i].",".$rewardYear[$i].",$projectId)");
		}
	}
	
	/*project story save here*/
	$projectStory = (isset($_POST['projectStory1'])) ? sanitize_string($_POST['projectStory1']) : '';
	$updateStory = $con->update("UPDATE projectstory set `projectDescription` = '".$projectStory."' where projectId=$projectId limit 1");
	
	/*project video link */
	if(isset($_POST['video_url'])) {
		$videourl = $_POST['video_url'];
		if (!preg_match('#youtube#i',$videourl)) { 
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
	
	/*about user save here.*/
	//$userBiography = sanitize_string($_POST['biography']);
	$userLocation = (isset($_POST['userLocation'])) ? sanitize_string($_POST['userLocation']) : '';
	
	//`biography` = '".$userBiography."'
	$updateStory = $con->update("UPDATE users set  `userLocation` = '".$userLocation."' where userId=".$_SESSION['userId']." limit 1");
	/*account details save here*/
	$paypalUserAccount = (isset($_POST) && isset($_POST['paypalUserAccount']) && !empty($_POST['paypalUserAccount'])) ? $_POST['paypalUserAccount'] : '';
	$paypalUserAccount = base64_encode($paypalUserAccount);
	
	$phoneNumber = (isset($_POST['phoneNumber'])) ? $_POST['phoneNumber'] : '';
	if($paypalUserAccount!='') {
		$updateStory = $con->update("UPDATE users set `paypalUserAccount` = '".$paypalUserAccount."' where userId=".$_SESSION['userId']." limit 1");	
	}
	
	//$projectDetail =  mysql_fetch_array($con->recordselect("SELECT commission_paid,commission_paid_id,fundingGoalType from projectbasics where projectId = ".$projectId));
	
	/*if($projectDetail['commission_paid']!='y' && ($projectDetail['commission_paid_id']=='' || $projectDetail['commission_paid_id']=='0') && $projectDetail['fundingGoalType']=='1')
	{
		
		//projectId,creatorId,amount,creatorEmail,creatorName,creatorPhone
		$checkCommision_r = $con->recordselect("select * from  commision WHERE type = 'b' LIMIT 1");
		if(mysql_num_rows($checkCommision_r)>0)
		{
			
			$checkCommision = mysql_fetch_array($checkCommision_r);
			
			$creator_detail = mysql_fetch_array($con->recordselect("select users.emailAddress,users.name,users.phoneNumber from users,projects WHERE projectId = '".$projectId."' and projects.userId=users.userId LIMIT 1"));
			
			$final_array=array();
			$final_array['amount'] = urlencode($checkCommision['value']);
			$final_array['projectId'] = $projectId;
			$final_array['creatorEmail']=$creator_detail['emailAddress'];
			$final_array['creatorPhone']=$creator_detail['phoneNumber'];
			$final_array['creatorId']=$_SESSION['userId'];
			
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
			$Pay=new Payment($PayPalConfig);
			$redirect_paypal_url=$Pay->PayCommisionfromCreatorForPType1($final_array);;
			//print $redirect_paypal_url;
			header("location:".$redirect_paypal_url);
		}
		else
		{
			
			$con->update("UPDATE projectbasics SET commission_paid = 'y' WHERE projectId=".$projectId);
			$updateProject = $con->update("UPDATE projects set published=1 where projectId=".$projectId);
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Project published sucessfully, after admin approval project will be listed on the site.");				
			unset($_SESSION['projectId']);
			redirect($base_url."profile/#b");
		}
	
	}
	else
	{*/
		
		$con->update("UPDATE projectbasics SET commission_paid = 'y' WHERE projectId=".$projectId);
		$updateProject = $con->update("UPDATE projects set published=1 where projectId=".$projectId);
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Project published sucessfully, after admin approval project will be listed on the site.");
						
		unset($_SESSION['projectId']);
		redirect($base_url."profile/#b");
	/*}*/
	
	//$updateProject = $con->update("UPDATE projects set published=1 where projectId=".$projectId);
	//='';
	
}
/*project publish code over here.*/
else
{
	//echo 'aaaa';exit;
	//print_r($_GET['id']);
	//$projId = str_replace("/","",sanitize_string($_GET['id']));
	$projId = (isset($_GET) && isset($_GET['id'])) ? sanitize_string($_GET['id']) : '';
	//$projectId
	$uid = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : '';
	//echo $projId;exit;
	$title = "Start your project";
	$meta = array("description"=>"create your project","keywords"=>"crowd funding projects");
	$module='createProject';
	$page='index';
	$siteCategories = $con->recordselect("select categoryId, categoryName from categories WHERE isActive = 1");
	if($projId!='') {		
		$checkProject = $con->recordselect("SELECT * FROM projects as p, projectbasics as pb where pb.projectId = p.projectId and pb.projectId = ".$projId);
		if(mysql_num_rows($checkProject)>0) {
			$prjDetails = mysql_fetch_array($checkProject);
			if($prjDetails['projectEnd']!='0') {
				if($prjDetails['projectEnd']>time() && $prjDetails['fundingStatus']!='n') {
					$end_date=(int) $prjDetails['projectEnd'];
					$cur_time=time();
					$total = $end_date - $cur_time;
					$left_days=$total/(24 * 60 * 60);
				} else {
					$left_days=0;
				}
			} else {
				$left_days = 1;
			}
			if($prjDetails['userId'] == $_SESSION['userId']) {
				if($left_days==0) {
					if($prjDetails['published']==1) {
					$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Project Had been expire");				
					unset($_SESSION['projectId']);
					redirect($base_url.'index.php');
					}
						else {
						$_SESSION['projectId'] = $projId;	
						//redirect($base_url.'createproject/'.$prjDetails['projectId']);
					}
				} else {
					if($prjDetails['published']==1) {
						$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Project already pubilshed and you cannot edit published project");				
						unset($_SESSION['projectId']);
						redirect($base_url.'index.php');
					} else {
						$_SESSION['projectId'] = $projId;
					}
				}
			} else {
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"You cannot edit other users project");				
				unset($_SESSION['projectId']);
				redirect($base_url.'index.php');
			}
		}
	}	
	if(isset($_SESSION['projectId']) && ($_SESSION['projectId']!='')) {
		$projId = $_SESSION['projectId'];
		$checkProject = $con->recordselect("SELECT * FROM projects as p, projectbasics as pb where pb.projectId = p.projectId and pb.projectId = ".$projId);
		if(mysql_num_rows($checkProject)>0) {
			$prjDetails = mysql_fetch_array($checkProject);
			if($prjDetails['projectEnd']!='0') {
				if($prjDetails['projectEnd']>time() && $prjDetails['fundingStatus']!='n') {
					$end_date=(int) $prjDetails['projectEnd'];
					$cur_time=time();
					$total = $end_date - $cur_time;
					$left_days=$total/(24 * 60 * 60);
				} else {
					$left_days=0;
				}
			} else {
				$left_days = 1;
			}
			if($prjDetails['userId'] == $_SESSION['userId']) {
				if($left_days==0) {
					if($prjDetails['published']==1) {
						$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Project is expired");				
					unset($_SESSION['projectId']);
					redirect($base_url.'index.php');
					}
					else {
						$_SESSION['projectId'] = $projId;
						//redirect($base_url.'createproject/'.$_SESSION['projectId']);
					}
					
				} else {
					if($prjDetails['published']==1) {
						
						$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"You cannot edit a published project");				
						unset($_SESSION['projectId']);
						redirect($base_url.'index.php');
					}					
				}
			} else {
				
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"You cannot edit other users project.");				
				unset($_SESSION['projectId']);
				redirect($base_url.'index.php');
			}
		}
		//"SELECT * FROM projectbasics where projectId= ".$_SESSION['projectId'];
		$projectBasicDetails=$con->recordselect("SELECT * FROM projectbasics where projectId= ".$_SESSION['projectId']);
		if(mysql_num_rows($projectBasicDetails)>0) {
			$projectBasicDetails = mysql_fetch_assoc($projectBasicDetails);
			//print_r($projectBasicDetails);
		}
		$projectImages=$con->recordselect("SELECT * FROM productimages where projectId= ".$_SESSION['projectId']);
		if(mysql_num_rows($projectImages)>0) {
			$projectImages = mysql_fetch_assoc($projectImages);
			//print_r($projectImages);
		}
		//echo "SELECT * FROM projectrewards where projectId= ".$_SESSION['projectId'];
		$projectRewards=$con->recordselect("SELECT * FROM projectrewards where projectId= ".$_SESSION['projectId']);		//echo "SELECT * FROM projectstory where projectId= ".$_SESSION['projectId'];
		
		/* no longer doing this .. just save remote image url for video in projectStory -- jwg
		$projectVideoImages=$con->recordselect("SELECT * FROM productimages where projectId= ".$_SESSION['projectId']." and isVideo=1");
		if(mysql_num_rows($projectVideoImages)>0) {
			$projectVideoImages = mysql_fetch_assoc($projectVideoImages);
			//print_r($projectImages);
		}
		*/
		$projectStory=$con->recordselect("SELECT * FROM projectstory where projectId= ".$_SESSION['projectId']);
		if(mysql_num_rows($projectStory)>0) {
			$projectStory = mysql_fetch_assoc($projectStory);
		}
		
	}
	$userDetails=$con->recordselect("SELECT * FROM users where userId= ".$uid);
	if(mysql_num_rows($userDetails)>0) {
		$userDetails = mysql_fetch_assoc($userDetails);
		//echo "SELECT * FROM projectstory where projectId= ".$_SESSION['projectId'];		
	}
	$userWebsites=$con->recordselect("SELECT * FROM userwebsites where userId= ".$uid);
	$sel_ContentPage = $con->recordselect("SELECT * FROM `content` WHERE `title` LIKE '%defining your project%' LIMIT 1");
	$sel_ContentPage = mysql_fetch_array($sel_ContentPage);
	$manage_commision_backers = mysql_fetch_array($con->recordselect("SELECT value from commision WHERE type = 'b'"));		
	$manage_commision_cost = mysql_fetch_array($con->recordselect("SELECT value from commision WHERE start =0 AND end >0 AND type = 'p'"));		
		
	
	
	$content=$module.'/'.$page;
	$createProjectHeader = 1;
	$footer_space = 1;
	
	if(isset($_SESSION['projectId'])){
		$projId = $_SESSION['projectId'];
	}
	/* jwg -- don't do fb here unless needed later
	$fb_login_require = true;
	$fb_createProject_Id = $projId;
	//global $fb_bio_set;
	
	if((isset($fb_createProject_Id) && $fb_createProject_Id >0 )){
		require_once(DIR_MOD.'fb_connect/fb_login.php');
	}
	*/
	require_once(DIR_TMP."main_page.tpl.php");

}


?>