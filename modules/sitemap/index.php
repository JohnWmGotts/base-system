<?php
require "../../includes/config.php";
	//$selectQuery = $con->recordselect("SELECT * from content where id=".$pageId);
	
		//$cms_arr = mysql_fetch_assoc($selectQuery);
		$title = "Site Map";
$meta = array("description"=>"Site Map","keywords"=>"Site Map");
		$module='sitemap';
		$page='index';
		$content=$module.'/'.$page;
		require_once(DIR_TMP."main_page.tpl.php");
	
	
?>