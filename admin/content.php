<?php
	require_once("../includes/config.php");
	
	if($_SESSION["admin_user"]=="")
	{
		print "<META http-equiv='refresh' content='0;URL=".SITE_ADM."index.php'>";
		exit;
	}
	
	// Delete Content code start
	if(isset($_GET['action']) && $_GET['action']=='delete') {
		// Delete Query HERE
	}
	// Delete Content code end
	
	// Form Post code start
	if(isset($_POST['action']) && ($_POST['action']=='edit')) {
		print_r($_POST);
		extract($_POST);
	}
	// Form Post code end
	
	// Content Edit select query code start
	if(isset($_GET['action']) && $_GET['action']=='edit') {
		$action=$_GET['action'];
		$eqry="SELECT * FROM content WHERE id='".$_GET['id']."'";
		$eres=$con->recordselect($eqry);
		$erow=mysql_fetch_array($eres);
		extract($erow);
	}
	// Content Edit select query code end
	
	// Content listing select query, pagging, sorting code start
	if(! isset($_GET['action'])) {
	}
	// Content listing select query code end
	
	$content="content";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>