<?php
	require_once("../includes/config.php");
	require_once(DIR_FUN.'validation.class.php');
	//$pagetitle="Manage Staff";
	$pagetitle="Staff Users";
	$tbl_nm = "admin";
	$target_file = "admin.php";
	if(!isset($_GET) || !isset($_GET['page']) || ($_GET['page']<1)) {
		$_GET['page'] = 1;
	}
	require_once("pagination.php");		
			
	if(!isset($_SESSION['admin_user']) || ($_SESSION["admin_user"]==""))
	{
		redirect(SITE_ADM."login.php");
	}
	if(isset($_SESSION['admin_role']) && (($_SESSION["admin_role"]==1) || ($_SESSION["admin_role"]==-1)))
	{
		redirect(SITE_ADM."home.php?msg=ACCDENIED");
	}
	if(isset($_POST) && isset($_POST['action']))
	{
		extract($_POST);
		$obj = new validation();
		
		$obj->add_fields($adminname, 'req', 'Please enter Name');
		$obj->add_fields($adminname, 'username', 'Please enter valid Name');
		$obj->add_fields($adminname, 'min=4', 'Name should be atleast 4 characters long');
        $obj->add_fields($adminname, 'max=25', 'Name should not be more than 25 characters long');
		$obj->add_fields($adminname, 'alphanumUD', "username".ER_ALPHANUM);
		$obj->add_fields($adminemail, 'req', 'Please enter Email');
		$obj->add_fields($adminemail, 'email', 'Enter valid Email Address');
		$obj->add_fields($password, 'req', ER_PSW);
        $obj->add_fields($password, 'min=6', 'Enter Password atleast 6. characters long');
        $obj->add_fields($password, 'max=25', 'Password should not be more than 25 characters long');
		$obj->add_fields($cpassword, 'req', ER_CPSW);
		$error = $obj->validate();
		
		$adminname = addslashes($adminname);
		$adminemail = addslashes($adminemail);
		
		$admin_name_old = mysql_fetch_array($con->recordselect("SELECT `username`,`email` FROM `admin` WHERE id = '".$_GET['id']."'"));
		$old = $admin_name_old['username'];
		$old_email = $admin_name_old['email'];
        $admin_name = $con->recordselect("SELECT `username`,`email` FROM `admin` WHERE `email`= '".$adminemail."' AND`username` = '".$adminname."'");
		$new_nm = mysql_fetch_array($admin_name);
		$new = $new_nm['username'];
		$new_email = $new_nm['email'];
			
		if($old!=$new)
		{
			$name_valid=mysql_num_rows($admin_name);
			
			if($name_valid > 0)
			{			
				$error .= 'Name already Exist! <br>';
			}	
		}
		if($old_email!=$new_email)
		{
			$email_valid = mysql_num_rows($admin_name);
			
			if($email_valid > 0)
			{			
				$error .= 'Email already Exist! <br>';
			}	
		}
		if($password!=$cpassword)
			$error .= ER_SAMEPSW.'<br>';
	}
		
		
	
	// Delete staff code start
	if(isset($_GET['action']) && $_GET['action']=='delete') {
		// Delete Query HERE
		$con->delete("DELETE FROM `staffpicks` WHERE `adminId` = '".$_GET['id']."'");
		$con->delete("DELETE FROM `admin` WHERE `id` = '".$_GET['id']."'");
		redirect(SITE_ADM."admin.php?msg=DELREC");		
	}
	// Delete staff code end
	
	// Form Post code start
	if(isset($_POST['action']) && ($_POST['action']=='add' || $_POST['action']=='edit')) {	
		extract($_POST);
		if($_POST['action']=='add' && $error=='')
		{
			$passswd = base64_encode($password);
			$adminname = addslashes($adminname);
			
			$adminemail = base64_encode($adminemail);			
			$con->insert("INSERT INTO admin (id, username, email, password, role) VALUES (NULL, '".$adminname."','".$adminemail."' ,'".$passswd."','1')");
			
			$artical="";
			$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical.="<body><strong>Hello , ".sanitize_string($adminname)."</strong><br />";
			$artical.="<br />Admin has added you as staff user at admin panel. please note down following login details to login to manage staff project list.<br /><br />";
			$artical.="<a href='".SITE_URL."admin/login.php' target='_blank' > Login </a><br/>";
			$artical.="<table cellpadding='1' cellspacing='1'><tr><td colspan='2'><strong>Account Information</strong></td></tr>";
			$artical.="<tr><td colspan='2'>&nbsp;</td></tr><tr><td><strong>Username : </strong></td><td>".$adminname."</td></tr>";
			$artical.="<tr><td><strong>Password : </strong></td><td>".$password."</td></tr>";
			$artical.="<tr><td colspan='2'>&nbsp;</td></tr></table>";
			$artical.="<br />Regards. <br />".DISPLAYSITENAME." Team.</body></html>";
			$subject="Staff User Detail At ".DISPLAYSITENAME;
			$mailbody = $artical;
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html\r\n";
			$headers .= FROMEMAILADDRESS;
			$to = base64_decode($adminemail);
			mail($to, $subject, $mailbody, $headers);		
			redirect(SITE_ADM."admin.php?msg=ADDREC");
		}
		if($_POST['action']=='edit' && $error=='') 
		{
			$passswd=base64_encode($password);
			$adminname = addslashes($adminname);
			$email = addslashes($adminemail);
			$email = base64_encode($email);
			$con->update("UPDATE admin SET email='$email', username='$adminname', password='$passswd', role='1' WHERE id='".$_GET['id']."'");
			$page1=$_GET['page'];
			if($page1=='' || $page1==0)
			{
				$page1=1;
			}
			redirect(SITE_ADM."admin.php?msg=EDITREC&page=".$page1);
		}
	}
	// Form Post code end
	
	// User Edit select query code start
	if(isset($_GET['action']) && $_GET['action']=='edit') {
		$sel_user_edit_qry = mysql_fetch_array($con->recordselect("SELECT * FROM admin WHERE id = '".$_GET['id']."'"));		
	} else {
		$sel_user_edit_qry = array('username' => null, 'email' => null, 'password' => null); // jwg
	}
	// User Edit select query code end
	$content="admin";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>