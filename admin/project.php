<?php
	require_once("../includes/config.php");
	require_once(DIR_FUN.'validation.class.php');
	$pagetitle="Staff Project list";
	$tbl_nm = "projectbasics";
	$target_file = "project.php";
	if(!isset($_GET) || !isset($_GET['page']) || $_GET['page']=='' || $_GET['page']<0 || !is_numeric($_GET['page']) || $_GET['page']==0)
	{
		$page=1;
		$_GET['page']=1;
	}
	else
	{
		$page = $_GET['page'];
	}
	$perpage=10;
	
	//require_once("project_pagination.php");		
			
	if($_SESSION["admin_user"]=="")
	{
		header('location: login.php');
	}
	//print "SELECT * FROM projects AS p, projectbasics AS pbs WHERE p.published=1 AND p.accepted=1 AND p.projectId=pbs.projectId ORDER BY pbs.projectStart DESC ";
	$sql = "SELECT * FROM projects AS p, projectbasics AS pbs WHERE p.published=1 AND p.accepted=1 AND p.projectId=pbs.projectId ORDER BY pbs.projectStart DESC";
	$result = mysql_query($sql);
	$content="project";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>