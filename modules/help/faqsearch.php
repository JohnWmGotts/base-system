<?php
	require "../../includes/config.php";
	//$left_panel=false;
	//$cont_mid_cl='-75';
	$title = "FAQ Search";
	$meta = array("description"=>"Help for Making Discover and Create Projects","keywords"=>"Help for Making Discover and Create Projects");
	extract($_POST);
	$term=sanitize_string($_POST['term']);
	$sel_faq_search=$con->recordselect("SELECT * FROM `faqquestionanswer` WHERE `faqQuestion` LIKE '%".$term."%' ORDER BY faqCategoryId ASC");

	$module='help';
	$page='faqsearch';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>