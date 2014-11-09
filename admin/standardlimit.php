<?php
	require_once("../includes/config.php");
	$pagetitle="Manage default commission";
	require_once(DIR_FUN.'validation.class.php');
	$tbl_nm = "smallprojectamount";
	$id	=	"id";
	$target_file = "standardlimit";
	
	if(!isset($_GET) || !isset($_GET['page']) || ($_GET['page']<1)) {
		$_GET['page'] = 1;
	}
	require_once("pagination.php");		
			
	if($_SESSION["admin_user"]=="")
	{
		header('location: login.php');
	}
	if($_SESSION["admin_role"]==1)
	{
		header('location: home.php');
	}
	if(isset($_POST['action']))
	{
		extract($_POST);
		$obj = new validation();
		
		//$obj->add_fields($standardaffiliated, 'req', 'This field is required.');
		$obj->add_fields($standardcommission, 'req', 'This field is required.');
		//$obj->add_fields($standardwithdrawl, 'req', 'This field is required.');
		
		//$obj->add_fields($standardaffiliated, 'num,max=6', 'Please Enter only number');
		$obj->add_fields($standardcommission, 'num,max=6', 'Please Enter only number');
		//$obj->add_fields($standardwithdrawl, 'num,max=6', 'Please Enter only number');
		//$obj->add_fields($wlimit, 'lte=1', 'Please Enter valid number');
		
		$error = $obj->validate();
		
	}
	
	if(isset($_GET) && isset($_GET['action']) && ($_GET['action']=='edit'))
	{	
		$std_edit_qry = mysql_fetch_assoc($con->recordselect("SELECT * FROM smallprojectamount"));
		
	}
	
	// Form Post code start
	if(isset($_POST['action']) && ($_POST['action']=='add' || $_POST['action']=='edit')) {	
		extract($_POST);
		
		//$standardaffiliated = addslashes($standardaffiliated);
		$standardcommission = addslashes($standardcommission);
		//$standardwithdrawl = addslashes($standardwithdrawl);
		
		if($_POST['action']=='edit' && $error=='') 
		{
			
			/*$con->update("UPDATE smallprojectamount SET std_cat_affiliated_commission  = '$standardaffiliated'");*/
			$con->update("UPDATE smallprojectamount SET std_cat_commission  = '$standardcommission'");
			/*$con->update("UPDATE smallprojectamount SET std_withdrawl_limit  = '$standardwithdrawl'");*/
			
			$page1=$_GET['page'];
			if($page1=='' || $page1==0)
			{
				$page1=1;
			}
			header('location: standardlimit.php?msg=EDITREC&page='.$page1);
		}
	}
	// Form Post code end
	
	$content="standardlimit";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>