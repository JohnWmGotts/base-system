<!--<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>-->
  <?php $perpage = 10; 
  
  $limit = " LIMIT 0,".$perpage;
  ?>   
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>
<script type="text/javascript"  language="javascript">

$(document).ready(function ()
    {
        SearchText();
    });
	 function SearchText()
    {
		$(".autosuggest").autocomplete({
            source: function (request, response) {
				 var textVal = $("#inviteemail").val();
                $.ajax({
                    type: "POST",
                    dataType: 'JSON',
                    url: '<?php echo SITE_URL; ?>modules/user/autosearch.php',
                    data: 'field=' + textVal,
                    dataType: "json",
                    success: function (data) {
						if(data==null) {
						//alert('null');
						response('');
						}
						else {
							//alert('not null');
                       response(data);
						}
                    }
                   /* error: function (result) {
                        alert("Error");
                    }*/
                });
            }
        });
    }
	$(document).ready(function() {
		//validation method for multiple email address..
	jQuery.validator.addMethod(
    "multiemail",
     function(value, element) {
        //alert(value);
		if(value==';') {return false} else { if (this.optional(element)) // return true on optional element 
             return true;
         var emails = value.split(/[;]+/); // split element by , and ;
         valid = true;
         for (var i in emails) {
             value = emails[i];
             valid = valid &&
                     jQuery.validator.methods.email.call(this, $.trim(value), element);
         }
         return valid;}
		
     },
 jQuery.validator.messages.email
);
	$("#inviteFrm").validate({
			rules: {
				inviteemail: { 
					required: true, 
					multiemail: true 
				},
			captcha: {
				required: true,
				remote:"<?php echo SITE_URL;?>modules/user/user_ajax.php"}
				
			},
			messages: {
				inviteemail: {
					required: "<font style='color:red;float:left'>Please enter email.</font>",
					multiemail: "<font style='color:red;float:left'>Please enter a valid email address.</font>"
			
				},
				captcha:{
					required:"Please enter captcha code.",
					remote:"Captcha code is not valid"}
			}
		});
		
});

 
   function historyshow() {
   $(".sign-up").css({"display":"block"});
   $(".left-side").css({"margin-left":"0px"});
     $("#hidehistory").css({"display":"block"});
	 $("#seehistory").css({"display":"none"});
	}
	function historyhide() {
   $(".sign-up").css({"display":"none"});
   $(".left-side").css({"margin-left":"270px"});
     $("#hidehistory").css({"display":"none"});
	 $("#seehistory").css({"display":"block"});
	}

</script>

<section id="container">
   
   <div id="inbox" class="head_content temp">
       <h3>Invite Your Friends</h3>
   </div>
   
   <div class="wrapper signupbox">
   		
        
       
         <div class="signupbox left-side" >
            <!--InviteFriendIN div start-->
				<div class="heading">
					<h3>Invite Friends</h3>
					<p>Invite Your Friends To Join Us.</p>
				</div>
                 <form action="<?php echo $base_url; ?>invitefriends/" method="post" name="inviteFrm" id="inviteFrm">
                  
		           <div class="inputfield">
                   <div class="ui-widget">
                    <label for="tbAuto">   <p>Friend's Email ID *</p> </label>
                    
                    <input name="inviteemail" id="inviteemail" class="autosuggest"  value="" type="text" tabindex="1"/>
                     <div>Enter Email Addresses With Semicolon</div>
                     <label for="inviteemail" generated="true" class="error"></label>
                      <div id="friendmailvalid">
</div>
                     
                      </div>
                    </div>
                   
                    <div class="inputfield">
                        <p>Captcha</p>
                        	<input name="captcha" id="captcha" type="text" class="small" tabindex="2" />
                            	
                    </div>
                    
                    <div class="inputfield">
							<img id="imgCaptcha" src="<?php echo SITE_URL; ?>includes/capcha/random.php" height="25" alt="Captcha Code" border="0" class="fl"/>
                            <a href="javascript:void(0)" onclick="document.getElementById('imgCaptcha').src='<?php echo SITE_URL; ?>includes/capcha/random.php?'+Math.random();$('#captcha').focus();$('#captcha').val('');" id="change-image" ><img id="changeCaptcha" src="<?php echo SITE_URL; ?>images/captcha-ref.jpg" alt="Captcha Refresh" border="0" class="fl" /></a>
							
						</div>
                   
                    <div class="inputfield" style="padding-top:20px;">
                        <input style="height:45px" type="submit" name="submitbtn" tabindex="3" value="Send Invite!">
                    </div>   
                </form> 
                               
			</div>
            	<a href="javascript:void(0);" onclick="historyshow();" id="seehistory"><h3 style="padding-bottom:20px; padding-top:10px; color:#7bc142"><u>See Your Invite History.</u></h3></a>
                <a href="javascript:void(0);" onclick="historyhide();" id="hidehistory" style="display:none;"><h3 style="padding-bottom:20px; padding-top:10px; color:#7bc142"><u>Hide Your Invite History.</u></h3></a>
             <div class="signupbox sign-up">
      
   <?php
   //echo 'SELECT * from tbl_invitefriends WHERE senderId="'.$_SESSION["userId"].'" ORDER BY createdDate DESC '.$limit.'';
   //echo 'SELECT * from tbl_invitefriends WHERE senderId="'.$_SESSION["userId"].'" ORDER BY createdDate DESC';
     $qrySelHistory = $con->recordselect('SELECT * from tbl_invitefriends WHERE senderId="'.$_SESSION["userId"].'" ORDER BY createdDate DESC '.$limit.'');
   			$qrySelHistoryTotal = $con->recordselect('SELECT * from tbl_invitefriends WHERE senderId="'.$_SESSION["userId"].'" ORDER BY createdDate DESC');
			 $total_num_records = mysql_num_rows($qrySelHistoryTotal);	
			 $total_rec = mysql_num_rows($qrySelHistory);	
			
				if(mysql_num_rows($qrySelHistory) > 0) { ?>
                
          
            
             <div class="message_heading">
               <h2 class="prctname">Email ID</h2>
                <h2 class="short_blurb">Date</h2>
                <h2 class="backed_ammount"></h2>
               
            </div>
            
        	<?php
			
				while($sel_inviteHistory=mysql_fetch_array($qrySelHistory)) {?>
				<ul id="search_ul_rec">
    		         <div class="prctname">
                   
                        <h6><?php if($sel_inviteHistory['mailAddress'] < 20 ){ 
						echo $sel_inviteHistory['mailAddress']; } else { 
						$newMail = tokenTruncate($sel_inviteHistory['mailAddress'], 20);
						echo $newMail;  }?></h6>
                        </div>
                   
                    
                   <div class="prctname">
                        <h6><?php echo date("m-d-Y H:i:s",$sel_inviteHistory['createdDate']); ?></h6>
                        
                    
                    <div class="clear"></div>
                </div>
                </ul>
			<?php }  ?>
          
            <div class="loadmorebtn">
          
                        <input type="hidden" value="<?php echo $perpage; ?>" id="found_rec">
                        <input type="hidden" value="<?php echo $total_num_records; ?>" id="total_num_records" />
                        <input type="hidden" value="<?php echo $total_rec ?>" id="total_qry_res" />
                        <?php if($total_num_records != $total_rec){ ?>
                            <a href="javascript:;" class="loadmorebtncenter" id="load_more_search">Load More...
                                <span id="wait_1" style="display: none;">
                                    <img alt="Please Wait" src="<?php echo SITE_IMG; ?>ajax-loader.gif">
                                </span>
                            </a>
                        <?php } ?>
                        <?php /*$con->onlyPagging($page,$per_page,8,2,0,1,$extra);*/ ?>
                    </div>
            </div>              
        <?php
			}else 
			{ ?>
        		<p class="no-content">You haven't invited any of your friends!</p>
		<?php } ?>

        		
           
       
             
   </div>
</section>

<script>
$(document).ready(function() {
	$("#load_more_search").click(function() {
	
		var $load_more = $(this);
		try {
			var $found_rec = $("#found_rec");
			var load_rec = parseInt($found_rec.val());
			var $total_num_records = $("#total_num_records");
			var total_num_records1 = parseInt($total_num_records.val());
			$("#wait_1").show();
			$.ajax({
				type		:	"POST",
				dataType	:	"json",
				url			:	"<?php echo SITE_URL; ?>modules/user/ajax.invitehistory.php",
				data		:	{
									per_page	:	'<?php echo $perpage; ?>',
									search_txt	:	'<?php echo $searchTerm; ?>',

									load_rec	:	load_rec
								},
				success		:	function (data) {
									if(parseInt(data["total_rec"]) > 0) {
										load_rec += parseInt(data["total_rec"]);
										$found_rec.val(load_rec);
										
										var html_data = data["html"];
										$("#wait_1").hide();
										$("#search_ul_rec").append(html_data);
										if(total_num_records1 == load_rec){
											$("#wait_1").hide();
											$load_more.hide();
										}
										
									} else {
										$("#wait_1").hide();
										$load_more.hide();
										
									}
								}
			})
		} catch(e) {
			console.log("Erro rin .load_more_search - " + e);
		}
	});
})
</script>