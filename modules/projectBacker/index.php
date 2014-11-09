<?php
require "../../includes/config.php";
$title = "test of title";
//_print_r($_POST);
//_print_r($_GET);
//_print_r($_SESSION);exit;

if (!isset($_SESSION['userId']) || ($_SESSION['userId'] == '')) {
    $_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "Please login to back on any project");
    $_SESSION['RedirectUrl'] = get_url();

    redirect($login_url);
    exit();
}
//echo 'project'.$_GET['project'];
$searchTerm = sanitize_string((isset($_GET) && isset($_GET['project'])) ? $_GET['project'] : ''); // jwg 4
$title = "Project Backer";
$meta = array("description" => "Project Backer", "keywords" => "Project Backer");
$module = 'projectBacker';
$page = 'index';
if (($searchTerm != '') && is_numeric($searchTerm)) {
	if (isset($_GET) && isset($_GET['rewardId']) && ($_GET['rewardId'] != '') && is_numeric($_GET['rewardId'])) {
        $projecttextAmount = mysql_fetch_assoc($con->recordselect("select * from projectrewards where rewardId = " . $_GET['rewardId'] . " and projectId=" . $searchTerm));
    }
    $sel_staff2 = $con->recordselect("select * from projectrewards where projectId=" . $searchTerm);

    $selProject = $con->recordselect("SELECT * FROM projects as p, projectbasics as pb where pb.projectId = p.projectId and  pb.fundingStatus!='n' and pb.projectId = " . $searchTerm);
    $sel_pro_basic = mysql_fetch_assoc($selProject);
    //_print_r($sel_pro_basic);exit;
    if ($sel_pro_basic['projectEnd'] > time() && $sel_pro_basic['fundingStatus'] != 'n') {
        $end_date = (int) $sel_pro_basic['projectEnd'];
        $cur_time = time();
        $total = $end_date - $cur_time;
        $left_days = $total / (24 * 60 * 60);
    } else {
        $left_days = 0;
    }
    //echo $left_days;exit;
    $sel_pro_user123 = $con->recordselect("SELECT * FROM users WHERE userId='" . $sel_pro_basic['userId'] . "'");
    $sel_pro_user = mysql_fetch_assoc($sel_pro_user123);
    if ($left_days > 0) {
        if ($sel_pro_basic['userId'] != $_SESSION['userId']) {
            $selCategory = $con->recordselect("select * from categories limit 10");
            $selCitie = $con->recordselect("select projectLocation,projectId from projectbasics group by projectLocation limit 10");
            //_print_r($_SESSION);exit;    
            $module = 'projectBacker';
            $page = 'index';
            $content = $module . '/' . $page;
            require_once(DIR_TMP . "main_page.tpl.php");
        } else {
            $_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "you cannot back on your own project");
            redirect($base_url . "browseproject/" . $searchTerm . "/" . Slug($sel_pro_basic['projectTitle']).'/');
        }
    } else {
        $_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "Project duration is over now you cannot back on this project");
        redirect($base_url . "browseproject/" . $searchTerm . "/" . Slug($sel_pro_basic['projectTitle']).'/');
    }
    /* } */
} else {
	// jwg -- fix for preapproval post handling
    //if (isset($_POST)) {
	if (isset($_POST) && !isset($_POST['preapprove_backing'])) { // initial backing request
        if (isset($_POST['projectId']) && ($_POST['projectId'] != '') && is_numeric($_POST['projectId'])) {
			wrtlog("projectBacking/index.php display page to confirm backing request for projectId {$_POST['projectId']} ");
            //$selCategory = $con->recordselect("select * from categories limit 10");
            //$selCitie = $con->recordselect("select projectLocation,projectId from projectbasics group by projectLocation limit 10");
            $searchTerm = sanitize_string($_POST['projectId']);
            $projectReward = (isset($_POST['projectReward'])) ? sanitize_string($_POST['projectReward']) : 0; // jwg rewardId					 // 
            $pledgeAmount_custom = (isset($_POST['pledgeAmount_custom'])) ? sanitize_string($_POST['pledgeAmount_custom']) : 0; // pledge amount (read-only? but initially settable)
			$rewardPledgeAmount_custom = (isset($_POST['rewardPledgeAmount_custom'])) ? sanitize_string($_POST['rewardPledgeAmount_custom']) : 0; // jwg.. 
            if ($projectReward > 0) {
                $sel_staff2 = $con->recordselect("select * from projectrewards where projectId=" . $searchTerm);
                if (mysql_num_rows($sel_staff2) <= 0 && $pledgeAmount_custom == '') {
                    $_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "No Project Reward found");

                    redirect($base_url . "projectBacker/" . $searchTerm);
                }
            }
		
            if (($projectReward == '' && (!isset($pledgeAmount_custom) || !is_numeric($pledgeAmount_custom) || $pledgeAmount_custom <= '0')) || ($projectReward == '0' && (!isset($pledgeAmount_custom) || !is_numeric($pledgeAmount_custom) || $pledgeAmount_custom <= '0'))) {

                if ($projectReward == '0' && (!isset($pledgeAmount_custom) || !is_numeric($pledgeAmount_custom) || $pledgeAmount_custom <= '0')) {
                    $_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "Please select backed amount for project");
                } else {
                    $_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "Please select backed amount for project");
                }
                redirect($base_url . "projectBacker/" . $searchTerm);
            } else {
				
				//condition for additional changes(backer can add more backing amount to rewards amount)..
                if (!is_numeric($rewardPledgeAmount_custom) || $rewardPledgeAmount_custom < '0') {
					//echo 'yy';exit;
                    $_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "Please select valid backed amount for project");
					  redirect($base_url . "projectBacker/" . $searchTerm);
                } 
				else {
					// jwg - get reward for details for pre-approval display
					if ($projectReward > 0) {
						$rewardDetailQuery = $con->recordselect("SELECT * from projectrewards where rewardId =" . $projectReward);
					}
					$userDetails = mysql_fetch_array($con->recordselect("SELECT * from users where userId = " . $_SESSION['userId']));
					if (isset($rewardDetailQuery) && (mysql_num_rows($rewardDetailQuery) > 0 || $projectReward <= 0)) {
						if ($projectReward > 0) {
							$rewardDetails = mysql_fetch_array($rewardDetailQuery);
						}
					} 
					
					//for new changes..backing amount will be addition of reward & any added backing amount..
					$final_considered_amount = $pledgeAmount_custom + $rewardPledgeAmount_custom;

					// $final_considered_amount = ($projectReward > 0) ? $rewardDetails['pledgeAmount'] : $pledgeAmount_custom;

					$projectBasic = mysql_fetch_array($con->recordselect("SELECT * FROM projects as p, projectbasics as pb where pb.projectId = p.projectId and pb.projectId = " . $searchTerm));
					
					wrtlog("CHECKING in projectBacker/index.php at 111: $pledgeAmount_custom + $rewardPledgeAmount_custom = $final_considered_amount for project {$_POST['projectId']} backer {$projectBasic['userId']} ");					
					
					$projectByUser = mysql_fetch_array($con->recordselect("SELECT * from users where userId = " . $projectBasic['userId']));
					$sel_image_check = $con->recordselect("SELECT image100by80 FROM productimages WHERE projectId='" . $searchTerm . "'");
					$sel_image = mysql_fetch_assoc($sel_image_check);


						//$amount,$commision,$projectId,$backer_email,$backer_phone,$creator_paypal
					$final_array = array();
					$final_array['amount'] = urlencode($final_considered_amount);
					$final_array['rewardId'] = $projectReward;
					$final_array['projectId'] = $searchTerm;
					$final_array['backer_email'] = $userDetails['emailAddress'];
					$final_array['backer_phone'] = $userDetails['phoneNumber'];
					$final_array['creator_paypal'] = base64_decode($projectByUser['paypalUserAccount']);
					$final_array['backer_id'] = $_SESSION['userId'];
					$final_array['backer_name'] = $_SESSION['name'];
						/* $commissionval=get_commission($searchTerm,$final_considered_amount,$projectBasic["fundingGoalType"]);
						  if($commissionval==""){
						  $sel_re_projectcommission=mysql_fetch_array($con->recordselect("SELECT * FROM smallprojectamount"));
						  $final_array['commision']=$sel_re_projectcommission['std_cat_commission'];	}
						  else {
						  $final_array['commision']=$commissionval;} */     //$final_array['commision']=get_commission($searchTerm,$final_considered_amount,$projectBasic["fundingGoalType"]);
					
					$projectBasic = mysql_fetch_array($con->recordselect("SELECT * FROM projectbasics where projectId = " . $searchTerm));
					
					/* jwg -- remainder unnecessary for doing preapproval -- which is next required step and corrects current flow					
					$final_array['commision'] = ($projectBasic['admincommission'] * $final_considered_amount) / 100;

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
				
					$Pay = new Payment($PayPalConfig);
						//print_r($final_array);
			*/
					$module = 'projectBacker';
					$page = 'paypalInfo';
					$content = $module . '/' . $page;
					require_once(DIR_TMP . "main_page.tpl.php");
					//} else {
					//	$_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "No project reward found");
					//	redirect($base_url.'index.php');
					//}
				}
			}
        } else {
            $_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "No project found");
            redirect($base_url.'index.php');
        }
	} else if (isset($_POST) && isset($_POST['preapprove_backing'])) { // handle pre-approval request
		
		if ($_SERVER['SERVER_NAME'] != 'emptyrocket.com') { // only permit tests on emptyrocket
			///// TEMP TURN OFF SUPPORT FOR BACKING UNTIL NEW PAYPAL SDK INTEGRATED ///////
			$_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "Backing temporarily unavailable while new PayPal code is integrated.");
			$sel_pro_basicdata=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$_POST['projectId']."'"));
			redirect(SITE_URL."browseproject/".$_POST['projectId'].'/'.Slug($sel_pro_basicdata['projectTitle']).'/');
			///////////////////////////////////////////////////////////////////////////////
		}
		
		$backerId = sanitize_string($_POST['backerId']);	
		if (!isset($_SESSION['userId']) || ($_SESSION['userId'] != $backerId)) {
			wrtlog("WARNING: preapprove_backing request userId ($backerId) does not match session (".$_SESSION['userId'].") ");
			$_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "Request does not match logged-in user.");
			redirect($base_url.'index.php');
		} else {
			$Pay = new Payment();
			$response = $Pay->doPreapproval($_POST);
			
			wrtlog("WARNING: unexpected return from call to Pay->doPreapprovePayment in projectBacker/index.php");
			wrtlog("....... post vars: ".print_r($_POST,true));
			wrtlog("....... response: ".print_r($response,true));
			$_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "Preapproval failed. See log.");
			$sel_pro_basicdata=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$_POST['projectId']."'"));
			redirect(SITE_URL."browseproject/".$_POST['projectId'].'/'.Slug($sel_pro_basicdata['projectTitle']).'/');
		}

	} else {
        $_SESSION['msgType'] = array('from' => 'user', 'type' => 'error', 'var' => "multiple", 'val' => "No project found");
        redirect($base_url.'index.php');
    }
}
?>