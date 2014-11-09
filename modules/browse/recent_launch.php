<?php
	require_once("../../includes/config.php");
	//$left_panel=false;
	//$cont_mid_cl='-75';
	$title = "Recently Launch";
	$meta = array("description"=>"Recently Launch Projects","keywords"=>"Recently Launch Projects");	
	
	$module='browse';
	$page='recent_launch';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>