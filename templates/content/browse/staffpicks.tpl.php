<!--start-content-->
<section id="container">
	<div class="wrapper">
		<section id="content">
			<div id="sidebarleft" class="inner-sidebarleft">
				<?php if(isset($catId)){ ?>
                	<div class="float-left textbig-b">
                        <a href="<?php echo $base_url; ?>staffpicks/">Discover </a>/
                        <?php if(isset($cityName)){ ?>
                        	<a href="<?php echo SITE_URL; ?>city/<?php echo $catId.'/'.Slug($catName).'/'; ?>"><?php echo $catName ?></a> /
                        <?php }else{ ?>
                        	<a href="<?php echo SITE_URL; ?>category/<?php echo $catId.'/'.Slug($catName).'/'; ?>"><?php echo $catName ?></a> /
                        <?php } ?>    
						<?php echo $title; ?>
                    </div>
				<?php }else{ ?>
                	<div class="float-left textbig-b">
					<a href="<?php echo $base_url; ?>staffpicks/">Discover </a>/
					<?php echo $title; ?></div>
                <?php } ?>
				<div class="flclear spaser-small"></div>
                <div class="latestprojects">
                <ul>
			<?php
				$comma_separated = array();
				while ($approved_chk = mysql_fetch_assoc($selectProjects)){
					$comma_separated[] = $approved_chk['projectId'];	
				}
				$comma_separated = implode(",", $comma_separated);
				if($comma_separated != ''){
					$sel_staff1 = $con->recordselect("SELECT `staffpicks_id`, `projectId`, `userId`, `adminId`, `status`, count(`projectId`) as total FROM `staffpicks` WHERE projectId IN (".$comma_separated.") AND status=1 GROUP BY `projectId` ORDER BY total DESC");
				}else{
	                $sel_staff1=$con->recordselect("SELECT `staffpicks_id`, `projectId`, `userId`, `adminId`, `status`, count(`projectId`) as total FROM `staffpicks` WHERE status=1 GROUP BY `projectId` ORDER BY total DESC");
				}
				
                if(mysql_num_rows($sel_staff1)>0)
                {
					while ($approved_check = mysql_fetch_assoc($sel_staff1))
					{
						$approved_check1=$con->recordselect("SELECT * FROM projects WHERE projectId='".$approved_check['projectId']."' AND published=1 AND accepted=1");										
						while($sel_staff=mysql_fetch_assoc($approved_check1))
						{
							$sel_project=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$sel_staff['projectId']."'"));
							$chktime_cur=time();  
						if($sel_project['fundingStatus']=='n' || ($sel_project['projectEnd']<$chktime_cur && $sel_project['fundingStatus']=='r'))
							{
								continue;
							}
							
							$sel_categories=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_project['projectCategory']."'"));
							$sel_image1=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_staff['projectId']."'");
							$sel_image=mysql_fetch_assoc($sel_image1);
							$sel_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_staff['userId']."'"));
                    ?>		
                <li>
                    <div class="innerbox">
                        
                        <div class="img_thumb">
                            <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_staff['projectId'].'/'.Slug($sel_project['projectTitle']).'/'; ?>">
                                <?php if(($sel_image['image223by169']!=NULL || $sel_image['image223by169']!='') && mysql_num_rows($sel_image1)>0) { if(file_exists(DIR_FS.$sel_image['image223by169'])) { ?>
                                    <img src="<?php echo SITE_URL.$sel_image['image223by169']; ?>" title="<?php echo $sel_project['projectTitle']; ?>" alt="<?php echo $sel_project['projectTitle']; ?>"/>
                                <?php } else { ?>
                                    <img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project['projectTitle']; ?>" alt="<?php echo $sel_project['projectTitle']; ?>" />
                                <?php	}
                                    } else { ?>
                                    <img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project['projectTitle']; ?>" alt="<?php echo $sel_project['projectTitle']; ?>" />
                                <?php } ?>
                            </a>
                        </div>
                        
                        <div class="poductname">
                            <?php if($sel_categories['isActive'] == 1) { ?>
                                <a title="<?php echo $sel_categories['categoryName']; ?>" href="<?php echo $base_url;?>category/<?php echo $sel_categories['categoryId'].'/'.Slug($sel_categories['categoryName']).'/'; ?>">
                                    <?php echo $sel_categories['categoryName']; ?>
                                </a>
                            <?php }else{ ?>
                            	<a title="<?php echo $sel_categories['categoryName']; ?>" href="javascript:void(0);">
                                    <?php echo $sel_categories['categoryName']; ?>
                                </a>
                            <?php } ?>
                        </div>
                            
                        <div class="whitebox">
                        
                            <div class="textnormal-b">
                                <strong>
                                    <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_staff['projectId'].'/'.Slug($sel_project['projectTitle']).'/'; ?>" title="<?php echo $sel_project['projectTitle']; ?>">
                                    <b><?php $unsanaprotit = unsanitize_string(ucfirst($sel_project['projectTitle']));  $protit_len=strlen($unsanaprotit);  if($protit_len>42) {echo substr($unsanaprotit, 0, 42).'...'; } else { echo substr($unsanaprotit, 0, 42); } ?></b>
                                    </a>
                                </strong>
                            </div>
                            
                            <div class="spaser-small"></div>
                            
                            <div>by <a title="<?php echo unsanitize_string(ucfirst($sel_user['name'])); ?>" class="linkblue" href="<?php echo SITE_URL.'profile/'.$sel_user['userId'].'/'.Slug($sel_user['name']).'/'; ?>">
                                <?php $unsanaprotit1=unsanitize_string(ucfirst($sel_user['name']));  $protit_len1=strlen($unsanaprotit1);  if($protit_len1>23) {echo substr($unsanaprotit1, 0, 23).'...'; } else { echo substr($unsanaprotit1, 0, 23); } ?></a>
                            </div>
                            
                            <div class="spaser-small"></div>
                            
                            <div class="textsmall-g">
                            	<span class="location-small"></span>
                                <a title="<?php echo unsanitize_string(ucfirst($sel_project['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_project['projectId'].'/'.Slug(ucfirst($sel_project['projectLocation'])).'/';?>">
									<?php $unsanaprotit2 = unsanitize_string(ucfirst($sel_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
                                </a>
                            </div>
                             <?php $chktime_cur=time(); if($sel_project['projectEnd']<=$chktime_cur) { ?>
                                    	
                                    		<?php
                                            if($sel_project['rewardedAmount']>=$sel_project['fundingGoal'])
                                                { ?>
                                                <div class="project-pledged-successful">
                                                SUCCESSFUL!
                                                </div>
											<?php } else { ?>
                                                <div class="project-pledged-empty"></div>
                                            <?php }  ?>
                                    	
                                    <?php } else { ?>
                            			<div class="project-pledged-empty"></div>
                            		<?php } ?>
                            <div class="spaser-small"></div>
                            
                            <div class="spaser1 display_descraption"><?php echo unsanitize_string(ucfirst($sel_project['shortBlurb']));  ?></div>
                                                        
                            <div class="spaser-small"></div>
                            <div class="gray-line"></div>
                            <?php
								$fundingAmount = (isset($sel_project['fundingGoal']) OR !empty($sel_project['fundingGoal'])) ? $sel_project['fundingGoal'] : 0;
                            	if($fundingAmount != NULL && $fundingAmount > 0){
									$value = $sel_project['rewardedAmount'];
									$max = $sel_project['fundingGoal'];
								}
								$scale = 1.0;
								if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
								else { $percent = 0; }
								if ( $percent > 100 ) { $percent = 100; }
                            ?>
                            <div><p>
                                <div class="percentbar content-slider-percentbar">
                                <div style="width:<?php echo round($percent * $scale); ?>%;"></div>
                                </div></p>
                            </div>
                            
                            <div class="spaser-small"></div>
                            
                            <div class="latest-rating">
                                <ul>
                                    <?php
										if($fundingAmount != NULL && $fundingAmount > 0){
											$value1 = $sel_project['rewardedAmount'];
											$max1 = $sel_project['fundingGoal'];
										}
										$scale = 1.0;
										if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
										else { $percent1 = 0; }
                                    ?>
                                    <li><?php echo (int) $percent1."%"; ?><br>Funded </li>
									
									
                                    	<li> $<?php echo number_format($sel_project['rewardedAmount']); ?><br />Pledged</li>
                                    
                                    
                                        <?php
                                        if($sel_project['projectEnd']>time() && $sel_project['fundingStatus']!='n') {
                                            $end_date=(int) $sel_project['projectEnd'];
                                            $cur_time=time();
                                            $total = $end_date - $cur_time;
                                            $left_days1=$total/(24 * 60 * 60);
                                        } else {
                                            $left_days1=0;
                                        }
                                        ?>
                                    <li class="last"> <?php echo roundDays($left_days1);?><br>
                                        Days to Go </li>
                                </ul>
                            </div>
                        <div class="flclear"></div>
                        </div>
                    </div>
                    </li>
              <?php } 
					}
					}else {?>
						<center><strong>No Record Found.</strong></center>
				<?php } ?>
					</ul>
				</div>
			</div>
			 <?php include(DIR_TMP."content/browse/searchsidebar.tpl.php"); ?>
			<div class="flclear"></div>
		</section>
	</div>
</section>
<!--End-content-->