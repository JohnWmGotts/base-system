<script type="text/javascript">
	function openproject(projectId)
	{
		window.location = application_path+"browseproject/"+projectId;		
	}
</script>

<section id="container">
   
   <div id="inbox" class="head_content temp">
       <h3>My Backer History</h3>
   </div>
   
   <div class="wrapper">
   		<?php
		if(mysql_num_rows($sel_backedproject[1])>0)
		{ ?>
            <div class="message_heading">
                <h2 class="prctname">Project Name</h2>
                <h2 class="short_blurb">Short Blurb</h2>
                <h2 class="backed_ammount">Backed Amount</h2>
            </div>
        	<?php
				while($sel_backedproject1=mysql_fetch_assoc($sel_backedproject[1])) {
					//code changed as required..
					//$sel_backproject=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb,productimages as pi WHERE pb.projectId='".$sel_backedproject1['projectId']."' AND pi.projectId='".$sel_backedproject1['projectId']."'"));
					$sel_backproject=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$sel_backedproject1['projectId']."'"));
					$sel_backprojectforimg=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_backedproject1['projectId']."'"));
					$sel_backprojectacceptedterms=mysql_fetch_assoc($con->recordselect("SELECT accepted FROM projects WHERE projectId='".$sel_backedproject1['projectId']."'"));
					//echo $sel_backprojectacceptedterms['accepted'];
			 ?>	
             <?php if($sel_backprojectacceptedterms['accepted']=='1') { ?>
                <div class="message_box" onClick="return openproject(<?php echo $sel_backedproject1['projectId']; ?>)">
                    <?php }
                        else if($sel_backprojectacceptedterms['accepted']=='3') { ?>
                         <div class="message_box">
                        <?php } ?>
                    <div class="prctname">
                    <?php // echo 'title'.$sel_backproject['projectTitle']; ?>
                    <?php if($sel_backprojectforimg['image100by80']!=""){ ?>
                        <img alt="<?php echo unsanitize_string($sel_backproject['projectTitle']); ?>" title="<?php echo unsanitize_string($sel_backproject['projectTitle']); ?>" src="<?php echo SITE_URL.$sel_backprojectforimg['image100by80']; ?>" >
                       <?php } else { ?>
                         <img alt="<?php echo unsanitize_string($sel_backproject['projectTitle']); ?>" title="<?php echo unsanitize_string($sel_backproject['projectTitle']); ?>" src="<?php echo SITE_URL.'images/missing_little1.png'; ?>" height="80" width="100" >
                       <?php } ?>
                       <?php if($sel_backprojectacceptedterms['accepted']=='1') { ?>
                        <a title="<?php echo unsanitize_string(ucfirst($sel_backproject['projectTitle'])); ?>" href="<?php echo SITE_URL.'browseproject/'.$sel_backedproject1['projectId'].'/'.Slug($sel_backproject['projectTitle']).'/'; ?>">
                            <?php echo unsanitize_string(ucfirst($sel_backproject['projectTitle'])); ?>
                        </a>
                        <?php }
                        else if($sel_backprojectacceptedterms['accepted']=='3') { ?>
                        <a title="<?php echo unsanitize_string(ucfirst($sel_backproject['projectTitle'])); ?>" href="#">
                            <?php echo unsanitize_string(ucfirst($sel_backproject['projectTitle'])); ?>
                        </a>
                        <?php } ?>
                        <h6><?php echo date('M d', $sel_backedproject1['backingTime']); ?></h6>
                        <div class="clear"></div>
                    </div>
                    <div class="short_blurb">
                        <h5><?php //echo unsanitize_string(ucfirst($sel_backproject['projectTitle'])); ?></h5>
                        <p><?php echo unsanitize_string($sel_backproject['shortBlurb']); ?></p>
                    </div>
                    <div class="backed_ammount">
                        <h4><?php echo '$'.$sel_backedproject1['pledgeAmount']; ?></h4>
                    </div>
                    <div class="clear"></div>
                </div>
			<?php } ?>                 
        <?php
			}else 
			{ ?>
        		<p class="no-content">You haven't backed any projects!</p>
		<?php } ?>
        <?php if(mysql_num_rows($sel_backedproject[1])>0)	{
			if (!isset($per_page)) $per_page = 10; // jwg
		?>
        <div class="pagination">
            <center><?php $con->onlyPagging($page,$per_page,8,2,0,1,$extra);?></center>
        </div>
        <?php } ?>       
   </div>
</section>