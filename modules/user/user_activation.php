<?php
	require_once("../../includes/config.php");
	
	wrtlog("DEBUG user/user_activation: ".print_r($_REQUEST,true));
	
	if($_REQUEST['email']!="" && $_REQUEST['actCode'] !="")
	{
		$email = (string) $_REQUEST['email'];
		$actCode = (string) $_REQUEST['actCode'];
		
		$qry1 = $con->recordselect("SELECT * FROM users WHERE emailAddress='".$email."' and randomNumber='".$actCode."' LIMIT 1");
		$tot_rec = mysql_num_rows($qry1);

		
		if($tot_rec == 1) {
			$valid_user = mysql_fetch_array($qry1);
		  //update status
			if($valid_user['activated']==0) {
				$con->update("UPDATE users SET activated=1 WHERE emailAddress='".$email."' and randomNumber='".$actCode."'");
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Your account activated Successfully.');
				
				if ($valid_user['referrerId'] > 0) {
					$refid = $valid_user['referrerId'];
					$qry2 = $con->recordselect("SELECT * FROM referrals WHERE newuserId=".$valid_user['userId']." AND referrerId=".$refid." LIMIT 1");
					$referral = mysql_fetch_array($qry2);
					$projid = $referral['projectId'];
					$targeturl = urlencode(SITE_URL.'browseproject/'.$projid);
					$_SESSION['refid'] = $refid;
					$_SESSION['projid'] = $projid;
					if ($prelaunch) redirect(SITE_URL); // jwg
					redirect(SITE_URL.'browseproject/'.$projid);
					//redirect(SITE_URL."login?refid=$refid&projid=$projid&redirUrl=$targeturl");
				} else {
					if ($prelaunch) redirect(SITE_URL); // jwg
					redirect(SITE_URL."profile");
				}
			}else{
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Your are Already Activated.');
				if ($prelaunch && ($valid_user['siteAccess'] == 0)) redirect(SITE_URL); // jwg
				redirect(SITE_URL."profile");	
			}
						
		 } else {
			
			redirect(SITE_URL); // jwg was SITE_URL.'signup'
		 }
	}else{ 
		redirect(SITE_URL); // jwg was SITE_URL.'signup'
	}
	
?>