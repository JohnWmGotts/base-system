<?php
	require_once("../includes/config.php");
	if($_SESSION["admin_user"]=="")
	{
		redirect(SITE_ADM."login.php");
	}
	if($_SESSION["admin_role"]==1)
	{
		redirect(SITE_ADM."home.php");
	}
	if($_GET['id']!='' && isset($_GET['id']))
	{
		// delete productimages
		/*$sel_image1=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$_GET['id']."'");
		if(mysql_num_rows($sel_image1)>0)
		{
			$sel_image=mysql_fetch_assoc($sel_image1);
			@unlink(DIR_FS.$sel_image['image700by370']);
			@unlink(DIR_FS.$sel_image['image640by480']);
			@unlink(DIR_FS.$sel_image['image400by300']);
			@unlink(DIR_FS.$sel_image['image340by250']);
			@unlink(DIR_FS.$sel_image['image223by169']);
			@unlink(DIR_FS.$sel_image['image200by156']);
			@unlink(DIR_FS.$sel_image['image100by80']);
			@unlink(DIR_FS.$sel_image['image16by16']);
		}*/
		// delete productimage record
		//$con->delete("DELETE FROM productimages WHERE projectId='".$_GET['id']."'");
		
		// delete projectbacking
		//$con->delete("DELETE FROM projectbacking WHERE projectId='".$_GET['id']."'");
		
		// delete projectbasics
		//$con->delete("DELETE FROM projectbasics WHERE projectId='".$_GET['id']."'");
		
		// delete projectcomments
		//$con->delete("DELETE FROM projectcomments WHERE projectId='".$_GET['id']."'");
		
		// delete projecthit
		//$con->delete("DELETE FROM projecthit WHERE projectId='".$_GET['id']."'");
		
		// delete projectremind
		//$con->delete("DELETE FROM projectremind WHERE projectId='".$_GET['id']."'");
				
		// delete projectrewards
		//$con->delete("DELETE FROM projectrewards WHERE projectId='".$_GET['id']."'");
		
		// delete projects
		$con->update("UPDATE projects SET accepted='3' WHERE projectId='".$_GET['id']."'");
			
		//$con->delete("DELETE FROM projects WHERE projectId='".$_GET['id']."'");
		
		// delete projectstory
		//$con->delete("DELETE FROM projectstory WHERE projectId='".$_GET['id']."'");
		
		// delete projectupdate
		//$con->delete("DELETE FROM projectupdate WHERE projectId='".$_GET['id']."'");
		
		// delete projectupdatecomment
		//$con->delete("DELETE FROM projectupdatecomment WHERE projectId='".$_GET['id']."'");
		
		// delete staffpicks
		//$con->delete("DELETE FROM staffpicks WHERE projectId='".$_GET['id']."'");
		
		// delete staffpicks
		$con->delete("DELETE FROM usermessages WHERE projectId='".$_GET['id']."'");
		
		// delete paypal transaction
		//$con->delete("DELETE FROM paypaltransaction WHERE projectId='".$_GET['id']."'");
		
		redirect(SITE_ADM.'project_accept.php?page='.$_GET["page"].'&msg=DELSUS');
	}
	else
	{
		redirect(SITE_ADM."project_accept.php");
	}
?>