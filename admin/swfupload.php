<?php
	// Work-around for setting up a session because Flash Player doesn't send the cookies
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}
	//session_start(); // jwg fixup
	if (version_compare(phpversion(), '5.4.0', '<')) { if(session_id() == '') session_start(); } 
	else { if (session_status() == PHP_SESSION_NONE) session_start(); }

	// The Demos don't save files
	
	exit(0);
?>