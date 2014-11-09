<?php
require "../../includes/config.php";

if($_REQUEST) {
	extract($_REQUEST);
	//$per_page
	//$search_txt
	//$load_rec
	$chktime_cur=time();
	
	$tbl = "projectbasics as pb, projects as p";
	$tbl .= ", categories as ct";
	
	$condition = " ct.isActive=1 ";
	$condition .= " AND p.published=1 ";
	$condition .= " AND p.accepted=1 ";
	$condition .= " AND p.projectId=pb.projectId ";
	$condition .= " AND ct.categoryId=pb.projectCategory ";
	
	$condition .= " AND (pb.fundingStatus != 'n' OR (pb.projectEnd >= ".$chktime_cur." AND pb.fundingStatus = 'r'))";
	$condition .= " AND (pb.projectTitle LIKE '%".$search_txt."%' OR pb.shortBlurb LIKE '%".$search_txt."%') ";
	
	$limit = " LIMIT ".$load_rec.",".$per_page;
	//print "SELECT * FROM ".$tbl." WHERE ".$condition." ORDER BY ct.categoryName ASC,pb.projectId DESC".$limit;
	$sqlQuery = "SELECT * FROM ".$tbl." WHERE ".$condition." ORDER BY ct.categoryName ASC,pb.projectId DESC".$limit;
	$sqlRes = $con->recordselect($sqlQuery);
	
	$content = NULL;
	
	
	$total_rec = mysql_num_rows($sqlRes);
	if($total_rec > 0) {
		while ($sel_project2 = mysql_fetch_assoc($sqlRes)) {					
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
			
			$content .= '<li>
							<div class="innerbox">
								<div class="img_thumb">
									<a href="'.base_url.'browseproject/'.$sel_project2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'.'">';
										
									if(($sel_image2['image223by169'] != NULL || $sel_image2['image223by169']!='') && mysql_num_rows($sel_image22)>0) { 
										if(file_exists(DIR_FS.$sel_image2['image223by169'])) { 
											$content .= '<img src="'.SITE_URL.$sel_image2['image223by169'].'" title="'.$sel_project2['projectTitle'].'" alt="'.$sel_project2['projectTitle'].'" />';
										
										} 
										else { 
											$content .= '<img src="'.NOIMG.'" title="'.$sel_project2['projectTitle'].'" alt="'.$sel_project2['projectTitle'].'" />';
											
										}
									} 
									else { 
										$content .= '<img src="'.NOIMG.'" title="'.$sel_project2['projectTitle'].'" alt="'.$sel_project2['projectTitle'].'" />';
									}
						$content .= '</a>
								</div>
								<div class="poductname">';
								
								if($sel_categories2['isActive'] == 1) { 
									$content .= '<a title="'.(isset($sel_categories2['categoryName']) ? $sel_categories2['categoryName'] : 'Unknown').'" href="'.$base_url.'category/'.$sel_categories2['categoryId'].'/'.Slug($sel_categories2['categoryName']).'/'.'">'.(isset($sel_categories2['categoryName']) ? $sel_categories2['categoryName'] : 'Unknown').' </a>';
								}
								else { 
									$content .= '<a title="'.(isset($sel_categories2['categoryName']) ? $sel_categories2['categoryName'] : 'Unknown').'" href="javascript:void(0);">'.(isset($sel_categories2['categoryName']) ? $sel_categories2['categoryName'] : 'Unknown').'</a>';
								}
					$content .= '</div>
							<div class="whitebox">	
								<div class="textnormal-b">
									<strong>
										<a title="'.unsanitize_string(ucfirst($sel_project2['projectTitle'])).'" href="'.SITE_URL.'browseproject/'.$sel_project2['projectId'].'/'.Slug($sel_project2['projectTitle']).'/'.'">';
										$unsanaprotit = unsanitize_string(ucfirst($sel_project2['projectTitle'])); 
										$protit_len=strlen($unsanaprotit);
										
										if($sel_project2['projectTitle']!='') { 
											if($protit_len>22) {
												$content .= '<b>'.substr($unsanaprotit, 0, 22).'...</b>'; 
											} 
											else { 
												$content .= '<b>'.substr($unsanaprotit, 0, 22).'</b>'; 
											} 
										} 
										else { 
											$content .= '<b>Untitled</b>';
										}
							$content .= '</a>
									</strong>
								</div>
								
								<div class="spaser-small"></div>
								
								<div>by <a title="'.unsanitize_string(ucfirst($sel_user2['name'])).'" class="linkblue" href="'.SITE_URL.'profile/'.$sel_user2['userId'].'/'.Slug($sel_user2['name']).'/'.'">';
								$unsanaprotit1=unsanitize_string(ucfirst($sel_user2['name']));
								$protit_len1=strlen($unsanaprotit1);
									
									if($protit_len1>23) {
										$content .= '<b>'.substr($unsanaprotit1, 0, 23).'...</b>'; 
									} 
									else { 
										$content .= '<b>'.substr($unsanaprotit1, 0, 23).'</b>'; 
									} 
						$content .= '</a>
								</div>
								
								<div class="spaser-small"></div>
								
								<div class="textsmall-g">
									<span class="location-small"></span>
									<a title="'.unsanitize_string(ucfirst($sel_project2['projectLocation'])).'" href="'.SITE_URL.'city/'.$sel_project2['projectId'].'/'.Slug(ucfirst($sel_project2['projectLocation'])).'/'.'">';
									$unsanaprotit2 = unsanitize_string(ucfirst($sel_project2['projectLocation']));  
									$protit_len=strlen($unsanaprotit2);  
									if($protit_len>23) {
										$content .= '<b>'. substr($unsanaprotit2, 0, 23).'...</b>'; 
									} 
									else { 
										$content .= '<b>'. substr($unsanaprotit2, 0, 23).'</b>'; 
									}
						$content .= '</a>
								</div>';
								
								$chktime_cur=time(); 
								if($sel_project2['projectEnd']<=$chktime_cur) { 
									if($sel_project2['rewardedAmount']>=$sel_project2['fundingGoal'])
									{ 
										$content .= '<div class="project-pledged-successful">SUCCESSFUL!</div>';
									} else { 
										$content .= '<div class="project-pledged-empty"></div>';
									} 
								} 
								else { 
									$content .= '<div class="project-pledged-empty"></div>';
								}
							$content .= '<div class="spaser-small"></div>
								
								<div class="spaser1 display_descraption">'.unsanitize_string(ucfirst($sel_project2['shortBlurb'])).'</div>
															
								<div class="spaser-small"></div>
								<div class="gray-line"></div>';
								$fundingAmount = (isset($sel_project2['fundingGoal']) OR !empty($sel_project2['fundingGoal'])) ? $sel_project2['fundingGoal'] : 0;
									if($fundingAmount != NULL && $fundingAmount > 0){
										$value = $sel_project2['rewardedAmount'];
										$max = $sel_project2['fundingGoal'];
									}
									$scale = 1.0;
									if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
									else { $percent = 0; }
									if ( $percent > 100 ) { $percent = 100; }
								
					$content .= '<div><p>
									<div class="percentbar content-slider-percentbar">
									<div style="width:'.round($percent * $scale).'%;"></div>
									</div></p>
								</div>
								
								<div class="spaser-small"></div>
								
								<div class="latest-rating">
									<ul>';
										
											if($fundingAmount != NULL && $fundingAmount > 0){
												$value1 = $sel_project2['rewardedAmount'];
												$max1 = $sel_project2['fundingGoal'];
											}
											$scale = 1.0;
											if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
											else { $percent1 = 0; }
										
										$content .= '<li>'.((int) $percent1)."%".'<br>Funded </li>';
										
										$content .= '<li> $'.number_format($sel_project2['rewardedAmount']).'<br />Pledged</li>';
										
										if($sel_project2['projectEnd']>time() && $sel_project2['fundingStatus']!='n') {
											$end_date=(int) $sel_project2['projectEnd'];
											$cur_time=time();
											$total = $end_date - $cur_time;
											$left_days1=$total/(24 * 60 * 60);
										} 
										else {
											$left_days1=0;
										}
											
							$content .= '<li class="last"> '.roundDays($left_days1).'<br>
											Days to Go </li>
									</ul>
								</div>
							
							</div>
						</div>
					 </li>';
	
			}
	}
	
	$arr["html"] = $content;
	$arr["total_rec"] = $total_rec;
	
	echo json_encode_html($arr);
	exit;
	
}
?>