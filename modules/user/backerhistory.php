<?php
	require_once("../../includes/config.php");
	//$left_panel=false;
	//$cont_mid_cl='-75';	
	$title = "My Backer History";
	$meta = array("description"=>"My Backer History","keywords"=>"My Backer History");
	
	if(!isset($_SESSION['userId']) || $_SESSION['userId']=='')
	{
		 $_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Please login to access this page.");	
			redirect(SITE_URL."index.php");
			exit;
	}
	
	$extra='';
	if(!isset($_GET) || !isset($_GET['page']) || $_GET['page']==0 || $_GET['page']<=0)
	{
		$_GET['page']=1;
	}
	$page = $_GET['page'];
	
	$perpage=10;
	
	$sel_backedproject1="SELECT * FROM `projectbacking` WHERE `userId` ='".$_SESSION['userId']."' ORDER BY backingTime DESC";
	$sel_backedproject = $con->select($sel_backedproject1,$page,$perpage,15,2,0);
	
	$module='user';
	$page='backerhistory';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>