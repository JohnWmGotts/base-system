<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	require_once(DIR_TMP."content/sitesDefault/head.tpl.php");
	require_once(DIR_TMP."content/sitesDefault/header.tpl.php");
	require_once(DIR_TMP."content/sitesDefault/content.tpl.php");
	require_once(DIR_TMP."content/sitesDefault/footer.tpl.php");
	if(isset($footer_space) && ($footer_space == 1)){
		echo '<div class="space90"></div>';
	}
?>
