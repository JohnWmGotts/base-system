<?php
	require_once("../../includes/config.php");
	//$left_panel=false;
	//$cont_mid_cl='-75';	
	$title = "Invite Friends";
	$meta = array("description"=>"Invite Friends","keywords"=>"Invite Friends");
	
	if(!isset($_SESSION['userId']) || $_SESSION['userId']=='')
	{
		 $_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"Please login to access this page.");	
			redirect(SITE_URL."index.php");
			exit;
	}
	
	$extra='';
	if(!isset($_GET) || !isset($_GET['page']) || $_GET['page']==0 || $_GET['page']<=0)
	{
		$_GET['page']=1;
	}
	$page = $_GET['page'];
	
	$perpage=10;
		if($_POST) {
			
		$errormsg = '';
		extract($_POST);
	 	
			$counter1=0;
			$counter2=0;
			$counter3=0;
			//echo 'SELECT * from users WHERE userId="'.$_SESSION["userId"].'"';
			$qrySel = $con->recordselect('SELECT * from users WHERE userId="'.$_SESSION["userId"].'"');
			$row = mysql_fetch_array($qrySel);
			$firstname = $row["name"];
			 $emailAddress = base64_decode($row["emailAddress"]);
			
			if($inviteemail == '') {
			 $_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Please enter email address.');
			}
			
			else {
				$emailid=explode(";",$inviteemail);
				
				if(count($emailid)>5) {
					$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Invitation can be sent to five people only.');
				}
				else {
					
				 // echo 'after'.count($emailid);exit;
			//print_r($emailid);
			for($i=0;$i<count($emailid);$i++){
				if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$emailid[$i])) {
			//echo $emailid[1];exit;
					//print_r($emailid);
					if($emailAddress==$emailid[$i]) {
							$counter1=1;
					}
					else {
					$qrySelExisting = $con->recordselect('SELECT * from tbl_invitefriends WHERE mailAddress="'.$emailid[$i].'"');	
						if(mysql_num_rows($qrySelExisting)>0) {
						
							$counter2=1;
						}
						else {
									$counter3 =1;
								$act_key=$con->recordselect("SELECT * FROM `users` WHERE `emailAddress` = '".base64_encode($emailid[$i])."'");
								$act_key1=mysql_fetch_array($act_key);
								$username = $act_key1['name'] != '' ? $act_key1['name'] : 'Friend';
								$artical="";
								$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
								$artical.="<body><strong>Hello ".sanitize_string(ucfirst($username)).", </strong><br />";
								$artical.="".ucfirst($firstname)." has invited you at ".DISPLAYSITENAME.".<br /> <br />";
								$artical.="Please visit the site by clicking on following link.<br /><a href='".SITE_URL."'>Click Here</a>";
								$artical.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
								$subject="".ucfirst($firstname)." has invited you at ".DISPLAYSITENAME."";
								$mailbody=$artical;
								$headers = "MIME-Version: 1.0\r\n";
								$headers .= "Content-type: text/html\r\n";
								$headers .= FROMEMAILADDRESS;
								@mail($emailid[$i], $subject, $mailbody, $headers);
								
								$currentTime = time();
								$con->insert("INSERT INTO tbl_invitefriends (`id`, `mailAddress`, `senderId`, `createdDate`) VALUES (NULL, '$emailid[$i]',  '".$_SESSION["userId"]."', '$currentTime')");
								
						}
					}
				
					
				}
				else {
					$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Please enter proper mail address.');
				
				}
			}//for loop completes..
			}
			//echo $counter1; echo $counter2; echo $counter3;	
							if(($counter1 == '1' || $counter2 == '1') && $counter3 == '0' ){
								//echo 'a';exit;
								$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Invitation can not be sent to youself & already sent users.');
							}
							else if(($counter1 == '1' || $counter2 == '1') && $counter3 == '1' ){
								//echo 'b';exit;
								$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Invitation  sent except youself & already sent users.');
							}
							else if(($counter1 == '0' && $counter2 == '0') && $counter3 == '1' ){
								//echo 'c';exit;
							 $_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>'Invitation successfully sent.');
							}
							 redirect($base_url."invitefriends");
			}
			
	}
	
	
	
		$sel_backedproject1="SELECT * FROM `projectbacking` WHERE `userId` ='".$_SESSION['userId']."' ORDER BY backingTime DESC";
	$sel_backedproject = $con->select($sel_backedproject1,$page,$perpage,15,2,0);

	
	
	$module='user';
	$page='invitefriends';
	$content=$module.'/'.$page;
	require_once(DIR_TMP."main_page.tpl.php");
?>