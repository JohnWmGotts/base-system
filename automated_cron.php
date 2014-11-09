<?php 
global $PayPalConfig; // for functions that use old sdk
require "includes/config.php";
//require_once('includes/paypal/config.php');			// jwg .. needed for cancelpreapproval old way
//require_once('includes/paypal/paypal.class.php');	// ......

// prep old-style config from vars set in updated paypal/config using new sdk Configuration
$PayPalConfig = array(
						  'Sandbox' => $sandbox,
						  'DeveloperAccountEmail' => $developer_account_email,
						  'ApplicationID' => $application_id,
						  'DeviceID' => $device_id,
						  'IPAddress' => $_SERVER['REMOTE_ADDR'],
						  'APIUsername' => $api_username,
						  'APIPassword' => $api_password,
						  'APISignature' => $api_signature,
						  'APISubject' => $api_subject
);		

$today = time();
$today=(date('Y-m-d',time()));

$artical="";
$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
$artical.="<body><strong>Hello ALL, </strong><br />";
$artical.="<table><tr><td colspan='2'><strong>CronJob Time Information</strong></td></tr>";
$artical.="<tr><td colspan='2'>&nbsp;</td></tr><tr><td><strong>Current Time(timestamp) : </strong></td><td>".time()."</td></tr>";
$artical.="<tr><td><strong>Date (Y-m-d) : </strong></td><td>".$today."</td></tr>";
$artical.="<tr><td><strong>TimeZone (default) : </strong></td><td>".date_default_timezone_get() . ' => ' . date('e') . ' => ' . date('T')."</td></tr>";
$artical.="<tr><td><strong>Query : </strong></td><td>SELECT pb.projectId FROM projects as p,projectbasics as pb WHERE pb.fundingStatus='r' AND p.published=1 AND p.accepted=1 AND FROM_UNIXTIME(projectEnd,'%Y-%m-%d')<='".$today."' AND projectEnd!='0' AND projectEnd IS NOT NULL AND p.projectId=pb.projectId</td></tr>";
$artical.="<tr><td colspan='2'>&nbsp;</td></tr></table>";
$artical.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
$subject="CronJob Detail At ".DISPLAYSITENAME."";
$mailbody=$artical;
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html\r\n";
$headers .= FROMEMAILADDRESS;
@mail('admin@crowdedrocket.com', $subject, $mailbody, $headers);
	
$projectSelect_r=$con->recordselect("SELECT pb.projectId FROM projects as p,projectbasics as pb WHERE pb.fundingStatus='r' AND p.published=1 AND p.accepted=1 AND FROM_UNIXTIME(projectEnd,'%Y-%m-%d')<='".$today."' AND projectEnd!='0' AND projectEnd IS NOT NULL AND p.projectId=pb.projectId");
if(mysql_num_rows($projectSelect_r)>0)
{
	while($projectSelect=mysql_fetch_assoc($projectSelect_r))
	{
		check_project_status($projectSelect['projectId']);
	}
}
