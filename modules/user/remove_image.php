<?php
	require_once("../../includes/config.php");
	if($_SESSION["userId"]=="" and $_SESSION["name"]=="" and $_GET['imgid']=="")
	{
        redirect(SITE_URL."index.php");
  	}
  	$imgid=$_GET['imgid'];
    $sel_rec=$con->recordselect("SELECT * FROM `users` WHERE `userId` = '$imgid'");
    $sel_rec1=mysql_fetch_array($sel_rec);
    
	$sel_img=$sel_rec1['profilePicture'];
	$sel_img100_100=$sel_rec1['profilePicture100_100'];
	$sel_img40_40=$sel_rec1['profilePicture40_40'];
	$sel_img80_80=$sel_rec1['profilePicture80_80'];
	$sel_img80_60=$sel_rec1['profilePicture80_60'];
	
	unlink("../../".$sel_img);
	unlink("../../".$sel_img100_100);
	unlink("../../".$sel_img40_40);
	unlink("../../".$sel_img80_80);
	unlink("../../".$sel_img80_60);
	
	$con->update("UPDATE users SET profilePicture=NULL , profilePicture100_100=NULL ,
		profilePicture40_40=NULL , profilePicture80_80=NULL, profilePicture80_60=NULL
		WHERE `userId` = '$imgid'");
	$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>ER_IMGRMV);
	
	redirect($base_url."profile/edit/#profile_");
?>
