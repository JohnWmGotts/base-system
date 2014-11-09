<?php
require_once("../includes/config.php");
//echo $_GET['admin_name'];
//exit;
$admin_name=(isset($_GET) && isset($_GET['adminname'])) ? $_GET['adminname'] : '';
$admin_email=(isset($_GET) && isset($_GET['adminemail'])) ? $_GET['adminemail'] : '';
if(isset($admin_name)){
	
	$id=$_GET['id'];
	$admin_name_old=mysql_fetch_array($con->recordselect("SELECT `username` FROM `admin` WHERE id = '".$id."'"));
	$old=$admin_name_old['username'];
	$admin_name=$con->recordselect("SELECT `username` FROM `admin` WHERE `username` = '".$admin_name."'");
	$new_nm=mysql_fetch_array($admin_name);
	$new=$new_nm['username'];
	if($old!=$new)
	{
		$admin_name1=mysql_num_rows($admin_name);
		if($admin_name1>0)
		{
		echo "1";
		}
		else
		{
		echo "0";
		}
	}
	else
	{
	echo "0";
	}
}
if(isset($admin_email)){
	
	$id=$_GET['id'];
	$admin_email_old = mysql_fetch_array($con->recordselect("SELECT `email` FROM `admin` WHERE id = '".$id."'"));
	$old = $admin_email_old['email'];
	$admin_email = $con->recordselect("SELECT `email` FROM `admin` WHERE `email` = '".base64_encode($admin_email)."'");
	$new_nm = mysql_fetch_array($admin_email);
	$new = $new_nm['email'];
	if($old != $new)
	{
		$admin_name1 = mysql_num_rows($admin_email);
		if($admin_name1 > 0)
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
	}
	else
	{
		echo "0";
	}
}
?>
