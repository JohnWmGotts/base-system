<?php
	// This script accepts an ID and looks in the user's session for stored thumbnail data.
	// It then streams the data to the browser as an image
	
	// Work around the Flash Player Cookie Bug
	/*if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}
	
	session_start();
	
	$image_id = isset($_GET["id"]) ? $_GET["id"] : false;
	

	header("Content-type: image/jpeg") ;
	header("Content-Length: ".strlen($_SESSION["file_info"][$image_id]));
	echo $_SESSION["file_info"][$image_id];
	exit(0);*/
	echo "FILEID:".$base_url."".DISPLAYSITENAME."/images/logo.png";
?>