<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/ui.geo_autocomplete.js"></script>
<link type="text/css" href="<?php echo SITE_CSS; ?>jquery-ui-1.8.20.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo SITE_JAVA; ?>jquery-ui-1.8.20.custom.min.js"></script>
<!--<link rel="stylesheet" href="<?php //echo SITE_CSS; ?>jquery.tagbox.css" />-->
<script type="text/javascript" src="<?php echo SITE_JAVA; ?>jquery.tagbox.js"></script>

<script type="text/javascript">
jQuery(function() {
  jQuery("#jquery-tagbox-text").tagBox();      
});
function entername()
{
	document.getElementById('web_arror').innerHTML="";
}
</script>

<script language="javascript">
$(document).ready(function() {
	<?php if(isset($_GET['website'])) { ?>
		$(".tagBox-input").focus();
	<?php } ?>
	$.validator.addMethod("AlphaNumRegex", function(value, element) {
		return this.optional(element) || /^[a-z0-9\_-]+$/i.test(value);
	}, "This must contain only letters, numbers, underscore or dashes.");
	
	$.validator.addMethod("validpassword", function(value, element) {
	    return value.match(new RegExp(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).*$/g));
		}, 
		"The password must contain a minimum of one lower case character," + " one upper case character and one digit");
		
	/*$.validator.addMethod("validpassword", function(value, element) {
    return this.optional(element) ||
        /.*(?=.*[a-z])(?=.*[A-Z])(?=.*[\d]).*$/i.test(value);
}, "The password must contain a minimum of one lower case character," +
           " one upper case character, one digit");*/

	$("#frmCP").validate({
		rules: {
            username: { required: true,minlength: 3,maxlength: 25 },
			location_name: { required: true },
            biography: { maxlength: 300 },
            website: { url: true }
		},
		messages: {
            username: {
				required: "<?php echo ER_USER;?>",
				minlength: "Name should be atleast 3 characters long",
				maxlength: "Name should not be more than 25 characters long"
			},
			location_name: {
				required: "Please enter Location<br>"
			},
			biography: {
				maxlength: "Biography should not be more than 300 characters long"
			},
			website: {
				url: "<div class='clear'></div>Please enter a valid URL"
			}
		}
	});
	$('#user_location_name').geo_autocomplete();
	
	/*$("#frmchgpass").submit(function(){
		alert('submit');
	});*/

	$("#frmchgpass").validate({
		rules: {           
            newpasswd: { minlength: 6,validpassword: true },
            confpasswd: { equalTo: "#newpasswd" }
		},
		messages: {            
			newpasswd: {
				minlength: "Enter Password atleast 6. characters long",
				validpassword: "The password must contain a minimum of <br>one lower case character,<br> one upper case character and one digit"				
			},
			confpasswd: {
                equalTo: "<?php echo ER_SAMEPSW;?>"
			}
		}
	});
	$("#frm_deleteaccount").validate({
		rules: {
            for_passwd: { required: true,equalTo:"#passwd" }
		},
		messages: {
			for_passwd: {
				required: "Please Enter Password",
				equalTo: "Please Enter a valid Password"
			}
		}
	});
	
    $(function(){
    	$("#cng_pass_hide1").hide();
		$('.show_hide').click(function(){
			$("#cng_pass_hide1").slideToggle();
		});
    });
});
</script>
<script language="javascript">
function load_image()
{
var imgpath = document.getElementById('user_photo').value;

	if(imgpath != "")
	{
		// code to get File Extension..
		var arr1 = new Array;
		arr1 = imgpath.split("\\");
		var len = arr1.length;
		var img1 = arr1[len-1];
		var filext = img1.substring(img1.lastIndexOf(".")+1);
		// Checking Extension
		if(filext == "jpg" || filext == "jpeg" || filext == "pjpeg")
			document.getElementById('user_photo').src = imgpath;
		else
		{
			document.getElementById('user_photo').value = "";
			document.getElementById('user_photo').focus();
			document.getElementById("photo_valid").innerHTML="Invalid File Format Selected!";
			return false;
		}
	}
}
$(function() {
	 $('#dialog_link1').click(function(){
	$( "#dialog" ).dialog({ resizable: false, minHeight:200,
	 open: function(event, ui){ 
			$(this).parents(".ui-dialog:first").find(".ui-widget-header")
				.addClass("ui-widget-header-custom");
		} });
	 return false;
	 });		 
});

//tab
$(document).ready(function(e) {
	var tab_name= location.hash;
	if(tab_name=='' || typeof(tab_name)==='undefined')
	{
		tab_name='#profile_';
	}
	
  $(".tab_box").click(function(){
    $(".tab_box").removeClass("activated");
	$(this).addClass("activated");
  });
  $(".fadeinoutdivs").fadeOut(1);
  $("#profile").fadeIn(1);
  $("#profile_tab").click(function(){
	 window.location.hash="profile_";
  	$(".fadeinoutdivs").fadeOut(1);
	$("#profile").fadeIn(1);
  });
  $("#account_tab").click(function(){
	   window.location.hash="account_";
  	$(".fadeinoutdivs").fadeOut(1);
	$("#Account").fadeIn(1);
  });
  $("#paypal_tab").click(function(){
	   window.location.hash="paypalaccount_";
  	$(".fadeinoutdivs").fadeOut(1);
	$("#PaypalAccount").fadeIn(1);
  });
  $("#notification_tab").click(function(){
	   window.location.hash="notification_";
  	$(".fadeinoutdivs").fadeOut(1);
	$("#Notification").fadeIn(1);
  });
  $(tab_name+"tab").trigger("click");
});
</script>
<!--delete account popup start-->
<div id="dialog" title="Delete Account" class="popup-hide">
	<form name="frm_deleteaccount" action="<?php echo SITE_URL; ?>profile/edit/" method="post" id="frm_deleteaccount">
		<p>Enter your <?php echo DISPLAYSITENAME; ?> password for verification:</p>
		<div>
        <?php $sel_passwd = mysql_fetch_assoc($con->recordselect("SELECT * FROM users where userId='".$_SESSION['userId']."' LIMIT 1")); ?>
        <input type="hidden" name="passwd" id="passwd" value="<?php echo base64_decode($sel_passwd['password']); ?>" />
		<input type="password" id="for_passwd" name="for_passwd" class="input-text" size="35">
		<div class="space10"></div>
		<input class="button-neutral submit width170 save11" name="submit_deleteacc"  type="submit" value="Delete Account" />
		<div class="space10"></div>
		</div>		
	</form>
</div>
<!--delete account popup end -->
<section id="container">
   <div id="edit_setting" class="head_content temp">
       <h3>Edit Setting</h3>
   </div>
   <div class="wrapper">
   		<div id="tabs_divs">
            <div id="profile_tab" class="tab_box activated">
                <h4>Profile</h4>
            </div>
            <div id="account_tab" class="tab_box">
                <h4>Account</h4>
            </div>
            <div id="paypal_tab" class="tab_box">
                <h4>Paypal Account</h4>
            </div>
            <div id="notification_tab" class="tab_box">
                <h4>Notifications</h4>
            </div>
       </div>
	
   	   <div id="profile" class="fadeinoutdivs">
    	<form action="<?php echo SITE_URL; ?>profile/edit/" method="post" name="frmCP" id="frmCP" enctype="multipart/form-data">
            <input class="hidden" id="view" name="view" type="hidden" value="profile" />
            	<?php /*?><div class="fieldset-errors fieldset-errors-editpofile">
			                <?php if($error!=""){ ?>
			                <?php print $error; ?>
			                <?php } ?>
			                <?php if($_GET["msg"]=="EDIT"){ ?>
					        <?php echo constant($_GET['msg']); ?>
			                <?php } ?>
			           </div><?php */?>
               
            <div id="left_attributes">
                <div class="attribute_box">
                        <h6>Name</h6>
                       <input id="user_name" name="username" size="43" type="text" value="<?php echo unsanitize_string($result['name']); ?>" />
                        <p>Your name is displayed on your profile.</p>
                        <div class="clear"></div>
                </div>                
                <div class="attribute_box">
                    <h6>Location</h6>
                   	<input class="input-search" id="user_location_name" name="location_name" size="43" maxlength="30" type="text" value="<?php echo unsanitize_string($result['userLocation']); ?>" />
                    <p>Simply type your location, e.g. Brooklyn, NY or Los Angeles, CA.</p>
                    <div class="clear"></div>
               </div>
                <div class="attribute_box">
                    <h6>Time Zone</h6>
                       <select name="time_zone">
                           <?php FOREACH($timezones AS $let=>$word){ ?>
                                    <option value="<?php echo $let; ?>" <?php if($let==$result['timezone']) echo 'selected' ?> > <?php echo $word ?> </option>
                            <?php } ?>
                        </select>
                    <div class="clear"></div>
               </div>
                <div class="attribute_box">
                    <h6>Biography</h6>
                    <textarea class="" cols="40" id="user_biography" name="biography" rows="20"><?php echo unsanitize_string($result['biography']); ?></textarea>
                    <p>We suggest a short bio. If it's 300 characters or less it'll look great on your profile.</p>
                    <div class="clear"></div>
               </div>
               
               <div class="attribute_box">
                    <h6>Websites</h6>
                    <input type="text" id="jquery-tagbox-text" class="website" />
                    <span class="input-tip">
						<table class="tbl-website-width tbl-website" width="79%" align="right">
								<?php
								while ($website_res_field = mysql_fetch_assoc($website_res))
								{
									echo "<tr><td>";
									echo "<font size='2'>".$website_res_field['siteUrl']."</font>";
									echo "</td><td>";
								?>
                                <?php //href="deletewebsite.php?siteid=<?php print $website_res_field['siteId'];  ?>
								<font size="2">
                                	<a 
                                    onclick="return confirm('Are you sure you want to delete?');" 
                                    href="<?php echo SITE_URL; ?>deletewebsite/<?php print $website_res_field['siteId'];?>/"
                                    title='Remove Website' class="remove">Delete</a>
                                </font>
								</td></tr>
								<?php }
								?>
								</table>
					</span>
                   
                    <div class="clear"></div>
               </div>
               
               <div id="last" class="attribute_box">
                    <input class="save" type="submit" name="submitEditprofile"  value="Save Settings" />
               </div>
                
            </div>
            <div id="right_attributes">
             <?php if(isset($error3) && ($error3!="")){ ?>
			                <?php echo $error3; ?>
			                <?php } ?>
			                <?php if(isset($_GET) && isset($_GET['msg3']) && (($_GET["msg3"]=="ER_IMGADD") || ($_GET["msg3"]=="ER_IMGRMV"))) { ?>
					        <?php echo constant($_GET['msg3']); ?>
			                <?php } ?>
            	<div class="attribute_box">
                    <h6>Picture</h6>
                    <div class="upload removeable" >
                    <?php 
										
						$check_proimg=str_split($result['profilePicture'], 4);
						if($result['profilePicture']!=NULL && $result['profilePicture']!= '' && file_exists(DIR_FS.$result['profilePicture']) && $check_proimg[0]=='imag') { ?>
						<a href="<?php echo SITE_URL; ?>profile/edit/"><img src="<?php echo SITE_URL.$result['profilePicture']; ?>" alt="Profile image" title="<?php echo $result['name'] ?>"  /></a>
						<?php }else if($result['profilePicture']!=NULL && $result['profilePicture']!= '' && $check_proimg[0]=='http') {?>
						<a href="<?php echo SITE_URL; ?>profile/edit/"><img src="<?php echo $result['profilePicture']; ?>" alt="Profile image" title="<?php echo $result['name'] ?>"  /></a>
						<?php }else{?>
						<a href="<?php echo SITE_URL; ?>profile/edit/"><img src="<?php echo NOIMG; ?>" alt="Profile image" title="<?php echo $result['name'] ?>" height="200" width="200"  /></a>
						<?php }?>			  
						<br>
						<?php if($result['profilePicture']!=NULL && $result['profilePicture']!= '') { ?>
						<a title="Remove Profile Image" class="remove" onclick="return confirm('Are you sure you want to delete?')" href="<?php echo SITE_URL ;?>remove_image/<?php echo $result['userId']; ?>">
						Remove
						</a><?php } ?>
                                        
                                  </div>
                                  <?php if($result['profilePicture']==NULL || $result['profilePicture']=='') { ?>
                    <input type="file" value="Upload" class="avatar file" onclick="this.focus()" onblur="return load_image();" id="user_photo" name="photo" /> <label id="photo_valid" class="edit-profile-image-valid"></label>
                    			<?php } ?>
                                <div class="clear"></div>
                </div>
            </div>
    	</form>
    
	</div>
    
    	<div id="Account" class="fadeinoutdivs" style="display:none;">
        <form action="<?php echo SITE_URL; ?>profile/edit/" method="post" name="frmchgpass" id="frmchgpass" enctype="multipart/form-data">
       	   <div id="left_attributes">
               <div class="attribute_box">
                    <h6>Email</h6>
                    <input class="input-text textgray" id="useremail" name="useremail" size="35" type="text" readonly="readonly" value="<?php echo base64_decode($result['emailAddress']); ?>" />
                    <div class="clear"></div>
               </div>
               <div class="attribute_box">
                    <h6>Password</h6>
                    <a href="javascript:void(0)" class="show_hide">Change Password</a>
                    <div class="clear"></div>
               </div>
               <div id="cng_pass_hide1" class="popup-hide1">
                   <div class="attribute_box">
                        <h6>New Password</h6>
                       <input class="input-text errornewpassword" id="newpasswd" name="newpasswd" size="35" type="password" value="" />
                        <div class="clear"></div>
                   </div>
                   <div class="attribute_box">
                        <h6>Confirm Password </h6>
                        <input class="input-text" id="confpasswd" name="confpasswd" size="35" type="password" value="" />
                        <div class="clear"></div>
                   </div>	
				</div>
               <div id="last" class="attribute_box">
                    <!--<input id="save" type="button" value="Save Settings" />-->
                    <input class="button-save submit" name="submitaccset" type="submit" value="Save Settings" id="save" />
               </div>
           </div>
           <div id="right_attributes">
               <div id="Delete_account" class="attribute_box">
                    <h6>Delete Account</h6>
                    <a title="Delete My <?php echo DISPLAYSITENAME; ?> Account" href="javascript:void(0)" id="dialog_link1" >Delete My <?php echo DISPLAYSITENAME; ?> Account</a>
                    <div class="clear"></div>
               </div>
           </div>
        </form>
       </div>
       
       <div id="PaypalAccount" class="fadeinoutdivs" style="display:none;">
        <form action="" method="post" name="getverifiedstatus" id="getverifiedstatus">
       	   <div id="left_attributes">
               <div class="attribute_box">
                    <h6>Email</h6>
                    <input class="input-text textgray" id="paypalemail" name="paypalemail" size="35" type="text" value="<?php echo base64_decode($result['paypalUserAccount']); ?>" />
                    <div class="clear"></div>
               </div>
               <div class="attribute_box">
                    <h6>First Name</h6>
                   <input class="input-text errornewpassword" id="paypalfname" name="paypalfname" size="35" type="text" value="<?php echo $result['paypalFname']; ?>" />
                    <div class="clear"></div>
               </div>
               <div class="attribute_box">
                    <h6>Last Name </h6>
                    <input class="input-text" id="paypallname" name="paypallname" size="35" type="text" value="<?php echo $result['paypalLname']; ?>" />
                    <div class="clear"></div>
               </div>	
               
               <div id="last" class="attribute_box">
                    <!--<input id="save" type="button" value="Save Settings" />-->
                    <input class="button-save submit" name="submitverifiedstatus" type="submit" value="Verify your Account" id="add_account" />
               </div>
           </div>
           <div id="right_attributes">
               
           </div>
        </form>
       </div>
       
       <div id="Notification" class="fadeinoutdivs" style="display:none">
        <form method="post" id="edit_user_notification" class="edit_user_notification" action="<?php echo SITE_URL; ?>profile/edit/" accept-charset="UTF-8">
       		<div class="attribute_box">
            	<h6>Weekly newsletter</h6> 
                <input type="checkbox" value="1" name="send_newsletters" id="user_send_newsletters" class="checkbox" <?php if($result['newsletter']==1) { echo 'checked="checked"';} ?>>
                <h5> I'd like to receive the weekly newsletter</h5>      
            </div>
            <div class="attribute_box">
            	<h6>Notify me by email when</h6>   
                <input type="checkbox" value="1" name="notify_of_friend_activity" id="user_notify_of_friend_activity" class="checkbox" <?php if($result['lanuchProjectNotify']==1) { echo 'checked="checked"';} ?>>
                <h5> Someone I follow backs or launches a project </h5>  
                <div class="clear"></div>    
               
                <h5> I get new followers (daily digest) </h5> 
                 <input type="checkbox" value="1" name="notify_of_follower" id="user_notify_of_follower" class="checkbox float_right" <?php if($result['newFollower']==1) { echo 'checked="checked"';} ?>>    
                
                <h5> Projects I've created receive new pledges </h5> 
               <input type="checkbox" value="1" name="notify_of_pledges" id="user_notify_of_backings" class="checkbox float_right" <?php if($result['pledgeMail']==1) { echo 'checked="checked"';} ?> >    
                
                <h5> Projects I've created receive new comments</h5>
                 <input type="checkbox" value="1" name="notify_of_comments" id="user_notify_of_comments" class="checkbox float_right" <?php if($result['createdProjectComment']==1) { echo 'checked="checked"';} ?> >
                 
                   <h5>Projects I'm backing post new updates</h5>
                 <input type="checkbox" value="1" name="notify_of_updates" id="user_notify_of_updates" class="checkbox float_right" <?php if($result['updatesNotifyBackedProject']==1) { echo 'checked="checked"';} ?>>
                <div class="clear"></div>     
                
            </div>
            <div id="last" class="attribute_box">
                     <input type="submit" value="Save Settings" name="submitNotification" class="button-save submit save1">
            </div>
           </form>
       </div>
       
    </div>
    
    <div style="display:none">
    <div id="tabs-3">
    	<div id="content-wrap">
            <div id="content_notification" class="content_notification">
                <form method="post" id="edit_user_notification" class="edit_user_notification" action="<?php echo SITE_URL; ?>profile/edit/" accept-charset="UTF-8">
                <fieldset>
                <ol>
                <li>
                <label>Weekly newsletter</label>
                <div class="fieldset-indent">
                <fieldset>
                <input type="checkbox" value="1" name="send_newsletters" id="user_send_newsletters" class="checkbox" <?php if($result['newsletter']==1) { echo 'checked="checked"';} ?>>
                <label for="user_send_newsletters" class="checkbox">I'd like to receive the weekly newsletter</label>
                </fieldset>
                </div>
                </li>
                <li>
                <label>Notify me by email when</label>
                <div class="fieldset-indent">
                <fieldset>
                <input type="checkbox" value="1" name="notify_of_friend_activity" id="user_notify_of_friend_activity" class="checkbox" <?php if($result['lanuchProjectNotify']==1) { echo 'checked="checked"';} ?>>
                <label for="user_notify_of_friend_activity" class="checkbox">Someone I follow backs or launches a project</label>
                <hr>
                </fieldset>
                <fieldset>
                <input type="checkbox" value="1" name="notify_of_follower" id="user_notify_of_follower" class="checkbox" <?php if($result['newFollower']==1) { echo 'checked="checked"';} ?>>
                <label for="user_notify_of_follower" class="checkbox">I get new followers (daily digest)</label>
                <hr>
                </fieldset>
                <fieldset>
                <input type="checkbox" value="1" name="notify_of_pledges" id="user_notify_of_backings" class="checkbox" <?php if($result['pledgeMail']==1) { echo 'checked="checked"';} ?> >
                <label for="user_notify_of_backings" class="checkbox">Projects I've created receive new pledges</label>
                </fieldset>
                <hr>
                <fieldset>
                <input type="checkbox" value="1" name="notify_of_comments" id="user_notify_of_comments" class="checkbox" <?php if($result['createdProjectComment']==1) { echo 'checked="checked"';} ?> >
                <label for="user_notify_of_comments" class="checkbox">Projects I've created receive new comments</label>
                </fieldset>
                <hr>
                <fieldset>
                <input type="checkbox" value="1" name="notify_of_updates" id="user_notify_of_updates" class="checkbox" <?php if($result['updatesNotifyBackedProject']==1) { echo 'checked="checked"';} ?>>
                <label for="user_notify_of_updates" class="checkbox">Projects I'm backing post new updates</label>
                </fieldset>
                </div>
                </li>
                </ol>
                </fieldset>
                <div class="form-submit-notification">
                <input type="submit" value="Save Settings" name="submitNotification" class="button-save submit save">
                </div>
                </form>
            </div>
            <!-- #content -->
         </div>
         <!-- tabs-3 end -->
    </div>
    </div>
</div>
</section>