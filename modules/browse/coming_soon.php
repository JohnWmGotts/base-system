<?php
	require_once("../../includes/config.php");
	//$left_panel=false;
	//$cont_mid_cl='-75';
	$title = "Upcoming Projects";
	$meta = array("description"=>"Upcoming Projects","keywords"=>"Upcoming Projects");	
	
	$module='browse';
	$page='coming_soon';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>