<script type="text/javascript" src="includes/paypal/Common/sdk_functions.js"></script> 
<script type="text/javascript" language="javascript">

function radioClicked(val,amount)
{
	
	//document.querySelectorAll('[id^=span_]*').style.display = none;	
	$('[id^=span_]').css("display","none");
	document.getElementById('span_'+val).style.display = "block";
	if(val>0)
	{
		$('#pledgeAmount_custom').val(amount);
		$('#labelreward').html("Pledge: $"+amount+" + <br/><br/>");
		$('#pledgeAmount_custom').attr('readonly',true);
		$(".hideshow1 input").val('0');
		var backval = $("#hiddenBackval").val();
		if(backval!='') {
		$(".hideshow1 input").val(backval);
		}
		else {
			$(".hideshow1 input").val('0');
		}
		//new change
		projectId = $("#hiddenpId").val();
		$("#hiddenprId").val(projectId)
		$(".hideshow1").show();
		$(".hideshow2").show();
		$(".showtext").hide();
		$(".showtextbox").hide();
		
	}
	else
	{
		//$('#pledgeAmount_custom').val(0);
		var backval = $("#hiddenBackval").val();
		//alert(backval);
		if(backval!='') {
		$("#pledgeAmount_custom").val(backval);
		$('#rewardPledgeAmount_custom').val('0');
		}
		else {
			$("#pledgeAmount_custom").val('0');
			$('#rewardPledgeAmount_custom').val('0');
		}
		
		$('#pledgeAmount_custom').attr('readonly',false);
		//new change
		$(".hideshow1").hide();
		$(".hideshow2").hide();
		projectId = $("#hiddenpId").val();
		$("#hiddenprId").val(projectId);
		$(".showtext").show();
		$(".showtextbox").show();
	$('#labelreward').html("");
	}
	
}
var selected_val=0;
var selected_amount=0;

$(document).ready(function() {
	$('#pledgeAmount_custom').on('change', function() {
		var backamount = $('#pledgeAmount_custom').val();
		$("#hiddenBackval").val(backamount);
	});
	$('#rewardPledgeAmount_custom').on('change', function() {
		var backamount = $('#rewardPledgeAmount_custom').val();
		$("#hiddenBackval").val(backamount);
	});

	projectId = $("#hiddenpId").val();
	$("#hiddenprId").val(projectId)
	$(".hideshow1").hide();
	$(".hideshow2").hide();
	selected_val=$('input[name="projectReward"][type="radio"]:checked').val(); // rewardId
	selected_amount=$('input[name="projectReward"][type="radio"]:checked').attr("data-amt");
	
	radioClicked(selected_val,selected_amount);
	$.validator.addMethod('positiveNumber',
    function (value) { 
        return parseInt(value) > parseInt(0);
    }, 'Enter a valid Amount');
	
	$("#projectBacker").validate({
		rules: {
            pledgeAmount_custom: { 
							required: {
								depends: function(element) {
									var checked_val=parseInt($('input[name="projectReward"][type="radio"]:checked').val());
									return (checked_val>0 || checked_val=='undefined')?false:true;
								}
							},
							positiveNumber:{depends: function(element) {
									var checked_val=parseInt($('input[name="projectReward"][type="radio"]:checked').val());
									//alert((checked_val>0 || checked_val=='undefined')?false:true);
									return (checked_val>0 || checked_val=='undefined')?false:true;
								}
							},
							number:{
									depends: function(element) {
									var checked_val=parseInt($('input[name="projectReward"][type="radio"]:checked').val());
									return (checked_val>0 || checked_val=='undefined')?false:true;
								}
							}
						}
		},
		 unhighlight:function (element, errorClass, validClass) {
			// $('.flash-error').html(error+"<div class='space20'></div>");
			$('.flash-error').hide();
		 },
		messages: {
			pledgeAmount_custom: {
				required: "Please enter a pledge amount.",
				positiveNumber:"Please enter valid price.",
				number:"Please enter only number"
			}
		},
		errorPlacement: function(error, element) {
			
			$('.flash-error').html(error[0].textContent);
			$('.flash-error').show();
			
		  }
	});
	$(".backer_reward_field li").click(function(){
		
		$(this).find(":radio").attr("checked",true);
		var value=$(this).find(":radio:checked").val();
		var amount=$(this).find(":radio:checked").attr("data-amt");
		radioClicked(value,amount);
	});
});	
</script>

<section id="container" class="backer_reward">
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
  
   <div class="wrapper">
        <div class="tabs_content_bg">
                <div class="tab_content">
                	<div class="tabs_left">
                    	<form id="projectBacker" name="projectBacker" method="post" action="<?php echo $base_url;?>projectBacker/">
                    		<div class="tabs_left_pledge">
							<h1>Thanks for your support!</h1>
							<small>Enter your pledge amount</small>
                            <p class="flash-error hide">Please enter a pledge amount. </p>
                           <div class="space20"></div>
							<div class="pledges__checkout_amount">
								<div class="backing_amount_wrapper">
                                	<div class="showtextbox"> 
										<input type="text" id="pledgeAmount_custom" name="pledgeAmount_custom" class="required backing_amount usd text" value="" /></div>
									<input type="hidden" name="projectId" id="hiddenBackval" value=""  />          
									<input type="hidden" name="projectId" id="hiddenpId" value="<?php echo $searchTerm;?>"  />
								</div>
                                
								<div class="help showtext">It's up to you. <br />Any amount of $1 or more.</div>
                                
                               <!-- as per new changes starts-->
                                <div class="backing_amount_wrapper hideshow1" style="padding-top:25px;">
                                <label id="labelreward" style="font-size:27px;"></label>
                                	 <input type="text" id="rewardPledgeAmount_custom" name="rewardPledgeAmount_custom" class="required backing_amount usd text" value="0" />
                <input type="hidden" name="projectId2" id="hiddenprId" value=""  />
								</div>
								<div class="help hideshow2" style="padding-top:70px; ">If you wish you may pledge<br />an additional amount here.</div>
								<!--as per new changes ends-->
                                
							</div>
							<div class="backer_reward_field">
								<h3>Select your reward</h3>
								<ul>
									<li>
										<input class="radio" onclick="javascript:radioClicked(this.value,'0');" name="projectReward" title="No reward" type="radio" value="0">
										<label class="minimum">No reward</label>
                                         <span id="span_0" class="selected selectedBacker"style="display:none;">selected</span>
										<div class="reward_description">
											<p>No thanks, I just want to help the project.</p>
										</div>
                                        
									</li>
                                    
                         <?php 	if(mysql_num_rows($sel_staff2)>0)
							{				
								while ($approved_chk = mysql_fetch_assoc($sel_staff2))
								{						
						?>		
									<li>
										
									  <?php
									  $soldFlag = 0;			
										if($approved_chk['limitAvailable']==0)
										{					
											$soldFlag = 0;
												
												
											?>	
											<input class="radio" onclick="javascript:radioClicked(this.value,'<?php echo (isset($approved_chk['pledgeAmount'])) ? $approved_chk['pledgeAmount'] : 0;?>');" id="input_<?php print (isset($approved_chk['rewardId'])) ? $approved_chk['rewardId'] : 0;?>"  data-amt="<?php echo (isset($approved_chk['pledgeAmount'])) ? $approved_chk['pledgeAmount'] : 0;?>" name="projectReward" title="for pledge of at least $<?php echo (isset($approved_chk['pledgeAmount'])) ? $approved_chk['pledgeAmount'] : 0;?>" type="radio" value="<?php echo (isset($approved_chk['rewardId'])) ? $approved_chk['rewardId'] : 0;?>" <?php if(isset($_GET['rewardId']) && ($_GET['rewardId']!='')){ if($_GET['rewardId'] == $approved_chk['rewardId']){?> checked = "checked"<?php }}?>>
											<label class="minimum">$<?php echo $approved_chk['pledgeAmount'];?> pledge</label>
											 <span id="span_<?php echo (isset($approved_chk['rewardId'])) ? $approved_chk['rewardId'] : '';?>" class="selected selectedBacker" <?php if(isset($_GET['rewardId']) && ($_GET['rewardId']!='')){ if($_GET['rewardId'] == $approved_chk['rewardId']){?> style="display:block;"<?php }else{?>style="display:none;"<?php }}else{?>style="display:none;"<?php }?>>selected</span>
									   
									   
										<?php 
										}
										else
										{					
											$qr = $con->recordselect("select count(*) as TotalRewards from projectbacking where rewardId = ".$approved_chk['rewardId']);
											
											if(mysql_num_rows($qr)>0)
											{
												$qrRow = mysql_fetch_assoc($qr);
												$proejctRewards = $qrRow['TotalRewards'];
											}
											else
											{
												$proejctRewards = 0;
											}
											
											$pendingRewards = $approved_chk['limitAvailable'] - $proejctRewards;
											if($pendingRewards==0)
											{
												$soldFlag = 1;
												?>
												  <input class="radio" id="input_<?php print $approved_chk['rewardId'];?>" value="<?php print $approved_chk['rewardId'];?>" data-amt="<?php echo $approved_chk['pledgeAmount'];?>" disabled="disabled" name="projectReward" title="$<?php echo $approved_chk['pledgeAmount'];?>" type="radio" >
												  <label class="minimum">$<?php echo $approved_chk['pledgeAmount'];?> pledge</label>
											
													<span id="soldOut" class="selected">SoldOut</span>
												
											<?php }
											else
											{
												$rewardId = (isset($approved_chk) && array_key_exists('rewardId', $approved_chk)) ? $approved_chk['rewardId'] : '';
												$pledgeAmount = (isset($approved_chk) && array_key_exists('pledgeAmount',$approved_chk)) ? $approved_chk['pledgeAmount'] : '';
											?>
											<input class="radio" id="input_<?php print $rewardId; ?>" onclick="javascript:radioClicked(this.value,'<?php echo $pledgeAmount;?>');" data-amt="<?php echo $pledgeAmount;?>"  name="projectReward" title="$<?php echo $pledgeAmount;?>" type="radio" value="<?php echo $rewardId;?>" <?php if(isset($_GET) && isset($_GET['rewardId']) && ($_GET['rewardId']!='')){ if(isset($_GET) && isset($_GET['rewardId']) && ($_GET['rewardId'] == $rewardId)){?> checked = "checked"<?php }}?>>
											 <label class="minimum">$<?php echo $pledgeAmount;?> pledge</label>
											 <span id="span_<?php echo $rewardId;?>" class="selectedBacker selected" style="display:none;">selected</span>
												
										<?php }
									
										} ?>
										
									  <div class="reward_description" <?php if($soldFlag == 1){ ?>class="disabled" <?php } ?>>
														<p><?php echo (isset($approved_chk) && isset($approved_chk['description'])) ? $approved_chk['description'] : '';?></p>
										
										<?php
										if($approved_chk['limitAvailable']==0)
										{
											
										}
										else
										{
											$qr = $con->recordselect("select count(*) as TotalRewards from projectbacking where rewardId = ".$approved_chk['rewardId']);
											if(mysql_num_rows($qr)>0)
											{
												$qrRow = mysql_fetch_assoc($qr);
												$proejctRewards = $qrRow['TotalRewards'];
											}
											else
											{
												$proejctRewards = 0;
											}					
											$pendingRewards = $approved_chk['limitAvailable'] - $proejctRewards;
											?>
											<p <?php if($soldFlag == 1){ ?>class="disabled" <?php } ?>>(<?php echo $pendingRewards;?> of <?php echo round($approved_chk['limitAvailable'],0);?> remaining)</p>
									<?php } ?>
										 <small>Est. Delivery: <?php echo date("M", mktime(0, 0, 0, $approved_chk['estimateDeliveryMonth'], 10));?> <?php echo $approved_chk['estimateDeliveryYear'];?></small>
									 
										</div>
								 
									</li>			
						<?php
								}	
							}
						?>
                
								</ul>
							</div>
							<div class="pledge_actions">
								<?php /*?><div class="pledge_actions_left">Ship to the US. <a href="#">Change</a></div><?php */?>
								<div class="pledge_actions_right">
									<input name="continue" type="submit" value="Continue To Next Step">
								</div>
							</div>
						</div>
						</form>
					</div>
                    <div class="tab_right">
    					<div class="pledges_checkout_accountability">
							<h6><span>NOTE</span></h6>
							<p>If you select a reward the associated pledge amount will be used.</p>
							<p>You may choose to pledge an additional amount. Or, you may pledge an amount without any reward.</p>
							<!-- <p><a target="_blank" href="<?php echo SITE_URL;?>help/1/#accountability/">Learn more about accountability</a></p> -->
						</div>
					</div>
                    <div class="clear"></div>
                    	
                </div>
            </div>
   </div>
   <div class="small_vert_pad"></div>
</section>