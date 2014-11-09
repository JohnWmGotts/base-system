<?php
	require_once("includes/config.php");
	////////////////////////////////////////////////////////////////////////////////////////////////
	/// WHEN READY TO OPEN SITE TO THE PUBLIC CHANGE /includes/config.php to $prelaunch=false //////
	////////////////////////////////////////////////////////////////////////////////////////////////
	$domain = $_SERVER['SERVER_NAME'];
	$site_name = (stristr($domain,'emptyrocket')!==false) ? 'EmptyRocket' : 'CrowdedRocket';
	$userip = get_ip_address1();	
	$rand8 = substr(time(),-8,8);
	$referral_url = 'https://'.$domain.'/index1.php';
	$title = 'Launching great companies : CrowdedRocket';
	$description = 'A new approach to crowdfunding!';
	
	//Facebook App Id and Secret
	if ($_SERVER['SERVER_NAME'] == 'emptyrocket.com') {
		$fbappid = '329614567212154';						// emptyrocket test - put these in config
		$fbsecret = 'e86b3b2055f2dd105343ea277c82913c';		//
	} else {
		$fbappid = '836466059717946';						// crowdedrocket - put these in config
		$fbsecret = '6b9a7a48b3709b002be3686c5b809ebc';		//
	}	
	
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/"
      xmlns:fb="http://developers.facebook.com/schema/" xml:lang="en_US" lang="en_US" class="" >
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=8" >
<meta name="description" content="<?php echo $description; ?>" />
<meta name="keywords" content="crowdfunding crowd funding startups investment rewards ownership" />
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:description" content="<?php echo $description; ?>" />
<meta property="og:image:secure_url" content="https://<?php echo $domain; ?>/images/site/frontpage-logo.png" />
<meta property="og:image" content="/images/site/frontpage-logo.png" />
<link rel="icon" href="/images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon" />
<meta name="generator" content="https://<?php echo $domain; ?>/" />

<script type="text/javascript" src="https://<?php echo $domain; ?>/includes/javascript/jquery.js" ></script>
<script type="text/JavaScript" src="https://<?php echo $domain; ?>/includes/javascript/jquery-1.7.1.min.js"></script>
<script type="text/JavaScript" src="https://<?php echo $domain; ?>/includes/javascript/jquery.validate.js"></script>
<script type="text/javascript" src="https://<?php echo $domain; ?>/includes/javascript/jquery.watermark.js"></script>
<script type="text/javascript" src="https://<?php echo $domain; ?>/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script type="text/javascript" src="https://<?php echo $domain; ?>/js/lmcbutton.js"></script>
<?php if(isset($browser) && $browser=='IE' && $curveyCornerFlag==1){ ?>
	<script type="text/javascript" language="javascript">
        var curveyCornerFlag = 0;
    </script>
<?php } else { ?>
	<script type="text/javascript" language="javascript">
       	var curveyCornerFlag = 1;	
    </script>   
<?php } ?>
<script type="text/javascript" src="https://<?php echo $domain; ?>/includes/javascript/custom.js"></script>
<script type="text/javascript">
<?php 
	$kibitz = "enter email for launch notification";
?>
var input_watermark = "<?php echo $kibitz; ?>";
$(document).ready(function(){	

	$("#email").Watermark(input_watermark,"#999");
	
	if (window.outerWidth < 1200) {
		$("img#front_bgd").attr("src", "/images/site/frontpage_mobile.png");
	} else {
		$("img#front_bgd").attr("src", "/images/site/frontpage.png");
	}
});

function submit_email() {
	if ($('#email').val() == input_watermark) {
		//alert('Enter your email address');
		$('#alert').html('Enter your email address');
		$('#alert').css({'display':'block'});
		return;
	} 
	if (!isValidEmailAddress($('#email').val())) {
		//alert('Enter a valid email address');
		$('#alert').html('Enter a valid email address');
		$('#alert').css({'display':'block'});
		return;
	}
	$.Watermark.HideAll();
	$.ajax({
		type: 'POST',
		url: "prelaunch_signup.php",
		data: {
			email: encodeURIComponent($('#email').val())
		},
		success: function(msg) 
		{
			//alert(msg);
			$('#alert').html(msg);
			$('#alert').css({'display':'block'});
		}
	});
};
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};
</script>

<link rel="stylesheet" href="css/rrssb.css" />
<style>
#front_bgd { width:100%;overflow:hidden; }
#main_div { position:absolute;top:36%;left:0;z-index:100;width:100%;overflow:hidden;text-align:center;font-family:Arial; }
@media only screen and (min-device-width : 320px) and (max-device-width : 960px) and (orientation:portrait) {	
	#main_div { top:12%; }		
}
#semimain_div {  width:100%;text-align:center; }
#front_logo { width:53%; }
#center_container { width:100%;margin-top:16px;text-align:center; }
#signup_container { width:444px;text-align:center; }
#form_content { height:38px;width:448px;padding:0px;}
#email { width:310px;height:28px;background-color:#d2d2d2;color:#999;font-size:20px;text-align:center;border:none; }
#submit { width:86px;height:24px;padding-left:1px;padding-top:3px;margin-top:8px;background-color:#4a9cf8;color:white;font-size:18px;text-align:center;border:none;cursor:pointer; }
#buttons_outer { text-align:center;width:100%;max-width:198px;margin-top:16%; }
#email_button { position:relative;top:-3px;width:60px;background-color:white;height:18px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px; }
#email_button a { font-size:12px;text-decoration:none;position:relative;top:-2px; }
@media screen and (-webkit-min-device-pixel-ratio:0) {
    #email_button a { top:0px; }
	#buttons_outer { margin-top:10%; }
}
#facebook_button { position:relative;top:-2px; }
</style>

<script>
	// added for fb share btn but didn't work
	//window.fbAsyncInit = function() {
  //      FB.init({
  //        appId      : '<?php echo $fbappid; ?>',
  //        xfbml      : true,
  //        version    : 'v2.1'
  //      });
  //};	
	
	(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=<?php echo $fbappid; ?>&version=v2.1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<!-- twitter -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<!-- google+ -->
<script src="https://apis.google.com/js/platform.js" async defer></script>

</head>
<body>
<!-- facebook -->
<div id="fb-root"></div>

<center>
	<img id="front_bgd" />
	<div id="main_div" >
		<div id="semimain_div" >
			<img id="front_logo" src="/images/site/front-logo.png" />
			<center>	
				<div id="center_container" >
					<center>
						
						<?php 
						$disperr = 'none';
						if (isset($_SESSION['msgType']) && !empty($_SESSION['msgType'])) { 
							$disperr = 'block';
						?>
						<div id="errormsg" style="text-align:center;color:#000;display:<?php echo $disperr; ?>;">
							<?php echo disMessage($_SESSION['msgType']); ?>	
						</div>
						<?php } ?>
						<div id="alert" style="text-align:center;color:#000;display:none;"></div>
						<div id="signup_container" >
							<form id="prelaunch_signup" >
							   <center>
								  <div id="form_content" >
									  <input type="text" id="email" name="email" value="<?php echo $kibitz; ?>" />
								  </div>
								  <div id="submit" onclick="submit_email()" >
									LAUNCH							  
								  </div>
							   </center>
							</form>
						</div>
						<div id="buttons_outer" >
								<ul id="button_list" class="rrssb-buttons clearfix">
									<li class="rrssb-email">
										<!-- Replace subject with your message using URL Endocding: http://meyerweb.com/eric/tools/dencoder/ -->
										<a href="mailto:?subject=Check%20out%20<?php echo urlencode($site_name); ?>&amp;body=<?php echo urlencode($referral_url); ?>" title="Share via Email">
											<span class="rrssb-icon">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve"><g><path d="M20.111 26.147c-2.336 1.051-4.361 1.401-7.125 1.401c-6.462 0-12.146-4.633-12.146-12.265 c0-7.94 5.762-14.833 14.561-14.833c6.853 0 11.8 4.7 11.8 11.252c0 5.684-3.194 9.265-7.399 9.3 c-1.829 0-3.153-0.934-3.347-2.997h-0.077c-1.208 1.986-2.96 2.997-5.023 2.997c-2.532 0-4.361-1.868-4.361-5.062 c0-4.749 3.504-9.071 9.111-9.071c1.713 0 3.7 0.4 4.6 0.973l-1.169 7.203c-0.388 2.298-0.116 3.3 1 3.4 c1.673 0 3.773-2.102 3.773-6.58c0-5.061-3.27-8.994-9.303-8.994c-5.957 0-11.175 4.673-11.175 12.1 c0 6.5 4.2 10.2 10 10.201c1.986 0 4.089-0.43 5.646-1.245L20.111 26.147z M16.646 10.1 c-0.311-0.078-0.701-0.155-1.207-0.155c-2.571 0-4.595 2.53-4.595 5.529c0 1.5 0.7 2.4 1.9 2.4 c1.441 0 2.959-1.828 3.311-4.087L16.646 10.068z"/></g></svg>
											</span>
										</a>
									</li>
									<li class="rrssb-facebook">
										<?php
											$sep = (strpos($referral_url,'?') === false) ? '?' : '&';
											$theurl = $referral_url . $sep . 't=' . time();
											$fburl = 'https://www.facebook.com/dialog/feed?app_id=' . $fbappid . '&link='.urlencode($referral_url).'&picture='.urlencode('https://'.$domain.'/images/site/frontpage-logo.png').'&name='.urlencode($site_name).'&caption='.urlencode($title).'&description='.urlencode($description).'&redirect_uri='.urlencode($theurl);
										?>
										<a href="<?php echo $fburl; ?>" title="Share on Facebook" class="popup">
											<span class="rrssb-icon">
												<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
													<path d="M27.825,4.783c0-2.427-2.182-4.608-4.608-4.608H4.783c-2.422,0-4.608,2.182-4.608,4.608v18.434
														c0,2.427,2.181,4.608,4.608,4.608H14V17.379h-3.379v-4.608H14v-1.795c0-3.089,2.335-5.885,5.192-5.885h3.718v4.608h-3.726
														c-0.408,0-0.884,0.492-0.884,1.236v1.836h4.609v4.608h-4.609v10.446h4.916c2.422,0,4.608-2.188,4.608-4.608V4.783z"/>
												</svg>
											</span>
										</a>
									</li>
									<li class="rrssb-linkedin">
										<!-- Replace href with your meta and URL information -->
										<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($referral_url); ?>&amp;title=<?php echo urlencode($title); ?>&amp;summary=<?php echo urlencode($description); ?>" title="Share on LinkedIn" class="popup">
											<span class="rrssb-icon">
												<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
													<path d="M25.424,15.887v8.447h-4.896v-7.882c0-1.979-0.709-3.331-2.48-3.331c-1.354,0-2.158,0.911-2.514,1.803
														c-0.129,0.315-0.162,0.753-0.162,1.194v8.216h-4.899c0,0,0.066-13.349,0-14.731h4.899v2.088c-0.01,0.016-0.023,0.032-0.033,0.048
														h0.033V11.69c0.65-1.002,1.812-2.435,4.414-2.435C23.008,9.254,25.424,11.361,25.424,15.887z M5.348,2.501
														c-1.676,0-2.772,1.092-2.772,2.539c0,1.421,1.066,2.538,2.717,2.546h0.032c1.709,0,2.771-1.132,2.771-2.546
														C8.054,3.593,7.019,2.501,5.343,2.501H5.348z M2.867,24.334h4.897V9.603H2.867V24.334z"/>
												</svg>
											</span>
										</a>
									</li>
									<li class="rrssb-twitter">
										<!-- Replace href with your Meta and URL information  -->
										<a href="http://twitter.com/home?status=<?php echo urlencode($title); ?>%20<?php echo urlencode($referral_url); ?>" title="Share on Twitter" class="popup">
											<span class="rrssb-icon">
												<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
													 width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
												<path d="M24.253,8.756C24.689,17.08,18.297,24.182,9.97,24.62c-3.122,0.162-6.219-0.646-8.861-2.32
													c2.703,0.179,5.376-0.648,7.508-2.321c-2.072-0.247-3.818-1.661-4.489-3.638c0.801,0.128,1.62,0.076,2.399-0.155
													C4.045,15.72,2.215,13.6,2.115,11.077c0.688,0.275,1.426,0.407,2.168,0.386c-2.135-1.65-2.729-4.621-1.394-6.965
													C5.575,7.816,9.54,9.84,13.803,10.071c-0.842-2.739,0.694-5.64,3.434-6.482c2.018-0.623,4.212,0.044,5.546,1.683
													c1.186-0.213,2.318-0.662,3.329-1.317c-0.385,1.256-1.247,2.312-2.399,2.942c1.048-0.106,2.069-0.394,3.019-0.851
													C26.275,7.229,25.39,8.196,24.253,8.756z"/>
												</svg>
										   </span>
										</a>
									</li>
									<li class="rrssb-googleplus">
										<!-- Replace href with your meta and URL information.  -->
										<a href="https://plus.google.com/share?url=<?php echo urlencode($title); ?>%20<?php echo urlencode($referral_url); ?>" title="Share on Google+" class="popup">
											<span class="rrssb-icon">
												<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
													<g>
														<g>
															<path d="M14.703,15.854l-1.219-0.948c-0.372-0.308-0.88-0.715-0.88-1.459c0-0.748,0.508-1.223,0.95-1.663
																c1.42-1.119,2.839-2.309,2.839-4.817c0-2.58-1.621-3.937-2.399-4.581h2.097l2.202-1.383h-6.67c-1.83,0-4.467,0.433-6.398,2.027
																C3.768,4.287,3.059,6.018,3.059,7.576c0,2.634,2.022,5.328,5.604,5.328c0.339,0,0.71-0.033,1.083-0.068
																c-0.167,0.408-0.336,0.748-0.336,1.324c0,1.04,0.551,1.685,1.011,2.297c-1.524,0.104-4.37,0.273-6.467,1.562
																c-1.998,1.188-2.605,2.916-2.605,4.137c0,2.512,2.358,4.84,7.289,4.84c5.822,0,8.904-3.223,8.904-6.41
																c0.008-2.327-1.359-3.489-2.829-4.731H14.703z M10.269,11.951c-2.912,0-4.231-3.765-4.231-6.037c0-0.884,0.168-1.797,0.744-2.511
																c0.543-0.679,1.489-1.12,2.372-1.12c2.807,0,4.256,3.798,4.256,6.242c0,0.612-0.067,1.694-0.845,2.478
																c-0.537,0.55-1.438,0.948-2.295,0.951V11.951z M10.302,25.609c-3.621,0-5.957-1.732-5.957-4.142c0-2.408,2.165-3.223,2.911-3.492
																c1.421-0.479,3.25-0.545,3.555-0.545c0.338,0,0.52,0,0.766,0.034c2.574,1.838,3.706,2.757,3.706,4.479
																c-0.002,2.073-1.736,3.665-4.982,3.649L10.302,25.609z"/>
															<polygon points="23.254,11.89 23.254,8.521 21.569,8.521 21.569,11.89 18.202,11.89 18.202,13.604 21.569,13.604 21.569,17.004
																23.254,17.004 23.254,13.604 26.653,13.604 26.653,11.89      "/>
														</g>
													</g>
												</svg>
											</span>
										</a>
									</li>
								</ul>
						</div>		
					</center>
				</div>		
			</center>
		</div>	
	</div>
</center>	
</html> 