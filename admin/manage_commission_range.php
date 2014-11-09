<?php
	require_once("../includes/config.php");
	$pagetitle="Manage Commission Price Range";
	require_once(DIR_FUN.'validation.class.php');
	$tbl_nm = "commision";
	$id	=	"id";
	$extra_cnd='type="p"';
	$target_file = "manage_commision_range.php";
	if(!isset($_GET) || !isset($_GET['page']) || ($_GET['page']<1)) {
		$_GET['page'] = 1;
	}
	require_once("pagination.php");		
			
	if(!isset($_SESSION['admin_user']) || ($_SESSION["admin_user"]==""))
	{
		header('location: login.php');
	}
	if(isset($_SESSION['admin_role']) && ($_SESSION["admin_role"]==1))
	{
		header('location: home.php');
	}
	
	// Delete category code start
	if(isset($_GET['action']) && $_GET['action']=='delete') 
	{
		
		// Delete Query HERE		
		$con->delete("DELETE FROM  commision WHERE id = '".$_GET['id']."'");
		//$con->delete("DELETE FROM `categories` WHERE `categoryId` = '".$_GET['id']."'");
		
		$page2=$_GET['page'];
		if($page2=='' || $page2==0)
		{
			$page2=1;
		}
		header('location: manage_commision_range.php?msg=DELREC&page='.$page2);		
	}
	// Delete category code end
	
	// Form Post code start
	if(isset($_POST['action']) && ($_POST['action']=='add' || $_POST['action']=='edit')) {	
		
		extract($_POST);
		$obj = new validation();		
		$obj->add_fields($start, 'req', 'Please Enter Start Range');
		$obj->add_fields($start, 'num,max=6', 'Please Enter only number for Start Range');
		$obj->add_fields($end, 'req', 'Please Enter End Range');
		$obj->add_fields($end, 'num,max=6', 'Please Enter only number for End Range');
		$obj->add_fields($value, 'req', 'Please Enter Value');
		$obj->add_fields($value, 'num,max=3', 'Please Enter only number for value');
		
		$error = $obj->validate();
		if($start=='0' && $end=='0')
		{
			$error.="You can't set both values to 0.";
		}
		if($start>$end)
		{
			if($end == 0 && $start>$end){
				
			}else{
				$error.='End Range must be greater than Start Range';
			}
		}
	
		if($_POST['action']=='add' && $error=='')
		{	
			$con->insert("INSERT INTO commision (start, end, value, type) VALUES ('".mysql_real_escape_string($start)."', '".mysql_real_escape_string($end)."', '".mysql_real_escape_string($value)."','p')");
			header('location: manage_commision_range.php?msg=ADDREC');
		}
		if($_POST['action']=='edit' && $error=='') 
		{
			$con->update("UPDATE commision SET start='".mysql_real_escape_string($start)."', end='".mysql_real_escape_string($end)."', value = '".mysql_real_escape_string($value)."' WHERE id='".$_GET['id']."'");
			$page1=$_GET['page'];
			if($page1=='' || $page1==0)
			{
				$page1=1;
			}
			header('location: manage_commision_range.php?msg=EDITREC&page='.$page1);
		}
	}
	// Form Post code end
	
	// User Edit select query code start
	if(isset($_GET['action']) && $_GET['action']=='edit') {
		$sel_category_edit_qry=mysql_fetch_array($con->recordselect("SELECT * FROM commision WHERE id = '".$_GET['id']."' and type='p'"));		
	}
	// User Edit select query code end
	
	if(isset($_GET['action']) && $_GET['action']=='inactive') {
		$con->recordselect("UPDATE categories SET isActive = 0 WHERE categoryId='".$_GET['id']."'");		
		redirect(SITE_ADM."category.php?msg=SUCBLO&page=".$page1);
	}
	if(isset($_GET['action']) && $_GET['action']=='active') {
		$con->recordselect("UPDATE categories SET isActive = 1 WHERE categoryId='".$_GET['id']."'");		
		redirect(SITE_ADM."category.php?msg=SUCACT&page=".$page1);
	}
	
	$content="manage_commision_range";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>