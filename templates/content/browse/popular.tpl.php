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
					$sel_staff3 = $con->recordselect("SELECT `hitId` , `projectId` , `hitTime` , count( `projectId` ) AS total FROM `projecthit` WHERE projectId IN (".$comma_separated.") AND `hitTime` BETWEEN '".$last_week."' AND '".$currentTime."' GROUP BY `projectId` ORDER BY total DESC");
				}else{
					$selCategory = $con->recordselect("SELECT categoryId as cat_id FROM categories where isActive='1' ORDER BY categoryName ASC");
					if(mysql_num_rows($selCategory)>0)
					{
						$products='';
						 while($row_cat= mysql_fetch_assoc($selCategory))
						{
							if($row_cat['cat_id']!='')
							{
								$cat_id=$row_cat['cat_id'];
								$cat_ids.=$cat_id.",";
								$selCategory1=$con->recordselect("SELECT  pb.projectId,count( pt.projectId ) AS total from projectbasics as pb,projecthit as pt where pt.projectId=pb.projectId and pb.projectCategory='".$cat_id."' and pt.`hitTime` BETWEEN '".$last_week."' AND '".$currentTime."' GROUP BY pt.`projectId` ORDER BY total DESC LIMIT 3");
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
							$sel_staff3 = $con->recordselect("SELECT pt.hitId , pt.projectId , pt.hitTime, count( pt.projectId ) AS total,ct.categoryName FROM `projecthit` as pt,projectbasics as pb,categories as ct WHERE pt.projectId=pb.projectId and pb.projectCategory IN (".trim($cat_ids,",").") and pb.projectId IN (".trim($products,",").") and pt.`hitTime` BETWEEN '".$last_week."' AND '".$currentTime."' AND ct.categoryId=pb.projectCategory GROUP BY pt.`projectId` ORDER BY ct.categoryName ASC,total DESC");
						}
						else
						{
							$sel_staff3 = $con->recordselect("SELECT `hitId` , `projectId` , `hitTime` , count( `projectId` ) AS total FROM `projecthit` WHERE `hitTime` BETWEEN '".$last_week."' AND '".$currentTime."' GROUP BY `projectId` ORDER BY total DESC");
						}
					}
					else
					{
						$sel_staff3 = $con->recordselect("SELECT `hitId` , `projectId` , `hitTime` , count( `projectId` ) AS total FROM `projecthit` WHERE `hitTime` BETWEEN '".$last_week."' AND '".$currentTime."' GROUP BY `projectId` ORDER BY total DESC");
					}
				}
				
				if(mysql_num_rows($sel_staff3)>0)
				{
						$cat_i=0;
                while ($approved_chk = mysql_fetch_assoc($sel_staff3))
				{	
						$cat_i++;	
						$approved_chk1 = $con->recordselect("SELECT * FROM projects WHERE projectId = '".$approved_chk['projectId']."' AND published=1 AND accepted=1");
							
						while($sel_staff_2 = mysql_fetch_assoc($approved_chk1))
						{						
							$sel_project2 = mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$sel_staff_2['projectId']."'"));
							$chktime_cur=time();  
							if($sel_project2['fundingStatus']=='n' || ($sel_project2['projectEnd']<$chktime_cur && $sel_project2['fundingStatus']=='r'))
							{
								continue;
							}
							$sel_categories2 = mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_project2['projectCategory']."'"));
							$sel_image22 = $con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_staff_2['projectId']."'");
							$sel_image2 = mysql_fetch_assoc($sel_image22);
							$sel_peoject_uid2 = mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$sel_project2['projectId']."'"));
							$sel_user2 = mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_peoject_uid2['userId']."'"));
							$current_cat=$sel_categories2['categoryId'];
							if($current_cat!=$last_cat)
							{
								$cat_i=1;
							}
							if($cat_i==1)
							{
								$last_cat=$sel_categories2['categoryId'];
								echo '<li class="head_title">'.$sel_categories2['categoryName'].'</li>';
							}
							
			?>		
                <li>
                    <div class="innerbox">
                        
                        <div class="img_thumb">
                            <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_staff_2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'; ?>">
                                <?php if(($sel_image2['image223by169']!=NULL || $sel_image2['image223by169']!='') && mysql_num_rows($sel_image22)>0) { if(file_exists(DIR_FS.$sel_image2['image223by169'])) { ?>
                                    <img src="<?php echo SITE_URL.$sel_image2['image223by169']; ?>" title="<?php echo $sel_project2['projectTitle']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>"  />
                                    <?php } else
                                    { ?>
                                    <img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project2['projectTitle']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>"  />
                             <?php	}
                                 } else { ?>
                                    <img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project2['projectTitle']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>"  />
                                  <?php } ?>
                            </a>
                        </div>
                        
                        <div class="poductname">
                            <?php if($sel_categories2['isActive'] == 1) { ?>
                                <a title="<?php echo unsanitize_string(ucfirst($sel_categories2['categoryName'])); ?>" href="<?php echo $base_url;?>category/<?php echo $sel_categories2['categoryId'].'/'.Slug($sel_categories2['categoryName']).'/'; ?>">
                                    <?php echo $sel_categories2['categoryName']; ?>
                                </a>
                            <?php }else{ ?>
                            	<a title="<?php echo $sel_categories2['categoryName']; ?>" href="javascript:void(0);">
                                    <?php echo $sel_categories2['categoryName']; ?>
                                </a>
                            <?php } ?>
                        </div>
                            
                        <div class="whitebox">
                        	
                            <div class="textnormal-b">
                                <strong>
                                    <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_staff_2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'; ?>" title="<?php echo $sel_project2['projectTitle']; ?>">
                                    <b><?php $unsanaprotit = unsanitize_string(ucfirst($sel_project2['projectTitle']));  $protit_len=strlen($unsanaprotit);  if($protit_len>42) {echo substr($unsanaprotit, 0, 42).'...'; } else { echo substr($unsanaprotit, 0, 42); } ?></b>
                                    </a>
                                </strong>
                            </div>
                            
                            <div class="spaser-small"></div>
                            
                            <div>by <a title="<?php echo unsanitize_string(ucfirst($sel_user2['name'])); ?>" href="<?php echo SITE_URL.'profile/'.$sel_user2['userId'].'/'.Slug($sel_user2['name']).'/'; ?>" class="linkblue">
                                <?php $unsanaprotit1=unsanitize_string(ucfirst($sel_user2['name']));  $protit_len1=strlen($unsanaprotit1);  if($protit_len1>23) {echo substr($unsanaprotit1, 0, 23).'...'; } else { echo substr($unsanaprotit1, 0, 23); } ?></a>
                            </div>
                            
                            <div class="spaser-small"></div>
                            
                            <div class="textsmall-g">
                            	<span class="location-small"></span>
                                <a title="<?php echo unsanitize_string(ucfirst($sel_project2['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_project2['projectId'].'/'.Slug(ucfirst($sel_project2['projectLocation'])).'/';?>">
									<?php $unsanaprotit2 = unsanitize_string(ucfirst($sel_project2['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
                                </a>
                                <?php //$unsanaprotit2 = unsanitize_string(ucfirst($sel_project2['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
                            </div>
                            <?php $chktime_cur=time(); if($sel_project2['projectEnd']<=$chktime_cur) { ?>
                                    	
								<?php
                                if($sel_project2['rewardedAmount']>=$sel_project2['fundingGoal'])
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
                            
                            
                            <div class="spaser1 display_descraption"><?php echo unsanitize_string(ucfirst($sel_project2['shortBlurb']));  ?></div>
                            
                            <div class="spaser-small"></div>
                            <div class="gray-line"></div>
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
											$value1 = $sel_project2['rewardedAmount'];
											$max1 = $sel_project2['fundingGoal'];
										}
										$scale = 1.0;
										if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
										else { $percent1 = 0; }
                                    ?>
                                    <li><?php echo (int) $percent1."%"; ?><br>Funded </li>
                                    
                                    <li> $<?php echo number_format($sel_project2['rewardedAmount']); ?><br />Pledged</li>
                                    
                                        <?php
                                        if($sel_project2['projectEnd']>time() && $sel_project2['fundingStatus']!='n') {
                                            $end_date=(int) $sel_project2['projectEnd'];
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
            <?php  if($cat_i==3 && !isset($catId))
					{
						echo '<li class="bottom_link"><a href="'.$base_url.'popular/'.$sel_project2['projectCategory'].'" class="see_more_cat">More in '.$sel_categories2["categoryName"].'</a></li>';
					}
			  } 
			  				
			 	} }else {?>
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