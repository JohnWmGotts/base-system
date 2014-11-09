<?php global $theme;
session_start();

// jwg - give access to site db
			require_once(DIR_FS.'includes/functions/dbconn.php');
			require_once(DIR_FS.'includes/functions/functions.php');
			$con = new DBconn();
			$con->connect(SITE_DB_HOST, SITE_DB_NAME, SITE_DB_USER, SITE_DB_PASS);
/* -- use function in dbconn
 function recordselect($qy,$st=0)
  {
    if($st==1)
    {
      print $qy;
	  print '<br/>';
    }
    $rs=mysql_query($qy) or die(mysql_error()."<br>".$qy);
    return $rs;
  }
*/

  function stringShorter($str, $len=0){
	$len = (int)$len;
	$unsanaprotit = unsanitize_string(ucfirst($str));
	$protit_len = strlen($unsanaprotit);
	if($protit_len >= $len) {echo substr($unsanaprotit, 0, $len).'...'; }
	else { echo substr($unsanaprotit, 0, $len); }
}
function unsanitize_string($string)
{
	$string =(get_magic_quotes_gpc()) ? stripslashes($string) : $string;
	return html_entity_decode($string);
}

 ?>

<!DOCTYPE html>
<?php function wp_initialize_the_theme() { if (!function_exists("wp_initialize_the_theme_load") || !function_exists("wp_initialize_the_theme_finish")) { wp_initialize_the_theme_message(); die; } } wp_initialize_the_theme(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title>
<?php $theme->meta_title(); ?>
</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php $theme->hook('meta'); ?>
<link rel="stylesheet" href="<?php echo THEMATER_URL; ?>/css/screen.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo THEMATER_URL; ?>/css/print.css" type="text/css" media="print" />
<!--[if lt IE 8]><link rel="stylesheet" href="<?php echo THEMATER_URL; ?>/css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
<link rel="stylesheet" href="<?php echo THEMATER_URL; ?>/css/defaults.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen, projection" />
<!--Validation-->
<?php  wp_head(); ?>
<script type="application/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("#commentform").validate({
		rules: {
			author: { required: true},
			email: { required: true, email: true},
			comment: { required: true }
		},
		messages: {
			author: { required: 'Enter Name'},
			email: { required: 'Enter Email Address', email: 'Enter Proper Email Address'},
			comment: { required: 'Enter Comment' }
		}
	});
});
</script>
<!--Validation-->

<?php $theme->hook('head'); ?>
</head>
<body <?php body_class(); ?>>
<?php $theme->hook('html_before'); ?>
<header>
  <div class="wrapper">
    <div class="logo">
      <?php if ($theme->display('logo')) { ?>
      <a href="<?php echo SITE_URL; ?>index.php"><img class="logo" src="<?php $theme->option('logo'); ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" /></a>
      <?php } else { ?>
      <h1 class="site-title"><a href="<?php bloginfo('url'); ?>">
        <?php bloginfo('name'); ?>
        </a></h1>
      <h2 class="site-description">
        <?php bloginfo('description'); ?>
      </h2>
      <?php } ?>
    </div>
    <nav>
      <ul>
        <li class="onelink"> <a href="<?php echo SITE_URL; ?>staffpicks/"><span>Discover</span><br/>
          <span class="black">Great Projects</span></a> </li>
        <li class="onelink"> <a href="<?php echo SITE_URL; ?>createproject/"><span>Start</span><br/>
          <span class="black">Your Projects</span></a> </li>
        <li class="searchdiv">
        <?php get_search_form(); ?>
        </li>
        <li class="last">
          <ul>
            <li><a href="<?php echo SITE_URL; ?>help/" title="Help">Help</a></li>
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
                        $sel_message_all_23= $con->recordselect("SELECT DISTINCT `projectId` FROM usermessages WHERE receiverId='".$_SESSION['userId']."' ORDER BY messageTime DESC LIMIT 0 , 3 ");							
                        $limit_count = 0; // jwg
						while ($sel_message_2 = mysql_fetch_assoc($sel_message_all_23))
                        {
                            if($limit_count <= 3)
                            {												
                                $sel_message_all23= $con->recordselect("SELECT * FROM usermessages WHERE projectId='".$sel_message_2['projectId']."' AND receiverId='".$_SESSION['userId']."' GROUP BY senderId ORDER BY messageTime DESC");								
                                while ($sel_message23 = mysql_fetch_assoc($sel_message_all23))
                                {
                                $sel_user_data231= $con->recordselect("SELECT * FROM `users` WHERE userId='".$sel_message23['senderId']."'");
                                $sel_user_data23=mysql_fetch_assoc($sel_user_data231);
                                $check_usrimg23=str_split($sel_user_data23['profilePicture40_40'], 4);
                                if($sel_user_data23['profilePicture40_40']!='NULL' || $sel_user_data23['profilePicture40_40']!= '')
                                {
                                     if(file_exists(DIR_FS.$sel_user_data23['profilePicture40_40']) && mysql_num_rows($sel_user_data231)>0 && $check_usrimg23[0]=='imag'){
                                         $imagPath = SITE_URL.$sel_user_data23['profilePicture40_40'];
                                     }
                                     else if($check_usrimg23[0]=='http')
                                     {
                                         $imagPath = $sel_user_data23['profilePicture40_40'];
                                     }
                                     else
                                     {
                                         $imagPath = NOIMG;
                                     }
                                }
                                else
                                {
                                    $imagPath = NOIMG;
                                }
                        ?>
                        
                         <div onClick="return openmessage1(<?php echo $sel_message23['senderId']; ?>,<?php echo $sel_message23['projectId']; ?>);">   
                            <div class="box-main">
                                <div class="box-left">
                                    <div class="box-left-img">
                                    	<a href="<?php echo SITE_MOD.'user/message.php?id='.$sel_message23['senderId'].'&projectId='.$sel_message23['projectId']; ?>">
                                        <!--<a href="<?php //echo SITE_URL.'user/message/'.$sel_message23['senderId'].'/'.$sel_message23['projectId']; ?>">-->
                                            <img src="<?php echo $imagPath; ?>" title="<?php echo $sel_user_data23['name']; ?>" alt="<?php echo $sel_user_data23['name']; ?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="box-right">
                                    <h4><a href="<?php echo SITE_MOD.'user/message.php?id='.$sel_message23['senderId'].'&projectId='.$sel_message23['projectId']; ?>"><?php echo $sel_user_data23['name']; ?></a></h4>
                                    <!--<h4><a href="<?php //echo SITE_URL.'user/message/'.$sel_message23['senderId'].'/'.$sel_message23['projectId']; ?>"><?php echo $sel_user_data23['name']; ?></a></h4>-->
                                    <p>
                                    	<a class="target" href="<?php echo SITE_MOD.'user/message.php?id='.$sel_message23['senderId'].'&projectId='.$sel_message23['projectId']; ?>">
                                        <!--<a class="target" href="<?php //echo SITE_URL.'user/message/'.$sel_message23['senderId'].'/'.$sel_message23['projectId']; ?>">-->
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
                        <div class="menu-dropdown-link"><a href="<?php echo SITE_URL."user/inbox/"; ?>">View all messages</a></div>
                        
                    </div>
                </li>
                                
                <li class="backhover">
                	<a href="#">
                    	<div class="activity"></div>
                        <!--<div class="notification">1</div>-->
                    </a>
                	<div class="menu-dropdown width250">
                     	<h3>Recent Activity</h3>
                        <div class="space10"></div>
                      	<?php
						$sel_starredproj= $con->recordselect("SELECT * FROM projectremind AS prorem, projectupdate AS pu WHERE prorem.userId ='".$_SESSION['userId']."'
							AND prorem.status =1 AND pu.projectId = prorem.projectId ORDER BY pu.updateTime DESC LIMIT 0 , 5");
						
						while ($sel_starred1 = mysql_fetch_assoc($sel_starredproj)) 
						{
							$sel_pro_data1=mysql_fetch_assoc( $con->recordselect("SELECT * FROM `projects` AS pro, projectbasics AS pb, users AS usr, categories AS cat 
								WHERE pro.projectId ='".$sel_starred1['projectId']."' AND pb.projectId ='".$sel_starred1['projectId']."' AND usr.userId ='".$sel_starred1['userId']."'
								AND pb.projectCategory = cat.categoryId"));				
							
							$sel_project_updateimg12= $con->recordselect("SELECT * FROM `productimages` WHERE projectId='".$sel_starred1['projectId']."' LIMIT 1");
							$sel_project_updateimg=mysql_fetch_assoc($sel_project_updateimg12);
						?>
                        	<div onClick="return openactivity1(<?php echo $sel_starred1['projectId']; ?>,<?php echo $sel_starred1['updatenumber']; ?>);">
                            	<div class="box-main">
                                    <div class="box-left">
                                        <div class="box-left-img">
                                            <a href="<?php echo SITE_URL.'browseproject/project/'.$sel_starred1['projectId'].'&update='.$sel_starred1['updatenumber'].'#tabs-2'; ?>">
												<?php if($sel_project_updateimg['image100by80']!='' && file_exists(DIR_FS.$sel_pro_imgs['image100by80']) && mysql_num_rows($sel_project_updateimg12)>0) { ?>
                                                <img width="40" height="40" src="<?php echo SITE_URL.$sel_project_updateimg['image100by80']; ?>">
                                                <?php } else { ?>
                                                <img width="40" height="40" src="<?php echo NOIMG; ?>">
                                                <?php } ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="box-right">
                                        <h4>
                                        	<a href="<?php echo SITE_URL.'browseproject/project/'.$sel_starred1['projectId'].'&update='.$sel_starred1['updatenumber'].'#tabs-2'; ?>">
												<?php echo $sel_pro_data1['projectTitle']; ?>
                            				</a>
                                        </h4>
                                        <p>
                                            <a class="target" href="<?php echo SITE_URL.'browseproject/project/'.$sel_starred1['projectId'].'&update='.$sel_starred1['updatenumber'].'#tabs-2'; ?>">
                                                 Update #<?php echo $sel_starred1['updatenumber']; ?><?php echo $sel_starred1['updateTitle']; ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="flclear"></div>
                            </div>
                        <?php
							}
							//While Over Activity.
						?>
                    	<div class="menu-dropdown-link"><a href="<?php echo SITE_MOD."user/activity.php"; ?>">View all Activities</a></div>
                    </div>
                </li>
                      
                <li class="backhover">
                	<a href="#">
                    	<?php if(!empty($_SESSION['name'])){ echo $_SESSION['name']; }else{echo "ME";} ?>
                    </a>
                    <div class="menu-dropdown width250">
                        <ul>
                            <h3>My Account</h3>
                            <li><a title="My Profile" href="<?php echo SITE_URL; ?>profile/edit/">My Profile</a></li>
                            <?php $qrySelCreator = $con->recordselect('SELECT * from projects WHERE userId="'.$_SESSION["userId"].'"');
							$qrySelBacker = $con->recordselect('SELECT * from projectbacking WHERE userId="'.$_SESSION["userId"].'"');						
							if(mysql_num_rows($qrySelCreator) > 0 || mysql_num_rows($qrySelBacker) > 0 ) {
							?>
								<li><a title="Invite Friends" href="<?php echo SITE_URL; ?>invitefriends/">Invite Friends</a></li>
                            <?php } ?>
                             <li><a title="My Financials" href="<?php echo SITE_URL; ?>advancefinance/">My Financials</a></li>
                            <li><a title="My Backer History" href="<?php echo SITE_URL; ?>backerhistory/">My Backer History</a></li>
                             <li><a title="My Reward History" href="<?php echo SITE_URL; ?>rewardhistory/">My Reward History</a></li>
                            <li><a title="Edit Settings" href="<?php echo SITE_URL; ?>profile/edit/">Edit Settings</a></li>
                            <li><div class="menu-dropdown-link "><a href="<?php echo SITE_URL; ?>logout/">Log Out</a></div></li>						
						</ul>
                        <?php
						$sel_created_project= $con->recordselect("SELECT * FROM projects AS pro, projectbasics AS pb
							WHERE pro.userId ='".$_SESSION['userId']."' AND pro.projectId = pb.projectId
							ORDER BY `pro`.`projectId` DESC LIMIT 5");
						if(mysql_num_rows($sel_created_project)>0)
						{ ?>
                        <ul>
                            <h3>My Created Projects</h3>
                            <?php
							while($selCreatedProject=mysql_fetch_assoc($sel_created_project))
							{
                            ?>
                            <li>
                            	<a href="<?php if($selCreatedProject['published']==1 && $selCreatedProject['accepted']==1)
								{
									echo SITE_URL.'browseproject/project/'.$selCreatedProject['projectId']; 
								}
								else
								{
									echo SITE_URL.'createproject/id/'.$selCreatedProject['projectId']; 
								} ?>" >
                                <?php 
									if($selCreatedProject['projectTitle']!='') 
									{ echo stringShorter($selCreatedProject['projectTitle'],18); }
									else
									{ echo 'Untitled'; }
                                ?>
                                </a>
                            </li>
                            <?php } ?>
                            <div class="menu-dropdown-link "><a href="<?php echo SITE_URL;?>modules/user/profile.php?#tabs-4">See All</a></div>
                        </ul>
                         <?php } ?>
                         
                    </div>
                </li>
		<?php } else { ?>
            <li><a href="<?php echo str_replace('http:','https:',SITE_URL);?>login" title="Log in">Log in</a></li>
            <li><a href="<?php echo str_replace('http:','https:',SITE_URL);?>signup" title="Sign Up">Sign up</a></li>
			<?php }?>
          </ul>
        </li>
      </ul>
    </nav>
    <div class="flclear"></div>
  </div>
</header>
<div id="wrapper">
<!-- #header -->
<div id="container" class="container">