<?php
	require_once("../../includes/config.php");
	//$left_panel=false;
	//$cont_mid_cl='-75';	
	$title = "Small Projects";
	$meta = array("description"=>"Small Projects","keywords"=>"Small Projects");	
	
	$module='browse';
	$page='small_project';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>

