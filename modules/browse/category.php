<?php
	require_once("../../includes/config.php");	
	//$left_panel=false;
	//$cont_mid_cl='-75';	
	if($_GET["catId"]=='' || !is_numeric($_GET["catId"]))
	{
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Invalid category id found.");
		//$_SESSION['RedirectUrl'] = get_url();
		redirect($base_url.'index.php');
	}
	$catId = sanitize_string($_GET["catId"]);
	$catId = str_replace("/","",sanitize_string($_GET['catId']));
		
	$selectProjects = $con->recordselect("select projectId from projectbasics where projectCategory = ".$catId);
	$sel_categories=mysql_fetch_assoc($con->recordselect("SELECT categoryName FROM categories WHERE isActive=1 AND categoryId ='".$catId."'"));
	//$title = "Project for ".$sel_categories['categoryName'];
	$title = " ".$sel_categories['categoryName'];
	$meta = array("description"=>"Project for ".$sel_categories['categoryName'],"keywords"=>"Project for ".$sel_categories['categoryName']);
	//$selCategory = $con->recordselect("SELECT * FROM categories order by RAND() LIMIT 10");
	$selCitie = $con->recordselect("select projectLocation,projectId from projectbasics group by projectLocation limit 10");
	/*if(mysql_num_rows($selectProjects)<=0)
	{
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"No project found.");
		//$_SESSION['RedirectUrl'] = get_url();
		ob_start();
		redirect($base_url.'index.php');
	}*/
	
	$module='browse';
	$page='category';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>