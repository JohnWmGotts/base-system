<?php
	//session_start();	// commented out - jwg
	$_SESSION["file_info"] = array();
	$_SESSION['projectToken'] = mt_rand();
?>
<Script type="text/javascript">
var SiteUrl="<?php print $base_url;?>";
</script>
<script type="text/javascript" src="<?php echo $base_url;?>js/sliding.form.js"></script>
<link href="<?php echo $base_url;?>css/swfupload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $base_url;?>includes/javascript/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>includes/javascript/swfupload/handlers.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>includes/javascript/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>includes/javascript/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/ui.geo_autocomplete.js"></script>

<link href="<?php echo $base_url;?>css/jquery-ui-1.8.20.custom.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $base_url;?>includes/javascript/ui/jquery.ui.core.js"></script>
<script src="<?php echo $base_url;?>includes/javascript/ui/jquery.ui.widget.js"></script>
<script src="<?php echo $base_url;?>includes/javascript/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.stickyscroll.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.multiFieldExtender.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/lib/jquery-ui/js/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript"  src="<?php print SITE_JAVA;?>oauthpopup.js"></script>

<?php 
if(isset($_SESSION['projectId'])){
	$projId = $_SESSION['projectId'];
}
// jwg - don't unless needed later
//$fb_login_require = true;
//$fb_createProject_Id = $projId;
//require_once(DIR_MOD.'fb_connect/fb_login.php'); 
?>

<script src="<?php echo SITE_JAVA; ?>startProject.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>includes/ckeditor/ckeditor.js"></script>

<script type="text/javascript" language="javascript">

$(document).ready(function() {
/* - jwg .. no longer using fb to get bio, etc for project creator
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
});

	var swfu,swfu1,swfu2;
	window.onload = function () {
		swfu = new SWFUpload({
			// Backend Settings
			upload_url: "<?php echo $base_url;?>templates/content/createProject/upload.php",
			post_params: {"PHPSESSID": "<?php echo session_id(); ?>","proId":"<?php echo (isset($_SESSION['projectId'])) ? $_SESSION['projectId'] : '';?>","userId":"<?php echo (isset($_SESSION['userId'])) ? $_SESSION['userId'] : '';?>"},
			// File Upload Settings
			file_size_limit : "10 MB",	// 5MB
			file_types : "*.jpg;*.jpeg;*.png;*.gif;",
			file_types_description : "JPG, PNG & GIF Images",
			file_upload_limit : "1",
			file_queue_limit:"1",
			// Event Handler Settings - these functions as defined in Handlers.js
			//  The handlers are not part of SWFUpload but are part of my website and control how
			//  my website reacts to the SWFUpload events.
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,

			// Button Settings
			button_image_url : "<?php echo $base_url;?>images/SmallSpyGlassWithTransperancy_17x18.png",
			button_placeholder_id : "spanButtonPlaceholder",
			button_width: 180,
			button_height: 18,
			button_text : '<span class="button">Select Image</span>',
			button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
			button_text_top_padding: 0,
			button_text_left_padding: 18,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			
			// Flash Settings
			flash_url : "<?php echo $base_url;?>includes/javascript/swfupload/swfupload.swf",

			custom_settings : {
				upload_target : "divFileProgressContainer"
			},
			
			// Debug Settings
			debug: false
		});
		/*
		swfu1 = new SWFUpload({
			//alert('video');
			// Backend Settings
			upload_url: "<?php echo $base_url;?>templates/content/createProject/uploadVideo.php",
			post_params: {"PHPSESSID": "<?php echo session_id(); ?>","proId":"<?php echo (isset($_SESSION['projectId'])) ? $_SESSION['projectId'] : '';?>","userId":"<?php echo (isset($_SESSION['userId'])) ? $_SESSION['userId'] : '';?>"},			 
			// File Upload Settings
			file_size_limit : "50MB",	// 2MB
			file_types : "*.avi;*.mov;*.flv;*.wmv;*.mpg;*.mpeg;",
			file_types_description : "Project Video",
			file_upload_limit : "1",
			file_queue_limit:"1",
			// Event Handler Settings - these functions as defined in Handlers.js
			//  The handlers are not part of SWFUpload but are part of my website and control how
			//  my website reacts to the SWFUpload events.
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			//upload_start_handler	:	uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess1,
			upload_complete_handler : uploadComplete,

			// Button Settings
			button_image_url : "<?php echo $base_url;?>images/SmallSpyGlassWithTransperancy_17x18.png",
			button_placeholder_id : "spanButtonPlaceholder1",
			button_width: 200,
			button_height: 18,
			button_text : '<span class="button">Select Project Video <span class="buttonSmall">(500 MB Max)</span></span>',
			button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
			button_text_top_padding: 0,
			button_text_left_padding: 18,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			
			// Flash Settings
			flash_url : "<?php echo $base_url;?>includes/javascript/swfupload/swfupload.swf",
			swfupload_element_id : "flashUI2",		// Setting from graceful degradation plugin
			degraded_element_id : "degradedUI2",	// Setting from graceful degradation plugin
			custom_settings : {
				upload_target : "divFileProgressContainer1"
			},
			// Debug Settings
			debug: false
		});
		*/
		swfu2 = new SWFUpload({
			// Backend Settings
			upload_url: "<?php echo $base_url;?>templates/content/createProject/uploadProfile.php",
			post_params: {"PHPSESSID": "<?php echo session_id(); ?>","proId":"<?php echo (isset($_SESSION['projectId'])) ? $_SESSION['projectId'] : '';?>","userId":"<?php echo (isset($_SESSION['userId'])) ? $_SESSION['userId'] : '';?>"},
			// File Upload Settings
			file_size_limit : "10 MB",	// 5MB
			file_types : "*.jpg;*.jpeg;*.png;*.gif;",
			file_types_description : "JPG, PNG or GIF Images",
			file_upload_limit : "1",
			file_queue_limit:"1",
			// Event Handler Settings - these functions as defined in Handlers.js
			//  The handlers are not part of SWFUpload but are part of my website and control how
			//  my website reacts to the SWFUpload events.
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess2,
			upload_complete_handler : uploadComplete,

			// Button Settings
			button_image_url : "<?php echo $base_url;?>images/SmallSpyGlassWithTransperancy_17x18.png",
			button_placeholder_id : "spanButtonPlaceholder2",
			button_width: 180,
			button_height: 18,
			button_text : '<span class="button">Select Image</span>',
			button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
			button_text_top_padding: 0,
			button_text_left_padding: 18,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			
			// Flash Settings
			flash_url : "<?php echo $base_url;?>includes/javascript/swfupload/swfupload.swf",
			swfupload_element_id : "flashUI3",		// Setting from graceful degradation plugin
			degraded_element_id : "degradedUI3",	// Setting from graceful degradation plugin
			custom_settings : {
				upload_target : "divFileProgressContainer2"
			},
			
			// Debug Settings
			debug: false
		});
	};
$(document).ready(function() {
	/*$('.wymeditor').wymeditor();*/
	$('#projectLocation').geo_autocomplete({
		"select": function(event, ui) {
				$('#projectLocationPreview').html(ui.item.value);
				$('#projectLocation').val(ui.item.value);
				
				if($('#projectLocation').val().length > 45){
					$(".project_meta").css("height","65px");
				}else{
					$(".project_meta").css("height","46px");
				}
    			return false;
			}
	});
	$('#userLocation').geo_autocomplete();
	$('div#containererreurtotal').hide();

	/*Reward Add-Remove*/
	$('#btnAdd1').click(function() {
		var is_show = $('#input1').is(':visible');
		
		if(!is_show){
			$('#input1').show();
			$("#noReward").val(1);
		}else{
			var num		= $('.clonedInput').length;// how many "duplicatable" input fields we currently have //1
			var newNum	= new Number(num + 1);		// the numeric ID of the new input field being added2
			$('#countRewards').val(newNum);
			// create the new element via clone(), and manipulate it's ID using newNum value
			var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);
		
			// manipulate the name/id values of the input inside the new element
			newElem.children(':first').attr('id', 'name' + newNum).attr('name', 'name' + newNum);
		
			// insert the new element after the last "duplicatable" input field
			$('#input' + num).after(newElem);
			
			// enable the "remove" button
			$('#btnDel1').removeAttr("disabled");				
			// business rule: you can only add 5 names
			if (newNum == 15)
				$('#btnAdd1').attr('disabled','disabled');
			bindCickEvents();
		}
	});
	
	$('#btnDel1').click(function() {
		
		var num	= $('.clonedInput').length;	// how many "duplicatable" input fields we currently have
		if(num == 1){
			$("#noReward").val(0);
			$("#input1").hide();
		}
		if(num > 1){
		$('#input' + num).remove();		// remove the last element

		// enable the "add" button
		$('#btnAdd1').removeAttr("disabled");

		// if only one element remains, disable the "remove" button
		$('#countRewards').val(num-1);
		}
		
	});
	
	<?php if(isset($projectRewards) && (@mysql_num_rows($projectRewards)<1)) { ?>	
		//$('#btnDel').attr('disabled','disabled');
	<?php }?>
	
	var rewA=true;
	var is_show1 = $('#input1').is(':visible');
	if(!is_show1){
		rewA=false;
	}else{
		rewA=true;
	}
	$.validator.addMethod('positiveNumber',
    function (value) { 
        return Number(value) > 0;
    }, 'Enter a valid Amount');
	$("#projectCreatefield").validate({
            errorLabelContainer: "#containererreurtotal",
            wrapper: "li",
         
            errorClass: "error",
            rules: {
				acceptTerms: {required: true},
                projectTitle: { required: true, maxlength: 60 },
                projectCategory: { required: true },
				Selecteddays: {required: true },			
				days:{required: true,min:1,max: 60,digits:true},
                shortBlurb: { required: true, maxlength: 135 },				
                projectLocation: { required: true },
				fundingGoal: {required: true, currency: true, maxlength: 7},
                
				"rewardAmount[]": { required: function(){ return rewA;}, currency: true, maxlength: 5},
                paypalUserAccount: {required: true ,email:true },
				rewardYear:{required:true},
				rewardDescription:{required:true},
				rewardMonth:{required:true}
            },
            messages: { 
				acceptTerms: {reqired:"Accept project guidelines"},
                projectTitle: { required: "Project title required", maxlength: "project title would not be greater then 60 characters" },
                projectCategory: { required: "Project category required"},
				Selecteddays: {required:"Funding duration date required"},
				days: {required:"Funding duration days required", min:"Days would more than 1 day.", max:"Days would not more than 60 days.", digits:"Invalid days"},
                shortBlurb: { required: "Short blurb required", maxlength: "Short blurb would not be greater then 135 characters" },
                projectLocation: { required: "Project location required"},
				fundingGoal	: {required: "Project funding goal required", currency: "Funding goal must be a number.", maxlength: "Funding goal too large."},
                fundingGoal_days: { required: "Project funding goal required", number: "Funding goal amount required", maxlength: "Invalid funding goal amount", min:"Project funding amount would be more then atleast 1 USD",positiveNumber: "Enter a valid Amount" },
			    fundingGoal_people: { required: "Project Minimum contributors required", number: "Project Minimum contributors required", maxlength: "Invalid Project Minimum contributors number", min:"Project Minimum contributors numbers would be more then atleast 1",positiveNumber: 'Enter a valid Project Minimum contributors' },
				"rewardAmount[]": { required: "Reward minimum pledge amount required", currency: "Pledge amount must be a number.", maxlength:"Pledge amount too large." },
                paypalUserAccount: { required: "Paypal id required", email: "Invalid Email Address" },
				rewardYear: {required:"Select reward year"},
				rewardDescription: {required:"Reward description required"},
				rewardMonth: {required:"Select reward month"}
            },
            invalidHandler: function(form, validator) {
                $("#containererreurtotal").show();
            },
            unhighlight: function(element, errorClass) {
				
				
                if (this.numberOfInvalids() == 0) {
                    $("#containererreurtotal").hide();
                }
                $(element).removeClass(errorClass);
            }    

        });

$('#AddWebsiteImage').click(function(){
	var myVariable = $('#userWebsites').val();
	
	if( /^([a-z]([a-z]|\d|\+|-|\.)*):(\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?((\[(|(v[\da-f]{1,}\.(([a-z]|\d|-|\.|_|~)|[!\$&'\(\)\*\+,;=]|:)+))\])|((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=])*)(:\d*)?)(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*|(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)){0})(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(myVariable)) {
	 
	  $.ajax({
				type: 'POST',
				url: "<?php echo $base_url; ?>modules/user/addwebsite.php",
				dataType: 'html',
				data: {
					sitename:encodeURIComponent(myVariable),
					ajax: 'ajax'
				},
				success: function(msg) 
				{
					$('.websitesProfile').append(msg);
					$("#noDataFound").remove();
					$('#userWebsites').val('');
				}
			});
	} else {
	  alert("invalid url");
	  $('#userWebsites').focus();
	}
});
	
	if (!!$('.stickey').offset()) { // make sure ".sticky" element exists
		var stickyTop = $('.stickey').offset().top; // returns number 
		$(window).scroll(function(){ // scroll event
			var windowTop = $(window).scrollTop(); // returns number 
			if (stickyTop < windowTop){
				$('.stickey').css({ position: 'fixed', top: 0 });
			}
			else {
				$('.stickey').css('position','static');
			}
		});
	}
	//$('#navigation').stickyScroll({ container: '.stepmain' });
	$('#projectTitle').keyup(function() {
		$('#projectTitlePreview').html($('#projectTitle').val());
	});
	$('#shortBlurb').keyup(function() {
		$('#projectShortBlurb').html($('#shortBlurb').val());
	});
	$('#projectLocation').keyup(function() {
		
		if($('#projectLocation').val().length > 45){
			$(".project_meta").css("height","65px");
		}else{
			$(".project_meta").css("height","46px");
		}
		$('#projectLocationPreview').html($('#projectLocation').val());
		
	});
	$('#fundingGoal').focusout(function() { 	
		var fg = $('#fundingGoal').val().replace('$','');
		$('#pledgedAmount').html('$'+fg);
		var prj_cost = fg;
		$.ajax({
				type: 'POST',
				url: "<?php echo $base_url; ?>modules/createProject/commision.php",
				async: false,
				dataType: 'html',
				data: {
					cost:prj_cost,
					projectId:0,
					ajax: 'ajax'
				},
				success: function(msg) 
				{
					if(msg==0){
						
					}else{
						$("#ajaxCommision").html('');
						$("#ajaxCommision").html(msg); // show our commission percentage
					}
				}
			});
	});
	$( "#daysInput" ).datepicker({
			altField: "#alternate",
			minDate:+1,
			maxDate:+60,
			altFormat: "DD, d MM, yy"
	});
		
	$('#days').keyup(function() {
		$('#daysToGo').html($('#days').val());
	});
	
	$("#daysInput").live('change',function(){
		if($("#daysInput").val()){
			var date01 = new Date($("#daysInput").val());
			var now01 = new Date();
			var diff = (Math.ceil((date01-now01)/86400000)); 
			$('#daysToGo').html(diff);			
		}
	});
	
	$('#duration_duration').click(function() {
		$('#durationDiv').addClass('required-gray-short2');
		$('#durationDiv').removeClass('required-gray-short');
		$('#durationDiv1').addClass('required-gray-short');
		$('#durationDiv1').removeClass('required-gray-short2');
		$('#daysInput').css("display","none");
		$('#days').css("display","block");
		$('#days').attr('disabled', false);
		$('#daysInput').attr('disabled', true);
		$('#daysInput').val('');
	});
	$('#duration_endtime').click(function() { 		
		$('#durationDiv').addClass('required-gray-short');
		$('#durationDiv').removeClass('required-gray-short2');
		$('#durationDiv1').addClass('required-gray-short2');
		$('#durationDiv1').removeClass('required-gray-short');
		$('#days').css("display","none");
		$('#daysInput').css("display","block");
		$('#daysInput').attr('disabled', false);
		$('#days').attr('disabled', true);//css("display","block");
		$('#days').val('');
	});
	
	//$('.wymeditor').wymeditor();
	bindCickEvents();
});
</script>
<script>
$(document).ready(function(){
		$(".temp").fadeOut(1);
		$("#aa").fadeIn(1); 
		$("#getStarted").click(function(){
			$(".temp").fadeOut(2, function(){
				$("#aa").fadeIn(2); 
			});
		});
		$("#getBasics").click(function(){
			$(".temp").fadeOut(2, function(){
				$("#bb").fadeIn(2); 
			});
		});
		$("#getGoal").click(function(){
			$(".temp").fadeOut(2, function(){
				$("#cc").fadeIn(2); 
			});
		});
		$("#getRewards").click(function(){
			$(".temp").fadeOut(2, function(){
				$("#dd").fadeIn(2); 
			});
		});
		$("#getStory").click(function(){
			$(".temp").fadeOut(2, function(){
				$("#ee").fadeIn(2); 
			});
		});
		$("#getAbout").click(function(){
			$(".temp").fadeOut(2, function(){
				$("#ff").fadeIn(2); 
			});
		});
		$("#getAccount").click(function(){
			$(".temp").fadeOut(2, function(){
				$("#gg").fadeIn(2); 
			});
		});
		$("#getReview").click(function(){
			$(".temp").fadeOut(2, function(){
				$("#hh").fadeIn(2); 
			});
		});
		
		$("#preview-btn a").click(function(){
			var url = $(this).attr("href");
			var win=window.open(url, '_blank');
		    win.focus();
		});	
		
});
</script>
<script>
function ckerror() {
	if ($('#containererreurtotal').length) {
		if ($('#containererreurtotal').css('display') == 'block') {
			alert("Resolve the red error message before proceeding to next page.");
			$(window).scrollTop(0);
			return true; // there is an error message (likely from jquery validate) at top of form
						 // and we want to inhibit user from moving forward w/o fixing that 
						 // in case they clicked Next without noticing the problem.
		}
	}
	return false;
}

function deleteProject() { 	// jwg
	$.ajax({
			type: 'POST',
			url: "<?php echo $base_url; ?>modules/createProject/updateProject.php",
			async: true,
			dataType: 'html',
			data: {
				request:'delete',
				projectId:<?php echo $projId; ?>,
				ajax: 'ajax'
			},
			success: function(msg) 
			{
				if ((msg !== '')) {
					alert(msg);
				} else {				
					alert('Project deleted');
					window.location = 'index.php';
				}
			}
	});
};

</script>

<section ><!--id="content"-->
	<div class="stepmain">
    	<div class="wrapper">
        	<div class="steps stickey" id="navigation">
                <ul>
                    <li class="step step-1" id="start"><a href="#" class="active" id="getStarted">Guidelines </a></li>
                    <li class="step step-2" id="basics"><a href="#" id="getBasics">Basics</a></li>
                    <li class="step step-3" id="goal"><a href="#" id="getGoal">Goal </a> </li>
                    <li class="step step-4" id="reward"><a href="#" id="getRewards">Rewards </a> </li>
                    <li class="step step-5" id="story"><a href="#" id="getStory">Story </a></li>
                    <li class="step step-6" id="about"><a href="#" id="getAbout">About You </a></li>
                    <li class="step step-7" id="account"><a href="#"  id="getAccount">Account </a> </li>
                    <li class="step step-8" id="review"><a href="#" id="getReview">Review </a></li>
                </ul>
                <div class="preview-btn" id="preview-btn">
                    <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $projId; ?>/" target="_blank">Preview</a>
                </div>
        	</div>      
		<div class="flclear"></div>
    	</div>
    </div>
</section>

<div class="clear"></div> 
<div id="sticky-footer-left" align="center">
			<input name="deleteProject" value="Delete" id="deleteProject" title="Delete this project" class="hover-effect" type="submit"
				onclick="deleteProject()" >
</div> 
<div id="sticky-footer" align="center">
			<input name="publishProject" value="Publish" id="publishProject" title="Submit project for review" class="hover-effect" type="submit"
				onclick="$('#projectCreatefield').submit()" >
</div> 
<div id="aa" class="head_contents temp hide">
    <h3>Project Guidelines</h3>
     <p>These are our guidelines:</p>
</div>
<div id="bb" class="head_contents temp hide">
    <h3>Meet your new project</h3>
    <p>Start by giving it a name, a pic, and other important details.</p>
</div>
<div id="cc" class="head_contents temp hide">
    <h3>Goal</h3>
     <p>Set your project goal:</p>
</div>
<div id="dd" class="head_contents temp hide">
    <h3>Rewards</h3>
     <p>Define rewards for funding levels:</p>
</div>
<div id="ee" class="head_contents temp hide">
    <h3>Story</h3>
    <p>Tell your project story.</p>
</div>
<div id="ff" class="head_contents temp hide">
    <h3>About You</h3>
     <p>Tell your story:</p>
</div>
<div id="gg" class="head_contents temp hide">
    <h3>Account</h3>
    <p>Specify your PayPal account for receiving funds;</p>
</div>
<div id="hh" class="head_contents temp hide">
    <h3>Review</h3>
     <p>Insure your project is complete and correct:</p>
</div>

<div id="containererreurtotal"></div>

<form id="projectCreatefield" name="projectCreatefield" action="<?php echo SITE_URL ?>createproject/" method="post">
<div class="wrapper">
<div class="main fl">
    <div id="wrapper">
        <div id="steps">
          <input type="hidden" name="projectCreate" id="projectCreate" <?php if(!isset($_SESSION['projectId']) || ($_SESSION['projectId']=='')){?>value="0" <?php } else{?> value="1" <?php }?>/>
          <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['projectToken'];?>"/>
          
          <!--Project Guidelines 1-->
          <fieldset class="step width640 firststepfieldset">
           
            <div class="NS_projects__edit_guidelines">
              <h3><?php echo DISPLAYSITENAME; ?> is a funding platform for creative projects </h3>
              <p><?php echo DISPLAYSITENAME; ?> is a funding platform for creative projects — everything from traditional forms of art (like theater and music) to contemporary forms (like design and games). These guidelines explain <?php echo DISPLAYSITENAME; ?>'s focus. Projects violating these guidelines will not be allowed to launch.</p>
              <p>Note that as you go through the site you may find past projects on <?php echo DISPLAYSITENAME; ?> that conflict with these rules. We're making tweaks as we learn and grow. Thanks for reading!</p>
              <?php
                if(!isset($_SESSION['projectId']) || ($_SESSION['projectId']==''))
                {
              ?>
              <p><input type="checkbox" name="acceptTerms" id="acceptTerms"/>
                I understand that if my project does not meet the Project Guidelines, I will not be able to launch it on <?php echo DISPLAYSITENAME; ?>.</p>
              <?php } ?>
            </div>
            <?php
            if(isset($_SESSION['projectId']) && ($_SESSION['projectId']!='')){ ?>
            <div class="clear"></div>
            <div id="nextPrev">
              <input type="button" class="button-save" id="btnAdd" onclick="javascript:if (!ckerror()) nextPrev('getStarted',2,'basics');" value="Next" />
            </div>
            <?php }?>
          </fieldset>
          
          <!--Meet your new project 2-->
          <fieldset class="step width640">
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Project image</h6>
              </div>
              <div class="grey-field-right fr">
                <div id="thumbnails" class="img fl">
                  <?php if(isset($projectImages) && isset($projectImages['image100by80']) && ($projectImages['image100by80']!='')){?>
                  <img src="<?php echo $base_url.$projectImages['image100by80'];?>" width="80" height="60" alt="Project Images" />
                  <?php }else { ?>
                  <img src="<?php echo $base_url;?>images/missing_little1.png" alt="Project Images" />
                  <?php } ?>
                </div>
                <div class="white-panel fr">
                  <div id="divFileProgressContainer"> <span id="spanButtonPlaceholder" class="white-panel fr"></span> </div>
                </div>
              </div>
              <div class="clear"></div>
            </div>
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Project title <span class="requiredStar">*</span></h6>
              </div>
              <div class="grey-field-right2 marbtm fr">
                <input name="projectTitle" class="inputClass  marbtm projectInput" type="text" id="projectTitle" maxlength="60" value="<?php echo (isset($projectBasicDetails)) ? $projectBasicDetails['projectTitle'] : ''; ?>"/>
                <span class="float-left padleft10">Your project title should be simple, specific, and memorable, and it should include the title of the creative project you're raising funds for. Avoid words like "help", "support", or "fund".</span> </div>
              <div class="clear"></div>
            </div>
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Category <span class="requiredStar">*</span></h6>
              </div>
              <div class="grey-field-right2 fr">
                <select class="inputClass projectInput width421" name="projectCategory" id="projectCategory">
                  <option value="">Select Category</option>
                  <?php while($row = mysql_fetch_assoc($siteCategories)) { ?>
                  <option value="<?php echo $row['categoryId'];?>" <?php if($row['categoryId']== (isset($projectBasicDetails)) ? $projectBasicDetails['projectCategory'] : null) {?> selected=selected <?php }?> ><?php echo $row['categoryName'];?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="clear"></div>
            </div>
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Short blurb <span class="requiredStar">*</span></h6>
              </div>
              <div class="grey-field-right2 marbtm fr">
                <textarea class="inputClass textarea marbtm projectInput txtareaFixwidth" cols="400" data-help_section="short-description-help" maxlength="135" id="shortBlurb" name="shortBlurb" rows="3"><?php echo (isset($projectBasicDetails)) ? unsanitize_string($projectBasicDetails['shortBlurb']) : ''; ?></textarea>
                <span style="float:left;" class="padleft10">If you had to describe your project in one tweet, how would you do it?</span> </div>
              <div class="clear"></div>
            </div>
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Project location <span class="requiredStar">*</span></h6>
              </div>
              <div class="grey-field-right2 fr">
                <input class="marbtm inputClass projectInput" id="projectLocation" name="projectLocation" maxlength="250" size="250" type="text" value="<?php echo (isset($projectBasicDetails)) ? $projectBasicDetails['projectLocation'] : ''; ?>">
              </div>
              <div class="clear"></div>
            </div>			  
			  
            <div class="clear"></div>
          
          <div id="nextPrev">
            <input type="button" class="button-save" id="btnAdd" onclick="javascript:nextPrev('getBasics',1,'start');" value="Prev" />
            <input type="button" class="button-save" id="btnAdd" onclick="javascript:if (!ckerror()) nextPrev('getBasics',3,'goal');" value="Next" />
          </div>
		   <div class="clear small_vert_pad" ></div>
		  </fieldset>
		  
          <!--Funding goal 3-->
          <fieldset class="step width640">

            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Funding duration <span class="requiredStar">*</span></h6>
              </div>
              <?php
              if(isset($projectBasicDetails) && (($projectBasicDetails['durationType']==1) or ($projectBasicDetails['projectEnd']=='0'))) { ?>
              <div class="grey-field-right2 marbtm fr">
                <div class="required-gray-short marbtm fl" id="durationDiv1">
                  <input checked="checked" class="radio" id="duration_duration" name="duration" type="radio" value="1">Number of days 
                </div>
                <?php
                  if($projectBasicDetails['projectEnd']!=0) {
                    $days = $projectBasicDetails['projectEnd'];
                    $startDate = time();
                    $endDate = $days-$startDate;
                    $endDate = $endDate/(24*3600);
                    $endDate = ceil($endDate);
					if($endDate<0 || $endDate==0){
						$endDate = 30;}
                  } 
				   
				  else { $endDate = 30; }
                ?>
                <input class="required-white-short marbtm fl inputClass projectRadio" id="days" maxlength="2" name="days" size="60" type="text" value="<?php echo $endDate;?>" >
                <div class="clear"></div>
                <div class="required-gray-short2 marbtm fl" id="durationDiv">
                  <input class="radio" id="duration_endtime" name="duration" type="radio" value="0">End on date
                </div>
                <input class="required-white-short marbtm fl inputClass projectRadio" readonly="readonly" id="daysInput" name="Selecteddays" size="60" type="text" style="display:none;">
                <div class="clear"></div>
                We recommend that projects last 30 days or less. Shorter durations have higher success rates, and will create a helpful sense of urgency around your project.<br />
                <br />
              </div>
              <?php }
              else
              {?>
              <div class="grey-field-right2 marbtm fr">
                <div class="required-gray-short2 marbtm fl" id="durationDiv1">
                  <input class="radio" id="duration_duration" name="duration" type="radio" value="1">Number of days 
                </div>
                <input class="required-white-short marbtm fl inputClass projectRadio" id="days" maxlength="2" name="days" size="60" type="text" value="30" style="display:none;">
                <div class="clear"></div>
                <div class="required-gray-short marbtm fl" id="durationDiv">
                  <input class="radio" id="duration_endtime" name="duration" type="radio" value="0" checked="checked" >End on date & time 
                </div>
                <input class="required-white-short marbtm fl inputClass projectRadio" id="daysInput" name="Selecteddays" size="60" type="text" value="<?php echo (isset($projectBasicDetails) && ($projectBasicDetails['projectEnd']!=0)) ? date("m/d/Y",$projectBasicDetails['projectEnd']):"";?>">
                <div class="clear"></div>
                We recommend that projects last 30 days or less. Shorter durations have higher success rates, and will create a helpful sense of urgency around your project.<br />
                <br />
              </div>
              <?php }
               ?>
              <div class="clear"></div>
            </div>

            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Funding goal (U.S. $) <span class="requiredStar">*</span></h6>
              </div>
				    
            <div class="grey-field-right2 marbtm fr positionrelativ">
                <input class="marbtm inputClass projectFundingInput" id="fundingGoal" maxlength="7" name="fundingGoal" size="60" type="text" value="<?php echo (isset($projectBasicDetails)) ? $projectBasicDetails['fundingGoal'] : ''; ?>">
                <div class="currencySign">&nbsp;</div>
                <span class=" float-left padleft10" id="txtChangeCost">Your funding goal should be the minimum amount needed to complete the project and fulfill all rewards. Because funding is all-or-nothing, you can always raise more than your goal but never less. <br />
                <br />If your project is successfully funded, <?php echo DISPLAYSITENAME;?> will apply a <span id="ajaxCommision"><?php echo $manage_commision_cost['value']; ?></span> % fee to the funds raised, and Paypal will apply credit card processing fees (about 3%). If funding isn't successful, there are no fees. </span> </div>
            <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
          
          <div id="nextPrev">
            <input type="button" class="button-save" id="btnAdd" onclick="javascript:nextPrev('getGoal',2,'start');" value="Prev" />
            <input type="button" class="button-save" id="btnAdd" onclick="javascript:if (!ckerror()) nextPrev('getGoal',4,'reward');" value="Next" />
          </div>
          </fieldset>
          
          <!--Rewards 4-->
          <fieldset class="step width640">
            <div class="clear"></div>
            <?php
            $j=1; 
            if(isset($projectRewards) && (@mysql_num_rows($projectRewards)>=1))
            {
                while($rewardRow = mysql_fetch_array($projectRewards))
                {?>
            <div id="input<?php echo $j;?>" style="margin-bottom:4px;" class="clonedInput">
              <div class="grey-field">
                <div class="grey-field-left fl">
                  <h6>Reward</h6>
                </div>
                <div class="grey-field-right fr"  style="width:418px; margin-top: 5px; float:right;">
                  <div class="left-column fl">
                    <div class="pledge-amount">Pledge (U.S. $) <span class="requiredStar">*</span></div>
                    <div class="title-name">Description <span class="requiredStar">*</span></div>
                    <div class="title-name2">Est. delivery date <span class="requiredStar">*</span></div>
                  </div>
                  <div class="right-column fl">
                    <div class="fl">
                      <input class="text" id="rewardAmount" name="rewardAmount[]" size="30" type="text" value="<?php echo isset($rewardRow['pledgeAmount']) ? (int)$rewardRow['pledgeAmount'] : 0;?>" maxlength="5">
                    </div>
                    <div class="limit fl checkChecked">
                      <input name="availLimit[]" id="availLimit" class="availTest" type="checkbox" <?php if($rewardRow['limitAvailable']>0){?> checked="checked" <?php } ?> maxlength="" />
                      Limit # available</div>
                    <input class="text" type="text" name="avail[]" id="avail" <?php if($rewardRow['limitAvailable']==0){?> readonly="readonly" <?php } ?> value="<?php echo ($rewardRow['limitAvailable'] > 0 ) ? $rewardRow['limitAvailable'] : 0;?>" maxlength="2">
                    <div class="clear"></div>
                    <div class="blank fl">
                      <textarea name="rewardDescription[]" class="text2" cols="" rows="" id="rewardDescription"><?php echo $rewardRow['description'];?></textarea>
                    </div>
                    <div class="clear"></div>
                    <div class="blank fl">
                      <select class="month select" id="rewardMonth" name="rewardMonth[]">
                        <option value="">Select month...</option>
                        <option value="1" <?php if($rewardRow['estimateDeliveryMonth']==1){?> selected="selected" <?php } ?>>January</option>
                        <option value="2" <?php if($rewardRow['estimateDeliveryMonth']==2){?> selected="selected" <?php } ?>>February</option>
                        <option value="3" <?php if($rewardRow['estimateDeliveryMonth']==3){?> selected="selected" <?php } ?>>March</option>
                        <option value="4" <?php if($rewardRow['estimateDeliveryMonth']==4){?> selected="selected" <?php } ?>>April</option>
                        <option value="5" <?php if($rewardRow['estimateDeliveryMonth']==5){?> selected="selected" <?php } ?>>May</option>
                        <option value="6" <?php if($rewardRow['estimateDeliveryMonth']==6){?> selected="selected" <?php } ?>>June</option>
                        <option value="7" <?php if($rewardRow['estimateDeliveryMonth']==7){?> selected="selected" <?php } ?>>July</option>
                        <option value="8" <?php if($rewardRow['estimateDeliveryMonth']==8){?> selected="selected" <?php } ?>>August</option>
                        <option value="9" <?php if($rewardRow['estimateDeliveryMonth']==9){?> selected="selected" <?php } ?>>September</option>
                        <option value="10" <?php if($rewardRow['estimateDeliveryMonth']==10){?> selected="selected" <?php } ?>>October</option>
                        <option value="11" <?php if($rewardRow['estimateDeliveryMonth']==11){?> selected="selected" <?php } ?>>November</option>
                        <option value="12" <?php if($rewardRow['estimateDeliveryMonth']==12){?> selected="selected" <?php } ?>>December</option>
                      </select>
                      <?php $currentYear = date("Y",time());?>
                      <select class="year select" id="rewardYear" name="rewardYear[]">
                        <option value="">Select year...</option>
                        <?php for($k=0;$k<=4;$k++)
                            {?>
                        <option value="<?php echo $currentYear+$k; ?>" <?php if($rewardRow['estimateDeliveryYear']==$currentYear+$k){?> selected="selected" <?php } ?>><?php echo $currentYear+$k; ?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="clear"></div>
              </div>
            </div>
            <?php
                    $j++;
                     }
                }
                else
                {
            ?>
            <div id="input1" style="margin-bottom:4px;" class="clonedInput">
              <div class="grey-field">
                <div class="grey-field-left fl">
                  <h6>Reward</h6>
                </div>
                <div class="grey-field-right fr"  style="width:411px;margin-top: 5px; float:left;">
                  <div class="left-column fl">
                    <div class="pledge-amount">Pledge (U.S. $)<span class="requiredStar">*</span></div>
                    <div class="title-name">Description<span class="requiredStar">*</span></div>
                    <div class="title-name2">Est. delivery date<span class="requiredStar">*</span></div>
                  </div>
                  <div class="right-column fl">
                    <div class="fl">
                      <input class="text" id="rewardAmount" name="rewardAmount[]" size="30" type="text" value="<?php echo (isset($rewardRow)) ? (int)$rewardRow['pledgeAmount'] : 0;?>" maxlength="4">
                    </div>
                    <div class="limit fl checkChecked">
                      <input name="availLimit[]" id="availLimit" class="availTest" type="checkbox" <?php if (isset($rewardRow) && ($rewardRow['limitAvailable']>0)){?> checked="checked" <?php } ?> />
                      Limit # available</div>
                    <input type="text" id="avail" maxlength="2" name="avail[]" value="0" <?php if (isset($rewardRow) && ($rewardRow['limitAvailable']==0)){?> readonly="readonly"<?php } ?>>
                    <div class="clear"></div>
                    <div class="blank fl">
                      <textarea name="rewardDescription[]" class="text2" cols="" rows="" id="rewardDescription"><?php echo (isset($rewardRow)) ? $rewardRow['description'] : '';?></textarea>
                    </div>
                    <div class="clear"></div>
                    <div class="blank fl">
                      <select class="month select" id="rewardMonth" name="rewardMonth[]">
                        <option value="">Select month...</option>
                        <option value="1" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==1)){?> selected="selected" <?php } ?>>January</option>
                        <option value="2" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==2)){?> selected="selected" <?php } ?>>February</option>
                        <option value="3" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==3)){?> selected="selected" <?php } ?>>March</option>
                        <option value="4" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==4)){?> selected="selected" <?php } ?>>April</option>
                        <option value="5" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==5)){?> selected="selected" <?php } ?>>May</option>
                        <option value="6" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==6)){?> selected="selected" <?php } ?>>June</option>
                        <option value="7" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==7)){?> selected="selected" <?php } ?>>July</option>
                        <option value="8" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==8)){?> selected="selected" <?php } ?>>August</option>
                        <option value="9" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==9)){?> selected="selected" <?php } ?>>September</option>
                        <option value="10" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==10)){?> selected="selected" <?php } ?>>October</option>
                        <option value="11" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==11)){?> selected="selected" <?php } ?>>November</option>
                        <option value="12" <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryMonth']==12)){?> selected="selected" <?php } ?>>December</option>
                      </select>
                      <?php $currentYear = date("Y",time());?>
                      <select class="year select" id="rewardYear" name="rewardYear[]">
                        <option value="">Select year...</option>
                        <?php for($k=0;$k<=4;$k++)
                            {?>
                        <option value="<?php echo $currentYear+$k; ?> <?php if (isset($rewardRow) && ($rewardRow['estimateDeliveryYear']==$currentYear+$k)){?> selected="selected" <?php } ?>"><?php echo $currentYear+$k; ?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="clear"></div>
              </div>
            </div>
            <?php }
                            ?>
            <input  type="hidden" name="countRewards" id="countRewards" value="<?php echo (isset($projectRewards)) ? @mysql_num_rows($projectRewards) : 0;?>"/>
            <input  type="hidden" name="noReward" id="noReward" value="1"/>
            <input  type="hidden" name="skipReward" id="skipReward" value="1"/>
            <div class="padleftAlignLeft">
              <input type="button" class="button-save" id="btnAdd1" value="Add another backer reward" />
              <input type="button" class="button-save" id="btnDel1" value="Remove Reward" />
            </div>
            <div class="clear"></div>
            <div id="nextPrev">
              <input type="button" class="button-save" id="btnAdd" onclick="javascript:nextPrev('getRewards',3,'goal');" value="Prev" />
              <input type="button" class="button-save" id="btnAdd" onclick="javascript:if (!ckerror()) nextPrev('getRewards',5,'story');" value="Next" />
            </div>
          </fieldset>
          
          <!--Story 5-->
          <fieldset class="step width640">
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Project Video</h6>
              </div>
              <div class="grey-field-right fr">
                <div id="thumbnails1" class="img fl">
				<?php
				/* no longer using projectVideoImages .. jwg
                  <?php if (isset($projectVideoImages) && ($projectVideoImages['image100by80']!='')){?>
                  	<img src="<?php echo $base_url.$projectVideoImages['image100by80']; ?>" width="80" height="60" alt="Project Video" />
                  <?php }else { ?>
                  	<img src="<?php echo $base_url;?>images/missing_little1.png" alt="Project Video" />
                  <?php } ?>
				 */
					if (isset($projectStory) && is_array($projectStory) && !empty($projectStory['projectVideoImage'])) {
					?>
						<img src="<?php echo $projectStory['projectVideoImage']; ?>" width="360" alt="Project Video" />
					<?php
					} else {
						// no image if not present
					}
				?>
		
                </div>
				<span>YouTube Video URL:</span>&nbsp;
				<?php
					$video_url = (isset($projectStory) && is_array($projectStory) && !empty($projectStory['projectVideo'])) ? 
						$projectStory['projectVideo'] : '' ;
				?>
				<input type="text" id="video_url" name="video_url" style="width:300px;" value="<?php echo $video_url; ?>" />
				<!--
                <div class="white-panel fr">
                  <div id="divFileProgressContainer1"> <span id="spanButtonPlaceholder1" class="white-panel fr"></span> </div>
                </div>
				-->
              </div>
              <div class="clear"></div>
            </div>
            <div class="grey-fieldVideo">
              <div class="grey-field-left fl">
                <h6>Project Description <span class="requiredStar">*</span></h6>
              </div>
              <div class="grey-field-right2 marbtm fr" style="overflow: auto;">
                <textarea style="height:400px;" class="required txtareaFixwidth" id="redactor_content" name="projectStory1"><?php echo (isset($projectStory)) ? unsanitize_string($projectStory['projectDescription']) : ''; ?></textarea>
              </div>
              <div class="clear"></div>
                           
              <div id="nextPrev">
                <input type="button" class="button-save" id="btnAdd" onclick="javascript:nextPrev('getStory',4,'reward');" value="Prev" />
                <input type="button" class="button-save" id="btnAdd" onclick="javascript:if (!ckerror()) nextPrev('getStory',6,'about');" value="Next" />
              </div>
            </div>
          </fieldset>
          
          <!--About You 6-->
          <fieldset class="step width640">
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Profile Photo</h6>
              </div>
              <div class="grey-field-right fr">
                <div id="thumbnails2" class="img fl">
					<?php $check_usrimg001=str_split($userDetails['profilePicture80_60'], 4);
                    if($userDetails['profilePicture80_60']!='' && $userDetails['profilePicture80_60']!=NULL && $check_usrimg001[0]=='imag') { ?>
                    	<img src="<?php echo SITE_URL.$userDetails['profilePicture80_60']; ?>" alt="Profile image" title="<?php echo $userDetails['name'] ?> "  />
                    <?php } else if($userDetails['profilePicture80_60']!='' && $userDetails['profilePicture80_60']!=NULL && $check_usrimg001[0]=='http') { 
						// jwg fixup for http vs https requirement
						$tempurl = $userDetails['profilePicture80_60'];
						if (strtolower(substr(SITE_URL,0,5)) != strtolower(substr($tempurl,0,5))) {
							$needed = explode(':',SITE_URL);
							$actual = explode(':',$tempurl);
							$tempurl = $needed[0].':'.$actual[1];
						}						
					?>
                    	<img src="<?php echo $tempurl; ?>" alt="Profile image" title="<?php echo $userDetails['name'] ?>" />
                    <?php } else { ?>
                   		<img src="<?php echo SITE_URL;?>images/missing_little1.png" alt="Profile image" title="<?php echo $userDetails['name'] ?>" width="80" height="60"  />
                    <?php } ?>
                </div>
                <div class="white-panel fr">
                  <div id="divFileProgressContainer2"> <span id="spanButtonPlaceholder2" class="white-panel fr"></span> </div>
                </div>
              </div>
              <div class="clear"></div>
            </div>
			<?php 
			/* -- don't do fb ... too limited w/o approval level
            <div class="grey-fieldVideo">
              <div class="grey-field-left fl">
                <h6>Facebook Connect</h6>
              </div>
              <div class="grey-field-right2 marbtm fr">
                <a class="btn-facebook">
                    <img src="<?php echo SITE_IMG_SITE ?>facebook-connect-button.png" alt="Facebook Login">
                </a>
              </div>
              <div class="clear"></div>
            </div>
			*/
			?>
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Biography</h6>
              </div>
              <div class="grey-field-right2 marbtm fr">
                <textarea class="inputClass textarea marbtm projectInput txtareaFixwidth" cols="400" rows="3" name="biography"><?php echo $userDetails['biography']; ?></textarea>
              </div>
              <?php /*?>
              <?php if($projectBasicDetails['userBiography']!='' && isset($projectBasicDetails['userBiography'])) { ?>
                <div class="grey-field-right2 marbtm fr">
                	<textarea class="inputClass textarea marbtm projectInput txtareaFixwidth" cols="400" rows="3" name="biography"><?php echo $projectBasicDetails['userBiography']; ?></textarea>
                </div>	
              <?php }else{ ?>
              <div class="grey-field-right2 marbtm fr">
                <textarea class="inputClass textarea marbtm projectInput txtareaFixwidth" cols="400" rows="3" name="biography"><?php echo $userDetails['biography']; ?></textarea>
              </div>
              <?php } ?>
              <?php */?>
              <input type="hidden" name="projectId_bio" id="projectId_bio" value="<?php echo $projId;?>"/>
              <div class="clear"></div>
            </div>
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Your location</h6>
              </div>
              <div class="grey-field-right2 fr">
                <input class="marbtm inputClass projectInput" id="userLocation" name="userLocation" maxlength="250" size="250" type="text" value="<?php echo $userDetails['userLocation']; ?>">
              </div>
              <div class="clear"></div>
            </div>
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Websites</h6>
              </div>
              <div class="grey-field-right2 fr" id="webContainerInput">
                <div style="float:left; width:380px;">
                  <input class="marbtm inputClass projectInput" id="userWebsites" name="userWebsites" maxlength="250" size="250" type="text">
                </div>
                <div class="imgDivWebsites">
                	<img src="<?php echo $base_url;?>images/add.jpg" title="Add Websites" alt="Add Websites" id="AddWebsiteImage" height="26px"/>
                </div>
              </div>
              <?php if(@mysql_num_rows($userWebsites)>0)
            {?>
              <div class="clear"></div>
              <div class="websitesProfile">
                <?php while($rowweb = mysql_fetch_array($userWebsites))
            	{?>
                <div id="websitesProfile<?php echo $rowweb['siteId'];?>"><?php echo $rowweb['siteUrl']; ?><span><img src="<?php echo $base_url;?>images/delete.png" border="0" onclick="return siteDelete('<?php echo $rowweb['siteId'];?>')"/></span></div>
                <br/>
                <?php } ?>
              </div>
              <?php }
              else{ ?>
              <div class="clear"></div>
              <div class="websitesProfile">
                <div id="noDataFound">No Website Added.</div>
              </div>
              <?php }
              ?>
              <div class="clear"></div>
              <div id="nextPrev">
                <input type="button" class="button-save" id="btnAdd" onclick="javascript:nextPrev('getAbout',5,'story');" value="Prev" />
                <input type="button" class="button-save" id="btnAdd" onclick="javascript:if (!ckerror()) nextPrev('getAbout',7,'account');" value="Next" />
              </div>
            </div>
          </fieldset>
          
          <!--Account 7-->
          <fieldset class="step width640 account_tab_panel">
            <div class="grey-field">
              <div class="grey-field-left fl">
                <h6>Paypal Account <span class="requiredStar">*</span></h6>
              </div>
              <div class="grey-field-right2 fr">
            
                <input id="paypalUserAccount" maxlength="100" name="paypalUserAccount" class="inputClass projectInput" type="text" value="<?php if($userDetails['paypalUserAccount']==''){ echo base64_decode($userDetails['emailAddress']); }else{ echo base64_decode($userDetails['paypalUserAccount']); }?>" readonly="readonly"/>
			  </div>
              <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
            <div id="nextPrev">
              <input type="button" class="button-save" id="btnAdd" onclick="javascript:nextPrev('getAccount',6,'about');" value="Prev" />
              <input type="button" class="button-save" id="btnAdd" onclick="javascript:if (!ckerror()) nextPrev('getAccount',8,'review');" value="Next" />
            </div>
          </fieldset>
          
          <!--Review 8-->
          <fieldset class="step width640 review_tab_panel">
            <div class="NS_projects__edit_submission unsubmitted paddingleft30">
              <h1>Before you publish</h1>
              <span class="fl">Make sure you have:</span>
              <ul style="text-align: left; padding: 25px;">
                <li> Clearly explained what you're raising funds to do. </li>
                <li> Added a video! It's the best way to connect with your backers. </li>
                <li> Created a series of well-priced, fun rewards. Not just thank-yous! </li>
                <li> Verified your funding account in your personal profile PayPal tab.</li>               
				<li> Previewed your project and gotten feedback from a friend. </li>
                <li> Checked out other projects on <?php echo DISPLAYSITENAME; ?> and backed one to get a feel for the experience. </li>
              </ul>
              <h1>After you publish</h1>
              <span class="fl">Once you've done everything listed above and published your project for review:</span>
              <ul style="text-align: left; padding: 25px;">
                <li> Your project will be reviewed to ensure it meets the Project Guidelines. </li>
                <li> Within a few days, we'll send you a message about the status of your project. </li>
                <li> If approved, you can launch whenever you're ready. </li>
              </ul>
            </div>
            <div class="clear"></div>
            <div id="nextPrev">
              <input type="button" class="button-save" id="btnAdd" onclick="javascript:nextPrev('getReview',7,'account');" value="Prev" />
            </div>
          </fieldset>
          
          </div>
      </div>
  </div>
	
	<div class="content_right" style="display:none;"> 
        <a target="_blank" href="<?php echo SITE_URL; ?>content/<?php echo $sel_ContentPage['id']; ?>/<?php echo Slug($sel_ContentPage['title']).'/'; ?>/" class="awesome_project background_light"> 
            <span>How to</span><br>
            Make an Awesome Project 
        </a>
        <div class="project_cart_preview background_light">
            <div class="project_cart_wrapper">
                <div class="project_cart">
                    <div class="project_thumb" id="BiggerThumb"> 
                    	<?php print (isset($projectImages)) ? $projectImages['image400by300'] : '';
						if(isset($projectImages) && ($projectImages['image200by156']!='')){?>
                        	<img id="test" src="<?php echo $base_url.$projectImages['image200by156'];?>" alt="Project Images" />
                        <?php }else { ?>
                        	<img id="test" src="<?php echo $base_url;?>images/missing_little.png" />
                        <?php } ?>
                    </div>
                    <div class="bbcard_name">
                        <h5>
                        	<a href="javascript:void()" target="" id="projectTitlePreview">
								<?php if(isset($projectBasicDetails) && ($projectBasicDetails['projectTitle']!='')){ echo $projectBasicDetails['projectTitle']; } else{ ?>
                                Untitled
                                <?php } ?>
                            </a>
                        </h5>
                        <p><?php echo $con->currentUserName();?></p>
                        <div id="projectShortBlurb">
							<?php (isset($projectBasicDetails)) ? unsanitize_string($projectBasicDetails['shortBlurb']) : ''; ?>
                        </div>
                    </div>
                    <div class="project_meta">
                    	<span class="location-name" id="projectLocationPreview"><?php echo (isset($projectBasicDetails)) ? $projectBasicDetails['projectLocation'] : ''; ?></span>
                    </div>
                </div>
                <div class="project_bottom">
                    <div class="percentbar">
                    	<div style="width:0%;"></div>
                    </div>
                    <!--<div class="progress"></div>-->
                    <div class="project_bottom_content">
                        <ul>
                            <li>
                                <h6>0%</h6>
                                <p>Funded</p>
                            </li>
                            
                            <li>
                                <h6 class="fundingtype_value" id="pledgedAmount">$0</h6>
                                <p class="fundingtype_text">Pledged</p>
                            </li>
                            
                            <li>
                            	<?php if(isset($projectBasicDetails) && ($projectBasicDetails['projectEnd']!=0)) {
                                        $days = $projectBasicDetails['projectEnd'];
                                        $startDate = time();
                                        $endDate = $days - $startDate;
                                        $endDate = $endDate/(24 * 3600);
                                        //$endDate = ceil($endDate);
                                    } else { $endDate = 30; } ?>
                                    
                            	<?php if(isset($projectBasicDetails) && (($projectBasicDetails['durationType']==1) or ($projectBasicDetails['projectEnd']=='0'))) { ?>
                                    <h6 id="daysToGo"><?php echo roundDays($endDate);?></h6>
                                    <p>Days Left</p>
                                <?php }else{ ?>
                                	<h6 id="daysToGo" ><?php echo roundDays($endDate);?></h6>
                                    <p>Days Left</p>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
	</div>
  
  </div><!--Wrapper Over-->

</form>
<script type="text/javascript">
//<![CDATA[
CKEDITOR.replace( 'redactor_content',
	{
		filebrowserBrowseUrl : '/browser/browse.php',
        filebrowserImageBrowseUrl : '/browser/browse.php?type=Images',
        filebrowserUploadUrl : '/uploader/upload.php',
        filebrowserImageUploadUrl : '/uploader/upload.php?type=Images',
		toolbar :
			[
				{ name: 'clipboard', items : ['Undo','Redo' ] },
				{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },
				{ name: 'insert', items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar','Iframe' ] },
						'/',
				{ name: 'styles', items : [ 'Styles','Format' ] },
				{ name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
				{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
				{ name: 'tools', items : [ 'Maximize','-','About' ] }
			]
	});	
	//]]>
</script>
<div class="clear"></div>

<!--</div>-->
<div class="clear"></div>
<!--<style>
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { border: 1px solid #cccccc; background: #00AEFF url(images/ui-bg_glass_100_f6f6f6_1x400.png) 50% 50% repeat-x; font-weight: bold; color: #ffffff !important; }
</style>-->