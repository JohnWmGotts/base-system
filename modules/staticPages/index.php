<?php
require "../../includes/config.php";
$pageId = $_GET['id'];

if($pageId!='' && is_numeric($pageId))
{
	$selectQuery = $con->recordselect("SELECT * from content where id=".$pageId);
	if(mysql_num_rows($selectQuery)>0)
	{
		$cms_arr = mysql_fetch_assoc($selectQuery);
		// jwg -- replace any remaining refs to fundraiser with current site name from config
		$cms_arr['title'] = preg_replace('#fundraiser#i',DISPLAYSITENAME,$cms_arr['title']);
		$cms_arr['meta_desc'] = preg_replace('#fundraiser#i',DISPLAYSITENAME,$cms_arr['meta_desc']);
		$cms_arr['meta_keyword'] = preg_replace('#fundraiser#i',DISPLAYSITENAME,$cms_arr['meta_keyword']);
		$cms_arr['description'] = preg_replace('#fundraiser#i',DISPLAYSITENAME,$cms_arr['description']);
		$cms_arr['title'] = preg_replace('#fundraiser#i',DISPLAYSITENAME,$cms_arr['title']);
		
		$title = $cms_arr['title'];
		$meta = array("description"=>$cms_arr['meta_desc'],"keywords"=>$cms_arr['meta_keyword']);
		$module='staticPages';
		$page='index';
		$content=$module.'/'.$page;
		require_once(DIR_TMP."main_page.tpl.php");
	}
	else
	{
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'No page found for your request.');				
		redirect($base_url.'index.php');
	}
}
else
{
	$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'No page found for your request.');				
	redirect($base_url.'index.php');
}
?>