<?php
	require_once("../../includes/config.php");
	//$left_panel=false;
	//$cont_mid_cl='-75';	
	$title = "My Reward History";
	$meta = array("description"=>"My Reward History","keywords"=>"My Reward History");
	
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
	/*echo "SELECT * FROM `projects` as pr,`projectbasics` as pb,`projectbacking` as pk  WHERE pr.userId ='".$_SESSION['userId']."' AND pr.projectId = pb.projectId AND pr.projectId = pk.projectId ORDER BY pk.backingTime DESC";*/
	$sel_backedproject1="SELECT * FROM `projects` as pr,`projectbasics` as pb,`projectbacking` as pk  WHERE pr.userId ='".$_SESSION['userId']."' AND pr.projectId = pb.projectId AND pr.projectId = pk.projectId AND pr.accepted=1 ORDER BY pk.backingTime DESC";
	$sel_backedproject = $con->select($sel_backedproject1,$page,$perpage,15,2,0);
	
	$module='user';
	$page='rewardhistory';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>