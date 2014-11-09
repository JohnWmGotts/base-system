<?php
	/* 
	*	rollback_updates.php?d=yyyymmdd-hhmm&p=<password>      
	* expects /updates/yyyymmdd-hhmm to exist   
	* expects files updated to have backup versions --.yyyymmdd-hhmm.bak     
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
	$logpath = $sitepath.'backups/history.log';
	if (!file_exists($logpath)) {
		$logfile = fopen($logpath, 'w');
		fclose($logfile);
		chmod($logpath,0777);
	} 	
	$logfile = fopen($logpath, 'a');
	
	$updatepath = $sitepath.'updates/'.$target;
	$intentpath = $sitepath;
	
	fwrite($logfile,getTimeStamp()."-----BEGIN ROLLBACK $target ----------------\n");
	if (substr($intentpath,-1,1) == '/') $intentpath = substr($intentpath,0,strlen($intentpath)-1);
	$rc = _rollback_fini($logfile,$target,$updatepath,$intentpath);
	if (!$rc) {
		$msg = "ROLLBACK FAILED.";
		echo $msg.'<br/>';
		fwrite($logfile,getTimeStamp().$msg."\n");		
		fclose($logfile);
		exit;
	}	
	
	// remove backup folder
	rmdir_recursive($sitepath.'backups/'.$target);		
	
	$msg = "ROLLBACK COMPLETED SUCCESSFULLY.";
	echo $msg.'<br/>';
	fwrite($logfile,getTimeStamp().$msg."\n");		
	fclose($logfile);
	
/* --------------------------------------------------- */
	
function rmdir_recursive($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if (($file == '.') || ($file == '..')) continue;
        if (is_dir($dir.'/'.$file)) {
            rmdir_recursive($dir.'/'.$file);
            if (file_exists($dir.'/'.$file)) {
            	rmdir($dir.'/'.$file);
            }
        } else {
        		if (file_exists($dir.'/'.$file)) {
            	unlink($dir.'/'.$file);
            }
        }
    }
    rmdir($dir);
}
	
function _rollback_fini($logfile,$target,$updatepath,$intentpath) {
	if ($handle = opendir($updatepath)) {
  	while (false !== ($file = readdir($handle))) {
    	if ($file != "." && $file != "..") {
				if (is_dir($updatepath.'/'.$file)) {
					$rc = _rollback_fini($logfile,$target,$updatepath.'/'.$file,$intentpath.'/'.$file);
					// don't log outcome at dir level in rollback .. continue
					
				} else {
					// process file prep
					$install_target = $intentpath.'/'.$file;
					
					//$install_backup = $install_target.'.'.$target.'.bak'; // no longer use immediate backup from install folder.. 
					$install_backup = str_replace('/updates/','/backups/',$updatepath.'/'.$file); // use original from backups folder
					
					if (!file_exists($install_backup)) {
						$msg = "ROLLBACK Backup File Not Found: $install_backup";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
						continue;
					}
					if (file_exists($install_target)) {
						unlink($install_target);
					}
					//$rc = rename($install_backup,$install_target); // no longer use immediate backup from install folder
					$rc = copy($install_backup, $install_target); // restore original from backups folder 
					
					if (!$rc) {
						//$msg = "ROLLBACK FAILED File Not Renamed: $install_backup to $install_target";
						$msg = "ROLLBACK FAILED File Not Copied: $install_backup to $install_target";
						echo $msg.'<br/>';
						fwrite($logfile,getTimeStamp().$msg."\n");
					} else {
						$msg = "restored> $install_target";
						fwrite($logfile,getTimeStamp().$msg."\n");
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
	return 	date('Y-m-d H:i:s').': ';
}	
	
?>