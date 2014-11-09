<?php
	require_once("../includes/config.php");
	$pagetitle = 'Home';
	if(!isset($_SESSION['admin_user']) || ($_SESSION["admin_user"]==""))
	{
		header('location: index.php');
		exit;
	}
	
	$sel_adminRole = $con->recordselect("SELECT * FROM adminrole WHERE status = 'a' ORDER BY id ");		
	
	$content="home";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>