<script type="text/javascript">
	function openproject(projectId)
	{
		window.location = application_path+"browseproject/"+projectId;		
	}
</script>

<section id="container">
   
   <div id="inbox" class="head_content temp">
       <h3>My Reward History</h3>
   </div>
   
   <div class="wrapper">
   		<?php
		if(mysql_num_rows($sel_backedproject[1])>0)
		{ ?>
            <div class="message_heading">
                <h2 class="prctname prctname1">Project Name</h2>
                <h2 class="backed_ammount backed_ammount1">Backer</h2>
                 <h2 class="backed_ammount backed_reward">Reward Description</h2>
                 <h2 class="short_blurb short_blurb1">Reward Amount</h2> 
            </div>
        	<?php
				while($sel_backedproject1=mysql_fetch_assoc($sel_backedproject[1])) {
					
					$sel_rewardamt=mysql_fetch_assoc($con->recordselect("SELECT * FROM  projectrewards WHERE rewardId='".$sel_backedproject1['rewardId']."'"));
					$sel_backprojectforimg=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_backedproject1['projectId']."'"));
					$sel_backprojectacceptedterms=mysql_fetch_assoc($con->recordselect("SELECT accepted FROM projects WHERE projectId='".$sel_backedproject1['projectId']."'"));
					//echo $sel_backprojectacceptedterms['accepted'];
					//echo 'img'.$sel_backprojectforimg['image100by80'];
			 ?>	
             <?php if($sel_backprojectacceptedterms['accepted']=='1') { ?>
                <div class="message_box" onClick="return openproject(<?php echo $sel_backedproject1['projectId']; ?>)">
                    <?php }
                        else if($sel_backprojectacceptedterms['accepted']=='3') { ?>
                         <div class="message_box">
                        <?php } ?>
                    <div class="prctname prctname1">
                    	<div class="msg-imgbox">
                    <?php // echo 'title'.$sel_backproject['projectTitle']; ?>
                    <?php if($sel_backprojectforimg['image100by80']!=""){ ?>
                        <img alt="<?php echo unsanitize_string($sel_backproject['projectTitle']); ?>" title="<?php echo unsanitize_string($sel_backproject['projectTitle']); ?>" src="<?php echo SITE_URL.$sel_backprojectforimg['image100by80']; ?>" >
                       <?php } else { ?>
                         <img alt="<?php echo unsanitize_string($sel_backproject['projectTitle']); ?>" title="<?php echo unsanitize_string($sel_backproject['projectTitle']); ?>" src="<?php echo SITE_URL.'images/missing_little1.png'; ?>" height="80" width="100" >
                       <?php } ?>
                       <?php if($sel_backprojectacceptedterms['accepted']=='1') { ?>
                        </div><a title="<?php echo unsanitize_string(ucfirst($sel_backedproject1['projectTitle'])); ?>" href="<?php echo SITE_URL.'browseproject/'.$sel_backedproject1['projectId'].'/'.Slug($sel_backedproject1['projectTitle']).'/'; ?>">
                            <?php echo unsanitize_string(ucfirst($sel_backedproject1['projectTitle'])); ?>
                        </a>
                        <?php }
                        else if($sel_backprojectacceptedterms['accepted']=='3') { ?>
                        <a title="<?php echo unsanitize_string(ucfirst($sel_backedproject1['projectTitle'])); ?>" href="#">
                            <?php echo unsanitize_string(ucfirst($sel_backedproject1['projectTitle'])); ?>
                        </a>
                        <?php } ?>
                        <h6><?php echo date('M d', $sel_backedproject1['backingTime']); ?></h6>
                        <div class="clear"></div>
                    </div>
                    
                    <div class="backed_ammount backed_ammount1">
                       	<?php
						//echo "SELECT * FROM projectbacking as bk, users as us WHERE bk.projectId='".$sel_backedproject1['projectId']."' AND bk.userId = us.userId";
						 $sel_backprojectUser=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbacking as bk, users as us WHERE bk.backingId='".$sel_backedproject1['backingId']."' AND bk.userId = us.userId")); ?>
                        <p><?php echo $sel_backprojectUser['name']; ?></p>
                    </div>
                    <div class="short_blurb backed_reward">
                       	<?php
						//echo "SELECT * FROM projectbacking as bk, users as us WHERE bk.projectId='".$sel_backedproject1['projectId']."' AND bk.userId = us.userId";
						 if($sel_backedproject1['rewardId']!=0) {
							// echo "SELECT * FROM  projectrewards WHERE rewardId	='".$sel_backedproject1['rewardId']."'";
						 $sel_backprojectReward=mysql_fetch_assoc($con->recordselect("SELECT * FROM  projectrewards WHERE rewardId	='".$sel_backedproject1['rewardId']."'")); ?>
                        <p><?php echo $sel_backprojectReward['description']; ?></p>
                        <?php }
                        else { ?>
                         <p>No Reward</p>
                        <?php } ?>
                    </div>
                     <div class="short_blurb short_blurb1">
                    <?php  if($sel_backedproject1['rewardId']!=0) { ?>
                        <h4><?php echo '$'.$sel_rewardamt['pledgeAmount']; ?></h4>
                        <?php }  else { ?>
							 <h4>No Reward</h4>
							
					<?php		} ?>
                       
                    </div>
                    <div class="clear"></div>
                    
                </div>
			<?php } ?>                 
        <?php
			}else 
			{ ?>
        		<p class="no-content">No Record Found!</p>
		<?php } ?>
        <?php if(mysql_num_rows($sel_backedproject[1])>0)	{?>
        <div class="pagination">
            <center><?php $con->onlyPagging($page,$per_page,8,2,0,1,$extra);?></center>
        </div>
        <?php } ?>       
   </div>
</section>