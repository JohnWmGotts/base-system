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
                        	<a href="<?php echo SITE_URL; ?>category/<?php echo $catId.'/'.Slug($catName).'/' ?>"><?php echo $catName ?></a>/
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
						if (isset($selectProjects)) { // jwg fixup
							while ($approved_chk = mysql_fetch_assoc($selectProjects)){
								$comma_separated[] = $approved_chk['projectId'];	
							}
						}
                        $comma_separated = implode(",", $comma_separated);
                        $last_week=time() - (7 * 24 * 60 * 60); //last week
                        $currentTime = time();
                        if($comma_separated != ''){
                            $sel_mostfunded = $con->recordselect("SELECT *, ((rewardedAmount *100) / fundingGoal) AS total FROM projectbasics as pb1, projects as p1  WHERE pb1.projectId IN (".$comma_separated.") AND pb1.projectEnd <='".$currentTime."' AND pb1.rewardedAmount >= pb1.fundingGoal AND pb1.projectId=p1.projectId AND p1.published=1 AND p1.accepted=1 ORDER BY total DESC");
                        }else{
							$selCategory = $con->recordselect("SELECT categoryId as cat_id FROM categories where isActive='1' ORDER BY categoryName ASC");
							
							if(mysql_num_rows($selCategory)>0)
							{
								$products='';
								$cat_ids = '';
								 while($row_cat= mysql_fetch_assoc($selCategory))
								{
									if($row_cat['cat_id']!='')
									{
										$cat_id=$row_cat['cat_id'];
										$cat_ids.=$cat_id.",";
										//$selCategory1=$con->recordselect("SELECT  GROUP_CONCAT(DISTINCT pb.projectId) as pb_products,count( pt.projectId ) AS total from projectbasics as pb,projecthit as pt where pt.projectId=pb.projectId and pb.projectCategory='".$cat_id."' and pt.`hitTime` BETWEEN '".$last_week."' AND '".$currentTime."' GROUP BY pt.`projectId` ORDER BY total DESC LIMIT 3");
										$selCategory1 = $con->recordselect("SELECT  pb1.projectId,((rewardedAmount *100) / fundingGoal) AS total FROM projectbasics as pb1, projects as p1  WHERE pb1.projectEnd <='".$currentTime."' AND pb1.projectCategory='".$cat_id."' AND pb1.rewardedAmount >= pb1.fundingGoal AND pb1.projectId=p1.projectId AND p1.published=1 AND p1.accepted=1 ORDER BY total DESC");
										if(mysql_num_rows($selCategory1)>0)
										{
											$i=0;
											while($rowCat1 = mysql_fetch_assoc($selCategory1))
											{
												if($rowCat1['projectId']!='' && $i<3)
												{
													$products.=$rowCat1['projectId'].",";
													$i++;
												}
												
											}
										}
									}
									
								}
								//print $products;
								if($products!='')
								{
									//$sel_staff3 = $con->recordselect("SELECT pt.hitId , pt.projectId , pt.hitTime, count( pt.projectId ) AS total,ct.categoryName FROM `projecthit` as pt,projectbasics as pb,categories as ct WHERE pt.projectId=pb.projectId and pb.projectCategory IN (".trim($cat_ids,",").") and pb.projectId IN (".trim($products,",").") and pt.`hitTime` BETWEEN '".$last_week."' AND '".$currentTime."' AND ct.categoryId=pb.projectCategory GROUP BY pt.`projectId` ORDER BY ct.categoryName ASC,total DESC");
									$sel_mostfunded = $con->recordselect("SELECT *, ((rewardedAmount *100) / fundingGoal) AS total ,ct.categoryName FROM projectbasics as pb1, projects as p1,categories as ct WHERE pb1.projectEnd <='".$currentTime."' AND pb1.rewardedAmount >= pb1.fundingGoal AND pb1.projectId IN (".trim($products,",").") AND pb1.projectCategory IN (".trim($cat_ids,",").") AND pb1.projectId=p1.projectId AND p1.published=1 AND p1.accepted=1 AND ct.categoryId=pb1.projectCategory ORDER BY ct.categoryName ASC,total DESC");									
								}
								else
								{
									$sel_mostfunded = $con->recordselect("SELECT *, ((rewardedAmount *100) / fundingGoal) AS total FROM projectbasics as pb1, projects as p1  WHERE pb1.projectEnd <='".$currentTime."' AND pb1.rewardedAmount >= pb1.fundingGoal AND pb1.projectId=p1.projectId AND p1.published=1 AND p1.accepted=1 ORDER BY total DESC");
								}
								
							}
							else
							{
								$sel_mostfunded = $con->recordselect("SELECT *, ((rewardedAmount *100) / fundingGoal) AS total FROM projectbasics as pb1, projects as p1  WHERE pb1.projectEnd <='".$currentTime."' AND pb1.rewardedAmount >= pb1.fundingGoal AND pb1.projectId=p1.projectId AND p1.published=1 AND p1.accepted=1 ORDER BY total DESC");
							}
                        }
                        if(mysql_num_rows($sel_mostfunded)>0)
                            { 
								$cat_i=0;
                            while ($sel_mostfunded1 = mysql_fetch_assoc($sel_mostfunded))
                            {
								$cat_i++;
                                $chk_mostfunded1=$con->recordselect("SELECT * FROM projects WHERE projectId='".$sel_mostfunded1['projectId']."' AND published=1 AND accepted=1");										
                                while($sel_data=mysql_fetch_assoc($chk_mostfunded1))
                                {
                                $sel_project=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$sel_data['projectId']."'"));
								$chktime_cur=time();  
								if($sel_project['fundingStatus']=='n' || ($sel_project['projectEnd']<$chktime_cur && $sel_project['fundingStatus']=='r'))
								{
									continue;
								}
                                $sel_categories=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_project['projectCategory']."'"));
                                $sel_image3=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_data['projectId']."'");
                                $sel_image=mysql_fetch_assoc($sel_image3);
                                $sel_peoject_uid=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$sel_data['projectId']."'"));
                                $sel_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_peoject_uid['userId']."'"));
								$current_cat=$sel_categories['categoryId'];
								if($current_cat!=$last_cat)
								{
									$cat_i=1;
								}
								if($cat_i==1)
								{
									$last_cat=$sel_categories['categoryId'];
									echo '<li class="head_title">'.$sel_categories['categoryName'].'</li>';
								}
                        ?>				
						<li>
							<div class="innerbox">
								<div class="img_thumb">
                                    <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_data['projectId'].'/'.Slug($sel_project['projectTitle']).'/'; ?>">
                                    <?php if(($sel_image['image223by169']!=NULL || $sel_image['image223by169']!='') && mysql_num_rows($sel_image3)>0) { if(file_exists(DIR_FS.$sel_image['image223by169'])) { ?>
                                    <img src="<?php echo SITE_URL.$sel_image['image223by169']; ?>" title="<?php echo $sel_project['projectTitle']; ?>" alt="<?php echo $sel_project['projectTitle']; ?>" />
                                    <?php } else
                                    { ?>
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
                                            <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_data['projectId'].'/'.Slug($sel_project['projectTitle']).'/'; ?>" title="<?php echo $sel_project['projectTitle']; ?>">
                                            <b><?php $unsanaprotit = unsanitize_string(ucfirst($sel_project['projectTitle']));  $protit_len=strlen($unsanaprotit);  if($protit_len>42) {echo substr($unsanaprotit, 0, 42).'...'; } else { echo substr($unsanaprotit, 0, 42); } ?></b></a></strong></div>
									<div class="spaser-small"></div>
									<div>by <a title="<?php echo unsanitize_string(ucfirst($sel_user['name'])); ?>" href="<?php echo SITE_URL.'profile/'.$sel_user['userId'].'/'.Slug($sel_user['name']).'/'; ?>" class="linkblue">
										<?php $unsanaprotit1=unsanitize_string(ucfirst($sel_user['name']));  $protit_len1=strlen($unsanaprotit1);  if($protit_len1>23) {echo substr($unsanaprotit1, 0, 23).'...'; } else { echo substr($unsanaprotit1, 0, 23); } ?></a></div>
									<div class="spaser-small"></div>
									<div class="textsmall-g">
                                    
                                    <span class="location-small"></span>
									<a title="<?php echo unsanitize_string(ucfirst($sel_project['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_project['projectId'].'/'.Slug(ucfirst($sel_project['projectLocation'])).'/';?>">
										<?php $unsanaprotit2 = unsanitize_string(ucfirst($sel_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
                                    </a>
									<?php //$unsanaprotit2 = unsanitize_string(ucfirst($sel_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len2>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?></div>
                                    
									<?php $chktime_cur=time(); if($sel_project['projectEnd']<=$chktime_cur) { ?>
                                    	
                                    		<?php
											if($sel_project['rewardedAmount']>=$sel_project['fundingGoal'])
                                                { ?>
                                                <div class="project-pledged-successful">
                                                SUCCESSFUL!
                                                </div>
											<?php } else { ?>
                                                <div class="project-pledged-empty"></div>
                                            <?php } ?>
                                    	
                                    <?php } else { ?>
                            			<div class="project-pledged-empty"></div>
                            		<?php } ?>
                                    <div class="spaser-small"></div>
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
                                  <div><p><div class="percentbar content-slider-percentbar">
                                    <div style="width:<?php echo round($percent * $scale); ?>%;"></div>
                                  </div></p></div>
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
                                                if($sel_project['projectEnd']>time() && $sel_project['fundingStatus']!='n')
                                                {
                                                $end_date=(int) $sel_project['projectEnd'];
                                                $cur_time=time();
                                                $total = $end_date - $cur_time;
                                                $left_days1=$total/(24 * 60 * 60);
                                                }
                                                else
                                                {
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
						<?php if($cat_i==3 && !isset($catId))
							{
								echo '<li class="bottom_link"><a href="'.$base_url.'mostfunded/'.$sel_project['projectCategory'].'" class="see_more_cat">More in '.$sel_categories['categoryName'].'</a></li>';
							}
						}
					}
					}
					else
				{?>
					<center><strong>No Record Found.</strong></center>
				<?php }
				?>
					</ul>
				</div>
			</div>
			 <?php include(DIR_TMP."content/browse/searchsidebar.tpl.php"); ?>
			<div class="flclear"></div>
		</section>
	</div>
</section>
<!--End-content-->