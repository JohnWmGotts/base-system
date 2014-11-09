<?php
require_once("../includes/config.php");
$pagetitle="Project Payment Details";
if(isset($_GET['id']))
{
	if($_GET['page']=='' || $_GET['page']<0 || !is_numeric($_GET['page']) || $_GET['page']==0)
	{
		$page=1;
	}
	else
	{
		$page = $_GET['page'];
	}
	$perpage=10;	
	$projectId = sanitize_string($_GET['id']);
	if($projectId!='' && is_numeric($projectId))
	{
		$sqlQuery = "SELECT * FROM paypaltransaction AS pt, projectbasics AS pb WHERE pb.projectId = pt.projectId AND pt.projectId=". $projectId." ORDER BY pt.dateTime DESC ";
		$query = $con->select($sqlQuery,$page,$perpage,15,2,0);
	}
	$content="project_payment_details";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
}
?>