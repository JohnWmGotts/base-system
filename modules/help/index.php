<?php
	require "../../includes/config.php";
	//$left_panel=false;
	//$cont_mid_cl='-75';
	$title = "Help Center";
	$meta = array("description"=>"Help for Making Discover and Create Projects","keywords"=>"Help for Making Discover and Create Projects");
	$module='help';
	$page='index';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>