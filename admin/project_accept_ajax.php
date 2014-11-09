<?php
require_once("../includes/config.php");
if(isset($_POST['projId']))
{
	$projectId = $_POST['projId']; ?>
       <div class="staff-picks-main">
      <div class="staff-picks-bottom2">
        <?php 		
				$approved_check2=$con->recordselect("SELECT * FROM projects WHERE projectId='".$projectId."' AND published=1");										
				$sel_staff_2=mysql_fetch_assoc($approved_check2);			
				$sel_project2=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$sel_staff_2['projectId']."'"));
				$sel_categories2=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_project2['projectCategory']."'"));
				$sel_image2=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_staff_2['projectId']."'"));				
				$sel_user2=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_staff_2['userId']."'"));
		?>
        <div class="float-left popular-main">
          <div class="info-panel-title min-height18" ><b style="word-wrap:break-word;"><?php echo $sel_categories2['categoryName']; ?></b></div>
          <!--.info-panel-title-->
          <div class="info-panel-img info-panel-img-ext popup_prj">
          	<a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_staff_2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'; ?>" target="_blank">
			<?php if(isset($sel_image2['image223by169']) && $sel_image2['image223by169'] != NULL) { ?> 
          		<img src="<?php echo SITE_URL.$sel_image2['image223by169']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>" border="0" />
            <?php } else { ?>
            	<img src="<?php echo NOIMG; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>" border="0" />
            <?php } ?> 
            </a>
          </div>
          <!--.info-panel-img-->
          <div class="info-panel-content info-panel-content-ext"> 
          <span class="blue-txt">
			  <?php if($sel_staff_2['accepted']=='1') { ?>
              <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_staff_2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'; ?>" target="_blank">
              	<b style="word-wrap:break-word;"><?php echo $sel_project2['projectTitle']; ?></b>
              </a><?php } else { ?>
               <b style="word-wrap:break-word;"><?php echo $sel_project2['projectTitle']; ?></b>
              <?php } ?>
          </span>
            <p>by <?php echo $sel_user2['name']; ?></p>
            <p style="word-wrap:break-word;"><?php echo $sel_project2['shortBlurb']; ?></p>
          </div>
          <!--.info-panel-content-->
          <div class="info-panel-description"> 
            <?php
			$fundingAmount = (isset($sel_project2['fundingGoal']) OR !empty($sel_project2['fundingGoal'])) ? $sel_project2['fundingGoal'] : 0;
            	if($fundingAmount != NULL && $fundingAmount > 0){
					$value = $sel_project2['rewardedAmount'];
					$max = $sel_project2['fundingGoal'];
				}
				$scale = 1.0;
				if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
				else { $percent = 0; }
				if ( $percent > 100 ) { $percent = 100; }
			?>
            
            <div class="percentbar">
              <div style="width:<?php echo round($percent * $scale); ?>%;"></div>
            </div>
            <?php
				if($sel_project2['projectEnd']>time())
				{
					$end_date=(int) $sel_project2['projectEnd'];
					$cur_time=time();
					$total = $end_date - $cur_time;
					$left_days=$total/(24 * 60 * 60);
				}
				else
				{
					$left_days=0;
				}
			?>
            <p>
            	<?php
					if($fundingAmount != NULL && $fundingAmount > 0){
						$value1 = $sel_project2['rewardedAmount'];
						$max1 = $sel_project2['fundingGoal'];
					}
					$scale = 1.0;
					if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
					else { $percent1 = 0; }
				?>
            		<b><?php echo (int) $percent1."%"; ?></b>Funded |
                    <b>$<?php echo number_format($sel_project2['rewardedAmount']); ?></b> Raised |
                	<b><?php echo roundDays($left_days);?></b> Days left
            </p>
          </div>
          <!--.info-panel-description--> 
        </div>
        <!--.info-panel .float-left-->       
        <div class="clear"></div>
      </div>
      <!--.staff-picks-bottom--> 
      
    </div>
      <?php
}
else
{
	
	$projectId=$_GET['projectId'];	
	$sel_project=mysql_fetch_array($con->recordselect("SELECT * FROM `projects` WHERE projectId = '".$projectId."'"));	
	$sel_projectBasic=mysql_fetch_array($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId = '".$projectId."'"));	
	$chktime_cur=time();
	
	if(isset($_GET['endDays'])) {
		  $daysEnd = $_GET['endDays']; 
		 $days = $daysEnd*24*3600; 
		 $startDate = time(); 
		 $endDate = $startDate + $days; 
		/* echo "UPDATE projectbasics SET projectStart='".$startDate."' AND projectEnd='".$endDate."' WHERE projectId = '".$projectId."'";exit;*/
		$con->update("UPDATE projectbasics SET projectStart='".$startDate."' WHERE projectId = '".$projectId."'");
		$con->update("UPDATE projectbasics SET projectEnd='".$endDate."' WHERE projectId = '".$projectId."'");
		
		
		$sel_projectUser=mysql_fetch_array($con->recordselect("SELECT * FROM `users` WHERE userId = '".$sel_project['userId']."'"));	
		$userEmail=base64_decode($sel_projectUser['emailAddress']);
		$userName=$sel_projectUser['name'];
		
			$artical1="";
			$artical1="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
			$artical1.="<body><strong>Hello ".$userName.", </strong><br />";
			$artical1.="<br />";			
			$artical1.= "Your project <b>'".$sel_projectBasic['projectTitle']."' </b>is accepted now.<br />";
			$artical1.= "Project will be ended after: ".$daysEnd." days<br />"; 
			
			$artical1.="<br /><br />Kind Regards,<br />".DISPLAYSITENAME." Team</body></html>";
			$subject1="Your project '".unsanitize_string(ucfirst($sel_projectBasic['projectTitle']))."' is accepted";
			$mailbody1=$artical1;
			$headers1 = "MIME-Version: 1.0\r\n";
			$headers1 .= "Content-type: text/html\r\n";
			$headers1 .= FROMEMAILADDRESS;
			@mail($userEmail, $subject1, $mailbody1, $headers1);	
			//@mail('drashti.nagrecha@ncrypted.com', $subject1, $mailbody1, $headers1);
			}
			
			
	 $currTime = time(); 
	if($sel_projectBasic['projectEnd']<$currTime && !isset($_GET['endDays'])) {
		redirect(SITE_ADM."project_accept.php");
	}
			  		
	if($sel_project['accepted']==1)
	{
		$con->update("UPDATE projects SET accepted=0 WHERE projectId = '".$projectId."'");
		redirect(SITE_ADM."project_accept.php");
	}
	else
	{
		$con->update("UPDATE projects SET accepted=1 WHERE projectId = '".$projectId."'");
		redirect(SITE_ADM."project_accept.php?msg=ACCEPTREC");
	}		
}
?>