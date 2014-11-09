<?php
session_start();
require "../includes/config.php";
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="en" />
<meta name="generator" content="NCrypted Technologies http://www.ncrypted.net" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
<link href="<?php echo $base_url; ?>css/style.css" rel="stylesheet" type="text/css" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script src="<?php echo SITE_JAVA; ?>jquery.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="<?php echo SITE_JAVA; ?>jquery-1.7.1.min.js"></script>
	<script type="text/JavaScript" src="<?php echo SITE_JAVA; ?>jquery.validate.min.js"></script>
	<script type="text/JavaScript" src="<?php echo $base_url; ?>js/curvycorners.js"></script>
	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>ui-lightness/jquery.ui.all.css">
	<script src="<?php echo SITE_JAVA; ?>ui/jquery.ui.core.js"></script>
	<script src="<?php echo SITE_JAVA; ?>ui/jquery.ui.widget.js"></script>
	<script src="<?php echo SITE_JAVA; ?>ui/jquery.ui.position.js"></script>
    <script src="<?php echo SITE_JAVA; ?>custom.js"></script>
    <script type="text/javascript" src="<?php echo SITE_JAVA; ?>jquery.jcarousel.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS; ?>tango/skin.css" />
<script type="text/JavaScript">
	addEvent(window, 'load', initCorners);
	  function initCorners() {
	    var settings = {
	      tl: { radius: 10 },
	      tr: { radius: 10 },
	      bl: { radius: 0 },
	      br: { radius: 0 },
	      antiAlias: true
	    }
	    curvyCorners(settings, ".top-menu");
	}		
        $(document).ready(function() {
			$("fieldset#toggle_menu").hide();
            $(".toggle_link").click(function(e) {          
				e.preventDefault();
                $("fieldset#toggle_menu").toggle();
				$(".inbox_toggle").toggleClass("menu-open");
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
			
			
        });		
	function openmessage1(id1,projectId1)
	{
		window.location="<?php echo SITE_MOD; ?>user/message.php?id="+ id1 +"&projectId="+ projectId1;		
	}
	function openactivity1(project1,update1)
	{
		window.location="<?php echo SITE_MOD; ?>browse/browseproject.php?project="+ project1 +"&update="+ update1 +"#tabs-2";		
	}
</script>

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>
<body>
<div class="wrapper-lsized">
<div class="header-lsized">
  <div class="header">
    <div class="header-left-panel float-left">
      <div class="logo"><a href="<?php echo $base_url;?>"><img src="<?php echo $base_url;?>images/logoc.png"  alt="logo" border="0" title="NCrypted Crowdfunding Clone" /></a></div>
      <!--.logo--> 
    </div>
    <!--.header-left-panel .float-left-->
    
    <div class="header-right-panel float-right">
      <div class="header-right-panel-top">
        <div class="left-column float-left">
          <ul>
            <li><a href="<?php echo $base_url;?>modules/browse/staffpicks.php" title="Discover Great Project">Discover<br />
              Great Project</a></li>
            <li><a href="<?php echo $base_url;?>modules/createProject/" title="Start Your Project">Start<br />
              Your Project</a></li>
          </ul>
        </div>
        <!--.left-column .float-left-->
        <div class="right-column float-right">
        <form id="searchBox" name="searchBox" action="<?php echo $base_url;?>modules/search/index.php" method="get">
          <div class="float-left"><input name="term" id="searchInputBox" type="text" class="search-box" size="10" /></div>
          <div class="float-right"><input type="submit" value="" name="searchBox" class="search-button" /></div>
          </form>
        </div>
        <!--.right-column .float-right--> 
      </div>
      <!--.header-right-panel-top-->
      <div class="clear"></div>
      <div class="header-right-panel-bottom">
        <div class="top-menu">
          <ul>
            <?php if($_SESSION["userId"]=="" and $_SESSION["name"]=="") { ?>
            <li><a href="<?php echo $base_url;?>modules/user/loginsignup.php" title="Log in">Log in</a></li>
            <li><a href="<?php echo $base_url;?>modules/user/loginsignup.php?signup" title="Sign Up">Sign up</a></li>
            <?php } else { ?>
            <!--<li><a href="<?php //echo $base_url;?>modules/user/logout.php">Logout</a></li>
            <li><a href="<?php //echo $base_url;?>modules/user/profile.php">My Profile</a></li>-->
            <!--start activity-->
             <li class="activity_toggle2"> <!--onclick="return changeClass();"--> 
              <a href="javascript:void(0)" class="toggle_link2" title="Me"><span>Me</span></a>
             </li>
            <li class="userinbox" id="userinbox">
              <fieldset id="toggle_menu2" class="toggle_menu toggle_menu_me" style="width:370px !important;">
                <div style="max-width:340px;">
                    <div class="menu-me-page">
                        <ol>
                            <li class="first_me"><b>My Account</b></li>
                            <li>
                            	<hr>
                            </li>
                            <li class="second">
                            	<a href="<?php echo $base_url;?>modules/user/profile.php" >My Profile</a>
                            </li>
                            <li class="second">
                            	<a href="<?php echo $base_url;?>modules/user/backerhistory.php" >My Backer History</a>
                            </li>
                            <li class="second">
                            <a href="<?php echo SITE_MOD_USER; ?>editprofile.php" >Edit Settings</a>
                            	</li>
                            <li class="second me_logout_link">
                            	<a href="<?php echo $base_url;?>modules/user/logout.php">Logout</a></li>
                        </ol>
                    </div>
                    <?php
						$sel_created_project=$con->recordselect("SELECT *
															FROM projects AS pro, projectbasics AS pb
															WHERE pro.userId ='".$_SESSION['userId']."'
															AND pro.projectId = pb.projectId
															ORDER BY `pro`.`projectId` DESC
															LIMIT 5");
						if(mysql_num_rows($sel_created_project)>0)
                    	{
                    ?>
                    <div class="menu-me-created">
                        <ol>
                            <li class="first_me">My Created Projects</li>
                            <li>
                            	<hr>
                            </li>
                            <?php
								while($selCreatedProject=mysql_fetch_assoc($sel_created_project))
								{
                            ?>
                            <li class="second">
                                <a href="<?php if($selCreatedProject['published']==1 && $selCreatedProject['accepted']==1)
												{
													echo $base_url.'modules/browse/browseproject.php?project='.$selCreatedProject['projectId']; 
												}
												else
												{
													echo $base_url.'modules/createProject/index.php?id='.$selCreatedProject['projectId']; 
												} ?>" >
                                               
									<?php 
                                        if($selCreatedProject['projectTitle']!='') 
                                        { echo $selCreatedProject['projectTitle']; }
                                        else
                                        { echo 'Untitled'; }
                                    ?>
                                </a>
                            </li>
                            <?php } ?>
                             <li class="last">
                            	<a class="button-viewallmsg" href="<?php echo $base_url;?>modules/user/profile.php?#tabs-4">See All</a></li>
                        </ol>
                    </div>
                    <?php } ?>
                </div>
              </fieldset>
            </li>            
            <!--end activity-->
            
            <!--start activity-->
             <li class="activity_toggle"> <!--onclick="return changeClass();"--> 
              <a href="javascript:void(0)" class="toggle_link1" title="Activity"><span>Activity</span></a></li>
            <li class="userinbox" id="userinbox">
              <fieldset id="toggle_menu1" class="toggle_menu">
                <ol>
                  <li class="first">Recent Activity</li>
                  <li>
                    <hr>
                  </li>
                  <?php
					$sel_starredproj=$con->recordselect("SELECT *
															FROM projectremind AS prorem, projectupdate AS pu
															WHERE prorem.userId ='".$_SESSION['userId']."'
															AND prorem.status =1
															AND pu.projectId = prorem.projectId
															ORDER BY pu.updateTime DESC
															LIMIT 0 , 5");
					
							
					while ($sel_starred1 = mysql_fetch_assoc($sel_starredproj))
					{
						$sel_pro_data1=mysql_fetch_assoc($con->recordselect("SELECT *
						FROM `projects` AS pro, projectbasics AS pb, users AS usr, productimages AS proImg, categories AS cat 
						WHERE pro.projectId ='".$sel_starred1['projectId']."'
						AND pb.projectId ='".$sel_starred1['projectId']."'
						AND usr.userId ='".$sel_starred1['userId']."'
						AND proImg.projectId ='".$sel_starred1['projectId']."'
						AND pb.projectCategory = cat.categoryId"));				
						/*$sel_project_update1=$con->recordselect("SELECT * FROM `projectupdate` WHERE projectId='".$sel_starred1['projectId']."' ORDER BY updateTime DESC");*/
						
						/*while ($sel_project_update_data1 = mysql_fetch_assoc($sel_project_update1))
						{*/
						
						
						
				?>
                  <li class="second" onClick="return openactivity1(<?php echo $sel_starred1['projectId']; ?>,<?php echo $sel_starred1['updatenumber']; ?>);">
                    <div class="userimage"><a href="<?php echo SITE_MOD.'browse/browseproject.php?project='.$sel_starred1['projectId'].'&update='.$sel_starred1['updatenumber'].'#tabs-2'; ?>"><img width="40" height="40" src="<?php echo SITE_URL.$sel_pro_data1['image100by80']; ?>"></a></div>
                    <div  class="secondleft"> <span class="username"><a href="<?php echo SITE_MOD.'browse/browseproject.php?project='.$sel_starred1['projectId'].'&update='.$sel_starred1['updatenumber'].'#tabs-2'; ?>"><?php echo $sel_pro_data1['projectTitle']; ?></a></span> <span class="usermessage"><a class="target" href="<?php echo SITE_MOD.'browse/browseproject.php?project='.$sel_starred1['projectId'].'&update='.$sel_starred1['updatenumber'].'#tabs-2'; ?>"> Update #<?php echo $sel_starred1['updatenumber']; ?><?php echo $sel_starred1['updateTitle']; ?></a></span> </div>
                  </li>
                  <?php
				  			
							
						
						}
					?>
                  <li class="last"><a class="button-viewallmsg" href="<?php echo SITE_MOD."user/activity.php"; ?>">View all Activity</a></li>
                </ol>
              </fieldset>
            </li>            
            <!--end activity-->
            
            <!--start inbox-->
            <li class="inbox_toggle"> <!--onclick="return changeClass();"--> 
              <a href="javascript:void(0)" class="toggle_link" title="Inbox"><span>Inbox</span></a></li>
            <li class="userinbox" id="userinbox">
              <fieldset id="toggle_menu">
                <ol>
                  <li class="first">INBOX</li>
                  <li>
                    <hr>
                  </li>
                  <?php 
										
					$sel_message_all_23=$con->recordselect("SELECT DISTINCT `projectId` FROM usermessages WHERE receiverId='".$_SESSION['userId']."' ORDER BY messageTime DESC");							
					while ($sel_message_2 = mysql_fetch_assoc($sel_message_all_23))
					{
						
						if($limit_count <= 3)
						{												
							$sel_message_all23=$con->recordselect("SELECT * FROM usermessages WHERE projectId='".$sel_message_2['projectId']."' AND receiverId='".$_SESSION['userId']."' GROUP BY senderId ORDER BY messageTime DESC");								
							while ($sel_message23 = mysql_fetch_assoc($sel_message_all23))
							{
							$sel_user_data23=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_message23['senderId']."'"));
							if($sel_user_data23['profilePicture40_40']!='NULL' && $sel_user_data23['profilePicture40_40']!= '')
							{
								 if(file_exists(SITE_URL.$sel_user_data23['profilePicture40_40'])){
									 $imagPath = SITE_URL.$sel_user_data23['profilePicture40_40'];
								 }
								 else
								 {
									 $imagPath = $sel_user_data23['profilePicture40_40'];
								 }
							}
							else
							{
								$imagPath = SITE_IMG_SITE."no_image.jpg";
							}
				?>
                  <li class="second" onClick="return openmessage1(<?php echo $sel_message23['senderId']; ?>,<?php echo $sel_message23['projectId']; ?>);">
                    <div class="userimage"><a href="<?php echo SITE_MOD.'user/message.php?id='.$sel_message23['senderId'].'&projectId='.$sel_message23['projectId']; ?>"><img src="<?php echo $imagPath; ?>" title="<?php echo $sel_user_data23['name']; ?>" alt="<?php echo $sel_user_data23['name']; ?>" width="40" height="40"></a></div>
                    <div  class="secondleft"> <span class="username"><a href="<?php echo SITE_MOD.'user/message.php?id='.$sel_message23['senderId'].'&projectId='.$sel_message23['projectId']; ?>"><?php echo $sel_user_data23['name']; ?></a></span> <span class="usermessage"><a class="target" href="<?php echo SITE_MOD.'user/message.php?id='.$sel_message23['senderId'].'&projectId='.$sel_message23['projectId']; ?>"><?php
					$unsanamsg = unsanitize_string(ucfirst($sel_message23['message'])); 
					$msg_len=strlen($unsanamsg);  
					if($msg_len>50) 
					{echo substr($unsanamsg, 0, 50).'...'; } 
					else { echo substr($unsanamsg, 0, 50); }  ?>
					 </a></span> </div>
                  </li>
                  <?php
												}											
											} $limit_count=$limit_count+1;
										}
									?>
                  <li class="last"><a class="button-viewallmsg" href="<?php echo SITE_MOD."user/inbox.php"; ?>">View all messages</a></li>
                </ol>
              </fieldset>
            </li>
            <!--end inbox-->
            <?php } ?>
            <li><a href="<?php echo SITE_MOD; ?>help/" title="Help">Help</a></li>
            <li><a href="<?php echo $base_url; ?>/blog/" title="Blog">blog</a></li>
          </ul>
        </div>
        <!--.top-menu--> 
      </div>
      <!--.header-right-panel-bottom--> 
    </div>
    <!--.header-right-panel .float-right--> 
  </div>
  <!--.header--> 
</div>
<div id="search_results-wrap" style="display: none;">
  	<div id="closeSearch" style=""><img src="<?php echo $base_url;?>images/close-btn.png"  /></div>
    <div class="clear"></div>
    <ul id="SearchCarousel" class="jcarousel-skin-tango">
      
    </ul>
  </div>
	<div id="main">
