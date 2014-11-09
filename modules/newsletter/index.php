<?php
	require "../../includes/config.php";
	$newsLetterEmail = base64_encode(trim($_POST['newsletteremail']));
	$sel_alreadyexist=$con->recordselect("SELECT * FROM newsletter_user WHERE email='".$newsLetterEmail."' AND status=1");
	$sel_alreadyexist1=$con->recordselect("SELECT * FROM newsletter_user WHERE email='".$newsLetterEmail."' AND status=0");
	if(mysql_num_rows($sel_alreadyexist)>0)
	{
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'You have already subscribed to our weekly newsletter with '.$newsLetterEmail);							
		redirect(SITE_URL."index.php");	
	}
	else if(mysql_num_rows($sel_alreadyexist1)>0)
	{
		$con->update("UPDATE newsletter_user SET status=1 WHERE email='".$newsLetterEmail."'");	
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'You have subscribed to our weekly newsletter with '.$newsLetterEmail);							
		redirect(SITE_URL."index.php");
	}
	else 
	{
		$cur_time=time();
		$con->insert("INSERT INTO newsletter_user (`id`, `userId`, `email`, `createDate`, `status`) VALUES (NULL, '0', '".$newsLetterEmail."', '$cur_time', '1')");
		$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'You have subscribed to our weekly newsletter with '.$newsLetterEmail);							
		redirect(SITE_URL."index.php");
	}
?>