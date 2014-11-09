<?php

// This is a simplified example, which doesn't cover security of uploaded files. 
// This example just demonstrate the logic behind the process.
require_once("../../includes/config.php");
$dir = '../../images/site/projectUpdateFiles/';
copy($_FILES['file']['tmp_name'], $dir.$_FILES['file']['name']);
					
$array = array(
	'filelink' => $base_url.'images/site/projectUpdateFiles/'.$_FILES['file']['name'],
	'filename' => $_FILES['file']['name']
);

echo stripslashes(json_encode($array));
	
?>