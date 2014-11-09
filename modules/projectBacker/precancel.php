<?php require_once "../../includes/config.php"; // jwg -- user cancelled preapproval
	
	if(isset($_GET['projectId']) && is_numeric($_GET['projectId']))
	{
		$projectId = $_GET['projectId'];
		if (!isset($_GET['trackingId'])) {
			wrtlog("WARNING!! No trackingId in call to precancel.php for project $projectId");
		} else {
			wrtlog("DEBUG projectBacker/precancel.php deleting project backing for project $projectId based on tracking_id.");
			$con->delete("DELETE projectbacking WHERE `projectId` = '$projectId' AND `tracking_id` = '{$_GET['trackingId']}' AND `payment_status` = '?' ");
		}
		$selectProject = mysql_fetch_assoc($con->recordselect("SELECT projectTitle from projectbasics where projectId = ".$projectId));
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Preapproval cancelled.");		
		wrtlog("Preapproval cancelled for ".Slug($selectProject['projectTitle']));
		redirect($base_url."browseproject/".$projectId."/".Slug($selectProject['projectTitle']).'/');		
	}
	wrtlog("WARNING precancel.php called without expected projectId");
	redirect($base_url.'index.php');
		
?>