<?php $noRecordInAll = 0 ; ?>

<script type="text/javascript">
$(document).ready(function(){
var staff_count=$(".staff_picks_li li").length;
var popular_count=$(".popular_li li").length;
//var launched_count=$(".recent_launched_li li").length;
//var small_prjct_count=$(".small_prjct_li li").length;
var mst_fn_count=$(".most_funded_li li").length;
var recent_sc_count=$(".recent_success_li li").length;
var myArray2 = [ 
				{"selector":"staff_picks","count":staff_count},
			 	{"selector":"popular","count":popular_count},
				/*{"selector":"recent_launched","count":launched_count},
				{"selector":"small_prjct","count":small_prjct_count},*/
				{"selector":"most_funded","count":mst_fn_count},
				{"selector":"recent_success","count":recent_sc_count}] ;	
	$.each(myArray2,function(i,v){
		
		
		var selector=myArray2[i]["selector"];
		var count=myArray2[i]["count"];
		
		if(count<=0)
		{
			$("."+selector+"_cont").remove();
			$("."+selector+"_li").remove();
		}
	});

});
</script>
<?php $noRecordInAll = 0 ; ?>
<!--start-content-->
<section id="container">
	<div class="wrapper">
		<section id="content">
			<div id="sidebarleft" class="inner-sidebarleft">
                <div class="float-left textbig-b"><a href="<?php echo $base_url; ?>staffpicks/">Discover </a>/<?php echo $title; ?></div>
				
                <div class="space20"></div>
				<?php
				$comma_separated = array();
				while ($approved_chk = mysql_fetch_assoc($selectProjects)){
					$comma_separated[] = $approved_chk['projectId'];	
				}
				$comma_separated = implode(",", $comma_separated);
				if($comma_separated != ''){
					$sel_staff1 = $con->recordselect("SELECT `staffpicks_id`, `projectId`, `userId`, `adminId`, `status`, count(`projectId`) as total FROM `staffpicks` WHERE projectId IN (".$comma_separated.") AND status=1 group by `projectId` order by total desc");
				
					$totalStaff = mysql_num_rows($sel_staff1);
					if(mysql_num_rows($sel_staff1)>0)
					{
					?>
						<div class="float-left textbig-b staff_picks_cont">Staff Picks</div>
							
						<div class="flclear spaser-small"></div>
						<div class="latestprojects">	
		<!-- Start Staff Picks -->
						<ul class="staff_picks_li">
						<?php $count_i=0;	
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
										$count_i++;	
										if($count_i>3)
										{
											continue;
										}
								$sel_categories=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE  categoryId ='".$sel_project['projectCategory']."'"));
								$sel_image1=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_staff['projectId']."'");
								$sel_image=mysql_fetch_assoc($sel_image1);
								$sel_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_staff['userId']."'"));
						?>		
						<li>
							<div class="innerbox">
								<div class="img_thumb">
									<a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_staff['projectId'].'/'.Slug($sel_project['projectTitle']).'/'; ?>">
									<?php if(($sel_image['image223by169']!=NULL || $sel_image['image223by169']!='') && mysql_num_rows($sel_image1)>0) { if(file_exists(DIR_FS.$sel_image['image223by169'])) { ?>
									<img src="<?php echo SITE_URL.$sel_image['image223by169']; ?>" title="<?php echo $sel_project['projectTitle']; ?>" alt="<?php echo $sel_project['projectTitle']; ?>" />
									<?php } else
									{ ?>
									<img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project['projectTitle']; ?>" alt="<?php echo $sel_project['projectTitle']; ?>"  />
									<?php	}
									} else { ?>
									<img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project['projectTitle']; ?>" alt="<?php echo $sel_project['projectTitle']; ?>"  />
									<?php } ?>
									</a>
								</div>
								
								<div class="poductname">
									<?php if($sel_categories['isActive'] == 1) { ?>
										<a title="<?php echo unsanitize_string(ucfirst($sel_categories['categoryName'])); ?>" href="<?php echo $base_url;?>category/<?php echo $sel_categories['categoryId'].'/'.Slug($sel_categories['categoryName']).'/'; ?>">
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
									
									<div>by <a title="<?php echo unsanitize_string(ucfirst($sel_user['name'])); ?>" href="<?php echo SITE_URL.'profile/'.$sel_user['userId'].'/'.Slug($sel_user['name']).'/'; ?>" class="linkblue">
										<?php $unsanaprotit1=unsanitize_string(ucfirst($sel_user['name']));  $protit_len1=strlen($unsanaprotit1);  if($protit_len1>23) {echo substr($unsanaprotit1, 0, 23).'...'; } else { echo substr($unsanaprotit1, 0, 23); } ?></a>
									</div>
									
									<div class="spaser-small"></div>
									
									<div class="textsmall-g">
										<span class="location-small"></span>
										<a title="<?php echo unsanitize_string(ucfirst($sel_project['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_project['projectId'].'/'.Slug(ucfirst($sel_project['projectLocation'])).'/';?>">
											<?php $unsanaprotit2 = unsanitize_string(ucfirst($sel_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
										</a>
										<?php //$unsanaprotit2 = unsanitize_string(ucfirst($sel_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
									</div>
									<?php $chktime_cur=time(); if($sel_project['projectEnd']<=$chktime_cur) { ?>
												
											<?php
											if($sel_project['rewardedAmount']>=$sel_project['fundingGoal'])
												{ ?>
												<div class="project-pledged-successful">
												SUCCESSFUL!
												</div>
											<?php }else { ?>
												<div class="project-pledged-empty"></div>
											<?php } ?>
												
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
						} ?>
						</ul>
						<div class="space10"></div>
						</div><!-- End latest-project-->

						<div class="border_bottom staff_picks_cont"></div>
						
						<?php if($totalStaff >= 3){ ?>
							<div class="float-right textnormal-b link-textnormal-b margin_top_bottom staff_picks_cont">
								<?php if(isset($cityName)){ ?>
									<a href="<?php echo $base_url; ?>staff/<?php echo $catId; ?>/city/<?php echo $cityId; ?>">See All Staff Picks</a>	
								<?php }else{ ?>
									<a href="<?php echo $base_url; ?>staff/<?php echo $catId ?>">See All Staff Picks</a>
								<?php } ?>
							</div>
						<?php }else{ ?>
							<div class="float-right textnormal-b link-textnormal-b margin_top_bottom">
							</div>
					   <?php } ?>
					   <div class="flclear"></div>

			<?php 	} else { $noRecordInAll++;?>
			
				<!--<center><strong>No Record Found.</strong></center>-->
			<?php 
					} /*End IF-ELSE of Staffpiks*/
			}
		?>
<!-- End Staff Picks -->
		                      
		<?php
		//Popular This Week
		$last_week = time() - (7 * 24 * 60 * 60); //last week
		$currentTime = time();
		if($comma_separated != ''){
			$sel_staff3=$con->recordselect("SELECT `hitId` , `projectId` , `hitTime` , count( `projectId` ) AS total FROM `projecthit` WHERE projectId IN (".$comma_separated.") AND `hitTime` BETWEEN '$last_week' AND '$currentTime' GROUP BY `projectId` ORDER BY total DESC");

			$totalPopular = mysql_num_rows($sel_staff3);
			if(mysql_num_rows($sel_staff3)>0)
			{
			?>
	<!-- Start Popular this week  -->
			<div class="float-left textbig-b popular_cont">Popular This Week</div>
				
			<div class="flclear spaser-small"></div>
			<div class="latestprojects">	
			<ul class="popular_li">
		<?php  $count_i=0;
			while ($approved_chk = mysql_fetch_assoc($sel_staff3))
			{
				$approved_chk1=$con->recordselect("SELECT * FROM projects WHERE projectId='".$approved_chk['projectId']."' AND published=1 AND accepted=1");										
			   
				while($sel_staff_2=mysql_fetch_assoc($approved_chk1))
				{						
				$sel_project2=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$sel_staff_2['projectId']."'"));	
				$chktime_cur=time();  
							if($sel_project2['fundingStatus']=='n' || ($sel_project2['projectEnd']<$chktime_cur && $sel_project2['fundingStatus']=='r'))
									{
										continue;
									}
									$count_i++;	
									if($count_i>3)
									{
										continue;
									}					
				$sel_categories2=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_project2['projectCategory']."'"));
				$sel_image22=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_staff_2['projectId']."'");
				$sel_image2=mysql_fetch_assoc($sel_image22);
				$sel_peoject_uid2=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$sel_project2['projectId']."'"));
				$sel_user2=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_peoject_uid2['userId']."'"));
		?>
				<li>
					<div class="innerbox">
						<div class="img_thumb">
							<a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_staff_2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'; ?>">
							<?php if(($sel_image2['image223by169']!=NULL || $sel_image2['image223by169']!='') && mysql_num_rows($sel_image22)>0) { if(file_exists(DIR_FS.$sel_image2['image223by169'])) { ?>
							<img src="<?php echo SITE_URL.$sel_image2['image223by169']; ?>" title="<?php echo $sel_project2['projectTitle']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>" />
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
				<?php } 
				} ?>
				</ul>
				<div class="space10"></div>
				</div>
				
				<div class="border_bottom popular_cont"></div>
				<?php if($totalPopular >= 3) { ?>
					<div class="float-right textnormal-b link-textnormal-b margin_top_bottom popular_cont">
						<?php if(isset($cityName)){ ?>
							<a href="<?php echo $base_url; ?>popular/<?php echo $catId; ?>/city/<?php echo $cityId; ?>">See All Popular This Week</a>	
						<?php }else{ ?>
							<a href="<?php echo $base_url; ?>popular/<?php echo $catId ?>">See All Popular This Week</a>
						<?php } ?>
					</div>
				<?php }else{ ?>
					<div class="float-right textnormal-b link-textnormal-b margin_top_bottom">
					</div>
			   <?php } ?>
			   <div class="flclear"></div>
				
		<?php }else { $noRecordInAll++;?>
				<!--<center><strong>No Record Found.</strong></center>-->
			<?php 
			} /*End IF-ELSE of Popular*/
		}
		?>
<!-- End Popular this week  -->
		        
		<?php
		$last_week=time() - (7 * 24 * 60 * 60); //last week
		$currentTime = time();							
		if($comma_separated != ''){
			$sel_recsuccess=$con->recordselect("SELECT * FROM projectbasics as pb2, projects as p2 WHERE pb2.projectId IN (".$comma_separated.") AND pb2.projectEnd <='$currentTime' AND pb2.rewardedAmount >= pb2.fundingGoal AND pb2.projectId=p2.projectId AND p2.published=1 AND p2.accepted=1 ORDER BY pb2.projectEnd DESC ");

			//$sel_recsuccess=$con->recordselect("SELECT * FROM projectbasics as pb2, projects as p2 WHERE pb2.projectId IN (".$comma_separated.") AND pb2.projectEnd <='$currentTime' AND pb2.rewardedAmount >= pb2.fundingGoal AND pb2.projectId=p2.projectId AND p2.published=1 AND p2.accepted=1 ORDER BY pb2.projectEnd DESC LIMIT 3");
			$totalRecent = mysql_num_rows($sel_recsuccess);
			if(mysql_num_rows($sel_recsuccess)>0)
				{
				?>
		<!-- Start Recently Successfully Funded  -->
				<div class="float-left textbig-b recent_success_cont">Recently Successful</div>
					
				<div class="flclear spaser-small"></div>
				<div class="latestprojects">        
				<ul class="recent_success_li">
				<?php $count_i=0;
					while ($sel_recsuccess1 = mysql_fetch_assoc($sel_recsuccess))
					{
						$chk_recsuccess1=$con->recordselect("SELECT * FROM projects WHERE projectId='".$sel_recsuccess1['projectId']."' AND published=1 AND accepted=1");										
							
						while($chk_recsuccess=mysql_fetch_assoc($chk_recsuccess1))
						{
						$sel_project=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$chk_recsuccess['projectId']."'"));
						$chktime_cur=time();  
						if($sel_project['fundingStatus']=='n' || ($sel_project['projectEnd']<$chktime_cur && $sel_project['fundingStatus']=='r'))
										{
											continue;
										}
										$count_i++;	
										if($count_i>3)
										{
											continue;
										}
						$sel_categories=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_project['projectCategory']."'"));
						$sel_image4=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$chk_recsuccess['projectId']."'");
						$sel_image=mysql_fetch_assoc($sel_image4);
						$sel_peoject_uid=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$chk_recsuccess['projectId']."'"));
						$sel_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_peoject_uid['userId']."'"));
				?>
						<li>
							<div class="innerbox">
								<div class="img_thumb">
									<a href="<?php echo SITE_URL; ?>browseproject/<?php echo $chk_recsuccess['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'; ?>">
									<?php if(($sel_image['image223by169']!=NULL || $sel_image['image223by169']!='') && mysql_num_rows($sel_image4)>0) { if(file_exists(DIR_FS.$sel_image['image223by169'])) { ?>
									<img src="<?php echo SITE_URL.$sel_image['image223by169']; ?>" title="<?php echo $sel_project['projectTitle']; ?>" alt="<?php echo $sel_project['projectTitle']; ?>"  />
									<?php } else
									{ ?>
									<img src="<?php echo NOIMG; ?>"  title="<?php echo $sel_project['projectTitle']; ?>" alt="<?php echo $sel_project['projectTitle']; ?>"  />
									<?php	}
									} else { ?>
									<img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project['projectTitle']; ?>" alt="<?php echo $sel_project['projectTitle']; ?>"  />
									<?php } ?>
									</a>
								</div>
								
								<div class="poductname">
									<?php if($sel_categories['isActive'] == 1) { ?>
										<a title="<?php echo unsanitize_string(ucfirst($sel_categories['categoryName'])); ?>" href="<?php echo $base_url;?>category/<?php echo $sel_categories['categoryId'].'/'.Slug($sel_categories['categoryName']).'/'; ?>">
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
											<a href="<?php echo SITE_URL; ?>browseproject/<?php echo $chk_recsuccess['projectId'].'/'.Slug($sel_project['projectTitle']).'/'; ?>" title="<?php echo $sel_project['projectTitle'];?>">
											<b><?php $unsanaprotit = unsanitize_string(ucfirst($sel_project['projectTitle']));  $protit_len=strlen($unsanaprotit);  if($protit_len>42) {echo substr($unsanaprotit, 0, 42).'...'; } else { echo substr($unsanaprotit, 0, 42); } ?></b>
											</a>
										</strong>
									</div>
									
									<div class="spaser-small"></div>
									
									<div>by <a title="<?php echo unsanitize_string(ucfirst($sel_user['name'])); ?>" href="<?php echo SITE_URL.'profile/'.$sel_user['userId'].'/'.Slug($sel_user['name']).'/'; ?>" class="linkblue">
										<?php $unsanaprotit1=unsanitize_string(ucfirst($sel_user['name']));  $protit_len1=strlen($unsanaprotit1);  if($protit_len1>23) {echo substr($unsanaprotit1, 0, 23).'...'; } else { echo substr($unsanaprotit1, 0, 23); } ?></a>
									</div>
									
									<div class="spaser-small"></div>
									
									<div class="textsmall-g">
										<span class="location-small"></span>
										<a title="<?php echo unsanitize_string(ucfirst($sel_project['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_project['projectId'].'/'.Slug(ucfirst($sel_project['projectLocation'])).'/';?>">
											<?php $unsanaprotit2 = unsanitize_string(ucfirst($sel_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
										</a>
										<?php //$unsanaprotit2 = unsanitize_string(ucfirst($sel_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
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
											<?php } ?>
												
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
											
											<li> $<?php echo number_format($sel_project['rewardedAmount']); ?><br />Pledged </li>
											
											
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
						} ?>
						</ul>
						<div class="space10"></div>
						</div>
						
						<div class="border_bottom recent_success_cont"></div>
						<?php if($totalRecent >= 3) { ?>
							<div class="float-right textnormal-b link-textnormal-b margin_top_bottom recent_success_cont">
							<?php if(isset($cityName)){ ?>
								<a href="<?php echo $base_url; ?>recentsuccess/<?php echo $catId; ?>/city/<?php echo $cityId; ?>">See All Recently Successful</a>	
							<?php }else{ ?>
								<a href="<?php echo $base_url; ?>recentsuccess/<?php echo $catId ?>">See All Recently Successful</a>
							<?php } ?>
							</div>
						<?php }else { ?>
								<div class="float-right textnormal-b link-textnormal-b margin_top_bottom ">
								</div>
					   <?php } ?>
					   <div class="flclear"></div>
										
				<?php }else { $noRecordInAll++;?>
					<!--<center><strong>No Record Found.</strong></center>-->
				<?php 
				} /*End IF-ELSE of Recent SuccessFully Funded*/
			}
		?> 
<!-- End Recently Successful  -->
		
<!-- Start Most Funded  -->
		<?php
		$last_week=time() - (7 * 24 * 60 * 60); //last week
		$currentTime = time();
		if($comma_separated != ''){
			$sel_mostfunded=$con->recordselect("SELECT *, ((rewardedAmount *100) / fundingGoal) AS total FROM projectbasics as pb1, projects as p1  WHERE pb1.projectId IN(".$comma_separated.") AND pb1.projectEnd <='$currentTime' AND pb1.rewardedAmount >= pb1.fundingGoal AND pb1.projectId=p1.projectId AND p1.published=1 AND p1.accepted=1 ORDER BY total DESC");

			$totalMost = mysql_num_rows($sel_mostfunded);
			if(mysql_num_rows($sel_mostfunded)>0)
			{
			?>
			<div class="float-left textbig-b most_funded_cont">Most Funded</div>
				
			<div class="flclear spaser-small"></div>
			<div class="latestprojects">
			<ul class="most_funded_li">
			<?php $count_i=0;
				while ($sel_mostfunded1 = mysql_fetch_assoc($sel_mostfunded))
				{
					$chk_mostfunded1=$con->recordselect("SELECT * FROM projects WHERE projectId='".$sel_mostfunded1['projectId']."' AND published=1 AND accepted=1");										
					
					while($sel_data=mysql_fetch_assoc($chk_mostfunded1))
					{
						$sel_project=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$sel_data['projectId']."'"));
						$chktime_cur=time();  
						if($sel_project['fundingStatus']=='n' || ($sel_project['projectEnd']<$chktime_cur && $sel_project['fundingStatus']=='r'))
						{
							continue;
						}
						$count_i++;	
						if($count_i>3)
						{
							continue;
						}
						$sel_categories=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_project['projectCategory']."'"));
						$sel_image3=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_data['projectId']."'");
						$sel_image=mysql_fetch_assoc($sel_image3);
						$sel_peoject_uid=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$sel_data['projectId']."'"));
						$sel_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_peoject_uid['userId']."'"));
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
								<a title="<?php echo unsanitize_string(ucfirst($sel_categories['categoryName'])); ?>" href="<?php echo $base_url;?>category/<?php echo $sel_categories['categoryId'].'/'.Slug($sel_categories['categoryName']).'/'; ?>">
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
									<b><?php $unsanaprotit = unsanitize_string(ucfirst($sel_project['projectTitle']));  $protit_len=strlen($unsanaprotit);  if($protit_len>42) {echo substr($unsanaprotit, 0, 42).'...'; } else { echo substr($unsanaprotit, 0, 42); } ?></b>
									</a>
								</strong>
							</div>
							
							<div class="spaser-small"></div>
							
							<div>by <a title="<?php echo unsanitize_string(ucfirst($sel_user['name'])); ?>" href="<?php echo SITE_URL.'profile/'.$sel_user['userId'].'/'.Slug($sel_user['name']).'/'; ?>" class="linkblue">
								<?php $unsanaprotit1=unsanitize_string(ucfirst($sel_user['name']));  $protit_len1=strlen($unsanaprotit1);  if($protit_len1>23) {echo substr($unsanaprotit1, 0, 23).'...'; } else { echo substr($unsanaprotit1, 0, 23); } ?></a>
							</div>
							
							<div class="spaser-small"></div>
							
							<div class="textsmall-g">
								<span class="location-small"></span>
								<a title="<?php echo unsanitize_string(ucfirst($sel_project['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_project['projectId'].'/'.Slug(ucfirst($sel_project['projectLocation'])).'/';?>">
									<?php $unsanaprotit2 = unsanitize_string(ucfirst($sel_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
								</a>
								<?php //$unsanaprotit2 = unsanitize_string(ucfirst($sel_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
							</div>
							<?php $chktime_cur=time(); if($sel_project['projectEnd']<=$chktime_cur) { ?>
											
										<?php
										if($sel_project['rewardedAmount']>=$sel_project['fundingGoal'])
											{ ?>
											<div class="project-pledged-successful">
											SUCCESSFUL!
											</div>
										<?php }else { ?>
											<div class="project-pledged-empty"></div>
										<?php } ?>
											
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
				} ?>
				</ul>
				<div class="space10"></div>
				</div>
				
				<div class="border_bottom most_funded_cont"></div>
				<?php if($totalMost >= 3) { ?>
					<div class="float-right textnormal-b link-textnormal-b margin_top_bottom most_funded_cont">
						<?php if(isset($cityName)){ ?>
							<a href="<?php echo $base_url; ?>mostfunded/<?php echo $catId; ?>/city/<?php echo $cityId; ?>">See All Most Funded</a>	
						<?php }else{ ?>
							<a href="<?php echo $base_url; ?>mostfunded/<?php echo $catId ?>">See All Most Funded</a>
						<?php } ?>
					</div>
				<?php }else { ?>
					<div class="float-right textnormal-b link-textnormal-b margin_top_bottom most_funded_cont">
					</div>
			   <?php } ?>
			   <div class="flclear"></div>
				
		<?php }else { $noRecordInAll++;?>
				
				<!--<center><strong>No Record Found.</strong></center>-->
		<?php 
			} /*End IF-ELSE of Most Funded*/
		}

	?>
<!-- End Most Funded  -->                              	
<?php if($noRecordInAll >=4){ ?><center><strong>No Record Found.</strong></center><?php } ?>
            </div><!-- END sidebarleft -->
			 <?php include(DIR_TMP."content/browse/searchsidebar.tpl.php"); ?>
			<div class="flclear"></div>
		</section>
	</div>
</section>
<!--End-content-->