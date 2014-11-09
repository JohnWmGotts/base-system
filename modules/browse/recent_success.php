<?php
	require_once("../../includes/config.php");
	$left_panel=false;
	$cont_mid_cl='-75';
	if(isset($_GET["catId"]) && ($_GET["catId"] != '' || is_numeric($_GET["catId"])))
	{
		$catId = sanitize_string($_GET["catId"]);
		$catId = str_replace("/","",sanitize_string($_GET['catId']));
		$cityId = sanitize_string($_GET["city"]);
		if(isset($cityId) && ($cityId != '' || is_numeric($cityId))){
			$selectProjectsQuery = $con->recordselect("select projectLocation from projectbasics where projectId = ".$cityId);
			$selectProjects = mysql_fetch_array($selectProjectsQuery);
			$catName = " ".$selectProjects['projectLocation'];
			$cityName=$selectProjects['projectLocation'];
			$chktime_cur=strtotime(date("Y-m-d H:i:s",time()));
			$selectProjects = $con->recordselect("select * from projectbasics as pb, projects as p where p.accepted=1 and p.published=1 and pb.projectLocation =  '".$selectProjects['projectLocation']."' and p.projectId = pb.projectId and (pb.fundingStatus='y' or pb.projectEnd >'".$chktime_cur."' and pb.fundingStatus='r')");
		}else{
			$selectProjects = $con->recordselect("select projectId from projectbasics where projectCategory = ".$catId);
			$sel_categories = mysql_fetch_assoc($con->recordselect("SELECT categoryName FROM categories WHERE categoryId ='".$catId."'"));
			$catName = " ".$sel_categories['categoryName']." ";
		}
	}
	$title = "Recently Successful";
	$meta = array("description"=>"Recently Successful Projects","keywords"=>"Recently Successful Projects");	
	
	$module='browse';
	$page='recent_success';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>