<?php
	require_once("../../includes/config.php");
	if($_SESSION["userId"]=="" and $_POST['sitename']=="")
	{
        header('Location: ../../index.php');
  	}
	
  	$siteid=sanitize_string(urldecode($_POST['sitename']));
	$userid=$_SESSION['userId'];
	
	if($siteid!='' && $userid!='')
	{
		$insert = $con->insert("INSERT INTO userwebsites(`siteUrl`, `userId`) values ('".$siteid."',$userid)");
		$insertedId = mysql_insert_id();
	}
	?>
    <div id="websitesProfile<?php echo $insertedId;?>"><?php echo $siteid; ?>
    	<span><img src="<?php echo $base_url;?>images/delete.png" border="0" onclick="return siteDelete('<?php echo $insertedId;?>')"/></span>
    </div><br/>
	
