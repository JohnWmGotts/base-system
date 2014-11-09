<?php
	require_once("../includes/config.php");
	require_once(DIR_FUN.'validation.class.php');
	$pagetitle="Project Update";
	$tbl_nm = "projectupdate";
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
	if(isset($_POST['action']) && ($_POST['action']=='edit')) {
		extract($_POST);
		if($description == ''){
			redirect(SITE_ADM."project_update.php?msg=EDITEMPTY");
		}
		else {
		
		if($action=='edit') {	
			    $table='content';
				$keyColumnName='id';
				$id=$id;
				//$update_values=array("description"=>$description);
				$updateQuery = "update projectupdate set updateDescription = '".addslashes($description)."' where projectupdateId=".$id." Limit 1";
				$con->update($updateQuery);
				$msg='EDIT';
			}
			redirect(SITE_ADM."project_update.php?msg=".$msg);
		}
	}
	// Delete User code end
	
	// Update Edit select query code start
	if(isset($_GET['action']) && $_GET['action']=='edit') {
		$action=$_GET['action'];
		$table='projectupdate';
		$fields='*';
		$keyColumnName='id';
		$id=$_GET['id'];
		$get_update_detail = mysql_fetch_array($con->recordselect("SELECT * from projectupdate where projectupdateId=".$id));
		//print_r($get_update_detail);
		//$get_content_detail=$con->get_record_by_ID($table, $keyColumnName, $id, $fields,$limit=1);
		//$erow=mysql_fetch_array($eres);
		//extract($get_content_detail[0]);
	}
	// Update Edit select query code end
	
	// Delete User code start
	
	
	// Form Post code end
	
	if(isset($_GET['action']) && $_GET['action']=='inactive') {
		//echo "UPDATE projectcomments SET status = 0 WHERE commentId='".$_GET['id']."'";exit;
		$con->recordselect("UPDATE projectupdate SET updatestatus = 0 WHERE projectupdateId='".$_GET['id']."'");		
		redirect(SITE_ADM."project_update.php?msg=SUCBLO&page=".$page1);
	}
	if(isset($_GET['action']) && $_GET['action']=='active') {
		
		$con->recordselect("UPDATE projectupdate SET updatestatus = 1 WHERE projectupdateId='".$_GET['id']."'");		
		redirect(SITE_ADM."project_update.php?msg=SUCACT&page=".$page1);
	}
	
		 $sqlQuery = "select p.*, pco.*, us.* from projects as p, projectupdate as pco, users as us where p.published=1 and p.accepted!=3 and p.projectId=pco.projectId and pco.userId=us.userId order by pco.updateTime DESC";
	//$results = $con->select($sqlQuery,$page,$perpage,15,2,0);
	$results = $con->recordselect($sqlQuery);
	$content="project_update";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>