<?php
	require_once("../includes/config.php");
	if($_SESSION["admin_user"]=="")
	{
		redirect(SITE_ADM."login.php");
	}
	if($_SESSION["admin_role"]==1)
	{
		redirect(SITE_ADM."home.php");
	}
	if($_GET['id']!='' && isset($_GET['id']) && $_GET['type']='projectreview')
	{
		
		// delete comments
		 $con->delete("DELETE FROM projectreview WHERE reviewId='".$_GET['id']."'");
		
		// delete paypal transaction
		//$con->delete("DELETE FROM paypaltransaction WHERE projectId='".$_GET['id']."'");
		
		redirect(SITE_ADM.'project_review.php?page='.$_GET["page"].'&msg=DELSUS');
	}
	else
	{
		redirect(SITE_ADM."project_review.php");
	}
?>