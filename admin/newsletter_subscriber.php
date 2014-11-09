<?php 
require_once("../includes/config.php");
$pagetitle="Newsletter Subscriber";
$id	=	"id";
	if($_SESSION["admin_user"]=="")
	{
		print "<META http-equiv='refresh' content='0;URL=".SITE_ADM."index.php'>";
		exit;
	}
	if(!isset($_GET) || !isset($_GET['page']) || ($_GET['page']<1)) {
		$_GET['page'] = 1;
		$page = 1;
	} else {
		$page = $_GET['page'];
	}
	$perpage=10;
	
	if(isset($_GET['action']) && $_GET['action']=='block') {
		$con->recordselect("UPDATE users SET newsletter=0 WHERE userId='".$_GET['id']."'");		
		$con->recordselect("UPDATE newsletter_user SET status=0 WHERE userId='".$_GET['id']."'");		
		redirect(SITE_ADM."newsletter_subscriber.php?msg=SUCBLO&page=".$page);
	}
	if(isset($_GET['action']) && $_GET['action']=='active') {
		$con->recordselect("UPDATE users SET newsletter=1 WHERE userId='".$_GET['id']."'");	
		$con->recordselect("UPDATE newsletter_user SET status=1 WHERE userId='".$_GET['id']."'");			
		redirect(SITE_ADM."newsletter_subscriber.php?msg=SUCACT&page=".$page);
	}
	if(isset($_GET['action']) && $_GET['action']=='delete') {
		$con->recordselect("UPDATE users SET newsletter=0 WHERE userId='".$_GET['id']."'");
		$con->delete("DELETE FROM newsletter_user WHERE userId='".$_GET['id']."'");	
		redirect(SITE_ADM."newsletter_subscriber.php?msg=SUCDEL");
	}
	
	if(!isset($_GET['action']) || $_GET['action']=='')
	{
		/*$sel_newsletter12 = "SELECT * FROM newsletter ORDER BY id DESC";
		$result = $con->recordselect($sel_newsletter12);*/
		
		//$sel_newsletter_subscriber = $con->recordselect("SELECT * FROM users WHERE newsletter=1");
		//nu.status=1 AND
		$sel_newsletter_subscriber = $con->recordselect("SELECT nu.email, nu.status, nu.userId, u.userId, u.emailAddress, u.name, u.newsletter FROM newsletter_user as nu, users as u WHERE  u.userId = nu.userId");
		//$sel_newsletter_subscriber1 = mysql_fetch_assoc($sel_newsletter_email);
		//$sel_newsletter_subscriber = $con->recordselect("SELECT * FROM newsletter_user WHERE status=1 AND userId=0");
		//$sel_newsletter_subscriber1 = mysql_fetch_assoc($sel_newsletter_subscriber);
	}
	
	$content="newsletter_subscriber";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>