<?php
	require "../../includes/config.php";
	$left_panel=false;
	$cont_mid_cl='-75';
	$title = "FAQ";
	$meta = array("description"=>"Help for Making Discover and Create Projects","keywords"=>"Help for Making Discover and Create Projects");
	
	$sel_faq_main_title=mysql_fetch_assoc($con->recordselect("SELECT * FROM `faqcategory` WHERE `faqCategoryId` ='".$_GET['id']."' AND `faqCategoryParentId` =0 ORDER BY faqCategoryId ASC"));

	$module='help';
	$page='faqresult';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>