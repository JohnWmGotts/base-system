<?php
	require_once("../includes/config.php");
	$pagetitle="Change password";
	if($_SESSION["admin_user"]=="")
	{
		header('location: login.php');
	}
	// Form Post Code
	if(isset($_POST["passwd"])) {
		extract($_POST);
		$obj = new validation();
		$obj->add_fields($passwd, 'req', ER_PSW);
		$obj->add_fields($passwd, 'min=6', 'Enter Password atleast 6. characters long');
		$obj->add_fields($passwd, 'max=25', 'Password should not be more than 25 characters long');
		//$obj->add_fields($passwd, 'alphanumUD', "Passord".ER_ALPHANUM);
		$obj->add_fields($opasswd, 'req', ER_OPSW);
		//$obj->add_fields($opasswd, 'alphanumUD', "Old passord".ER_ALPHANUM);
		$obj->add_fields($cpasswd, 'req', ER_CPSW);
		//$obj->add_fields($cpasswd, 'alphanumUD', "Confirmed passord".ER_ALPHANUM);
		$error = $obj->validate();
		
		if($opasswd!=$passvalue && $opasswd!='')
			$error .= ER_OPSWINC.'<br>';
		if($passwd!=$cpasswd)
			$error .= ER_SAMEPSW.'<br>';
		if($error=='') {	
			$update_qy="update admin set password='".base64_encode($passwd)."' WHERE id = '".$_SESSION['admin_id']."'";
			$con->update($update_qy);
			header('location: change_password.php?msg=CHNGPSW');
		}
	}
	$qy="select password from admin WHERE id = '".$_SESSION['admin_id']."'";
	$rs=$con->recordselect($qy);
	$rsw=mysql_fetch_array($rs);			
	$passwd=$rsw["password"];
	$content="change_password";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>