<?php
	require "../../includes/config.php";
	/*echo $_POST['term'];
	echo "----";
	echo $_GET['term'];*/
	//exit;
	$searchTerm = (isset($_POST) && isset($_POST['term'])) ? sanitize_string(trim($_POST['term'])) : '';
	//echo ''.$searchTerm;
	$title = "Discover Projects";
	$meta = array("description"=>"Discover Projects","keywords"=>"Discover Projects");
	$module="search";
	$page = "index";
	
	//$searchTerm = str_replace("/","",sanitize_string($searchTerm));
	//$searchTerm = mysql_real_escape_string(str_replace(array('_', '%'), array('\_', '\%'),$searchTerm ));
	$searchTerm=escapeSearchString($searchTerm);
	//$searchTerm = Slug($searchTerm);
	//echo $searchTerm;
		
	if(isset($searchTerm) && $searchTerm!='' && (!isset($_GET) || (isset($_GET['term']) && ($_GET['term']==''))))
	{
		//echo 'if';print_r($_POST);
		$all_categories=$con->recordselect("SELECT * FROM categories WHERE isActive = 1");
		if(mysql_num_rows($all_categories)>0)
		{
			$projCnt=0;
			$i=0;
			while($category_detail = mysql_fetch_assoc($all_categories))
			{
				$i++;
				$sel_staff2=$con->recordselect("SELECT * FROM projectbasics as pb, projects as p WHERE (pb.projectTitle LIKE '%".$searchTerm."%' OR pb.shortBlurb LIKe '%".$searchTerm."%' ) 
					AND p.accepted=1 AND p.projectId= pb.projectId  AND pb.projectCategory = '".$category_detail["categoryId"]."' ORDER BY pb.projectId DESC LIMIT 3");
				
				if(mysql_num_rows($sel_staff2)>0)
				{
				while($sel_project2 = mysql_fetch_assoc($sel_staff2))
				{
					$chktime_cur=time();  
					if($sel_project2['fundingStatus']=='n' || ($sel_project2['projectEnd']<$chktime_cur && $sel_project2['fundingStatus']=='r'))
					{
						continue;
					}
					$projCnt++;
					$sel_image2=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$sel_project2['projectId']."'"));
					
					$sel_categories2 = mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_project2['projectCategory']."'"));
					$sel_peoject_uid2=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects WHERE projectId='".$sel_project2['projectId']."'"));
					$sel_user2=mysql_fetch_assoc($con->recordselect("SELECT * FROM users WHERE userId='".$sel_peoject_uid2['userId']."'"));
			?>
				<li>
                    <div class="float-left" style="width:223px; height:340px; padding:10px 0 0 8px; ">
                        <div class="innerbox">
							<div class="img_thumb">
                                <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_project2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'; ?>">
									<?php if(($sel_image2['image223by169']!= NULL || $sel_image2['image223by169']!='')) { 
                                        if(file_exists(DIR_FS.$sel_image2['image223by169'])) { ?>
                                            <img src="<?php echo SITE_URL.$sel_image2['image223by169']; ?>" title="<?php echo $sel_project2['projectTitle']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>" />
                                        <?php } else{ ?>
                                            <img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project2['projectTitle']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>" />
                                        <?php	}
                                    } else { ?>
                                        <img src="<?php echo NOIMG; ?>" title="<?php echo $sel_project2['projectTitle']; ?>" alt="<?php echo $sel_project2['projectTitle']; ?>" />
                                    <?php } ?>
                                </a>
							</div>
						<div class="poductname">
							<?php if($sel_categories2['isActive'] == 1) { ?>
                                <a title="<?php echo $sel_categories2['categoryName']; ?>" href="<?php echo $base_url;?>category/<?php echo $sel_categories2['categoryId'].'/'.Slug($sel_categories2['categoryName']).'/'.'/'; ?>">
                                    <?php echo $sel_categories2['categoryName']; ?>
                                </a>
                            <?php }else{ ?>
                            	<a title="<?php if(isset($sel_categories2['categoryName'])) { echo $sel_categories2['categoryName']; } else { echo 'Unknown'; }?>" href="javascript:void(0);">
                                    <?php if(isset($sel_categories2['categoryName'])) {  echo $sel_categories2['categoryName'];  } else { echo 'Unknown'; }?>
                                </a>
                            <?php } ?>
						</div>
						<div class="whitebox">
						  <div class="textnormal-b">
                          	<strong>
							<a title="<?php echo unsanitize_string(ucfirst($sel_project2['projectTitle'])); ?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_project2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'; ?>">
                                <b><?php $unsanaprotit = unsanitize_string(ucfirst($sel_project2['projectTitle']));  $protit_len=strlen($unsanaprotit);  if($protit_len>47) {echo substr($unsanaprotit, 0, 47).'...'; } else { echo substr($unsanaprotit, 0, 47); } ?></b>
                            </a>
                            </strong>
                          </div>
						  <div class="spaser-small"></div>
						  <div>
                          by <a title="<?php echo unsanitize_string(ucfirst($sel_user2['name'])); ?>" class="linkblue"  href="<?php echo SITE_URL.'profile/'.$sel_user2['userId'].'/'.Slug($sel_user2['name']).'/'; ?>">
							<?php echo $unsanaprotit1=unsanitize_string(ucfirst($sel_user2['name']));  $protit_len1=strlen($unsanaprotit1);  if($protit_len1>18) {echo substr($unsanaprotit1, 0, 18).'...'; } else { echo substr($unsanaprotit1, 0, 18); } ?>
                        	</a>
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
                                <?php }  ?>
                            
                            <?php } else { ?>
                                <div class="project-pledged-empty"></div>
                            <?php } ?>
                            
                          <div class="spaser-small"></div>
						  <div class="spaser1 display_descraption"><?php print unsanitize_string(ucfirst($sel_project2['shortBlurb'])); ?></div>
						  <div></div>
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
						  <div><p></p><div class="percentbar content-slider-percentbar">
							<div style="width:<?php echo round($percent * $scale); ?>%;"></div>
						  </div><p></p></div>
														   
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
									if($sel_project2['projectEnd']>time()   && $sel_project2['fundingStatus']!='n') {
										$end_date=(int) $sel_project2['projectEnd'];
										$cur_time=time();
										$total = $end_date - $cur_time;
										$left_days1=$total/(24 * 60 * 60);
									} else {
										$left_days1=0;
									}
								?>
                                <li class="last"> <?php echo floor($left_days1);?><br>Days to Go </li>
							</ul>
						  </div>
						   <div class="flclear"></div>
						</div>
					  </div>
                    </div>
            	</li>
            <?php }
			//While Loop Over ?>
			<?php
			}
			     
			}//While Over ($category_detail = mysql_fetch_assoc($all_categories)) ?> 
        <?php if($projCnt=='0') { ?>	
            
		<?php
            //echo "0";
		} ?>
		<?php if($projCnt>=4) {?>
            <li class="see_more_result">
              <a href="<?php echo SITE_URL; ?>search/<?php echo $searchTerm; ?>/">See All Results</a></span> 
            </li>
        <?php }//If Over proCnt?>	
            							
		<?php }//If Over mysql_num_rows($all_categories)>0
		else { ?>	
            <center><strong>No Record Found.</strong></center>
		<?php
            echo "0";
		}
	}//If Over ($searchTerm!='')
	else
	{
		$searchTerm = (isset($_GET) && isset($_GET['term'])) ? sanitize_string(trim($_GET['term'])) : '';
		//echo 'else';print_r($_GET);
		//$searchTerm = str_replace("/","",sanitize_string($searchTerm));
		$searchTerm = escapeSearchString($searchTerm);
		//$searchTerm = Slug($searchTerm);
		
		//$searchTerm = mysql_real_escape_string(str_replace(array('_', '%'), array('\_', '\%'),$searchTerm ));
		/*if(preg_match('/'.preg_quote('^\'£$%^&*()}{@#~?><,@|-=-_+-¬', '/').'/', $searchTerm))
		{
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"No project found.");				
			redirect($base_url.'index.php');
		}*/
		
		$perpage = 6;
		
		if(isset($searchTerm) && $searchTerm!='')
		{
			$extra='';
			if(!isset($_GET) || (isset($_GET['page']) && ($_GET['page']=='')))
			{
				$page=1;
			}
			else
			{
				$page = (isset($_GET) && isset($_GET['page'])) ? $_GET['page'] : 1;
			}
			$extra.="&term=".$searchTerm;
			
			//$perpage=9;
			
					
			//$sqlQuery = "SELECT * FROM projectbasics as pb,projects as p,categories as ct WHERE ct.isActive=1 AND p.published=1 AND p.accepted=1 AND p.projectId=pb.projectId AND ct.categoryId=pb.projectCategory AND (pb.projectTitle LIKE '%".$searchTerm."%' OR pb.shortBlurb LIKE '%".$searchTerm."%' OR ct.categoryName LIKE '%".$searchTerm."%') ORDER BY ct.categoryName ASC,pb.projectId DESC";
			
			//$total_rec = mysql_num_rows($con->recordselect($sqlQuery));
			
			//echo $total_rec;
			//exit;
			//select($qy,$page,$per_page,$totallink,$dpaging=0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$paggingvar='page')
			
			//AND pb.fundingStatus!='n' OR (pb.projectEnd >= $chktime_cur && pb.fundingStatus != 'r');
			$search_txt = $searchTerm;
			$chktime_cur=time();
			
			$tbl = "projectbasics as pb, projects as p";
			$tbl .= ", categories as ct";
			
			$condition = " ct.isActive=1 ";
			$condition .= " AND p.published=1 ";
			$condition .= " AND p.accepted=1 ";
			$condition .= " AND p.projectId=pb.projectId ";
			$condition .= " AND ct.categoryId=pb.projectCategory ";
			
			$condition .= " AND (pb.fundingStatus != 'n' OR (pb.projectEnd >= ".$chktime_cur." AND pb.fundingStatus = 'r'))";
			$condition .= " AND (pb.projectTitle LIKE '%".$search_txt."%' OR pb.shortBlurb LIKE '%".$search_txt."%' OR ct.categoryName LIKE '%".$search_txt."%') ";
			
			$limit = " LIMIT 0,".$perpage;
			
			$sqlQuery = "SELECT * FROM ".$tbl." WHERE ".$condition." ORDER BY ct.categoryName ASC,pb.projectId DESC".$limit;
			$sql_Total_rec = "SELECT * FROM ".$tbl." WHERE ".$condition." ORDER BY ct.categoryName ASC,pb.projectId DESC";
			
			$sql_Total_rec = $con->recordselect($sql_Total_rec);
			$total_num_records = mysql_num_rows($sql_Total_rec);
			
			
			$sel_staff2 = $con->recordselect($sqlQuery);
			$total_rec = mysql_num_rows($sel_staff2);
			
			//$sel_staff2 = $con->select($sqlQuery,$page,$perpage,15,2,0);
			
			$selCategory=$con->recordselect("SELECT * FROM categories WHERE isActive='1' ORDER BY categoryName ASC");
			$selCitie = $con->recordselect("SELECT projectLocation , projectId FROM projectbasics GROUP BY projectLocation ");
			$module="search";
			$pagename = "index";
			$content=$module.'/'.$pagename;
			require_once(DIR_TMP."main_page.tpl.php");
		}
		else
		{
			$_SESSION['msgType'] = array('from'=>'user', 'type'=>'error', 'var'=>"multiple",'val'=>"No project found.");				
			redirect($base_url.'index.php');
		}
} ?>