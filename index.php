<?php require "includes/config.php";

	if ($prelaunch) {
		if (!isset($_SESSION['userId']) || ($_SESSION['userId'] == '')) 
			redirect(SITE_URL); // jwg
		
		$qry1=$con->recordselect("SELECT * FROM users WHERE `userId` = ".$_SESSION['userId']." ");
        $valid_user=mysql_fetch_array($qry1);
		if ($valid_user['siteAccess'] != 1) 
			redirect(SITE_URL); 
	}

	$content='sitesDefault/contentRight';
	$title = "home";
    require_once("templates/main_page.tpl.php");
?>