<?php
	require_once("../includes/config.php");
	
	$projectId=$_GET['projectId'];
	$adminId=$_GET['adminid'];
	//print "SELECT * FROM `projects` WHERE projectId = '".$projectId."'";echo '</br>';
	$userId_qry=mysql_fetch_array($con->recordselect("SELECT * FROM `projects` WHERE projectId = '".$projectId."'"));
	$userId=$userId_qry['userId'];
	//$con->insert("INSERT INTO staffpicks (staffpicks_id, projectId, userId, adminId, status) VALUES
	//(NULL, '$projectId', '$userId', '$adminId', 1)");
	//print "SELECT * FROM `staffpicks` WHERE projectId = '".$projectId."'";echo '</br>';
	$already_exist=$con->recordselect("SELECT * FROM `staffpicks` WHERE projectId = '".$projectId."'");
	if(mysql_num_rows($already_exist)>0) {
		$already_exist_status=mysql_fetch_array($already_exist);
		$already_exist_status1=$already_exist_status['status'];
		if($already_exist_status['status']==1) {
			//print "UPDATE staffpicks SET status=0 WHERE projectId = '".$projectId."'";
			$con->update("UPDATE staffpicks SET status=0 WHERE projectId = '".$projectId."'");
		} else {
			
			$con->update("UPDATE staffpicks SET status=1, adminId='".$adminId."' WHERE projectId = '".$projectId."'");
		}	
	} else {
		$con->insert("INSERT INTO staffpicks (staffpicks_id, projectId, userId, adminId, status) VALUES
		(NULL, '$projectId', '$userId', '$adminId', 1)");
	}

?>
<?php /*?><?php
require_once("../includes/config.php");

		$projectId=$_GET['projectId'];
		$adminId=$_GET['adminid'];
		
		$userId_qry=mysql_fetch_array($con->recordselect("SELECT * FROM `projects` WHERE projectId = '".$projectId."'"));
		$userId=$userId_qry['userId'];
		
		$already_exist=$con->recordselect("SELECT * FROM `staffpicks` WHERE projectId = '".$projectId."' and adminId='".$adminId."'");
        if(mysql_num_rows($already_exist)>0)
		{
			$already_exist_status=mysql_fetch_array($already_exist);
			$already_exist_status1=$already_exist_status['status'];
			if($already_exist_status['status']==1) {
				$con->update("UPDATE staffpicks SET status=0 WHERE projectId = '".$projectId."' and adminId='".$adminId."'");
			}else{
				$con->update("UPDATE staffpicks SET status=1 WHERE projectId = '".$projectId."' and adminId='".$adminId."'");
			}
		}
		else{
			if($_SESSION['admin_role'] == -1) {
				
				$already_exist=$con->recordselect("SELECT * FROM `staffpicks` WHERE projectId = '".$projectId."'");
				if(mysql_num_rows($already_exist)>0){
					$already_exist_status=mysql_fetch_array($already_exist);
					$already_exist_status1=$already_exist_status['status'];
					
					if($already_exist_status1 == 1 && $_SESSION['admin_id'] != $already_exist_status['adminId']){
						$con->update("UPDATE staffpicks SET status=0 WHERE projectId = '".$projectId."'");
					}
					if($already_exist_status1 == 0 && $_SESSION['admin_id'] != $already_exist_status['adminId']){
						$con->update("UPDATE staffpicks SET status=1 WHERE projectId = '".$projectId."'");
					}
					
				}else{
					$con->insert("INSERT INTO staffpicks (staffpicks_id, projectId, userId, adminId, status) VALUES
				   (NULL, '".$projectId."', '".$userId."', '".$adminId."', 1)");
				}
			}else{
				$con->insert("INSERT INTO staffpicks (staffpicks_id, projectId, userId, adminId, status) VALUES
				   (NULL, '".$projectId."', '".$userId."', '".$adminId."', 1)");
			}
		}		
?><?php */?>