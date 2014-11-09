<?php
	require_once("../../includes/config.php");
	//$left_panel=false;
	//$cont_mid_cl='-75';	
	$title = "My Inbox";
	$meta = array("description"=>"Inbox","keywords"=>"Inbox");
	
	if(!isset($_SESSION['userId']) || $_SESSION['userId']=='')
	{
		 $_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Please login to access this page.");	
			redirect(SITE_URL."index.php");
			exit;
	}
	
	// delete conversation code start
	if(isset($_GET['deleteid']))
	{
		$conversationId = $_GET['deleteid'];
		//echo "SELECT * FROM usermessages WHERE messageId=$conversationId";exit;
		$sel_message_detail=mysql_fetch_array($con->recordselect("SELECT * FROM usermessages WHERE messageId=$conversationId"));
		$projectId = $sel_message_detail['projectId'];
		$receiverId = $sel_message_detail['receiverId'];
		$senderId = $sel_message_detail['senderId'];
		//echo "SELECT * FROM usermessages WHERE projectId=$projectId AND  receiverId=$receiverId AND  senderId=$senderId";exit;
		$sel_message_delete=$con->recordselect("SELECT * FROM usermessages WHERE projectId=$projectId AND  receiverId=$receiverId AND  senderId=$senderId");
		while($msg_delete = mysql_fetch_array($sel_message_delete)) {
 		$messageDel = $con->delete("delete from usermessages where messageId=".$msg_delete['messageId']);
		}
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Conversation successfully deleted.');
		redirect($base_url."inbox");
	}
	//delete conversation code end
	
	
	$module='user';
	$page='inbox';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>