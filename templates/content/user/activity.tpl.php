<section id="container">
	<div id="inbox" class="head_content temp">
       <h3>Recent Activity</h3>
   </div>
	<div class="tab">
   		<div class="wrapper" id="profile_tabs">
        	<div id="tabs">
                <div class="tab_content_bg">
                    <div class="tab_content">
                    	<div id="a" class="tab_left" >
                    
					<?php
					if(empty($news_array))	
					{
						if($_SESSION['userId']!=$_GET['user'] && isset($_GET['user']) && $_GET['user']!='')
						{ ?>
							<p class="no-content"><?php echo ucfirst($result['name']); ?> has not created any projects.</p>
					<?php } else { ?> 
							<p class="no-content">
							<strong>You haven't published, backed or commented on any projects.</strong> 
							Let's change that! <a href="<?php echo $base_url;?>staffpicks/">Discover projects</a></p>							
					<?php }	
					}						
					$tempNewsArray = array();
					for($tempI = count($news_array); $tempI>0; $tempI--)
					{								
						$tempNewsArray[] = $news_array[$tempI-1];
					}
					$news_array = $tempNewsArray;
					
					if(isset($_GET['page']) && $_GET['page']!='') {
						if($_GET['page']>$lastpage1)
						{
							$_GET['page']=1;
						}
						$val1=($_GET['page']*10)-9;
						$val2=$_GET['page']*10;
					} else {
						$val1=(1*10)-9;
						$val2=1*10;
					}
					for ($i = $val1 ; $i <=$val2; $i++) 
					{
						 if(isset($news_array[$i]['created_date']))
						{ 
						
							/*$sel_3_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
									WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.projectId='".$news_array[$i]['projectId']."'
									AND usr3.userId='".$news_array[$i]['userId']."' AND cat3.categoryId=pb3.projectCategory"));*/
									$sel_3_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
									WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.projectId='".$news_array[$i]['projectId']."'
									AND usr3.userId=p3.userId AND cat3.categoryId=pb3.projectCategory"));
							$sel_3_dataimg=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));
						?>    
						<div class="tab_content_left">
							<a href="<?php echo SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'; ?>">
								<?php if($sel_3_dataimg['image223by169']!='' && file_exists(DIR_FS.$sel_3_dataimg['image223by169'])) { ?>
									<img src="<?php echo SITE_URL.$sel_3_dataimg['image223by169']; ?>" title="<?php echo $sel_3_data['projectTitle']; ?>" alt="<?php echo $sel_3_data['projectTitle']; ?>">
								<?php } else { ?>
									<img src="<?php echo NOIMG; ?>" title="<?php echo $sel_3_data['projectTitle']; ?>" alt="<?php echo $sel_3_data['projectTitle']; ?>">
								<?php } ?>
							</a>
							<div class="right_comment">
								<a title="<?php if($sel_3_data['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_3_data['projectTitle']));} else { echo "Untitled"; }?>" href="<?php echo SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'; ?>">
									<?php if($sel_3_data['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_3_data['projectTitle']));} else { echo "Untitled"; }?>
								</a>
								<span class="Launched_project">Review On A Project</span>
								<span >By <a title="<?php echo $sel_3_data['name']; ?>" class="linkblue" href="<?php echo SITE_URL.'profile/'.$news_array[$i]['userId'].'/'.Slug($sel_3_data['name']).'/'; ?>">
									<?php echo $sel_3_data['name']; ?></a></span>
								
								<ul>
									<img src="<?php echo SITE_IMG; ?>category.png" />
									<li>
										<?php if($sel_3_data['isActive'] == 1) { ?>
                                            <a title="<?php echo unsanitize_string(ucfirst($sel_3_data['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_3_data['categoryId'].'/'.Slug($sel_3_data['categoryName']).'/';?>">
                                                <?php echo unsanitize_string(ucfirst($sel_3_data['categoryName'])); ?>
                                            </a>
                                        <?php }else {?>
                                            <a title="<?php echo unsanitize_string(ucfirst($sel_3_data['categoryName'])); ?>" href="javascript:void(0);">
                                                <?php echo unsanitize_string(ucfirst($sel_3_data['categoryName'])); ?>
                                            </a>
                                        <?php }?>
									</li>
									<img src="<?php echo SITE_IMG; ?>location.png" />
									<li>
										<a title="<?php echo ucfirst($sel_3_data['projectLocation']); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectLocation']).'/';?>">
											<?php echo ucfirst($sel_3_data['projectLocation']); ?>
										</a>
									</li>
									<div class="clear"></div>
								</ul>
								<span class="activity-icon-quote"></span>
								<blockquote class="activity-project_update-blockquote">
									<?php 
										$unsanaprotit2 = unsanitize_string($news_array[$i]['review']);
										$protit_len = strlen($unsanaprotit2);
										if($protit_len>350){echo substr($unsanaprotit2,0, 350).'...'; }
										else { echo substr($unsanaprotit2, 0, 350); } 
									?>
									<?php //echo $news_array[$i]['comment']; ?>
								</blockquote>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					<?php }//for review else if-$news_array[$i]['created_date'] Over 
						else if(isset($news_array[$i]['backingTime'])) 
						{
							$sel_1_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb1, projects as p1, users as usr1, productimages as pi1, categories as cat1 
										WHERE pb1.projectId='".$news_array[$i]['projectId']."' AND p1.projectId='".$news_array[$i]['projectId']."'
										AND usr1.userId='".$news_array[$i]['userId']."' AND pb1.projectCategory = cat1.categoryId "));
							$sel_pro_creater=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects as p2, users as usr2 WHERE p2.projectId='".$news_array[$i]['projectId']."' AND p2.userId = usr2.userId"));
							$sel_backers_activity=mysql_fetch_assoc($con->recordselect("SELECT count( distinct( `userId` )) AS backer_total2 FROM projectbacking WHERE projectId='".$news_array[$i]['projectId']."' "));
							$sel_pro_imgs1=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."'"));
					?>
                        	<div class="tab_content_left">
                            	<?php if($sel_pro_imgs1['image223by169']!='' && file_exists(DIR_FS.$sel_pro_imgs1['image223by169'])) { ?>
                                	<img src="<?php echo SITE_URL.$sel_pro_imgs1['image223by169']; ?>" alt="<?php echo ucfirst($sel_1_data['projectTitle']); ?>" title="<?php echo ucfirst($sel_1_data['projectTitle']); ?>" />
                                <?php } else { ?>
                                	<img src="<?php echo NOIMG; ?>" alt="<?php echo ucfirst($sel_1_data['projectTitle']); ?>" title="<?php echo ucfirst($sel_1_data['projectTitle']); ?>" />
                                <?php } ?>
                                
                                <div class="right_comment">
                                    
                                    <a title="<?php if($sel_1_data['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_1_data['projectTitle'])); } else { echo "Untitled"; }?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $news_array[$i]['projectId'].'/'.Slug($sel_1_data['projectTitle']).'/'; ?>">
                                        <?php if($sel_1_data['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_1_data['projectTitle'])); } else { echo "Untitled"; }?>
                                    </a>
                                    <span >By <a title="<?php echo ucfirst($sel_pro_creater['name']); ?>" class="linkblue" href="<?php echo SITE_URL; ?>profile/<?php echo $sel_pro_creater['userId'].'/'.Slug($sel_pro_creater['name']).'/'; ?>">
											<?php echo ucfirst($sel_pro_creater['name']); ?>
                                        	</a>
                                    </span>
                                    
                                    <span class="Launched_project">Backed A Project</span>
                                    
                                    <ul>
                                        <img src="<?php echo SITE_IMG; ?>category.png" />
                                        <li>
                                        	<?php if($sel_1_data['isActive'] == 1) { ?>
                                                <a title="<?php echo unsanitize_string(ucfirst($sel_1_data['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_1_data['categoryId'].'/'.Slug($sel_1_data['categoryName']).'/';?>">
                                                    <?php echo unsanitize_string(ucfirst($sel_1_data['categoryName'])); ?>
                                                </a>
                                            <?php }else {?>
                                                <a title="<?php echo unsanitize_string(ucfirst($sel_1_data['categoryName'])); ?>" href="javascript:void(0);">
                                                    <?php echo unsanitize_string(ucfirst($sel_1_data['categoryName'])); ?>
                                                </a>
											<?php }?>
                                        </li>
                                        <img src="<?php echo SITE_IMG; ?>location.png" />
                                        <li>
                                        	<a title="<?php echo ucfirst($sel_1_data['projectLocation']); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $news_array[$i]['projectId'].'/'.Slug($sel_1_data['projectLocation']).'/';?>">
												<?php echo ucfirst($sel_1_data['projectLocation']); ?>
                                            </a>
                                        </li>
                                        <div class="clear"></div>
                                    </ul>
                                    <p><?php echo unsanitize_string(ucfirst($sel_1_data['shortBlurb'])); ?></p>
                                    
                                    <?php $chktime_cur=time(); if($sel_1_data['projectEnd']<=$chktime_cur) { ?>
                                    	<h4 class="sticker">
                                    		<?php if($sel_1_data['rewardedAmount']>=$sel_1_data['fundingGoal'])
                                                { ?>
                                                SUCCESSFUL!
											<?php } else { ?>
                                                FUNDING UNSUCCESSFUL
                                            <?php } ?>
                                    	</h4>
                                    <?php } ?>
                                    
                                    <div class="clear"></div>
                                    <?php
									$fundingAmount = (isset($sel_1_data['fundingGoal']) OR !empty($sel_1_data['fundingGoal'])) ? $sel_1_data['fundingGoal'] : 0;
                                    	if($fundingAmount != NULL && $fundingAmount > 0){
											$value = $sel_1_data['rewardedAmount'];
											$max = $sel_1_data['fundingGoal'];
										}
										$scale = 1.0;
										if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
										else { $percent = 0; }
										if ( $percent > 100 ) { $percent = 100; }
									?>
                                    
                                    <div class="progress_bar">    
                                        <div style="width:<?php echo round($percent * $scale); ?>%;" class="progres"></div>
                                    </div>
                                    <div class="bottom">
                                        <ul>
                                        	<?php
												if($fundingAmount != NULL && $fundingAmount > 0){
													$value1 = $sel_1_data['rewardedAmount'];
													$max1 = $sel_1_data['fundingGoal'];
												}
												$scale = 1.0;
												if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
												else { $percent1 = 0; }
											?>
                                            
                                        	<li><?php echo (int) $percent1."%"; ?> Funded </li>
                                            
                                            <li>|</li>
                                            
                                            <li> $<?php echo number_format($sel_1_data['rewardedAmount']); ?> Pledged</li>
                                            
                                            <li>|</li>
											
											<?php
												if($sel_1_data['projectEnd']>time()  && $sel_1_data['fundingStatus']!='n')
												{
													$end_date=(int) $sel_1_data['projectEnd'];
													$cur_time=time();
													$total = $end_date - $cur_time;
													$left_days=$total/(24 * 60 * 60);
												} else {
													$left_days=0;
												}
											?>
                                            
                                        	<li><?php echo roundDays($left_days);?> days left</li>
                                            
                                            <div class="clear"></div>
                                        </ul>
                                    </div>
                                </div>
                            	<div class="clear"></div>
                        	</div>
						<?php
                        }//If-$news_array[$i]['backingTime'] Over
						else if(isset($news_array[$i]['accepted']))
						{ 
							$sel_5_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb1, projects as p1, users as usr1, categories as cat1 
										WHERE pb1.projectId='".$news_array[$i]['projectId']."' AND p1.projectId='".$news_array[$i]['projectId']."'
										AND usr1.userId='".$news_array[$i]['userId']."' AND pb1.projectCategory = cat1.categoryId "));
							$sel_pro_creater5=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects as p2, users as usr2 WHERE p2.projectId='".$news_array[$i]['projectId']."' AND p2.userId = usr2.userId"));
							$sel_backers_activity=mysql_fetch_assoc($con->recordselect("SELECT count( distinct( `userId` )) AS backer_total2 FROM projectbacking WHERE projectId='".$news_array[$i]['projectId']."' "));
							$sel_pro_imgs=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."'"));
						?>    	   
                            <div class="tab_content_left">
                            	<?php if($sel_pro_imgs['image223by169']!='' && file_exists(DIR_FS.$sel_pro_imgs['image223by169'])) { ?>
                                	<img src="<?php echo SITE_URL.$sel_pro_imgs['image223by169']; ?>"  alt="<?php echo ucfirst($sel_5_data['projectTitle']); ?>" title="<?php echo ucfirst($sel_5_data['projectTitle']); ?>" />
                                <?php } else { ?>
                                	<img src="<?php echo NOIMG; ?>"  alt="<?php echo ucfirst($sel_5_data['projectTitle']); ?>" title="<?php echo ucfirst($sel_5_data['projectTitle']); ?>" />
                                <?php } ?>
                                <div class="right_comment">
                                    <a title="<?php if($sel_5_data['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_5_data['projectTitle'])); } else { echo "Untitled"; }?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_5_data['projectId'].'/'.Slug($sel_5_data['projectTitle']).'/'; ?>">
										<?php if($sel_5_data['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_5_data['projectTitle'])); } else { echo "Untitled"; }?>
                                    </a>
									<span class="Launched_project">Launched A Project</span>
                                    <span >By <a title="<?php echo ucfirst($sel_pro_creater5['name']); ?>" class="linkblue" href="<?php echo SITE_URL; ?>profile/<?php echo $sel_pro_creater5['userId'].'/'.Slug($sel_pro_creater5['name']).'/'; ?>">
										<?php echo ucfirst($sel_pro_creater5['name']); ?></a></span>
                                    
                                    <ul>
                                        <img src="<?php echo SITE_IMG; ?>category.png" />
                                        <li>
                                        	<a title="<?php echo unsanitize_string(ucfirst($sel_5_data['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_5_data['categoryId'].'/'.Slug($sel_5_data['categoryName']).'/';?>">
												<?php echo unsanitize_string(ucfirst($sel_5_data['categoryName'])); ?>
                                            </a>
                                        </li>
                                        <img src="<?php echo SITE_IMG; ?>location.png" />
                                        <li>
                                        	<a title="<?php echo ucfirst($sel_5_data['projectLocation']); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $news_array[$i]['projectId'].'/'.Slug($sel_5_data['projectLocation']).'/';?>">
												<?php echo ucfirst($sel_5_data['projectLocation']); ?>
                                            </a>
                                        </li>
                                        <div class="clear"></div>
                                    </ul>
                                    <p><?php echo unsanitize_string(ucfirst($sel_5_data['shortBlurb'])); ?></p>
                                    
                                    <?php $chktime_cur=time(); if($sel_5_data['projectEnd']<=$chktime_cur) { ?>
                                        <h4 class="sticker">
                                            <?php if($sel_5_data['rewardedAmount']>=$sel_5_data['fundingGoal'])
                                                { ?>
                                                    SUCCESSFUL!
                                            <?php } else { ?>
                                                    FUNDING UNSUCCESSFUL
                                            <?php } ?>
                                        </h4>
                                    <?php  } ?>
                                    
                                    <div class="clear"></div>
                                    <?php
										$fundingAmount = (isset($sel_5_data['fundingGoal']) OR !empty($sel_5_data['fundingGoal'])) ? $sel_5_data['fundingGoal'] : 0;
										if($fundingAmount != NULL && $fundingAmount > 0){
											$value = $sel_5_data['rewardedAmount'];
											$max = $sel_5_data['fundingGoal'];
										}
										$scale = 1.0;
										if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
										else { $percent = 0; }
										if ( $percent > 100 ) { $percent = 100; }
									?>
									
                                    <div class="progress_bar">
                                        <div style="width:<?php echo round($percent * $scale); ?>%;" class="progres"></div>
                                    </div>
                                    <div class="bottom">
                                    <ul>
                                    	<?php
											if($fundingAmount != NULL && $fundingAmount > 0){
												$value1 = $sel_5_data['rewardedAmount'];
												$max1 = $sel_5_data['fundingGoal'];
											}
											$scale = 1.0;
											if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
											else { $percent1 = 0; }
										?>
                                        
                                        <li><?php echo (int) $percent1."%"; ?> Funded </li>
                                        <li>|</li>
                                        <li> $<?php echo number_format($sel_5_data['rewardedAmount']); ?> Pledged</li>
                                        <li>|</li>
                                        <?php
											if($sel_5_data['projectEnd']>time()  && $sel_5_data['fundingStatus']!='n')
											{
												$end_date=(int) $sel_5_data['projectEnd'];
												$cur_time=time();
												$total = $end_date - $cur_time;
												$left_days=$total/(24 * 60 * 60);
											} else {
												$left_days=0;
											}
										?>
                                        <li><?php echo roundDays($left_days);?> days left</li>
										
                                        <div class="clear"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php											
							}//else if-$news_array[$i]['accepted'] Over
						else if(isset($news_array[$i]['commentTime']))
						{ 
						
							/*$sel_3_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
									WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.projectId='".$news_array[$i]['projectId']."'
									AND usr3.userId='".$news_array[$i]['userId']."' AND cat3.categoryId=pb3.projectCategory"));*/
									$sel_3_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
									WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.projectId='".$news_array[$i]['projectId']."'
									AND usr3.userId=p3.userId AND cat3.categoryId=pb3.projectCategory"));
							$sel_3_dataimg=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));
						?>    
						<div class="tab_content_left">
							<a href="<?php echo SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'; ?>">
								<?php if($sel_3_dataimg['image223by169']!='' && file_exists(DIR_FS.$sel_3_dataimg['image223by169'])) { ?>
									<img src="<?php echo SITE_URL.$sel_3_dataimg['image223by169']; ?>" title="<?php echo $sel_3_data['projectTitle']; ?>" alt="<?php echo $sel_3_data['projectTitle']; ?>">
								<?php } else { ?>
									<img src="<?php echo NOIMG; ?>" title="<?php echo $sel_3_data['projectTitle']; ?>" alt="<?php echo $sel_3_data['projectTitle']; ?>">
								<?php } ?>
							</a>
							<div class="right_comment">
								<a title="<?php if($sel_3_data['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_3_data['projectTitle']));} else { echo "Untitled"; }?>" href="<?php echo SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'; ?>">
									<?php if($sel_3_data['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_3_data['projectTitle']));} else { echo "Untitled"; }?>
								</a>
								<span class="Launched_project">Commented On A Project</span>
								<span >By <a title="<?php echo $sel_3_data['name']; ?>" class="linkblue" href="<?php echo SITE_URL.'profile/'.$news_array[$i]['userId'].'/'.Slug($sel_3_data['name']).'/'; ?>">
									<?php echo $sel_3_data['name']; ?></a></span>
								
								<ul>
									<img src="<?php echo SITE_IMG; ?>category.png" />
									<li>
										<?php if($sel_3_data['isActive'] == 1) { ?>
                                            <a title="<?php echo unsanitize_string(ucfirst($sel_3_data['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_3_data['categoryId'].'/'.Slug($sel_3_data['categoryName']).'/';?>">
                                                <?php echo unsanitize_string(ucfirst($sel_3_data['categoryName'])); ?>
                                            </a>
                                        <?php }else {?>
                                            <a title="<?php echo unsanitize_string(ucfirst($sel_3_data['categoryName'])); ?>" href="javascript:void(0);">
                                                <?php echo unsanitize_string(ucfirst($sel_3_data['categoryName'])); ?>
                                            </a>
                                        <?php }?>
									</li>
									<img src="<?php echo SITE_IMG; ?>location.png" />
									<li>
										<a title="<?php echo ucfirst($sel_3_data['projectLocation']); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectLocation']).'/';?>">
											<?php echo ucfirst($sel_3_data['projectLocation']); ?>
										</a>
									</li>
									<div class="clear"></div>
								</ul>
								<span class="activity-icon-quote"></span>
								<blockquote class="activity-project_update-blockquote">
									<?php 
										$unsanaprotit2 = unsanitize_string($news_array[$i]['comment']);
										$protit_len = strlen($unsanaprotit2);
										if($protit_len>350){echo substr($unsanaprotit2,0, 350).'...'; }
										else { echo substr($unsanaprotit2, 0, 350); } 
									?>
									<?php //echo $news_array[$i]['comment']; ?>
								</blockquote>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					<?php }//else if-$news_array[$i]['commentTime'] Over 
						else if(isset($news_array[$i]['updateTime']))
						{ 
							 $sel_2_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb2, projects as p2, users as usr2, categories as cat2 
									 WHERE pb2.projectId='".$news_array[$i]['projectId']."' AND p2.projectId='".$news_array[$i]['projectId']."'
									 AND usr2.userId='".$news_array[$i]['userId']."' AND cat2.categoryId=pb2.projectCategory"));
							$sel_2_dataimg=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));
						?>
						<div class="tab_content_left">
							<a href="<?php echo SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_2_data['projectTitle']).'/'; ?>">
								<?php if($sel_2_dataimg['image223by169']!='' && file_exists(DIR_FS.$sel_2_dataimg['image223by169'])) { ?>
								<img src="<?php echo SITE_URL.$sel_2_dataimg['image223by169']; ?>" title="<?php echo ucfirst($sel_2_data['projectTitle']); ?>" alt="<?php echo ucfirst($sel_2_data['projectTitle']); ?>">
								<?php } else { ?>
								<img src="<?php echo NOIMG; ?>" title="<?php echo ucfirst($sel_2_data['projectTitle']); ?>" alt="<?php echo ucfirst($sel_2_data['projectTitle']); ?>">
								<?php } ?>
							</a>
							<div class="right_comment">
								<a title="<?php if($sel_2_data['projectTitle']!='') {echo unsanitize_string(ucfirst($sel_2_data['projectTitle'])); } else { echo "Untitled"; } ?>" href="<?php echo SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_2_data['projectTitle']).'/'; ?>">
									  <?php if($sel_2_data['projectTitle']!='') {echo unsanitize_string(ucfirst($sel_2_data['projectTitle'])); } else { echo "Untitled"; } ?>
								</a>
								<span class="Launched_project">Posted Project Update #<?php echo $news_array[$i]['updatenumber']; ?></span>
								<span >By <a title="<?php echo $sel_2_data['name']; ?>" class="linkblue" href="<?php echo SITE_URL.'profile/'.$news_array[$i]['userId'].'/'.Slug($sel_2_data['name']).'/'; ?>">
									<?php echo $sel_2_data['name']; ?></a></span>
								
								<ul>
									<img src="<?php echo SITE_IMG; ?>category.png" />
									<li>
                                    	<?php if($sel_2_data['isActive'] == 1) { ?>
                                            <a title="<?php echo unsanitize_string(ucfirst($sel_2_data['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_2_data['categoryId'].'/'.Slug($sel_2_data['categoryName']).'/';?>">
                                                <?php echo unsanitize_string(ucfirst($sel_2_data['categoryName'])); ?>
                                            </a>
                                        <?php }else {?>
                                            <a title="<?php echo unsanitize_string(ucfirst($sel_2_data['categoryName'])); ?>" href="javascript:void(0);">
                                                <?php echo unsanitize_string(ucfirst($sel_2_data['categoryName'])); ?>
                                            </a>
                                        <?php }?>
									</li>
									<img src="<?php echo SITE_IMG; ?>location.png" />
									<li>
										<a title="<?php echo ucfirst($sel_2_data['projectLocation']); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $news_array[$i]['projectId'].'/'.Slug($sel_2_data['projectLocation']).'/';?>">
											<?php echo ucfirst($sel_2_data['projectLocation']); ?>
										</a>
									</li>
									<div class="clear"></div>
								</ul>
								<span class="activity-icon-quote"></span>
								<blockquote class="activity-project_update-blockquote">
									<a href="<?php echo SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_2_data['projectTitle']).'/'.'/&update='.$news_array[$i]['updatenumber'].'#b'; ?>">
										<?php echo unsanitize_string(ucfirst($news_array[$i]['updateTitle'])); ?>
									</a>
									<?php 
										$unsanaprotit2 = unsanitize_string($news_array[$i]['updateDescription']);
										$protit_len = strlen($unsanaprotit2);
										if($protit_len>350){echo substr($unsanaprotit2,0, 350).'...'; }
										else { echo substr($unsanaprotit2, 0, 350); } 
									?>
									<?php //echo unsanitize_string($news_array[$i]['updateDescription']); ?>
									
								</blockquote>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					<?php }//else if-$news_array[$i]['updateTime'] Over 
						else if(isset($news_array[$i]['updateCommentTime']))
						{  
							$sel_4_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb4, projects as p4, users as usr4, categories as cat4 
									  WHERE pb4.projectId='".$news_array[$i]['projectId']."' AND p4.projectId='".$news_array[$i]['projectId']."'
									  AND usr4.userId=p4.userId AND cat4.categoryId=pb4.projectCategory"));
							$sel_4_dataimg=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));
						?>
						<div class="tab_content_left">
							<a href="<?php echo SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_4_data['projectTitle']).'/'; ?>">
								<?php if($sel_4_dataimg['image223by169']!='' && file_exists(DIR_FS.$sel_4_dataimg['image223by169'])) { ?>
								<img  src="<?php echo SITE_URL.$sel_4_dataimg['image223by169']; ?>" title="<?php echo ucfirst($sel_4_data['projectTitle']); ?>" alt="<?php echo ucfirst($sel_4_data['projectTitle']); ?>">
								<?php } else { ?>
								<img  src="<?php echo NOIMG; ?>" title="<?php echo ucfirst($sel_4_data['projectTitle']); ?>" alt="<?php echo ucfirst($sel_4_data['projectTitle']); ?>">
								<?php } ?>
							</a>
							<div class="right_comment">
								<a title="<?php if($sel_4_data['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_4_data['projectTitle'])); }else { echo "Untitled"; } ?>" href="<?php echo SITE_URL.'/browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_4_data['projectTitle']).'/'; ?>">
									<?php if($sel_4_data['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_4_data['projectTitle'])); }else { echo "Untitled"; } ?>
								</a>
								<span class="Launched_project">Commented On A Project Update</span>
								<span >By <a title="<?php echo ucfirst($sel_4_data['name']); ?>" class="linkblue" href="<?php echo SITE_URL.'profile/'.$news_array[$i]['userId'].'/'.Slug($sel_4_data['name']).'/'; ?>">
									<?php echo ucfirst($sel_4_data['name']); ?></a></span>
								
								<ul>
									<img src="<?php echo SITE_IMG; ?>category.png" />
									<li>
                                    	<?php if($sel_4_data['isActive'] == 1) { ?>
										<a title="<?php echo unsanitize_string(ucfirst($sel_4_data['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_4_data['categoryId'].'/'.Slug($sel_4_data['categoryName']).'/';?>">
											<?php echo unsanitize_string(ucfirst($sel_4_data['categoryName'])); ?>
										</a>
                                        <?php }else {?>
                                            <a title="<?php echo unsanitize_string(ucfirst($sel_4_data['categoryName'])); ?>" href="javascript:void(0);">
                                                <?php echo unsanitize_string(ucfirst($sel_4_data['categoryName'])); ?>
                                            </a>
                                        <?php }?>
									</li>
									<img src="<?php echo SITE_IMG; ?>location.png" />
									<li>
										<a title="<?php echo ucfirst($sel_4_data['projectLocation']); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $news_array[$i]['projectId'].'/'.Slug($sel_4_data['projectLocation']).'/';?>">
											<?php echo ucfirst($sel_4_data['projectLocation']); ?>
										</a>
									</li>
									<div class="clear"></div>
								</ul>
								<span class="activity-icon-quote"></span>
								<blockquote class="activity-project_update-blockquote">
									<?php 
										$unsanaprotit2 = unsanitize_string($news_array[$i]['updateComment']);
										$protit_len = strlen($unsanaprotit2);
										if($protit_len>350){echo substr($unsanaprotit2,0, 350).'...'; }
										else { echo substr($unsanaprotit2, 0, 350); } 
									?>
									<?php //echo $news_array[$i]['updateComment']; ?>
								</blockquote>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					  <?php } //Else if - $news_array[$i]['updateCommentTime'] Over
						} //For Loop Over
					?>
                        <div class="pagination">
                            <center><?php echo $activity_pagination; ?></center>
                        </div>
                    </div>
                    
                    	<div class="clear"></div>
                    </div>
                </div>    
            </div>
		</div>
	</div>
</section>