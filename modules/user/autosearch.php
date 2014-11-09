<?php

	require_once("../../includes/config.php");

if($_REQUEST["field"]!='')
{
	$qry = $con->recordselect("select * from users WHERE activated	='1'");
	
		while($row = mysql_fetch_array($qry)) {
			$emailAddress = base64_decode($row['emailAddress']);
			if (strpos($emailAddress,$_REQUEST["field"]) !== false) {
				$result[] = $emailAddress;
			}
			
			
		}
		
				
	
	echo json_encode($result);
}else
{
	header('location:'.SITE_URL);
}
?>