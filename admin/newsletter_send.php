<?php 
require_once("../includes/config.php");
$pagetitle="Newsletter Subscriber";
$id	=	"id";
	if($_SESSION["admin_user"]=="")
	{
		print "<META http-equiv='refresh' content='0;URL=".SITE_ADM."index.php'>";
		exit;
	}
	if($_GET['page']=='' || $_GET['page']<0 || !is_numeric($_GET['page']) || $_GET['page']==0)
	{
		$page=1;
		$_GET['page']=1;
	}
	else
	{
		$page = $_GET['page'];
	}
	$perpage=10;
	if(isset($_GET['action']) && $_GET['action']=='mail_send')
	{
		$newsId = $_GET['newsId'];
		$action = $_GET['action'];
	}
	
	//nu.status=1 AND
	$sel_newsletter_subscriber = $con->recordselect("SELECT nu.email, nu.status, nu.userId, u.userId, u.emailAddress, u.name, u.newsletter FROM newsletter_user as nu, users as u WHERE  u.userId = nu.userId");
	
	$content="newsletter_send";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>