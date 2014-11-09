<?php
if($content == 'sitesDefault/contentRight'){ 
?>
<link href="<?php echo SITE_CSS; ?>orbit-1.3.0.css" rel="stylesheet" type="text/css" media="screen,projection" />
<script type="text/javascript" src="<?php echo SITE_JAVA; ?>jquery.orbit-1.3.0.js"></script>
<!--[if IE]>
     <style type="text/css">
         .timer { display: none !important; }
        .orbit-wrapper .orbit-caption { background:rgb(0,0,0,0.6); filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000);zoom: 1; }
    </style>
<![endif]-->

<script type="text/javascript">		
	$(document).ready(function(){
	//$(window).load(function() {
		var count = 1;
		$('#sidebarleft').orbit({bullets: true });/* directionalNav: true*/
		$('.orbit-wrapper').addClass("temps");
		
		$(window).bind('load', function() {
			$(".rounded-img, .rounded-img2").load(function() {
				$(this).wrap(function(){
					return '<span class="' + $(this).attr('class') + '" style="background:url(' + $(this).attr('src') + ') no-repeat center center; width: ' + $(this).width() + 'px; height: ' + $(this).height() + 'px;" />';
				});
				$(this).css("opacity","0");
			});
		});
		//$('#sidebarleft').css({ width: 700, height: 370 });
		});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		var t = $("#staff-picks-right a:first").attr("data");
		$("#staff-picks-right a:first").addClass("active");
		$(".catIdAjaxCall").css("cursor","pointer");
		callCatAax(t);
	});
	$(".catIdAjaxCall").click(function(e) {
		e.preventDefault();
	});
	function callCatAax(id){
		$('.catIdAjaxCall').removeClass('active');
		$('.catIdAjaxCall').each(function(){
			if($(this).attr("data") == id){
				$(this).addClass("active");	
			}		
		});	
		
		var link1 = "<?php echo $base_url; ?>templates/content/sitesDefault/content_ajax.php";
		var data = id;
		$.ajax({
			type: "POST", 
			url: link1, 
			dataType: 'html',
			data: { type: data },
			success: function(data1){
				var data_n=data1;
				if ( $.browser.msie ) {
					document.getElementById('staff-picks-left').innerHTML=data_n;
					//$(".staff-picks-left").empty().html(data_n);
				}else{
					$(".staff-picks-left").html("");
					$(".staff-picks-left").html(data_n);	
				}
			}
		});
		return false;
	}
</script>

<div id="content-main">
  <section id="slider">
    <div class="wrapper">
     <?php
	  flush(); 
      //ob_flush();
	  if( ob_get_level() > 0 ) ob_flush();

	  $currentTimeStamp = time();
	  $aboveThreeday = strtotime('+1 day', $currentTimeStamp);
	  $chktime_cur=strtotime(date("Y-m-d H:i:s",time()));					
	$recentProject = $con->recordselect("SELECT projectbasics.projectEnd, projectbasics.projectId, projectbasics.projectTitle, projectbasics.rewardedAmount, projectbasics.fundingStatus,
		projectbasics.projectCategory FROM `projectbasics`
		LEFT JOIN projects ON projects.projectId = projectbasics.projectId
		WHERE projects.published =1 AND projects.accepted =1 AND projectbasics.projectEnd >'".$chktime_cur."' AND projectbasics.fundingStatus = 'r'
		ORDER BY projectbasics.projectId DESC,projectbasics.fundingGoal DESC LIMIT 0 , 4");
																	
		$cnt = mysql_num_rows($recentProject);
		if(mysql_num_rows($recentProject)>0){
			$tempCnt=0;
		?>
        <div id="sidebarleft">
		<?php
			while($sel_smallproject = mysql_fetch_assoc($recentProject)) {
				$sel_sm_image_check = $con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_smallproject['projectId']."'");
				$sel_sm_category_check = $con->recordselect("SELECT * FROM categories WHERE categoryId='".$sel_smallproject['projectCategory']."'");
				$sel_sm_image = mysql_fetch_assoc($sel_sm_image_check);
				$sel_sm_category = mysql_fetch_assoc($sel_sm_category_check);
				$Slideurl = $base_url."browseproject/".$sel_smallproject['projectId'].'/'.Slug($sel_smallproject['projectTitle']).'/';
				if(mysql_num_rows($sel_sm_image_check)>0) {
					$value = DIR_FS.$sel_sm_image['image700by370'];
				} else {
					$value = NOSLIMG;
				}
				$timeLeft = $sel_smallproject['projectEnd'];
				$cur_time=time();
				$total = $timeLeft - $cur_time;
				$left_days=$total/(24 * 60 * 60);
				if($left_days<0 || $sel_smallproject['fundingStatus']=='n'){$left_days=0;}
				
				$otherData = "<span >$".number_format($sel_smallproject['rewardedAmount'])."</span> raised  <span class='spangap12'></span> | <span class='spangap12'></span><span >".roundDays($left_days)."</span> days left";
				//ucwords(strtolower($bar));
				$caption = "<div class='sliderMainContainer'>
					<div class='sliderInnerDiv proejctTitle'>
						<a title='".ucwords(strtolower($sel_smallproject['projectTitle']))."' href='".$Slideurl."' class='slidera'>".ucwords(strtolower($sel_smallproject['projectTitle']))."</a>						
					</div>
					<div class='sliderInnerDiv otherDetail'>
						<a title='".ucwords(strtolower($sel_sm_category['categoryName']))."' href='".$Slideurl."' class='slidera'>".ucwords(strtolower($sel_sm_category['categoryName']))."</a><br />
						".$otherData."
					</div>
					<div class='sliderInnerDivlast'>
						<input style='border-radius: 10px;' class='button-save' type='button' value='View Project »' name='viewProject' onclick=window.location='".$Slideurl."'>
					</div>
				</div>";
			?>
            <?php
				echo '<div class="sliderImgContainer" orbit-caption = "'.$caption.'">';
				echo '<img src="'.$base_url.'modules/roundedCorner.php?source='.$value .'" alt="'.$sel_smallproject['projectTitle'].'" border="0"   id="rounded_img" class="rounded-img"  />';
				echo '</div>';
			?>
        <?php $tempCnt++;
		 } ?>
		</div><!--sidebarleft END -->
       <?php } else { ?>
		<div id="sidebarleft">
		<?php 
			$caption = "<div class='sliderInnerDiv'><a href='javascript:void(0);' class='slidera'>No Projects Yet</a><br />
					<span class='clr'></span><span class='clr'></span>
					</div><div class='sliderInnerDivlast'></div>";
		?>
        <?php
			echo '<img src="'.$base_url.'images/site/no_image_slider.jpg" alt="slider"  orbit-caption = "'.$caption.'" />';
		?>
        <?php /*?><img src="<?php echo $base_url;?>images/site/no_image_slider.jpg" alt="slider"  orbit-caption = "<?php echo $caption; ?>" /><?php */?>
		</div><!--sidebarleft END -->
        <?php } ?>
        
      <div id="sidebarright" class="leftmenu">
        <ul>
        <li>
            <a href="<?php echo $base_url;?>staffpicks/" class="browse">
				<span>
					<p class="heading">Browse</p>
					<p class="names">Projects</p>
				</span>
			</a>
		  </li>
          <li>
            <a href="<?php echo $base_url;?>help/" class="learnhowitwork">
				<span>
					<p class="heading">Learn</p>
					<p class="names">how it works</p>
				</span>
			</a>
		  </li>
          <li>
            <a href="<?php echo $base_url;?>createproject/" class="creatproject">
				<span>
					<p class="heading">Create</p>
					<p class="names">a Project</p>
				</span>
			</a>
		  </li>
        </ul>
      </div>
      <div class="flclear"></div>
      
    </div><!-- wrapper end -->
  </section>
 
 <section id="container">
    <div class="wrapper">
      <section class="staff-picks">
        <div class="staff-picks-left" id="staff-picks-left">
        
		</div>
        <div class="staff-picks-right" id="staff-picks-right">
        	<ul>
				<?php
					$arrCat=array();
					$projectCategory = $con->recordselect("SELECT DISTINCT(p.projectCategory) FROM `projectbasics` as p,`staffpicks` as s  WHERE p.projectId = s.projectId AND s.status != '0' ORDER BY p.projectCategory ASC ");
					while($CategoryData=mysql_fetch_assoc($projectCategory)){
						$arrCat[] = $CategoryData['projectCategory'];
					}
					$arrCat = implode(",", $arrCat);
					if($arrCat != ""){
	                	$projectCategory = $con->recordselect("SELECT * FROM `categories` WHERE isActive=1 AND categoryId IN(".$arrCat.") ORDER BY  categoryName ASC");
					}
                	if(mysql_num_rows($projectCategory)>0){
                		while($CategoryData=mysql_fetch_assoc($projectCategory)) {?>
                			<li>
                            	<a title="<?php echo ucfirst($CategoryData["categoryName"]); ?>" class="catIdAjaxCall" onclick="callCatAax(<?php echo $CategoryData["categoryId"]; ?>)" data-href="<?php echo SITE_URL."templates/content/sitesDefault/content_ajax.php" ; ?>" 
								data = "<?php echo $CategoryData["categoryId"]; ?>" >
									<?php echo ucfirst($CategoryData["categoryName"]); ?>
                                </a>
                            </li>
                		<?php } ?>
                	<?php } ?>
        	</ul>
        </div>
       <div class="flclear"></div>
      </section>
	<section>
    <div class="float-left textbig-b">Latest Projects</div>      
	<?php
	$last_week=time() - (7 * 24 * 60 * 60); //last week
	$currentTime1 = time();
	$sel_reclaunche=$con->recordselect("SELECT `projectStart` , published, projectbasics.projectId
		FROM `projectbasics` LEFT JOIN projects ON projects.projectId = projectbasics.projectId
		WHERE projects.published =1 AND projects.accepted =1 AND projectbasics.projectStart<='$currentTime1'
		ORDER BY projectbasics.projectStart DESC LIMIT 0,4");	
	if(mysql_num_rows($sel_reclaunche)>0){
	?>
        <div class="float-right textnormal-b"><a href="<?php echo $base_url;?>staffpicks/"><strong>See All Projects</strong></a></div>
        <div class="flclear spaser-small"></div>
        <div class="latestprojects latestpro">
        	<ul>
		  	<?php 
			while($chk_reclaunche=mysql_fetch_assoc($sel_reclaunche)){
				$sel_re_project=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$chk_reclaunche['projectId']."'"));
				$chktime_cur=time();  
				if($sel_re_project['fundingStatus']=='n' || ($sel_re_project['projectEnd']<$chktime_cur && $sel_re_project['fundingStatus']=='r')){
					continue;
				}
				$sel_re_categories=mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_re_project['projectCategory']."'"));
				$checkimage=$con->recordselect("SELECT * FROM productimages WHERE projectId='".$chk_reclaunche['projectId']."'");
				$sel_re_image=mysql_fetch_assoc($checkimage);
				$sel_re_peoject_uid=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$chk_reclaunche['projectId']."'"));
				$sel_re_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_re_peoject_uid['userId']."'"));
		?>          
            <li>
              <div class="innerbox">
                	<div class="img_thumb">
						<a title="<?php echo ucfirst($sel_re_project['projectTitle']); ?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $chk_reclaunche['projectId'].'/'.Slug($sel_re_project['projectTitle']).'/'; ?>">
						<?php if(($sel_re_image['image223by169']!=NULL || $sel_re_image['image223by169']!='') && mysql_num_rows($checkimage)>0) { if(file_exists(DIR_FS.$sel_re_image['image223by169'])) { ?>
                        <img src="<?php echo SITE_URL.$sel_re_image['image223by169']; ?>" title="<?php echo $sel_re_project['projectTitle']; ?>" alt="<?php echo $sel_re_project['projectTitle']; ?>"/>
                        <?php } else
                        { ?>
                        <img height="169" src="<?php echo NOIMG; ?>" title="<?php echo $sel_re_project['projectTitle']; ?>" alt="<?php echo $sel_re_project['projectTitle']; ?>"  />
                        <?php	}
                        } else { ?>
                        <img height="169"  src="<?php echo NOIMG; ?>" title="<?php echo $sel_re_project['projectTitle']; ?>" alt="<?php echo $sel_re_project['projectTitle']; ?>" />
                        <?php } ?>
                        </a>
                	</div>
                <div class="poductname">
                	<?php if($sel_re_categories['isActive'] == 1) { ?>
                        <a title="<?php echo ucfirst($sel_re_categories['categoryName']); ?>" href="<?php echo $base_url;?>category/<?php echo $sel_re_categories['categoryId'].'/'.Slug($sel_re_categories['categoryName']).'/'; ?>">
                            <?php echo $sel_re_categories['categoryName']; ?>
                        </a>
                    <?php }else{ ?>
                        <a title="<?php echo $sel_re_categories['categoryName']; ?>" href="javascript:void(0);">
                            <?php echo $sel_re_categories['categoryName']; ?>
                        </a>
                    <?php } ?>
                </div>
                <div class="whitebox">
                  <div class="textnormal-b"><strong>
                    <a title="<?php echo ucfirst($sel_re_project['projectTitle']); ?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $chk_reclaunche['projectId'].'/'.Slug($sel_re_project['projectTitle']).'/'; ?>">
                    <b>
				  	<?php $unsanaprotit = unsanitize_string(ucwords(strtolower($sel_re_project['projectTitle'])));  $protit_len=strlen($unsanaprotit);  if($protit_len>47) {echo substr($unsanaprotit, 0, 47).'...'; } else { echo substr($unsanaprotit, 0, 47); } ?></b></a></strong></div>
                  <div class="spaser-small"></div>
                  <div>by <a title="<?php echo ucfirst($sel_re_user['name']); ?>" href="<?php echo SITE_URL.'profile/'.$sel_re_user['userId'].'/'.Slug($sel_re_user['name']).'/'; ?>" class="linkblue">
				  	<?php $unsanaprotit1=unsanitize_string(ucfirst($sel_re_user['name']));  $protit_len1=strlen($unsanaprotit1);  if($protit_len1>18) {echo substr($unsanaprotit1, 0, 18).'...'; } else { echo substr($unsanaprotit1, 0, 18); } ?>
                   	</a></div>
                  <div class="spaser-small"></div>
                  <div class="textsmall-g">
                  	<span class="location-small"></span>
                    <a title="<?php echo unsanitize_string(ucfirst($sel_re_project['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_re_project['projectId'].'/'.Slug(ucfirst($sel_re_project['projectLocation'])).'/';?>">
						<?php $unsanaprotit2 = unsanitize_string(ucfirst($sel_re_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len>23) {echo substr($unsanaprotit2, 0, 23).'...'; } else { echo substr($unsanaprotit2, 0, 23); } ?>
                    </a>
				  	<?php //$unsanaprotit2 = unsanitize_string(ucfirst($sel_re_project['projectLocation']));  $protit_len=strlen($unsanaprotit2);  if($protit_len2>28) {echo substr($unsanaprotit2, 0, 28).'...'; } else { echo substr($unsanaprotit2, 0, 28); } ?>
                  </div>
					<?php $chktime_cur=time(); if($sel_re_project['projectEnd']<=$chktime_cur) { ?>
                                        
                    <?php
                    if($sel_re_project['rewardedAmount']>=$sel_re_project['fundingGoal'])
                        { ?>
                        <div class="project-pledged-successful">
                        SUCCESSFUL!
                        </div>
                    <?php } else { ?>
                        <div class="project-pledged-empty"></div>
                    <?php } ?>
                            
                    <?php } else { ?>
                        <div class="project-pledged-empty"></div>
                    <?php }  ?>
                  <div class="spaser-small"></div>
                  <div class="spaser1 display_descraption"><?php echo unsanitize_string(ucfirst($sel_re_project['shortBlurb']));  ?></div>
                  <div  ></div>
                  <div class="spaser-small"></div>
                  <div class="gray-line"></div>
                  
				  <?php
				  $fundingAmount = (isset($sel_re_project['fundingGoal']) OR !empty($sel_re_project['fundingGoal'])) ? $sel_re_project['fundingGoal'] : 0;
					if($fundingAmount != NULL && $fundingAmount > 0){
						$value = $sel_re_project['rewardedAmount'];
						$max = $sel_re_project['fundingGoal'];
					}
					$scale = 1.0;
					if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
					else { $percent = 0; }
					if ( $percent > 100 ) { $percent = 100; }
				  ?>
                  
                  <div><p><div class="percentbar content-slider-percentbar">
                    <div style="width:<?php echo round($percent * $scale); ?>%;"></div>
                  </div></p></div>
                                                   
                  <div class="latest-rating">
                    <ul>
						<?php
                        if($fundingAmount != NULL && $fundingAmount > 0){
							$value1 = $sel_re_project['rewardedAmount'];
							$max1 = $sel_re_project['fundingGoal'];
                        }
                        $scale = 1.0;
                        if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
                        else { $percent1 = 0; }
                        ?>
                      <li><?php echo (int) $percent1."%"; ?> <br />
                        Funded </li>
                      <li> $<?php echo number_format($sel_re_project['rewardedAmount']); ?><br />Pledged </li>
					  <?php  if($sel_re_project['projectEnd']>time() && $sel_re_project['fundingStatus']!='n')
								{
									$end_date=(int) $sel_re_project['projectEnd'];
									$cur_time=time();
									$total = $end_date - $cur_time;
									$left_days2=$total/(24 * 60 * 60);
								}
								else
								{
									$left_days2=0;
								} ?>
                      <li class="last"> <?php echo roundDays($left_days2);?><br />
                        Days to Go </li>
                        
                    </ul>
                  </div>
                   <div class="flclear"></div>
                </div>
              </div>
              </li>    		
		<?php }
	 } else {
		echo '<br/><center><p>Recently Launched project Not Found Now.</p></center>';	
	} 
?>  
          </ul>
        </div>
        <div class="flclear"></div>
      </section>
    </div>
  </section>
</div>
<?php
    } else {
		require_once(DIR_TMP."content/".$content.".tpl.php");
    }
?>