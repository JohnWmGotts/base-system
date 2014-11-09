<?php
require_once("../../includes/config.php");

$perpage 	= isset($_REQUEST["per_page"]) ? (int)$_REQUEST["per_page"] : 3;
$limit 		= " LIMIT ".(isset($_REQUEST["load_rec"]) ? $_REQUEST["load_rec"] : 0).",".$perpage;
$comment_limit = " LIMIT ".(isset($_REQUEST["load_rec_comment"]) ? $_REQUEST["load_rec_comment"] : 0).",".$perpage;

$curr_page	= isset($_REQUEST["curr_page"]) ? (int)$_REQUEST["curr_page"] : 0;
$curr_page_comment	= isset($_REQUEST["curr_page_comment"]) ? (int)$_REQUEST["curr_page_comment"] : 0;

$active_tab = isset($_REQUEST["active_tab"]) ? $_REQUEST["active_tab"] : NULL;

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

if($active_tab != NULL) {
	//echo $active_tab;exit;
	$return_arr = array();
	$return_arr["status"] = 200;
	//print_r($_POST);
	$html_content 	= NULL;
	
	$ses_user 		= isset($_POST['ses_user']) ? $_POST['ses_user'] : NULL;
	$get_project 	= isset($_POST['get_project']) ? $_POST['get_project'] : NULL;
	$return_arr["total_rec"] = 0;
	
	try {
		if ( $active_tab == "a") {
			
			/*$get_project = isset($_POST['get_project']) ? $_POST['get_project'] : NULL;
			$return_arr["total_rec"] = 0;
			$html_content = "";*/
		}
	
		else if ( $active_tab == "b" ) {
			
			 $get_updates 	= isset($_POST['get_updates']) ? $_POST['get_updates'] : NULL;
			$count_backers 	= isset($_POST['count_backers']) ? $_POST['count_backers'] : NULL;
			
			$sel_updates_qry = "SELECT * FROM `projectupdate` WHERE projectId = '".$get_project."' AND updatestatus=1 ORDER BY updateTime DESC ".$limit;
			$sel_updates = mysql_query($sel_updates_qry);
			
			if ( $get_updates == '' ) {
				if(mysql_num_rows($sel_updates) > 0) {
					while ($sel_updates_project = mysql_fetch_assoc($sel_updates)) {
					
						$update_time = $sel_updates_project['updateTime'];
						$return_arr["total_rec"]++;
						
						$html_content .= '<div class="update_box first">
									<h1>Update #'.$sel_updates_project['updatenumber'].": ".unsanitize_string(ucfirst($sel_updates_project['updateTitle'])).'</h1>
									<h2>Posted '.ago($update_time).'</h2>
									<div class="clear"></div>
									<p>'.unsanitize_string($sel_updates_project['updateDescription']).'</p>
									
							
								<div class="comment" id="updt-comment-container-'.$sel_updates_project['updatenumber'].'">';
								
									$tot_updt_coment_res = $con->recordselect("SELECT * FROM `projectupdatecomment` WHERE `projectId` = '".$get_project."' AND updatecommentstatus=1 AND updatenumber ='".$sel_updates_project['updatenumber']."' ORDER BY updateCommentTime DESC");
									$tot_updt_coment = mysql_num_rows($tot_updt_coment_res);
                                    $sel_updateProjectComment	= $con->recordselect("SELECT * FROM `projectupdatecomment` WHERE `projectId` = '".$get_project."' AND updatecommentstatus=1 AND updatenumber ='".$sel_updates_project['updatenumber']."' ORDER BY updateCommentTime DESC ".$comment_limit);
									
									while ($sel_updateProjectComments = mysql_fetch_assoc($sel_updateProjectComment)) {
										
										$sel_updateCommentUsr	= mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_updateProjectComments['userId']."'"));
										
						$html_content .= '<div class="comment_box backgrndnone">
										   <div class="comment_box_left1">
											<a href="'.SITE_URL.'profile/'.$sel_updateCommentUsr['userId'].'/'.Slug($sel_updateCommentUsr['name']).'/'.'">'; 
												$check_usr12proimg=str_split($sel_updateCommentUsr['profilePicture80_80'], 4);
												if($sel_updateCommentUsr['profilePicture80_80']!='' && $sel_updateCommentUsr['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_updateCommentUsr['profilePicture80_80']) && $check_usr12proimg[0]=='imag') {
						$html_content .=            '<img src="'.SITE_URL.$sel_updateCommentUsr['profilePicture80_80'].'" class="avatar-thumb" alt="'.$sel_updateCommentUsr['name'].'" title="'.$sel_updateCommentUsr['name'].'">';
												} else if($sel_updateCommentUsr['profilePicture80_80']!='' && $sel_updateCommentUsr['profilePicture80_80']!=NULL && $check_usr12proimg[0]=='http') {
						$html_content .=            '<img src="'.$sel_updateCommentUsr['profilePicture80_80'].'" class="avatar-thumb" alt="'.$sel_updateCommentUsr['name'].'" title="'.$sel_updateCommentUsr['name'].'">';
												} else {
						$html_content .=            '<img width="80" height="80" src="'.NOIMG2.'" class="avatar-thumb" alt="'.$sel_updateCommentUsr['name'].'" title="'.$sel_updateCommentUsr['name'].'">';
												}
						$html_content .=  	'</a>
											</div>
											<div class="comment_box_right1">
											<a href="'.SITE_URL.'profile/'.$sel_updateCommentUsr['userId'].'/'.Slug($sel_updateCommentUsr['name']).'/'.'" class="float-left">
												'.unsanitize_string(ucfirst($sel_updateCommentUsr['name'])).'
											</a>
											<h6 class="float-right"><a href="javascript:void(0);">About ';
											$update_comment_time=$sel_updateProjectComments['updateCommentTime']; 
						$html_content .=    ago($update_comment_time);
						$html_content .=    '</a></h6>
											<div class="clear"></div>
											<p>'.$sel_updateProjectComments['updateComment'].'</p>
											</div>
											<div class="clear"></div>
										</div>';
															
									}
						$html_content .= '</div>';
						$html_content .='<div class="space10"></div>';
						
										if($tot_updt_coment > $perpage) {
						$html_content .= '<div id="dv_comment_b">
											<center class="post-btn float-left">
												<div class="morelink">
													<input type="hidden" id="hidden_val_comment_b_'.$sel_updates_project['updatenumber'].'" value="'.$perpage.'">
													<input type="hidden" id="hidden_curr_page_comment_b_'.$sel_updates_project['updatenumber'].'" value="0">
													<a href="javascript:;" class="hover-effect load_post_comments" data-for="comment_b" data-number="'.$sel_updates_project['updatenumber'].'" data-project="'.$sel_updates_project['projectId'].'">Get More Comments...</a>
												</div>
											</center>
											<div class="space10"></div>
										</div>';
										}
									
									if(isset($_SESSION['userId']) && ($count_backers > 0 || $sel_projectcreater['userId']==$_SESSION['userId'])) {

						$html_content .= '<script type="text/javascript">
										$(document).ready(function() {
											$("#frm_userupdate_comment_'.$sel_updates_project['updatenumber'].'").validate({
												rules: {
														projectupdate_comment: { required: true, maxlength:255 }
														},
												messages: {
														projectupdate_comment: {
															required: "Please Enter comment",
															maxlength: "Accepted only 255 characters"
														}
													}
											});
										});
										</script>';
						$html_content .='<form method="post" action="'.SITE_URL.'browseproject/'.$get_project.'/" name="frm_userupdate_comment" id="frm_userupdate_comment_'.$sel_updates_project['updatenumber'].'">								
											<textarea id="projectupdate_comment-'.$sel_updates_project['updatenumber'].'" onkeyup="countCharPrjUpdate(this)" name="projectupdate_comment" ></textarea>
											<div id="charNumPrjUpdate'.$sel_updates_project['updatenumber'].'">255</div>
											<br/>
											<input type="hidden" name="updatenumber" value="'.$sel_updates_project['updatenumber'].'" />
											<input name="submitProjectUpdateComment" type="submit" value="Post Comment" />
											<div class="space10"></div>							
										</form> ';                    
									
									}
						$html_content .='</div>';
					}
				}
			}
			else {
				
				$sel_updates_project1 = mysql_fetch_assoc( $con->recordselect("SELECT * FROM `projectupdate` WHERE `projectId` = '".$get_project."' AND updatestatus=1 AND  updatenumber='".$get_updates."'") ); 	
				
				$html_content .= '<div class="update_box first">
                                <h1>Update # '.$sel_updates_project1['updatenumber'].": ".unsanitize_string(ucfirst($sel_updates_project1['updateTitle'])).'</h1>
                                <h2>Posted ';
								$update_time1 = $sel_updates_project1['updateTime']; 
				$html_content .= ago($update_time1).'</h2>
                                <p>'.unsanitize_string($sel_updates_project1['updateDescription']).'</p>
                                
								<div class="comment" id="updt-comment-container-'.$sel_updates_project1['updatenumber'].'">';
								
									$tot_updt_coment_res = $con->recordselect("SELECT * FROM `projectupdatecomment` WHERE `projectId` = '".$get_project."' AND updatecommentstatus=1 AND updatenumber ='".$sel_updates_project['updatenumber']."' ORDER BY updateCommentTime DESC");
									$tot_updt_coment = mysql_num_rows($tot_updt_coment_res);
										
									$sel_updateProjectComment1 = $con->recordselect("SELECT * FROM `projectupdatecomment` WHERE `projectId` = '".$get_project."' AND updatecommentstatus=1 AND updatenumber ='".$sel_updates_project['updatenumber']."' ORDER BY updateCommentTime DESC".$comment_limit);
                                    
									while ( $sel_updateProjectComments1 = mysql_fetch_assoc($sel_updateProjectComment1) ) {
										
										$sel_updateCommentUsr1=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_updateProjectComments1['userId']."'"));		
								
                $html_content .=  	'<div class="comment_box backgrndnone">
                                            <a href="'.SITE_URL.'profile/'.$sel_updateCommentUsr1['userId'].'/'.Slug($sel_updateCommentUsr1['name']).'/'.'">';
											 
                                                $check_usr123proimg=str_split($sel_updateCommentUsr1['profilePicture80_80'], 4);
                                                if($sel_updateCommentUsr1['profilePicture80_80']!='' && $sel_updateCommentUsr1['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_updateCommentUsr1['profilePicture80_80']) && $check_usr123proimg[0]=='imag') {
                $html_content .=                   	'<img src="'.SITE_URL.$sel_updateCommentUsr1['profilePicture'].'" alt="'.$sel_updateCommentUsr1['name'].'" title="'.$sel_updateCommentUsr1['name'].'">';
                                                } else if($sel_updateCommentUsr1['profilePicture80_80']!='' && $sel_updateCommentUsr1['profilePicture80_80']!=NULL && $check_usr123proimg[0]=='http') { 
                $html_content .=                   	'<img  src="'.$sel_updateCommentUsr1['profilePicture'].'" alt="'.$sel_updateCommentUsr1['name'].'" title="'.$sel_updateCommentUsr1['name'].'">';
                                                } else {
                $html_content .=                   	'<img width="80" height="80" src="'.NOIMG2.'" alt="'.$sel_updateCommentUsr['name'].'" title="'.$sel_updateCommentUsr1['name'].'">';
                                                }
                $html_content .=           '</a>
                                            <a href="'.SITE_URL.'profile/'.$sel_updateCommentUsr1['userId'].'/'.Slug($sel_updateCommentUsr1['name']).'/'.'">';
												unsanitize_string(ucfirst($sel_updateCommentUsr1['name']));
                $html_content .=           '</a> 
                                            <h6><a href="javascript:void(0);">About ';
											$update_comment_time1 = $sel_updateProjectComments1['updateCommentTime'];
				$html_content .=			ago($update_comment_time1);
                $html_content .=           '</a></h6>
                                            <p>'.$sel_updateProjectComments1['updateComment'].'</p>
                                            <div class="clear"></div>
                                        </div>';
                                
                                }
                $html_content .= '</div>';
				$html_content .='<div class="space10"></div>';
								if($tot_updt_coment > $perpage) {	
                $html_content .='<div id="dv_comment_b">
                                    <center class="post-btn float-left">
                                        <div class="morelink">
                                            <input type="hidden" id="hidden_val_comment_b_'.$sel_updates_project1['updatenumber'].'" value="'.$perpage.'">
                                            <input type="hidden" id="hidden_curr_page_comment_b_'.$sel_updates_project1['updatenumber'].'" value="0">
                                            <a href="javascript:;" class="hover-effect load_post_comments" data-for="comment_b" data-number="'.$sel_updates_project1['updatenumber'].'" data-project="'.$sel_updates_project1['projectId'].'">Get More Comments...</a>
                                        </div>
                                    </center>
                                    <div class="space10"></div>
                                </div>';
                                }
                                    
                                if(isset($_SESSION['userId']) && ($count_backers > 0 || $sel_projectcreater['userId']==$_SESSION['userId'])) {
									
                $html_content .='<script type="text/javascript">
									$(document).ready(function() {
										$("#frm_userupdate_comment_'.$sel_updates_project['updatenumber'].'").validate({
											rules: {
												projectupdate_comment: { required: true, maxlength:255 }
											},
											messages: {
												projectupdate_comment: {
													required: "Please Enter comment",
													maxlength: "Accepted only 255 characters"
												}
											}
										});
									});
									</script>';
									
                $html_content .=   '<form method="post" action="'.SITE_URL.'browseproject/'.$get_project.'/&update='.$sel_updates_project1['updatenumber'].'#update/" name="frm_userupdate_comment" id="frm_userupdate_comments1">								
                                        <textarea id="projectupdate_comment1" onkeyup="countCharPrjUpCmt(this)" name="projectupdate_comment1" ></textarea>
                                        <div id="charNumPrjUpCmt">255</div>
                                        <input type="hidden" name="updatenumber1" value="'.$sel_updates_project1['updatenumber'].'" />
                                        <input name="submitProjectUpdateComment1" type="submit" value="Post Comment" />							
                                    </form>';

                                }
                                
								if($_SESSION["userId"] != $sel_projectcreater['userId']) { 
                                    if(isset($_SESSION['userId'])) {
										$dialogue_name = 'dialogaskcreater1';
                $html_content .=       '<input type="hidden" value="Ask the project creator" id="dialogaskcreater1" />';
                $html_content .=       "<h6>Only backers can post comments. If you have a question,<a class='ask-creater' href='javascript:void(0)' onClick='return sendmessage(document.getElementById(".$dialogue_name.").value);' > ask the project creator.</a></h6>";
                                    } else { 
                //$html_content .=      '<h6><a class="ask-creater-for-comment" href="javascript:void(0)" onClick="return chkloginforcomment();">Leave a comment (for backers only)</a></h6>';
                                    }  
								}
   							
				$html_content .= '</div>';
			}
			$return_arr["curr_page"] = ($curr_page+1);
		}
	
		else if ( $active_tab == "c" ) {
			
			$sel_backers_qry = "SELECT DISTINCT `userId` FROM `projectbacking` WHERE `projectId` = '".$get_project."' ".$limit;
			$sel_backeruser = mysql_query($sel_backers_qry);
			
			if ( mysql_num_rows($sel_backeruser) > 0 ) {
				while ( $sel_users = mysql_fetch_assoc($sel_backeruser) ) {
					
					$return_arr["total_rec"]++;
					$sel_user 					= mysql_fetch_assoc( $con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_users['userId']."'") );
					$sel_userbackprojectcount 	= mysql_fetch_assoc( $con->recordselect("SELECT count(DISTINCT(projectId)) as totalcounts FROM `projectbacking` WHERE `userId` = '".$sel_users['userId']."'") );
					$count_project				= $sel_userbackprojectcount['totalcounts'] - 1;
					
					$html_content .= '<div class="comment_box comment2 backers" id="div-backers">
										<div class="comment2_left">
										<a href="'.SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_users['userId']).'/'.'">'; 
											$check_usrpro123img=str_split($sel_user['profilePicture80_80'], 4);
											if($sel_user['profilePicture80_80']!='' && $sel_user['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_user['profilePicture80_80']) && $check_usrpro123img[0]=='imag') {
					$html_content .=           	'<img src="'.SITE_URL.$sel_user['profilePicture80_80'].'" alt="'.unsanitize_string(ucfirst($sel_user['name'])).'" title="'.unsanitize_string($sel_user['name']).'" /></a>';
											} else if($sel_user['profilePicture80_80']!='' && $sel_user['profilePicture80_80']!=NULL && $check_usrpro123img[0]=='http') {
					$html_content .=           	'<img src="'.$sel_user['profilePicture80_80'].'" alt="'.unsanitize_string(ucfirst($sel_user['name'])).'" title="'.unsanitize_string($sel_user['name']).'" /></a>';
											} else {
					$html_content .=          	'<img src="'.NOIMG.'" alt="'.unsanitize_string(ucfirst($sel_user['name'])).'" title="'.unsanitize_string($sel_user['name']).'" height="80" width="80"  /></a>';
											}
					$html_content .=    '</a>
										</div>
										<div class="comment2_right">
										<a title="'.$sel_user['name'].'" href="'.SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_user['name']).'/'.'">
											'.$sel_user['name'].'
										</a>
										<h5>';
										if($count_project>0) { 
											if($count_project == 1) { 
					$html_content .= 		 'Backed '. $count_project .' other project. '; 
											}else { 
					$html_content .= 		 'Backed '. $count_project .' other projects. ';
											}
										}
					$html_content .= 	'</h5>
										</div>
										<div class="clear"></div>
									</div>';
				}
			}
			$return_arr["curr_page"] = ($curr_page+1);
		}
	
		else if ( $active_tab == "d" ) {
			$sel_usercomment = $con->recordselect("SELECT * FROM `projectcomments` WHERE `projectId` = '".$get_project."' AND commentstatus ='1' ORDER BY commentTime DESC".$limit);
			
			while ( $sel_comment = mysql_fetch_assoc($sel_usercomment) ) { 	
				
				$return_arr["total_rec"]++;
				
				$sel_users = mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_comment['userId']."'"));
				
				$html_content .= '<div class="comment_box first">
									<div class="comment_box_left">
									<a href="'.SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_users['name']).'/'.'">';
										$check_usrcmt1=str_split($sel_users['profilePicture80_80'], 4);
										if($sel_users['profilePicture80_80']!='' && $sel_users['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_users['profilePicture80_80']) && $check_usrcmt1[0]=='imag') {
				$html_content .=       		'<img src="'.SITE_URL.$sel_users['profilePicture80_80'].'" class="avatar-thumb" alt="'.$sel_users['name'].'" title="'.$sel_users['name'].'">';
										} else if($sel_users['profilePicture80_80']!='' && $sel_users['profilePicture80_80']!=NULL && $check_usrcmt1[0]=='http') {
				$html_content .=           	'<img src="'.$sel_users['profilePicture80_80'].'" class="avatar-thumb" alt="'.$sel_users['name'].'" title="'.$sel_users['name'].'">';
										} else {
				$html_content .=           	'<img src="'.NOIMG.'" class="avatar-thumb" alt="'.$sel_users['name'].'" title="'.$sel_users['name'].'">';
										}
				$html_content .=    '</a>
									</div>
									<div class="comment_box_right">
									<a href="'.SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_users['name']).'/'.'">'.unsanitize_string(ucfirst($sel_users['name'])).'</a>
									<h6>';
									$new_time = $sel_comment['commentTime'];
				$html_content .=	ago($new_time);
				$html_content .=    '</h6>
									<div class="clear"></div>	
									<p>'.$sel_comment['comment'].''. $sel_pro_user['userId'].'</p>  
									<div class="clear"></div>';
									 
								$sel_backers = "SELECT DISTINCT `userId` FROM `projectbacking` WHERE `projectId` = '".$get_project."' ";
								$sel_backersuser = mysql_query($sel_backers);
								while($backers = mysql_fetch_array($sel_backersuser)){
								if($backers['userId'] == $sel_comment['userId'] && $backers['userId'] == $_SESSION['userId']) { 
			$html_content .=	'<div><a href="'.SITE_URL.'browseproject/'.$sel_comment['commentId'].'/comment/'.$get_project.'" onclick="return confirm(\'Are you sure you want to delete this comment?\');">Delete</a></div>';
                                 } } 
					 
								$sel_creator = "SELECT DISTINCT `userId` FROM `projects` WHERE `projectId` = '".$get_project."' ";
								$sel_creatoruser = mysql_fetch_array(mysql_query($sel_creator));	
								//echo 'creatorId'.$sel_creatoruser['userId'];			 
               if($sel_creatoruser['userId'] == $_SESSION['userId'] ) { 
			$html_content .=	'<div><a href="'.SITE_URL.'browseproject/'.$sel_comment['commentId'].'/comment/'.$get_project.'" onclick="return confirm(\'Are you sure you want to delete this comment?\');">Delete</a></div>';
                                } 
			$html_content .=	'</div>
								</div>';
			}
			$return_arr["curr_page"] = ($curr_page+1);
		}
		//for review tab..
		else if ( $active_tab == "e" ) {
			//echo 'pr'.$_REQUEST["procreator_id"];exit;
			if($_REQUEST["procreator_id"] == $_SESSION["userId"]){
				//echo "SELECT * FROM `projectreview` WHERE `projectId` = '".$_GET['project']."' ORDER BY created_date DESC".$limit;
							$sel_usercomment = $con->recordselect("SELECT * FROM `projectreview` WHERE `projectId` = '".$get_project."' ORDER BY created_date DESC".$limit);
						}else {
							$sel_usercomment = $con->recordselect("SELECT * FROM `projectreview` WHERE `projectId` = '".$get_project."' AND reviewstatus=1 ORDER BY created_date DESC".$limit);
						}
			/*$sel_usercomment = $con->recordselect("SELECT * FROM `projectreview` WHERE `projectId` = '".$get_project."' AND reviewstatus=1  ORDER BY created_date DESC".$limit);*/
			
			while ( $sel_comment = mysql_fetch_assoc($sel_usercomment) ) { 	
				
				$return_arr["total_rec"]++;
				
				$sel_users = mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_comment['userId']."'"));
				
				$html_content .= '<div class="comment_box first">
									<div class="comment_box_left">
									<a href="'.SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_users['name']).'/'.'">';
										$check_usrcmt1=str_split($sel_users['profilePicture80_80'], 4);
										if($sel_users['profilePicture80_80']!='' && $sel_users['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_users['profilePicture80_80']) && $check_usrcmt1[0]=='imag') {
				$html_content .=       		'<img src="'.SITE_URL.$sel_users['profilePicture80_80'].'" class="avatar-thumb" alt="'.$sel_users['name'].'" title="'.$sel_users['name'].'">';
										} else if($sel_users['profilePicture80_80']!='' && $sel_users['profilePicture80_80']!=NULL && $check_usrcmt1[0]=='http') {
				$html_content .=           	'<img src="'.$sel_users['profilePicture80_80'].'" class="avatar-thumb" alt="'.$sel_users['name'].'" title="'.$sel_users['name'].'">';
										} else {
				$html_content .=           	'<img src="'.NOIMG.'" class="avatar-thumb" alt="'.$sel_users['name'].'" title="'.$sel_users['name'].'">';
										}
				$html_content .=    '</a>
									</div>
									<div class="comment_box_right">
									<a href="'.SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_users['name']).'/'.'">'.unsanitize_string(ucfirst($sel_users['name'])).'</a>
									<h6>';
									$new_time = $sel_comment['created_date'];
				$html_content .=	ago($new_time);
				$html_content .=    '</h6>
									<div class="clear"></div>	
									<p>'.$sel_comment['review'].'</p>'; 
									if($_REQUEST["procreator_id"] == $_SESSION["userId"]) { 
												if($sel_comment['reviewstatus']=='0') {
								$html_content .=    '<p><a href="javascript:void(0);" onClick="return changereviewStatus('.$sel_comment['reviewId'].',\'on\')" title="Click here to accept review">Accept</a></p>'; 
												 }
												else if($sel_comment['reviewstatus']=='1'){ 
									$html_content .=    '<p><a href="javascript:void(0);" onClick="return changereviewStatus('.$sel_comment['reviewId'].',\'off\')" title="Click here to reject review">Reject</a></p>'; 
												}
								} 
					$html_content .=    '<div class="clear"></div>
									</div>
								</div>';
			}
			$return_arr["curr_page"] = ($curr_page+1);
		}
		
		
		else if ( $active_tab == "comment_b" ) {
			
			$updatenumber 	= isset($_POST['updatenumber']) ? $_POST['updatenumber'] : NULL;
			$get_updates 	= isset($_POST['get_updates']) ? $_POST['get_updates'] : NULL;
			
			$sel_updateProjectComment	= $con->recordselect("SELECT * FROM `projectupdatecomment` WHERE `projectId` = '".$get_project."' AND updatecommentstatus=1 AND updatenumber ='".$updatenumber."' ORDER BY updateCommentTime DESC ".$comment_limit);
			
			while ( $sel_updateProjectComments = mysql_fetch_assoc($sel_updateProjectComment) ) {
				
				$return_arr["total_rec"]++;
				
				$sel_updateCommentUsr	= mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_updateProjectComments['userId']."'")); 
		
					$html_content .= '<div class="comment_box backgrndnone">
                                   
								   <div class="comment_box_left1">
								    <a href="'.SITE_URL.'profile/'.$sel_updateCommentUsr['userId'].'/'.Slug($sel_updateCommentUsr['name']).'/'.'">';
										 
                                        $check_usr12proimg=str_split($sel_updateCommentUsr['profilePicture80_80'], 4);
                                        if($sel_updateCommentUsr['profilePicture80_80']!='' && $sel_updateCommentUsr['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_updateCommentUsr['profilePicture80_80']) && $check_usr12proimg[0]=='imag') {
                    $html_content .=        '<img src="'.SITE_URL.$sel_updateCommentUsr['profilePicture80_80'].'" class="avatar-thumb" alt="'.$sel_updateCommentUsr['name'].'" title="'.$sel_updateCommentUsr['name'].'">';
                                        } else if($sel_updateCommentUsr['profilePicture80_80']!='' && $sel_updateCommentUsr['profilePicture80_80']!=NULL && $check_usr12proimg[0]=='http') {
                    $html_content .=        '<img src="'.$sel_updateCommentUsr['profilePicture80_80'].'" class="avatar-thumb" alt="'.$sel_updateCommentUsr['name'].'" title="'.$sel_updateCommentUsr['name'].'">';
                                        } else {
                    $html_content .=        '<img width="80" height="80" src="'.NOIMG2.'" class="avatar-thumb" alt="'.$sel_updateCommentUsr['name'].'" title="'.$sel_updateCommentUsr['name'].'">';
                                        }
                    $html_content .= '</a>
                                    </div>
									<div class="comment_box_right1">
                                    <a href="'.SITE_URL.'profile/'.$sel_updateCommentUsr['userId'].'/'.Slug($sel_updateCommentUsr['name']).'/'.'" class="float-left">';
					$html_content .= unsanitize_string(ucfirst($sel_updateCommentUsr['name']));
                    $html_content .= '</a>
                                    <h6 class="float-right"><a href="javascript:void(0);">About ';
									$update_comment_time=$sel_updateProjectComments['updateCommentTime'];  
					$html_content .= ago($update_comment_time);
					$html_content .= '</a></h6>
                                    <div class="clear"></div>
									<p>'.$sel_updateProjectComments['updateComment'].'</p>';
									
									 
								$sel_backers = "SELECT DISTINCT `userId` FROM `projectbacking` WHERE `projectId` = '".$get_project."' ";
								$sel_backersuser = mysql_query($sel_backers);
								while($backers = mysql_fetch_array($sel_backersuser)){
								if($backers['userId'] == $sel_updateProjectComments['userId'] && $backers['userId'] == $_SESSION['userId']) { 
			$html_content .=	'<div><a href="'.SITE_URL.'browseproject/'.$sel_updateProjectComments['updatecommentId'].'/updatecomment/'.$get_project.'" onclick="return confirm(\'Are you sure you want to delete this comment?\');">Delete</a></div>';
                                 } } 
					 
								$sel_creator = "SELECT DISTINCT `userId` FROM `projects` WHERE `projectId` = '".$get_project."' ";
								$sel_creatoruser = mysql_fetch_array(mysql_query($sel_creator));	
								//echo 'creatorId'.$sel_creatoruser['userId'];			 
               if($sel_creatoruser['userId'] == $_SESSION['userId'] ) { 
			$html_content .=	'<div><a href="'.SITE_URL.'browseproject/'.$sel_updateProjectComments['updatecommentId'].'/updatecomment/'.$get_project.'" onclick="return confirm(\'Are you sure you want to delete this comment?\');">Delete</a></div>';
                                } 
			$html_content .=	' <div class="clear"></div>
                                </div></div>';
			} 
			$return_arr["curr_page"] = ($curr_page_comment+1);
		}
	
		$return_arr["html_content"] = $html_content;
		
	} catch(Exception $e) {
		//echo $e;
		$return_arr["status"] = 100;
		$return_arr["msg"] = $e;
	}
	echo json_encode_html($return_arr);
	exit;
}
?>