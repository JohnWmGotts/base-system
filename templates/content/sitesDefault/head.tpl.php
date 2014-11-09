<?php
	$moduletemplate = '';
	if (preg_match('#modules/(.+)?/(.+)?\.php#i', $_SERVER['SCRIPT_NAME'], $match)) {
		$moduletemplate = $match[1].'-'.$match[2];
		if ($moduletemplate == 'staticPages-index') {
			if (isset($_SERVER['SCRIPT_URI']) && preg_match('#/terms/#i',$_SERVER['SCRIPT_URI'])) {
				$moduletemplate .= '-terms';
			}
		}
	}
	
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="en" />
    <meta http-equiv="X-UA-Compatible" content="IE=8" >
<?php if (!isset($meta) || !isset($meta['description'])) {
		if (!preg_match('#index\.php$#',$_SERVER['SCRIPT_NAME'])) {
			// is something special .. not just index.php.. might want to consider adding meta
			wrtlog("meta not defined or not set.. called with ".$_SERVER['SCRIPT_NAME']);
			//fct_show_trace(debug_backtrace(),"backtrace");  
		}
	} else { ?>
    <meta name="description" content="<?php echo $meta['description']; ?>" />
    <meta name="keywords" content="<?php echo $meta['keywords']; ?>" />
<?php } ?> 
	<meta name="generator" content="<?php echo SITE_URL;?>" />
    <?php
	$Currenturl = get_url();
	$Currenturl = explode("/",$Currenturl);
	$curveyCornerFlag = 0;
	if(in_array("createProject",$Currenturl)){		
		$curveyCornerFlag =1;
	}
	$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
	if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
		$browser_version=$matched[1];
		$browser = 'IE';
	}
	?>
   <title><?php print ($title=='home')?'Welcome to '.DISPLAYSITENAME.'':$title." : ".DISPLAYSITENAME.""?></title>
   <link rel="icon" href="<?php echo SITE_IMG; ?>favicon.png" type="image/x-icon" />
   <link rel="shortcut icon" href="<?php echo SITE_IMG; ?>favicon.png" type="image/x-icon" />
   <link href="<?php echo SITE_CSS; ?>style.css" rel="stylesheet" type="text/css" >
   <link href="<?php echo SITE_CSS; ?>msg.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" href="<?php echo SITE_CSS; ?>ui-lightness/jquery.ui.all.css">
	<!--[if IE 7]>
	<link href="<?php echo SITE_CSS; ?>ie7.css" rel="stylesheet" type="text/css">
	<![endif]-->
	<!--[if IE 8]>
	<link href="<?php echo SITE_CSS; ?>ie8.css" rel="stylesheet" type="text/css">
	<![endif]-->
	<noscript><meta http-equiv="refresh" content="1; url=<?php echo $base_url; ?>ScriptError/" /></noscript>
	<script type="text/javascript" src="<?php echo SITE_URL; ?>js/modernizr.custom.92560.js"></script>
    <script src="<?php echo SITE_JAVA; ?>html5shiv.js" type="text/javascript"></script>
	<script src="<?php echo SITE_JAVA; ?>jquery.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="<?php echo SITE_JAVA; ?>jquery-1.7.1.min.js"></script>
	<script type="text/JavaScript" src="<?php echo SITE_JAVA; ?>jquery.validate.js"></script>
	<?php if(isset($browser) && $browser=='IE' && $curveyCornerFlag==1){ ?>
		<script type="text/javascript" language="javascript">
	        var curveyCornerFlag = 0;
        </script>
	<?php } else { ?>
		<script type="text/javascript" language="javascript">
        	var curveyCornerFlag = 1;	
        </script>   
	<?php } ?>
	<script src="<?php echo SITE_JAVA; ?>ui/jquery.ui.core.js"></script>
	<script src="<?php echo SITE_JAVA; ?>ui/jquery.ui.widget.js"></script>
	<script src="<?php echo SITE_JAVA; ?>ui/jquery.ui.position.js"></script>
    <script src="<?php echo SITE_JAVA; ?>custom.js"></script>
    <script type="text/javascript">
		application_path = "<?php echo SITE_URL;?>";
    </script>
    <script type="text/javascript" src="<?php echo SITE_JAVA; ?>jquery.jcarousel.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS; ?>tango/skin.css" />	
    <script>
    <?php
	// For Google Analytics Code
	 if (!preg_match('#emptyrocket#i', SITE_URL)) { // no analytics for emptyrocket.com 
		 $selectQueryAnalytics = mysql_fetch_array($con->recordselect("SELECT * from tbl_analyticscode"));
		 echo $analyticscode = stripslashes($selectQueryAnalytics['analyticscode']); 
	 }     
	 ?>
	</script>
</head>
<body id="<?php echo $moduletemplate; ?>" >
<div id="fb-root"></div>
<!-- replaced below for new crowdedrocket app
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '1445733892307042',                        // App ID from the app dashboard
      status     : true,                                 // Check Facebook Login status
      xfbml      : true                                  // Look for social plugins on the page
    });
    // Additional initialization code such as adding Event Listeners goes here
  };
  // Load the SDK asynchronously
  (function(){
     // If we've already installed the SDK, we're done
     if (document.getElementById('facebook-jssdk')) {return;}
     // Get the first script element, which we'll use to find the parent node
     var firstScriptElement = document.getElementsByTagName('script')[0];
     // Create a new script element and set its id
     var facebookJS = document.createElement('script'); 
     facebookJS.id = 'facebook-jssdk';
     // Set the new script's source to the source of the Facebook JS SDK
     facebookJS.src = '//connect.facebook.net/en_US/all.js';
     // Insert the Facebook JS SDK into the DOM
     firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
   }());
</script>
-->
<!-- DO NOT USE UNTIL NEEDED - THEN SET PROPER APPID
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '836466059717946',
      xfbml      : true,
      version    : 'v2.1'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
-->