<?php
	
	require_once("../../includes/config.php");
	
	//$left_panel=false;
	//$cont_mid_cl='-75';
	if(!isset($_GET) || !isset($_GET['page']) || $_GET['page']==0 || $_GET['page']<=0)
	{
		$_GET['page']=1;
	}
	//require_once("pagination.php");
	//require_once("backedprojec_pagination.php");
	//require_once("starredproject_pagination.php");
	$perpage = 5;
	$limit = " LIMIT 0,".$perpage;
	$rec_limit = " LIMIT 0,".$perpage;
		
	function Aspect_Ration($image,$width) {
		$imageFile = $image;
		 
		/* Set the width fixed at 200px; */
		//$width = 200;
		 
		/* Get the image info */
		$info = getimagesize($imageFile);
		 
		/* Calculate aspect ratio by dividing height by width */
		$aspectRatio = $info[1] / $info[0];
		 
		/* Keep the width fix at 100px, 
		   but change the height according to the aspect ratio */
		$newHeight = (int)($aspectRatio * $width) . "px";
		 
		/* Use the 'newHeight' in the CSS height property below. */
		return array('h'=>$newHeight,'w'=>$width."px");
		//$width .= "px";
	}
	
	function ago($time) {
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");

	   $now = time();

		   $difference     = $now - $time;
		   $tense         = "ago";

	   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		   $difference /= $lengths[$j];
	   }

	   $difference = round($difference);

	   if($difference != 1) {
		   $periods[$j].= "s";
	   }

	   return "$difference $periods[$j] ago ";
	}
	
	$news_array = array (); 
	if(!isset($_GET['user']) || (isset($_GET['user']) && $_GET['user']==''))
	{
		
		$sel_1=$con->recordselect("SELECT *,bk.backingTime as sorting FROM `projectbacking` as bk,`projects` as p WHERE bk.userId ='".$_SESSION['userId']."' AND bk.projectId=p.projectId AND p.accepted!='3' group by bk.projectId order by bk.backingTime desc");													
		$total_count = mysql_num_rows($sel_1) ;
				
		$sel_2=$con->recordselect("SELECT *,cm.commentTime as sorting FROM `projectcomments` as cm,`projects` as p WHERE cm.userId ='".$_SESSION['userId']."' AND cm.projectId=p.projectId AND p.accepted!='3' AND cm.commentstatus=1 order by cm.commentTime desc");													
		$total_count += mysql_num_rows($sel_2) ;
				
		$sel_3=$con->recordselect("SELECT *,up.updateTime as sorting FROM `projectupdate` as up,`projects` as p WHERE up.userId ='".$_SESSION['userId']."' AND up.projectId=p.projectId AND p.accepted!='3' AND up.updatestatus=1 order by up.updateTime desc");	
		$total_count += mysql_num_rows($sel_3) ;
		
		$sel_4=$con->recordselect("SELECT *,upct.updateCommentTime as sorting FROM `projectupdatecomment` as upct,`projects` as p WHERE upct.userId ='".$_SESSION['userId']."' AND upct.projectId=p.projectId AND p.accepted!='3' AND upct.updatecommentstatus=1 order by upct.updateCommentTime desc");	
		$total_count += mysql_num_rows($sel_4) ;
		//echo "SELECT *,pbs.projectStart as sorting FROM projects as p, projectbasics as pbs WHERE p.userId ='".$_SESSION['userId']."' and p.projectId=pbs.projectId and p.published=1 and p.accepted=1 and p.accepted!=3 order by pbs.projectStart desc";
		 $sel_5=$con->recordselect("SELECT *,pbs.projectStart as sorting FROM projects as p, projectbasics as pbs WHERE p.userId ='".$_SESSION['userId']."' and p.projectId=pbs.projectId and p.published=1 and p.accepted=1 and p.accepted!=3 order by pbs.projectStart desc");	
		$total_count += mysql_num_rows($sel_5) ;
		/*echo "SELECT *,cm.created_date as sorting FROM `projectreview` as cm,`projects` as p WHERE cm.userId ='".$_SESSION['userId']."' AND cm.projectId=p.projectId AND p.accepted!='3' order by cm.created_date desc";*/
		$sel_6=$con->recordselect("SELECT *,cm.created_date as sorting FROM `projectreview` as cm,`projects` as p WHERE cm.userId ='".$_SESSION['userId']."' AND cm.projectId=p.projectId AND p.accepted!='3' AND cm.reviewstatus=1 order by cm.created_date desc");													
		$total_count += mysql_num_rows($sel_6) ;
	
		
		/*$sel_1=$con->recordselect("SELECT *,backingTime as sorting FROM `projectbacking` WHERE `userId` ='".$_SESSION['userId']."' group by projectId order by backingTime desc");													
		$total_count = mysql_num_rows($sel_1) ;
				
		$sel_2=$con->recordselect("SELECT *,commentTime as sorting FROM `projectcomments` WHERE `userId` ='".$_SESSION['userId']."' order by commentTime desc");													
		$total_count += mysql_num_rows($sel_2) ;
				
		$sel_3=$con->recordselect("SELECT *,updateTime as sorting FROM `projectupdate` WHERE `userId` ='".$_SESSION['userId']."' order by updateTime desc");	
		$total_count += mysql_num_rows($sel_3) ;
		
		$sel_4=$con->recordselect("SELECT *,updateCommentTime as sorting FROM `projectupdatecomment` WHERE `userId` ='".$_SESSION['userId']."' order by updateCommentTime desc");	
		$total_count += mysql_num_rows($sel_4) ;
		
		$sel_5=$con->recordselect("SELECT *,pbs.projectStart as sorting FROM projects as p, projectbasics as pbs WHERE p.userId ='".$_SESSION['userId']."' and p.projectId=pbs.projectId and p.published=1 and p.accepted=1 order by pbs.projectStart desc");	
		$total_count += mysql_num_rows($sel_5) ;*/
	}
	else
	{
		$sel_1=$con->recordselect("SELECT *,bk.backingTime as sorting FROM `projectbacking` as bk,`projects` as p1 WHERE bk.userId ='".$_GET['user']."' AND bk.projectId=p1.projectId AND p1.accepted!='3' group by bk.projectId order by bk.backingTime desc");													
		$total_count = mysql_num_rows($sel_1) ;
				
		$sel_2=$con->recordselect("SELECT *,cm.commentTime as sorting FROM `projectcomments` as cm,`projects` as p1 WHERE cm.userId ='".$_GET['user']."' AND cm.projectId=p1.projectId AND p1.accepted!='3' AND cm.commentstatus=1 order by cm.commentTime desc");													
		$total_count += mysql_num_rows($sel_2) ;
				
		$sel_3=$con->recordselect("SELECT *,up.updateTime as sorting FROM `projectupdate` as up,`projects` as p1 WHERE up.userId ='".$_GET['user']."' AND up.projectId=p1.projectId AND p1.accepted!='3' AND up.updatestatus=1 order by up.updateTime desc");	
		$total_count += mysql_num_rows($sel_3) ;
		
		$sel_4=$con->recordselect("SELECT *,upct.updateCommentTime as sorting FROM `projectupdatecomment` as upct,`projects` as p1 WHERE upct.userId ='".$_GET['user']."' AND upct.projectId=p1.projectId AND p1.accepted!='3' AND updatecommentstatus=1 order by upct.updateCommentTime desc");	
		$total_count += mysql_num_rows($sel_4) ;
		
		$sel_5=$con->recordselect("SELECT *,pbs.projectStart as sorting FROM projects as p, projectbasics as pbs WHERE p.userId ='".$_GET['user']."' and p.projectId=pbs.projectId and p.published=1 and p.accepted=1 and p.accepted!='3' order by pbs.projectStart desc");	
		$total_count += mysql_num_rows($sel_5) ;
		
		$sel_6=$con->recordselect("SELECT *,cm.created_date as sorting FROM `projectreview` as cm,`projects` as p1 WHERE cm.userId ='".$_GET['user']."' AND cm.projectId=p1.projectId AND p1.accepted!='3' AND cm.reviewstatus=1 order by cm.created_date desc");													
		$total_count += mysql_num_rows($sel_6) ;
	}
	while($row=mysql_fetch_array($sel_1))
	{
		array_push($news_array, $row);
	}	
	while($row2=mysql_fetch_array($sel_2))
	{
		array_push($news_array, $row2);
	}
	while($row3=mysql_fetch_array($sel_3))
	{
		array_push($news_array, $row3);
	}
	while($row4=mysql_fetch_array($sel_4))
	{
		array_push($news_array, $row4);
	}	
	while($row5=mysql_fetch_array($sel_5))
	{
		array_push($news_array, $row5);
	}
	while($row6=mysql_fetch_array($sel_6))
	{
		array_push($news_array, $row6);
	}
	
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}


array_sort_by_column($news_array,"sorting");

	//project update comment code start
	if(isset($_POST['submitProjectUpdateComment']) && $_SESSION['userId']!=''){
		extract($_POST);
		$updatecomment_time=time();
		$con->insert("INSERT INTO `projectupdatecomment` (`updatecommentId`, `userId`, `projectId`, `updatenumber`, `updateComment`, `updateCommentTime`) VALUES 
			(NULL, '".$_SESSION['userId']."', '".$project."', '".$updatenumber."', '".sanitize_string($projectupdate_comment)."', '$updatecomment_time')");
		/*if($_SESSION['userId']!=$sel_pro['userId'])
		{
		$emailid="";
		$artical="";
		$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$artical.="<body><strong>Hello ".$sel_pro_user['name'].", </strong><br />";
		$artical.="<br />Thank you for creating your profile on ".DISPLAYSITENAME.".com.<br /><br />";
		$artical.="<table><tr><td colspan='2'><strong>Account Information</strong></td></tr>";
		$artical.="<tr><td colspan='2'>&nbsp;</td></tr><tr><td><strong>User Id : </strong></td><td>".$user_comment."</td></tr>";
		$artical.="<tr><td><strong>Password : </strong></td><td>".$sel_pro_user['name']."</td></tr>";
		$artical.="<tr><td colspan='2'>&nbsp;</td></tr></table>";
		$artical.="Please activate your account by clicking on following link.<br /><a href='".SITE_URL."modules/user/user_activation.php?email=".$sel_pro_user['name']."&actCode=".$sel_pro_user['name']."' target='_blank'>Activate</a><br /> Once you activated, you can use your user id and password to login into your account.";
		$artical.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
		$subject="Registration Detail At ".DISPLAYSITENAME."";
		$mailbody=$artical;
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html\r\n";
		$headers .= FROMEMAILADDRESS;
		@mail($emailid, $subject, $mailbody, $headers);
		 //header('Location: loginsignup.php?msg1=REGSUS');
		}*/
	}
	//project update comment code over
	if(isset($_GET['user']) && $_GET['user']!=''){
		$results=$con->recordselect("SELECT * FROM users WHERE userId='".$_GET['user']."'");
		if(mysql_num_rows($results)>0)
		{
			$result=mysql_fetch_array($results);
			$website_res=$con->recordselect("SELECT * FROM userwebsites WHERE userId='".$_GET['user']."'");
			$title = $result['name'];
			$meta = array("description"=>"User profile","keywords"=>"User profile");
		}
		else
		{
			redirect(SITE_URL."index.php");
		}
	}
	else
	{
		if($_SESSION["userId"]=="" && $_SESSION["name"]=="")
		{
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Please login to access this page.");	
			redirect(SITE_URL."index.php");
			exit;
		}
		else
		{
			$result=mysql_fetch_array($con->recordselect("SELECT * FROM users WHERE userId='".$_SESSION['userId']."'"));
			$website_res=$con->recordselect("SELECT * FROM userwebsites WHERE userId='".$_SESSION['userId']."'");
			$title = "My profile";
			$meta = array("description"=>"User profile","keywords"=>"User profile");
		}		
	}
	
	$ses_user = isset($_SESSION['userId']) ? $_SESSION['userId'] : NULL;
	$get_user = isset($_GET['user']) ? $_GET['user'] : NULL;
	
	if(isset($_SESSION['userId']) && $_SESSION['userId']!='' && !isset($_GET['user']) || $_GET['user']=='' || $_SESSION['userId']==$_GET['user']) {
		$sql = "SELECT * FROM `projects` WHERE `userId` ='".$_SESSION['userId']."' ORDER BY `projectId` DESC ".$limit;
		$sel_created = mysql_query($sql);
	}
	else
	{
		$sql = "SELECT * FROM `projects` WHERE `userId` ='".$_GET['user']."' AND published=1 AND accepted=1 ORDER BY `projectId` DESC ".$limit;
		$sel_created = mysql_query($sql);
	}
	
	//require_once("activity_pagination.php");	
	$categoriesList = $con->recordselect("SELECT * from categories limit 10");	
	$module='user';
	$page='profile';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>