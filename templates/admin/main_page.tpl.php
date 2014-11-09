<?php
	$file=basename($_SERVER['PHP_SELF']);
	require_once(DIR_ADM."header.php");
	require_once(DIR_ADM_CONT.$content.".tpl.php");
	require_once(DIR_ADM."footer.php");
?>