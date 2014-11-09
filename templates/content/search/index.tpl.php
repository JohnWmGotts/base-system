<section id="container">
	<div class="wrapper">
		<section id="content">
			<div id="sidebarleft" class="inner-sidebarleft">
				<div class="float-left textbig-b">Search Result </div>
				<div class="flclear spaser-small"></div>
				<div class="latestprojects">
					<ul id="search_ul_rec">
            <?php 			
				if(mysql_num_rows($sel_staff2)>0)		
				{
					while ($sel_project2 = mysql_fetch_assoc($sel_staff2))
					{ 
						$chktime_cur=time();  
						if($sel_project2['fundingStatus']=='n' || ($sel_project2['projectEnd']<$chktime_cur && $sel_project2['fundingStatus']=='r'))
						{
							continue;
						}
						$sel_categories2=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE isActive='1' AND categoryId ='".$sel_project2['projectCategory']."'"));
						$sel_image22=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_project2['projectId']."'");
						$sel_image2=mysql_fetch_assoc($sel_image22);
						$sel_peoject_uid2=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$sel_project2['projectId']."'"));
						$sel_user2=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_peoject_uid2['userId']."'"));
			?>
                	<li>
                    <div class="innerbox">
                        
                        <div class="img_thumb">
                            <a href="<?php echo $base_url;?>browseproject/<?php echo $sel_project2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'; ?>">
								<?php if(($sel_image2['image223by169']!=NULL || $sel_image2['image223by169']!='') && mysql_num_rows($sel_image22)>0) { 
								if(file_exists(DIR_FS.$sel_image2['image223by169'])) { ?>
                                	<img src="<?php echo SITE_URL.$sel_image2['image223by169']; ?>" title="<?php echo $sel_project2['projectTitle']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>" />
                                <?php } else
                                { ?>
                                	<img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project2['projectTitle']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>" />
                                <?php	}
                                } else { ?>
                                	<img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project2['projectTitle']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>" />
                                <?php } ?>
                            </a>
                        </div>
                        
                        <div class="poductname">
                        	<?php if($sel_categories2['isActive'] == 1) { ?>
                                <a title="<?php if(isset($sel_categories2['categoryName'])) { echo $sel_categories2['categoryName']; } else { echo 'Unknown'; }?>" href="<?php echo $base_url;?>category/<?php echo $sel_categories2['categoryId'].'/'.Slug($sel_categories2['categoryName']).'/'; ?>">
                                    <?php if(isset($sel_categories2['categoryName'])) { ?>
                                    <?php echo $sel_categories2['categoryName']; ?>
                                    <?php } else { echo 'Unknown'; }?>
                                </a>
                            <?php }else{ ?>
                            	<a title="<?php if(isset($sel_categories2['categoryName'])) { echo $sel_categories2['categoryName']; } else { echo 'Unknown'; }?>" href="javascript:void(0);">
                                    <?php if(isset($sel_categories2['categoryName'])) { ?>
                                    <?php echo $sel_categories2['categoryName']; ?>
                                    <?php } else { echo 'Unknown'; }?>
                                </a>
                            <?php } ?>
                        </div>
                            
                        <div class="whitebox">
                        
                            <div class="textnormal-b">
                                <strong>
                                    <a title="<?php echo unsanitize_string(ucfirst($sel_project2['projectTitle'])); ?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_project2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'; ?>">
                                    <b><?php $unsanaprotit = unsanitize_string(ucfirst($sel_project2['projectTitle']));  $protit_len=strlen($unsanaprotit);   if($sel_project2['projectTitle']!='') { if($protit_len>22) {echo substr($unsanaprotit, 0, 22).'...'; } else { echo substr($unsanaprotit, 0, 22); } } else { echo "Untitled"; } ?></b>
                                    </a>
                                </strong>
                            </div>
                            
                            <div class="spaser-small"></div>
                            
                            <div>by <a title="<?php echo unsanitize_string(ucfirst($sel_user2['name'])); ?>" class="linkblue" href="<?php echo SITE_URL.'profile/'.$sel_user2['userId'].'/'.Slug($sel_user2['name']).'/'; ?>">
                                <?php $unsanaprotit1=unsanitize_string(ucfirst($sel_user2['name']));  $protit_len1=strlen($unsanaprotit1);  if($protit_len1>23) {echo substr($unsanaprotit1, 0, 23).'...'; } else { echo substr($unsanaprotit1, 0, 23); } ?></a>
                            </div>
                            
                            <div class="spaser-small"></div>
                            
                            <div class="textsmall-g">
                            	<span class="location-small"></span>
                                <a title="<?php echo unsanitize_string(ucfirst($sel_project2['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_project2['projectId'].'/'.Slug(ucfirst($sel_project2['projectLocation'])).'/';?>">
									<?php $unsanaprotit2 = unsanitize_string(ucfirst($sel_project2['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
                                </a>
                            </div>
							
							<?php $chktime_cur=time(); if($sel_project2['projectEnd']<=$chktime_cur) { ?>
                            
								<?php
                                if($sel_project2['rewardedAmount']>=$sel_project2['fundingGoal'])
                                { ?>
                                	<div class="project-pledged-successful">SUCCESSFUL!</div>
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
                        
                        </div>
                    </div>
                    </li>
			<?php
                	}
					//While Over
             	} //If Over				
				else
				{?>
					<h3 class="wordwrap">Sorry, no results for "<?php echo htmlentities(stripslashes($_REQUEST['term'])); ?>". </h3>
				<?php } ?>
                
                <?php if(mysql_num_rows($sel_staff2)>0)	{?>
                
                <?php } ?>
            		</ul>
                    <div class="loadmorebtn">
                        <input type="hidden" value="<?php echo $perpage; ?>" id="found_rec">
                        <input type="hidden" value="<?php echo $total_num_records; ?>" id="total_num_records" />
                        <input type="hidden" value="<?php echo $total_rec ?>" id="total_qry_res" />
                        <?php if($total_num_records != $total_rec){ ?>
                            <a href="javascript:;" class="loadmorebtncenter" id="load_more_search">Load More...
                                <span id="wait_1" style="display: none;">
                                    <img alt="Please Wait" src="<?php echo SITE_IMG; ?>ajax-loader.gif">
                                </span>
                            </a>
                        <?php } ?>
                        <?php /*$con->onlyPagging($page,$per_page,8,2,0,1,$extra);*/ ?>
                    </div>
				</div>
            </div>
            <?php include(DIR_TMP."content/browse/searchsidebar.tpl.php"); ?>
			<div class="flclear"></div>
		</section>
	</div>
</section>
<div id="tmp">
</div>
<script>
$(document).ready(function() {
	$("#load_more_search").click(function() {
		var $load_more = $(this);
		try {
			var $found_rec = $("#found_rec");
			var load_rec = parseInt($found_rec.val());
			var $total_num_records = $("#total_num_records");
			var total_num_records1 = parseInt($total_num_records.val());
			$("#wait_1").show();
			$.ajax({
				type		:	"POST",
				dataType	:	"json",
				url			:	"<?php echo SITE_URL; ?>ajax.search.php",
				data		:	{
									per_page	:	'<?php echo $perpage; ?>',
									search_txt	:	'<?php echo $searchTerm; ?>',

									load_rec	:	load_rec
								},
				success		:	function (data) {
									if(parseInt(data["total_rec"]) > 0) {
										load_rec += parseInt(data["total_rec"]);
										$found_rec.val(load_rec);
										
										var html_data = data["html"];
										$("#wait_1").hide();
										$("#search_ul_rec").append(html_data);
										if(total_num_records1 == load_rec){
											$("#wait_1").hide();
											$load_more.hide();
										}
										
									} else {
										$("#wait_1").hide();
										$load_more.hide();
										
									}
								}
			})
		} catch(e) {
			console.log("Erro rin .load_more_search - " + e);
		}
	});
})
</script>