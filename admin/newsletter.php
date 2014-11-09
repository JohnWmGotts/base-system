<?php 
require_once("../includes/config.php");
$pagetitle="Manage Newsletter";
$id	=	"id";
	if($_SESSION["admin_user"]=="")
	{
		print "<META http-equiv='refresh' content='0;URL=".SITE_ADM."index.php'>";
		exit;
	}
	
		$_SESSION['SUCCESS_MAIL_SEND']=0;
		$_SESSION['FAIL_MAIL_SEND']=0;
		$_SESSION['TOTAL_SUCCESS_MAIL'] = 0;
		$_SESSION['TOTAL_FAIL_MAIL'] = 0;	
	
	if(isset($_POST['action']))
	{
		extract($_POST);
		$obj = new validation();
		
		$obj->add_fields($txtNewsLetterName, 'req', 'Please Enter Newsletter Name');
		$obj->add_fields($content_newsletter, 'req', 'Please Enter Newsletter Content');
		$error = $obj->validate();
	
		if($error=='')
		{
			//add newsletter
			if(isset($_REQUEST['action']) && $_REQUEST['action']=='save')
			{
				extract($_POST);
				$con->insert("INSERT INTO newsletter (`id`, `name`, `content`) VALUES (NULL, '".sanitize_string($txtNewsLetterName)."', '".sanitize_string($content_newsletter)."')");
				redirect(SITE_ADM."newsletter.php?msg=ADDREC");
			}
						
			//edit newsletter
			if(isset($_POST['action']) && $_POST['action']=='edit_news')
			{
				extract($_POST);
				$con->update("UPDATE newsletter SET name='".sanitize_string($txtNewsLetterName)."', content='".sanitize_string($content_newsletter)."' WHERE id='$news_Id'");
				redirect(SITE_ADM."newsletter.php?msg=EDITREC");
			}
		}
	}
	//select newsletter
		if(isset($_GET['action']) && ($_GET['action']=='edit' || $_GET['action']=='view'))
		{
			$sel_EditNewsLetter=mysql_fetch_assoc($con->recordselect("SELECT * FROM `newsletter` WHERE id='".$_REQUEST['newsId']."'"));
		}
		//delete newsletter
		if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete')
		{
			$con->delete("DELETE FROM newsletter WHERE id = '".$_GET['newsId']."'");
			redirect(SITE_ADM."newsletter.php?msg=DELREC");	
		}
		   
   //send mail to user
	if(isset($_GET['action']) && $_GET['action']=='mail_send')
	{
		
		$sel_newsletter_email=$con->recordselect("SELECT * FROM users");
		$sel_newsletter1=mysql_fetch_assoc($con->recordselect("SELECT * FROM newsletter WHERE id='".$_GET['newsId']."' LIMIT 1"));
		
		$loopLimit = count($_POST['newsusers']);
		$i=0;
		$j=0;	
		$sentEmails=array();
		$failEmails=array();	
		
		for($k=0;$k<$loopLimit;$k++){				
				$sel_newsletter_email=$con->recordselect("SELECT * FROM users WHERE userId = '".$_POST['newsusers'][$k]."'");
				$val = mysql_fetch_assoc($sel_newsletter_email);
				$artical="";
				//tableborder { border: 1px solid #CCCCCC; }
				$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }
				.mtext {font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #333333;text-decoration: none;}
				a { font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #A11B1B;font-weight: normal;text-decoration: underline;}
				a:hover {font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: normal;color: #A11B1B;text-decoration: none;}
				</style></head>";
				$artical.="<body><strong>Hello ".$val['name'].", </strong><br /><br />";				
				$artical.="<br /><table width='100%' cellspacing='0' cellpadding='0' class='tableborder' align='center'>";
				/*$artical.="<tr>
			<td height='80' style='border-bottom:solid 1px #f2f2f2; padding:5px; background-color: #999999;' valign='middle'><img src='".SITE_IMG."logo_fundraiser.png' /></td>
		  </tr>";*/
				$artical.="<tr><td colspan='2'>".unsanitize_string($sel_newsletter1['content'])."</td></tr>";				
				$artical.="<tr><td colspan='2'>&nbsp;</td></tr>";
				/*$artical.="<tr>
	<td style='font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#000; text-decoration:none; line-height:30px; border-top:solid 1px #f2f2f2;'>&copy; ".date("Y")." ".DISPLAYSITENAME." , All Rights Reserved.</td>
	</tr>";*/
				$artical.="<tr><td colspan='2'>&nbsp;</td></tr></table>";           
				$artical.="<br /><br />Kind Regards, <br />".DISPLAYSITENAME." Admin</body></html>";
				$subject=" ".$sel_newsletter1['name']."";
				$mailbody=$artical;
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html\r\n";
				$headers .= FROMEMAILADDRESS;
				
				if(@mail(base64_decode($val['emailAddress']), $subject, $mailbody, $headers))
				{
					$sentEmails[] = base64_decode($val['emailAddress']);
					$i=$i+1;
				}else{
					$failEmails[] = base64_decode($val['emailAddress']);
					$j=$j+1;
				}
			
		}
		
		$_SESSION['SUCCESS_MAIL_SEND']=$sentEmails;
		$_SESSION['FAIL_MAIL_SEND']=$failEmails;
		$_SESSION['TOTAL_SUCCESS_MAIL'] = $i;
		$_SESSION['TOTAL_FAIL_MAIL'] = $j;
		
		redirect(SITE_ADM."newsletter.php?msg=NEWSSUC");
	}

	// User listing select query code end
	//select newsletter
	if(!isset($_GET) || !isset($_GET['page']) || ($_GET['page']=='') || ($_GET['page']<0) || !is_numeric($_GET['page']) || $_GET['page']==0)
	{
		$page=1;
		$_GET['page']=1;
	}
	else
	{
		$page = $_GET['page'];
	}
	$perpage=10;
	if(!isset($_GET['action']) || $_GET['action']=='')
	{
		$sel_newsletter12 = "SELECT * FROM newsletter ORDER BY id DESC";
		//$result = $con->select($sel_newsletter12,$page,$perpage,15,2,0);
		$result = $con->recordselect($sel_newsletter12);
	}
	$content="newsletter";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>