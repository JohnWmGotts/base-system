<?php
require_once("../../includes/config.php");

	if(!isset($_GET) || !isset($_GET['page']) || ($_GET['page']<1)) {
		$_GET['page'] = 1;
	}

//require_once("backedprojec_pagination.php");
//require_once("starredproject_pagination.php");

$perpage 	= isset($_REQUEST["per_page"]) ? (int)$_REQUEST["per_page"] : 3;
$limit 		= " LIMIT ".(isset($_REQUEST["load_rec"]) ? $_REQUEST["load_rec"] : 0).",".$perpage;
$curr_page	= isset($_REQUEST["curr_page"]) ? (int)$_REQUEST["curr_page"] : 0;

function ago($time) {
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

	   $difference     = $now - $time;
	   $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	   $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
	   $periods[$j].= "s";
   }

   return "$difference $periods[$j] ago ";
}
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
	$sort_col = array();
	foreach ($arr as $key=> $row) {
		$sort_col[$key] = $row[$col];
	}
	array_multisort($sort_col, $dir, $arr);
}

	$news_array = array (); 

$active_tab = isset($_REQUEST["active_tab"]) ? $_REQUEST["active_tab"] : NULL;

if($active_tab != NULL) {
	$return_arr = array();
	$return_arr["status"] = 200;
	
	$html_content = NULL;
	
	// For Tab 1
	if ( $active_tab == "a") {
		$ses_user = isset($_POST['ses_user']) ? $_POST['ses_user'] : NULL;
		$get_user = isset($_POST['get_user']) ? $_POST['get_user'] : NULL;
		
		if($get_user == NULL) {
			$sel_1=$con->recordselect("SELECT *,backingTime as sorting FROM `projectbacking` WHERE `userId` ='".$ses_user."' group by projectId order by backingTime desc");													
			$total_count = mysql_num_rows($sel_1) ;
			
			$sel_2=$con->recordselect("SELECT *,commentTime as sorting FROM `projectcomments` WHERE `userId` ='".$ses_user."' AND commentstatus=1 order by commentTime desc");													
			$total_count += mysql_num_rows($sel_2) ;
			
			$sel_3=$con->recordselect("SELECT *,updateTime as sorting FROM `projectupdate` WHERE `userId` ='".$ses_user."' AND updatestatus=1 order by updateTime desc");	
			$total_count += mysql_num_rows($sel_3) ;
			
			$sel_4=$con->recordselect("SELECT *,updateCommentTime as sorting FROM `projectupdatecomment` WHERE `userId` ='".$ses_user."' AND updatecommentstatus=1 order by updateCommentTime desc");	
			$total_count += mysql_num_rows($sel_4) ;
			
			$sel_5=$con->recordselect("SELECT *,pbs.projectStart as sorting FROM projects as p, projectbasics as pbs WHERE p.userId ='".$ses_user."' and p.projectId=pbs.projectId and p.published=1 and p.accepted=1 order by pbs.projectStart desc");	
			$total_count += mysql_num_rows($sel_5) ;
			/*echo "SELECT *,created_date as sorting FROM `projectreview` WHERE `userId` ='".$ses_user."' order by created_date desc";*/
			$sel_6=$con->recordselect("SELECT *,created_date as sorting FROM `projectreview` WHERE `userId` ='".$ses_user."' AND reviewstatus=1 order by created_date desc");													
			$total_count += mysql_num_rows($sel_6) ;
		}
		else {
			$sel_1=$con->recordselect("SELECT *,backingTime as sorting FROM `projectbacking` WHERE `userId` ='".$get_user."' group by projectId order by backingTime desc");													
			$total_count = mysql_num_rows($sel_1) ;
			
			$sel_2=$con->recordselect("SELECT *,commentTime as sorting FROM `projectcomments` WHERE `userId` ='".$get_user."' AND commentstatus=1 order by commentTime desc");													
			$total_count += mysql_num_rows($sel_2) ;
			
			$sel_3=$con->recordselect("SELECT *,updateTime as sorting FROM `projectupdate` WHERE `userId` ='".$get_user."' AND updatestatus=1 order by updateTime desc");	
			$total_count += mysql_num_rows($sel_3) ;
			
			$sel_4=$con->recordselect("SELECT *,updateCommentTime as sorting FROM `projectupdatecomment` WHERE `userId` ='".$get_user."' AND updatecommentstatus=1 order by updateCommentTime desc");	
			$total_count += mysql_num_rows($sel_4) ;
			
			$sel_5=$con->recordselect("SELECT *,pbs.projectStart as sorting FROM projects as p, projectbasics as pbs WHERE p.userId ='".$get_user."' and p.projectId=pbs.projectId and p.published=1 and p.accepted=1 order by pbs.projectStart desc");	
			$total_count += mysql_num_rows($sel_5) ;
			
			$sel_6=$con->recordselect("SELECT *,created_date as sorting FROM `projectreview` WHERE `userId` ='".$get_user."' AND reviewstatus=1 order by created_date desc");													
			$total_count += mysql_num_rows($sel_6) ;
		}
		
		while ( $row1 = mysql_fetch_array($sel_1) ) {
			array_push($news_array, $row1);
		}
		while ( $row2 = mysql_fetch_array($sel_2) ) {
			array_push($news_array, $row2);
		}
		while ( $row3 = mysql_fetch_array($sel_3) ) {
			array_push($news_array, $row3);
		}
		while ( $row4 = mysql_fetch_array($sel_4) ) {
			array_push($news_array, $row4);
		}
		while ( $row5 = mysql_fetch_array($sel_5) ) {
			array_push($news_array, $row5);
		}
		while ( $row6 = mysql_fetch_array($sel_6) ) {
			//echo 'ab';
			array_push($news_array, $row6);
		}
		array_sort_by_column($news_array,"sorting");
		
		$tempNewsArray = array();
		for($tempI = count($news_array); $tempI >= 0; $tempI--) {
			if(!empty($news_array[$tempI])) {
				$tempNewsArray[] = $news_array[$tempI];
			}
		}
		$news_array = $tempNewsArray;
		//print_r($news_array);
		
		$load_rec = isset($_REQUEST["load_rec"]) ? $_REQUEST["load_rec"] : 3;
		$val1	= ($perpage*$curr_page)-$perpage;
		$val2	= $curr_page*$perpage;
		
		//$val1	= ($perpage*1)-$perpage;
		//$val2	= 1*$perpage;
		
		$return_arr["total_rec"] = 0;
		for ($i = $val1+1; $i <= $val2; $i++) {
			$return_arr["total_rec"]++;
			 if ( isset($news_array[$i]['created_date']) ) { 
					
				/*$sel_3_data		= mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
					WHERE pb3.projectId='".$news_array[$i]['projectId']."' 
					AND p3.projectId='".$news_array[$i]['projectId']."'	AND usr3.userId='".$news_array[$i]['userId']."'
					
					AND cat3.categoryId=pb3.projectCategory"));
				$sel_3_dataimg	= mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));*/
				
				$sel_3_data		= mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
					WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.accepted!='3'
					AND p3.projectId='".$news_array[$i]['projectId']."'	AND usr3.userId=p3.userId
					
					AND cat3.categoryId=pb3.projectCategory"));
				$sel_3_dataimg	= mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));
				
				$sel_pro_creater3 = mysql_fetch_assoc($con->recordselect("SELECT * FROM projects as p2, users as usr2 WHERE p2.projectId='".$news_array[$i]['projectId']."' AND p2.userId = usr2.userId"));
				
				if($sel_3_data['projectTitle']!='') { $title4 = unsanitize_string(ucfirst($sel_3_data['projectTitle']));} else { $title4 = "Untitled"; }
				
				$html_content .= '<div class="tab_content_left">
                            	 <a href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'.'">';
									if($sel_3_dataimg['image223by169']!='' && file_exists(DIR_FS.$sel_3_dataimg['image223by169'])) {
                $html_content .=      	'<img src="'.SITE_URL.$sel_3_dataimg['image223by169'].'" title="'.$sel_3_data['projectTitle'].'" alt="'.$sel_3_data['projectTitle'].'">';
                                    } else {
                $html_content .=       	'<img src="'.NOIMG.'" title="'.$sel_3_data['projectTitle'].'" alt="'.$sel_3_data['projectTitle'].'">';
                                    }
                $html_content .= '</a>
                                <div class="right_comment">
                                    <a title="'.$title4.'" href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'.'">';
				$html_content .= $title4;
                $html_content .= '</a>
									<span class="Launched_project">Reviewed On A Project</span>
                                    <span >By <a title="'.$sel_pro_creater3['name'].'" class="linkblue" href="'.SITE_URL.'profile/'.$news_array[$i]['userId'].'/'.Slug($sel_pro_creater3['name']).'/'.'">
										'.$sel_pro_creater3['name'].'</a></span>
                                    <ul>
                                        <img src="'.SITE_IMG.'category.png" />
                                        <li>';
                                        	if($sel_3_data['isActive'] == 1) {
                $html_content .=           		'<a title="'.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'" href="'.SITE_URL.'category/'.$sel_3_data['categoryId'].'/'.Slug($sel_3_data['categoryName']).'/'.'">
													'.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'
                                            	</a>';
                                            }else {
                $html_content .=               '<a title="'.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'" href="javascript:void(0);">
                                                    '.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'
                                                </a>';
                                            }
                $html_content .=        '</li>
                                        <img src="'.SITE_IMG.'location.png" />
                                        <li>
                                        	<a title="'.ucfirst($sel_3_data['projectLocation']).'" href="'.SITE_URL.'city/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectLocation']).'/'.'">
												'.ucfirst($sel_3_data['projectLocation']).'
                                            </a>
                                        </li>
                                        <div class="clear"></div>
                                    </ul>
                                    <span class="activity-icon-quote"></span>
                                    <blockquote class="activity-project_update-blockquote">';
									
									$unsanaprotit2 = unsanitize_string($news_array[$i]['review']);
									$protit_len = strlen($unsanaprotit2);
									if($protit_len>350){
				$html_content .=		 substr($unsanaprotit2,0, 350).'...'; }
									else { 
				$html_content .=		 substr($unsanaprotit2, 0, 350); } 
										
                $html_content .=    '</blockquote>
                                    <div class="clear"></div>
                                </div>
                            	<div class="clear"></div>
                        	</div>';
				
			}
			else if ( isset($news_array[$i]['backingTime']) ) {
				
				$sel_1_data 			= mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb1, projects as p1, users as usr1, productimages as pi1, categories as cat1 
											WHERE pb1.projectId='".$news_array[$i]['projectId']."' AND p1.projectId='".$news_array[$i]['projectId']."' AND usr1.userId='".$news_array[$i]['userId']."' AND p1.accepted!='3' AND pb1.projectCategory = cat1.categoryId"));
				$sel_pro_creater		= mysql_fetch_assoc($con->recordselect("SELECT * FROM projects as p2, users as usr2 WHERE p2.projectId='".$news_array[$i]['projectId']."' AND p2.userId = usr2.userId"));
				$sel_backers_activity	= mysql_fetch_assoc($con->recordselect("SELECT count( distinct( `userId` )) AS backer_total2 FROM projectbacking WHERE projectId='".$news_array[$i]['projectId']."' "));
				$sel_pro_imgs1			= mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."'"));
				
				$html_content .= '<div class="tab_content_left">';
                            	if($sel_pro_imgs1['image223by169']!='' && file_exists(DIR_FS.$sel_pro_imgs1['image223by169'])) {
                $html_content .=    '<img src="'.SITE_URL.$sel_pro_imgs1['image223by169'].'" alt="'.ucfirst($sel_1_data['projectTitle']).'" title="'.ucfirst($sel_1_data['projectTitle']).'" />';
                                } else {
                $html_content .= 	'<img src="'.NOIMG.'" alt="'.ucfirst($sel_1_data['projectTitle']).'" title="'.ucfirst($sel_1_data['projectTitle']).'" />';
                                }
                if($sel_1_data['projectTitle']!='') { $title2 = unsanitize_string(ucfirst($sel_1_data['projectTitle'])); } else { $title2 = "Untitled"; }
				                
                $html_content .= '<div class="right_comment">  
                                    <a title="'.$title2.'" href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_1_data['projectTitle']).'/'.'">';
                $html_content .=    $title2;
                $html_content .=    '</a>
                                    <span >By <a title="'.ucfirst($sel_pro_creater['name']).'" class="linkblue" href="'.SITE_URL.'profile/'.$sel_pro_creater['userId'].'/'.Slug($sel_pro_creater['name']).'/'.'">
										'.ucfirst($sel_pro_creater['name']).'</a></span>
                                    <span class="Launched_project">Backed A Project</span>
                                    <ul>
                                        <img src="'.SITE_IMG.'category.png" />
                                        <li>';
                                        	if($sel_1_data['isActive'] == 1) {
                $html_content .=               '<a title="'.unsanitize_string(ucfirst($sel_1_data['categoryName'])).'" href="'.SITE_URL.'category/'.$sel_1_data['categoryId'].'/'.Slug($sel_1_data['categoryName']).'/'.'">
                                                    '.unsanitize_string(ucfirst($sel_1_data['categoryName'])).'
                                                </a>';
                                            }else {
                $html_content .=               '<a title="'.unsanitize_string(ucfirst($sel_1_data['categoryName'])).'" href="javascript:void(0);">
                                                    '.unsanitize_string(ucfirst($sel_1_data['categoryName'])).'
                                                </a>';
                                            }
                $html_content .=       '</li>
                                        <img src="'.SITE_IMG.'location.png" />
                                        <li>
                                        	<a title="'.ucfirst($sel_1_data['projectLocation']).'" href="'.SITE_URL.'city/'.$news_array[$i]['projectId'].'/'.Slug($sel_1_data['projectLocation']).'/'.'">
												'.ucfirst($sel_1_data['projectLocation']).'
                                            </a>
                                        </li>
                                        <div class="clear"></div>
                                    </ul>
                                    <p>'.unsanitize_string(ucfirst($sel_1_data['shortBlurb'])).'</p>';
                                    
                                    $chktime_cur=time(); if($sel_1_data['projectEnd']<=$chktime_cur) {
                                    	
                $html_content .=           '<h4 class="sticker">';
                                                if($sel_1_data['rewardedAmount']>=$sel_1_data['fundingGoal']) {
                $html_content .=               'SUCCESSFUL!';
                                                } else {
                $html_content .=               'FUNDING UNSUCCESSFUL';
                                                }
                $html_content .=           '</h4>';
                                        
                                    }
                                    
                $html_content .=   '<div class="clear"></div>';
										if($fundingAmount != NULL && $fundingAmount > 0){
											$value = $sel_1_data['rewardedAmount'];
											$max = $sel_1_data['fundingGoal'];
										}
										$scale = 1.0;
										if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
										else { $percent = 0; }
										if ( $percent > 100 ) { $percent = 100; }
									
                $html_content .=   '<div class="progress_bar">    
                                        <div style="width:'.round($percent * $scale).'%;" class="progres"></div>
                                    </div>
                                    <div class="bottom">
                                        <ul>';
												if($fundingAmount != NULL && $fundingAmount > 0){
													$value1 = $sel_1_data['rewardedAmount'];
													$max1 = $sel_1_data['fundingGoal'];
												}
												$scale = 1.0;
												if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
												else { $percent1 = 0; }
                                            
             $html_content .=              '<li>'.(int) $percent1."%".' Funded </li> 
                                            <li>|</li>';
                                            
											
             $html_content .=              '<li> $'.number_format($sel_1_data['rewardedAmount']).' Pledged</li>';
                                            
             $html_content .=              '<li>|</li>';
			 
											if($sel_1_data['projectEnd']>time()  && $sel_1_data['fundingStatus']!='n')
											{
												$end_date=(int) $sel_1_data['projectEnd'];
												$cur_time=time();
												$total = $end_date - $cur_time;
												$left_days=$total/(24 * 60 * 60);
											} else {
												$left_days=0;
											}
                                            
             $html_content .=            	'<li>'.roundDays($left_days).' days left</li>
                                            <div class="clear"></div>
                                        </ul>
                                    </div>
                                </div>
                            	<div class="clear"></div>
                        	</div>';	
			}
			else if ( isset($news_array[$i]['accepted']) ) { 
				$sel_5_data				= mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb1, projects as p1, users as usr1, categories as cat1 
										WHERE pb1.projectId='".$news_array[$i]['projectId']."' AND p1.projectId='".$news_array[$i]['projectId']."' AND p1.accepted!='3'	AND usr1.userId='".$news_array[$i]['userId']."' AND pb1.projectCategory = cat1.categoryId "));
										
				$sel_pro_creater5		= mysql_fetch_assoc($con->recordselect("SELECT * FROM projects as p2, users as usr2 WHERE p2.projectId='".$news_array[$i]['projectId']."' AND p2.userId = usr2.userId"));
				$sel_backers_activity	= mysql_fetch_assoc($con->recordselect("SELECT count( distinct( `userId` )) AS backer_total2 FROM projectbacking WHERE projectId='".$news_array[$i]['projectId']."' "));
				$sel_pro_imgs			= mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."'"));
				$main_category_name		= mysql_fetch_assoc($con->recordselect("SELECT * FROM categories WHERE categoryId='".$sel_5_data['main_categoryId']."'"));
						
				$html_content .= '<div class="tab_content_left">';
                            	if($sel_pro_imgs['image223by169']!='' && file_exists(DIR_FS.$sel_pro_imgs['image223by169'])) {
                $html_content .=   	'<img src="'.SITE_URL.$sel_pro_imgs['image223by169'].'"  alt="'.ucfirst($sel_5_data['projectTitle']).'" title="'.ucfirst($sel_5_data['projectTitle']).'" />';
                                } else {
                $html_content .=   	'<img src="'.NOIMG.'"  alt="'.ucfirst($sel_5_data['projectTitle']).'" title="'.ucfirst($sel_5_data['projectTitle']).'" />';
                                }
                if($sel_5_data['projectTitle']!='') { $title3 = unsanitize_string(ucfirst($sel_5_data['projectTitle'])); } else { $title3 = "Untitled"; }
								               
                $html_content .= '<div class="right_comment">
                                    <a title="'.$title3.'" href="'.SITE_URL.'browseproject/'.$sel_5_data['projectId'].'/'.Slug($sel_5_data['projectTitle']).'/'.'">'.$title3.'</a>
									<span class="Launched_project">Launched A Project</span>
                                    <span >By <a title="'.ucfirst($sel_pro_creater5['name']).'" class="linkblue" href="'.SITE_URL.'profile/'.$sel_pro_creater5['userId'].'/'.Slug($sel_pro_creater5['name']).'/'.'">
										'.ucfirst($sel_pro_creater5['name']).'</a></span>
                                    <ul>
                                        <img src="'.SITE_IMG.'category.png" />
                                        <li>';
                                        	if($sel_5_data['isActive'] == 1) {
                $html_content .=               '<a title="'.unsanitize_string(ucfirst($sel_5_data['categoryName'])).'" href="'.SITE_URL.'category/'.$sel_5_data['categoryId'].'/'.Slug($sel_5_data['categoryName']).'/'.'">
                                                    '.unsanitize_string(ucfirst($sel_5_data['categoryName'])).'
                                                </a>';
                                            }else {
                $html_content .=               '<a title="'.unsanitize_string(ucfirst($sel_5_data['categoryName'])).'" href="javascript:void(0);">
                                                    '.unsanitize_string(ucfirst($sel_5_data['categoryName'])).'
                                                </a>';
                                            }
                $html_content .=       '</li>
                                        <img src="'.SITE_IMG.'location.png" />
                                        <li>
                                        	<a title="'.ucfirst($sel_5_data['projectLocation']).'" href="'.SITE_URL.'city/'.$news_array[$i]['projectId'].'/'.Slug($sel_5_data['projectLocation']).'/'.'">
												'.ucfirst($sel_5_data['projectLocation']).'
                                            </a>
                                        </li>
                                        <div class="clear"></div>
                                    </ul>
                                    <p>'.unsanitize_string(ucfirst($sel_5_data['shortBlurb'])).'</p>';
                                    
                                    $chktime_cur=time(); if($sel_5_data['projectEnd']<=$chktime_cur) {
                                        
                $html_content .=            '<h4 class="sticker">';
                                               if($sel_5_data['rewardedAmount']>=$sel_5_data['fundingGoal']) {
                $html_content .=               'SUCCESSFUL!';
                                                } else {
                $html_content .=               'FUNDING UNSUCCESSFUL';
                                                }
                $html_content .=            '</h4>';
                                        
                                    }                                    
                $html_content .=   '<div class="clear"></div>';
										if($fundingAmount != NULL && $fundingAmount > 0){
											$value = $sel_5_data['rewardedAmount'];
											$max = $sel_5_data['fundingGoal'];
										}
										$scale = 1.0;
										if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
										else { $percent = 0; }
										if ( $percent > 100 ) { $percent = 100; }
									
                $html_content .=   '<div class="progress_bar">
                                        <div style="width:'.round($percent * $scale).'%;" class="progres"></div>
                                    </div>
                                    
                                    <div class="bottom">
                                    <ul>';
										if($fundingAmount != NULL && $fundingAmount > 0){
											$value1 = $sel_5_data['rewardedAmount'];
											$max1 = $sel_5_data['fundingGoal'];
										}
										$scale = 1.0;
										if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
										else { $percent1 = 0; }
										                                        
                $html_content .=       '<li>'. (int) $percent1."%".' Funded </li>
                                        <li>|</li>';
                                        
                $html_content .=       '<li> $'.number_format($sel_5_data['rewardedAmount']).' Pledged</li>';
                                        
                $html_content .=       '<li>|</li>';
				
										if($sel_5_data['projectEnd']>time()  && $sel_5_data['fundingStatus']!='n')
										{
											$end_date=(int) $sel_5_data['projectEnd'];
											$cur_time=time();
											$total = $end_date - $cur_time;
											$left_days=$total/(24 * 60 * 60);
										} else {
											$left_days=0;
										}
										
                $html_content .=       '<li>'.roundDays($left_days).' days left</li>
                                        <div class="clear"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>';
			
			}
			else if ( isset($news_array[$i]['commentTime']) ) { 
						
				/*$sel_3_data		= mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
					WHERE pb3.projectId='".$news_array[$i]['projectId']."' 
					AND p3.projectId='".$news_array[$i]['projectId']."'	AND usr3.userId='".$news_array[$i]['userId']."'
					
					AND cat3.categoryId=pb3.projectCategory"));
				$sel_3_dataimg	= mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));*/
				
				$sel_3_data		= mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
					WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.accepted!='3'
					AND p3.projectId='".$news_array[$i]['projectId']."'	AND usr3.userId=p3.userId
					
					AND cat3.categoryId=pb3.projectCategory"));
				$sel_3_dataimg	= mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));
				
				$sel_pro_creater3 = mysql_fetch_assoc($con->recordselect("SELECT * FROM projects as p2, users as usr2 WHERE p2.projectId='".$news_array[$i]['projectId']."' AND p2.userId = usr2.userId"));
				
				if($sel_3_data['projectTitle']!='') { $title4 = unsanitize_string(ucfirst($sel_3_data['projectTitle']));} else { $title4 = "Untitled"; }
				
				$html_content .= '<div class="tab_content_left">
                            	 <a href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'.'">';
									if($sel_3_dataimg['image223by169']!='' && file_exists(DIR_FS.$sel_3_dataimg['image223by169'])) {
                $html_content .=      	'<img src="'.SITE_URL.$sel_3_dataimg['image223by169'].'" title="'.$sel_3_data['projectTitle'].'" alt="'.$sel_3_data['projectTitle'].'">';
                                    } else {
                $html_content .=       	'<img src="'.NOIMG.'" title="'.$sel_3_data['projectTitle'].'" alt="'.$sel_3_data['projectTitle'].'">';
                                    }
                $html_content .= '</a>
                                <div class="right_comment">
                                    <a title="'.$title4.'" href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'.'">';
				$html_content .= $title4;
                $html_content .= '</a>
									<span class="Launched_project">Commented On A Project</span>
                                    <span >By <a title="'.$sel_pro_creater3['name'].'" class="linkblue" href="'.SITE_URL.'profile/'.$news_array[$i]['userId'].'/'.Slug($sel_pro_creater3['name']).'/'.'">
										'.$sel_pro_creater3['name'].'</a></span>
                                    <ul>
                                        <img src="'.SITE_IMG.'category.png" />
                                        <li>';
                                        	if($sel_3_data['isActive'] == 1) {
                $html_content .=           		'<a title="'.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'" href="'.SITE_URL.'category/'.$sel_3_data['categoryId'].'/'.Slug($sel_3_data['categoryName']).'/'.'">
													'.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'
                                            	</a>';
                                            }else {
                $html_content .=               '<a title="'.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'" href="javascript:void(0);">
                                                    '.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'
                                                </a>';
                                            }
                $html_content .=        '</li>
                                        <img src="'.SITE_IMG.'location.png" />
                                        <li>
                                        	<a title="'.ucfirst($sel_3_data['projectLocation']).'" href="'.SITE_URL.'city/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectLocation']).'/'.'">
												'.ucfirst($sel_3_data['projectLocation']).'
                                            </a>
                                        </li>
                                        <div class="clear"></div>
                                    </ul>
                                    <span class="activity-icon-quote"></span>
                                    <blockquote class="activity-project_update-blockquote">';
									
									$unsanaprotit2 = unsanitize_string($news_array[$i]['comment']);
									$protit_len = strlen($unsanaprotit2);
									if($protit_len>350){
				$html_content .=		 substr($unsanaprotit2,0, 350).'...'; }
									else { 
				$html_content .=		 substr($unsanaprotit2, 0, 350); } 
										
                $html_content .=    '</blockquote>
                                    <div class="clear"></div>
                                </div>
                            	<div class="clear"></div>
                        	</div>';
				
			}
			else if ( isset($news_array[$i]['created_date']) ) { 
					
				/*$sel_3_data		= mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
					WHERE pb3.projectId='".$news_array[$i]['projectId']."' 
					AND p3.projectId='".$news_array[$i]['projectId']."'	AND usr3.userId='".$news_array[$i]['userId']."'
					
					AND cat3.categoryId=pb3.projectCategory"));
				$sel_3_dataimg	= mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));*/
				
				$sel_3_data		= mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
					WHERE pb3.projectId='".$news_array[$i]['projectId']."' AND p3.accepted!='3'
					AND p3.projectId='".$news_array[$i]['projectId']."'	AND usr3.userId=p3.userId
					
					AND cat3.categoryId=pb3.projectCategory"));
				$sel_3_dataimg	= mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));
				
				$sel_pro_creater3 = mysql_fetch_assoc($con->recordselect("SELECT * FROM projects as p2, users as usr2 WHERE p2.projectId='".$news_array[$i]['projectId']."' AND p2.userId = usr2.userId"));
				
				if($sel_3_data['projectTitle']!='') { $title4 = unsanitize_string(ucfirst($sel_3_data['projectTitle']));} else { $title4 = "Untitled"; }
				
				$html_content .= '<div class="tab_content_left">
                            	 <a href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'.'">';
									if($sel_3_dataimg['image223by169']!='' && file_exists(DIR_FS.$sel_3_dataimg['image223by169'])) {
                $html_content .=      	'<img src="'.SITE_URL.$sel_3_dataimg['image223by169'].'" title="'.$sel_3_data['projectTitle'].'" alt="'.$sel_3_data['projectTitle'].'">';
                                    } else {
                $html_content .=       	'<img src="'.NOIMG.'" title="'.$sel_3_data['projectTitle'].'" alt="'.$sel_3_data['projectTitle'].'">';
                                    }
                $html_content .= '</a>
                                <div class="right_comment">
                                    <a title="'.$title4.'" href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'.'">';
				$html_content .= $title4;
                $html_content .= '</a>
									<span class="Launched_project">Reviewed On A Project</span>
                                    <span >By <a title="'.$sel_pro_creater3['name'].'" class="linkblue" href="'.SITE_URL.'profile/'.$news_array[$i]['userId'].'/'.Slug($sel_pro_creater3['name']).'/'.'">
										'.$sel_pro_creater3['name'].'</a></span>
                                    <ul>
                                        <img src="'.SITE_IMG.'category.png" />
                                        <li>';
                                        	if($sel_3_data['isActive'] == 1) {
                $html_content .=           		'<a title="'.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'" href="'.SITE_URL.'category/'.$sel_3_data['categoryId'].'/'.Slug($sel_3_data['categoryName']).'/'.'">
													'.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'
                                            	</a>';
                                            }else {
                $html_content .=               '<a title="'.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'" href="javascript:void(0);">
                                                    '.unsanitize_string(ucfirst($sel_3_data['categoryName'])).'
                                                </a>';
                                            }
                $html_content .=        '</li>
                                        <img src="'.SITE_IMG.'location.png" />
                                        <li>
                                        	<a title="'.ucfirst($sel_3_data['projectLocation']).'" href="'.SITE_URL.'city/'.$news_array[$i]['projectId'].'/'.Slug($sel_3_data['projectLocation']).'/'.'">
												'.ucfirst($sel_3_data['projectLocation']).'
                                            </a>
                                        </li>
                                        <div class="clear"></div>
                                    </ul>
                                    <span class="activity-icon-quote"></span>
                                    <blockquote class="activity-project_update-blockquote">';
									
									$unsanaprotit2 = unsanitize_string($news_array[$i]['review']);
									$protit_len = strlen($unsanaprotit2);
									if($protit_len>350){
				$html_content .=		 substr($unsanaprotit2,0, 350).'...'; }
									else { 
				$html_content .=		 substr($unsanaprotit2, 0, 350); } 
										
                $html_content .=    '</blockquote>
                                    <div class="clear"></div>
                                </div>
                            	<div class="clear"></div>
                        	</div>';
				
			}
			else if ( isset($news_array[$i]['updateTime']) ) { 
								
				$sel_2_data = mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb2, projects as p2, users as usr2, categories as cat2 
							WHERE pb2.projectId='".$news_array[$i]['projectId']."' AND p2.projectId='".$news_array[$i]['projectId']."' AND p2.accepted!='3'
							AND usr2.userId='".$news_array[$i]['userId']."' AND cat2.categoryId=pb2.projectCategory"));
				$sel_2_dataimg = mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));
					 
				if($sel_2_data['projectTitle']!='') {$title5 = unsanitize_string(ucfirst($sel_2_data['projectTitle'])); } else { $title5 = "Untitled"; }
				
				$html_content .= '<div class="tab_content_left">
                            	<a href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_2_data['projectTitle']).'/'.'">';
									if($sel_2_dataimg['image223by169']!='' && file_exists(DIR_FS.$sel_2_dataimg['image223by169'])) {
                $html_content .=       	'<img src="'.SITE_URL.$sel_2_dataimg['image223by169'].'" title="'.ucfirst($sel_2_data['projectTitle']).'" alt="'.ucfirst($sel_2_data['projectTitle']).'">';
                                    } else {
                $html_content .=        '<img src="'.NOIMG.'" title="'.ucfirst($sel_2_data['projectTitle']).'" alt="'.ucfirst($sel_2_data['projectTitle']).'">';
                                    }
                $html_content .='</a>
                                <div class="right_comment">
									<a title="'.$title5.'" href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_2_data['projectTitle']).'/'.'">';
				$html_content .= $title5;
                $html_content .= '</a>
									<span class="Launched_project">Posted Project Update #'.$news_array[$i]['updatenumber'].'</span>
                                    <span >By <a title="'.$sel_2_data['name'].'" class="linkblue" href="'.SITE_URL.'profile/'.$news_array[$i]['userId'].'/'.Slug($sel_2_data['name']).'/'.'">
										'.$sel_2_data['name'].'</a></span>
                                    <ul>
                                        <img src="'.SITE_IMG.'category.png" />
                                        <li>';
                                        	if($sel_2_data['isActive'] == 1) {
                $html_content .=               '<a title="'.unsanitize_string(ucfirst($sel_2_data['categoryName'])).'" href="'.SITE_URL.'category/'.$sel_2_data['categoryId'].'/'.Slug($sel_2_data['categoryName']).'/'.'">
                                                    '.unsanitize_string(ucfirst($sel_2_data['categoryName'])).'
                                                </a>';
                                            }else {
                $html_content .=                '<a title="'.unsanitize_string(ucfirst($sel_2_data['categoryName'])).'" href="javascript:void(0);">
                                                    '.unsanitize_string(ucfirst($sel_2_data['categoryName'])).'
                                                </a>';
                                            }
                $html_content .=        '</li>
                                        <img src="'.SITE_IMG.'location.png" />
                                        <li>
                                        	<a title="'.ucfirst($sel_2_data['projectLocation']).'" href="'.SITE_URL.'city/'.$news_array[$i]['projectId'].'/'.Slug($sel_2_data['projectLocation']).'/'.'">
												'.ucfirst($sel_2_data['projectLocation']).'
                                            </a>
                                        </li>
                                        <div class="clear"></div>
                                    </ul>
                                    <span class="activity-icon-quote"></span>
                                    <blockquote class="activity-project_update-blockquote">
                                    	<a href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_2_data['projectTitle']).'/&update='.$news_array[$i]['updatenumber'].'#b'.'">
											'.unsanitize_string(ucfirst($news_array[$i]['updateTitle'])).'
                                        </a>';
										
											$unsanaprotit2 = unsanitize_string($news_array[$i]['updateDescription']);
											$protit_len = strlen($unsanaprotit2);
											if($protit_len>350){
				$html_content .=				 substr($unsanaprotit2,0, 350).'...'; }
											else { 
				$html_content .=				 substr($unsanaprotit2, 0, 350); } 
										
                $html_content .=    '</blockquote>
                                    <div class="clear"></div>
                                </div>
                            	<div class="clear"></div>
                        	</div>';
			
			}
			else if ( isset($news_array[$i]['updateCommentTime']) ) { 
							
				/*$sel_4_data 	= mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb4, projects as p4, users as usr4, categories as cat4 
								WHERE pb4.projectId='".$news_array[$i]['projectId']."' AND p4.projectId='".$news_array[$i]['projectId']."' 
								AND usr4.userId='".$news_array[$i]['userId']."' AND cat4.categoryId=pb4.projectCategory"));*/
								
				$sel_4_data 	= mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb4, projects as p4, users as usr4, categories as cat4 
								WHERE pb4.projectId='".$news_array[$i]['projectId']."' AND p4.projectId='".$news_array[$i]['projectId']."' AND p4.accepted!='3' 
								AND usr4.userId=p4.userId AND cat4.categoryId=pb4.projectCategory"));
						
				$sel_4_dataimg 	= mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array[$i]['projectId']."' limit 1 "));
				
				$sel_pro_creater4 = mysql_fetch_assoc($con->recordselect("SELECT * FROM projects as p2, users as usr2 WHERE p2.projectId='".$news_array[$i]['projectId']."' AND p2.userId = usr2.userId"));
					
				if($sel_4_data['projectTitle']!='') { $title6 = unsanitize_string(ucfirst($sel_4_data['projectTitle'])); }else { $title6 = "Untitled"; }
				
				$html_content .= '<div class="tab_content_left">
                            	<a href="'.SITE_URL.'browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_4_data['projectTitle']).'/'.'">';
									if($sel_4_dataimg['image223by169']!='' && file_exists(DIR_FS.$sel_4_dataimg['image223by169'])) {
                $html_content .=        '<img  src="'.SITE_URL.$sel_4_dataimg['image223by169'].'" title="'.ucfirst($sel_4_data['projectTitle']).'" alt="'.ucfirst($sel_4_data['projectTitle']).'">';
                                    } else {
                $html_content .=       	'<img  src="'.NOIMG.'" title="'.ucfirst($sel_4_data['projectTitle']).'" alt="'.ucfirst($sel_4_data['projectTitle']).'">';
                                    }
                $html_content .='</a>
                                <div class="right_comment">
                                    <a title="'.$title6.'" href="'.SITE_URL.'/browseproject/'.$news_array[$i]['projectId'].'/'.Slug($sel_4_data['projectTitle']).'/'.'">';
				$html_content .=	$title6;
				$html_content .=	'</a>
									<span class="Launched_project">Commented On A Project Update</span>
                                    <span >By <a title="'.ucfirst($sel_pro_creater4['name']).'" class="linkblue" href="'.SITE_URL.'profile/'.$news_array[$i]['userId'].'/'.Slug($sel_pro_creater4['name']).'/'.'">
										'.ucfirst($sel_pro_creater4['name']).'</a></span>
                                    <ul>
                                        <img src="'.SITE_IMG.'category.png" />
                                        <li>';
                                        	if($sel_4_data['isActive'] == 1) {
                $html_content .=               '<a title="'.unsanitize_string(ucfirst($sel_4_data['categoryName'])).'" href="'.SITE_URL.'category/'.$sel_4_data['categoryId'].'/'.Slug($sel_4_data['categoryName']).'/'.'">
                                                    '.unsanitize_string(ucfirst($sel_4_data['categoryName'])).'
                                                </a>';
                                            }else {
                $html_content .=               '<a title="'.unsanitize_string(ucfirst($sel_4_data['categoryName'])).'" href="javascript:void(0);">
                                                    '.unsanitize_string(ucfirst($sel_4_data['categoryName'])).'
                                                </a>';
                                            }
                $html_content .=       '</li>
                                        <img src="'.SITE_IMG.'location.png" />
                                        <li>
                                        	<a title="'.ucfirst($sel_4_data['projectLocation']).'" href="'.SITE_URL.'city/'.$news_array[$i]['projectId'].'/'.Slug($sel_4_data['projectLocation']).'/'.'">
												'.ucfirst($sel_4_data['projectLocation']).'
                                            </a>
                                        </li>
                                        <div class="clear"></div>
                                    </ul>
                                    <span class="activity-icon-quote"></span>
                                    <blockquote class="activity-project_update-blockquote">';
									$unsanaprotit2 = unsanitize_string($news_array[$i]['updateComment']);
									$protit_len = strlen($unsanaprotit2);
									if($protit_len>350){
				$html_content .=		 substr($unsanaprotit2,0, 350).'...'; }
									else { 
				$html_content .=		 substr($unsanaprotit2, 0, 350); } 
               $html_content .=     '</blockquote>
                                    <div class="clear"></div>
                                </div>
                            	<div class="clear"></div>
                        	</div>';
			}
			
		} 
	}
	else if ( $active_tab == "b" ) {
		
		$ses_user = isset($_POST['ses_user']) ? $_POST['ses_user'] : NULL;
		$get_user = isset($_POST['get_user']) ? $_POST['get_user'] : NULL;
		
		if( $ses_user != NULL && $get_user == NULL || $ses_user == $get_user) {
			$sql = "SELECT * FROM `projects` WHERE `userId` ='".$ses_user."' ORDER BY `projectId` DESC ".$limit;
			$sel_created = mysql_query($sql);
		}
		else {
			$sql = "SELECT * FROM `projects` WHERE `userId` ='".$get_user."' AND published=1 AND accepted=1 ORDER BY `projectId` DESC ".$limit;
			$sel_created = mysql_query($sql);
		}
		
		$return_arr["total_rec"] = mysql_num_rows($sel_created);
			
		while ( $sel_createdprojects = mysql_fetch_assoc($sel_created) ) {
		
			/*$sel_createproject=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId='".$sel_createdprojects['projectId']."'"));
			$sel_cr_projectuser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projects` WHERE projectId='".$sel_createdprojects['projectId']."'"));
			$sel_createprojectuser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_cr_projectuser['userId']."'"));
			$sel_createproject_image=mysql_fetch_assoc($con->recordselect("SELECT * FROM `productimages` WHERE projectId='".$sel_createdprojects['projectId']."'"));
			$sel_createproject_cat=mysql_fetch_assoc($con->recordselect("SELECT * FROM `categories` WHERE categoryId='".$sel_createproject['projectCategory']."'"));
			$sel_cr_backers=mysql_fetch_assoc($con->recordselect("SELECT  count( distinct( `userId` )) AS backers FROM `projectbacking` WHERE `projectId` ='".$sel_createdprojects['projectId']."'"));*/
				
			$sel_createproject=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbasics` as pb INNER JOIN projects as p ON pb.projectId = p.projectId INNER JOIN categories as c ON c.categoryId = pb.projectCategory AND p.accepted!='3'  INNER JOIN productimages as pi ON pi.projectId = pb.projectId  WHERE pb.projectId='".$sel_createdprojects['projectId']."'"));
			$sel_cr_projectuser=$sel_createproject;
			$sel_createproject_cat=$sel_createproject;
			$sel_createproject_image=$sel_createproject;
			$sel_createprojectuser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_cr_projectuser['userId']."'"));
			$sel_cr_backers=mysql_fetch_assoc($con->recordselect("SELECT  count( distinct( `userId` )) AS backers FROM `projectbacking` WHERE `projectId` ='".$sel_createdprojects['projectId']."'"));
			
			$main_category_name1=mysql_fetch_assoc($con->recordselect("SELECT * FROM `categories` WHERE categoryId ='".$sel_createproject_cat['main_categoryId']."'"));
			
			
			if($sel_createdprojects['published']==1 && $sel_createdprojects['accepted']==1){
				$href1 = $base_url.'browseproject/'.$sel_createdprojects['projectId'].'/'.Slug($sel_createproject['projectTitle']).'/'; 
			}else{
				$href1 = $base_url.'createproject/'.$sel_createdprojects['projectId']; 
			}
			
			if($sel_createproject_image['image223by169']!='' && file_exists(DIR_FS.$sel_createproject_image['image223by169'])){ 
				$img1 = SITE_URL.$sel_createproject_image['image223by169']; } else { $img1 = NOIMG; }
			if($sel_createproject['projectTitle']!='') { $title1 =  unsanitize_string(ucfirst($sel_createproject['projectTitle'])); } else { $title1 =  "Untitled"; }
			
			if($sel_createdprojects['published']==1 && $sel_createdprojects['accepted']==1) {
				$pubAcCondition = $base_url.'browseproject/'.$sel_createdprojects['projectId'].'/'.Slug($sel_createproject['projectTitle']).'/'; 
			} else {
				$pubAcCondition = $base_url.'createproject/'.$sel_createdprojects['projectId']; 
			}
			$html_content .= '<div class="tab_content_left">
                                <a href="'.$href1.'" >
										<img src="'.$img1.'" title="'.$title1.'" alt="'.$title1.'" />
								</a>
								<div class="right_comment">
                                    <a title="'.$title1.'" 
										href="'.$pubAcCondition.'" >
                                        '.$title1.'
									</a>
                                    <span >By 
                                    	<a title="'.ucfirst($sel_createprojectuser['name']).'" class="linkblue" href="'.SITE_URL.'profile/'.$sel_createprojectuser['userId'].'/'.Slug($sel_createprojectuser['name']).'/'.'">
											'.ucfirst($sel_createprojectuser['name']).'
                                        </a>
                                    </span>';
									
                                    $cur_time2=time();
                                    if($sel_createdprojects['published']==1 && $sel_createdprojects['accepted']==1 && $sel_createdprojects['userId']==$_SESSION['userId'] && $sel_createproject['projectEnd']>$cur_time2) { 
             $html_content .=          '<span class="Launched_project">
                                        <a href="'.SITE_URL.'projectupdate/'.$sel_createdprojects['projectId'].'/'.Slug($sel_createproject['projectTitle']).'/'.'">
                                            Make update
                                        </a>
                                        </span>';
                                    }
                                    
             $html_content .=      '<ul>';
                                    	if($sel_createproject_cat['categoryName']!='') {
             $html_content .= 	        	'<img src="'.SITE_IMG.'category.png" />
                                            <li>';
                                            	if($sel_createproject_cat['isActive'] == 1) {
             $html_content .=                      '<a title="'.unsanitize_string(ucfirst($sel_createproject_cat['categoryName'])).'" href="'.SITE_URL.'category/'.$sel_createproject_cat['categoryId'].'/'.Slug($sel_createproject_cat['categoryName']).'/'.'">
                                                        '.unsanitize_string(ucfirst($sel_createproject_cat['categoryName'])).'
                                                    </a>';
                                                }else {
             $html_content .=                      '<a title="'.unsanitize_string(ucfirst($sel_createproject_cat['categoryName'])).'" href="javascript:void(0);">
                                                        '.unsanitize_string(ucfirst($sel_createproject_cat['categoryName'])).'
                                                    </a>';
                                                }
             $html_content .=              '</li>
                                            <img src="'.SITE_IMG.'location.png" />
                                            <li>
                                            	<a title="'.ucfirst($sel_createproject['projectLocation']).'" href="'.SITE_URL.'city/'.$sel_createdprojects['projectId'].'/'.Slug($sel_createproject['projectLocation']).'/'.'">
													'.ucfirst($sel_createproject['projectLocation']).'
                                                </a>
                                            </li>';
                                        }
             $html_content .=           '<div class="clear"></div>
                                    </ul>
                                    <p>'.unsanitize_string(ucfirst($sel_createproject['shortBlurb'])).'</p>';
									$chktime_cur=time(); 
									if($sel_createproject['projectEnd']<=$chktime_cur && $sel_createdprojects['published']==1 && $sel_createdprojects['accepted']==1) { 
                                        
             $html_content .=               '<h4 class="sticker">';
                                                if($sel_createproject['rewardedAmount']>=$sel_createproject['fundingGoal']) {
             $html_content .=                      'SUCCESSFUL!';
                                                } else {
             $html_content .=                      'FUNDING UNSUCCESSFUL';
                                                }
             $html_content .=               '</h4>';
                                        
                                    }
                                    
             $html_content .=      '<div class="clear"></div>';
                                    if($sel_createdprojects['published']==1 && $sel_createdprojects['accepted']==1) {
											if($fundingAmount != NULL && $fundingAmount > 0){
												$value = $sel_createproject['rewardedAmount'];
												$max = $sel_createproject['fundingGoal'];
											}
											$scale = 1.0;
											if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
											else { $percent = 0; }
											if ( $percent > 100 ) { $percent = 100; }
										
              $html_content .=         '<div class="progress_bar">
                                            <div style="width:'.round($percent * $scale).'%" class="progres"></div>
                                        </div>
                                        <div class="bottom">
                                            <ul>';
													if($fundingAmount != NULL && $fundingAmount > 0){
														$value1 = $sel_createproject['rewardedAmount'];
														$max1 = $sel_createproject['fundingGoal'];
													}
													$scale = 1.0;
													if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
													else { $percent1 = 0; }
													
               $html_content .=                '<li>'.(int) $percent1."%".' Funded </li>
                                                <li>|</li>';
                                                
               $html_content .=                '<li> $'.number_format($sel_createproject['rewardedAmount']).' Pledged</li>';
                                                
               $html_content .=                '<li>|</li>';
			   
													if($sel_createproject['projectEnd']>time() && $sel_createproject['fundingStatus']!='n'){
														$end_date=(int) $sel_createproject['projectEnd'];
														$cur_time=time();
														$total = $end_date - $cur_time;
														$left_days=$total/(24 * 60 * 60);
													}else{
														$left_days=0;
													}
													
                $html_content .=               '<li>'.roundDays($left_days).' days left</li>
                                                <div class="clear"></div>
                                            </ul>
                                        </div>';
                                        
                                    } else {
                $html_content .=      '<h4 class="sticker">Project Not Launched</h4>
                                        <strong>(only you can see this)</strong>';
                                    }   
                $html_content .=   '</div>
                                <div class="clear"></div>
                        	</div>';
			
		}
	}
	else if ( $active_tab == "c" ) {
		
		$ses_user = isset($_POST['ses_user']) ? $_POST['ses_user'] : NULL;
		$get_user = isset($_POST['get_user']) ? $_POST['get_user'] : NULL;
		
		if ( $get_user == NULL ) {
			$sel_backedproject	= $con->recordselect("SELECT DISTINCT bk.projectId FROM `projectbacking` as bk,`projects` as p WHERE bk.userId ='".$ses_user."' and bk.projectId=p.projectId and p.accepted!=3".$limit);													
		}else {
			$sel_backedproject=$con->recordselect("SELECT DISTINCT bk.projectId FROM `projectbacking` as bk,,`projects` as p WHERE bk.userId ='".$get_user."' and bk.projectId=p.projectId and p.accepted!=3".$limit);
		}
		$return_arr["total_rec"] = mysql_num_rows($sel_backedproject);
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
	 
			$html_content .= '<div class="tab_content_left">
                                    <a href="'.SITE_URL.'browseproject/'.$sel_backedproject1['projectId'].'/'.Slug($sel_backproject['projectTitle']).'/'.'">';
										if($sel_backproject_image['image223by169']!='' && file_exists(DIR_FS.$sel_backproject_image['image223by169'])) {
            $html_content .=                '<img src="'.SITE_URL.$sel_backproject_image['image223by169'].'" title="'.unsanitize_string($sel_backproject['projectTitle']).'" alt="'.$sel_backproject['projectTitle'].'" />';
                                        } else {
            $html_content .=                '<img src="'.NOIMG.'" title="'.unsanitize_string($sel_backproject['projectTitle']).'" alt="'.$sel_backproject['projectTitle'].'"  />';
                                        }
            $html_content .=        '</a>
                                    <div class="right_comment">
                                        <a title="'.unsanitize_string(ucfirst($sel_backproject['projectTitle'])).'" href="'.SITE_URL.'browseproject/'.$sel_backedproject1['projectId'].'/'.Slug($sel_backproject['projectTitle']).'/'.'">';
											if($sel_backproject['projectTitle']!='') { $title003 = unsanitize_string(ucfirst($sel_backproject['projectTitle'])); } else { $title003 = "Untitled"; }
            $html_content .=            $title003.'</a>
                                        <span >By <a title="'.ucfirst($sel_backprojectuser['name']).'" class="linkblue" href="'.SITE_URL.'profile/'.$sel_backprojectuser['userId'].'/'.Slug($sel_backprojectuser['name']).'/'.'">
											'.ucfirst($sel_backprojectuser['name']).'</a></span>
                                        <ul>
                                            <img src="'.SITE_IMG.'category.png" />
                                            <li>';
                                            	if($sel_backproject_cat['isActive'] == 1) {
            $html_content .=                        '<a title="'.unsanitize_string(ucfirst($sel_backproject_cat['categoryName'])).'" href="'.SITE_URL.'category/'.$sel_backproject_cat['categoryId'].'/'.Slug($sel_backproject_cat['categoryName']).'/'.'">
                                                        '.unsanitize_string(ucfirst($sel_backproject_cat['categoryName'])).'
                                                    </a>';
                                                }else {
            $html_content .=                        '<a title="'.unsanitize_string(ucfirst($sel_backproject_cat['categoryName'])).'" href="javascript:void(0);">
                                                        '.unsanitize_string(ucfirst($sel_backproject_cat['categoryName'])).'
													</a>';
                                                }
            $html_content .=                '</li>
                                            <img src="'.SITE_IMG.'location.png" />
                                            <li>
                                            	<a title="'.unsanitize_string(ucfirst($sel_backproject['projectLocation'])).'" href="'.SITE_URL.'city/'.$sel_backedproject1['projectId'].'/'.Slug($sel_backproject['projectLocation']).'/'.'">
													'.unsanitize_string(ucfirst($sel_backproject['projectLocation'])).'
                                                </a>
                                            </li>
                                            <div class="clear"></div>
                                        </ul>
                                        <p>'.unsanitize_string(ucfirst($sel_backproject['shortBlurb'])).'</p>';
										
                                        $chktime_cur=time(); if($sel_backproject['projectEnd']<=$chktime_cur) {
                                            
             $html_content .=                  '<h4 class="sticker">';
                                                    if($sel_backproject['rewardedAmount']>=$sel_backproject['fundingGoal']) {
             $html_content .=                       'SUCCESSFUL!';
                                                    } else {
             $html_content .=                       'FUNDING UNSUCCESSFUL';
                                                    }
             $html_content .=                   '</h4>';
                                            
                                        }
             $html_content .=          '<div class="clear"></div>';
											if($fundingAmount != NULL && $fundingAmount > 0){
												$value = $sel_backproject['rewardedAmount'];
												$max = $sel_backproject['fundingGoal'];
											}
											$scale = 1.0;
											if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
											else { $percent = 0; }
											if ( $percent > 100 ) { $percent = 100; }
										
             $html_content .=            '<div class="progress_bar">
                                            <div style="width:'.round($percent * $scale).'%" class="progres">
                                            </div>
                                        </div>
                                        <div class="bottom">
                                            <ul>';
													if($fundingAmount != NULL && $fundingAmount > 0){
														$value1 = $sel_backproject['rewardedAmount'];
														$max1 = $sel_backproject['fundingGoal'];
													}
													$scale = 1.0;
													if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
													else { $percent1 = 0; }
												
             $html_content .=                  '<li>'.(int) $percent1."%".' Funded </li>
                                                <li>|</li>';
                                                
             $html_content .=                  '<li> $'.number_format($sel_backproject['rewardedAmount']).' Pledged</li>';
                                                
             $html_content .=                  '<li>|</li>';
													if($sel_backproject['projectEnd']>time() && $sel_backproject['fundingStatus']!='n'){
														$end_date=(int) $sel_backproject['projectEnd'];
														$cur_time=time();
														$total = $end_date - $cur_time;
														$left_days=$total/(24 * 60 * 60);
													}else{
														$left_days=0;
													}
             $html_content .=                  '<li>'.roundDays($left_days).' days left</li>
                                                <div class="clear"></div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>';
			} 
		}
	}
	else if ( $active_tab == "d" ) {
		
		$ses_user = isset($_POST['ses_user']) ? $_POST['ses_user'] : NULL;
		$get_user = isset($_POST['get_user']) ? $_POST['get_user'] : NULL;
		/*if ( $get_user == NULL ) {
			$sel_backedproject	= $con->recordselect("SELECT DISTINCT bk.projectId FROM `projectbacking` as bk,`projects` as p WHERE bk.userId ='".$ses_user."' and bk.projectId=p.projectId and p.accepted!=3".$limit);													
		}else {
			$sel_backedproject=$con->recordselect("SELECT DISTINCT bk.projectId FROM `projectbacking` as bk,,`projects` as p WHERE bk.userId ='".$get_user."' and bk.projectId=p.projectId and p.accepted!=3".$limit);
		}*/
		if ( $get_user == NULL ) {
			$sel_starredproject	= $con->recordselect("SELECT * FROM `projectremind`,`projects` as p WHERE rm.userId ='".$ses_user."' AND rm.status=1 and rm.projectId=p.projectId and p.accepted!=3 ORDER BY rm.remindTime DESC".$limit);
		}else {
			$sel_starredproject	= $con->recordselect("SELECT * FROM `projectremind`,`projects` as p WHERE rm.userId ='".$get_user."' AND rm.status=1 and rm.projectId=p.projectId and p.accepted!=3 ORDER BY rm.remindTime DESC".$limit);	
		}
		
		$return_arr["total_rec"] = mysql_num_rows($sel_starredproject);
		
		if ( mysql_num_rows($sel_starredproject) > 0 ) {
			
			while( $sel_starredproject1 = mysql_fetch_assoc($sel_starredproject) ) {
				
				$sel_starproject=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId='".$sel_starredproject1['projectId']."'"));
				$sel_staruser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projects` WHERE projectId='".$sel_starredproject1['projectId']."'"));
				$sel_starprojectusername=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_staruser['userId']."'"));
				$sel_starprojectuser=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_starredproject1['userId']."'"));
				$sel_starproject_image1=$con->recordselect("SELECT * FROM `productimages` WHERE projectId='".$sel_starredproject1['projectId']."'");
				$sel_starproject_image=mysql_fetch_assoc($sel_starproject_image1);
				$sel_starproject_cat=mysql_fetch_assoc($con->recordselect("SELECT * FROM `categories` WHERE categoryId='".$sel_starproject['projectCategory']."'"));
				$sel_starbackers=mysql_fetch_assoc($con->recordselect("SELECT  count( distinct( `userId` )) AS backers FROM `projectbacking` WHERE `projectId` ='".$sel_starredproject1['projectId']."'"));
		
				$html_content .= '<div class="tab_content_left">
                                    <a href="'.SITE_URL.'browseproject/'.$sel_starredproject1['projectId'].'/'.Slug($sel_starproject['projectTitle']).'/'.'">';
										if($sel_starproject_image['image223by169']!='' && file_exists(DIR_FS.$sel_starproject_image['image223by169']) && mysql_num_rows($sel_starproject_image1)>0) {
                      		$html_content .= '<img src="'.SITE_URL.$sel_starproject_image['image223by169'].'"  alt="'.$sel_starproject['projectTitle'].'" title="'.$sel_starproject['projectTitle'].'" />';
                                        } else {
                            $html_content .= '<img src="'.NOIMG.'"  alt="'.$sel_starproject['projectTitle'].'" title="'.$sel_starproject['projectTitle'].'" />';
                                        }
                            $html_content .= '</a>';
                            $html_content .= '<div class="right_comment">
                                        <a title="'.unsanitize_string(ucfirst($sel_starproject['projectTitle'])).'" href="'.SITE_URL.'browseproject/'.$sel_starredproject1['projectId'].'/'.Slug($sel_starproject['projectTitle']).'/'.'">';
											if($sel_starproject['projectTitle']!='') { $title007 = unsanitize_string(ucfirst($sel_starproject['projectTitle'])); } else {  $title007 =  "Untitled"; }
                            $html_content .= $title007.'</a>
                                        <span >By <a title="'.ucfirst($sel_starprojectusername['name']).'" class="linkblue" href="'.SITE_URL.'profile/'.$sel_starprojectusername['userId'].'/'.Slug($sel_starprojectusername['name']).'/'.'">'.ucfirst($sel_starprojectusername['name']).'</a>
										</span>
                                        <ul>
                                            <img src="'.SITE_IMG.'category.png" />
                                            <li>';
                                            	if($sel_starproject_cat['isActive'] == 1) {
                            $html_content .= '<a title="'.unsanitize_string(ucfirst($sel_starproject_cat['categoryName'])).'" href="'.SITE_URL.'category/'.$sel_starproject_cat['categoryId'].'/'.Slug($sel_starproject_cat['categoryName']).'/'.'">'.unsanitize_string(ucfirst($sel_starproject_cat['categoryName'])).'</a>';
                                                }else {
                            $html_content .= '<a title="'.unsanitize_string(ucfirst($sel_starproject_cat['categoryName'])).'" href="javascript:void(0);">
                                                        '.unsanitize_string(ucfirst($sel_starproject_cat['categoryName'])).'
                                                    </a>';
                                                }
                             $html_content .= '</li>
                                            <img src="'.SITE_IMG.'location.png" />
                                            <li>
                                            	<a title="'.unsanitize_string(ucfirst($sel_starproject['projectLocation'])).'" href="'.SITE_URL.'city/'.$sel_starredproject1['projectId'].'/'.Slug($sel_starproject['projectLocation']).'/'.'">
													'.unsanitize_string(ucfirst($sel_starproject['projectLocation'])).'
                                                </a>
                                            </li>
                                            <div class="clear"></div>
                                        </ul>
                                        <p>'.unsanitize_string(ucfirst($sel_starproject['shortBlurb'])).'</p>';
                                        $chktime_cur=time(); if($sel_starproject['projectEnd']<=$chktime_cur) {
                                            
                              $html_content .= '<h4 class="sticker">';
                                                    if($sel_starproject['rewardedAmount']>=$sel_starproject['fundingGoal']){
                              $html_content .=		    'SUCCESSFUL!';
                                                    } else {
                              $html_content .=          'FUNDING UNSUCCESSFUL';
                                                    }
                              $html_content .= '</h4>';
                                            
										}   
                              $html_content .= '<div class="clear"></div>';
                                        
											if($fundingAmount != NULL && $fundingAmount > 0){
												$value = $sel_starproject['rewardedAmount'];
												$max = $sel_starproject['fundingGoal'];
											}
											$scale = 1.0;
											if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
											else { $percent = 0; }
											if ( $percent > 100 ) { $percent = 100; }
										
                               $html_content .= '<div class="progress_bar">
                                            <div style="width:'.round($percent * $scale).'%" class="progres">
                                            </div>
                                        </div>
                                        <div class="bottom">
                                            <ul>';
													if($fundingAmount != NULL && $fundingAmount > 0){
														$value1 = $sel_starproject['rewardedAmount'];
														$max1 = $sel_starproject['fundingGoal'];
													}
													$scale = 1.0;
													if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
													else { $percent1 = 0; }
												
                                $html_content .= '<li>'. (int) $percent1."%".' Funded </li>
                                                <li>|</li>';
                                                
                                $html_content .= '<li> $'.number_format($sel_starproject['rewardedAmount']).' Pledged</li>';
                                                
                                $html_content .= '<li>|</li>';
													if($sel_starproject['projectEnd']>time() && $sel_starproject['fundingStatus']!='n'){
														$end_date=(int) $sel_starproject['projectEnd'];
														$cur_time=time();
														$total = $end_date - $cur_time;
														$left_days=$total/(24 * 60 * 60);
													}else{
														$left_days=0;
													}
												
                                $html_content .= '<li>'.roundDays($left_days).' days left</li>
                                                <div class="clear"></div>
                                            </ul>
                                        </div>
                                    </div>
                            		<div class="clear"></div>
                        		</div>';
			} 
		}
	}
	
	$return_arr["html_content"] = $html_content;
	$return_arr["curr_page"] = ($curr_page+1);
	echo json_encode_html($return_arr);
	exit;
}

?>