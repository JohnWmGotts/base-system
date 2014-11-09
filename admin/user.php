<?php
	require_once("../includes/config.php");
	$pagetitle="Manage Users";
	$tbl_nm = "users";
	$target_file = "user.php";
	$id="userId";
	
	if(!isset($_GET) || !isset($_GET['page']) || ($_GET['page']<1)) {
		$_GET['page'] = 1;
	}
	$page1=(!isset($_GET['page1']) || ($_GET['page1']=='') || ($_GET['page1']==0)) ? 1 : $_GET['page1'];
	
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
		
		$obj->add_fields($uname, 'req', ER_FULLNAME);
		$obj->add_fields($uname, 'name', 'Please enter valid Full Name');
		$obj->add_fields($uname, 'min=4', ER_UNAME_MIN);
        $obj->add_fields($uname, 'max=25', ER_UNAME_MAX);
		//$obj->add_fields($uname, 'alphanumUD', "username".ER_ALPHANUM);
		$obj->add_fields($password, 'req', ER_PSW);
        $obj->add_fields($password, 'min=6', ER_UPWD_MIN);
        $obj->add_fields($password, 'max=25', 'Password should not be more than 25 characters long');
		$obj->add_fields($email, 'req', ER_EMAIL);
		$obj->add_fields($email, 'email', ER_UEMAIL);
		$obj->add_fields($biography, 'max=300', ER_UBIOGRAPHY_MAX);
		$error = $obj->validate();
		
		$email = addslashes($email);
		
		 //$error = $obj->validate();
		if( preg_match('`[A-Z]`',$password) // at least one upper case 
			&& preg_match('`[a-z]`',$password) // at least one lower case 
			&& preg_match('`[0-9]`',$password) // at least one digit 
			)
		{ 
			
		}
		else
		{ 
			$error .= 'The password must contain a minimum of one lower case character. one upper case character, one digit'.'<br>'; // not valid 
		}           
		
		$user_name_old=mysql_fetch_array($con->recordselect("SELECT `emailAddress` FROM `users` WHERE userId = '".$_GET['id']."'"));
		$old=$user_name_old['emailAddress'];
        $user_name_new=$con->recordselect("SELECT * FROM `users` WHERE `emailAddress` = '".$email."'");
		$new_nm=mysql_fetch_array($user_name_new);
		$new=$new_nm['emailAddress'];
			
		if($old!=$new)
		{
			$tot_rec=mysql_num_rows($user_name_new);
			if($tot_rec > 0)
			{			
				$error .= 'That email address is already registered.<br>';
			}	
		}
	}	
	
	// Delete User code start
	if(isset($_GET['action']) && $_GET['action']=='delete') {
		// Delete Query HERE
	}
	// Delete User code end
	
	// Form Post code start
	if(isset($_POST['action']) && ($_POST['action']=='add' || $_POST['action']=='edit')) {
		extract($_POST);
		if($_POST['action']=='add' && $error=='')
		{
			$time_add=time();
			$acti_key=base64_encode($time_add);
			$created=date('Ymd');
			$passwd = base64_encode($password);
			$biography = addslashes($biography);
			$email = addslashes($email);
			$email = base64_encode($email);
			$status = (int)$status;
			
			$con->insert("INSERT INTO users (userId, biography, emailAddress, name, password, created, access, status, activated, randomNumber, profilePicture) VALUES
			                           (NULL,'$biography' , '$email', '".sanitize_string($uname)."', '$passwd', $created, 0, 0, '$status', '$acti_key', 'NULL')");
			$user_id=mysql_insert_id();
			$cur_time=time();
			$con->insert("INSERT INTO newsletter_user (`id`, `userId`, `email`, `createDate`, `status`) 
				VALUES (NULL, '".$user_id."', '".$email."', '".$cur_time."', '1')");
			
			redirect(SITE_ADM."user.php?msg=ADDREC");

		}
		if($_POST['action']=='edit' && $error=='')
		{
			extract($_POST);
			$biography = addslashes($biography);
			$email = addslashes($email);
			$email = base64_encode($email);
			$status = (int)$status;
			$passswd=base64_encode($password);
			$con->update("UPDATE users SET name='".sanitize_string($uname)."', password='$passswd', emailAddress='$email', biography='$biography', activated='$status'  WHERE userId='".$_GET['id']."'");
			
			$sel_newsletter=$con->recordselect("SELECT * FROM newsletter_user WHERE email='".$email."'");
			if(mysql_num_rows($sel_newsletter)>0){
				$con->update("UPDATE newsletter_user SET status=1, userId='".mysql_real_escape_string($_GET['id'])."'  WHERE email='".$email."'");
				
			}else{
				$cur_time=time();
				$con->insert("INSERT INTO newsletter_user (`id`, `userId`, `email`, `createDate`, `status`) 
					VALUES (NULL, '".mysql_real_escape_string($_GET['id'])."', '".$email."', '".$cur_time."', '1')");
			}
					
			redirect(SITE_ADM."user.php?msg=EDITREC&page=".$page1);
		}
	}
	// Form Post code end
	
	// User Block query code start
	if(isset($_GET['action']) && $_GET['action']=='block') {
		$con->recordselect("UPDATE users SET activated=2 WHERE userId='".$_GET['id']."'");		
		redirect(SITE_ADM."user.php?msg=SUCBLO&page=".$page1);
	}
	if(isset($_GET['action']) && $_GET['action']=='active') {
		$con->recordselect("UPDATE users SET activated=1 WHERE userId='".$_GET['id']."'");		
		redirect(SITE_ADM."user.php?msg=SUCACT&page=".$page1);
	}
	// User Block select query code end
	
	// User Edit select query code start
	if(isset($_GET['action']) && $_GET['action']=='edit') {
		$sel_user_edit_qry=mysql_fetch_array($con->recordselect("SELECT * FROM users WHERE userId = '".$_GET['id']."'"));		
	} else {
		$sel_user_edit_qry = array('name' => null, 'emailAddress' => null, 'password' => null, 'biography' => null, 'activated' => null); // jwg
	}
	// User Edit select query code end
	
	$content="user";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>