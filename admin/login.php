<?php
	require_once("../includes/config.php");
	
	if(isset($_SESSION['admin_user']) && ($_SESSION["admin_user"]!=""))
	{
		header('location: home.php');
	}
	
	// Login Form Post
	
	if(isset($_POST['login2_x']) && isset($_POST['login2_y']))
	{
		$uname=$_POST['uname'];
		$password=$_POST['passwd'];
		
		$obj = new validation();

		$obj->add_fields($uname, 'req', ER_USER);
		$obj->add_fields($password, 'req', ER_PSW);
		$error = $obj->validate();
		$password=base64_encode($password);
		$aqy="select * from admin where username='$uname' && password='$password'";
		$ars=$con->recordselect($aqy);
		$v=mysql_fetch_array($ars);
		$uname_v=$v['username'];
		$password_v=$v['password'];
		if(mysql_num_rows($ars)<=0)
			$error .=ER_INVUP."<br>";
		else if(strcmp($password,$password_v)!=0)
			$error .=ER_PCS;
				
		if($error==''){
			$_SESSION["admin_id"]=$v['id'];
			$_SESSION["admin_user"]=$uname_v;
			$_SESSION["admin_role"]=$v['role'];
			header('location: '.SITE_ADM.'home.php');
			//print "<META http-equiv='refresh' content='0;URL=".SITE_ADM."home.php'>";	
		}
	}
	
	$content="login";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>