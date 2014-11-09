<?php
	require_once("../includes/config.php");
	require_once(DIR_FUN.'validation.class.php');
	$pagetitle="Invite History";
	$tbl_nm = "tbl_invitefriends";
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
			
	if($_SESSION["admin_user"]=="" || $_SESSION["admin_role"]==1)
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
	
	
	// Form Post code end
	
	/*if(isset($_GET['action']) && $_GET['action']=='inactive') {
		//echo "UPDATE projectcomments SET status = 0 WHERE commentId='".$_GET['id']."'";exit;
		$con->recordselect("UPDATE projectreview SET reviewstatus = 0 WHERE reviewId='".$_GET['id']."'");		
		redirect(SITE_ADM."project_review.php?msg=SUCBLO&page=".$page1);
	}
	if(isset($_GET['action']) && $_GET['action']=='active') {
		
		$con->recordselect("UPDATE projectreview SET reviewstatus = 1 WHERE reviewId='".$_GET['id']."'");		
		redirect(SITE_ADM."project_review.php?msg=SUCACT&page=".$page1);
	}*/
	
		 $sqlQuery = "select * from tbl_invitefriends as inv, users as us WHERE inv.senderId = us.userId ORDER BY createdDate DESC";
	//$results = $con->select($sqlQuery,$page,$perpage,15,2,0);
	$results = $con->recordselect($sqlQuery);
	$content="invitehistory";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>