<?php
	require_once("../../includes/config.php");
	if($_SESSION["userId"]=="" and $_SESSION["name"]=="" and $_GET['siteid']=="")
	{
        redirect(SITE_URL."index.php");
  	}
  	$siteid=$_GET['siteid'];
	$userid=$_SESSION['userId'];
    $con->delete("DELETE FROM userwebsites WHERE siteId='$siteid' and userId='$userid'");
	$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Web site Deleted Successfully.');
	if(!isset($_GET['ajax']))
	{	
		redirect(SITE_URL."profile/edit");	
	}
	else
	{
		$count = $con->recordselect("SELECT * from userwebsites WHERE userId='$userid'");
		if(mysql_num_rows($count)>0)
		{
			echo "0";
		}
		else
		{
			echo "1";
		}
	}
?>
