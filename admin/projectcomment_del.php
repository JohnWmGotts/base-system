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
	if($_GET['id']!='' && isset($_GET['id']) && $_GET['type']='projectcomment')
	{
		
		// delete comments
		 $con->delete("DELETE FROM projectcomments WHERE commentId='".$_GET['id']."'");
		
		// delete paypal transaction
		//$con->delete("DELETE FROM paypaltransaction WHERE projectId='".$_GET['id']."'");
		
		redirect(SITE_ADM.'project_comment.php?page='.$_GET["page"].'&msg=DELSUS');
	}
	else
	{
		redirect(SITE_ADM."project_comment.php");
	}
?>