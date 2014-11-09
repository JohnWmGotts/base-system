<?php
	require_once("../includes/config.php");
	$pagetitle="Small Project Amount";
	require_once(DIR_FUN.'validation.class.php');
		
			
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
		$obj->add_fields($amount, 'req', 'Please Enter Small Project Amount');
		$obj->add_fields($amount, 'num,max=6', 'Please Enter only number');
		$error = $obj->validate();	
	}
		
	// Form Post code start
	if(isset($_POST['action']) && $_POST['action']=='edit') {	
		extract($_POST);
		$amount = (is_numeric($amount)? $amount : 0);
		
		if($_POST['action']=='edit' && $error=='') 
		{
			$con->update("UPDATE smallprojectamount SET amount='$amount' WHERE id=1");
			
			header('location: small_project.php?msg=RECSUC');
		}
	}
	// Form Post code end
	
	//select query code start
	
	$sel_small_project_amount=mysql_fetch_array($con->recordselect("SELECT * FROM smallprojectamount WHERE id=1"));		
	
	//select query code end
	
	
	$content="small_project";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>