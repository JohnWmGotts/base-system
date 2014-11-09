<script type="text/javascript">
$(document).ready(function() {
	var callInboxUnread=true;
	if ( $.browser.msie ) {
		$("#searchInputBox").val("Search Projects");
	}
	var Input = $("#searchInputBox");
	var default_value = Input.val();
	Input.focus(function() {
			if(Input.val() == default_value) Input.val("");
		}).blur(function(){
			if(Input.val().length == 0) Input.val(default_value);
		});
		
	$("#searchInputBox").focus(function(){
		$("#searchInputBox").val("");
	});
	
	$("#search").click(function(){
		var findstr = '%20';
		var re = new RegExp(findstr, 'g');
		//str = str.replace(re, '');
		var searchText = encodeURIComponent($("#searchInputBox").val());
		//place = searchText.replace("%20", "+");
		place = searchText.replace(re, "+");
		//alert(place);
		$("#searchBox").attr('action',application_path+'search/'+(place));
		$("#searchBox").submit();
		/*$("#searchBox").attr('action',application_path+'search/'+encodeURIComponent($("#searchInputBox").val()));
		$("#searchBox").submit();*/
	});
	$("#searchBox").submit(function(){
		/*$("#searchBox").attr('action',application_path+'search/'+encodeURIComponent($("#searchInputBox").val()));
		return true;*/
		var findstr = '%20';
		var re = new RegExp(findstr, 'g');
		//str = str.replace(re, '');
		var searchText = encodeURIComponent($("#searchInputBox").val());
		//place = searchText.replace("%20", "+");
		place = searchText.replace(re, "+");
		//alert(place);
		$("#searchBox").attr('action',application_path+'search/'+(place));
		return true;
	});
	
	$("fieldset#toggle_menu").hide();
	
	$(".toggle_link").click(function(e) {          
		e.preventDefault();
		$("fieldset#toggle_menu").toggle();
		$(".inbox_toggle").toggleClass("menu-open");
	});
	
	$("fieldset#toggle_menu").mouseup(function() {
		return false
	});
	$(document).mouseup(function(e) {
		if($(e.target).parent("a.toggle_link").length==0) {
			$(".inbox_toggle").removeClass("menu-open");
			$("fieldset#toggle_menu").hide();
		}
	});	

	$("fieldset#toggle_menu1").hide();
	$(".toggle_link1").click(function(e) {          
		e.preventDefault();
		$("fieldset#toggle_menu1").toggle();
		$(".activity_toggle").toggleClass("menu-open");
	});
	
	$("fieldset#toggle_menu1").mouseup(function() {
		return false
	});
	$(document).mouseup(function(e) {
		if($(e.target).parent("a.toggle_link1").length==0) {
			$(".activity_toggle").removeClass("menu-open");
			$("fieldset#toggle_menu1").hide();
		}
	});	
	
	$("fieldset#toggle_menu2").hide();
	$(".toggle_link2").click(function(e) {          
		e.preventDefault();
		$("fieldset#toggle_menu2").toggle();
		$(".activity_toggle2").toggleClass("menu-open2");
	});
	
	$("fieldset#toggle_menu2").mouseup(function() {
		return false
	});
	$(document).mouseup(function(e) {
		if($(e.target).parent("a.toggle_link2").length==0) {
			$(".activity_toggle2").removeClass("menu-open2");
			$("fieldset#toggle_menu2").hide();
		}
	});	
	
	$("#newsletter").validate({
		rules: {
			newsletteremail: { required: true,email:true }
		},
		messages: {
			newsletteremail: {
				required: '<br>Please enter email',
				email: "<br>Please enter a valid email address"
			}
		}
	});
	
	$("#clearCountInbox").hover(function(){
		if(callInboxUnread==true){
			clearunread();
		}
		callInboxUnread=false;
	});
	
});		
function openmessage1(id1,projectId1) {
	window.location="<?php echo SITE_URL; ?>message/"+ id1 +"/"+ projectId1+"/";	
}
function openactivity1(project1,update1) {
	window.location="<?php echo SITE_URL; ?>browseproject/"+ project1 +"&update="+ update1 +"#b";		
}
function clearunread() {
	if ($('#count_inboxunread').length) { // jwg -- only if present
		document.getElementById('count_inboxunread').style.visibility = 'hidden'; 
		$.ajax({
			url:'<?php echo SITE_MOD."user/"; ?>inboxunread.php'
		});
	}
}	
</script>
<body>

<header>
  <div class="wrapper">
    <div class="logo">
      <h1><a href="<?php echo $base_url;?>index.php">
      	<img src="<?php echo $base_url;?>images/site/logos-transparent.png" alt="<?php echo DISPLAYSITENAME; ?>"  title="<?php echo DISPLAYSITENAME; ?>"/>
      </a></h1>
    </div>
    <nav>
      <ul>
        <li class="onelink"> <a href="<?php echo $base_url;?>staffpicks/"><span>Discover</span><br/>
        	<span class="black">Great Projects</span></a> </li>
        <li class="onelink"> <a href="<?php echo $base_url;?>createproject/"><span>Start</span><br/>
        	<span class="black">Your Projects</span></a> </li>
        <li class="searchdiv">
            <div class="search">
                <form id="searchBox" name="searchBox" action="<?php echo $base_url;?>search/" method="post">
                    <div class="textbox">
                    <input name="term" id="searchInputBox" type="text" placeholder="Search Projects"  size="10" <?php if(isset($_REQUEST['term'])){?> value="<?php echo htmlentities(stripslashes($_REQUEST['term']));?>" <?php } ?> />
                    </div>
                </form>
                <div class="flclear"></div>
            </div>
        </li>
        <li class="last">
            <ul>
                <!--<li><a href="<?php echo SITE_URL; ?>help/" title="Help"><span class='footerblack'>Help</span></a></li>-->
             <li><a href="<?php echo SITE_URL; ?>help/" title="Help"><span class=''>Help</span></a></li>   
		<?php if($_SESSION["userId"]!="" and $_SESSION["name"]!="") { ?>
			<?php $sel_count_unrearinbox=mysql_fetch_assoc($con->recordselect("SELECT count(*) as inboxunread FROM usermessages WHERE receiverId='".$_SESSION['userId']."' and  status=0"));?>
                <li class="backhover"> 
                	<a href="#" id="clearCountInbox">
                    	<div class="inbox"></div>
                        <?php if($sel_count_unrearinbox['inboxunread']>0) {?>
                            <div class="notification" id="count_inboxunread">
                                <?php echo $sel_count_unrearinbox['inboxunread']; ?>
                            </div>
                        <?php } ?>
                    </a>
                    <div class="menu-dropdown width250">
                        <h3>Inbox</h3>
                        <div class="space10"></div>
						<?php 			
                        $sel_message_all_23=$con->recordselect("SELECT DISTINCT `projectId` FROM usermessages WHERE receiverId='".$_SESSION['userId']."' ORDER BY messageTime DESC LIMIT 0 , 3 ");							
                        $limit_count = 0; // jwg
						while ($sel_message_2 = mysql_fetch_assoc($sel_message_all_23)){
                            if($limit_count <= 3){												
                                $sel_message_all23=$con->recordselect("SELECT * FROM usermessages WHERE projectId='".$sel_message_2['projectId']."' AND receiverId='".$_SESSION['userId']."' GROUP BY senderId ORDER BY messageTime DESC");								
                                while ($sel_message23 = mysql_fetch_assoc($sel_message_all23)){
                                $sel_user_data231=$con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_message23['senderId']."'");
                                $sel_user_data23=mysql_fetch_assoc($sel_user_data231);
                                $check_usrimg23=str_split($sel_user_data23['profilePicture40_40'], 4);
                                if($sel_user_data23['profilePicture40_40']!=NULL || $sel_user_data23['profilePicture40_40']!= ''){
                                     if(file_exists(DIR_FS.$sel_user_data23['profilePicture40_40']) && mysql_num_rows($sel_user_data231)>0 && $check_usrimg23[0]=='imag'){
                                         $imagPath = SITE_URL.$sel_user_data23['profilePicture40_40'];
                                     }else if($check_usrimg23[0]=='http'){
                                         $imagPath = $sel_user_data23['profilePicture40_40'];
                                     }else{
                                         $imagPath = NOIMG;
                                     }
                                }else{
                                    $imagPath = NOIMG;
                                }
                        ?>
                         <div onClick="return openmessage1(<?php echo $sel_message23['senderId']; ?>,<?php echo $sel_message23['projectId']; ?>);">   
                            <div class="box-main">
                                <div class="box-left">
                                    <div class="box-left-img">
                                        <a href="<?php echo SITE_URL.'message/'.$sel_message23['senderId'].'/'.$sel_message23['projectId'].'/'; ?>">
                                            <img src="<?php echo $imagPath; ?>" title="<?php echo $sel_user_data23['name']; ?>" alt="<?php echo $sel_user_data23['name']; ?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="box-right">
                                    <h4><a href="<?php echo SITE_URL.'message/'.$sel_message23['senderId'].'/'.$sel_message23['projectId']; ?>"><?php echo $sel_user_data23['name']; ?></a></h4>
                                    <p>
                                    <a class="target" href="<?php echo SITE_URL.'message/'.$sel_message23['senderId'].'/'.$sel_message23['projectId'].'/'; ?>">
                                        <?php
                                        $unsanamsg = unsanitize_string(ucfirst($sel_message23['message'])); 
                                        $msg_len=strlen($unsanamsg);  
                                        if($msg_len>50) 
                                        {echo substr($unsanamsg, 0, 50).'...'; } 
                                        else { echo substr($unsanamsg, 0, 50); }  
                                        ?>
                                    </a>
                                    </p>
                                </div>
                            </div>
                            <div class="flclear"></div>
                        </div>
                  <?php
							}											
						} $limit_count=$limit_count+1;
					}
					?>
                        <div class="menu-dropdown-link"><a href="<?php echo SITE_URL."inbox/"; ?>">View All Messages</a></div>
                    </div>
                </li>
                                
                <li class="backhover">
                	<a href="#"><div class="activity"></div></a>
                	<div class="menu-dropdown width250 activity_notification">
                     	<h3>Recent Activity</h3>
                        <div class="clear"></div>
                      	<?php $news_array1 = array ();
		$sel_1=$con->recordselect("SELECT *,backingTime as sorting FROM `projectbacking` WHERE `userId` ='".$_SESSION['userId']."' group by projectId order by backingTime desc");													
		$total_count = mysql_num_rows($sel_1) ;
				
		$sel_2=$con->recordselect("SELECT *,commentTime as sorting FROM `projectcomments` WHERE `userId` ='".$_SESSION['userId']."' order by commentTime desc");													
		$total_count += mysql_num_rows($sel_2) ;
				
		$sel_3=$con->recordselect("SELECT *,updateTime as sorting FROM `projectupdate` WHERE `userId` ='".$_SESSION['userId']."' order by updateTime desc");	
		$total_count += mysql_num_rows($sel_3) ;
		
		$sel_4=$con->recordselect("SELECT *,updateCommentTime as sorting FROM `projectupdatecomment` WHERE `userId` ='".$_SESSION['userId']."' order by updateCommentTime desc");	
		$total_count += mysql_num_rows($sel_4) ;
		
		$sel_5=$con->recordselect("SELECT *,pbs.projectStart as sorting FROM projects as p, projectbasics as pbs WHERE p.userId ='".$_SESSION['userId']."' and p.projectId=pbs.projectId and p.published=1 and p.accepted=1 order by pbs.projectStart desc");	
		$total_count += mysql_num_rows($sel_5) ;
	
		while($row=mysql_fetch_array($sel_1)){
			array_push($news_array1, $row);
		}
		while($row2=mysql_fetch_array($sel_2)){
			array_push($news_array1, $row2);
		}
		while($row3=mysql_fetch_array($sel_3)){
			array_push($news_array1, $row3);
		}
		while($row4=mysql_fetch_array($sel_4)){
			array_push($news_array1, $row4);
		}
		while($row5=mysql_fetch_array($sel_5)){
			array_push($news_array1, $row5);
		}
						
		array_sort_by_column1($news_array1,"sorting");
		
		if(!empty($news_array1)){	
			$tempNewsArray = array();
			for($tempI = count($news_array1); $tempI>0; $tempI--){								
				$tempNewsArray[] = $news_array1[$tempI-1]; // jwg fixup -1
			}
			$news_array1 = $tempNewsArray;
			$val1=(1*3)-9;
			$val2=1*3;
			for ($i = $val1 ; $i <=$val2; $i++){
				if(isset($news_array1[$i]['backingTime'])){
					$sel_1_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb1, projects as p1, users as usr1, productimages as pi1, categories as cat1 
								WHERE pb1.projectId='".$news_array1[$i]['projectId']."' AND p1.projectId='".$news_array1[$i]['projectId']."'
								AND usr1.userId='".$news_array1[$i]['userId']."' AND pb1.projectCategory = cat1.categoryId "));
					$sel_pro_creater=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects as p2, users as usr2 WHERE p2.projectId='".$news_array1[$i]['projectId']."' AND p2.userId = usr2.userId"));
					$sel_backers_activity=mysql_fetch_assoc($con->recordselect("SELECT count( distinct( `userId` )) AS backer_total2 FROM projectbacking WHERE projectId='".$news_array1[$i]['projectId']."' "));
					$sel_pro_imgs1=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array1[$i]['projectId']."'"));
			?>
                        <div class="tab_content_left">
                            	<?php if($sel_pro_imgs1['image65by50']!='' && file_exists(DIR_FS.$sel_pro_imgs1['image65by50'])) { ?>
                                	<img src="<?php echo SITE_URL.$sel_pro_imgs1['image65by50']; ?>" alt="<?php echo ucfirst($sel_1_data['projectTitle']); ?>" title="<?php echo ucfirst($sel_1_data['projectTitle']); ?>" />
                                <?php } else { ?>
                                	<img src="<?php echo NOIMG; ?>" alt="<?php echo ucfirst($sel_1_data['projectTitle']); ?>" title="<?php echo ucfirst($sel_1_data['projectTitle']); ?>" />
                                <?php } ?>
                                
                                <div class="right_comment">
                                    
                                    <a title="<?php print $sel_1_data['projectTitle']; ?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $news_array1[$i]['projectId'].'/'.Slug($sel_1_data['projectTitle']).'/'; ?>">
                                        <?php $unsanaprotit = unsanitize_string(ucfirst($sel_1_data['projectTitle'])); $protit_len=strlen($unsanaprotit);   if($sel_1_data['projectTitle']!='') { if($protit_len>25) {echo substr($unsanaprotit, 0, 25).'...'; } else { echo substr($unsanaprotit, 0, 25); } } else { echo "Untitled"; } ?>
                                    </a>
                                    <div class="clear"></div>
                                    <span class="Launched_project">Backed A Project</span>
                                    <div class="clear"></div>
                                </div>
                            	<div class="clear"></div>
                        	</div>
				<?php }else if(isset($news_array1[$i]['accepted'])){ 
					$sel_5_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb1, projects as p1, users as usr1, categories as cat1 
								WHERE pb1.projectId='".$news_array1[$i]['projectId']."' AND p1.projectId='".$news_array1[$i]['projectId']."'
								AND usr1.userId='".$news_array1[$i]['userId']."' AND pb1.projectCategory = cat1.categoryId "));
					$sel_pro_creater5=mysql_fetch_assoc($con->recordselect("SELECT * FROM projects as p2, users as usr2 WHERE p2.projectId='".$news_array1[$i]['projectId']."' AND p2.userId = usr2.userId"));
					$sel_backers_activity=mysql_fetch_assoc($con->recordselect("SELECT count( distinct( `userId` )) AS backer_total2 FROM projectbacking WHERE projectId='".$news_array1[$i]['projectId']."' "));
					$sel_pro_imgs=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array1[$i]['projectId']."'"));
				?>    	   
                	<div class="tab_content_left" >
                            	<?php if($sel_pro_imgs['image65by50']!='' && file_exists(DIR_FS.$sel_pro_imgs['image65by50'])) { ?>
                                	<img src="<?php echo SITE_URL.$sel_pro_imgs['image65by50']; ?>"  alt="<?php echo ucfirst($sel_5_data['projectTitle']); ?>" title="<?php echo ucfirst($sel_5_data['projectTitle']); ?>" />
                                <?php } else { ?>
                                	<img src="<?php echo NOIMG; ?>"  alt="<?php echo ucfirst($sel_5_data['projectTitle']); ?>" title="<?php echo ucfirst($sel_5_data['projectTitle']); ?>" />
                                <?php } ?>
                                <div class="right_comment">
                                    <a title="<?php print $sel_5_data['projectTitle']; ?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_5_data['projectId'].'/'.Slug($sel_5_data['projectTitle']).'/'; ?>">
										<?php $unsanaprotit = unsanitize_string(ucfirst($sel_5_data['projectTitle']));
										$protit_len=strlen($unsanaprotit);
										if($sel_5_data['projectTitle']!='') { 
											if($protit_len>25) {echo substr($unsanaprotit, 0, 25).'...'; } 
											else { echo substr($unsanaprotit, 0, 25); } } else { echo "Untitled"; } 
										?>
                                    </a><div class="clear"></div>
									<span class="Launched_project">Launched A Project</span>
                                    <div class="clear"></div>   
                            </div>
                            <div class="clear"></div>
                        </div>
				<?php }else if(isset($news_array1[$i]['commentTime'])){ 
                    $sel_3_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb3, projects as p3, users as usr3, categories as cat3 
                            WHERE pb3.projectId='".$news_array1[$i]['projectId']."' AND p3.projectId='".$news_array1[$i]['projectId']."'
                            AND usr3.userId='".$news_array1[$i]['userId']."' AND cat3.categoryId=pb3.projectCategory"));
                    $sel_3_dataimg=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array1[$i]['projectId']."' limit 1 "));
                ?>    
					<div class="tab_content_left" >
							<a href="<?php echo SITE_URL.'browseproject/'.$news_array1[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'; ?>">
								<?php if($sel_3_dataimg['image65by50']!='' && file_exists(DIR_FS.$sel_3_dataimg['image65by50'])) { ?>
									<img src="<?php echo SITE_URL.$sel_3_dataimg['image65by50']; ?>" title="<?php echo $sel_3_data['projectTitle']; ?>" alt="<?php echo $sel_3_data['projectTitle']; ?>">
								<?php } else { ?>
									<img src="<?php echo NOIMG; ?>" title="<?php echo $sel_3_data['projectTitle']; ?>" alt="<?php echo $sel_3_data['projectTitle']; ?>">
								<?php } ?>
							</a>
							<div class="right_comment">
								<a title="<?php print $sel_3_data['projectTitle']; ?>" href="<?php echo SITE_URL.'browseproject/'.$news_array1[$i]['projectId'].'/'.Slug($sel_3_data['projectTitle']).'/'; ?>">
									<?php $unsanaprotit = unsanitize_string(ucfirst($sel_3_data['projectTitle']));
									$protit_len=strlen($unsanaprotit);
									if($sel_3_data['projectTitle']!='') { 
										if($protit_len>20) {echo substr($unsanaprotit, 0, 20).'...'; } 
										else { echo substr($unsanaprotit, 0, 20); } 
									} else { echo "Untitled"; } ?>
								</a><div class="clear"></div>
								<span class="Launched_project">Commented On A Project</span>
								
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
				<?php }else if(isset($news_array1[$i]['updateTime'])){ 
                         $sel_2_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb2, projects as p2, users as usr2, categories as cat2 
                                 WHERE pb2.projectId='".$news_array1[$i]['projectId']."' AND p2.projectId='".$news_array1[$i]['projectId']."'
                                 AND usr2.userId='".$news_array1[$i]['userId']."' AND cat2.categoryId=pb2.projectCategory"));
                        $sel_2_dataimg=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array1[$i]['projectId']."' limit 1 "));
				?>
					<div class="tab_content_left" >
							<a href="<?php echo SITE_URL.'browseproject/'.$news_array1[$i]['projectId'].'/'.Slug($sel_2_data['projectTitle']).'/'; ?>">
								<?php if($sel_2_dataimg['image65by50']!='' && file_exists(DIR_FS.$sel_2_dataimg['image65by50'])) { ?>
								<img src="<?php echo SITE_URL.$sel_2_dataimg['image65by50']; ?>" title="<?php echo ucfirst($sel_2_data['projectTitle']); ?>" alt="<?php echo ucfirst($sel_2_data['projectTitle']); ?>">
								<?php } else { ?>
								<img src="<?php echo NOIMG; ?>" title="<?php echo ucfirst($sel_2_data['projectTitle']); ?>" alt="<?php echo ucfirst($sel_2_data['projectTitle']); ?>">
								<?php } ?>
							</a>
							<div class="right_comment">
								<a title="<?php print $sel_2_data['projectTitle'];?>" href="<?php echo SITE_URL.'browseproject/'.$news_array1[$i]['projectId'].'/'.Slug($sel_2_data['projectTitle']).'/'; ?>">
									  <?php $unsanaprotit = unsanitize_string(ucfirst($sel_2_data['projectTitle']));
									  $protit_len=strlen($unsanaprotit);
									  if($sel_2_data['projectTitle']!='') { 
										if($protit_len>20) {echo substr($unsanaprotit, 0, 20).'...'; } 
										else { echo substr($unsanaprotit, 0, 20); } } 
									  else { echo "Untitled"; } ?>
								</a>
                                <div class="clear"></div>
								<span class="Launched_project">Posted Project Update #<?php echo $news_array1[$i]['updatenumber']; ?></span>
								
								
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
				<?php }else if(isset($news_array1[$i]['updateCommentTime'])){  
                        $sel_4_data=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics as pb4, projects as p4, users as usr4, categories as cat4 
                                  WHERE pb4.projectId='".$news_array1[$i]['projectId']."' AND p4.projectId='".$news_array1[$i]['projectId']."'
                                  AND usr4.userId='".$news_array1[$i]['userId']."' AND cat4.categoryId=pb4.projectCategory"));
                        $sel_4_dataimg=mysql_fetch_assoc($con->recordselect("SELECT * FROM productimages WHERE projectId='".$news_array1[$i]['projectId']."' limit 1 "));
                ?>
					<div class="tab_content_left" >
							<a href="<?php echo SITE_URL.'browseproject/'.$news_array1[$i]['projectId'].'/'.Slug($sel_4_data['projectTitle']).'/'; ?>">
								<?php if($sel_4_dataimg['image65by50']!='' && file_exists(DIR_FS.$sel_4_dataimg['image65by50'])) { ?>
								<img  src="<?php echo SITE_URL.$sel_4_dataimg['image65by50']; ?>" title="<?php echo ucfirst($sel_4_data['projectTitle']); ?>" alt="<?php echo ucfirst($sel_4_data['projectTitle']); ?>">
								<?php } else { ?>
								<img  src="<?php echo NOIMG; ?>" title="<?php echo ucfirst($sel_4_data['projectTitle']); ?>" alt="<?php echo ucfirst($sel_4_data['projectTitle']); ?>">
								<?php } ?>
							</a>
							<div class="right_comment">
								<a title="<?php print $sel_4_data['projectTitle']; ?>" href="<?php echo SITE_URL.'/browseproject/'.$news_array1[$i]['projectId'].'/'.Slug($sel_4_data['projectTitle']).'/'; ?>">
									<?php $unsanaprotit = unsanitize_string(ucfirst($sel_4_data['projectTitle'])); 
									$protit_len=strlen($unsanaprotit);   
									if($sel_4_data['projectTitle']!='') { 
										if($protit_len>20){echo substr($unsanaprotit, 0, 20).'...'; } 
										else { echo substr($unsanaprotit, 0, 20); } 
									}else { echo "Untitled"; } ?>
								</a><div class="clear"></div>
								<span class="Launched_project">Commented On A Project Update</span>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
				<?php } 
                	} 
                }
                ?>	
                    	<div class="menu-dropdown-link"><a href="<?php echo SITE_URL."activity/"; ?>">View All Activities</a></div>
                    </div>
                </li>
                      
                <li class="backhover">
                	<a href="#"><?php if(!empty($_SESSION['name'])){ echo $_SESSION['name']; }else{echo "ME";} ?></a>
                    <div class="menu-dropdown width250">
                        <ul>
                            <h3>My Account</h3>
                            <li><a title="My Profile" href="<?php echo $base_url;?>profile/edit/">My Profile</a></li>
                            
                            
                            <?php $qrySelCreator = $con->recordselect('SELECT * from projects WHERE userId="'.$_SESSION["userId"].'"');
							$qrySelBacker = $con->recordselect('SELECT * from projectbacking WHERE userId="'.$_SESSION["userId"].'"');						
							if(mysql_num_rows($qrySelCreator) > 0 || mysql_num_rows($qrySelBacker) > 0 ) {
							?>
                           <li><a title="Invite Friends" href="<?php echo $base_url;?>invitefriends/">Invite Friends</a></li>
                            
                            <?php } ?>
                             <li><a title="My Financials" href="<?php echo $base_url;?>advancefinance/">My Financials</a></li>
                            <li><a title="My Backer History" href="<?php echo $base_url;?>backerhistory/">My Backer History</a></li>
                             <li><a title="My Reward History" href="<?php echo $base_url;?>rewardhistory/">My Reward History</a></li>
                            <li><a title="Edit Settings" href="<?php echo SITE_URL; ?>profile/edit/">Edit Settings</a></li>
                            <li><div class="menu-dropdown-link "><a href="<?php echo $base_url;?>logout/">Log Out</a></div></li>
                        </ul>
                        <?php
						$sel_created_project=$con->recordselect("SELECT * FROM projects AS pro, projectbasics AS pb
							WHERE pro.userId ='".$_SESSION['userId']."' AND pro.projectId = pb.projectId
							ORDER BY `pro`.`projectId` DESC LIMIT 5");
						if(mysql_num_rows($sel_created_project)>0) { ?>
                        <ul class="my_created">
                            <h3>My Created Projects</h3>
                            <?php while($selCreatedProject=mysql_fetch_assoc($sel_created_project)){ ?>
                            <li>
                            	<a href="<?php if($selCreatedProject['published']==1 && $selCreatedProject['accepted']==1) {
									echo $base_url.'browseproject/'.$selCreatedProject['projectId'].'/'.Slug($selCreatedProject['projectTitle']).'/'; 
								}else{
									echo $base_url.'createproject/'.$selCreatedProject['projectId']; 
								} ?>" title="<?php if($selCreatedProject['projectTitle']!='') 
									{ echo $selCreatedProject['projectTitle']; }else{ echo 'Untitled'; } ?>" >
                                	<?php 
									if($selCreatedProject['projectTitle']!=''){ echo stringShorter($selCreatedProject['projectTitle'],18); }
									else { echo 'Untitled'; }
                                	?>
                                </a>
                            </li>
                            <?php } ?>
                            <li class="last"> <div class="menu-dropdown-link"><a href="<?php echo $base_url;?>profile/#b">See All</a></div></li>
                        </ul>
                         <?php } ?>
                    </div>
                </li>
		<?php } else { ?>
                <li><a href="<?php echo str_replace('http:','https:',$base_url);?>login/" title="Log in">Log in</a></li>
            	<li><a href="<?php echo str_replace('http:','https:',$base_url);?>signup/" title="Sign Up">Sign up</a></li>
		<?php }?>
            </ul>
        </li>
      </ul>
    </nav>
    <div class="flclear"></div>
  </div>
</header>
<?php if(isset($_SESSION['msgType']) && $_SESSION['msgType']!='') {?>
	<div id="msgPart"> <?php echo disMessage($_SESSION['msgType']); ?> </div>
<?php } ?>
<div id="search_results-wrap" style="display: none;">
    <div id="closeSearch" style="">x</div>
    <div class="clear"></div>
    <div class="suggestion_loading"></div>
    <div class="cs_cont">
    <ul id="SearchCarousel" class="jcarousel-skin-tango">
    </ul>
    </div>

</div>