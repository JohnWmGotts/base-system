<?php
	require_once("../includes/config.php");
	if($_SESSION["admin_user"]=="")
	{
		redirect(SITE_ADM."login.php");
	}
	if($_SESSION["admin_role"]==1 or $_SESSION["admin_role"]==-1)
	{
		redirect(SITE_ADM."home.php");
	}
	if($_GET['id']!='' && isset($_GET['id']))
	{
		$sel_project=$con->recordselect("SELECT * FROM `projects` WHERE userId='".$_GET['id']."'");
		if(mysql_num_rows($sel_project)>0)
		{
			while($selProjectDelete = mysql_fetch_assoc($sel_project))
			{
				$con->delete("DELETE FROM projectbasics WHERE projectId='".$selProjectDelete['projectId']."'");
				$con->delete("DELETE FROM projecthit WHERE projectId='".$selProjectDelete['projectId']."'");
				$con->delete("DELETE FROM projectrewards WHERE projectId='".$selProjectDelete['projectId']."'");
				$con->delete("DELETE FROM projectstory WHERE projectId='".$selProjectDelete['projectId']."'");
				$con->delete("DELETE FROM paypaltransaction WHERE projectId='".$selProjectDelete['projectId']."'");
				$con->delete("DELETE FROM projectcomments WHERE projectId='".$selProjectDelete['projectId']."'");
				$con->delete("DELETE FROM projectremind WHERE projectId='".$selProjectDelete['projectId']."'");
				$con->delete("DELETE FROM projectupdatecomment WHERE projectId='".$selProjectDelete['projectId']."'");
			}
		}
		
		$sel_projectimg=$con->recordselect("SELECT * FROM `productimages` WHERE userId='".$_GET['id']."'");
		if(mysql_num_rows($sel_projectimg)>0)
		{
			while($selProjectimgDelete = mysql_fetch_assoc($sel_projectimg))
			{
				if (!empty($selProjectimgDelete['image700by370'])) @unlink(DIR_FS.$selProjectimgDelete['image700by370']);
				if (!empty($selProjectimgDelete['image640by480'])) @unlink(DIR_FS.$selProjectimgDelete['image640by480']);
				if (!empty($selProjectimgDelete['image400by300'])) @unlink(DIR_FS.$selProjectimgDelete['image400by300']);
				if (!empty($selProjectimgDelete['image340by250'])) @unlink(DIR_FS.$selProjectimgDelete['image340by250']);
				if (!empty($selProjectimgDelete['image223by169'])) @unlink(DIR_FS.$selProjectimgDelete['image223by169']);
				if (!empty($selProjectimgDelete['image200by156'])) @unlink(DIR_FS.$selProjectimgDelete['image200by156']);
				if (!empty($selProjectimgDelete['image100by80'])) @unlink(DIR_FS.$selProjectimgDelete['image100by80']);
				if (!empty($selProjectimgDelete['image16by16'])) @unlink(DIR_FS.$selProjectimgDelete['image16by16']);				
			}
		}
		
		$sel_userimg=$con->recordselect("SELECT * FROM `users` WHERE userId='".$_GET['id']."'");
		if(mysql_num_rows($sel_userimg)>0)
		{
			while($selUserImgDelete = mysql_fetch_assoc($sel_userimg))
			{
				if (isset($selUserImgDelete['profilePicture']) && !empty($selUserImgDelete['profilePicture']) && ($selUserImgDelete['profilePicture'] != 'NULL')) @unlink(DIR_FS.$selUserImgDelete['profilePicture']);
				if (isset($selUserImgDelete['profilePicture40_40']) && !empty($selUserImgDelete['profilePicture40_40']) && ($selUserImgDelete['profilePicture40_40'] != 'NULL'))@unlink(DIR_FS.$selUserImgDelete['profilePicture40_40']);
			}
		}
		
		$con->delete("DELETE FROM newsletter_user WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM productimages WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM projectbacking WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM projectcomments WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM projectremind WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM projectupdate WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM projectupdatecomment WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM staffpicks WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM usermessages WHERE receiverId='".$_GET['id']."' or senderId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM paypaltransaction WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM userwebsites WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM projects WHERE userId='".$_GET['id']."'");
		
		$con->delete("DELETE FROM users WHERE userId='".$_GET['id']."'");

		
		redirect(SITE_ADM."user.php?msg=DELREC");		
	}
	else
	{
		redirect(SITE_ADM."user.php");
	}
?>