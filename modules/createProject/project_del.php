<?php
	if (!isset($uid) || !isset($projectId) || !isset($projectStatus)) {
		wrtlog("createProject/project_del.php called w/o required set vars");
		$error = 'Unexpected error';
	} else if ($projectStatus['published'] != 0) {
		wrtlog("createProject/project_del.php called for published project");
		$error = 'You can only delete a project before it is published.';
	} else {
		$con->delete("DELETE FROM projects WHERE projectId='".$projectId."'");
		$con->delete("DELETE FROM projectstory WHERE projectId='".$projectId."'");
		$con->delete("DELETE FROM projectupdate WHERE projectId='".$projectId."'");
		$con->delete("DELETE FROM projectupdatecomment WHERE projectId='".$projectId."'");
		$con->delete("DELETE FROM staffpicks WHERE projectId='".$projectId."'");
		$con->delete("DELETE FROM usermessages WHERE projectId='".$projectId."'");
		$con->delete("DELETE FROM paypaltransaction WHERE projectId='".$projectId."'");
		$error = 'Project deleted';
		redirect($base_url);
	}
?>