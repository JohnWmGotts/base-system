<?php $notfound =0 ; ?>
<section id="container">
	<div class="wrapper">
		<section id="content">
			<div id="sidebarleft" class="inner-sidebarleft">
				<div class="float-left textbig-b">
                <a href="<?php echo $base_url; ?>staffpicks/">Discover </a>/
                Small Projects</div>
				<div class="flclear spaser-small"></div>
				<div class="latestprojects">
					<ul>
					<?php
                        $last_week=time() - (7 * 24 * 60 * 60); //last week
                        $currentTime1 = time();							
                        //$sel_reclaunche=$con->recordselect("SELECT * FROM `projectbasics` WHERE `projectStart` !=0 AND `projectStart` <='$currentTime1' ORDER BY `projectStart` DESC");
                        $sel_samllprojectamount=mysql_fetch_assoc($con->recordselect("SELECT * FROM `smallprojectamount` WHERE id=1"));
                        $sel_smallpro=$con->recordselect("SELECT projectbasics.projectId, projectbasics.projectTitle
                                                            FROM `projectbasics`
                                                            LEFT JOIN projects ON projects.projectId = projectbasics.projectId
                                                            WHERE projectbasics.fundingGoal <= '".$sel_samllprojectamount['amount']."'
                                                            AND projects.published =1
                                                            AND projects.accepted =1
                                                            ORDER BY projectbasics.fundingGoal DESC");
                        
                    
                                    if(mysql_num_rows($sel_smallpro)>0)
                                    {
                                        while($sel_smallproject=mysql_fetch_assoc($sel_smallpro))
                                            {
                                                $sel_sm_project=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$sel_smallproject['projectId']."'"));
												$chktime_cur=time();  
												if($sel_sm_project['fundingStatus']=='n' || ($sel_sm_project['projectEnd']<$chktime_cur && $sel_sm_project['fundingStatus']=='r'))
												{
													continue;
												}
                                                $sel_sm_categories=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_sm_project['projectCategory']."'"));
                                                $sel_sm_image6=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_smallproject['projectId']."'");
                                                $sel_sm_image=mysql_fetch_assoc($sel_sm_image6);
                                                $sel_sm_peoject_uid=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$sel_smallproject['projectId']."'"));
                                                $sel_sm_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_sm_peoject_uid['userId']."'"));
                                    ?>		

						<li>
							<div class="innerbox">
                                <div class="img_thumb"> 
                                    <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_smallproject['projectId'].'/'.Slug($sel_sm_project['projectTitle']).'/'; ?>">
                                    <?php if(($sel_sm_image['image223by169']!=NULL || $sel_sm_image['image223by169']!='') && mysql_num_rows($sel_sm_image6)>0) { if(file_exists(DIR_FS.$sel_sm_image['image223by169'])) { ?>
                                    <img src="<?php echo SITE_URL.$sel_sm_image['image223by169']; ?>" title="<?php echo $sel_sm_project['projectTitle']; ?>" alt="<?php echo $sel_sm_project['projectTitle']; ?>" />
                                    <?php } else
                                    { ?>
                                    <img src="<?php echo NOIMG; ?>" title="<?php echo $sel_sm_project['projectTitle']; ?>" alt="<?php echo $sel_sm_project['projectTitle']; ?>" />
                                    <?php	}
                                    } else { ?>
                                    <img src="<?php echo NOIMG; ?>" title="<?php echo $sel_sm_project['projectTitle']; ?>" alt="<?php echo $sel_sm_project['projectTitle']; ?>"  />
                                    <?php } ?>
                                    </a>
                                </div>
                                
								<div class="poductname">
									<?php if($sel_sm_categories['isActive'] == 1) { ?>
                                        <a title="<?php echo $sel_sm_categories['categoryName']; ?>" href="<?php echo $base_url;?>category/<?php echo $sel_sm_categories['categoryId'].'/'.Slug($sel_sm_categories['categoryName']).'/'; ?>">
                                            <?php echo $sel_sm_categories['categoryName']; ?>
                                        </a>
                                    <?php }else{ ?>
                                        <a title="<?php echo $sel_sm_categories['categoryName']; ?>" href="javascript:void(0);">
                                            <?php echo $sel_sm_categories['categoryName']; ?>
                                        </a>
                            		<?php } ?>
                                </div>
                                
								<div class="whitebox">
									<div class="textnormal-b">
                                    	<strong>
                                            <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_smallproject['projectId'].'/'.Slug($sel_sm_project['projectTitle']).'/'; ?>" title="<?php echo $sel_sm_project['projectTitle']; ?>">
												<b><?php $unsanaprotit = unsanitize_string(ucfirst($sel_sm_project['projectTitle']));  $protit_len=strlen($unsanaprotit);  if($protit_len>42) {echo substr($unsanaprotit, 0, 42).'...'; } else { echo substr($unsanaprotit, 0, 42); } ?></b>
                                            </a>
                                        </strong>
                                    </div>
									<div class="spaser-small"></div>
									<div>by 
                                    	<a title="<?php echo unsanitize_string(ucfirst($sel_sm_user['name'])); ?>" href="<?php echo SITE_URL.'profile/'.$sel_sm_user['userId'].'/'.Slug($sel_sm_user['name']).'/'; ?>" class="linkblue">
											<?php echo $unsanaprotit1=unsanitize_string(ucfirst($sel_sm_user['name']));  $protit_len1=strlen($unsanaprotit1);  if($protit_len1>23) {echo substr($unsanaprotit1, 0, 23).'...'; } else { echo substr($unsanaprotit1, 0, 23); } ?>
                                        </a>
                                    </div>
                                    
									<div class="spaser-small"></div>
									<div class="textsmall-g">
                                    	<span class="location-small"></span>
                                        <a title="<?php echo unsanitize_string(ucfirst($sel_sm_project['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_sm_project['projectId'].'/'.Slug(ucfirst($sel_sm_project['projectLocation'])).'/';?>">
											<?php $unsanaprotit2 = unsanitize_string(ucfirst($sel_sm_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
                                        </a>
										<?php //$unsanaprotit2 = unsanitize_string(ucfirst($sel_sm_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len2>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
                                    </div>
                                    <?php $chktime_cur=time(); if($sel_sm_project['projectEnd']<=$chktime_cur) { ?>
                                    	
                                    		<?php
                                            if($sel_sm_project['rewardedAmount']>=$sel_sm_project['fundingGoal'])
                                                { ?>
                                                <div class="project-pledged-successful">
                                                SUCCESSFUL!
                                                </div>
											<?php } else { ?>
                                                <div class="project-pledged-empty"></div>
                                            <?php }?>
                                    	
                                    <?php } else { ?>
                            			<div class="project-pledged-empty"></div>
                            		<?php } ?>
									<div class="spaser-small"></div>
                                    
                                    <div class="spaser1 display_descraption"><?php echo unsanitize_string(ucfirst($sel_sm_project['shortBlurb']));  ?></div>
                                    								
                                    <div class="spaser-small"></div>
                                    <div class="gray-line"></div>
                     <?php
					 	$fundingAmount = (isset($sel_sm_project['fundingGoal']) OR !empty($sel_sm_project['fundingGoal'])) ? $sel_sm_project['fundingGoal'] : 0;
                     	if($fundingAmount != NULL && $fundingAmount > 0){
							$value = $sel_sm_project['rewardedAmount'];
							$max = $sel_sm_project['fundingGoal'];
						}
						$scale = 1.0;
						if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
						else { $percent = 0; }
						if ( $percent > 100 ) { $percent = 100; }
					 ?>
                  <div><p><div class="percentbar content-slider-percentbar">
                    <div style="width:<?php echo round($percent * $scale); ?>%;"></div>
                  </div></p></div>
                  
                  <div class="spaser-small"></div>
									<div class="latest-rating">
                                    <ul>
				<?php
					if($fundingAmount != NULL && $fundingAmount > 0){
						$value1 = $sel_sm_project['rewardedAmount'];
						$max1 = $sel_sm_project['fundingGoal'];
					}
					$scale = 1.0;
					if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
					else { $percent1 = 0; }
                ?>
                    <li><?php echo (int) $percent1."%"; ?><br>Funded </li>
                    <li> $<?php echo number_format($sel_sm_project['rewardedAmount']); ?><br />Pledged</li>
					<?php
                        if($sel_sm_project['projectEnd']>time() && $sel_sm_project['fundingStatus']!='n')
                        {
                        $end_date=(int) $sel_sm_project['projectEnd'];
                        $cur_time=time();
                        $total = $end_date - $cur_time;
                        $left_days1=$total/(24 * 60 * 60);
                        }
                        else
                        {
                        $left_days1=0;
                        }
                    ?>
						<li class="last"> <?php echo roundDays($left_days1);?><br>Days to Go </li>
										</ul>
										</div>
									<div class="flclear"></div>
								</div>
							</div>
						</li>
						<?php 
					}
					}
					else { $notfound++;?>
					<!--<center><strong>No Record Found.</strong></center>-->
				<?php } ?>
					</ul>
				</div>
                <?php if($notfound>0){ ?>
                <center><strong>No Record Found.</strong></center>
                <?php } ?>
			</div>
			 <?php include(DIR_TMP."content/browse/searchsidebar.tpl.php"); ?>
			<div class="flclear"></div>
		</section>
	</div>
</section>
<!--End-content-->