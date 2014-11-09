<?php
	require_once("../../includes/config.php");
	$title = "Reset Password";
	$meta = array("description"=>"Reset Password","keywords"=>"Reset Password");
 if($_GET["email"] && $_GET["actCode"] !="")
 {
	if(isset($_POST["submitResetpass"]))
	{
		 extract($_POST);
		
		 $obj = new validation();

		 $obj->add_fields($newpass, 'req', ER_PSW);
		 $obj->add_fields($newpass, 'min=6', 'Enter Password atleast 6. characters long');
		 $obj->add_fields($newpass, 'max=25', 'Password should not be more than 25 characters long');
		 $obj->add_fields($newpass, 'alphanumUD', "Passord".ER_ALPHANUM);
		 $obj->add_fields($cnewpass, 'req', ER_CPSW);
		 $obj->add_fields($cnewpass, 'alphanumUD', "Confirmed passord".ER_ALPHANUM);
		 $error = $obj->validate();
		 $passwd = '';
		 
		/*if( preg_match('`[A-Z]`',$passwd) // at least one upper case 
			&& preg_match('`[a-z]`',$passwd) // at least one lower case 
			&& preg_match('`[0-9]`',$passwd) // at least one digit 
			)
		{ 
			echo  "hi";
		}
		else
		{ 
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"The password must contain a minimum of one lower case character. one upper case character, one digit.");
			
		}  */

		if($newpass!=$cnewpass)
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>ER_SAMEPSW);
		if($error=='')
		{
			
			$checkValid1 = $con->recordselect("SELECT * FROM users WHERE emailAddress  = '".$_GET['email']."' and randomNumber = '".$_GET['actCode']."'");
			$checkValid=mysql_num_rows($checkValid1);
			
			if($checkValid>0)
			{
				$newpass1=base64_encode($newpass);
				$con->update("UPDATE users SET password='".$newpass1."' WHERE emailAddress  = '".$_GET['email']."' AND randomNumber = '".$_GET['actCode']."'");
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Reset Password Successfully");
				redirect($base_url."login");
			}
			else
			{
				$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Reset Password Unsuccessfully please try again");
				redirect(SITE_URL."index.php");
			}
		}
	}
}
else
{
	redirect($base_url."login");
}	
	
	$module='user';
	$page='resetpassword';
	$content=$module.'/'.$page;
 	require_once(DIR_TMP."main_page.tpl.php");
?>
