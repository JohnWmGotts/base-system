// JavaScript Document
/* -- replaced below w/ appid for crowdedrocket - using later version of api 
/// however -- do not use until required
window.fbAsyncInit = function() {
  FB.init({
	appId      : '1445733892307042', // App ID
	channelUrl : 'http://CrowdedRocket.com/modules/fb_connect/fb_login.php', // Channel File
	status     : true, // check login status
	cookie     : true, // enable cookies to allow the server to access the session
	xfbml      : true  // parse XFBML
  });
  // Additional initialization code here
};
// Load the SDK Asynchronously
(function(d){
           var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           ref.parentNode.insertBefore(js, ref);
         }(document));
*/
function timeRemaining(epochTime){
  var diff = epochTime - ((new Date()).getTime() / 1000);
  var num_unit = (diff < 60 && [Math.max(diff, 0), 'seconds']) ||
	((diff/=60) < 60 && [diff, 'minutes']) ||
	((diff/=60) < 72 && [diff, 'hours']) ||
	[diff/=24, 'days'];

  // Round down
  num_unit[0] = Math.floor(num_unit[0]);
  // Singularize unit
  if (num_unit[0] == 1) { num_unit[1] = num_unit[1].replace(/s$/,""); }

  return num_unit;
}
function siteDelete(siteId)
{
	var c;
	c = confirm("Are you sure to delete the website?");
	if(c)
	{
		$.ajax({
		type: 'GET',
		url: application_path+'modules/user/deletewebsite.php?siteid='+siteId+'&ajax=ajax',
		dataType: 'html',
		success: function(data) 
		{
			if(data==1)
			{
				$('#websitesProfile'+siteId).remove();
				$('.websitesProfile').html('<div id="noDataFound">No Website Added.</div>');
			}
			else
			{
				$('#websitesProfile'+siteId).remove();
			}
			
		}
		
	});
	}
	else{
	return false;
	}
}
function bindCickEvents()
{
	$('.checkChecked .availTest').each(function(i,e) {
		$(this).click(function(){
	if($(this).attr('checked'))	
	{
		
		//$(this).parent().next('input').attr('disabled', false);//css("display","block");
		$(this).parent().next('input').attr('readonly', false);//css("display","block");
	}
	else
	{
		//$(this).parent().next('input').attr('disabled', true);
		$(this).parent().next('input').attr('readonly', true);
		//$('#avail').attr('disabled', true);//css("display","block");
	}
	//$('#avail').val('');
		});
	});
}		