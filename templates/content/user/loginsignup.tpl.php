 <link type="text/css" href="<?php echo SITE_CSS; ?>jquery-ui-1.8.20.custom.css" rel="stylesheet" />

<script type="text/javascript" src="<?php echo SITE_JAVA; ?>jquery-ui-1.8.20.custom.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<!--for facebook php SDK-->
<script type="text/javascript"  src="<?php print SITE_JAVA;?>oauthpopup.js"></script>
<!--for facebook php SDK-->
<script type="text/javascript"  language="javascript">
<!--for facebook php SDK-->
$(document).ready(function() {
/*
	$('.btn-facebook').click(function(e){
		e.preventDefault();
        $.oauthpopup({
            path: '<?php echo SITE_MOD_USER."fb/login.php";?>',
			width:600,
			height:300,
            callback: function(){
                window.location.reload();
            }
        });
		e.preventDefault();
    });
*/
	  var appId = '836466059717946'; // crowdedrocket.com - production site
	  if (window.location.hostname == 'emptyrocket.com') appId = '329614567212154'; // test site
      window.fbAsyncInit = function() {
        FB.init({		
          'appId'      : appId,
          'xfbml'      : false,
		  'cookie'     : true,  
          'version'    : 'v2.1'
        });
      };

	$(function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
		
	$('.btn-facebook').click(function(e){
		e.preventDefault();
		FB.login(function(response) {
		  if (response.status === 'connected') {
			// Logged into your app and Facebook.
			console.log("connected via facebook");
			// redrive w/ token to get fb session
			window.location.href = '/login/?token='+response.authResponse.accessToken;

		  } else if (response.status === 'not_authorized') {
			// The person is logged into Facebook, but not your app.
			console.log("facebook says not authorized");
			alert("Sorry. Cannot proceed according to Facebook.");
		  } else {
			// The person is not logged into Facebook, so we're not sure if
			// they are logged into this app or not.
			console.log("not logged into facebook nor into the app");
			alert("Unable to login via Facebook");
		  }
		}, {scope:'public_profile,email,user_friends'}); 
	});
	
	$(function() {
		$('#dialog_link').click(function(){
			$( "#dialog" ).dialog({ 
				resizable: false ,
				open: function(event, ui){ 
					$(this).parents(".ui-dialog:first").find(".ui-widget-header")
					.addClass("ui-widget-header-custome");
				}
			});
			return false;
		});
	});
	/*
	$(function() {
		 $('#dialog_link1').click(function(){
		 $( "#dialog1" ).dialog({
			resizable: false,
			open: function(event, ui){ 
				$(this).parents(".ui-dialog:first").find(".ui-widget-header")
				.addClass("ui-widget-header-custome");
			} });
		 return false;
		 });
	});
	*/

	$("#user_email").focus();
	<?php
		if(isset($_GET['signup']))
		{
			echo "$('#user_name').focus();";
		}
	?>
	$.validator.addMethod("validpassword", function(value, element) {
	    return value.match(new RegExp(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).*$/g));
		}, 
		"The password must contain a minimum of one lower case character," + " one upper case character and one digit");
	$("#frmCP1").validate({
		rules: {
            emailid: { required: true, email:true },
			passwd: { required: true }
		},
		messages: {
			emailid: {
				required: "<?php echo ER_EMAIL;?>",
				email: 'Please enter a valid email address'
			},
			passwd: {
				required: "<?php echo ER_PSW;?>"				
			}
		}
	});

	$("#frmCP2").validate({
		rules: {
            username: { required: true,minlength: 4,maxlength: 25 },
            emailid: { required: true,email: true },
			passwd: { required: true,minlength: 6, maxlength: 25, validpassword:true },
			cpasswd: {
				required: true,
				equalTo: "#user_password1"
			},
			captcha: {
				required: true,
				remote:"<?php echo SITE_URL;?>modules/user/user_ajax.php"}
		
		},
		messages: {
            username: {
				required: "<?php echo ER_USER;?>",
				minlength: "Name should be atleast 3 characters long",
				maxlength: "Name should not be more than 25 characters long"
			},
			emailid: {
				required: "<?php echo ER_EMAIL;?>",
				email: "Please enter a valid email address"
			},
			passwd: {
				required: "<?php echo ER_PSW;?>",
				minlength: "Enter Password atleast 6 characters long",
				maxlength: "Password should not be more than 25 characters long",
				validpassword: "The password must contain a minimum of one lower case character. one upper case character and one digit"
			},
			cpasswd: {
                required: "<?php echo ER_CPSW;?>",
                equalTo: "<?php echo ER_SAMEPSW;?>"
			},
			captcha:{remote:"Captcha code is not valid"}
		}
		
	});

    $("#frm_forgotpass").validate({
		rules: {
            for_email: { required: true,email:true }
		},
		messages: {
			for_email: {
				required: "<?php echo ER_EMAIL;?>",
				email: "Please enter a valid email address"
			}
		}
	});
	$("#for_email").keypress(function(event) {
		if (event.which == 13) {
			$("#frm_forgotpass").submit();
		}
	});
	
});
</script>
	
<!--forgot password popup start-->
<div id="dialog" title="Forgot Password ?" class="hide">
	<form name="frm_forgotpass" action="<?php echo SITE_URL; ?>login/" method="post" id="frm_forgotpass">
        <p>Tell us the email you used to sign up and we'll get you logged in.</p>
        <center>
		<div class="ie7input">
        <input type="text" id="for_email" name="for_email" class="input-text" size="35">
		<div class="space10"></div>
		</div>
        <input class="button-neutral submit width170" name="submit_forgotpass"  type="submit" value="Reset My Password" />
        </center>		
	</form>
</div>
<!--forgot password popup end -->

<!--Terms of use popup start
<div id="dialog1" title="Terms Of Use" class="hide">
	<p>Terms Of Use</p>
	<br>
	<br>
</div>
--Terms of use popup end-->

<div class="flclear"></div>

<div id="content-main">  
  <!--start-content-->
  <section id="container">
    <div class="wrapper">
      	<div class="signup-main">
			
            <div class="signupbox">
            <!--LogIN div start-->
				<div class="heading">
					<h3>Log in</h3>
					<p>Please log in to continue.</p>
				</div>
                <form action="<?php echo SITE_URL; ?>login/" method="post" name="frmCP1" id="frmCP1">
                	<input type="hidden" name="passvalue" id="passvalue" value="<?php print (isset($passwd)) ? $passwd : ''; ?>" />
                    <input type="hidden" name="parentUrl" id="parentUrl" value="<?php print (isset($_GET['parentUrl']) && ($_GET['parentUrl']!='')) ? $_GET['parentUrl'] : ''; ?>" />
                    <div class="fieldset-errors">
                        <?php if (!isset($error1)) $error1 = ''; ?> 
						<?php if($error1!=""){ ?>
                        <?php print $error1; ?>
                        <?php } ?>
                        <?php if(isset($_GET) && isset($_GET["msg"]) && ($_GET['msg'] =="CHANGEPSW")){ ?>
                        <?php echo constant($_GET['msg']); ?>
                        <?php } ?>
                    </div>
                    
					<?php
					if(isset($_COOKIE) && isset($_COOKIE['rememberme']) && ($_COOKIE['rememberme'] =="1")){
						
						if(isset($_COOKIE['emailid'])){
							$qry1=$con->recordselect("SELECT * FROM users WHERE emailAddress='".base64_encode($_COOKIE['emailid'])."' LIMIT 1 ");
							if(mysql_num_rows($qry1) > 0){
								$valid_user = mysql_fetch_array($qry1);
								$passWd = base64_decode($valid_user['password']);
							}
						}
					}
					?>
                    <div class="inputfield">
                        <p>Email</p>
                        <input class="input-text" id="user_email" name="emailid" type="text" size="30" tabindex="1" value="<?php if(isset($_COOKIE) && isset($_COOKIE['emailid']) && ($_COOKIE['emailid'] !="")){echo $_COOKIE['emailid'];}else {echo "";} ?>" />
                    </div>
                    <div class="inputfield">
                        <div><div class="float-left">Password</div> <span class="span"><a href="javascript:void(0)" id="dialog_link" >Forgot password?</a></span></div>
                        <input class="input-text password" id="user_password" size="30" name="passwd" tabindex="2" type="password" value="<?php if(isset($passWd) && ($passWd!="")){echo $passWd;}else {echo "";} ?>">
                    </div>
                    <div class="inputfield chec'kbox">
                        <input <?php if(isset($_COOKIE) && isset($_COOKIE['rememberme']) && ($_COOKIE['rememberme']=="1")){echo "checked=checked";} ?> class="checkbox" id="remember" name="rememberme" tabindex="3" type="checkbox"  value="1">
                        <div class="float-left">Remember Me</div>
                    </div>
                    <div class="inputfield">
                        <input name="submitLogin" tabindex="4" type="submit" value="Log Me In!">
                    </div>   
                </form>                
			</div>
            <!--LogIN div end-->
            
			<?php
			$hidden = '';
			$readonly = '';
			if (isset($_SESSION['fbuser']) && !empty($_SESSION['fbuser']['name'])) {
				$hidden = 'style="display:none;"';
				$readonly = 'readonly';
			}	
			?>
			
			<div class="signupbox">
            <!--Signup div start-->
				<div class="heading">
					<h3>New to <?php echo DISPLAYSITENAME; ?>?</h3>
					<?php
						if (!empty($hidden)) {
							echo "<p style='color:#ed2121;'>Choose a password for your ".DISPLAYSITENAME." account.</p>";
						} else {
							echo "<p>A ".DISPLAYSITENAME." account is required to continue.</p>";
						}
					?>				
				</div>
                <form action="<?php echo SITE_URL; ?>login/" method="post" name="frmCP2" id="frmCP2">
                	<input type="hidden" name="passvalue" id="passvalue" value="<?php print (isset($passwd)) ? $passwd : ''; ?>" />
                    <div class="fieldset-errors">
						<?php if (!isset($error)) $error = ''; ?>
						<?php if($error!=""){ ?>
						<?php print $error; ?>
						<?php } ?>
						<?php if(isset($_GET) && isset($_GET["msg1"]) && ($_GET['msg1'] =='REGSUS')){ ?>
						<?php echo constant($_GET['msg1']); ?>
						<?php } ?>
					</div>
                    <?php
						$username = (isset($_REQUEST['username'])) ? $_REQUEST['username'] : '';
						$emailaddress = (isset($_REQUEST['emailid'])) ? $_REQUEST['emailid'] : '';
						if (empty($username) && isset($_SESSION['fbuser']) && !empty($_SESSION['fbuser']['name'])) {
							$username = $_SESSION['fbuser']['name'];
						}
						if (empty($emailaddress) && isset($_SESSION['fbuser']) && !empty($_SESSION['fbuser']['email'])) {
							$emailaddress = $_SESSION['fbuser']['email'];
						}
						if (empty($emailaddress) && isset($_SESSION['prelaunch_email']) && !empty($_SESSION['prelaunch_email'])) {
							$emailaddress = $_SESSION['prelaunch_email'];
							unset($_SESSION['prelaunch_email']);
						}
					?>
                    <div class="inputfield">
                        <p>Name</p>
                        <input class="input-text" title="4 to 25 alpha-numeric characters" id="user_name" name="username" size="30" tabindex="4" type="text" value="<?php echo $username; ?>" <?php echo $readonly; ?> />
                    </div>
                    <div class="inputfield">
                        <p>Email</p>
                        <input class="input-text ajax[ajaxUserCallPhp2]]" id="user_email1" onblur="return onchangeemail(this.value);" name="emailid" size="30" tabindex="5" type="text" value="<?php echo $emailaddress; ?>" <?php echo $readonly; ?> /><br>
						<label id="email_valid" class="email-check-ajax"></label>
                        <p>Used for project and account notifications.</p>
                    </div>
                    <div class="inputfield">
                        <p>Password</p>
                        <input class="input-text password" id="user_password1" name="passwd" size="30" tabindex="6" type="password" />
                    </div>
                    <div class="inputfield">
                        <p>Re-Enter Password</p>
                        <input class="input-text password1" id="user_password_confirmation" size="30" name="cpasswd" tabindex="7" type="password" />
                    </div>
					<?php if (empty($hidden)) { ?>
						<div class="inputfield" >
							<p>Captcha</p>
								<input name="captcha" id="captcha" type="text" class="small"  tabindex="8">
						</div>
						<div class="inputfield" >
								<img id="imgCaptcha" src="<?php echo SITE_URL; ?>includes/capcha/random.php" height="25" alt="Captcha Code" border="0" class="fl"/>
								<a href="javascript:void(0)" onclick="document.getElementById('imgCaptcha').src='<?php echo SITE_URL; ?>includes/capcha/random.php?'+Math.random();$('#captcha').focus();$('#captcha').val('');" id="change-image" ><img id="changeCaptcha" src="<?php echo SITE_URL; ?>images/captcha-ref.jpg" alt="Captcha Refresh" border="0" class="fl" /></a>
						</div>
                    <?php } ?>
                    <div class="inputfield checkbox" style="padding-top:20px;">
                    	<input class="hidden" name="user[send_newsletters]" type="hidden" value="0" />
                        <input checked="checked" class="checkbox" id="user_send_newsletters" name="txtTerms" tabindex="8" type="checkbox" value="1" />
                        <div class="float-left"><strong>Discover New Projects</strong></div>
                        <p>With Our Weekly Newsletter</p><br>
						<?php /* In the following line sel_ContentPage is set for terms of service by loginsignup.php */ ?>
                        <!-- <p>By signing up, you agree to our <a href="<?php echo SITE_URL.'content/'.$sel_ContentPage['id'].'/'.Slug($sel_ContentPage['title']).'/' ;?>" target="_blank">terms of use</a>.</p> -->
                    </div>
                    <div class="inputfield">
                        <input name="submitSignup" tabindex="8" type="submit" value="Sign Me Up!">
                    </div>
                </form>
			</div>
            <!--Signup div end-->
                       
			<div class="signupbox" <?php echo $hidden; ?>>
            <!--Facebook div start-->
				<div class="heading">
					<h3>Sign in with Facebook</h3>
					<p>&nbsp;</p>
					<div class="facebook-button">
                    <a class="btn-facebook">
                    	<img src="<?php echo SITE_IMG_SITE ?>facebook-connect-button.png" alt="Facebook Login">
                    </a>
                    </div>

				</div>
			</div>
			<!--Facebook div end-->
		</div>
    </div>
  </section>
  <!--End-content--> 
</div>

<div class="flclear"></div>

<script type="text/javascript">

function onchangeemail(email)
{
	if (email) {
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url1 = url.substring(0, xend);
		url="user_ajax/user_email/"+email;
		var sentUrl =application_path+url;
		if (url.substring(0, 4) != 'http')
		{
			url = base_url1 + url;			
		}
		var strSubmit="user_email1="+email;
		var strURL = sentUrl;
		var strResultFunc = "emailavable";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;
	}
}

function emailavable(strIn)
{
	if(strIn=='1')
	{
    	document.getElementById("email_valid").innerHTML="That email address is already registered.";
    	//document.getElementById('user_email1').value="";
		//document.getElementById('user_email1').focus();
		return false;
	}
	else
	{
        document.getElementById("email_valid").innerHTML="";
	}
}
</script>