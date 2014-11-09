<?php
	require_once("../../includes/config.php");
	//$left_panel=false;
	//$cont_mid_cl='-75';	
	$title = "My Financials";
	$meta = array("description"=>"My Financials","keywords"=>"My Financials");
	
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
	
	//finance as as backer
	/*echo 'SELECT * FROM paypaltransaction AS pt, projectbasics AS pb, categories AS ct,projects as pr WHERE  pb.projectId = pt.projectId AND pt.userId='.$_SESSION['userId'].' AND pb.projectCategory = ct.categoryId AND pr.projectId = pb.projectId AND pr.accepted !=3 ORDER BY pt.dateTime DESC';*/
	$sqlQueryBacker = 'SELECT * FROM paypaltransaction AS pt, projectbasics AS pb, categories AS ct,projects as pr WHERE  pb.projectId = pt.projectId AND pt.userId='.$_SESSION['userId'].' AND pb.projectCategory = ct.categoryId AND pr.projectId = pb.projectId AND pr.accepted !=3  ORDER BY pt.dateTime DESC';
	$sqlResBacker = $con->recordselect($sqlQueryBacker);
	
	$sqlQueryBackerTotal = 'SELECT * FROM paypaltransaction AS pt, projectbasics AS pb, categories AS ct,projects as pr WHERE  pb.projectId = pt.projectId AND pt.userId='.$_SESSION['userId'].' AND pb.projectCategory = ct.categoryId AND pr.projectId = pb.projectId AND pr.accepted !=3  ORDER BY pt.dateTime DESC';
	$sqlResBackerTotal = $con->recordselect($sqlQueryBackerTotal);
	$totalBacking = 0;
	 while($resBackingTotal = mysql_fetch_array($sqlResBackerTotal)) {
		$totalBacking+=$resBackingTotal['amount'];
	 }
	 
	 $sqlQueryBackerNumber = 'SELECT * FROM paypaltransaction AS pt, projectbasics AS pb, categories AS ct,projects as pr WHERE  pb.projectId = pt.projectId AND pt.userId='.$_SESSION['userId'].' AND pb.projectCategory = ct.categoryId AND pr.projectId = pb.projectId AND pr.accepted !=3 GROUP BY pb.projectId';
	$sqlResBackerNumber = $con->recordselect($sqlQueryBackerNumber);
	$totalprojectBacker = mysql_num_rows($sqlResBackerNumber);
	 
	//finance as a creator
	/*echo  'SELECT * FROM paypaltransaction AS pt, projectbasics AS pb, categories AS ct, projects as pr WHERE pr.userId='.$_SESSION['userId'].' AND pr.accepted !=3 AND pr.projectId = pb.projectId AND pb.projectCategory = ct.categoryId AND pr.projectId = pt.projectId ORDER BY pt.dateTime DESC';*/
	$sqlQueryCreator = 'SELECT * FROM paypaltransaction AS pt, projectbasics AS pb, categories AS ct, projects as pr WHERE pr.userId='.$_SESSION['userId'].' AND pr.accepted !=3 AND pr.projectId = pb.projectId AND pb.projectCategory = ct.categoryId AND pr.projectId = pt.projectId ORDER BY pt.dateTime DESC';

	$sqlResCreator = $con->recordselect($sqlQueryCreator);
	
	
	$sqlQueryCreatorTotal = 'SELECT * FROM paypaltransaction AS pt, projectbasics AS pb, categories AS ct, projects as pr WHERE pr.userId='.$_SESSION['userId'].' AND pr.accepted !=3 AND pr.projectId = pb.projectId AND pb.projectCategory = ct.categoryId AND pr.projectId = pt.projectId ORDER BY pt.dateTime DESC';

	$sqlResCreatorTotal = $con->recordselect($sqlQueryCreatorTotal);
	
	$totalCreate = 0;
	 while($resCreateTotal = mysql_fetch_array($sqlResCreatorTotal)) {
		$totalCreate+=$resCreateTotal['amount'];
	 }
	
	$sqlQueryCreatorNumber= 'SELECT * FROM paypaltransaction AS pt, projectbasics AS pb, categories AS ct, projects as pr WHERE pr.userId='.$_SESSION['userId'].' AND pr.accepted !=3 AND pr.projectId = pb.projectId AND pb.projectCategory = ct.categoryId AND pr.projectId = pt.projectId GROUP BY pb.projectId';

	$sqlResCreatorNumber = $con->recordselect($sqlQueryCreatorNumber);
	$totalprojectCreator = mysql_num_rows($sqlResCreatorNumber);
	
	$module='user';
	$page='advancefinance';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>