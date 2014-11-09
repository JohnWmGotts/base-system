<?php
	require_once("../includes/config.php");
	$_SESSION['admin_id']="";
	$_SESSION['admin_user']="";
	$_SESSION["admin_role"]="";
	
	if(isset($_SESSION["userId"]) || isset($_SESSION["name"])){
		 
	}else{
		session_destroy();
	}
	//session_destroy(); 
	header('location: '.SITE_ADM.'login.php');
	//print "<META http-equiv='refresh' content='0;URL=".SITE_ADM."login.php'>";
?>