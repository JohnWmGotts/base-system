<?php
	require_once("../../includes/config.php");	
	//$left_panel=false;
	//$cont_mid_cl='-75';	
	if($_GET["catId"]=='' || !is_numeric($_GET["catId"]))
	{
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Invalid city.");
		
		redirect($base_url.'index.php');
	}	
	$catId = sanitize_string($_GET["catId"]);
	$cityId = sanitize_string($_GET["catId"]);
	
	$selectProjectsQuery = $con->recordselect("select projectLocation from projectbasics where projectId = ".$catId);
	$selectProjects = mysql_fetch_array($selectProjectsQuery);
	$title = " Project for ".$selectProjects['projectLocation'];
	$titlename =$selectProjects['projectLocation'];
	$meta = array("description"=>"Project for ".$selectProjects['projectLocation'],"keywords"=>"Project for ".$selectProjects['projectLocation']);
	$chktime_cur=strtotime(date("Y-m-d H:i:s",time()));  
	
	$selectProjects = $con->recordselect("select * from projectbasics as pb, projects as p where p.accepted=1 and p.published=1 and pb.projectLocation =  '".$selectProjects['projectLocation']."' and p.projectId = pb.projectId and (pb.fundingStatus='y' or pb.projectEnd >'".$chktime_cur."' and pb.fundingStatus='r')");
	$sel_categories=mysql_fetch_assoc($con->recordselect("SELECT categoryName FROM categories WHERE categoryId ='".$catId."'"));	
	$selCategory = $con->recordselect("SELECT * FROM categories order by RAND() LIMIT 10");
	$selCitie = $con->recordselect("select projectLocation,projectId from projectbasics group by projectLocation limit 10");
	
	$cityName = $title;
	$module='browse';
	$page='category';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>