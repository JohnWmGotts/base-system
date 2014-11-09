<?php
	require_once("../../includes/config.php");
	$con->update("UPDATE users SET status=0 WHERE userId='".$_SESSION["userId"]."' AND name='".$_SESSION["name"]."'");
    $_SESSION["userId"]="";
	$_SESSION["name"]="";
	$_SESSION["msgType"]="";
	$_SESSION['User']='';
	if(isset($_SESSION["admin_id"]) || isset($_SESSION["admin_user"]) || isset($_SESSION["admin_role"])){
		 
	}else{
		session_destroy();
	}
	//$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Please login to access this page.');
		
	redirect(SITE_URL."login");
?>
