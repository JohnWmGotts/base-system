<?php
	require_once("../../includes/config.php");
	//$left_panel=false;
	//$cont_mid_cl='-75';
	//echo 'hi';exit;
	$title = 'My Inbox';
	$meta = array("description"=>"Message","keywords"=>"Message");

	wrtlog("message debug: ".print_r($_GET,true));
	
	$sel_project_detail=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId='".$_GET['projectId']."'"));
	if (isset($_GET['id'])) {
		$sel_project_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE userId='".$_GET['id']."'"));
		wrtlog("message found get['id']=".$_GET['id']);
	} else {
		$sel_project_user=array();
		wrtlog("message found no get['id']");
	}
	$sel_project_image=mysql_fetch_assoc($con->recordselect("SELECT * FROM `productimages` WHERE projectId='".$_GET['projectId']."'"));
	
	$sel_creator_name = mysql_fetch_assoc($con->recordselect("SELECT p.userId FROM `projects` as p WHERE p.projectId='".$_GET['projectId']."'"));
	$sel_creator_name1 = mysql_fetch_assoc($con->recordselect("SELECT name FROM users  WHERE userId='".$sel_creator_name['userId']."'"));
		
	if(!isset($_SESSION['userId']) || $_SESSION['userId']=='')
	{
		 //redirect(SITE_URL."index.php");
	}
	// reply message code start
	if(isset($_POST['submitReplymessage']))
	{
		extract($_POST);
		$message_time=time();
		$con->insert("INSERT INTO usermessages (`messageId` ,`message` ,`projectId` ,`receiverId` ,`senderId` ,`messageTime`)
		VALUES (NULL , '".sanitize_string($replymessage)."', '".$_GET['projectId']."', '".$_GET['id']."', '".$_SESSION['userId']."', '".$message_time."')");
	}
	//reply message code end
	
	// delete message code start
	if(isset($_GET['deleteid']))
	{
		//echo $_GET['senderId'];exit;
		$messageDel = $con->delete("delete from usermessages where messageId=".$_GET['deleteid']);
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Message successfully deleted.');
		redirect($base_url."message/".$_GET['senderId'].'/'.$_GET['projectId'].'/');
	}
	//delete message code end
	
	$module='user';
	$page='message';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>