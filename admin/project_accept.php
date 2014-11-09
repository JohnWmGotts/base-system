<?php
	require_once("../includes/config.php");
	require_once(DIR_FUN.'validation.class.php');
	$pagetitle="Project Accept";
	$tbl_nm = "projectbasics";
	$id	=	"basicsId";
	/*if($_GET['page']<0 || !is_numeric($_GET['page']) || $_GET['page']==0)
	{
		$_GET['page']=1;
	}
	$target_file = "project_accept.php";
	if($_GET['page']=='')
	{
		$page=1;
	}
	else
	{
		$page = $_GET['page'];
	}*/
	$perpage=10;
	require_once("pagination.php");		
			
	if (!isset($_SESSION['admin_user']) || ($_SESSION["admin_user"]=="") || ($_SESSION["admin_role"]==1))
	{
		redirect(SITE_ADM."login.php");
	}
	if(isset($_POST['action']))
	{
		extract($_POST);
		$obj = new validation();		
		$obj->add_fields($project_title, 'req', 'Please enter Project Title');
		$obj->add_fields($project_title, 'min=4', 'Project Title should be atleast 4 characters long');
		$obj->add_fields($project_title, 'max=25', 'Project Title should not be more than 25 characters long');		
        $obj->add_fields($short_blurb, 'req', 'Name should not be more than 25 characters long');
		$obj->add_fields($short_blurb, 'min=4', 'Short Blurb should be atleast 4 characters long');
		$obj->add_fields($short_blurb, 'max=50', 'Short Blurb should not be more than 25 characters long');		
		$obj->add_fields($project_location, 'req', 'Please enter Location');		
		$obj->add_fields($project_description, 'req', 'Please Enter Project Description');
        $obj->add_fields($project_description, 'min=4', 'Project Description should be atleast 4 characters long');
		$obj->add_fields($project_description, 'max=250', 'Project Description should not be more than 25 characters long');
		$error = $obj->validate();				
	}
	
	// Delete User code start
	if(isset($_GET['action']) && $_GET['action']=='delete') {
		// Delete Query HERE
		//echo "delete";
		//$con->delete("DELETE FROM `admin` WHERE `id` = '".$_GET['id']."'");
		//header('location: admin.php');		
	}
	// Delete User code end
	
	// Form Post code start
	if(isset($_POST['action']) && ($_POST['action']=='add' || $_POST['action']=='edit')) 
	{	
		if($_POST['action']=='edit' && $error=='') 
		{
			$con->update("UPDATE projectbasics SET projectTitle='$project_title', projectCategory='$project_category', shortBlurb='$short_blurb', projectLocation='$project_location' WHERE projectId='".$_GET['id']."'");
			$con->update("UPDATE projects SET accepted='$project_status' WHERE projectId='".$_GET['id']."'");
			//$con->update("UPDATE projectstory SET projectVideo='$project_video', projectDescription='$project_description' WHERE projectId='".$_GET['id']."'");
			// jwg -- alt approach for youtube video and its related image
			if (isset($project_video) && !empty($project_video)) {
				if (!preg_match('#youtube#i',$project_video)) {
					wrtlog("Video not youtube .. in project_accept.php: $project_video for $project_title");
					$error = 'We currently support only youtube videos';
				} else {
					$imageurl = '';
					if (preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/watch\?v=((?:[a-zA-Z0-9._]|-)+)(?:\&|$)/i',$videourl,$match) ||				
						preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/(?:user\/)?(?:[a-z0-9\_\#\/]|-)*\/[a-z0-9]*\/[a-z0-9]*\/((?:[a-z0-9._]|-)+)(?:[\&\?\w;=\+_\#\%]|-)*/i',$videourl,$match) ||
						preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/embed\/((?:[a-z0-9._]|-)+)(?:\?|$)/i',$videourl,$match)) {	  	
						$videoId = $match[1];
						$imageurl = 'https://img.youtube.com/vi/'.$videoId.'/0.jpg';
					} else {
						wrtlog("Could not determine YouTube video ID: $project_video for $project_title");
						$error = 'Could not determine YouTube video Id for video image';
					}
					
					$con->update("UPDATE projectstory SET projectVideo='$project_video', projectVideoImage='$imageurl', projectDescription='$project_description' WHERE projectId='".$_GET['id']."'");
				}
			}
			//$con->update("UPDATE categories SET username='$adminname', password='$passswd', role='$role' WHERE id='".$_GET['id']."'");
			// for paging 
			/*$page1=$_GET['page'];
			if($page1=='' || $page1==0)
			{
				$page1=1;
			}*/
			header('location: project_accept.php');   //?page='.$page1 redirect page after update all record
		}		
	}
	// Form Post code end
	
	if(isset($_GET['action']) && $_GET['action']=='inactive') {
	
		$con->recordselect("UPDATE projects SET accepted = 0 WHERE projectId='".$_GET['id']."'");		
		redirect(SITE_ADM."project_accept.php?msg=SUCBLO&page=".$page1);
	}
	if(isset($_GET['action']) && $_GET['action']=='active') {
		
		$con->recordselect("UPDATE projects SET accepted = 1 WHERE projectId='".$_GET['id']."'");		
		redirect(SITE_ADM."project_accept.php?msg=SUCACT&page=".$page1);
	}
	if(isset($_GET['action']) && $_GET['action']=='addComing') {
		$con->recordselect("UPDATE projects SET comming_soon = 1 WHERE projectId='".$_GET['id']."'");		
		redirect(SITE_ADM."project_accept.php?msg=SUCBLO&page=".$page1);
	}
	if(isset($_GET['action']) && $_GET['action']=='removeComing') {
		$con->recordselect("UPDATE projects SET comming_soon = 0 WHERE projectId='".$_GET['id']."'");		
		redirect(SITE_ADM."project_accept.php?msg=SUCACT&page=".$page1);
	}
	
	
	// User Edit select query code start
	if(isset($_GET['action']) && $_GET['action']=='edit') {
		$sel_editproject=mysql_fetch_array($con->recordselect("SELECT * FROM projectbasics WHERE projectId  = '".$_GET['id']."'"));	
		$sel_editproject_pro=mysql_fetch_array($con->recordselect("SELECT * FROM projects WHERE projectId = '".$_GET['id']."'"));	
		$sel_editproject_ps=mysql_fetch_array($con->recordselect("SELECT * FROM projectstory WHERE projectId = '".$_GET['id']."'"));
		//$sel_editproject_cat=mysql_fetch_array($con->recordselect("SELECT * FROM categories WHERE categoryId = '".$sel_editproject['projectCategory']."'"));
	}
	// User Edit select query code end
	$sqlQuery = "select * from projects as p, projectbasics as pbs where p.published=1 and p.accepted!=3 and p.projectId=pbs.projectId order by pbs.projectStart DESC";
	//$results = $con->select($sqlQuery,$page,$perpage,15,2,0);
	$results = $con->recordselect($sqlQuery);
	$content="project_accept";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>