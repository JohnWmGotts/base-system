<?php

require_once("includes/config.php");
	// config starts session and connects to database
	// defines several global constants (e.g. SITE_URL) and vars (e.g. $con == db connection obj)
	// also requires once the validation class
	
class crAPI {

	var $method = null;
	var $sesstoken = null;
	var $userid = null;
	
	function processRequest() {
		// we can directly reference $_SESSION, $_REQUEST and defined vars set by config;
		global $con; // give access to open db connection object
		
		//wrtlog("API processRequest: ". print_r($_REQUEST,true));
		
		$resp = array();
		$no_login_required = array('cksession','login');
		$defined_methods = array('cksession','login','logout','projects','userinfo','pledge');
		/*
		// before rewrite
			/api/cksession/<b64_user_email>
			/api/login/<session_token>/<b64_user_email>/<b64_user_pwd>
			/api/logout/<session_token>
			/api/projects/<session_token>
			/api/userinfo/<session_token>
			/api/userinfo/<session_token>/<projectId>
			/api/pledge/<session_token>/<projectId>/<dollaramount>
		// after rewrite
			/api.php?a=<methodname>&b=<param1>[&c=<param2>[&d=<param3>]]
		*/
		$this->sesstoken = fct_session_token(); // from $_SESSION['token'] (may be gen'd new just now)
		$this->method = (isset($_REQUEST['a'])) ? $_REQUEST['a'] : '';
		if (empty($this->method) || !in_array($this->method,$defined_methods)) {
			$resp = array('completion' => 'NOK', 'error' => 'invalid method requested: '.$this->method);
			
		} else if (in_array($this->method,$no_login_required)) { 	// no logged in session required
			
			if ($this->method == 'cksession') {
				$user_email = base64_decode((isset($_REQUEST['b'])) ? $_REQUEST['b'] : '');
				$resp = $this->cksession($user_email);
			
			} else if ($this->method == 'login') {
				$_SESSION['pb6'] = '';
				$token = (isset($_REQUEST['b'])) ? $_REQUEST['b'] : '';
				$user_email = base64_decode((isset($_REQUEST['c'])) ? $_REQUEST['c'] : '');
				$user_pass = base64_decode((isset($_REQUEST['d'])) ? $_REQUEST['d'] : '');
				if (empty($user_email) || empty($user_pass)) {
					$resp = array('completion' => 'NOK', 'error' => 'missing required parameters');
				} else if ($token != $this->sesstoken) {
					$resp = array('completion' => 'NOK', 'error' => 'invalid session token');
				} else {
					$resp = $this->login($user_email,$user_pass);
				}
			} else {
				$resp = array('completion' => 'NOK', 'error' => 'requested method not yet hooked up');
			}
			
		} else { 													// logged in session required
			if ($this->method == 'logout') {
				session_destroy();
				$resp = array('completion' => 'OK');
			} else {
				$token = (isset($_REQUEST['b'])) ? $_REQUEST['b'] : '';
				if ($token != $this->sesstoken) {
					$resp = array('completion' => 'NOK', 'error' => 'invalid session token');
				} else {
					$this->userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : false;
					if (!$this->userid) {
						$resp = array('completion' => 'NOK', 'error' => 'no user id in session');
					} else {
						if ($this->method == 'projects') {
							$resp = $this->projects();
						} else if ($this->method == 'userinfo') {
							$projId = (isset($_REQUEST['c'])) ? $_REQUEST['c'] : ''; // may be null
							$resp = $this->userinfo($projId);
						} else if ($this->method == 'pledge') {
							$projId = (isset($_REQUEST['c'])) ? $_REQUEST['c'] : '';  
							$b64pwd = (isset($_REQUEST['d'])) ? $_REQUEST['d'] : '';
							$amount = (isset($_REQUEST['e'])) ? $_REQUEST['e'] : '';
							if (!is_numeric($projId)) {
								$resp = array('completion' => 'NOK', 'error' => 'missing valid project id');
							} else if (!is_numeric($amount) || ($amount <= 0)) {
								$resp = array('completion' => 'NOK', 'error' => 'missing valid pledge amount');
							} else if (!isset($_SESSION) || !isset($_SESSION['pb6']) || ($b64pwd != $_SESSION['pb6'])) {
								$resp = array('completion' => 'NOK', 'error' => 'password incorrect');
							} else {
								$resp = $this->pledge($projId,$amount);
							}
						} else {
							$resp = array('completion' => 'NOK', 'error' => 'requested method not yet hooked up.');
						}
					}
				}
			}
		}
		//wrtlog("API response: " . print_r($resp,true));
		
		//wrtlog(print_r($resp,true));
		header('Content-Type: application/json; charset=utf-8');
		$jsonResp = json_encode($resp);
		//wrtlog($jsonResp); // DEBUG
		return $jsonResp;
	}
	
    /**
     * cksession: A means to check session logged-in status and obtain a session token for the API
	 *
     * URL: http://<this site>/api/cksession/<b64_user_email>
     *
     * Returns an indication of session logged-in status and a session token:
     * 	'session' 'YES|NO'		 
     *  'token'   '<current-or-new-token>'
     *
     */

    function cksession($user_email)
    {
		global $con;
        $yes_or_no = 'NO';

        $qry1 = $con->recordselect("SELECT * FROM users WHERE emailAddress='".base64_encode($user_email)."' ");
        $tot_rec=mysql_num_rows($qry1);
        $valid_user=mysql_fetch_array($qry1);
        if ($tot_rec == 1) {
        	if ($valid_user['userId'] == fct_current_user_id()) {
        		$yes_or_no = 'YES';
        	}
		}
		$picpath = (!empty($valid_user['profilePicture'])) ? $valid_user['profilePicture'] : 'images/site/no_image.jpg';
        return array('session' => $yes_or_no, 'token' => $this->sesstoken, 'name' => $valid_user['name'], 'profilePicture' => SITE_URL.$picpath);
    }
        
    /**
     * login: A means to login for the API to be used in conjunction with cksession
     *
	 * URL: http://<this site>/api/login/<token>/<b64_user_email>
     *
	 * Returns an indication of session logged-in status
     * 	'OK' or failure message
     */

    function login($user_email, $user_pass)
    {
        global $con;

		$ok_or_failed = 'Failed';
		$_SESSION['pb6'] = '';
		$qry1=$con->recordselect("SELECT * FROM users WHERE emailAddress='".base64_encode($user_email)."' and password='".base64_encode($user_pass)."'");
        $tot_rec=mysql_num_rows($qry1);
        $valid_user=mysql_fetch_array($qry1);	 
		
	    if ($tot_rec == 0) {
			$ok_or_failed = 'Incorrect user email or password.';
	    } else {
		    // success!
			$_SESSION['userid'] = $valid_user['userId'];
			$_SESSION['token'] = $this->sesstoken;
			$ok_or_failed = 'OK'; // don't localize ... this means good completion. Anything else is an error message.
		}
		$picpath = (!empty($valid_user['profilePicture'])) ? $valid_user['profilePicture'] : 'images/site/no_image.jpg';
		$response_array = array('completion' => 'OK', 'name' => $valid_user['name'], 'profilePicture' => SITE_URL.$picpath);
        if ($ok_or_failed != 'OK') {
			$response_array = array('completion' => 'NOK', 'error' => $ok_or_failed);
		} else {
			$_SESSION['pb6'] = base64_encode($user_pass);
		}
		return $response_array;
    }
	
    /**
     * projects: 
     *
	 * URL: http://<this site>/api/projects/<token>
     *
	 * Returns list of project info for all published active running projects
     * 	
     */

    function projects()
    {
        global $con;
		$projects = array();
		$ok_or_failed = 'No projects currently accepted and running.';
		$today = time();
		//$sql = "SELECT * FROM projects as p, projectbasics as pb WHERE pb.fundingStatus='r' AND p.published=1 AND p.accepted=1 AND FROM_UNIXTIME(projectEnd,'%Y-%m-%d')<='".$today."' AND projectEnd!='0' AND projectEnd IS NOT NULL AND p.projectId=pb.projectId";
		//skip requirement for published and accepted and running for early testing
		$sql = "SELECT * FROM projects as p, projectbasics as pb WHERE pb.fundingStatus='r' AND projectStart <= ".$today." AND projectEnd >= ".$today." AND p.projectId=pb.projectId";
		if (isset($_REQUEST['test']) && ($_REQUEST['test'] == 1)) {
			$sql = "SELECT * FROM projects as p, projectbasics as pb WHERE p.published=1 AND p.accepted=0 AND pb.projectEnd > ".$today." AND p.projectId=pb.projectId";
		}
		$projects_r=$con->recordselect($sql);
		if(mysql_num_rows($projects_r)>0) {
			$ok_or_failed = 'OK';
			while($project=mysql_fetch_assoc($projects_r)) {
				$filtered = array();
				foreach($project as $key => $val) { // remove redundant array elements
					if (!is_numeric($key)) {			   // only leave those with key names
						if (in_array($key, array('fundingGoal','fundingStatus','projectCategory','projectEnd','projectId',
									'projectLocation','projectStart','projectTitle','shortBlurb',
									'userId','rewardedAmount'))) {
							if (($key == 'rewardedAmount') && ($val == '')) $val = 0; 
							$filtered[$key] = $val;
							if (($key == 'projectCategory')) {
								// also get project name
								if (is_numeric($val) && ($val > 0)) {
									$category_rec=mysql_fetch_array($con->recordselect("SELECT `categoryName` FROM `categories` WHERE categoryId = '".$val."'"));
									$filtered['categoryName'] = (is_array($category_rec) && array_key_exists('categoryName',$category_rec)) ? $category_rec['categoryName'] : '';
								} else {
									$filtered['categoryName'] = '';
								}
							}
						}	
					}
				}
				
				$qry1=$con->recordselect("SELECT * FROM `users` WHERE `userId` = ".$project['userId']." ");
				$valid_user=mysql_fetch_array($qry1);	
				$filtered['name'] = $valid_user['name'];
				$picpath = (!empty($valid_user['profilePicture'])) ? $valid_user['profilePicture'] : 'images/site/no_image.jpg';
				$filtered['profilePicture'] = SITE_URL.$picpath;
				
				$sql = "SELECT * FROM productimages WHERE projectId = ".$project['projectId']." AND approved = 1 ";
				$images_r=$con->recordselect($sql);
				$image_array = array();
				if(mysql_num_rows($images_r)>0) {
					while($image=mysql_fetch_assoc($images_r)) {
						$filename = DIR_FS.$image['image700by370'];
						list($width, $height) = getimagesize($filename); 
						$image_array[] = array('url' => SITE_URL.$image['image700by370'], 'width' => $width, 'height' => $height, 'isVideo' => $image['isVideo']);
					}
				}
				
				$sql = "SELECT * FROM projectstory WHERE projectId = ".$project['projectId']." ";
				$story_r=$con->recordselect($sql);
				if(mysql_num_rows($story_r)>0) {
					$story=mysql_fetch_assoc($story_r);
					if ($story['projectVideo']!='') {
						$image_array[] = array('url' => $story['projectVideo'], 'width' => '480', 'height' => '360', 'isVideo' => 1);
					}
				}
				$filtered['media'] = $image_array;
				array_push($projects,$filtered);
			}
		} 
	 
        if ($ok_or_failed != 'OK') {
			$response_array = array('completion' => 'NOK', 'error' => $ok_or_failed);
		} else {
			$response_array = array('completion' => 'OK', 'content' => $projects);
		}
		return $response_array;
    }	
	
    /**
     * userinfo: 
     *
	 * URL: http://<this site>/api/userinfo/<token>				 // get user info for logged-in user
	 * URL: http://<this site>/api/userinfo/<token>/<projectId>  // get user info for project owner
     *
	 * Returns user information
     * 	
     */

    function userinfo($projId)
    {
        global $con;
		$userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : null;
		if (is_numeric($projId)) {
			$sql = "SELECT * FROM projects as p, projectbasics as pb WHERE pb.fundingStatus='r' AND projectStart <= ".$today." AND projectEnd >= ".$today." AND p.projectId=$projId AND p.projectId=pb.projectId";
			$projects_r=$con->recordselect($sql);
			if(mysql_num_rows($projects_r)>0) {		
				$userId = p.userId;
			} else {
				$userId = null;
			}
		} else if (!empty($projId)) {
			$userId = null;
		}
		if (empty($userId)) {
			$response_array = array('completion' => 'NOK', 'error' => 'Unknown project Id');
		
		} else {
			$qry1=$con->recordselect("SELECT * FROM `users` WHERE `userId` = $userId ");
			$tot_rec=mysql_num_rows($qry1);
			$valid_user=mysql_fetch_array($qry1);	 
		 
			if ($tot_rec == 0) {
				$response_array = array('completion' => 'NOK', 'error' => 'User not found');
				
			} else {
				foreach($valid_user as $key => $val) { // remove redundant array elements
					if (is_numeric($key)) {			   // only leave those with key names
						unset($valid_user[$key]);
					} 
				}
				if ($valid_user['userId'] != $_SESSION['userid']) { // if requested user is not logged in user
					foreach ($valid_user as $key => $val) {			// remove private array elements
						if (!array_key_exists($key,array('name','timezone','biography','profilePicture',
							'profilePicture100_100','profilePicture40_40','profilePicture80_80','profilePicture80_60',
							'userLocation'))) {
							unset($valid_user[$key]);
						}
					}				
				} else {
					foreach ($valid_user as $key => $val) {			// filter returned elements
						if (!array_key_exists($key,array('name','timezone','biography','profilePicture',
							'profilePicture100_100','profilePicture40_40','profilePicture80_80','profilePicture80_60',
							'userLocation','newsletter','lanuchProjectNotify','newFollower','updatesNotifyBackedProject',
							'createdProjectComment','pledgeMail'))) {
							unset($valid_user[$key]);
						}
					}
				}
				$response_array = array('completion' => 'OK', 'content' => $valid_user);
			}
		}
		return $response_array;
    }	
	
   /**
     * pledge: 
     *
	 * URL: http://<this site>/api/pledge/<token>/<dollaramount>
     *
	 * Make a monetary pledge to support a project's funding goal	 
     * 	
	 * Returns confirmation and extended info about how/when pledged $$ are paid
	 * 
     */

    function pledge($projectId,$amount)
    {
        global $con;
		$projects = array();
		$ok_or_failed = 'Project can not currently accept pledge.';
		$today = time();
		//$sql = "SELECT * FROM projects as p, projectbasics as pb WHERE pb.fundingStatus='r' AND p.published=1 AND p.accepted=1 AND FROM_UNIXTIME(projectEnd,'%Y-%m-%d')<='".$today."' AND projectEnd!='0' AND projectEnd IS NOT NULL AND p.projectId=pb.projectId");
		$sql = "SELECT * FROM projects as p, projectbasics as pb WHERE p.projectId = $projectId AND p.accepted=1 AND pb.fundingStatus='r' AND projectStart <= ".$today." AND projectEnd >= ".$today." AND p.projectId=pb.projectId";
		$projects_r=$con->recordselect($sql);
		if(mysql_num_rows($projects_r)>0) {
			$project = mysql_fetch_assoc($projects_r);
		
			// ADD FURTHER TESTS ON RESPONSE HERE
			// to shorten reply for mobile -- OR -- let behind-scenes processing do it -- TBD
			// want something like following....
			// response: {"completion":"OK","content":[{"projectId":"1","receipt":"Thank you for your pledge of $nnn. We have sent you an email to explain how pledges are held and processed."}]}
		
		
			$ok_or_failed = 'OK';			
			
			
		} 
	 
        if ($ok_or_failed != 'OK') {
			$response_array = array('completion' => 'NOK', 'error' => $ok_or_failed);
		} else {
			$response_array = array('completion' => 'OK', 'content' => $projects);
		}
		return $response_array;
    }		
	
 
} /* end of crAPI class definition */
	
	$api = new crAPI();
	echo $api->processRequest();	
		
?>