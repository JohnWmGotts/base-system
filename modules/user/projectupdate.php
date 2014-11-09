<?php
	require_once("../../includes/config.php");
	
	//$left_panel=false;
	//$cont_mid_cl='-75';
	//echo 'hi'.$_GET['updateId'];exit;
	if(!isset($_SESSION['userId']) || $_SESSION['userId']=='')
	{
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Please login to access this page.");	
			redirect(SITE_URL."index.php");
			exit;
	}
	//echo $_GET['type'];
	/*if(isset($_POST['type']) && $_POST['type'] == 'edit' && isset($_GET['projectId']) && isset($_POST['submitUpdate']) && $_GET['type'] != 'edit') {
		echo 'hi';exit;
	}	*/
	//echo "SELECT * FROM `projects` WHERE `projectId`='".sanitize_string($_GET['projectId'])."' and `accepted`=1 and `published`=1 and userId='".$_SESSION['userId']."' limit 1";exit;
	$sel_check_getproject=$con->recordselect("SELECT * FROM `projects` WHERE `projectId`='".sanitize_string($_GET['projectId'])."' and `accepted`=1 and `published`=1 and userId='".$_SESSION['userId']."' limit 1");
	if((($_GET['projectId']=='' || !is_numeric($_GET['projectId']) || mysql_num_rows($sel_check_getproject)<=0)) && !isset($_POST))
	{
		//echo 'hello';exit;
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Invalid ProjectId");
		redirect(SITE_URL.'profile');
	}
	$sel_project_detail=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId='".$_GET['projectId']."'"));
	$title = 'Update on '.$sel_project_detail['projectTitle'];
	$meta = array("description"=>"Project Update","keywords"=>"Project Update");
	if(isset($_POST['submitUpdate']) && isset($_GET['projectId']) && $_GET['projectId']!=''  &&  $_POST['operation'] =='')
	{
		//echo 'insert';exit;
		extract($_POST);
		$obj = new validation();

		$obj->add_fields($updateTitle, 'req', 'Please Enter Title Of Update');
		$error = $obj->validate();
		if($_POST['content']=='')
		{
			$error .= "Please Enter Content".'<br>';
		}
		
		if($_POST['content']!='')
		{
		$sel_projectupdateno=mysql_fetch_assoc($con->recordselect("SELECT count(*) as total FROM projectupdate WHERE projectId='".$_GET['projectId']."'"));
		$num_of_rows=$sel_projectupdateno['total']+1;
		$currentTime=time();
		$textcontent= unsanitize_string($content);
		
		$con->insert("INSERT INTO `projectupdate` ( `projectupdateId` , `projectId` , `userId` , `updateTitle` , `updateDescription` , updatenumber, `updateTime` )
		VALUES ( NULL , '".$_GET['projectId']."', '".$_SESSION['userId']."', '".sanitize_string($updateTitle)."', '".addslashes($content)."', '$num_of_rows', '$currentTime')" );
		$sel_project_name=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$_GET['projectId']."'"));
		$sel_project_detail=$con->recordselect("SELECT * FROM `projectbacking` WHERE projectId='".$_GET['projectId']."' GROUP BY `userId`");
		while($sel_project_backers = mysql_fetch_assoc($sel_project_detail))
		{
			$sel_project_backer_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_project_backers['userId']."'"));
			if($sel_project_backer_user['updatesNotifyBackedProject']==1)
			{
			$artical="";
			//tableborder { border: 1px solid #CCCCCC; }
			$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }
			.mtext {font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #333333;text-decoration: none;}
			a { font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #A11B1B;font-weight: normal;text-decoration: underline;}
			a:hover {font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: normal;color: #A11B1B;text-decoration: none;}
			</style></head>";
			$artical.="<body><strong>Hello ".$sel_project_backer_user['name'].", </strong><br />";				
			$artical.="<br /><table width='100%' cellspacing='0' cellpadding='0' class='tableborder' align='left'>";
			/*$artical.="<tr><td height='80' style='border-bottom:solid 1px #f2f2f2; padding:5px; background-color: #999999;' valign='middle'><img src='".SITE_IMG."logo_fundraiser.png' /></td>
	  		</tr>";*/
	  		$artical.="<tr><td colspan='2'>Updates on <b>".$sel_project_name['projectTitle']."</b> "."</td></tr>";				
	  		$artical.="<tr><td colspan='2'>Update #".$num_of_rows." ".unsanitize_string($_POST['updateTitle'])."</td></tr>";				
			$artical.="<tr><td colspan='2'>".$textcontent."</td></tr>";				
			$artical.="<tr><td colspan='2'>&nbsp;</td></tr>";
			/*$artical.="<tr><td style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#000; text-decoration:none; line-height:30px; border-top:solid 1px #f2f2f2;'>&copy; ".date('Y'). DISPLAYSITENAME." , All Rights Reserved.</td>
			</tr>";*/
			$artical.="<tr><td colspan='2'>&nbsp;</td></tr></table><br />";           
			$artical.="Kind Regards, <br />".DISPLAYSITENAME." Admin</body></html>";
			$subject="Updates on ".SlugMailSubject(unsanitize_string($sel_project_name['projectTitle']))."";
			$mailbody=$artical;
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html\r\n";
			$headers .= FROMEMAILADDRESS;
			@mail(base64_decode($sel_project_backer_user['emailAddress']), $subject, $mailbody, $headers);
			}
		}
		 $_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Update Added Successfully");
		 redirect(SITE_URL."browseproject/".$_GET['projectId']."/".Slug($sel_project_name['projectTitle'])."/&update=".$num_of_rows."#b");
		}
	}
	
	if(isset($_POST['submitUpdate']) && isset($_GET['projectId']) && $_GET['projectId']!=''  && isset($_POST['operation']) && $_POST['operation'] !='')
	{
		//echo $_GET['projectId'];exit;
		//echo 'edit';exit;
		extract($_POST);
		$obj = new validation();

		$obj->add_fields($updateTitle, 'req', 'Please Enter Title Of Update');
		$error = $obj->validate();
		if($_POST['content']=='')
		{
			$error .= "Please Enter Content".'<br>';
		}
		
		if($_POST['content']!='')
		{
		$sel_projectupdateno=mysql_fetch_assoc($con->recordselect("SELECT count(*) as total FROM projectupdate WHERE projectId='".$_GET['projectId']."'"));
		$num_of_rows=$sel_projectupdateno['total']+1;
		$currentTime=time();
		$textcontent= unsanitize_string($content);
		//$textcontent= trim(strip_tags($content));
		//echo 'abc'.$updateTitle;exit;
		//echo 'aaaa'.$updateTitle;exit;
		//echo "UPDATE projectupdate SET updateTitle='".sanitize_string($updateTitle)."' AND updateDescription='".$textcontent."' WHERE projectupdateId='".$_GET['projectId']."'";exit;
		$con->update("UPDATE projectupdate SET updateDescription='' WHERE projectupdateId='".$_GET['projectId']."'");
		$con->update("UPDATE projectupdate SET updateDescription='".addslashes($content)."' WHERE projectupdateId='".$_GET['projectId']."'");
		$con->update("UPDATE projectupdate SET updateTitle='".sanitize_string($updateTitle)."' WHERE projectupdateId='".$_GET['projectId']."'");
		
		
		$sel_project_id=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectupdate WHERE projectupdateId='".$_GET['projectId']."'"));
		$sel_project_name=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$sel_project_id['projectId']."'"));
		$sel_project_detail=$con->recordselect("SELECT * FROM `projectbacking` WHERE projectId='".$sel_project_id['projectId']."' GROUP BY `userId`");
		while($sel_project_backers = mysql_fetch_assoc($sel_project_detail))
		{
			$sel_project_backer_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_project_backers['userId']."'"));
			if($sel_project_backer_user['updatesNotifyBackedProject']==1)
			{
			$artical="";
			//tableborder { border: 1px solid #CCCCCC; }
			$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }
			.mtext {font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #333333;text-decoration: none;}
			a { font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #A11B1B;font-weight: normal;text-decoration: underline;}
			a:hover {font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: normal;color: #A11B1B;text-decoration: none;}
			</style></head>";
			$artical.="<body><strong>Hello ".$sel_project_backer_user['name'].", </strong><br />";				
			$artical.="<br /><table width='100%' cellspacing='0' cellpadding='0' class='tableborder' align='left'>";
			/*$artical.="<tr><td height='80' style='border-bottom:solid 1px #f2f2f2; padding:5px; background-color: #999999;' valign='middle'><img src='".SITE_IMG."logo_fundraiser.png' /></td>
	  		</tr>";*/
	  		$artical.="<tr><td colspan='2'>Updates on <b>".$sel_project_name['projectTitle']." Edited: </b> "."</td></tr>";				
	  		$artical.="<tr><td colspan='2'>Update #".$num_of_rows." ".unsanitize_string($_POST['updateTitle'])."</td></tr>";				
			$artical.="<tr><td colspan='2'>".$textcontent."</td></tr>";				
			$artical.="<tr><td colspan='2'>&nbsp;</td></tr>";
			$artical.="<tr><td colspan='2'>&nbsp;</td></tr></table><br />";           
			$artical.="Kind Regards, <br />".DISPLAYSITENAME." Admin</body></html>";
			$subject="Updates on ".SlugMailSubject(unsanitize_string($sel_project_name['projectTitle']))." Edited";
			$mailbody=$artical;
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html\r\n";
			$headers .= FROMEMAILADDRESS;
			@mail(base64_decode($sel_project_backer_user['emailAddress']), $subject, $mailbody, $headers);
			}
		}
		 $_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Update Edited Successfully");
		 redirect(SITE_URL."browseproject/".$sel_project_id['projectId']."/".Slug($sel_project_name['projectTitle'])."/&update=".$num_of_rows."#b");
		}
	}
	
	
	
	$module='user';
	$page='projectupdate';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>