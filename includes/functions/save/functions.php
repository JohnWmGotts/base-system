<?php 
require_once(DIR_INC.'paypal/config.php');
require_once(DIR_INC.'paypal/paypal.class.php');
require (DIR_INC."paypal/payment.class.php");
function array_sort_by_column1(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
function _print_r($val) {
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}
function addQuotes($str){
    return "'$str'";
}
function roundDays($day){
	return ceil($day);
}
function Slug($string)
{
    return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
}
function SlugMailSubject($string)
{
    return (trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
}
function escapeSearchString($srch)
{
    if (is_object($srch)) {
        $res = new stdClass();
        foreach ($srch as $k => $v) {
            $res->$k = trim(mysql_real_escape_string(str_replace(array(
                '_',
                '%'
            ), array(
                '\_',
                '\%'
            ), $v)));
        }
    } else {
        $res = trim(mysql_real_escape_string(str_replace(array(
            '_',
            '%'
        ), array(
            '\_',
            '\%'
        ), $srch)));
    }
    return $res;
}
//function for retrieving url 
function get_url($show_port = false)
{
	if(isset($_SERVER['HTTPS']))
	{
		$my_url = 'https://';
	}
	else
	{
		$my_url = 'http://';
	}

	$my_url .= $_SERVER['HTTP_HOST'];

	if($show_port)
	{
		$my_url .= ':' . $_SERVER['SERVER_PORT'];
	}

	$my_url .= $_SERVER['SCRIPT_NAME'];

	if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != NULL)
	{    
		$my_url .= '?' . $_SERVER['QUERY_STRING'];
	}
	return $my_url;
}
//end		
//function for getting date for day,month & year differance
function datediff($interval, $datefrom, $dateto, $using_timestamps = false)
{
  /*
    $interval can be:
    yyyy - Number of full years
    q - Number of full quarters
    m - Number of full months
    y - Difference between day numbers
      (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
    d - Number of full days
    w - Number of full weekdays
    ww - Number of full weeks
    h - Number of full hours
    n - Number of full minutes
    s - Number of full seconds (default)
  */
    
  if (!$using_timestamps) {
    $datefrom = strtotime($datefrom, 0);
    $dateto = strtotime($dateto, 0);
  }
  $difference = $dateto - $datefrom; // Difference in seconds
   
  switch($interval) {
   
    case 'yyyy': // Number of full years

      $years_difference = floor($difference / 31536000);
      if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
        $years_difference--;
      }
      if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
        $years_difference++;
      }
      $datediff = $years_difference;
      break;

    case "q": // Number of full quarters

      $quarters_difference = floor($difference / 8035200);
      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
        $months_difference++;
      }
      $quarters_difference--;
      $datediff = $quarters_difference;
      break;

    case "m": // Number of full months
      $months_difference = floor($difference / 2678400);
      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
        $months_difference++;
      }
      $months_difference--;
      $datediff = $months_difference;
      break;

    case 'y': // Difference between day numbers

      $datediff = date("z", $dateto) - date("z", $datefrom);
      break;

    case "d": // Number of full days

      $datediff = floor($difference / 86400);
      break;

    case "w": // Number of full weekdays

      $days_difference = floor($difference / 86400);
      $weeks_difference = floor($days_difference / 7); // Complete weeks
      $first_day = date("w", $datefrom);
      $days_remainder = floor($days_difference % 7);
      $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
      if ($odd_days > 7) { // Sunday
        $days_remainder--;
      }
      if ($odd_days > 6) { // Saturday
        $days_remainder--;
      }
      $datediff = ($weeks_difference * 5) + $days_remainder;
      break;

    case "ww": // Number of full weeks

      $datediff = floor($difference / 604800);
      break;

    case "h": // Number of full hours

      $datediff = floor($difference / 3600);
      break;

    case "n": // Number of full minutes

      $datediff = floor($difference / 60);
      break;

    default: // Number of full seconds (default)

      $datediff = $difference;
      break;
  }

  return $datediff;
}
//end

//function for calculationg date time diff for recent visitor
function timeDiff($firstTime,$lastTime)
{
	// convert to unix timestamps
	$firstTime=strtotime($firstTime);
	$lastTime=strtotime($lastTime);
	
	// perform subtraction to get the difference (in seconds) between times
	$timeDiff=$lastTime-$firstTime;
	
	// return the difference
	//return round($timeDiff/3600);
	return round($timeDiff/60);
}
//end
//functions for getting time diffrance
function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );	
}
//end

//function for string
function string_replace($str)
{
	$str=trim($str);
	$str=str_replace("'","&#39;",$str);
	$str=str_replace("\"","&#34;",$str);
	return $str;
}
//end

//Function Display Date format
function display_date($org_dt,$dt_format="d F Y")
{
	$tdate=split(" ",$org_dt);
	$dt=split("-",$tdate[0]);
	$dt1=split(":",$tdate[1]);
	print date($dt_format, mktime($dt1[0], $dt1[1], $dt1[2], $dt[1], $dt[2], $dt[0]));
}
//end

//Function Display Date format
function display_onlydate($org_dt,$dt_format="d F Y")
{
	$dt=split("-",$org_dt);
	print date($dt_format, mktime(0, 0, 0, $dt[1], $dt[2], $dt[0]));
}
//end

//Function Display Date format
function display_onlydate_nw($org_dt,$dt_format="M d, Y")
{
	$dt=split("-",$org_dt);
	print date($dt_format, mktime(0, 0, 0, $dt[1], $dt[2], $dt[0]));
}
//end

//Functions for Date & time diffrence
function time_diff($post_date)
{	
//	$post_date="2006-02-03 12:14:47";
//	print display_date($post_date); 
	
	$tdate=split(" ",$post_date);
	$current_time=date("H:i");
	$qdate=$tdate[0];
	$posted_time=$tdate[1];
	$dt=split("-",$qdate);
	$dt1=split(":",$posted_time);
	$today=date("Y-m-d");

	//$cdt=date("d F Y H:i:s", mktime($dt1[0], $dt1[1], $dt1[2], $dt[1], $dt[2], $dt[0]));
	$cdt=date("d F Y", mktime($dt1[0], $dt1[1], $dt1[2], $dt[1], $dt[2], $dt[0]));
	$tdt=date("d F Y H:i:s");
	
	$daydiff=datediff('d', $cdt, $tdt, false);
	$monthdiff=datediff('m', $cdt, $tdt, false);

	if(date("Y")==$dt[0]){
		if(date("m")==$dt[1]){														
			if($today==$qdate){
				$diff=@get_time_difference($posted_time,$current_time);										
				
				$t=$diff['hours']." - ".$diff['minutes'];										
				
				$totalhour=$diff['hours'];
				$totalmin=$diff['minutes'];		
				if($totalhour>0){
					$totaltime=$totalhour." hours back";
				}
				else{
					if($totalmin>0)
						$totaltime=$totalmin." minutes back";
					else
						$totaltime=" just a few sec."; 
				}
			}
			else{
				$totaltime=date("d")-$dt[2]." days ago";											
			}
		}
		else{
			$totalmonth=datediff('m', $cdt, $tdt, false);
			if(date("d")==$dt[2]){
				$totaltime= $totalmonth." month ago";
			}
			else if(date("d") > $dt[2]){													
				$totalday=date("d")-$dt[2];//datediff('d', $cdt, $tdt, false);
				$totaltime= $totalmonth." month and ".$totalday." days ago";
			}
			else if(date("d") < $dt[2]){
				$end_date=date("d F Y", mktime($dt1[0], $dt1[1], $dt1[2], $dt[1]+($totalmonth-1), $dt[2], $dt[0]));													
				$totalday=datediff('d', $end_date, $tdt, false);
				if(($totalmonth-1)>0)
					$totaltime=($totalmonth-1)." month and ";
				$totaltime.= $totalday." days ago";
			}
		}
	}
	else{
		if(floor($monthdiff/12) > 0)
		{
			$totaltime=floor($monthdiff/12)." years";
		}
		if($totaltime!="" and $monthdiff-(floor($monthdiff/12)*12) > 0)
		{
			$totaltime.=" and ";
		}
		if($monthdiff-(floor($monthdiff/12)*12) > 0)
		{
			if($daydiff > 30)
				$totaltime.=($monthdiff-(floor($monthdiff/12)*12))." months ago";
			else
				$totaltime.=$daydiff." days ago";
		}
	}					
	print $totaltime;
}
//end

function RemoveLastChar($tempstring,$nochar = 1)
{
	if($tempstring!="")
	{
		$tempstring=substr($tempstring,0,strlen($tempstring)-$nochar);
	}
	return $tempstring;
}
function array_element_count($temp_arr)
{
	$f1=split(",",$temp_arr);
	$cnt=0;
	if(is_array($f1))
	{
		$cnt=count($f1);
	}
	return $cnt;
}

function rewrite_replace($txt)
{
	$txt=trim($txt);
	$txt=str_replace("&#39;","'",$txt);
	$txt=str_replace("&#34;","\"",$txt);
	$txt=str_replace(" ","_",$txt);
	$txt=str_replace("-","",$txt);
	$txt=str_replace("?","",$txt);
	$txt=str_replace("&","",$txt);
	$txt=str_replace("'","",$txt);
	$txt=str_replace("\"","",$txt);	
	return $txt;
}
function generate_password($length=8) {

	$allowable_characters = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghijklmnopqrstuvwxyz";
	// We see how many characters are in the allowable list

	$ps_len = strlen($allowable_characters);
	mt_srand((double)microtime()*1000000);
	$pass = "";
	for($i = 0; $i < $length; $i++) {
		$pass .= $allowable_characters[mt_rand(0,$ps_len-1)];
	} // End for
	return $pass;
}
function queryParameterCheck($variable)
{
	$rval=true;
	if(($variable=="") || (!is_numeric($variable)))
	{
		$rval=false;
	}
	return $rval;	
}
// Redirect to another page or site
function redirect($url) {

if (defined('ENABLE_SSL') && (ENABLE_SSL == true) && (getenv('HTTPS') == 'on') ) { // We are loading an SSL page
  if (substr($url, 0, strlen(HTTP_SERVER)) == HTTP_SERVER) { // NONSSL url
	$url = HTTPS_SERVER . substr($url, strlen(HTTP_SERVER)); // Change it to SSL
  }
}
print "<META http-equiv='refresh' content='0;URL=".$url."'>";
//header('Location: ' . $url);
exit();
}
////
/*sanitize string*/
function sanitize_string($string) {
	 //$string =(get_magic_quotes_gpc()) ? stripslashes($string) : $string;  
	 return htmlentities(mysql_real_escape_string($string),ENT_QUOTES | ENT_COMPAT | ENT_HTML401,'UTF-8');
}
function unsanitize_string($string)
{
	$string =(get_magic_quotes_gpc()) ? stripslashes($string) : $string;
	return html_entity_decode($string,ENT_QUOTES | ENT_COMPAT | ENT_HTML401,'UTF-8');
}
/*sanitize string*/
/*Break a word in a string if it is longer than a specified length ($len)*/
function break_string($string, $len, $break_char = '-') {
    $l = 0;
    $output = '';
    for ($i=0, $n=strlen($string); $i<$n; $i++) {
      $char = substr($string, $i, 1);
      if ($char != ' ') {
        $l++;
      } else {
        $l = 0;
      }
      if ($l > $len) {
        $l = 1;
        $output .= $break_char;
      }
      $output .= $char;
    }

    return $output;
  }
/*Break a word in a string if it is longer than a specified length ($len)*/
// Wrapper function for round()
function fundraiser_round($number, $precision) {	
    if (strpos($number, '.') && (strlen(substr($number, strpos($number, '.')+1)) > $precision)) {
      $number = substr($number, 0, strpos($number, '.') + 1 + $precision + 1);

      if (substr($number, -1) >= 5) {
        if ($precision > 1) {
          $number = substr($number, 0, -1) + ('0.' . str_repeat(0, $precision-1) . '1');
        } elseif ($precision == 1) {
          $number = substr($number, 0, -1) + 0.1;
        } else {
          $number = substr($number, 0, -1) + 1;
        }
      } else {
        $number = substr($number, 0, -1);
      }
    }

    return $number;
  }

/*function for mail*/
 function fundraiser_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address) {
	 
    // Instantiate a new mail object
    $message = new email(array('X-Mailer: Tbarter'));

    // Build the text version
    $text = strip_tags($email_text);
    if (EMAIL_USE_HTML == 'true') {
      $message->add_html($email_text, $text);
    } else {
      $message->add_text($text);
    }

    // Send message
    $message->build_message();
    $message->send($to_name, $to_email_address, $from_email_name, $from_email_address, $email_subject);
  }
  /*function for check is null or not*/
  function is_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }
  /*function for string to int converstion*/
  function string_to_int($string) {
    return (int)$string;
  }
  /*validate IP Address*/
  function validate_ip_address($ip_address) {
    if (function_exists('filter_var') && defined('FILTER_VALIDATE_IP')) {
      return filter_var($ip_address, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV4));
    }

    if (preg_match('/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $ip_address)) {
      $parts = explode('.', $ip_address);

      foreach ($parts as $ip_parts) {
        if ( (intval($ip_parts) > 255) || (intval($ip_parts) < 0) ) {
          return false; // number is not within 0-255
        }
      }

      return true;
    }

    return false;
  }

  /*Get IP Address*/
  function get_ip_address() {
    global $HTTP_SERVER_VARS;

    $ip_address = null;
    $ip_addresses = array();

    if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']) && !empty($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])) {
      foreach ( array_reverse(explode(',', $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])) as $x_ip ) {
        $x_ip = trim($x_ip);

        if (tep_validate_ip_address($x_ip)) {
          $ip_addresses[] = $x_ip;
        }
      }
    }

    if (isset($HTTP_SERVER_VARS['HTTP_CLIENT_IP']) && !empty($HTTP_SERVER_VARS['HTTP_CLIENT_IP'])) {
      $ip_addresses[] = $HTTP_SERVER_VARS['HTTP_CLIENT_IP'];
    }

    if (isset($HTTP_SERVER_VARS['HTTP_X_CLUSTER_CLIENT_IP']) && !empty($HTTP_SERVER_VARS['HTTP_X_CLUSTER_CLIENT_IP'])) {
      $ip_addresses[] = $HTTP_SERVER_VARS['HTTP_X_CLUSTER_CLIENT_IP'];
    }

    if (isset($HTTP_SERVER_VARS['HTTP_PROXY_USER']) && !empty($HTTP_SERVER_VARS['HTTP_PROXY_USER'])) {
      $ip_addresses[] = $HTTP_SERVER_VARS['HTTP_PROXY_USER'];
    }

    $ip_addresses[] = $HTTP_SERVER_VARS['REMOTE_ADDR'];

    foreach ( $ip_addresses as $ip ) {
      if (!empty($ip) && tep_validate_ip_address($ip)) {
        $ip_address = $ip;
        break;
      }
    }

    return $ip_address;
  }
  // nl2br() prior PHP 4.2.0 did not convert linefeeds on all OSs (it only converted \n)
  function convert_linefeeds($from, $to, $string) {
    if ((PHP_VERSION < "4.0.5") && is_array($from)) {
      return preg_replace('/(' . implode('|', $from) . ')/', $to, $string);
    } else {
      return str_replace($from, $to, $string);
    }
  }
////
function validate_email($email) {
    $email = trim($email);

    if ( strlen($email) > 255 ) {
      $valid_address = false;
    } elseif ( function_exists('filter_var') && defined('FILTER_VALIDATE_EMAIL') ) {
     $valid_address = (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    } else {
      if ( substr_count( $email, '@' ) > 1 ) {
        $valid_address = false;
      }

      if ( preg_match("/[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/i", $email) ) {
        $valid_address = true;
      } else {
        $valid_address = false;
      }
    }

    if ($valid_address && ENTRY_EMAIL_ADDRESS_CHECK == 'true') {
      $domain = explode('@', $email);

      if ( !checkdnsrr($domain[1], "MX") && !checkdnsrr($domain[1], "A") ) {
        $valid_address = false;
      }
    }

    return $valid_address;
  }
  
  function tep_check_gzip() {
    global $HTTP_ACCEPT_ENCODING;

    if (headers_sent() || connection_aborted()) {
      return false;
    }

    if (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false) return 'x-gzip';

    if (strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false) return 'gzip';

    return false;
  }

/* $level = compression level 0-9, 0=none, 9=max */
  function tep_gzip_output($level = 5) {
    if ($encoding = tep_check_gzip()) {
      $contents = ob_get_contents();
      ob_end_clean();

      header('Content-Encoding: ' . $encoding);

      $size = strlen($contents);
      $crc = crc32($contents);

      $contents = gzcompress($contents, $level);
      $contents = substr($contents, 0, strlen($contents) - 4);

      echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
      echo $contents;
      echo pack('V', $crc);
      echo pack('V', $size);
    } else {
      ob_end_flush();
    }
  }
  /**
 * Word Censoring Function
 *
 * Supply a string and an array of disallowed words and any
 * matched words will be converted to #### or to the replacement
 * word you've submitted.
 *
 * @param	string	the text string
 * @param	string	the array of censoered words
 * @param	string	the optional replacement value
 * @return	string
 */	

function word_censor($str, $censored, $replacement = '')
{
	if ( ! is_array($censored))
	{
		return $str;
	}

	$str = ' '.$str.' ';
	foreach ($censored as $badword)
	{
		if ($replacement != '')
		{
			$str = preg_replace("/\b(".str_replace('\*', '\w*?', preg_quote($badword)).")\b/i", $replacement, $str);
		}
		else
		{
			$str = preg_replace("/\b(".str_replace('\*', '\w*?', preg_quote($badword)).")\b/ie", "str_repeat('#', strlen('\\1'))", $str);
		}
	}

	return trim($str);
}
/**
 * Word Limiter
 *
 * Limits a string to X number of words.
 *
 * @param	string
 * @param	integer
 * @param	string	the end character. Usually an ellipsis
 * @return	string
 */
function word_limiter($str, $limit = 100, $end_char = '&#8230;')
{
	if (trim($str) == '')
	{
		return $str;
	}

	preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);

	if (strlen($str) == strlen($matches[0]))
	{
		$end_char = '';
	}

	return rtrim($matches[0]).$end_char;
}
 function disMessage($msgArray) { //die();
	$message = '';
    //var_dump($msgArray);
	$from = isset($msgArray["from"])?$msgArray["from"]:'';
	$type = isset($msgArray["type"])?$msgArray["type"]:'';
	$var = isset($msgArray["var"])?$msgArray["var"]:'';
	$val = isset($msgArray["val"])?$msgArray["val"]:'';
	// var_dump($msgArray);
	 //print_r($_SESSION);
	if($type != '' && $var != '')
	{  
		unset($_SESSION["msgType"]);
		$_SESSION["msgType"] = '';
		if($from == 'admin') {
			// admin 
			switch($var){
				//NEW FRom Admindemo Start
				case 'NRF' : {$message = 'No record found'; break; }
				case 'alreadytaken':{$message= 'User Name or Email is already taken'; break;}
				case 'invaildUsers' : {$message = 'Invalid username or password'; break; }
				case 'fillAllvalues' : {$message = 'Fill all required values properly'; break; }
				case 'insufValues' : {$message = 'Insufficient values'; break; }
				case 'succActivateAccount' : {$message = 'You have successfully activated your account, Please login to continue'; break; }
	
				## global admin
				case 'userExist' : {$message = 'Username is already exist'; break; }
				case 'emailExist' : {$message = 'Email address is already exist'; break; }				
				case 'addedUser' : {$message = 'You have successfully added Global Admin.'; break; }
				case 'editedUser' : {$message = 'You have successfully edited Global Admin.'; break; }				
				case 'actUserStatus' : {$message = 'You have successfully activated Global Admin status.'; break; }
				case 'deActUserStatus' : {$message = 'You have successfully de-activated Global Admin status.'; break; }				
				case 'delUser' : {$message = 'You have successfully deleted Global Admin.'; break; }	
				
				case 'recAdded' : {$message = 'Record was added successfully.'; break; }
				case 'recEdited' : {$message = 'Record was edited successfully.'; break; }				
				case 'recActivated' : {$message = 'Record was activated successfully.'; break; }
				case 'recDeActivated' : {$message = 'Record was deactivated successfully.'; break; }				
				case 'recDflLang' : {$message = 'Default Language Set successfully.'; break; }
				case 'recDeleted' : {$message = 'Record was deleted successfully.'; break; }
				//OVER Admindemo
				
				// OLD Original
				case 'changPass' : { $message = 'Password updated'; break; }
				case 'add' : { $message = 'Record added'; break; }				
				case 'edit' : { $message = 'Record edited successfully'; break; }				
				case 'del' : { $message = 'Record deleted successfully'; break; }				
				case 'status' : { $message = 'Status changed successfully'; break; }
				case 'urlTitleExist' : { $message = 'URL Title already exists!'; break; }
				case 'pageLinkExist' : { $message = 'Page link already exists!'; break; }
				case 'multiple' : {$message = $val; break; }
				case 'emailExist' : { $message = 'Email already used!'; break; }
				case 'abuseExist' : { $message = 'Abuse Keyword already exists!'; break; }
				case 'sentEmail' : { $message = 'Email has been sent successfully!'; break;}				
				
				default :{$message = $var; break;}
				
			}
		}
		else {
			// client
			switch($var){
                case 'multiple' : {$message = $val; break; }
				case 'wrongUserPass' : { $message = 'Wrong Email address or Password!'; break; }
				case 'wrongTechPass' : { $message = 'Wrong Email address or Password!'; break; }				
                case 'selectSignUp' :{ $message = 'Please select sign up option';  break;    }
				
				case 'succLogin' : { $message = 'You have logged in successfully!'; break; }
				case 'succLogout' : { $message = 'You have log out successfully!'; break; }
				case 'inSuffRegValues' : { $message = 'Please enter all required vlaues!'; break; }
				case 'emailExist' : { $message = 'Email is already exist!'; break; }
				case 'notActivated' : { $message = 'Your account is not activated yet, Please active!'; break; }
				
				## activation account
				case 'notApproved' : { $message = 'Your account is disapproved by admin!'; break; }				
				case 'activated' : { $message = 'Your account has been activated successfully!'; break; }
				case 'invalidActivation' : { $message = 'Invalid activation key, Please try again!'; break; }
				case 'succAddComment' : { $message = 'You have added comment successfully!'; break; }
				case 'enterComment' : { $message = 'Please enter a comment!'; break; }				

				case 'appNameBlank' : { $message = 'App\'s Title Should not blank!'; break; }
				case 'sucDup' : { $message = 'You have duplicated project successfully!'; break; }
				case 'sucupdateProStatus' : { $message = 'You have updated progress status successfully!'; break; }				
				case 'uploadProject' : { $message = 'You have uploaded project successfully!'; break; }				
				case 'noEmailFound' : { $message = 'No email address found.'; break; }
				case 'succForgot' :{ $message = 'You have added your email address successfully, Please check your e-mail!'; break;}
				case 'succChangeStatus' : { $message = 'You have updated project status successfully!'; break;}
				case 'sucChangeMemberPlan' : { $message = 'You have changed membership plan successfully!'; break;}
				case 'proChangeMemberPlan' : { $message = 'Problem to change membership plan!'; break;}
				case 'cancelMembership' : { $message = 'You have successfully canceled your Membership!'; break;}
			}
		}
		if($type == 'suc') {
			$msgClass = 'succMessage';
			$msgBackClass = 'succBackGround';
			//$imagePath = '<img src="'.SITE_IMG_SITE.'right-sign.png" height="15" alt="" />';
		}
		else {
			$msgClass = 'errorMessage';
			$msgBackClass = 'errorBackGround';
			//$imagePath = '<img src="'.SITE_IMG_SITE.'wrong-sign.png" height="18" alt="" />';
		}
		if($val	==""){
			return '<div style="height:5px;"></div>
				<div id="'.$msgClass.'">
					<div class="'.$msgBackClass.'">
						<div class="fl">'.$imagePath.'</div>
						<div class="fl">&nbsp;&nbsp;&nbsp;</div>
						<div class="fl disMsg">'.$message.'</div>
						<div class="fr disMsg"><a href="javascript:void(0);" title="Remove" id="closeMsgPart">X</a></div>
						<div style="clear:both"></div>
					</div>					
				</div>';
		}
		else{
			if (!isset($imagePath)) $imagePath = '';
			if (!isset($message)) $message = '';
			return '<div style="height:5px;"></div>
				<div id="'.$msgClass.'">
					<div class="'.$msgBackClass.'" style="height:auto">
						<div class="fl">'.$imagePath.'</div>
						<div class="fl">&nbsp;&nbsp;&nbsp;</div>
						<div class="fl disMsg">'.$message.'</div>
						<div class="fr disMsg"><a href="javascript:void(0);" title="Remove" id="closeMsgPart">X</a></div>
						<div style="clear:both"></div>
					</div>					
				</div>';
		}
	}
}

// Get IP Address
function get_ip_address1() {
	foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
		if (array_key_exists($key, $_SERVER) === true) {
			foreach (explode(',', $_SERVER[$key]) as $ip) {
				if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
					return $ip;
				}
			}
		}
	}
}
function stringShorter($str, $len=0){
	$len = (int)$len;
	$unsanaprotit = unsanitize_string(ucfirst($str));
	$protit_len = strlen($unsanaprotit);
	if($protit_len >= $len) {echo substr($unsanaprotit, 0, $len).'...'; }
	else { echo substr($unsanaprotit, 0, $len); }
}
function get_commision($projectId,$amount,$projectType,$type='a')
{
	/*$type = 'a' for Amount, 'p' for Percent*/
	$con=new DBconn();
	if($projectType=='1')
	{
		return '0';
	}
	else
	{
		$sel_range_basic_r=$con->recordselect("SELECT value FROM commision WHERE start<='".$amount."' and '".$amount."'<=end and type='p' order by id desc LIMIT 1");
		if(mysql_num_rows($sel_range_basic_r)>0)
		{
			$sel_range_basic=mysql_fetch_assoc($sel_range_basic_r);
			if($type == 'p'){
				return ($sel_range_basic['value']);
			}else{
				return (($amount*$sel_range_basic['value'])/100);
			}
		}
		else 
		{
			$sel_range_basic_s_r=$con->recordselect("SELECT value FROM commision WHERE start<='".$amount."' and end='0' and type='p' order by id desc LIMIT 1");
			if(mysql_num_rows($sel_range_basic_s_r)>0)
			{
				$sel_range_basic_s=mysql_fetch_assoc($sel_range_basic_s_r);
				if($type == 'p'){
					return ($sel_range_basic_s['value']);
				}else{
					return (($amount*$sel_range_basic_s['value'])/100);
				}
			}
			else {
				$sel_range_basic_e_r=$con->recordselect("SELECT value FROM commision WHERE '".$amount."'<=end and start='0' and type='p' order by id desc LIMIT 1");
				if(mysql_num_rows($sel_range_basic_e_r)>0)
				{
					$sel_range_basic_e=mysql_fetch_assoc($sel_range_basic_e_r);
					if($type == 'p'){
						return ($sel_range_basic_e['value']);
					}else{
						return (($amount*$sel_range_basic_e['value'])/100);
					}
				}
				/*else 
				{
					//SELECT value,if((start-14)<0,((start-14)*(-1)),(start-14)) as diff FROM commision order by diff asc,id desc
					$sel_range_basic_r1=$con->recordselect("SELECT value,if((start-'".$amount."')<0,((start-'".$amount."')*(-1)),(start-'".$amount."')) as diff FROM commision WHERE type='p' order by diff asc,id desc LIMIT 1");
					$sel_range_basic1=mysql_fetch_assoc($sel_range_basic_r1);
					if($type == 'p'){
						return ($sel_range_basic1['value']);
					}else{
						return (($amount*$sel_range_basic1['value'])/100);
					}
				}*/
			}
		}
		
	}
	
}
function check_project_status($projectId)
{
	$con=new DBconn();
	$sel_pro_basic=mysql_fetch_assoc($con->recordselect("SELECT projectEnd,rewardedAmount,fundingGoal FROM projectbasics WHERE projectId='".$projectId."'"));
	//$sel_pro_basic=mysql_fetch_assoc($con->recordselect("SELECT projectEnd,rewardedAmount,fundingGoal,fundingGoalType,minimumContributer,rewardedContributer FROM projectbasics WHERE projectId='".$projectId."'"));
	if($sel_pro_basic['projectEnd']>time() && $sel_pro_basic['fundingStatus']!='n')
	{
		$end_date=$sel_pro_basic['projectEnd'];
		$cur_time=time();
		$total = abs($end_date - $cur_time);
		$dateDiffentPara = 86400;
		$left_days = $total/$dateDiffentPara;
	}
	else
	{
		$left_days=0;
	}
	//echo '--'.$projectId.'left days'.$left_days;
	//print $left_days."-".$projectId;
	//print '<br/>';
	if($left_days!='0'){
	  $con->update("update projectbasics set fundingStatus='r' where projectId='".$projectId."'"); 
	}
	else
	{
	   /*if($sel_pro_basic['fundingGoalType'] == 1) 
	  {
		  if($sel_pro_basic['rewardedContributer']>=$sel_pro_basic['minimumContributer']) {
			$con->update("update projectbasics set fundingStatus='y' where projectId='".$projectId."'");
			
			pay_to_creator_on_success($projectId);
			
		  } else {
			  $con->update("update projectbasics set fundingStatus='n' where projectId='".$projectId."'");
			  pay_to_backers_on_refund($projectId);
			  
		  }
		  
		  
	  }
	  else
	  {*/
		 /*echo 'rewardamt'.$sel_pro_basic['rewardedAmount'];echo '<br>';
		 echo 'fundinggoal'.$sel_pro_basic['fundingGoal'];exit;*/
		  if($sel_pro_basic['rewardedAmount']>=$sel_pro_basic['fundingGoal']) {
				//echo 'if';
				//$con->update("update projectbasics set fundingStatus='y' where projectId='".$projectId."'");
				pay_to_creator_on_success($projectId);
		  } else {
			  //echo 'else';exit;
			  $con->update("update projectbasics set fundingStatus='n' where projectId='".$projectId."'");
			  pay_to_backers_on_refund($projectId);
		  }
	  /*}*/
	}
}
/*function pay_to_backers_on_refund($projectId)
{
	
	
}*/
function pay_to_backers_on_refund($projectId)
{
	global $PayPalConfig;
	$Pay=new Payment($PayPalConfig);
	
	
	$con=new DBconn();
	//$creator_detail=mysql_fetch_assoc($con->recordselect("select pbs.projectId,pbs.projectTitle,u.emailAddress,u.name,pbs.preapproval_key,pbs.fundingGoalType from projectbasics as pbs,users as u,projects as p where p.projectId='".$projectId."' and u.userId=p.userId and pbs.projectId=p.projectId"));
	$creator_detail=mysql_fetch_assoc($con->recordselect("select pbs.projectId,pbs.projectTitle,u.paypalId,u.userId,u.emailAddress,u.name,pbs.preapproval_key from projectbasics as pbs,users as u,projects as p where pbs.projectId='".$projectId."' and u.userId=p.userId and pbs.projectId=p.projectId"));
	
	$final_array=array();
	$final_array['projectId'] =$creator_detail['projectId'];
	$final_array['project_name'] = $creator_detail['projectTitle'];
	$final_array['creator_id']=$creator_detail['userId'];
	$final_array['creator_name']=$creator_detail['name'];
	$final_array['creator_email']=base64_decode($creator_detail['emailAddress']);
	$final_array['creator_paykey']=$creator_detail['preapproval_key'];
	$final_array['creator_paypal']=base64_decode($creator_detail['paypalId']);
	$final_array['fundingGoalType']=$creator_detail['fundingGoalType'];
	
	$userDetail_r=$con->recordselect("select pb.*,pbs.projectId,pbs.projectTitle,u.emailAddress,u.name,pb.userId from projectbasics as pbs,users as u, projectbacking as pb where pb.projectId='".$projectId."' and u.userId=pb.userId and pbs.projectId=pb.projectId and pb.payment_status='p' and pb.preapproval_key IS NOT NULL");
	
	if(mysql_num_rows($userDetail_r)>0)
	{				
		$Pay=new Payment($PayPalConfig);
		while($userDetails=mysql_fetch_assoc($userDetail_r))
		{
			/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_name,$creator_id,$amount,$commision,$rewardId,$backer_email,$creator_email*/
			
			$final_array=array();
			
			$final_array['projectId'] =$projectId;
			$final_array['project_name'] = $creator_detail['projectTitle'];
			$final_array['creator_id']=$creator_detail['userId'];
			$final_array['creator_name']=$creator_detail['name'];
			$final_array['creator_email']=base64_decode($creator_detail['emailAddress']);
			$final_array['creator_paykey']=$creator_detail['preapproval_key'];
			$final_array['creator_paypal']=base64_decode($creator_detail['paypalId']);
			$final_array['fundingGoalType']=$creator_detail['fundingGoalType'];
			
			$final_array['amount'] = $userDetails['pledgeAmount'];
			$final_array['commision'] = urlencode(get_commision($projectId,$userDetails['pledgeAmount'],$creator_detail["fundingGoalType"]));
			$final_array['paykey'] =$userDetails['preapproval_key'];	
			$final_array['rewardId'] = $userDetails['rewardId'];
			$final_array['back_id']=$userDetails['backingId'];

			$final_array['backer_id']=$userDetails['userId'];		
			$final_array['backer_email']=base64_decode($userDetails['emailAddress']);	
			$final_array['backer_name']=$userDetails['name'];
			
			//print_r($final_array);
			$Pay->payRefund_Unsuccessful($final_array);;
			
		}
		
	}
	$Pay->payRefund_Unsuccessful_creator_mail($final_array);;
	/*if($creator_detail['fundingGoalType']=='1')
	{
		
		$Pay->PayCommisionfromCreatorForPType1_Refund($final_array);
	}*/
		
}

function pay_to_creator_on_success($projectId)
{
	//echo $projectId;exit;
	global $PayPalConfig;
	$Pay=new Payment($PayPalConfig);	
	
	$con=new DBconn();
	
	//$creator_detail=mysql_fetch_assoc($con->recordselect("select pbs.projectId,pbs.projectTitle,pbs.fundingGoalType,u.emailAddress,u.name from projectbasics as pbs,users as u,projects as p where p.projectId='".$projectId."' and u.userId=p.userId and pbs.projectId=p.projectId "));
	$creator_detail=mysql_fetch_assoc($con->recordselect("select pb.*,pbs.projectId,pbs.projectTitle,u.emailAddress,u.name,u.paypalId from projectbasics as pbs,users as u,projects as p, projectbacking as pb where pb.projectId='".$projectId."' and u.userId=p.userId and pbs.projectId=p.projectId and pbs.projectId=pb.projectId "));
	
	$userDetail_r=$con->recordselect("select pb.*,pbs.projectId,pbs.projectTitle,u.emailAddress,u.name,pb.userId from projectbasics as pbs,users as u, projectbacking as pb where pb.projectId='".$projectId."' and u.userId=pb.userId and pbs.projectId=pb.projectId and pb.payment_status='p' and pb.preapproval_key IS NOT NULL");
	
	if(mysql_num_rows($userDetail_r)>0)
	{
		$Pay=new Payment($PayPalConfig);
		while($userDetails=mysql_fetch_assoc($userDetail_r))
		{
			//print_r($userDetails);exit;
			/*paykey,$backer_id,$back_id,$backer_name,$projectId,
		$project_name,$creator_name,$creator_id,$amount,$commision,$rewardId,$backer_email,$creator_email*/
			
			$final_array=array();
			$final_array['amount'] = $userDetails['pledgeAmount'];
			
			$final_array['commision'] = urlencode(get_commision($projectId,$userDetails['pledgeAmount'],$creator_detail["fundingGoalType"]));
			$final_array['paykey'] =$userDetails['preapproval_key'];
			
			$final_array['rewardId'] = $userDetails['rewardId'];
			$final_array['back_id']=$userDetails['backingId'];

			$final_array['projectId'] =$projectId;
			$final_array['project_name'] = $userDetails['projectTitle'];
			
			$final_array['backer_id']=$userDetails['userId'];		
			$final_array['backer_email']=base64_decode($userDetails['emailAddress']);	
			$final_array['backer_name']=$userDetails['name'];
			
			$final_array['creator_id']=$creator_detail['userId'];
			$final_array['creator_name']=$creator_detail['name'];
			$final_array['creator_email']=base64_decode($creator_detail['emailAddress']);
			$final_array['creator_paykey']=$creator_detail['preapproval_key'];
			$final_array['creator_paypal']=base64_decode($creator_detail['paypalId']);
			
			$final_array['fundingGoalType']=$creator_detail['fundingGoalType'];
			
			//_print_r($final_array);
			$Pay->payExecute_Successful($final_array);;
			
		}
		//echo 'abc';
		$Pay->pay_Execute_Successful_creator_mail($final_array);
	}
}

/* 
	json encode with html content 
	to remove extra spaces.
*/
function json_encode_html($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = json_encode($value);
                    $output_associative[] = json_encode($key) . ':' . json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }
function getValFromTbl($getvar,$table,$whvar,$flag=false,$qryorder='',$qrylimit='') {
	$con=new DBconn();
	if($flag==true)
		$retval=array();
	else
		$retval='';
	$whcon='';
	if($whvar!='')
		$whcon=" WHERE ".$whvar;
	 $qry="SELECT ".$getvar." FROM ".$table.$whcon.$qryorder.$qrylimit;
	 
	$res=$con->recordselect($qry);
	if(mysql_num_rows($res)>0) {
		$i=0;
		while($row=mysql_fetch_array($res)) {
			if($flag==true)
				$retval[$i]=$row[$getvar];
			else
				$retval=$row[$getvar];
			$i++;
		}
	}
	return $retval;
}
function imageUploadNew($type,$userid,$albumname,$th_arr,$listing_id=0,$uploadtype='i',$image_title='',$image_description='',$crop=false,$image_path='') 
{
	//echo 'imageuploadNew fun';
	$con=new DBconn();
	$tot_th=count($th_arr);
	//deleteImage($type,$tblnm,$fieldnm,$whfieldnm,$id,$tot_th);
//	$temp_img=DIR_TEMP.$_SESSION[$type.'_temp_'.$uploadtype];
	//$ext=getExt($temp_img);
	//print $temp_img;
	
	
	 $image_info = getimagesize($image_path);
      $image_ext = $image_info[2];
	if( $image_ext == IMAGETYPE_JPEG ) {
 		
         $ext = 'jpeg';
      } elseif( $image_ext == IMAGETYPE_GIF ) {
 
         $ext = 'gif';
      } elseif( $image_ext== IMAGETYPE_PNG ) {
 
         $ext='png';
	  }
	  else 
	  {
		  $ext='jpg';
		  }
	$q_dir="select * from photo_dir where dir_type='".$type."'";			
	$res_dir=$con->recordselect($q_dir);
	if(mysql_num_rows($res_dir)>0)
	{
		$row_dir=mysql_fetch_assoc($res_dir);
		if($row_dir["no"]>=$row_dir["files"])
		{
			
			$n_que=$row_dir["dir_index"]+1;
			mkdir(DIR_IMG.$type.$n_que,0777);
			$qqq="update photo_dir set currentdir='".$type.$n_que."',dir_index=".$n_que.",files=".$row_dir["files"].",no=0 where dir_type='".$type."'";
			$con->update($qqq);	
			$dirr=$type.$n_que;
			$filepath=DIR_IMG.$type.$n_que.'/';
			$fileurl=SITE_IMG.$type.$n_que.'/';
		}
		else
		{
			$filepath=DIR_IMG.$row_dir['currentdir'].'/';
			$fileurl=SITE_IMG.$row_dir['currentdir'].'/';
			$dirr=$row_dir['currentdir'];
		}	
		
		$filenm=md5(date("Y-m-d H:i:s")).'.'.$ext;
		//echo $filenm;
		//print "fnm->".$filenm;
		//copy($temp_img,$filepath.$filenm);
		//echo 'image path=>'.$image_path."<br>".$filenm."<br>".$filepath;

		//copy($image_path,$filepath.$filenm);
		for($i=0;$i<$tot_th;$i++) {
		//print "filename_th->".$i.$filepath.$filenm;
		//print "newfilename_th->".$filepath.'th'.($i+1).'_'.$filenm;		
			resizeImageNew($image_path,$filepath.'th'.($i+1).'_'.$filenm,$th_arr[$i]['width'],$th_arr[$i]['height'],true);
		}
		/* echo 'image path=>'.$image_path."<br>".$filenm."<br>".$filepath;exit;*/

		copy($image_path,$filepath.$filenm);
		$total=$tot_th+1;
		$update_dir=mysql_query("update photo_dir set no=no+".$total." where dir_type='".$type."'");
		//unlink($temp_img);
		//$_SESSION[$type.'_temp_'.$uploadtype]='';
		
		//$con=new DBconn();
		if($albumname=='listing')
		{
			$cond="listing_id='".$listing_id."'";
		}
		else{
			$cond="user_id='".$userid."'";
		}
		
		if($album=getValFromTbl('album_name','user_album',$cond." and album_name='".$albumname."'"))
		{
			//print "ä";
			$album_id=getValFromTbl('id','user_album',$cond." and album_name='".$albumname."'");
			$album_count=getValFromTbl('count(id)','user_photos',"album_id='".$album_id."'");
			
			if(getValFromTbl('id','user_photos',"album_id='".$album_id."' and `default`='y' and image_type!='u'"))
			{
				$q_insert="insert into  user_photos (image_title,image_description,`album_id`,`image`,`dir`,`order`,`status`,`image_type`,`created`,`ipaddress`) values ('".mysql_real_escape_string(addslashes($image_title))."','".mysql_real_escape_string(addslashes($image_description))."','".$album_id."','".$filenm."','".$dirr."','".($album_count+1)."','a','".$uploadtype."',CURRENT_TIMESTAMP,'".get_ip_address()."')";
				$con->insert($q_insert);
				$inserid=mysql_insert_id();
			}
			else
			{
				if($fb_photo_id=getValFromTbl('id','user_photos',"album_id='".$album_id."' and `default`='y' and image_type='u'"))
				{
					
					$con->update("update user_photos set `default`='' where id='".$fb_photo_id."'");
				}
				
				$q_insert="insert into  user_photos (image_title,image_description,`album_id`,`image`,`dir`,`default`,`order`,`status`,`image_type`,`created`,`ipaddress`) values ('".mysql_real_escape_string(addslashes($image_title))."','".mysql_real_escape_string(addslashes($image_description))."','".$album_id."','".$filenm."','".$dirr."','y','".($album_count+1)."','a','".$uploadtype."',CURRENT_TIMESTAMP,'".get_ip_address()."')";
				$con->insert($q_insert);
				$inserid=mysql_insert_id();
			}	
			
		}
		else
		{
				$q_insert1="insert into  user_album (`user_id`,`listing_id`,`album_name`,`created`,`ipaddress`) values ('".$userid."','".$listing_id."','".$albumname."',CURRENT_TIMESTAMP,'".get_ip_address()."')";
				$con->insert($q_insert1);
				$album_id=mysql_insert_id();
				$q_insert="insert into  user_photos (image_title,image_description,`album_id`,`image`,`dir`,`default`,`order`,`status`,`image_type`,`created`,`ipaddress`) values ('".mysql_real_escape_string(addslashes($image_title))."','".mysql_real_escape_string(addslashes($image_description))."','".$album_id."','".$filenm."','".$dirr."','y','".($album_count+1)."','a','".$uploadtype."',CURRENT_TIMESTAMP,'".get_ip_address()."')";
				$con->insert($q_insert);
				$inserid=mysql_insert_id();
		}
		$file=array("filename"=>$filenm,"filepath"=>$fileurl,"inserid"=>$inserid);
		return $file;
	}
	
}

/* ----------------------------------------------- */
// following added by jwg
 
function fct_show_trace($backtrace, $callerinfo) {
	wrtlog("BACKTRACE: $callerinfo");
	array_walk($backtrace,'_show_trace');
	if (isset($_SERVER) && isset($_SERVER['SERVER_NAME']) && isset($_SERVER['REQUEST_URI'])) {
		wrtlog("> from request ".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
	}
}

function _show_trace($val,$key) {
	$func = (isset($val['function'])) ? $val['function'] : 'unknown fct';
	$args = (isset($val['args'])) ? _show_trace_args($val['args']) : 'no args';
	$file = (isset($val['file'])) ? $val['file'] : 'unknown file';
	$line = (isset($val['line'])) ? $val['line'] : 'unknown line';
	wrtlog(">> $func".'('.$args.") at $line in $file");
}

function _show_trace_args($args) {
	$argstr = '';
	$sep = '';
	foreach ($args as $arg) {
		if (is_array($arg)) {
			$argstr .= $sep.'array';
		} else if (is_object($arg)) {
			$argstr .= $sep.'object';
		} else {
			$argstr .= $sep.substr($arg,0,1000);
			if (strlen($arg) > 1000) $argstr .= "... ";
		}
		$sep = ',';
	}	
	return $argstr;
}

function fct_current_user_id() {
	if (isset($_REQUEST[session_name()]) || (isset($_SESSION['userid']) && $_SESSION['userid'])) {
		fct_ensure_session();
        return isset($_SESSION['userid']) ? $_SESSION['userid'] : false;
	} else {
		return false;
	}
}

function fct_session_token() {
	fct_ensure_session();
	if (!array_key_exists('token', $_SESSION)) {
		$_SESSION['token'] = fct_good_rand(64);
	}
	return $_SESSION['token'];
}

function fct_ensure_session() {
	$c = null;
	if (!isset($_COOKIE)) {
	} else if (array_key_exists(session_name(), $_COOKIE)) {
		$c = $_COOKIE[session_name()];
	}
	if (!fct_have_session()) {
		
		// the following session_start might fail (but w/o any actual exception) if headers already sent
		// to track down source of problem, uncomment next line and see log for what precedes headers sent error    
		if (headers_sent($filename, $linenum)) {
			wrtlog("HEADERS: ".print_r(headers_list(),true));
			wrtlog("BEFORE SESSION_START().. HEADERS WERE ALREADY SENT IN $filename on line $linenum"); 		
			fct_show_trace(debug_backtrace(),"backtrace");     
		} else {
			@session_start();
		}
	}
	if (!isset($_SESSION['started'])) {
		$_SESSION['started'] = time();
	}
}

function fct_have_session() {
    //return (0 != strcmp(session_id(), ''));
	if (version_compare(phpversion(), '5.4.0', '<')) { if(session_id() == '') return false; } 
	else { if (session_status() == PHP_SESSION_NONE) return false; }
	return true;
}
   
function fct_good_rand($bytes) {
    if (@file_exists('/dev/urandom')) {
        return fct_urandom($bytes);
    } else { 
        return fct_mtrand($bytes);
    }	
}

function fct_urandom($bytes)
{
    $h = fopen('/dev/urandom', 'rb');
    // should not block
    $src = fread($h, $bytes);
    fclose($h);
    $enc = '';
    for ($i = 0; $i < $bytes; $i++) {
        $enc .= sprintf("%02x", (ord($src[$i])));
    }
    return $enc;
}

function fct_mtrand($bytes)
{
    $enc = '';
    for ($i = 0; $i < $bytes; $i++) {
        $enc .= sprintf("%02x", mt_rand(0, 255));
    }
    return $enc;
}

?>