<html xmlns:fb="http://ogp.me/ns/fb#">
<link href="<?php echo SITE_CSS ?>jquery-ui.css" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="<?php echo SITE_JS; ?>jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo SITE_JS; ?>lmcbutton.js"></script>

<script type="text/javascript">
function chklogin(val,rewardId,projectId){
	if(val==''){
		$(function() { 
		 $( "#dialog" ).dialog({ resizable: false, width: 262,
		 open: function(event, ui){ 
				$(this).parents(".ui-dialog:first").find(".ui-widget-header")
					.addClass("ui-widget-header-custom");
			} });
		 return false;             
		});
	} else { 
		if(<?php echo $sel_pro['userId']; ?>!=val) {
		window.location = application_path+"projectBacker/"+<?php echo sanitize_string($_GET['project']);?>+"/"+rewardId+"/<?php print Slug($sel_pro_basic['projectTitle']).'/';?>";;
		}
	}
}
function usrerredirect(rewardId) {
	window.location=application_path+"projectBacker/"+<?php echo sanitize_string($_GET['project']);?>+"/"+rewardId+"/<?php print Slug($sel_pro_basic['projectTitle']).'/';?>";
}

$("#profile-bio-full").css({ 'display': 'block' });
$("#referral-reward").css({ 'display': 'none' });
function showReferralPopup(){
	$("#profile-bio-full").css({ 'display': 'none' });
	$("#referral-reward").css({ 'display': 'block' });
}

$(document).ready(function() {
	
	
	var arr = [ "#a", "#b", "#c", "#d", "#e" ];
	var arr1 = ["#aa", "#bb", "#cc", "#dd", "#ee"];
	if ( $.browser.msie ) {
 		var hash = document.URL.substr(document.URL.indexOf('#'));
	}else{
  		var hash = window.location.hash;
	}
	//alert(hash);
	$(".tabs_left").fadeOut(1);
	$(".tab_header_left ul li").removeClass("activate");
	
	if(jQuery.inArray( hash, arr ) != -1) {
		$(hash).fadeIn(1);
		var selecter = '#'+hash.substr(hash.indexOf('#')+1)+hash.substr(hash.indexOf('#')+1);
		if(jQuery.inArray( selecter, arr1 ) != -1){
			$(selecter).addClass("activate");
		}		
	}else{
		$("#a").fadeIn(1);
		$("#aa").addClass("activate");
	}
	$(".tab_header_left ul li").click(function(){
		$(".tab_header_left ul li").removeClass("activate");
		$(this).addClass("activate");
	});
	/*$("#a").fadeIn(1);
	$(".tab_header_left ul li").click(function(){
		$(".tab_header_left ul li").removeClass("activate");
		$(this).addClass("activate");
	});*/
	
  	$("#aa").click(function(){
		$(".tabs_left").fadeOut(1);
		$("#a").fadeIn(1);
	});
	$("#bb").click(function(){
		$(".tabs_left").fadeOut(1);
		$("#b").fadeIn(1);
	});
	$("#cc").click(function(){
		$(".tabs_left").fadeOut(1);
		$("#c").fadeIn(1);
	});
	$("#dd").click(function(){
		$(".tabs_left").fadeOut(1);
		$("#d").fadeIn(1);
	});
	$("#ee").click(function(){
		$(".tabs_left").fadeOut(1);
		$("#e").fadeIn(1);
	});
	
	$(".tab_header_right ul span").click(function(){
		$("#toggle_first").slideToggle(1);
		$("#toggle_second").slideToggle(1);
	});
		
	$("#frmCP1").validate({
	rules: {
		emailid: { required: true,email:true },
		passwd: { required: true }
	},
	messages: {
		emailid: {
			required: "<?php echo ER_EMAIL;?>",
			email: "Please enter a valid email address."
				},
		passwd: {
			required: "<?php echo ER_PSW;?>"
			}
		}
	});

	$("#frmMessage").validate({
		rules: {
			user_message: { required: true, maxlength:255 },
			captcha: {
				required: true,
				remote:"<?php echo SITE_URL;?>modules/user/user_ajax.php"}
		
		},
		
		messages: {
			user_message: {
				required: 'Please Enter Message',
				maxlength: "Accepted only 255 characters"
			},
			captcha:{remote:"Captcha code is not valid"}
		}
	});	
	$("#frm_user_comments").validate({
		rules: {
			user_comment: { required: true, maxlength:255 }
		},
		messages: {
			user_comment: {
				required: 'Please Enter comment',
				maxlength: "Accepted only 255 characters"
			}
		}
	});	
	$("#frm_user_reviews").validate({
		rules: {
			user_review: { required: true, maxlength:255 }
		},
		messages: {
			user_review: {
				required: 'Please Enter Review',
				maxlength: "Accepted only 255 characters"
			}
		}
	});	
	$("#frm_userupdate_comments1").validate({
		rules: {
			projectupdate_comment1: { required: true, maxlength:255 }
		},
		messages: {
			projectupdate_comment1: {
				required: 'Please Enter comment',
				maxlength: "Accepted only 255 characters"
			}
		}
	});
	$("#frm_forgotpass").validate({
		rules: {
			for_email: { required: true,email:true }
		},
		messages: {
			for_email: {
				required: "<?php echo '<br>'.ER_EMAIL;?>",
				email: "<br>Please enter a valid email address"
			}
		}
	});
});
 
function chkloginforcomment() {             
	$( "#dialog" ).dialog({ resizable: false, width: 262, 
		open: function(event, ui){ 
			$(this).parents(".ui-dialog:first").find(".ui-widget-header")
			.addClass("ui-widget-header-custom");
		}
	});
	return false;             
}
function sendmessage(dialogtitle) { 
	$( "#dialog1" ).dialog({ resizable: false, width: 460,  title: dialogtitle,
		 open: function(event, ui){ 
	$(this).parents(".ui-dialog:first").find(".ui-widget-header")
		.addClass("ui-widget-header-custom");
	}
	});		 
	 return false;             
}
function remindproject(projectId,userId) {             
	 window.location=application_path+"remindme/"+ projectId +"/"+ userId +"/";
}
</script>

<script>
$(function() {
	$('#dialog_link_forgot').click(function(){
		$('#dialog').dialog('close')
		$( "#dialog_forgot" ).dialog({ 
			resizable: false ,
			open: function(event, ui){ 
				$(this).parents(".ui-dialog:first").find(".ui-widget-header")
				.addClass("ui-widget-header-custom");
			}
		});
		return false;
	});
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
<script>
  function countChar(val) {
	var len = val.value.length;
	if(len <=255){
		$('#charNum').text(255 - len);
	}else{
		val.value = val.value.substring(0, 255);
	}
  };
  function countCharPrjUpdate(val) {
	var len = val.value.length;
	var id = val.id;
	var target_id = id.split("-")[1];
	if(len <=255){
		$('#charNumPrjUpdate'+target_id).text(255 - len);
	}else{
		val.value = val.value.substring(0, 255);
	}
  };
  function countCharPrjUpCmt(val) {
	var len = val.value.length;
	if(len <=255){
		$('#charNumPrjUpCmt').text(255 - len);
	}else{
		val.value = val.value.substring(0, 255);
	}
  };
  function countChar1(val) {
	var len = val.value.length;
	if (len <= 255) {
	  $('#charNum1').text(255 - len);
	} else {
	  val.value = val.value.substring(0, 255);
	}
  };
  function countChar2(val) {
	var len = val.value.length;
	if (len <= 255) {
	  $('#charNum2').text(255 - len);
	} else {
	  val.value = val.value.substring(0, 255);
	}
  };
  
  function playVideo(div_id,video_url) {
	var pic_width = $('#'+div_id).width();
	var pic_height = $('#'+div_id).height();
	// replace current image displayed in the div_id area with an embedded youtube video for given url - jwg
	document.getElementById(div_id).innerHTML = '<iframe src="'+ video_url +'" width="' + pic_width + '" height="' + pic_height + '" frameborder="0" allowfullscreen></iframe>';
  }
</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1525405234342164&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<?php 
$referral_url = SITE_URL.'referral/'.$sel_pro_basic['projectId'].'/'.$sel_projectcreater['userId']; 
if (preg_match('#http:#i',substr($referral_url,0,5))) $referral_url = preg_replace('#http://#i','https://',$referral_url);
?>
<div class="modal_dialog dark">
    <div class="modal_dialog_outer">
        <div class="modal_dialog_sizer">
            <div class="modal_dialog_inner">
                <div class="modal_dialog_content">
                    <div class="modal_dialog_head">
                        <a class="modal_dialog_close modal_show" href="#"><span class="ss-icon ss-delete"></span></a>
                    </div>
                    <div class="modal_dialog_body">
					<div id="referral-reward" style="display:none;">
                        <h2>Refer Friends, Earn Rewards</h2>
                        <h4>Spread the word about <?php echo $sel_pro_basic['projectTitle']; ?> </h4>
                        <p>
							Send this link to your friends: <span style="color:#008800"><?php echo $referral_url; ?></span>
							<script type="text/javascript"> ShowLMCButton('<?php echo $referral_url; ?>','copy','','<?php echo SITE_JS .'lmcbutton.swf'; ?>'); </script>
							<p>
								When your friends visit that link, they will be asked to register and will then be shown this project.
							</p>
							<p>
								When your friends back this or any project, a portion of our processing fee will be credited to your account.
							</p>
							<p>
								When this project reaches its funding goal, your account credits will be transferred to your PayPal account.
							</p>
							<p>
								You can also tell your friends about this project at Facebook and Twitter by clicking the Share buttons at the top of this page.
							</p>
						</p>				
					</div>
                    <div id="profile-bio-full" style="display:block;">
                        <h2>Biography</h2>
                        <h4>Regarding: <?php echo $sel_pro_basic['projectTitle']; ?> </h4>
                        <?php if(isset($sel_pro_basic['userBiography']) && $sel_pro_basic['userBiography']!='') { ?>
                            <p><?php echo $sel_pro_basic['userBiography']; ?></p>
                        <?php } else { ?>
                            <p><center>No Record Found.</center></p>
                        <?php } ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--forgot password popup start-->
<div id="dialog_forgot" title="Forgot Password?" class="hide">
	<form name="frm_forgotpass" action="<?php echo SITE_URL; ?>browseproject/" method="post" id="frm_forgotpass">
		<p>Tell us the email you used to sign up and we'll get you logged in.</p>
		<center>
		<input type="text" name="for_email" size="35" class="forgotinput">
		<br/><br/>
		<input name="submit_forgotpass"  type="submit" value="Reset My Password" />
		</center>		
	</form>
</div>
<!--forgot password popup end -->

<!--Log In popup start-->
<div id="dialog" title="Log in" class="hide">
	<h3 class="displayinline">Login </h3> or <a href="<?php echo SITE_URL.'signup/'; ?>" class="linkcolor">Sign Up</a>
	<p class="marbottom0">Please log in to continue.</p>
    <form action="<?php echo SITE_URL; ?>browseproject/<?php echo $_GET['project']; ?>/<?php print Slug($sel_pro_basic['projectTitle']).'/';?>/" method="post" name="frmCP1" id="frmCP1">
        <input type="hidden" name="passvalue" id="passvalue" value="<?php print (isset($passwd)) ? $passwd : ''; ?>" />
        <fieldset>
            <div class="fieldset-errors">
				<?php if(isset($error1) && ($error1!="")){ ?>
                    <?php print $error1; ?>
                <?php } ?>
                <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="CHANGEPSW")){ ?>
                    <?php echo constant($_GET['msg']); ?>
                <?php } ?>
            </div>
            <ol style="list-style-type:none;">
                <li id="form-signup-email">
                     <label for="user_email">Email</label>
                     <input id="user_email" name="emailid" size="30" tabindex="1" type="text" />
                </li>
                <li id="form-signup-email">
                     <label for="user_password" class="displayinline float-left">Password</label><a class="forgot-password-position1 linkcolor float-right" href="javascript:void(0)" id="dialog_link_forgot">Forgot password?</a>
                     <div class="clear"></div>
					 <input id="user_password" size="30" name="passwd" tabindex="2" type="password" />
                </li>
                <li>
                     <input name="submitLogin" tabindex="3" type="submit" value="Log Me In!" />
                </li>
            </ol>
        </fieldset>																																																																								
    </form>		
</div>
<!--Log In popup end-->

<!-- Msg popup start-->
<div id="dialog1" title="" class="hide">
    <form action="<?php echo SITE_URL;?>browseproject/<?php echo $_GET['project']; ?>/" method="post" name="frmMessage" id="frmMessage">
        <input type="hidden" name="passvalue" id="passvalue" value="<?php print (isset($passwd)) ? $passwd : ''; ?>" />
        <fieldset>
        <div class="fieldset-errors">
            <?php if(isset($error1) && ($error1!="")){ ?>
            	<?php print $error1; ?>
            <?php } ?>
            <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="CHANGEPSW")){ ?>
            	<?php echo constant($_GET['msg']); ?>
            <?php } ?>
            <?php if($sel_pro_basic['projectEnd']>time() && $sel_pro_basic['fundingStatus']!='n') {
				$end_date=(int) $sel_pro_basic['projectEnd'];
				$cur_time=time();
				$total = $end_date - $cur_time;
				$left_days=$total/(24 * 60 * 60);
			} else {
				$left_days=0;
			} ?>		
        </div>
        <ol class="poup-sendmessage" style="list-style-type:none;">
         <li id=""> <label>To: <?php echo $sel_pro_user['name']; ?></label></li>
         <li><textarea name="user_message" onKeyUp="countChar(this)" id="field"></textarea></li>
         <li><div id="charNum">255</div></li>
         <li> <div class="inputfield">
                <p>Captcha</p>
                    <input name="captcha" id="captcha" type="text" class="small">
             </div></li>
           <li style="margin-bottom:25px;"> <div class="inputfield">
                    <img id="imgCaptcha" src="<?php echo SITE_URL; ?>includes/capcha/random.php" height="25" alt="Captcha Code" border="0" class="fl"/>
                    <a href="javascript:void(0)" onClick="document.getElementById('imgCaptcha').src='<?php echo SITE_URL; ?>includes/capcha/random.php?'+Math.random();$('#captcha').focus();$('#captcha').val('');" id="change-image" ><img id="changeCaptcha" src="<?php echo SITE_URL; ?>images/captcha-ref.jpg" alt="Captcha Refresh" border="0" class="fl" /></a>
                    
                </div></li>

         <li><input name="submitMessage" tabindex="3" type="submit" value="Send" /></li>
         </ol>
        </fieldset>																																																																								
    </form>		
</div>
<!-- Msg popup end-->


<section id="container" >
    <div id="get_started_header_detail" class="head_content temp">
    	
        <a title="<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectTitle'])); ?>" href="<?php echo SITE_URL.'browseproject/'.$sel_pro_basic['projectId'].'/'.Slug($sel_pro_basic['projectTitle']).'/'; ?>" >
            <h3><?php echo unsanitize_string(ucfirst($sel_pro_basic['projectTitle'])); ?></h3>
        </a>
        
        <p id="marginbottom30">by
            <a title="<?php echo unsanitize_string(ucfirst(trim($sel_pro_user['name']))); ?>" href="<?php echo SITE_URL.'profile/'.$sel_pro_user['userId'].'/'.Slug($sel_pro_user['name']).'/'; ?>" >
        		<?php echo unsanitize_string(ucfirst(trim($sel_pro_user['name']))); ?>
        	</a>
        </p>
        
    </div>
    
    <?php $sel_backers_count=mysql_fetch_assoc($con->recordselect("SELECT count( DISTINCT (userId) ) AS total3 FROM `projectbacking` WHERE `projectId` ='".$_GET['project']."'")); ?>
    
    <div class="tab">
   		<div class="wrapper" id="profile_tabs">
        <div id="tabs">
            <div class="tab_header">
                <div class="tab_header_left">
                    <ul>
                        <li id="aa" class="activate">Home</li>
                        <li id="bb">Updates</li>
                        <li id="cc">Backers (<?php if($sel_backers_count['total3']!='') { echo $sel_backers_count['total3']; } else { echo "0";} ?>)</li>
                        <li id="dd">Comments (<?php echo $sel_usercomment_count['tot']; ?>)</li>
                        <li id="ee">Reviews (<?php echo $sel_userreview_count['tot']; ?>)</li>
						<?php if (($sel_pro['published']==1) && ($sel_pro['accepted']==1)) { ?>
							<li><a class="modal_show" href="javascript:showReferralPopup()" >Referral Rewards</a></li>                        
							<li><div class="fb-share-button" data-href="<?php echo $referral_url; ?>" layout="button" ></div></li>
							<li><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $referral_url; ?>" data-text="Share" data-count="none">Tweet</a></li>
						<?php } ?>
						<div class="clear"></div>
                        <?php $total_comments = (int)$sel_usercomment_count["tot"];?>
                          <?php $total_reviews = (int)$sel_userreview_count["tot"];?>
                        <?php $total_backers = $sel_backers_count['total3'] == '' ? 0 : (int)$sel_backers_count['total3'];?>
                    </ul>
                </div>
                
                
               
                <div class="tab_header_right">
                	<ul>
                    	<?php 
						/* don't do this ... jwg
                    	<li>
							<img src="<?php echo SITE_IMG ?>location-mid.png" />
                        	<a title="<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectLocation'])); ?>" href="<?php echo SITE_URL; ?>city/<?php echo $sel_pro_basic['projectId'].'/'.Slug($sel_pro_basic['projectLocation']).'/';?>">
								<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectLocation'])); ?>
                            </a>
                        </li>
                       */
					   ?>
                        <li>
							<img src="<?php echo SITE_IMG ?>category-mid.png" />
                            <?php if($sel_pro_cate['isActive'] == 1) { ?>
                                <a title="<?php echo unsanitize_string(ucfirst($sel_pro_cate['categoryName'])); ?>" href="<?php echo SITE_URL; ?>category/<?php echo $sel_pro_cate['categoryId'].'/'.Slug($sel_pro_cate['categoryName']).'/';?>">
                                    <?php echo unsanitize_string(ucfirst($sel_pro_cate['categoryName'])); ?>
                                </a>
                            <?php }else{ ?>
                            	<a title="<?php echo $sel_pro_cate['categoryName']; ?>" href="javascript:void(0);">
                                    <?php echo $sel_pro_cate['categoryName']; ?>
                                </a>
                            <?php } ?>
                        </li>
                        <span>
                        <?php
						if($_SESSION["userId"] != $sel_projectcreater['userId']) {
							if(isset($_SESSION['userId']) && $_SESSION['userId']!='' && $left_days>0) {
								$sel_remind_status = mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectremind` WHERE projectId='".$_GET['project']."' AND userId='".$_SESSION['userId']."'"));		
								if($sel_remind_status['status']==1) { ?>
									<a title="Remove From Favorite" href="javascript:void(0)" onClick="return remindproject(<?php echo $_GET['project']; ?>,<?php echo $_SESSION['userId']; ?>);">
                                    	<img id="toggle_first" src="<?php echo SITE_IMG ?>star.png" />
                                    </a>
						<?php 	} else { ?>
									<a title="Add To Favorite" href="javascript:void(0)" onClick="return remindproject(<?php echo $_GET['project']; ?>,<?php echo $_SESSION['userId']; ?>);">
                                    	<img id="toggle_second" src="<?php echo SITE_IMG ?>blue_star.png" />
                                    </a>
						<?php  	}  }  } ?>
                        </span>
                	</ul>
                </div>
                 <div class="clear"></div>
            </div>
            
            <div class="tabs_content_bg">
                <div class="tab_content">
                	
                    <div id="a" class="tabs_left">
					<?php /* -- replaced uploaded video w/ youtube-sourced video and image -- jwg
						<?php if($sel_pro_video['projectVideo']!='' && mysql_num_rows($sel_pro_video1)>0) { ?>
                        	<div id="mediaplayer">JW Player goes here</div>
                        <?php } else if($sel_pro_image['image640by480']!='' && mysql_num_rows($sel_pro_image1)>0) { ?> 
                        	<img src="<?php echo SITE_URL.$sel_pro_image['image640by480']; ?>" title="<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectTitle'])); ?>" alt="<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectTitle'])); ?>" /> 
                        <?php } else { ?>
                        	<img src="<?php echo NOIMG; ?>" title="<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectTitle'])); ?>" alt="<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectTitle'])); ?>" /> 
                        <?php }?>
                        <script type="text/javascript" src="<?php echo SITE_JAVA; ?>jwplayer.js"></script>
                        <script type="text/javascript">
                            jwplayer("mediaplayer").setup({
                                flashplayer: "<?php echo SITE_MOD_BROWSE;?>player.swf",
                                file: "<?php echo SITE_IMG.$sel_pro_video['projectVideo']; ?>",
                                image: "<?php echo SITE_URL.$sel_pro_image['image640by480']; ?>"
                            });
                        </script>
                        */ 
						if (($sel_pro_video['projectVideo']!='') && ($sel_pro_video['projectVideoImage']!='')) {
							$videourl = $sel_pro_video['projectVideo'];
							if (preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/watch\?v=((?:[a-zA-Z0-9._]|-)+)(?:\&|$)/i',$videourl,$match) ||				
								preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/(?:user\/)?(?:[a-z0-9\_\#\/]|-)*\/[a-z0-9]*\/[a-z0-9]*\/((?:[a-z0-9._]|-)+)(?:[\&\?\w;=\+_\#\%]|-)*/i',$videourl,$match) ||
								preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/embed\/((?:[a-z0-9._]|-)+)(?:\?|$)/i',$videourl,$match)) {	  	
								$videoId = $match[1];
								$imageurl = 'https://img.youtube.com/vi/'.$videoId.'/0.jpg';
								//$videourl = 'https://www.youtube.com/embed/'.$videoId; 
								$videourl = 'https://www.youtube-nocookie.com/embed/'.$videoId.'?hd=1&autohide=1&autoplay=1&fs=1&rel=0';
						?>	
						Click image to watch video:
						<div id="videoArea">
							<a href="javascript:playVideo('videoArea','<?php echo $videourl; ?>')">
								<img src="<?php echo $sel_pro_video['projectVideoImage']; ?>" title="<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectTitle'])); ?>" alt="<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectTitle'])); ?>" /> 
							</a>
						</div>
						<?php
							} else {
								echo "Click link to watch video: <a target='_blank' href='$videourl'>$videourl</a><br/>";
							}
						}
						?>
						
                     	
                        <h3>About This Project</h3>
                     	<p><?php echo unsanitize_string(ucfirst($sel_pro_basic['shortBlurb'])); ?></p>
                        <div class="border_bottom"></div>
						<?php $sel_discription=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectstory WHERE projectId='".$_GET['project']."'")); ?>
						<?php $project_story = unsanitize_string($sel_discription['projectDescription']); ?>
                        <?php // echo '<pre>'.$project_story.'</pre>'; ?>
                         <?php  echo $project_story; ?>
						<?php if($_SESSION["userId"] != $sel_projectcreater['userId']) { ?>
                            <div class="last_button_div">
                                <?php if(isset($_SESSION['userId'])) { ?>
                                    <input type="hidden" value="Ask A Question" id="dialogaskquestion" />
                                    <a title="Ask a question" href="javascript:void(0)" class="button-ask-question" onClick="return sendmessage(document.getElementById('dialogaskquestion').value);" >Ask A Question</a>
                                <?php } else { ?>
                                    <a title="Ask a question" href="javascript:void(0)" class="button-ask-question" onClick="return chkloginforcomment();" >Ask A Question</a>
                                <?php } ?>
                                        <p><b>Have a question?</b>
                                        If the info above doesn't help, you can ask the project creator directly.
                                        </p>
                            </div>
                        <?php } ?>                        
					</div>
                    
                    
                    
                    
                    <div id="d" class="tabs_left"><!--id="comments"-->
						
						<?php if($_SESSION["userId"] != $sel_projectcreater['userId'] && $sel_usercomment_count['tot'] < 1) { ?>
                            <div class="ask-project-creater">
								<?php // if(isset($_SESSION['userId'])) { ?>
                                    <input type="hidden" value="Ask the project creator" id="dialogaskcreater2" />
                                    <span>Only backers can post comments. If you have a question,<a class="ask-creater" href="javascript:void(0)" onClick="return sendmessage(document.getElementById('dialogaskcreater2').value);" > ask the project creator.</a></span>
                                <?php // } else { ?>
                                    <!--<span><a class="ask-creater-for-comment" href="javascript:void(0)" onClick="return chkloginforcomment();">Leave a comment (for backers only)</a></span>-->
                                <?php // } ?>
                            </div>
                        <?php } ?>
                    		<div class="comment" id="dv-comments">
						<?php
							$sel_usercomment = $con->recordselect("SELECT * FROM `projectcomments` WHERE `projectId` = '".$_GET['project']."' AND commentstatus ='1' ORDER BY commentTime DESC".$rec_limit);
							while ($sel_comment = mysql_fetch_assoc($sel_usercomment)) {
								$sel_users=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_comment['userId']."'"));
						?>
                            <div class="comment_box first">
								<div class="comment_box_left">
                                <a href="<?php echo SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_users['name']).'/'; ?>">
									<?php 
                                    $check_usrcmt1=str_split($sel_users['profilePicture80_80'], 4);
                                    if($sel_users['profilePicture80_80']!='' && $sel_users['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_users['profilePicture80_80']) && $check_usrcmt1[0]=='imag') { ?>
                                   		<img src="<?php echo SITE_URL.$sel_users['profilePicture80_80']; ?>" class="avatar-thumb" alt="<?php echo $sel_users['name']; ?>" title="<?php echo $sel_users['name']; ?>">
                                    <?php } else if($sel_users['profilePicture80_80']!='' && $sel_users['profilePicture80_80']!=NULL && $check_usrcmt1[0]=='http') { ?>
                                    	<img src="<?php echo $sel_users['profilePicture80_80']; ?>" class="avatar-thumb" alt="<?php echo $sel_users['name']; ?>" title="<?php echo $sel_users['name']; ?>">
                                    <?php } else { ?>
                                    	<img width="80" height="80" src="<?php echo NOIMG2; ?>" class="avatar-thumb" alt="<?php echo $sel_users['name']; ?>" title="<?php echo $sel_users['name']; ?>">
                                    <?php } ?>
                                </a>
								</div>
								<div class="comment_box_right">
                                <a href="<?php echo SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_users['name']).'/'; ?>">
									<?php echo unsanitize_string(ucfirst($sel_users['name'])); ?>
                                </a>
                                <h6><?php $new_time = $sel_comment['commentTime'];	echo ago($new_time); ?> </h6> 
								<div class="clear"></div>	
                                <p><?php echo $sel_comment['comment']; ?></p>  
                                <div class="clear"></div>
                                <?php 
								//echo $sel_backers = "SELECT DISTINCT `userId` FROM `projectbacking` WHERE `projectId` = '".$_GET["project"]."' ";
								$sel_backers = "SELECT DISTINCT `userId` FROM `projectbacking` WHERE `projectId` = '".$_GET["project"]."' ";
								$sel_backersuser = mysql_query($sel_backers);
								while($backers = mysql_fetch_array($sel_backersuser)){
								if($backers['userId'] == $sel_comment['userId'] && $backers['userId'] == $_SESSION['userId']) { ?>
                                <div><a href="<?php echo SITE_URL.'browseproject/'.$sel_comment['commentId'].'/comment/'.$_GET['project']; ?>/" onClick="return confirm('Are you sure you want to delete this comment?')">Delete</a></div>
                                <?php } } ?>
                                <?php if($sel_pro_user['userId'] == $_SESSION['userId'] ) { 
								//echo $_GET['project'];  ?>
                                <?php // echo SITE_URL.'browseproject/'.$sel_comment['commentId'].'/comment/'.$_GET['project']; ?>
								 <div><a href="<?php echo SITE_URL.'browseproject/'.$sel_comment['commentId'].'/comment/'.$_GET['project']; ?>/" onClick="return confirm('Are you sure you want to delete this comment?')">Delete</a></div>
                                <?php  } ?>
                                </div>
                            </div>
                        
                        <?php } ?>
                        	</div>
                    	<div class="space10"></div>
						<?php if($total_comments > $perpage) { ?>
                            <div id="dv_d">
                                <center class="post-btn float-left">
                                    <div class="morelink">
                                        <input type="hidden" id="hidden_val_d" value="<?php echo $perpage; ?>">
                                        <input type="hidden" id="hidden_curr_page_d" value="0">
                                        <a href="javascript:;" id="load_comments" class="" data-for="d">Load More Comments...</a>
                                    </div>
                                </center>
                                <div class="space10"></div>
                            </div>
                        <?php } ?>
                        <div class="space10"></div>
						<?php if(isset($_SESSION['userId']) && ($count_backers > 0 || $sel_projectcreater['userId']==$_SESSION['userId'])) { ?>
                            <form method="post" action="<?php echo SITE_URL;?>browseproject/<?php echo $_GET['project']; ?>/" name="user_comment" id="frm_user_comments">								
                                <textarea class="input-textarea-comment"  id="user_comment" name="user_comment" onKeyUp="countChar1(this)"  ></textarea>
                                <br/>
                                <div id="charNum1">255</div>
                                <input class="button-comment" name="submitUserComment" type="submit" value="Post Comment" />							
                            </form>	
                        <?php } ?>
                    </div>
                    
                    
                    
                    <div id="c" class="tabs_left"><!--id="backers"-->
                        
						<?php
						$sel_backers_qry = "SELECT DISTINCT `userId` FROM `projectbacking` WHERE `projectId` = '".$_GET["project"]."' ".$rec_limit;
						$sel_backeruser = mysql_query($sel_backers_qry);
						
                        if(mysql_num_rows($sel_backeruser)>0) { ?>
                        
                        	<div class="comment" id="div-backers">	
                        <?php
							while ($sel_users = mysql_fetch_assoc($sel_backeruser)) {
								$sel_user=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_users['userId']."'"));
								$sel_userbackprojectcount=mysql_fetch_assoc($con->recordselect("SELECT count(DISTINCT(projectId)) as totalcounts FROM `projectbacking` WHERE `userId` = '".$sel_users['userId']."'"));
								$count_project=$sel_userbackprojectcount['totalcounts']-1;
                        ?>
                                <div class="comment_box comment2 backers" >
									<div class="comment2_left">
                                    <a href="<?php echo SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_user['name']).'/'; ?>">
										<?php 
                                        $check_usrpro123img=str_split($sel_user['profilePicture80_80'], 4);
                                        if($sel_user['profilePicture80_80']!='' && $sel_user['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_user['profilePicture80_80']) && $check_usrpro123img[0]=='imag') { ?>
                                        	<img src="<?php echo SITE_URL.$sel_user['profilePicture80_80']; ?>" alt="<?php echo unsanitize_string(ucfirst($sel_user['name'])); ?>" title="<?php echo unsanitize_string($sel_user['name']); ?>" /> 
									
                                        <?php } else if($sel_user['profilePicture80_80']!='' && $sel_user['profilePicture80_80']!=NULL && $check_usrpro123img[0]=='http') { ?>
                                        	<img src="<?php echo $sel_user['profilePicture80_80']; ?>" alt="<?php echo unsanitize_string(ucfirst($sel_user['name'])); ?>" title="<?php echo unsanitize_string($sel_user['name']); ?>" /> 
                                        <?php } else { ?>
                                        	<img src="<?php echo NOIMG; ?>" alt="<?php echo unsanitize_string(ucfirst($sel_user['name'])); ?>" title="<?php echo unsanitize_string($sel_user['name']); ?>" height="80" width="80"  /> 
                                        <?php } ?>
                                    </a>
									</div>
									<div class="comment2_right">
                                    <a title="<?php echo $sel_user['name']; ?>" href="<?php echo SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_user['name']).'/'; ?>">
										<?php echo $sel_user['name']; ?>
                                    </a>
                                    <h5><?php if($count_project>0) { if($count_project==1) { echo 'Backed '. $count_project .' other project. '; } else { echo 'Backed '. $count_project .' other projects. '; }} ?></h5>
									</div>
                                    <div class="clear"></div>
                                </div>
						<?php } ?>
                        	</div>
                        <?php
							} 
							else { ?>
                                <p class="no-content">No Backers found.</p>
                        <?php }  ?>
						<div class="space10"></div>
						<?php if ( $total_backers > $perpage ) { ?>
                            <div id="dv_c">
                                <center class="post-btn float-left">
                                    <div class="morelink">
                                        <input type="hidden" id="hidden_val_c" value="<?php echo $perpage; ?>">
                                        <input type="hidden" id="hidden_curr_page_c" value="0">
                                        <a href="javascript:;" id="load_backers" class="" data-for="c">Load More...</a>
                                    </div>
                                </center>
                                <div class="space10"></div>
                            </div>
                        <?php } ?>
                       
                    </div>
                    
                    <div id="b" class="tabs_left"><!--id="updates"-->
						
                    <div class="tabsupdate">
				<?php
					$total_updt_res = mysql_query("SELECT * FROM `projectupdate` WHERE projectId='".$_GET['project']."' AND updatestatus='1' ORDER BY updateTime DESC");
					$total_updt = mysql_num_rows($total_updt_res);
					$sel_updates_qry = "SELECT * FROM `projectupdate` WHERE projectId='".$_GET['project']."' AND updatestatus=1 ORDER BY updateTime DESC ".$rec_limit;
					$sel_updates = mysql_query($sel_updates_qry);
							 
                    if(!isset($_GET['update']) || $_GET['update']=='') { ?>
							
                        <div id="div-updates">
							
				<?php  	if(mysql_num_rows($sel_updates)>0) {
								
							while ($sel_updates_project = mysql_fetch_assoc($sel_updates)) { ?>
                                	
								<div class="update_box first">
                                <h1>Update #<?php echo $sel_updates_project['updatenumber'].": ".unsanitize_string(ucfirst($sel_updates_project['updateTitle'])); ?>
                                    &nbsp;&nbsp;&nbsp; 
                                    <?php if($sel_pro_user['userId'] == $_SESSION['userId']) { ?>
                                     <a href="<?php echo SITE_URL ;?>projectupdate/<?php echo $sel_updates_project['projectupdateId'].'/'.Slug($sel_pro_basic['projectTitle']).'/edit/'; ?>">
                                  	Edit</a>
                                    &nbsp;&nbsp;
                                    <a href="<?php echo SITE_URL.'browseproject/'.$sel_updates_project['projectupdateId'].'/update/'.$_GET['project']; ?>/"  onClick="return confirm('Are you sure you want to delete this update?')">Delete</a>
                                    </h1>
                                  
                                    <?php } ?>
                                    <h2>Posted <?php $update_time = $sel_updates_project['updateTime']; echo ago($update_time); ?></h2>
                                    <div class="clear"></div>
                                    <p><?php echo unsanitize_string($sel_updates_project['updateDescription']);?></p>
                                   <div class="comment" id="updt-comment-container-<?php echo $sel_updates_project['updatenumber']; ?>">
                                    <?php
                                $tot_updt_coment_res = $con->recordselect("SELECT * FROM `projectupdatecomment` WHERE `projectId` = '".$_GET['project']."' AND updatecommentstatus=1 AND updatenumber ='".$sel_updates_project['updatenumber']."' ORDER BY updateCommentTime DESC");
                                $tot_updt_coment = mysql_num_rows($tot_updt_coment_res);
                                    //$tot_updt_coment = (int)$tol_updt_coment_row['total'];
                                $sel_updateProjectComment	= $con->recordselect("SELECT * FROM `projectupdatecomment` WHERE `projectId` = '".$_GET['project']."' AND updatecommentstatus=1 AND updatenumber ='".$sel_updates_project['updatenumber']."' ORDER BY updateCommentTime DESC".$comment_limit);
								while ($sel_updateProjectComments = mysql_fetch_assoc($sel_updateProjectComment)) {
                                    $sel_updateCommentUsr	= mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_updateProjectComments['userId']."'"));  ?>
                                        <div class="comment_box backgrndnone">
                                           	<div class="comment_box_left1">
                                            <a href="<?php echo SITE_URL.'profile/'.$sel_updateCommentUsr['userId'].'/'.Slug($sel_updateCommentUsr['name']).'/'; ?>">
                                                <?php 
                                                $check_usr12proimg=str_split($sel_updateCommentUsr['profilePicture80_80'], 4);
                                                if($sel_updateCommentUsr['profilePicture80_80']!='' && $sel_updateCommentUsr['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_updateCommentUsr['profilePicture80_80']) && $check_usr12proimg[0]=='imag') { ?>
                                                    <img src="<?php echo SITE_URL.$sel_updateCommentUsr['profilePicture80_80']; ?>" class="avatar-thumb" alt="<?php echo $sel_updateCommentUsr['name']; ?>" title="<?php echo $sel_updateCommentUsr['name']; ?>">
                                                <?php } else if($sel_updateCommentUsr['profilePicture80_80']!='' && $sel_updateCommentUsr['profilePicture80_80']!=NULL && $check_usr12proimg[0]=='http') { ?>
                                                    <img src="<?php echo $sel_updateCommentUsr['profilePicture80_80']; ?>" class="avatar-thumb" alt="<?php echo $sel_updateCommentUsr['name']; ?>" title="<?php echo $sel_updateCommentUsr['name']; ?>">
                                                <?php } else { ?>
                                                    <img width="80" height="80" src="<?php echo NOIMG2; ?>" class="avatar-thumb" alt="<?php echo $sel_updateCommentUsr['name']; ?>" title="<?php echo $sel_updateCommentUsr['name']; ?>">
                                                <?php } ?>
                                            </a>
                                            </div>
                                            <div class="comment_box_right1">
                                                <a href="<?php echo SITE_URL.'profile/'.$sel_updateCommentUsr['userId'].'/'.Slug($sel_updateCommentUsr['name']).'/'; ?>" class="float-left">
                                                	<?php echo unsanitize_string(ucfirst($sel_updateCommentUsr['name'])); ?>
                                                </a>
                                                <h6 class="float-right"><a href="javascript:void(0);">About <?php $update_comment_time=$sel_updateProjectComments['updateCommentTime']; echo ago($update_comment_time); ?></a></h6>
                                                <div class="clear"></div>
                                                <p><?php echo $sel_updateProjectComments['updateComment']; ?></p>
                                                <div class="clear"></div>
                                <?php 
									//echo $sel_backers = "SELECT DISTINCT `userId` FROM `projectbacking` WHERE `projectId` = '".$_GET["project"]."' ";exit;
									$sel_backers = "SELECT DISTINCT `userId` FROM `projectbacking` WHERE `projectId` = '".$_GET["project"]."' ";
									$sel_backersuser = mysql_query($sel_backers);
									while($backers = mysql_fetch_array($sel_backersuser)){
									if($backers['userId'] == $sel_updateProjectComments['userId'] && $backers['userId'] == $_SESSION['userId']) {
									 ?>
									<div><a href="<?php echo SITE_URL.'browseproject/'.$sel_updateProjectComments['updatecommentId'].'/updatecomment/'.$_GET['project']; ?>/" onClick="return confirm('Are you sure you want to delete this comment?')">Delete</a></div>
									<?php } } ?>
                                <?php if($sel_pro_user['userId'] == $_SESSION['userId'] ) { 
								//echo $_GET['project'];  ?>
                                <?php // echo SITE_URL.'browseproject/'.$sel_comment['commentId'].'/comment/'.$_GET['project']; ?>
								<div><a href="<?php echo SITE_URL.'browseproject/'.$sel_updateProjectComments['updatecommentId'].'/updatecomment/'.$_GET['project']; ?>/" onClick="return confirm('Are you sure you want to delete this comment?')">Delete</a></div>
                                <?php  } ?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>               
                         <?php  }//while Over ?>
                                   </div>
                                    <div class="space10"></div>
                                    
						<?php 	if($tot_updt_coment > $perpage) { ?>
                                        <div id="dv_comment_b">
                                            <center class="post-btn float-left">
                                                <div class="morelink">
                                                    <input type="hidden" id="hidden_val_comment_b_<?php echo $sel_updates_project['updatenumber']; ?>" value="<?php echo $perpage; ?>">
                                                    <input type="hidden" id="hidden_curr_page_comment_b_<?php echo $sel_updates_project['updatenumber']; ?>" value="0">
                                                    <a href="javascript:;" class="load_post_comments" data-for="comment_b" data-number="<?php echo $sel_updates_project['updatenumber']; ?>" data-project="<?php echo $sel_updates_project['projectId']; ?>">Get More Comments...</a>
                                                </div>
                                            </center>
                                            <div class="space10"></div>
                                        </div>
                          <?php } ?>
                                    
                                    <?php
                                if(isset($_SESSION['userId']) && ($count_backers > 0 || $sel_projectcreater['userId']==$_SESSION['userId'])) { ?>
                                        									
										<script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#frm_userupdate_comment_<?php echo $sel_updates_project['updatenumber']; ?>").validate({
                                                rules: {
                                                        projectupdate_comment: { required: true, maxlength:255 }
                                                        },
                                                messages: {
                                                        projectupdate_comment: {
                                                            required: 'Please Enter comment',
                                                            maxlength: "Accepted only 255 characters"
                                                        }
                                                    },
                                            });
                                        });
                                        </script>
                                        <form method="post" action="<?php echo SITE_URL;?>browseproject/<?php echo $_GET['project']; ?>/" name="frm_userupdate_comment" id="frm_userupdate_comment_<?php echo $sel_updates_project['updatenumber']; ?>">
                                            <textarea id="projectupdate_comment-<?php echo  $sel_updates_project['updatenumber'];?>" onKeyUp="countCharPrjUpdate(this)" name="projectupdate_comment" ></textarea>
                                            <div id="charNumPrjUpdate<?php echo $sel_updates_project['updatenumber']; ?>">255</div>
                                            <br/>
                                            <input type="hidden" name="updatenumber" value="<?php echo  $sel_updates_project['updatenumber'];?>" />
                                            <input name="submitProjectUpdateComment" type="submit" value="Post Comment" />
                                            <div class="space10"></div>							
                                        </form>
                          <?php }//If Over ?>
								</div>
                    <?php }//While Outer 
								if($_SESSION["userId"]!=$sel_projectcreater['userId'] ) { 
									while($prbackers=mysql_fetch_array($sel_onlybackers)) {
										if($_SESSION["userId"]!=$prbackers['userId']) {
											//if(isset($_SESSION['userId'])) { ?>
											<input type="hidden" value="Ask the project creator" id="dialogaskcreater" />
											<h6>Only backers can post comments. If you have a question,<a href="javascript:void(0)" onClick="return sendmessage(document.getElementById('dialogaskcreater').value);" > ask the project creator.</a></h6>
									<?php } 
									} 
										 //} else { ?>
											<!--<h6><a href="javascript:void(0)" onClick="return chkloginforcomment();">Leave a comment (for backers only)</a></h6>-->
										<?php //} 
								} 
						} //IF Over (mysql_num_rows($sel_updates)>0)
						else { ?> 
						<p>No Updates found.</p> 
			<?php 		} ?>
                        	
                            </div>
                        
			<?php 	} //If Over Main (!isset($_GET['update']) || $_GET['update']=='')
						else { 
							
							$sel_updates_project1=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectupdate` WHERE `projectId` = '".$_GET['project']."' AND updatestatus=1 AND updatenumber='".$_GET['update']."'")); ?>  
                        	
                            <div class="update_box first">
                                <h1>Update #<?php echo $sel_updates_project1['updatenumber'].": ".unsanitize_string(ucfirst($sel_updates_project1['updateTitle'])); ?></h1>
                                <h2>Posted <?php $update_time1=$sel_updates_project1['updateTime']; echo ago($update_time1); ?></h2>
                                <p><?php echo  unsanitize_string($sel_updates_project1['updateDescription']);?></p>
                                
								<div class="comment" id="updt-comment-container-<?php echo $sel_updates_project1['updatenumber']; ?>">
								<?php
									$tot_updt_coment_res = $con->recordselect("SELECT * FROM `projectupdatecomment` WHERE `projectId` = '".$_GET['project']."' AND updatecommentstatus=1 AND updatenumber ='".$sel_updates_project['updatenumber']."' ORDER BY updateCommentTime DESC");
									$tot_updt_coment = mysql_num_rows($tot_updt_coment_res);
										
									$sel_updateProjectComment1 = $con->recordselect("SELECT * FROM `projectupdatecomment` WHERE `projectId` = '".$_GET['project']."' AND updatecommentstatus=1 AND updatenumber ='".$sel_updates_project['updatenumber']."' ORDER BY updateCommentTime DESC".$comment_limit);
                                    
									while ( $sel_updateProjectComments1 = mysql_fetch_assoc($sel_updateProjectComment1) ) {
										
										$sel_updateCommentUsr1=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_updateProjectComments1['userId']."'"));		
								?>
                                		<div class="comment_box backgrndnone">
                                            <a href="<?php echo SITE_URL.'profile/'.$sel_updateCommentUsr1['userId'].'/'.Slug($sel_updateCommentUsr1['name']).'/'; ?>">
												<?php 
                                                $check_usr123proimg=str_split($sel_updateCommentUsr1['profilePicture80_80'], 4);
                                                if($sel_updateCommentUsr1['profilePicture80_80']!='' && $sel_updateCommentUsr1['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_updateCommentUsr1['profilePicture80_80']) && $check_usr123proimg[0]=='imag') { ?>
                                                	<img src="<?php echo SITE_URL.$sel_updateCommentUsr1['profilePicture']; ?>" alt="<?php echo $sel_updateCommentUsr1['name']; ?>" title="<?php echo $sel_updateCommentUsr1['name']; ?>">
                                                <?php } else if($sel_updateCommentUsr1['profilePicture80_80']!='' && $sel_updateCommentUsr1['profilePicture80_80']!=NULL && $check_usr123proimg[0]=='http') { ?>
                                                	<img  src="<?php echo $sel_updateCommentUsr1['profilePicture']; ?>" alt="<?php echo $sel_updateCommentUsr1['name']; ?>" title="<?php echo $sel_updateCommentUsr1['name']; ?>">
                                                <?php } else { ?>
                                                	<img width="80" height="80" src="<?php echo NOIMG2; ?>" alt="<?php echo $sel_updateCommentUsr['name']; ?>" title="<?php echo $sel_updateCommentUsr1['name']; ?>">
                                                <?php } ?>
                                          	</a>
                                            <a href="<?php echo SITE_URL.'profile/'.$sel_updateCommentUsr1['userId'].'/'.Slug($sel_updateCommentUsr1['name']).'/'; ?>">
												<?php echo unsanitize_string(ucfirst($sel_updateCommentUsr1['name'])); ?>
                                            </a> 
                                            <h6><a href="javascript:void(0);">About <?php $update_comment_time1=$sel_updateProjectComments1['updateCommentTime'];	echo ago($update_comment_time1); ?></a></h6>
                                            <p><?php echo $sel_updateProjectComments1['updateComment']; ?></p>
                                            <div class="clear"></div>
                                        </div>
                                
                                <?php }//While Over ?>
                                </div>
								<div class="space10"></div>
								<?php if($tot_updt_coment > $perpage) { ?>
                                <div id="dv_comment_b">
                                    <center class="post-btn float-left">
                                        <div class="morelink">
                                            <input type="hidden" id="hidden_val_comment_b_<?php echo $sel_updates_project1['updatenumber']; ?>" value="<?php echo $perpage; ?>">
                                            <input type="hidden" id="hidden_curr_page_comment_b_<?php echo $sel_updates_project1['updatenumber']; ?>" value="0">
                                            <a href="javascript:;" class="load_post_comments" data-for="comment_b" data-number="<?php echo $sel_updates_project1['updatenumber']; ?>" data-project="<?php echo $sel_updates_project1['projectId']; ?>">Get More Comments...</a>
                                        </div>
                                    </center>
                                    <div class="space10"></div>
                                </div>
                                <?php } ?>
                                    
                                <?php if(isset($_SESSION['userId']) && ($count_backers > 0 || $sel_projectcreater['userId']==$_SESSION['userId'])) { ?>
                                    <script type="text/javascript">
									$(document).ready(function() {
										$("#frm_userupdate_comment_<?php echo $sel_updates_project['updatenumber']; ?>").validate({
											rules: {
												projectupdate_comment: { required: true, maxlength:255 }
											},
											messages: {
												projectupdate_comment: {
													required: 'Please Enter comment',
													maxlength: "Accepted only 255 characters"
												}
											}
										});
									});
									</script>
                                    <form method="post" action="<?php echo SITE_URL;?>browseproject/<?php echo $_GET['project']; ?>/&update=<?php echo $sel_updates_project1['updatenumber']; ?>#update/" name="frm_userupdate_comment" id="frm_userupdate_comments1">								
                                        <textarea id="projectupdate_comment1" onKeyUp="countCharPrjUpCmt(this)" name="projectupdate_comment1" ></textarea>
                                        <div id="charNumPrjUpCmt">255</div>
                                        <input type="hidden" name="updatenumber1" value="<?php echo  $sel_updates_project1['updatenumber'];?>" />
                                        <input name="submitProjectUpdateComment1" type="submit" value="Post Comment" />							
                                    </form>

                                <?php } ?>
                                
								<?php if($_SESSION["userId"]!=$sel_projectcreater['userId']) { ?>
                                    <?php if(isset($_SESSION['userId'])) { ?>
                                        <input type="hidden" value="Ask the project creator" id="dialogaskcreater1" />
                                        <h6>Only backers can post comments. If you have a question,<a class="ask-creater" href="javascript:void(0)" onClick="return sendmessage(document.getElementById('dialogaskcreater1').value);" > ask the project creator.</a></h6>
                                    <?php } else { ?>
                                    	<!--<h6><a class="ask-creater-for-comment" href="javascript:void(0)" onClick="return chkloginforcomment();">Leave a comment (for backers only)</a></h6>-->
                                    <?php }  
									}?>
   							
								</div>
						<?php  } ?>
                    </div>
					
					<?php
                    if($total_updt > $perpage) { ?>
                    <div id="dv_b">
                        <center class="post-btn float-right">
                            <div class="morelink">
                                <input type="hidden" id="hidden_val_b" value="<?php echo $perpage; ?>">
                                <input type="hidden" id="hidden_curr_page_b" value="1">
                                <a href="javascript:;" id="load_updates" class="" data-for="b">Get More Updates...</a>
                            </div>
                        </center>
                        <div class="space10"></div>
                    </div>
                    <?php } ?>
                    
				</div>
                    
                    <div class="tab_right">
    					
                        <div class="top">
        				  <h1><?php echo $sel_backers_count['total3']; ?></h1>
                          <p>backers</p>
                          					  
                           <h1> $<?php echo number_format($sel_pro_basic['rewardedAmount']); ?></h1>
                          <p>pledged of $<?php echo (isset($sel_pro_basic['fundingGoal']) && (is_numeric($sel_pro_basic['fundingGoal']))) ? number_format($sel_pro_basic['fundingGoal']) : ''; ?> goal</p>
                                                    
                          <h1><?php echo roundDays($left_days);?></h1>
                          <p>days to go</p>
						
                       <!-- back button not for creator(new change) starts-->
                       
							
							<?php if($left_days!=0 && $sel_pro_basic['fundingStatus'] != 'n') { ?>
                              
                              <div class="button">	
                                  <?php if(empty($_SESSION['userId']) || $_SESSION['userId']=='') { ?>
                                      <a title="Back This Project" href="javascript:void(0)" onClick="return chkloginforcomment();" >
                                        <h4>Back This Project</h4>
                                        <h6 class="text_center">$1 Minimum Pledge</h6>
                                      </a>
                                  <?php } else { ?>
                                      <a title="Back This Project" href="<?php echo $base_url;?>projectBacker/<?php echo sanitize_string($_GET['project']).'/'.Slug($sel_pro_basic['projectTitle']).'/';?>">
                                        <h4>Back This Project</h4>
                                        <h6 class="text_center">$1 Minimum Pledge</h6>
                                      </a>
                                  <?php } ?>
                              </div>
                            <?php } ?>
                          
                       <!-- back button not for creator(new change) ends-->
                               
							<?php
                            if($left_days!=0){ ?>
								<?php /*?>if($sel_pro_basic['rewardedAmount']>$sel_pro_basic['fundingGoal']){?>
                           		<p class="special">This project will be funded on <?php echo  date('l M d\, h:ia ', $sel_pro_basic['projectEnd']);  ?>EDT.</p>
                            <?php } else {<?php */?> 
                             <p class="special">This project will only be funded if at least $<?php echo number_format((isset($sel_pro_basic['fundingGoal']) && is_numeric($sel_pro_basic['fundingGoal'])) ? $sel_pro_basic['fundingGoal'] : 0); ?> is pledged by <?php echo  date('l M d\, h:ia ', $sel_pro_basic['projectEnd']);  ?>EDT.</p>
                                
                            <?php /*}*/								
                            } else {
									
								if($sel_pro_basic['rewardedAmount']>0)
								{
									if($sel_pro_basic['rewardedAmount']>=$sel_pro_basic['fundingGoal']) { ?>
                                        <center class="project-pledged-successful">Funding Successful</center>

                                        <p class="special">This project successfully raised its funding goal on <?php echo  date('l M d', $sel_pro_basic['projectEnd']);  ?>.</p>
								<?php } else { ?>
                                        <center class="project-pledged-unsuccessful">Funding Unsuccessful</center>
                                        <p class="special">This project reached the deadline without achieving its funding goal on <?php echo  date('l M d', $sel_pro_basic['projectEnd']);  ?>.</p>
								<?php	}
								}
                            }
                            ?>
                          
                          <!--For make update button starts..  -->
                         <?php  $sel_creator=mysql_fetch_array($con->recordselect("SELECT * FROM projects WHERE projectId='".$_GET['project']."'")); 
						 		if($sel_creator['userId'] == $_SESSION["userId"] && $sel_creator['published']==1 && $sel_creator['accepted']==1 && $left_days!=0) {
									
						 ?>
                            <div class="button">	
                                 <a href="<?php echo SITE_URL ;?>projectupdate/<?php echo $_GET['project'].'/'.Slug($sel_pro_basic['projectTitle']).'/'; ?>">
                                        <h4 class="text_center" style="line-height:44px;">Make Update</h4>
                                      </a>
                                 </div> 
                         <?php } ?>       
                       <!--For make update button ends ..  -->
                     
                     
                       </div>
                        
                        <?php 
							$sel_rewards=$con->recordselect("SELECT * FROM projectrewards WHERE projectId='".$_GET['project']."' ORDER BY pledgeAmount ASC");
							while ($sel_reward = mysql_fetch_assoc($sel_rewards))
							{
                        ?>
                                <div class="bottomest <?php if($left_days>0 && $_SESSION["userId"] != $sel_pro['userId']) { echo 'clickable'; } ?>" 
                                <?php if($_SESSION['userId']!= $sel_pro['userId']) { ?>    
									<?php if($left_days != 0 ) {
												if($_SESSION["userId"]!=$sel_pro['userId']) { 
									?> 
                                    onClick = "return chklogin('<?php echo $_SESSION["userId"]; ?>',<?php echo $sel_reward['rewardId']; ?>,<?php echo $sel_reward['projectId']; ?>);"
                                     <?php 		} else { ?> 
                                     onMouseDown="return usrerredirect(<?php echo $sel_reward['rewardId']; ?>);" 
									 <?php 		} 
											} ?>
                                   <?php } ?> >
                                    <h2>PLEDGE $<?php echo number_format($sel_reward['pledgeAmount']); ?> OR MORE</h2>
                                    <?php
                                    $sel_subbckers = mysql_fetch_assoc($con->recordselect("SELECT `backingId` , `rewardId` , `projectId` , `userId` , `pledgeAmount` , `backingTime`, COUNT(`projectId`) FROM `projectbacking` WHERE `projectId` ='".$sel_reward['projectId']."' AND `rewardId` ='".$sel_reward['rewardId']."' GROUP BY `projectId`"));
                                    if (is_array($sel_subbckers) && !array_key_exists('total',$sel_subbckers)) $sel_subbckers['total'] = 0;
									if (empty($sel_subbckers['total'])) $sel_subbckers['total'] = 0;
									?>
                                    <h4 style="clear:both;"><?php echo $sel_subbckers['total']; ?> Times Pledged</h4>
                                    <h3><?php echo $sel_reward['description']; ?></h3>
                                    <p>Estimated Delivery: <span><?php echo date('M',mktime(0, 0, 0, $sel_reward['estimateDeliveryMonth'], 10))." ".$sel_reward['estimateDeliveryYear']; ?></span></p>
                                </div>
                            <?php
                            }//While Over Pledge  
						?>                       
                        
                        <div class="profile">
							<div class="profile_left">
                            
                            <a href="<?php echo SITE_URL.'profile/'.$sel_pro['userId'].'/'.Slug($sel_pro_user['name']).'/'; ?>">
                                <?php 
                                $check_usrimg001 = str_split($sel_pro_user['profilePicture100_100'], 4);
                                if($sel_pro_user['profilePicture100_100']!='' && $sel_pro_user['profilePicture100_100']!=NULL  && file_exists(DIR_FS.$sel_pro_user['profilePicture100_100']) && $check_usrimg001[0]=='imag') { ?>
                                    <img src="<?php echo SITE_URL.$sel_pro_user['profilePicture100_100']; ?>" alt="Profile image" title="<?php echo $sel_pro_user['name'] ?>"  />
                                <?php } else if($sel_pro_user['profilePicture100_100']!='' && $sel_pro_user['profilePicture100_100']!=NULL && $check_usrimg001[0]=='http') { ?>
                                    <img src="<?php echo $sel_pro_user['profilePicture100_100']; ?>" alt="Profile image" title="<?php echo $sel_pro_user['name'] ?>"  />
                                <?php } else { ?>
                                    <img width="80" height="80" src="<?php echo NOIMG2; ?>" alt="Profile image" title="<?php echo $sel_pro_user['name'] ?>"  />
                                <?php } ?>
                            </a>
							</div>
							<div class="profile_right">
                            <p>Project by</p>
                            
                            <a title="<?php echo unsanitize_string(ucfirst($sel_pro_user['name'])); ?>" href="<?php echo SITE_URL.'profile/'.$sel_pro['userId'].'/'.Slug($sel_pro_user['name']).'/'; ?>">
								<?php echo unsanitize_string(ucfirst($sel_pro_user['name'])); ?>
                            </a>
                            <p class="location"><span><img src="<?php echo SITE_IMG; ?>location-mid.png" /></span><?php echo unsanitize_string(ucfirst($sel_pro_user['userLocation'])); ?></p>
                              
							<?php if($_SESSION["userId"] != $sel_projectcreater['userId']) { ?>
                            <h6>
                                <?php if(isset($_SESSION['userId'])) { ?>
                                    <input type="hidden" value="Send Message" id="dialogsendmsg2" />
                                    <a title="Contact Me" href="javascript:void(0)" class="remote_modal_dialog" onClick="return sendmessage(document.getElementById('dialogsendmsg2').value);"><span class="icon"></span>Contact Me</a>
                                <?php } else { ?>
                                    <a title="Contact Me" href="javascript:void(0)" class="remote_modal_dialog" onClick="return chkloginforcomment();"><span class="icon"></span>Contact Me</a>
                                <?php } ?>
                            </h6>
                            <?php } ?>
                            
                            <?php if($_SESSION["userId"] != $sel_projectcreater['userId']) { ?>
                            <h6>
                                <?php if(isset($_SESSION['userId'])) { ?>
                                    <input type="hidden" value="Send Message" id="dialogsendmsg2" />
                                    <a title="Biography" href="javascript:void(0)" class="modal_show" id="popup_bio"><span class="icon"></span>Biography</a>
                                <?php } else { ?>
                                    <a title="Biography" href="javascript:void(0)" class="remote_modal_dialog" onClick="return chkloginforcomment();"><span class="icon"></span>Biography</a>
                                <?php } ?>
                            </h6>
                            <?php } ?>                     
                            </div>
                            <div class="clear"></div>
                            <ul>
                              <li>
                                <?php $sel_usersbackedproject=mysql_fetch_array($con->recordselect("SELECT count( DISTINCT `projectId` ) AS totalbacked FROM `projectbacking` WHERE `userId` ='".$sel_pro['userId']."'")); ?>
                                
                                <a href="<?php echo SITE_URL.'profile/'.$sel_pro['userId'].'#c/'; ?>" >
                                	Backed project (<?php echo $sel_usersbackedproject['totalbacked']; ?>)
                                </a>
                              </li>                          
                              <?php if(mysql_num_rows($website_res)<=0 && !isset($sel_pro['userId']) && isset($_SESSION['userId'])) {
                                    //echo "<a href='".SITE_URL."profile/edit/?website'>Add websites</a>";
                                } else { ?>
                                <b>Website:</b><br/>  
								<?php
                                while ($website_res_field = mysql_fetch_assoc($website_res))
                                {
                                echo "<a title='".$website_res_field['siteUrl']."' target='_blank' href=".$website_res_field['siteUrl'].">".$website_res_field['siteUrl']."</a><br/>";
								}?>
                            <?php } ?>
                            	<br/>
                            </ul>
						</div>
                        <div class="clear"></div>
                        <?php if($_SESSION["userId"] == $sel_projectcreater['userId']) { ?>
                            <div class="socailbutton">
                                
                            </div>
                    	<?php } ?>        
					</div>
                    
                    
                    <div id="e" class="tabs_left"><!--id="reviews"-->
						
                        
						<?php if($_SESSION["userId"] != $sel_projectcreater['userId'] && $sel_userreview_count['tot'] < 1) { ?>
                            <div class="ask-project-creater">
								<?php // if(isset($_SESSION['userId'])) { ?>
                                    <input type="hidden" value="Ask the project creator" id="dialogaskcreater2" />
                                    <span>Only backers can post reviews. If you have a question,<a class="ask-creater" href="javascript:void(0)" onClick="return sendmessage(document.getElementById('dialogaskcreater2').value);" > ask the project creator.</a></span>
                                <?php // } else { ?>
                                    <!--<span><a class="ask-creater-for-comment" href="javascript:void(0)" onClick="return chkloginforcomment();">Leave a comment (for backers only)</a></span>-->
                                <?php // } ?>
                            </div>
                        <?php } ?>
                    		<div class="review" id="dv-reviews">
						<?php
						if($sel_pro['userId'] == $_SESSION["userId"]){
							$sel_userreview = $con->recordselect("SELECT * FROM `projectreview` WHERE `projectId` = '".$_GET['project']."' ORDER BY created_date DESC".$rec_limit);
						}else {
							$sel_userreview = $con->recordselect("SELECT * FROM `projectreview` WHERE `projectId` = '".$_GET['project']."' AND reviewstatus=1 ORDER BY created_date DESC".$rec_limit);
						}
						while ($sel_review = mysql_fetch_assoc($sel_userreview)) {
								$sel_users=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId` = '".$sel_review['userId']."'"));
						?>
                            <div class="comment_box first">
								<div class="comment_box_left">
                                <a href="<?php echo SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_users['name']).'/'; ?>">
									<?php 
                                    $check_usrcmt1=str_split($sel_users['profilePicture80_80'], 4);
                                    if($sel_users['profilePicture80_80']!='' && $sel_users['profilePicture80_80']!=NULL  && file_exists(DIR_FS.$sel_users['profilePicture80_80']) && $check_usrcmt1[0]=='imag') { ?>
                                   		<img src="<?php echo SITE_URL.$sel_users['profilePicture80_80']; ?>" class="avatar-thumb" alt="<?php echo $sel_users['name']; ?>" title="<?php echo $sel_users['name']; ?>">
                                    <?php } else if($sel_users['profilePicture80_80']!='' && $sel_users['profilePicture80_80']!=NULL && $check_usrcmt1[0]=='http') { ?>
                                    	<img src="<?php echo $sel_users['profilePicture80_80']; ?>" class="avatar-thumb" alt="<?php echo $sel_users['name']; ?>" title="<?php echo $sel_users['name']; ?>">
                                    <?php } else { ?>
                                    	<img width="80" height="80" src="<?php echo NOIMG2; ?>" class="avatar-thumb" alt="<?php echo $sel_users['name']; ?>" title="<?php echo $sel_users['name']; ?>">
                                    <?php } ?>
                                </a>
								</div>
								<div class="comment_box_right">
                                <a href="<?php echo SITE_URL.'profile/'.$sel_users['userId'].'/'.Slug($sel_users['name']).'/'; ?>">
									<?php echo unsanitize_string(ucfirst($sel_users['name'])); ?>
                                </a>
                                <h6><?php $new_time = $sel_review['created_date'];	echo ago($new_time); ?> </h6> 
								<div class="clear"></div>	
                                <p><?php echo $sel_review['review']; ?></p> <?php if($sel_pro['userId'] == $_SESSION["userId"]) { 
								if($sel_review['reviewstatus']=='0') {
								?> <p><a href="javascript:void(0);" onClick="return changereviewStatus('<?php echo $sel_review['reviewId']; ?>','on')" title="Click here to accept review">Accept</a></p> 
								<?php }
								else if($sel_review['reviewstatus']=='1'){ ?>
								<p><a href="javascript:void(0);" onClick="return changereviewStatus('<?php echo $sel_review['reviewId']; ?>','off')" title="Click here to reject review">Reject</a></p> 
								<?php }} ?>
                                <div class="clear"></div>
								</div>
                            </div>
                        
                        <?php } ?>
                        	</div>
                    	<div class="space10"></div>
						<?php if($total_reviews > $perpage) { ?>
                            <div id="dv_d">
                                <center class="post-btn float-left">
                                    <div class="morelink">
                                        <input type="hidden" id="hidden_val_e" value="<?php echo $perpage; ?>">
                                        <input type="hidden" id="hidden_curr_page_e" value="0">
                                              <a href="javascript:void(0);" id="load_reviews" class="" data-for="e">Load More Reviews...</a>
                                        <!--<a href="javascript:;" id="load_comments" class="" data-for="e">Load More Reviews...</a>-->
                                    </div>
                                </center>
                                <div class="space10"></div>
                            </div>
                        <?php } ?>
                        <div class="space10"></div>
						<?php if(isset($_SESSION['userId']) && ($count_backers > 0)) { ?>
                            <form method="post" action="<?php echo SITE_URL;?>browseproject/<?php echo $_GET['project']; ?>/" name="user_review" id="frm_user_reviews">								
                                <textarea class="input-textarea-review"  id="user_review" name="user_review" onKeyUp="countChar2(this)"  ></textarea>
                                <br/>
                                <div id="charNum2">255</div>
                                <input class="button-comment" name="submitUserReview" type="submit" value="Post Review" />							
                            </form>	
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            </div>
        </div><!--wrapper Over -->
        <div class="clear"></div>
   </div><!--tab Over -->
</section>

<script type="text/javascript">
$(document).ready(function () {
	$("#load_comments").click(function() {
		var $load_comments = $(this);
		var load_for = $load_comments.attr("data-for");
		var load_rec = parseInt($("#hidden_val_"+load_for).val());
		var curr_page = parseInt($("#hidden_curr_page_"+load_for).val());
		var per_page 		= parseInt(<?php echo $perpage; ?>)
		try {
			$.ajax({
				type		:	"POST",
				dataType	:	"json",
				url			:	"<?php echo SITE_URL; ?>ajax.browseproject.php",
				data		:	{
									get_project		:	'<?php echo $get_project; ?>',
									ses_user		:	'<?php echo $ses_user; ?>',
									active_tab		:	load_for,
									per_page		:	per_page,
									load_rec		:	load_rec,
									curr_page		:	curr_page
								},
				success		:	function(data) {
									if(data["status"] == 200) {
										var found_rec = parseInt(data["total_rec"]);
										if( found_rec > 0) {	
											
											$("#dv-comments").append(data["html_content"]);
											
											load_rec += parseInt(data["total_rec"]);
											
											$("#hidden_val_"+load_for).val(load_rec);
											$("#hidden_curr_page_"+load_for).val(data["curr_page"]);
											
											if ( found_rec < per_page ) {
												$load_comments.remove();
											}
										}
										else {
											$load_comments.remove();
										}
									} else {
										console.log("Error in #load_comments ajax response - " + data["msg"]);
									}
								}
			});
		} catch(e) {
			console.log("Error in #load_comments - " + e);
		}
	});
	$("#load_reviews").click(function() {
		var $load_comments = $(this);
		var load_for = $(this).attr("data-for");
		var load_rec = parseInt($("#hidden_val_"+load_for).val());
		var curr_page = parseInt($("#hidden_curr_page_"+load_for).val());
		
		var per_page 		= parseInt(<?php echo $perpage; ?>)
		
		try {
			$.ajax({
				type		:	"POST",
				dataType	:	"json",
				url			:	"<?php echo SITE_URL; ?>ajax.browseproject.php",
				data		:	{
									get_project		:	'<?php echo $get_project; ?>',
									ses_user		:	'<?php echo $ses_user; ?>',
									active_tab		:	load_for,
									per_page		:	per_page,
									load_rec		:	load_rec,
									curr_page		:	curr_page,
									procreator_id   :   '<?php echo $sel_pro['userId']; ?>'
								},
				success		:	function(data) {
									if(data["status"] == 200) {
										var found_rec = parseInt(data["total_rec"]);
										if( found_rec > 0) {	
											
											$("#dv-reviews").append(data["html_content"]);
											
											load_rec += parseInt(data["total_rec"]);
											
											$("#hidden_val_"+load_for).val(load_rec);
											$("#hidden_curr_page_"+load_for).val(data["curr_page"]);
											
											if ( found_rec < per_page ) {
												$("#load_reviews").remove();
											}
										}
										else {
											$("#load_reviews").remove();
										}
									} else {
										console.log("Error in #load_comments ajax response - " + data["msg"]);
									}
								}
			});
		} catch(e) {
			console.log("Error in #load_reviews - " + e);
		}
	});
	$("#load_backers").click(function() {
		var $load_backers = $(this);
		var load_for = $load_backers.attr("data-for");
		var load_rec = parseInt($("#hidden_val_"+load_for).val());
		var curr_page = parseInt($("#hidden_curr_page_"+load_for).val());
		var per_page 		= parseInt(<?php echo $perpage; ?>)
		
		try {
			$.ajax({
				type		:	"POST",
				dataType	:	"json",
				url			:	"<?php echo SITE_URL; ?>ajax.browseproject.php",
				data		:	{
									get_project		:	'<?php echo $get_project; ?>',
									ses_user		:	'<?php echo $ses_user; ?>',
									active_tab		:	load_for,
									per_page		:	per_page,
									load_rec		:	load_rec,
									curr_page		:	curr_page
								},
				success		:	function(data) {
									if(data["status"] == 200) {
										var found_rec = parseInt(data["total_rec"]);
										if( found_rec > 0) {	
											$("#div-backers").append(data["html_content"]);
											
											load_rec += parseInt(data["total_rec"]);
											
											$("#hidden_val_"+load_for).val(load_rec);
											$("#hidden_curr_page_"+load_for).val(data["curr_page"]);
											
											if ( found_rec < per_page ) {
												$load_backers.remove();
											}
										}
										else {
											$load_backers.remove();
										}
									} else {
										console.log("Error in #load_backers ajax response - " + data["msg"]);
									}
								}
			});
		} catch(e) {
			console.log("Error in #load_backers - " + e);
		}
	});
	$("#load_updates").click(function() {
		
		var $load_updates 	= $(this);
		var load_for 		= $load_updates.attr("data-for");
		var load_rec 		= parseInt($("#hidden_val_"+load_for).val());
		var curr_page 		= parseInt($("#hidden_curr_page_"+load_for).val());
		var per_page 		= parseInt(<?php echo $perpage; ?>)
		
		try {
			$.ajax({
				type		:	"POST",
				dataType	:	"json",
				url			:	"<?php echo SITE_URL; ?>ajax.browseproject.php",
				data		:	{
									count_backers	:	'<?php echo $count_backers; ?>',
									get_updates		:	'<?php echo $get_updates; ?>',
									get_project		:	'<?php echo $get_project; ?>',
									ses_user		:	'<?php echo $ses_user; ?>',
									active_tab		:	load_for,
									per_page		:	per_page,
									load_rec		:	load_rec,
									curr_page		:	curr_page
								},
				success		:	function(data) {
									if(data["status"] == 200) {
										var found_rec = parseInt(data["total_rec"]);
										if( found_rec > 0) {
											
											$("#div-updates").append(data["html_content"]);
											
											load_rec += parseInt(data["total_rec"]);
											
											$("#hidden_val_"+load_for).val(load_rec);
											$("#hidden_curr_page_"+load_for).val(data["curr_page"]);
											
											if ( found_rec < per_page ) {
												$load_updates.remove();
											}
										} else {
											$load_updates.remove();
										}
									} else {
										console.log("Error in #load_updates ajax response - " + data["msg"]);
									}
								}
			});
		} catch(e) {
			console.log("Error in #load_updates - " + e);
		}
	});
	$(".load_post_comments").live("click",function() {
		var $load_comments 	= $(this);
		var load_for 		= $load_comments.attr("data-for");
		var updatenumber	= $load_comments.attr("data-number");
		var project_id		= $load_comments.attr("data-project");
		var load_rec 		= parseInt($("#hidden_val_"+load_for+"_"+updatenumber).val());
		var curr_page 		= parseInt($("#hidden_curr_page_"+load_for+"_"+updatenumber).val());
		var per_page 		= parseInt(<?php echo $perpage; ?>);
		
		try {
			$.ajax({
				type		:	"POST",
				dataType	:	"json",
				url			:	"<?php echo SITE_URL; ?>ajax.browseproject.php",
				data		:	{
									project_id		:	project_id,
									updatenumber	:	updatenumber,
									/*get_updates		:	'<?php //echo $get_updates; ?>',*/
									get_updates		:	updatenumber,
									get_project		:	'<?php echo $get_project; ?>',
									ses_user		:	'<?php echo $ses_user; ?>',
									active_tab		:	load_for,
									per_page		:	per_page,
									load_rec_comment:	load_rec,
									curr_page_comment:	curr_page
								},
				success		:	function(data) {
									if(data["status"] == 200) {
										var found_rec = parseInt(data["total_rec"]);
										if( found_rec > 0) {
											
											$("#updt-comment-container-"+updatenumber).append(data["html_content"]);
											
											load_rec += parseInt(data["total_rec"]);
											
											$("#hidden_val_"+load_for+"_"+updatenumber).val(load_rec);
											$("#hidden_curr_page_"+load_for+"_"+updatenumber).val(data["curr_page"]);
											
											if ( found_rec < per_page ) {
												$load_comments.remove();
											}
										} else {
											$load_comments.remove();
										}
									} else {
										console.log("Error in #load_updates ajax response - " + data["msg"]);
									}
								}
			});
		} catch(e) {
			console.log("Error in #load_updates - " + e);
		}
	});
	
	
});
//for changing status of review..
	function changereviewStatus(reviewId,status)
	{
		//alert('hi');
		window.location = "browseproject.php?reviewId="+reviewId+"&status="+status+"";
		
	}
</script>
