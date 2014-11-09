<?php
		
	global $PayPalConfig;
	// site name
	define('DISPLAYSITENAME','CrowdedRocket');		
	$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http'; 
	define('SITE_URL',$http.'://crowdedrocket.com/');
	define('DIR_FS',$_SERVER['DOCUMENT_ROOT'].'/crowdedrocket/');
	$db_host="crowdedrocket.db.9407803.hostedresource.com";
	$db_name="crowdedrocket";		
	$db_user="crowdedrocket";
	$db_pass="A1nDj2Jj3!";
	$prelaunch = true; ////// CHANGE THIS AT LAUNCH //////
	
function full_url()
{
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
    $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}
function wrtlog($msg,$type=3,$dest=null) {
	$destfile = DIR_FS.'/logs/process.log';
	if (!empty($dest)) $destfile = $dest;
	if ($type == 3) $dest = $destfile;
    $ip = '---.---.---.---';	// jwg 2010-07-29 also show IP of user
    if (isset($_SERVER) && isset($_SERVER["REMOTE_ADDR"])) {
			$ip = $_SERVER["REMOTE_ADDR"];
	}        
    if (!is_string($msg)) {
    	$logline = date('Y-m-d H:i:s') . ' '.$ip.' ' . ': ' . print_r($msg,true) . "\n";  
    } else {                                  
    	$logline = date('Y-m-d H:i:s') . ' '.$ip.' ' . ': ' . $msg . "\n";
	}
	error_log($logline,$type,$dest);
}
function my_handler ($number, $message, $file, $line) { // jwg
//	echo 'The following error occurred, allegedly on line ' . $line . ' of file ' . $file . ': ' . $message . ' <br/>';
//	echo 'The existing variables are:' . print_r($GLOBALS, 1) . '';
	wrtlog ("ERROR EXIT: line $line of $file - $message");
	echo '<div style="width:100%;textalign:center;"><table width="80%"><tr><td>There was an error processing your request. See log.</td></tr></table>';
	exit;
}

	$actual_link = full_url();
	$need_trace = false;
	if (version_compare(phpversion(), '5.4.0', '<')) { if(session_id() == '') session_start(); else $need_trace = true; } 
	else { if (session_status() == PHP_SESSION_NONE) session_start(); else $need_trace = true; }
	
	set_time_limit(0);
	//error_reporting( E_ALL ); // (0) for no reporting
	//set_error_handler('my_handler', E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR ); // standard 
	set_error_handler('my_handler', E_ALL & ~E_STRICT);  // debug mode		

	define('SITE_CSS',SITE_URL.'css/');
	define('SITE_IMG',SITE_URL.'images/');
	define('SITE_IMG_SITE',SITE_IMG.'site/');
	define('SITE_JS',SITE_URL.'js/');
	define('SITE_CKE',SITE_URL.'includes/ckeditor/');
	define('SITE_MOD',SITE_URL.'modules/');
	// Define Admin URL
	define('SITE_MOD_USER',SITE_MOD.'user/');
	define('SITE_MOD_BROWSE',SITE_MOD.'browse/');
	define('SITE_ADM',SITE_URL.'admin/');
	define('SITE_ADM_IMG',SITE_IMG.'admin/');
	define('SITE_JAVA',SITE_URL.'includes/javascript/');
	
	define('DIR_INC',DIR_FS.'includes/');
	define('DIR_JS',DIR_INC.'javascript/');
	define('DIR_FUN',DIR_INC.'functions/');
	define('DIR_IMG',DIR_FS.'images/');
	define('DIR_SITE',DIR_IMG.'site/');
	define('DIR_TMP',DIR_FS.'templates/');
	define('DIR_CONT',DIR_TMP.'content/');
	define('DIR_MOD',DIR_FS.'modules/');
	define('DIR_MOD_USER',DIR_MOD.'user/');
	define('DIR_MOD_TMP_USER',DIR_CONT.'user/');
	define('DIR_CSS',DIR_FS.'css/');
	// USER VARIABLES
    define('DIR_WS_CLASSES',DIR_INC.'classes/');
	// Define Admin Directory
	define('DIR_ADM',DIR_FS.'admin/');
	define('DIR_ADM_TMP',DIR_TMP.'admin/');
	define('DIR_ADM_CONT',DIR_ADM_TMP.'content/');
	define('DIR_AMD_IMG',DIR_IMG.'admin/');

	define('DIR_UPLOAD',DIR_FS.'uploads/'); // jwg
	
	require "functions/functions.php";

	$base_url = SITE_URL;
	
	if ($need_trace) {
		fct_show_trace(debug_backtrace(),"backtrace");
	}
	
	//wrtlog($_SERVER);
	
	$login_url = $base_url."login";
	$c_url=get_url();
	$fb_login_require = false;
	$fb_createProject_Id = 0;
	$fb_bio_set = false;
	
	if (!isset($_SESSION['userId'])) $_SESSION['userId'] = "";
	if (!isset($_SESSION['name'])) $_SESSION['name'] = "";

	if($c_url!=$login_url){
		//wrtlog("incoming url=".$c_url);
		if (strpos($c_url,'redirUrl=') !== false) { 
			$x = strpos($c_url,'redirUrl=');
			$c_url = urldecode(substr($c_url,$x+9));
		} else if (isset($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'],'redirUrl=') !== false)) {
			if (substr($c_url,-15,15) == 'loginsignup.php') { // dealing (likely) with posted login form
				$x = strpos($_SERVER['HTTP_REFERER'],'redirUrl=');
				$c_url = urldecode(substr($_SERVER['HTTP_REFERER'],$x+9));
			}
		}
		if (strpos($login_url,'?') >0){
			$login_url.= "&parentUrl=".$c_url;
		}
		else{
			$login_url.= "?parentUrl=".$c_url;
		}
		//wrtlog("new login url=$login_url");
		//wrtlog("-------------------------------------");
	}
	/*echo "<script type='text/javascript'>var application_path='$base_url';</script>";*/
	require_once(DIR_FUN.'dbconn.php');	
	global $con;
	$con = new DBconn();
	$con->connect($db_host,$db_name,$db_user,$db_pass);

	// Front side panel variable declare
	$left_panel=true;
	$right_panel=true;
	$cont_mid_cl='';// If both panel false then '-100' value OR If only one panel false then '-75' value
	//require_once(DIR_INC.'db_const.php');
	require_once(DIR_FUN.'validation.class.php');
	require_once(DIR_INC."adminmessage.php");
	//require_once(DIR_FUN.'function.php');
	

?>