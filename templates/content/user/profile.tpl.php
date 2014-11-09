<link href="<?php echo SITE_CSS ?>jquery-ui.css" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="<?php echo SITE_JS; ?>jquery-ui.js"></script>
<script>
$(document).ready(function(){
	var arr = [ "#a", "#b", "#c", "#d" ];
	var arr1 = ["#aa", "#bb", "#cc", "#dd"];
	if ( $.browser.msie ) {
 		var hash = document.URL.substr(document.URL.indexOf('#'));
	}else{
  		var hash = window.location.hash;
	}
	
	$(".tab_left").fadeOut(0);
	$(".tab_header_left ul li").removeClass("activate");
		
	if(jQuery.inArray( hash, arr ) != -1)
	{
		$(hash).fadeIn("slow");
		var selecter = '#'+hash.substr(hash.indexOf('#')+1)+hash.substr(hash.indexOf('#')+1);
		if(jQuery.inArray( selecter, arr1 ) != -1){
			$(selecter).addClass("activate");	
		}
		
	}else{
		$(".tab_left").fadeOut(0);
		$("#a").fadeIn("slow");
		$("#aa").addClass("activate");
		
	}
	
	<?php if(isset($get_user)){ $user = $get_user;}else { $user = $ses_user; } ?>

	$(".tab_header_left ul li").click(function(){
		var $tab = $(this);
		var id = $tab.attr("id");
		var tab = $tab.attr("data-tab");
		//$("#dv_content_" +tab+ " .tab_content_left").last().addClass("last");
		path = application_path + "profile/" + <?php echo $user;  ?> + "/#"+tab;
		//window.location.hash = "#" + tab;
		//document.location.href = path;
		$(".tab-content").fadeOut(0);
		//$("#dv_content_"+tab).fadeOut(0);
		$(".tab_header_left ul li").removeClass("activate");
		$("#"+tab).fadeIn("slow");
		//$("#dv_content_"+tab).fadeIn("slow");
		$("#"+id).addClass("activate");
		
		//window.location.reload(true);
		//alert(tab);
		/*$(".tab_header_left ul li").removeClass("activate");
		$(this).addClass("activate");*/
	});

	/*$(".profile-tab").click(function() {
		var $tab = $(this);
		var id = $tab.attr("id");
		var tab = $tab.attr("data-tab");
		path = application_path + "profile/" + <?php //echo $user;  ?> + "/#"+tab;
		
		window.location.hash = "#" + tab;
		window.location.reload(true);
		
		//document.location.href = path;
		//$(".tab-content").fadeOut(0);
		//$("#"+tab).fadeIn("slow");
		//$("#"+id).addClass("activate");
	});*/
});
</script>

<script type="text/javascript">
	$(document).ready(function () {
	$(".modal_dialog").hide();
	$('.modal_show').click(function () {
	$(".modal_dialog").fadeToggle(10);
	});
});
</script>

<section id="container">
   
	<div id="get_started_header_profile" class="head_content temp">
         <div class="wrapper">
             <div class="head_img_profile">
                <?php 
                if(!isset($_GET['user']) || ($_SESSION["userId"] == $_GET['user'])) 
                {
                    if($result['profilePicture']!=NULL && $result['profilePicture']!= '') {
                        $check_img=str_split($result['profilePicture'], 4);
						
                        if($check_img[0]=='http') { 
						$temp_if=Aspect_Ration($result['profilePicture'],220);
						?>
                            <a href="<?php echo SITE_URL; ?>profile/edit/"><img src="<?php echo $result['profilePicture']; ?>" alt="Profile image" title="<?php echo $result['name'] ?>" <?php /*?>height="<?php print $temp_if['h']; ?>" width="<?php print $temp_if['w']; ?>"<?php */?> /></a>
                        <?php } else if(file_exists(DIR_FS.$result['profilePicture']) && $check_img[0]=='imag') {
							$temp_i=Aspect_Ration(SITE_URL.$result['profilePicture'],220);
							 ?>
                            <a href="<?php echo SITE_URL; ?>profile/edit/"><img src="<?php echo SITE_URL.$result['profilePicture']; ?>" alt="Profile image" title="<?php echo $result['name'] ?>" <?php /*?>height="<?php print $temp_i['h']; ?>" width="<?php print $temp_i['w']; ?>" <?php */?>/></a>
                        <?php } else {	?>
                            <a href="<?php echo SITE_URL; ?>profile/edit/"><img src="<?php echo NOIMG; ?>" alt="Profile image" title="<?php echo $result['name'] ?>"   /></a>
                        <?php }
                    } else { ?>
                        <a href="<?php echo SITE_URL; ?>profile/edit/"><img src="<?php echo NOIMG; ?>" title="No-image" alt="Profile image"  /></a>
                  <?php }
                } else { 
                    if($result['profilePicture']!=NULL && $result['profilePicture']!= '') {
                        $check_img=str_split($result['profilePicture'], 4);
                        if($check_img[0]=='http') { 
						$temp_if=Aspect_Ration($result['profilePicture'],220);
						?>
                            <a href="javascript:void(0);"><img src="<?php echo $result['profilePicture']; ?>" alt="Profile image" title="<?php echo $result['name'] ?>"  <?php /*?>height="<?php print $temp_if['h']; ?>" width="<?php print $temp_if['w']; ?>"<?php */?>/></a>
                        <?php } else if(file_exists(DIR_FS.$result['profilePicture']) && $check_img[0]=='imag') { 
						$temp_i=Aspect_Ration(SITE_URL.$result['profilePicture'],220);
						?>
                            <a href="javascript:void(0);"><img src="<?php echo SITE_URL.$result['profilePicture']; ?>" alt="Profile image" title="<?php echo $result['name'] ?>"  <?php /*?>height="<?php print $temp_i['h']; ?>" width="<?php print $temp_i['w']; ?>"<?php */?>  /></a>
                        <?php } else {	?>
                            <a href="javascript:void(0);"><img src="<?php echo NOIMG; ?>" title="No-image" alt="Profile image"  /></a>
                        <?php } 
                    } else { ?>
                            <a href="javascript:void(0);"><img src="<?php echo NOIMG; ?>" title="No-image" alt="Profile image"  /></a>
                  <?php } 
                } ?>
                <!--Edit Profile Button Set Here-->
        
         </div>
         
<!---Number Of Backed Proects and Stared Projects--->         
		 <?php
			if(!isset($_GET['user']) || ($_GET['user']=='')){
				$sel_backed_count=mysql_fetch_array($con->recordselect("SELECT count( DISTINCT `projectId` ) AS total FROM `projectbacking` WHERE `userId` ='".$_SESSION['userId']."'"));
				$sel_starred_count=mysql_fetch_assoc($con->recordselect("SELECT count(projectremindId) as starredcount FROM `projectremind` WHERE `userId` ='".$_SESSION['userId']."' AND status=1"));
			}else{
				$sel_backed_count=mysql_fetch_array($con->recordselect("SELECT count( DISTINCT `projectId` ) AS total FROM `projectbacking` WHERE `userId` ='".$_GET['user']."'"));
				$sel_starred_count=mysql_fetch_assoc($con->recordselect("SELECT count(projectremindId) as starredcount FROM `projectremind` WHERE `userId` ='".$_GET['user']."' AND status=1"));
			}
		?>
         <div class="head_content_right">
         	<h1>
				<?php echo ucfirst($result['name']); ?> 
                <span class="edit_link"><?php
            if(!isset($_GET['user']) && isset($_SESSION['userId']))
            { ?>
            	<a title="Edit" href="<?php echo SITE_URL; ?>profile/edit/" class="button-neutral1" >Edit </a>
            <?php } ?>
            </span>
            </h1>
           
            <h2>Backed <?php if($sel_backed_count['total']>0){ echo $sel_backed_count['total'];}else{ echo 0;} ?> projects </h2>
            
			<?php if(!empty($result['userLocation'])) { ?>
            	<h2>-</h2>
            	<h2><?php echo unsanitize_string(ucfirst($result['userLocation'])); ?></h2>
            <?php } ?>
            
            <?php if(!empty($result['name'])) { ?>
                <h2>-</h2>
                <h2><?php echo ucfirst($result['name']); ?> Joined <?php echo  ucfirst(date('F  Y', strtotime($result['created'])));  ?></h2>
            <?php } ?>
            
            <div class="clear"></div>
            <p>
            	<?php 
					$unsanaprotit2 = unsanitize_string(ucfirst($result['biography']));
					$protit_len=strlen($unsanaprotit2);
					if($protit_len>350){echo substr($unsanaprotit2,0, 350).'...'; }
					else { echo substr($unsanaprotit2, 0, 350); } 
				?>
            	<span><a title="See full bio & links" href="javascript:void(0)" class="modal_show">See full bio & links</a></span>
            </p>
           
         </div>
         <div class="clear"></div>
         </div>   
   </div>

    <div class="modal_dialog dark">
		<div class="modal_dialog_outer">
			<div class="modal_dialog_sizer">
				<div class="modal_dialog_inner">
					<div class="modal_dialog_content">
						<div class="modal_dialog_head">
							<a class="modal_dialog_close modal_show" href="#"><span class="ss-icon ss-delete"></span></a>
						</div>
                        <div class="modal_dialog_body">
                        <div id="profile-bio-full">
                            <h2>Biography</h2>
                            <p><?php if($result['biography']!="") {echo $result['biography'];} else { echo "No biography added yet."; } ?></p>
                            <ul>
                                <li>
									<?php if(mysql_num_rows($website_res)<=0 && !isset($_GET['user']) && isset($_SESSION['userId'])) {
                                        //echo "<a href='".SITE_URL."profile/edit/?website'>Add websites</a>";
                                    } else { ?>
                                        <h3>Websites</h3>
                                        <ul class="menu-submenu">
                                        <?php
                                        while ($website_res_field = mysql_fetch_assoc($website_res))
                                        {
											echo "<li><a target='_blank' href=".$website_res_field['siteUrl'].">".$website_res_field['siteUrl']."</a></li>";
                                        }?>
                                        </ul>                                       
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
   <?php 
		if(isset($_SESSION['userId']) && $_SESSION['userId']!='' && (!isset($_GET['user']) || $_GET['user']=='') || $_SESSION['userId']==$_GET['user']) {
			$sel_createdproject_count=mysql_fetch_array($con->recordselect("SELECT count(`projectId` ) AS num FROM projects WHERE `userId` ='".$_SESSION['userId']."'"));
		}else{
			$sel_createdproject_count=mysql_fetch_array($con->recordselect("SELECT count(`projectId` ) AS num FROM projects WHERE `userId` ='".$_GET['user']."' AND published=1 AND accepted=1"));
		}
		$totCreatePrj = $sel_createdproject_count['num'];
		$totBakedPrj = $sel_backed_count['total'];
		$totStarPrj = $sel_starred_count['starredcount'];
	?>
	<div class="tab">
   		<div class="wrapper" id="profile_tabs">
        <div id="tabs">
            <div class="tab_header">
                <div class="tab_header_left">
                    <ul>
                        <li id="aa" class="profile-tab" data-tab="a">Activity</li>
                        <li id="bb" class="profile-tab" data-tab="b">Created Projects (<?php echo $sel_createdproject_count['num']; ?>)</li>
                        <li id="cc" class="profile-tab" data-tab="c">Backed Projects(<?php echo $sel_backed_count['total']; ?>)</li>
                        <li id="dd" class="profile-tab" data-tab="d">Starred Projects (<?php echo $sel_starred_count['starredcount']; ?>)</li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div class="tab_content_bg">
                <div class="tab_content">

                    <div id="a" class="tab_left tab-content" >
                    	<div id="dv_content_a">
                    <?php
					if(empty($news_array))	
					{
						if(isset($_GET['user']) && ($_GET['user']!='') && ($_SESSION['userId']!=$_GET['user']))
						{ ?>
							<p class="no-content"><?php echo ucfirst($result['name']); ?> has not created any projects.</p>
					<?php } else { ?> 
							<p class="no-content">
							<strong>You haven't published, backed or commented on any projects.</strong> 
							Let's change that! <a href="<?php echo $base_url;?>staffpicks/">Discover projects</a></p>							
					<?php }	
					}		
					
					$tempNewsArray = array();
					$totalActivity123 = count($news_array) - 1;
					//$totalActivity123 = count($news_array);
					if (!empty($news_array)) {
						for($tempI = count($news_array); $tempI>0; $tempI--) {								
							$tempNewsArray[] = $news_array[$tempI-1];
						}
					}
					$news_array = $tempNewsArray;
					
					$val1	= ($perpage*1)-$perpage;
					$val2	= 1*$perpage;
					
					for ($i = $val1 ; $i <=$val2; $i++) 
					{
						if(isset($news_array[$i]['created_date']))
						{ 
							$sel_3_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
							WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.projectId='".$news_array[$i]['projectId']."' AND p3.accepted!='3'
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
									<span class="Launched_project">Reviewed On A Project</span>
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
											echo unsanitize_string($news_array[$i]['review']);
											/*$unsanaprotit2 = unsanitize_string($news_array[$i]['comment']);
											$protit_len = strlen($unsanaprotit2);
											if($protit_len>350){echo substr($unsanaprotit2,0, 350).'...'; }
											else { echo substr($unsanaprotit2, 0, 350); } */
										?>
										<?php //echo $news_array[$i]['comment']; ?>
                                    </blockquote>
                                    <div class="clear"></div>
                                </div>
                            	<div class="clear"></div>
                        	</div>
						<?php }//for review.. else if-$news_array[$i]['created_date'] Over
						else if(isset($news_array[$i]['backingTime'])) 
						{
							$sel_1_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb1, projects as p1, users as usr1, productimages as pi1, categories as cat1 
										WHERE pb1.projectId='".$news_array[$i]['projectId']."' AND p1.projectId='".$news_array[$i]['projectId']."' AND p1.accepted!='3'
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
										<?php echo ucfirst($sel_pro_creater['name']); ?></a></span>
                                    
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
											<?php if($sel_1_data['rewardedAmount']>=$sel_1_data['fundingGoal']) { ?>
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
										WHERE pb1.projectId='".$news_array[$i]['projectId']."' AND p1.projectId='".$news_array[$i]['projectId']."' AND p1.accepted!='3'
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
                                        	<?php if($sel_5_data['isActive'] == 1) { ?>
                                                <a title="<?php echo unsanitize_string(ucfirst($sel_5_data['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_5_data['categoryId'].'/'.Slug($sel_5_data['categoryName']).'/';?>">
                                                    <?php echo unsanitize_string(ucfirst($sel_5_data['categoryName'])); ?>
                                                </a>
                                            <?php }else {?>
                                                <a title="<?php echo unsanitize_string(ucfirst($sel_5_data['categoryName'])); ?>" href="javascript:void(0);">
                                                    <?php echo unsanitize_string(ucfirst($sel_5_data['categoryName'])); ?>
                                                </a>
                                            <?php }?>
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
											<?php if($sel_5_data['rewardedAmount']>=$sel_5_data['fundingGoal']){ ?>                                        
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
						/* $sel_3_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
                                                            WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.projectId='".$news_array[$i]['projectId']."'
                                                            AND usr3.userId=p3.userId AND cat3.categoryId=pb3.projectCategory"));*/
								/*$sel_3_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
										WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.projectId='".$news_array[$i]['projectId']."'
										AND usr3.userId='".$news_array[$i]['userId']."' AND cat3.categoryId=pb3.projectCategory"));*/
										$sel_3_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
										WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.projectId='".$news_array[$i]['projectId']."' AND p3.accepted!='3'
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
											echo unsanitize_string($news_array[$i]['comment']);
											/*$unsanaprotit2 = unsanitize_string($news_array[$i]['comment']);
											$protit_len = strlen($unsanaprotit2);
											if($protit_len>350){echo substr($unsanaprotit2,0, 350).'...'; }
											else { echo substr($unsanaprotit2, 0, 350); } */
										?>
										<?php //echo $news_array[$i]['comment']; ?>
                                    </blockquote>
                                    <div class="clear"></div>
                                </div>
                            	<div class="clear"></div>
                        	</div>
						<?php }//for comment.. else if-$news_array[$i]['commentTime'] Over 
						
						else if(isset($news_array[$i]['updateTime']))
                        { 
                                $sel_2_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb2, projects as p2, users as usr2, categories as cat2 
                                         WHERE pb2.projectId='".$news_array[$i]['projectId']."' AND p2.projectId='".$news_array[$i]['projectId']."' AND p2.accepted!='3'
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
                                    	<a href="<?php echo SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_2_data['projectTitle']).'/update='.$news_array[$i]['updatenumber'].'/#b'; ?>">
											<?php echo unsanitize_string(ucfirst($news_array[$i]['updateTitle'])); ?>
                                        </a>
										<?php 
											echo unsanitize_string($news_array[$i]['updateDescription']);
											/*$unsanaprotit2 = unsanitize_string($news_array[$i]['updateDescription']);
											$protit_len = strlen($unsanaprotit2);
											if($protit_len>350){echo substr($unsanaprotit2,0, 350).'...'; }
											else { echo substr($unsanaprotit2, 0, 350); } */
										?>
                                    </blockquote>
                                    <div class="clear"></div>
                                </div>
                            	<div class="clear"></div>
                        	</div>
						<?php }//else if-$news_array[$i]['updateTime'] Over 
                        else if(isset($news_array[$i]['updateCommentTime']))
                        {  
                                 /*$sel_4_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb4, projects as p4, users as usr4, categories as cat4 
                                                              WHERE pb4.projectId='".$news_array[$i]['projectId']."' AND p4.projectId='".$news_array[$i]['projectId']."'
                                                              AND usr4.userId=p4.userId AND cat4.categoryId=pb4.projectCategory"));*/
								
								/*$sel_4_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb4, projects as p4, users as usr4, categories as cat4 
                                          WHERE pb4.projectId='".$news_array[$i]['projectId']."' AND p4.projectId='".$news_array[$i]['projectId']."'
                                          AND usr4.userId='".$news_array[$i]['userId']."' AND cat4.categoryId=pb4.projectCategory"));*/
										  $sel_4_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb4, projects as p4, users as usr4, categories as cat4 
                                          WHERE pb4.projectId='".$news_array[$i]['projectId']."' AND p4.projectId='".$news_array[$i]['projectId']."' AND p4.accepted!='3'
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
											echo unsanitize_string($news_array[$i]['updateComment']);
											/*$unsanaprotit2 = unsanitize_string($news_array[$i]['updateComment']);
											$protit_len = strlen($unsanaprotit2);
											if($protit_len>350){echo substr($unsanaprotit2,0, 350).'...'; }
											else { echo substr($unsanaprotit2, 0, 350); } */
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
                    </div>
                        <div id="dv_a" class="margin10">
	                        <div class="loadmorebtn">
                                <center>
                                    <input type="hidden" id="hidden_val_a" value="<?php echo $perpage; ?>">
                                    <input type="hidden" id="hidden_curr_page_a" value="1">
                                    <input type="hidden" id="total_a" value="<?php echo $totalActivity123; ?>">
                                    <?php if($totalActivity123 > 5) { ?>
                                        <a href="javascript:;" class="hover-effect load_activity loadmorebtncenter" data-for="a">Load More...
                                        <span id="wait_1" style="display: none;">
                                            <img alt="Please Wait" src="<?php echo SITE_IMG; ?>ajax-loader1.gif">
                                        </span>
                                        </a>
                                    <?php } ?>
                                </center>
                            </div>
                        </div>
                    </div>

                    <div id="b" class="tab_left tab-content">
                    	<div id="dv_content_b">
                    <?php 							
						//$noCreatedPrj = mysql_num_rows($sel_created);
						if(mysql_num_rows($sel_created)>0)
						{
							while($sel_createdprojects=mysql_fetch_assoc($sel_created))
							{
								$sel_createproject=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId='".$sel_createdprojects['projectId']."'"));
								$sel_cr_projectuser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projects` WHERE projectId='".$sel_createdprojects['projectId']."'"));
								$sel_createprojectuser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_cr_projectuser['userId']."'"));
								$sel_createproject_image=mysql_fetch_assoc($con->recordselect("SELECT * FROM `productimages` WHERE projectId='".$sel_createdprojects['projectId']."'"));
								$sel_createproject_cat=mysql_fetch_assoc($con->recordselect("SELECT * FROM `categories` WHERE categoryId='".$sel_createproject['projectCategory']."'"));
								$sel_cr_backers=mysql_fetch_assoc($con->recordselect("SELECT  count( distinct( `userId` )) AS backers FROM `projectbacking` WHERE `projectId` ='".$sel_createdprojects['projectId']."'"));
					?>
                        	<div class="tab_content_left">
                                <a href="<?php if($sel_createdprojects['published']==1 && $sel_createdprojects['accepted']==1)
									{
										echo $base_url.'browseproject/'.$sel_createdprojects['projectId'].'/'.Slug($sel_createproject['projectTitle']).'/'; 
									}else{
										echo $base_url.'createproject/'.$sel_createdprojects['projectId']; 
									} ?>" >
										<img src="<?php if($sel_createproject_image['image223by169']!='' && file_exists(DIR_FS.$sel_createproject_image['image223by169'])) 
											{ echo SITE_URL.$sel_createproject_image['image223by169']; } else { echo NOIMG; } ?>" 
											title="<?php if($sel_createproject['projectTitle']!='') { echo unsanitize_string($sel_createproject['projectTitle']); } else { echo "Untitled"; } ?>" 
											alt="<?php if($sel_createproject['projectTitle']!='') { echo $sel_createproject['projectTitle']; } else { echo "Untitled"; } ?>" />
								</a>
                                                                
                                <div class="right_comment">
                                    <a title="<?php if($sel_createproject['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_createproject['projectTitle'])); } else { echo "Untitled"; } ?>" href="<?php if($sel_createdprojects['published']==1 && $sel_createdprojects['accepted']==1)
										{
											echo $base_url.'browseproject/'.$sel_createdprojects['projectId'].'/'.Slug($sel_createproject['projectTitle']).'/'; 
										} else {
											echo $base_url.'createproject/'.$sel_createdprojects['projectId']; 
										} ?>" >
                                        <?php if($sel_createproject['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_createproject['projectTitle'])); } else { echo "Untitled"; } ?>
									</a>
                                    <span >By 
                                    	<a title="<?php echo ucfirst($sel_createprojectuser['name']); ?>" class="linkblue" href="<?php echo SITE_URL; ?>profile/<?php echo $sel_createprojectuser['userId'].'/'.Slug($sel_createprojectuser['name']).'/'; ?>">
											<?php echo ucfirst($sel_createprojectuser['name']); ?>
                                        </a>
                                    </span>
                                    
									<?php 
                                    $cur_time2=time();
                                    if($sel_createdprojects['published']==1 && $sel_createdprojects['accepted']==1 && $sel_createdprojects['userId']==$_SESSION['userId'] && $sel_createproject['projectEnd']>$cur_time2) { ?>
                                        <span class="Launched_project">
                                        <a href="<?php echo SITE_URL ;?>projectupdate/<?php echo $sel_createdprojects['projectId'].'/'.Slug($sel_createproject['projectTitle']).'/'; ?>">
                                            Make update
                                        </a>
                                        </span>
                                    <? } ?>
                                    
                                    <ul>
                                    	<?php if($sel_createproject_cat['categoryName']!='') { ?>
                                            <img src="<?php echo SITE_IMG; ?>category.png" />
                                            <li>
                                            	<?php if($sel_createproject_cat['isActive'] == 1) { ?>
                                                    <a title="<?php echo unsanitize_string(ucfirst($sel_createproject_cat['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_createproject_cat['categoryId'].'/'.Slug($sel_createproject_cat['categoryName']).'/';?>">
                                                        <?php echo unsanitize_string(ucfirst($sel_createproject_cat['categoryName'])); ?>
                                                    </a>
                                                <?php }else {?>
                                                    <a title="<?php echo unsanitize_string(ucfirst($sel_createproject_cat['categoryName'])); ?>" href="javascript:void(0);">
                                                        <?php echo unsanitize_string(ucfirst($sel_createproject_cat['categoryName'])); ?>
                                                    </a>
                                                <?php }?>
                                            </li>
                                            <img src="<?php echo SITE_IMG; ?>location.png" />
                                            <li>
                                            	<a title="<?php echo ucfirst($sel_createproject['projectLocation']); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_createdprojects['projectId'].'/'.Slug($sel_createproject['projectLocation']).'/';?>">
													<?php echo ucfirst($sel_createproject['projectLocation']); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <div class="clear"></div>
                                    </ul>
                                    <p><?php echo unsanitize_string(ucfirst($sel_createproject['shortBlurb'])); ?></p>
                                    
									<?php $chktime_cur=time(); 
									if($sel_createproject['projectEnd']<=$chktime_cur && $sel_createdprojects['published']==1 && $sel_createdprojects['accepted']==1) { ?>
                                        <h4 class="sticker">
											<?php if($sel_createproject['rewardedAmount']>=$sel_createproject['fundingGoal']) { ?>                                    	
                                                SUCCESSFUL!
                                            <?php } else { ?>
                                                FUNDING UNSUCCESSFUL                                    	
	                                        <?php } ?>
                                        </h4>
                                    <?php } ?>	
                                    
                                    <div class="clear"></div>
                                    <?php if($sel_createdprojects['published']==1 && $sel_createdprojects['accepted']==1) { ?>
                                    
                                        <?php
											$fundingAmount = (isset($sel_createproject['fundingGoal']) OR !empty($sel_createproject['fundingGoal'])) ? $sel_createproject['fundingGoal'] : 0;
											if($fundingAmount != NULL && $fundingAmount > 0){
												$value = $sel_createproject['rewardedAmount'];
												$max = $sel_createproject['fundingGoal'];
											}
											$scale = 1.0;
											if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
											else { $percent = 0; }
											if ( $percent > 100 ) { $percent = 100; }
										?>
										
                                        <div class="progress_bar">
                                            <div style="width:<?php echo round($percent * $scale); ?>%" class="progres"></div>
                                        </div>
                                        <div class="bottom">
                                        	
                                            <ul>
                                            	<?php
													if($fundingAmount != NULL && $fundingAmount > 0){
														$value1 = $sel_createproject['rewardedAmount'];
														$max1 = $sel_createproject['fundingGoal'];
													}
													$scale = 1.0;
													if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
													else { $percent1 = 0; }
												?>
                                                <li><?php echo (int) $percent1."%"; ?> Funded </li>
                                                <li>|</li>
                                                <li> $<?php echo number_format($sel_createproject['rewardedAmount']); ?> Pledged</li>
                                                <li>|</li>
                                                <?php
													if($sel_createproject['projectEnd']>time() && $sel_createproject['fundingStatus']!='n'){
														$end_date=(int) $sel_createproject['projectEnd'];
														$cur_time=time();
														$total = $end_date - $cur_time;
														$left_days=$total/(24 * 60 * 60);
													}else{
														$left_days=0;
													}
												?>
                                                <li><?php echo roundDays($left_days);?> days left</li>
                                                <div class="clear"></div>
                                            </ul>
                                        </div>
                                        
                                    <?php } else { ?>
                                    	<h4 class="sticker">Project Not Launched</h4>
                                        <strong>(only you can see this)</strong>
                                    <?php } ?>
                                    
                                </div>
                                <div class="clear"></div>
                        	</div>
                        	 
                    <?php }?>
                        
                   <?php } else { ?>
                            <p class="no-content">
                                <strong>You haven't published any projects.</strong> Let's change that! <a href="<?php echo $base_url;?>createproject/">Create projects</a>
                            </p>
					<?php } ?>
                    	</div>
                        <div id="dv_b" class="margin10">
	                        <div class="loadmorebtn">
                                <center>
                                	<input type="hidden" id="hidden_val_b" value="<?php echo $perpage; ?>">
                                    <input type="hidden" id="hidden_curr_page_b" value="0">
                                    <input type="hidden" id="total_b" value="<?php echo $totCreatePrj; ?>">
                                    <?php if($totCreatePrj > 5) { ?>
                                        <a href="javascript:;" class="hover-effect load_activity loadmorebtncenter" data-for="b">Load More...
                                        <span id="wait_1" style="display: none;">
                                            <img alt="Please Wait" src="<?php echo SITE_IMG; ?>ajax-loader1.gif">
                                        </span>
                                        </a>
                                    <?php } ?>
                                </center>
                            </div>
                        </div>
                        
                    </div>


                    <div id="c" class="tab_left tab-content">
                    	<div id="dv_content_c">
                    	<?php
							if(!isset($_GET['user']) || ($_GET['user']==''))
							{
								$sel_backedproject=$con->recordselect("SELECT DISTINCT `projectId` FROM `projectbacking` WHERE `userId` ='".$_SESSION['userId']."'".$rec_limit);													
							}else{
								$sel_backedproject=$con->recordselect("SELECT DISTINCT `projectId` FROM `projectbacking` WHERE `userId` ='".$_GET['user']."'".$rec_limit);	
							}
							//$noBackedPrj = mysql_num_rows($sel_backedproject);
							if(mysql_num_rows($sel_backedproject)>0)
							{
								while($sel_backedproject1=mysql_fetch_assoc($sel_backedproject))
								{
								$sel_backproject=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId='".$sel_backedproject1['projectId']."'"));
								$sel_projectuser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projects` WHERE projectId='".$sel_backedproject1['projectId']."'"));
								$sel_backprojectuser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_projectuser['userId']."'"));
								$sel_backproject_image=mysql_fetch_assoc($con->recordselect("SELECT * FROM `productimages` WHERE projectId='".$sel_backedproject1['projectId']."'"));
								$sel_backproject_cat=mysql_fetch_assoc($con->recordselect("SELECT * FROM `categories` WHERE categoryId='".$sel_backproject['projectCategory']."'"));
								$sel_backers=mysql_fetch_assoc($con->recordselect("SELECT  count( distinct( `userId` )) AS backers FROM `projectbacking` WHERE `projectId` ='".$sel_backedproject1['projectId']."'"));
						 ?>
                                <div class="tab_content_left">
                                    <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_backedproject1['projectId'].'/'.Slug($sel_backproject['projectTitle']).'/'; ?>">
										<?php if($sel_backproject_image['image223by169']!='' && file_exists(DIR_FS.$sel_backproject_image['image223by169'])) { ?>
                                            <img src="<?php echo SITE_URL.$sel_backproject_image['image223by169']; ?>" title="<?php echo unsanitize_string($sel_backproject['projectTitle']); ?>" alt="<?php echo $sel_backproject['projectTitle']; ?>" />
                                        <?php } else { ?>
                                            <img src="<?php echo NOIMG; ?>" title="<?php echo unsanitize_string($sel_backproject['projectTitle']); ?>" alt="<?php echo $sel_backproject['projectTitle']; ?>"  />                                                
                                        <?php } ?>
                                    </a>
                                    <div class="right_comment">
                                        <a title="<?php echo unsanitize_string(ucfirst($sel_backproject['projectTitle'])); ?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_backedproject1['projectId'].'/'.Slug($sel_backproject['projectTitle']).'/'; ?>">
											<?php if($sel_backproject['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_backproject['projectTitle'])); } else { echo "Untitled"; } ?>
                                        </a>
                                        <span >By <a title="<?php echo ucfirst($sel_backprojectuser['name']); ?>" class="linkblue" href="<?php echo SITE_URL; ?>profile/<?php echo $sel_backprojectuser['userId'].'/'.Slug($sel_backprojectuser['name']).'/'; ?>">
											<?php echo ucfirst($sel_backprojectuser['name']); ?></a></span>
                                        <ul>
                                            <img src="<?php echo SITE_IMG; ?>category.png" />
                                            <li>
                                            	<?php if($sel_backproject_cat['isActive'] == 1) { ?>
                                                    <a title="<?php echo unsanitize_string(ucfirst($sel_backproject_cat['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_backproject_cat['categoryId'].'/'.Slug($sel_backproject_cat['categoryName']).'/';?>">
                                                        <?php echo unsanitize_string(ucfirst($sel_backproject_cat['categoryName'])); ?>
                                                    </a>
                                                <?php }else {?>
                                                    <a title="<?php echo unsanitize_string(ucfirst($sel_backproject_cat['categoryName'])); ?>" href="javascript:void(0);">
                                                        <?php echo unsanitize_string(ucfirst($sel_backproject_cat['categoryName'])); ?>
                                                    </a>
                                                <?php }?>
                                            </li>
                                            <img src="<?php echo SITE_IMG; ?>location.png" />
                                            <li>
                                            	<a title="<?php echo unsanitize_string(ucfirst($sel_backproject['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_backedproject1['projectId'].'/'.Slug($sel_backproject['projectLocation']).'/';?>">
													<?php echo unsanitize_string(ucfirst($sel_backproject['projectLocation'])); ?>
                                                </a>
                                            </li>
                                            <div class="clear"></div>
                                        </ul>
                                        <p><?php echo unsanitize_string(ucfirst($sel_backproject['shortBlurb'])); ?></p>
                                        <?php $chktime_cur=time(); if($sel_backproject['projectEnd']<=$chktime_cur) { ?>
                                            <h4 class="sticker">
												<?php if($sel_backproject['rewardedAmount']>=$sel_backproject['fundingGoal']){ ?>                                            
                                                    SUCCESSFUL!
                                                <?php } else { ?>
                                                    FUNDING UNSUCCESSFUL                                            
	                                         	<?php }  ?>   
                                            </h4>
                                         <?php } ?>
                                        <div class="clear"></div>
                                        <?php
											$fundingAmount = (isset($sel_backproject['fundingGoal']) OR !empty($sel_backproject['fundingGoal'])) ? $sel_backproject['fundingGoal'] : 0;
											if($fundingAmount != NULL && $fundingAmount > 0){
												$value = $sel_backproject['rewardedAmount'];
												$max = $sel_backproject['fundingGoal'];
											}
											$scale = 1.0;
											if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
											else { $percent = 0; }
											if ( $percent > 100 ) { $percent = 100; }
										?>
										
                                        <div class="progress_bar">
                                            <div style="width:<?php echo round($percent * $scale); ?>%" class="progres">
                                            </div>
                                        </div>
                                        <div class="bottom">
                                        	
                                            <ul>
                                            	<?php
													if($fundingAmount != NULL && $fundingAmount > 0){
														$value1 = $sel_backproject['rewardedAmount'];
														$max1 = $sel_backproject['fundingGoal'];
													}
													$scale = 1.0;
													if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
													else { $percent1 = 0; }
												?>
                                                <li><?php echo (int) $percent1."%"; ?> Funded </li>
                                                <li>|</li>
                                                <li> $<?php echo number_format($sel_backproject['rewardedAmount']); ?> Pledged</li>
                                                <li>|</li>
                                                <?php
													if($sel_backproject['projectEnd']>time() && $sel_backproject['fundingStatus']!='n'){
														$end_date=(int) $sel_backproject['projectEnd'];
														$cur_time=time();
														$total = $end_date - $cur_time;
														$left_days=$total/(24 * 60 * 60);
													}else{
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
                        	<?php } //While Over ?>
                        <?php } else {
								if(isset($_GET['user']) && ($_SESSION['userId']!=$_GET['user']) && ($_GET['user']!='')) { ?>
									<p><?php echo $result['name']; ?> is not backing any projects.</p>
							<?php } else { ?>
                            		<p><strong>You haven't backed any projects.</strong> Let's change that! <a href="<?php echo $base_url;?>staffpicks/">Discover projects</a></p>
							<?php }
							} ?> 
                        </div>
                        <div id="dv_c" class="margin10">
	                        <div class="loadmorebtn">
                                <center>
                                    <input type="hidden" id="hidden_val_c" value="<?php echo $perpage; ?>">
                                    <input type="hidden" id="hidden_curr_page_c" value="0">
                                    <input type="hidden" id="total_c" value="<?php echo $totBakedPrj; ?>">
                                    <?php if($totBakedPrj > 5) { ?>
                                        <a href="javascript:;" class="hover-effect load_activity loadmorebtncenter" data-for="c">Load More...
                                        <span id="wait_1" style="display: none;">
                                            <img alt="Please Wait" src="<?php echo SITE_IMG; ?>ajax-loader1.gif">
                                        </span>
                                        </a>
                                    <?php } ?>
                                </center>
                            </div>
                        </div>                        
                    </div>

                    <div id="d" class="tab_left tab-content">
                    	<div id="dv_content_d">
                    <?php
						if(!isset($_GET['user']) || ($_GET['user']=='')) {
							$sel_starredproject=$con->recordselect("SELECT * FROM `projectremind` WHERE `userId` ='".$_SESSION['userId']."' AND status=1 ORDER BY remindTime DESC".$rec_limit);													
						} else {
							$sel_starredproject=$con->recordselect("SELECT * FROM `projectremind` WHERE `userId` ='".$_GET['user']."' AND status=1 ORDER BY remindTime DESC".$rec_limit);	
						}
						//$noStartredPrj = mysql_num_rows($sel_starredproject);
						if(mysql_num_rows($sel_starredproject)>0) {
							while($sel_starredproject1=mysql_fetch_assoc($sel_starredproject)) {
								$sel_starproject=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId='".$sel_starredproject1['projectId']."'"));
								$sel_staruser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projects` WHERE projectId='".$sel_starredproject1['projectId']."'"));
								$sel_starprojectusername=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_staruser['userId']."'"));
								$sel_starprojectuser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_starredproject1['userId']."'"));
								$sel_starproject_image1=$con->recordselect("SELECT * FROM `productimages` WHERE projectId='".$sel_starredproject1['projectId']."'");
								$sel_starproject_image=mysql_fetch_assoc($sel_starproject_image1);
								$sel_starproject_cat=mysql_fetch_assoc($con->recordselect("SELECT * FROM `categories` WHERE categoryId='".$sel_starproject['projectCategory']."'"));
								$sel_starbackers=mysql_fetch_assoc($con->recordselect("SELECT  count( distinct( `userId` )) AS backers FROM `projectbacking` WHERE `projectId` ='".$sel_starredproject1['projectId']."'"));
					 ?>
                        		<div class="tab_content_left">
                                    <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_starredproject1['projectId'].'/'.Slug($sel_starproject['projectTitle']).'/'; ?>">
										<?php if($sel_starproject_image['image223by169']!='' && file_exists(DIR_FS.$sel_starproject_image['image223by169']) && mysql_num_rows($sel_starproject_image1)>0) { ?>
                                            <img src="<?php echo SITE_URL.$sel_starproject_image['image223by169']; ?>"  alt="<?php echo $sel_starproject['projectTitle']; ?>" title="<?php echo $sel_starproject['projectTitle']; ?>" />
                                        <?php } else { ?>
                                            <img src="<?php echo NOIMG; ?>"  alt="<?php echo $sel_starproject['projectTitle']; ?>" title="<?php echo $sel_starproject['projectTitle']; ?>" />
                                        <?php } ?>
                                    </a>
                                    <div class="right_comment">
                                        <a title="<?php echo unsanitize_string(ucfirst($sel_starproject['projectTitle'])); ?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_starredproject1['projectId'].'/'.Slug($sel_starproject['projectTitle']).'/'; ?>">
											<?php if($sel_starproject['projectTitle']!='') { echo unsanitize_string(ucfirst($sel_starproject['projectTitle'])); } else { echo "Untitled"; } ?>
                                        </a>
                                        <span >By <a title="<?php echo ucfirst($sel_starprojectusername['name']); ?>" class="linkblue" href="<?php echo SITE_URL; ?>profile/<?php echo $sel_starprojectusername['userId'].'/'.Slug($sel_starprojectusername['name']).'/'; ?>">
											<?php echo ucfirst($sel_starprojectusername['name']); ?></a></span>
                                        <ul>
                                            <img src="<?php echo SITE_IMG; ?>category.png" />
                                            <li>
                                            	<?php if($sel_starproject_cat['isActive'] == 1) { ?>
                                            	<a title="<?php echo unsanitize_string(ucfirst($sel_starproject_cat['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_starproject_cat['categoryId'].'/'.Slug($sel_starproject_cat['categoryName']).'/';?>">
													<?php echo unsanitize_string(ucfirst($sel_starproject_cat['categoryName'])); ?>
                                                </a>
                                                <?php }else {?>
                                                    <a title="<?php echo unsanitize_string(ucfirst($sel_starproject_cat['categoryName'])); ?>" href="javascript:void(0);">
                                                        <?php echo unsanitize_string(ucfirst($sel_starproject_cat['categoryName'])); ?>
                                                    </a>
                                                <?php }?>
                                            </li>
                                            <img src="<?php echo SITE_IMG; ?>location.png" />
                                            <li>
                                            	<a title="<?php echo unsanitize_string(ucfirst($sel_starproject['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_starredproject1['projectId'].'/'.Slug($sel_starproject['projectLocation']).'/';?>">
													<?php echo unsanitize_string(ucfirst($sel_starproject['projectLocation'])); ?>
                                                </a>
                                            </li>
                                            <div class="clear"></div>
                                        </ul>
                                        <p><?php echo unsanitize_string(ucfirst($sel_starproject['shortBlurb'])); ?></p>
                                        <?php $chktime_cur=time(); if($sel_starproject['projectEnd']<=$chktime_cur) { ?>
                                            <h4 class="sticker">
												<?php if($sel_starproject['rewardedAmount']>=$sel_starproject['fundingGoal']){ ?>                                        	
                                                    SUCCESSFUL!
                                                <?php } else { ?>
                                                    FUNDING UNSUCCESSFUL
                                            	<?php } ?>
                                            </h4>
                                         <?php  } ?>   
                                        <div class="clear"></div>
                                        <?php
											$fundingAmount = (isset($sel_starproject['fundingGoal']) OR !empty($sel_starproject['fundingGoal'])) ? $sel_starproject['fundingGoal'] : 0;
											if($fundingAmount != NULL && $fundingAmount > 0){
												$value = $sel_starproject['rewardedAmount'];
												$max = $sel_starproject['fundingGoal'];
											}
											$scale = 1.0;
											if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
											else { $percent = 0; }
											if ( $percent > 100 ) { $percent = 100; }
										?>
										
                                        <div class="progress_bar">
                                            <div style="width:<?php echo round($percent * $scale); ?>%" class="progres">
                                            </div>
                                        </div>
                                        <div class="bottom">
                                        	
                                            <ul>
                                            	<?php
													if($fundingAmount != NULL && $fundingAmount > 0){
														$value1 = $sel_starproject['rewardedAmount'];
														$max1 = $sel_starproject['fundingGoal'];
													}
													$scale = 1.0;
													if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
													else { $percent1 = 0; }
												?>
                                                <li><?php echo (int) $percent1."%"; ?> Funded </li>
                                                <li>|</li>
                                                <li> $<?php echo number_format($sel_starproject['rewardedAmount']); ?> Pledged</li>
                                                <li>|</li>
                                                <?php
													if($sel_starproject['projectEnd']>time() && $sel_starproject['fundingStatus']!='n'){
														$end_date=(int) $sel_starproject['projectEnd'];
														$cur_time=time();
														$total = $end_date - $cur_time;
														$left_days=$total/(24 * 60 * 60);
													}else{
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
                     	<?php } ?>
                        	</div>
						<?php } else {
								if(isset($_GET['user']) && ($_SESSION['userId']!=$_GET['user']) && ($_GET['user']!='')) { ?>
									<p><?php echo $result['name']; ?> is not following any projects.</p>
							<?php } else { ?>
									<p><strong>You aren't following any projects.</strong> Let's change that! Follow a project by clicking the remind me button on a project page. <a href="<?php echo $base_url;?>staffpicks/">Discover projects</a></p>
							<?php }
						} ?>
                    	
						<div id="dv_d" class="margin10">
                            <div class="loadmorebtn">
                                <center>
                                    <input type="hidden" id="hidden_val_d" value="<?php echo $perpage; ?>">
                                    <input type="hidden" id="hidden_curr_page_d" value="0">
                                    <input type="hidden" id="total_d" value="<?php echo $totStarPrj; ?>">
                                    <?php if($totStarPrj > 5){ ?>
                                        <a href="javascript:;" class="hover-effect load_activity loadmorebtncenter" data-for="d">Load More...
                                        <span id="wait_1" style="display: none;">
                                            <img alt="Please Wait" src="<?php echo SITE_IMG; ?>ajax-loader1.gif">
                                        </span>
                                        </a>
                                    <?php } ?>
                                </center>
                            </div>
                        </div>
                    </div>
                <div class="clear"></div>
                </div>
            </div>  
        </div>
   		</div>
	</div>
</section>

<script type="text/javascript">
$(document).ready(function () {
	
	$(".load_activity").click(function() {	
		var $load_activity = $(this);
		var load_for = $load_activity.attr("data-for");
		var load_rec = parseInt($("#hidden_val_"+load_for).val());
		var curr_page = parseInt($("#hidden_curr_page_"+load_for).val());
		var total_rec = parseInt($("#total_"+load_for).val());
		//alert(<?php echo $perpage; ?>);				
		try {
			$("#wait_1").show();
			$.ajax({
				type		:	"POST",
				dataType	:	"json",
				url			:	"<?php echo SITE_URL; ?>ajax.profile.php",
				data		:	{
									get_user	:	'<?php echo $get_user; ?>',
									ses_user	:	'<?php echo $ses_user; ?>',
									active_tab	:	load_for,
									per_page	:	'<?php echo $perpage; ?>',
									load_rec	:	load_rec,
									curr_page	:	curr_page
								},
				success		:	function(data) {
									if(data["status"] == 200) {
										if(parseInt(data["total_rec"]) > 0) {										
											$("#dv_content_"+load_for).append(data["html_content"]);
											load_rec += parseInt(data["total_rec"]);
											$("#hidden_val_"+load_for).val(load_rec);
											$("#hidden_curr_page_"+load_for).val(data["curr_page"]);
											$("#wait_1").hide();
											if((data["html_content"] == null) || ($("#hidden_val_"+load_for).val() >= total_rec)){
												$load_activity.hide();
											}
										}
										else {
											$load_activity.hide();
											$("#wait_1").hide();
										}
									} else {
										$("#wait_1").hide();
										console.log("Error in .load_activity ajax response - " + data["msg"]);
									}
								}
			});
		} catch(e) {
			$("#wait_1").hide();
			console.log("Error in .load_activity - " + e);
		}
		
	});
});
</script>