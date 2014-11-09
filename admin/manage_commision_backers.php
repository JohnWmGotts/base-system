<?php
	require_once("../includes/config.php");
	$pagetitle="Manage Commission for Backers";
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
		$obj->add_fields($amount, 'req', 'Please Enter Commision Amount');
		$obj->add_fields($amount, 'num,max=6', 'Please Enter only number');
		
		$error = $obj->validate();	
		if($amount<=0)
		{
			$error.="Enter a valid Amount<br/>";
		}
	}
		
	// Form Post code start
	if(isset($_POST['action']) && $_POST['action']=='edit') {	
		extract($_POST);
		$amount = (is_numeric($amount)? $amount : 0);
		
		if($_POST['action']=='edit' && $error=='') 
		{
			$check_entry_r=$con->recordselect("SELECT id FROM commision WHERE type = 'b'");
			if(mysql_num_rows($check_entry_r)>0)
			{
				$check_entry=mysql_fetch_array($check_entry_r);
				$con->update("UPDATE commision SET value='".mysql_real_escape_string($amount)."' WHERE id='".$check_entry['id']."'");
				
			}
			else
			{
				$con->insert("INSERT INTO commision (start, end, value, type) VALUES ('0','0' , '".mysql_real_escape_string($amount)."', 'b')");
				//header('location: manage_commision_backers.php?msg=ADDREC');
			}
			
			header('location: manage_commision_backers.php?msg=RECSUC');
		}
	}
	// Form Post code end
	
	//select query code start
	
	$manage_commision_backers=mysql_fetch_array($con->recordselect("SELECT value from commision WHERE type = 'b'"));		
	
	//select query code end
	
	
	$content="manage_commision_backers";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>