<?php
	/* 
	*	install_updates.php?d=yyyymmdd-hhmm      
	* expects /updates/yyyymmdd-hhmm to exist  
	* rejects if /backups/yyyymmdd-hhmm exists 
	* to rollback use                          
	* rollback_updates.php?d=yyyymmdd-hhmm&p=pw     
	*
	*/
	
	date_default_timezone_set('UTC');
	
	$target = (isset($_REQUEST['d'])) ? $_REQUEST['d'] : null;
	if (empty($target) || !preg_match('#^\d{8}-\d{4}$#',$target)) {
		echo "INVALID OR MISSING PARAMETER";
		exit;
	}
	if (!isset($_REQUEST['p']) || ($_REQUEST['p'] != '1nDj2Jj3!!')) {
		echo "MISSING REQUIRED PARAMETER";
		exit;
	}
	$sitepath = dirname(__FILE__); // assumes we are in lib folder
	if (substr($sitepath,-1,1) != '/') $sitepath .= '/';
	if (!file_exists($sitepath.'updates/'.$target)) {
		echo "UPDATES FOLDER NOT FOUND: ".$sitepath.'updates/'.$target;
		exit;
	}
	if (file_exists($sitepath.'backups/'.$target)) {
		echo "BACKUP FOLDER STILL PRESENT. DO ROLLBACK, OR MANUALLY REMOVE ".$sitepath.'backups/'.$target;
		exit;
	}
	if (!mkdir($sitepath.'backups/'.$target)) {
		echo "UPDATES BACKUP FOLDER COULD NOT BE CREATED.";
		exit;	
	}
	$logpath = $sitepath.'backups/history.log';
	if (!file_exists($logpath)) {
		$logfile = fopen($logpath, 'w');
		fclose($logfile);
		chmod($logpath,0777);
	} 	
	$logfile = fopen($logpath, 'a');
	
	$updatepath = $sitepath.'updates/'.$target;
	$backuppath = $sitepath.'backups/'.$target;
	$intentpath = $sitepath;
	fwrite($logfile,getTimeStamp()."-----BEGIN $target ----------------\n");
	if (substr($intentpath,-1,1) == '/') $intentpath = substr($intentpath,0,strlen($intentpath)-1);
	$rc = _install_prep($logfile,$target,$updatepath,$intentpath,$backuppath);	
	if (!$rc) {
		$msg = "UPDATES FAILED DURING INSTALL PREP.";
		echo $msg.'<br/>';
		fwrite($logfile,getTimeStamp().$msg."\n");		
		fclose($logfile);
		exit;
	}
	$msg = "PREPARE PHASE SUCCESSFUL";
	echo $msg.'<br/>';
	fwrite($logfile,getTimeStamp().$msg."\n");
	$rc = _install_check($logfile,$target,$updatepath,$intentpath,$backuppath);
	if (!$rc) {
		$msg = "UPDATES FAILED DURING INSTALL CHECK.";
		echo $msg.'<br/>';
		fwrite($logfile,getTimeStamp().$msg."\n");		
		fclose($logfile);
		exit;
	}	
	$msg = "CHECK PHASE SUCCESSFUL";
	echo $msg.'<br/>';
	fwrite($logfile,getTimeStamp().$msg."\n");
	$rc = _install_fini($logfile,$target,$updatepath,$intentpath,$backuppath);
	if (!$rc) {
		$msg = "UPDATES FAILED DURING INSTALL FINISH.";
		echo $msg.'<br/>';
		fwrite($logfile,getTimeStamp().$msg."\n");		
		fclose($logfile);
		exit;
	}	
	$msg = "UPDATES COMPLETED SUCCESSFULLY.";
	echo $msg.'<br/>';
	fwrite($logfile,getTimeStamp().$msg."\n");		
	fclose($logfile);
	
/* --------------------------------------------------- */

function _install_prep($logfile,$target,$updatepath,$intentpath,$backuppath) {
	if ($handle = opendir($updatepath)) {
  	while (false !== ($file = readdir($handle))) {
    	if ($file != "." && $file != "..") {
				if (is_dir($updatepath.'/'.$file)) {
					if (!file_exists($intentpath.'/'.$file)) {
						$rc = mkdir($intentpath.'/'.$file, 0777);
						if (!$rc) {
							$msg = "UPDATES FAILED CREATING DIR $intentpath/$file";
							echo $msg.'<br/>';
							fwrite($logfile,getTimeStamp().$msg."\n");
							closedir($handle);
							return false; 
						}
					}
					if (!file_exists($backuppath.'/'.$file)) {
						$rc = mkdir($backuppath.'/'.$file, 0777);
						if (!$rc) {
							$msg = "UPDATES FAILED CREATING DIR $backuppath/$file";
							echo $msg.'<br/>';
							fwrite($logfile,getTimeStamp().$msg."\n");
							closedir($handle);
							return false; 
						}						
					}
					$rc = _install_prep($logfile,$target,$updatepath.'/'.$file,$intentpath.'/'.$file,$backuppath.'/'.$file);
					if (!$rc) {
						$msg = "UPDATES FAILED PREPARING INSTALL FOR DIR $updatepath/$file";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
						closedir($handle);
						return false; 
					}
				} else {
					// process file prep
					$temptarget = $intentpath.'/'.$file.'.'.$target.'.new';
					if (file_exists($temptarget)) {
						unlink($temptarget); 
					}
					if (copy($updatepath.'/'.$file, $temptarget)) {
						//if (!copy($updatepath.'/'.$file, $backuppath.'/'.$file)) {
						// backup the OLD file .. not the new update !!
						if (file_exists($intentpath.'/'.$file) && !copy($intentpath.'/'.$file, $backuppath.'/'.$file)) {
							$msg = "COULD NOT COPY OLD FILE TO ".$backuppath.'/'.$file;
							echo $msg.'<br/>';
							fwrite($logfile,getTimeStamp().$msg."\n");
							closedir($handle);
							return false; 	
						}
					} else {
						$msg = "COULD NOT COPY PREP FILE TO $temptarget";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
						closedir($handle);
						return false; 
					}
				}
   		}
 		}
 		closedir($handle);
 		return true;
	} else {
		$msg = "COULD NOT OPEN UPDATES SUBFOLDER";
		echo $msg;
		fwrite($logfile,getTimeStamp().$msg."\n");
		return false;
	}
}
	
function _install_check($logfile,$target,$updatepath,$intentpath,$backuppath) {
	if ($handle = opendir($updatepath)) {
  	while (false !== ($file = readdir($handle))) {
    	if ($file != "." && $file != "..") {
				if (is_dir($updatepath.'/'.$file)) {
					$rc = _install_check($logfile,$target,$updatepath.'/'.$file,$intentpath.'/'.$file,$backuppath.'/'.$file);
					if (!$rc) {
						$msg = "UPDATES FAILED DURING CHECK PHASE FOR DIR $intentpath/$file";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
						closedir($handle);
						return false; 
					}
				} else {
					// process file prep
					$temptarget = $intentpath.'/'.$file.'.'.$target.'.new';
					if (!file_exists($temptarget)) {
						$msg = "UPDATES FAILED DURING CHECK PHASE File Not Found: $intentpath/$file";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
						closedir($handle);
						return false; 
					}
				}
   		}
 		}
 		closedir($handle);
 		return true;
	} else {
		$msg = "COULD NOT OPEN UPDATES SUBFOLDER FOR CHECK";
		echo $msg;
		fwrite($logfile,getTimeStamp().$msg."\n");
		return false;
	}
}	
	
function _install_fini($logfile,$target,$updatepath,$intentpath,$backuppath) {
	if ($handle = opendir($updatepath)) {
		// like CHECK phase, except does the final backups and renames
  	while (false !== ($file = readdir($handle))) {
    	if ($file != "." && $file != "..") {
				if (is_dir($updatepath.'/'.$file)) {
					$rc = _install_fini($logfile,$target,$updatepath.'/'.$file,$intentpath.'/'.$file,$backuppath.'/'.$file);
					if (!$rc) {
						$msg = "UPDATES FAILED DURING FINISH PHASE FOR DIR $intentpath/$file";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
						closedir($handle);
						return false; 
					}
				} else {
					// process file prep
					$temptarget = $intentpath.'/'.$file.'.'.$target.'.new';
					if (!file_exists($temptarget)) {
						$msg = "UPDATES FAILED DURING FINISH PHASE File Not Found: $temptarget";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
						closedir($handle);
						return false; 
					}
					$install_target = $intentpath.'/'.$file;
					$install_backup = $install_target.'.'.$target.'.bak';
					if (file_exists($install_backup)) {
						unlink($install_backup);
					}
					$havebkup = false;
					if (file_exists($install_target)) {
						rename($install_target,$install_backup);
						$havebkup = true;
					}
					
					/*
					if (file_exists($install_target)) {
						echo "$install_target still exists -- not renamed <br/>";
						return false;
					} else {
						echo "$install_target was renamed to $install_backup <br/>";
					}
					*/
					
					
					$rc = rename($temptarget,$install_target);
					if ($rc) {
						$msg = "Updated> $install_target";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
						if ($havebkup) {
							unlink($install_backup); // remove temp .bak file if renamed ok
						}	
					} else {
						$msg = "UPDATES FAILED DURING FINISH PHASE File Not Renamed: $temptarget to $install_target";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
						$msg = "UPDATES RECOVERING BACKUP FILE: $install_backup";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
						$rc = rename($install_backup,$install_target);
						if (!$rc) {
							$msg = "UPDATES UNABLE TO RESTORE BACKUP FILE DURING FINISH: $install_backup";
							echo $msg.'<br/>';
							fwrite($logfile,getTimeStamp().$msg."\n");
						} else {
							$msg = "updated> $install_target";
							fwrite($logfile,getTimeStamp().$msg."\n");						
						}
						$msg = "REVIEW EXTENT OF INSTALL!!!";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");	
						closedir($handle);
						return false; 
					}
				}
   		}
 		}
 		closedir($handle);
 		return true;
	} else {
		$msg = "COULD NOT OPEN UPDATES SUBFOLDER FOR FINISH PHASE";
		echo $msg.'<br/>';
		fwrite($logfile,getTimeStamp().$msg."\n");
		return false;
	}
}		
	
function getTimeStamp() {
	return 	date('Y-m-d H:i:s',time()).': ';
}	
	
?>