<?php 
	// jwg .. following was used to make non-conformative actual payment from backer to owner
	//  and similar should be used in final payment process using preapproval keys of backers.
	//  $Pay and $final_array were setup in modules/projectBacker/index.php, but $Pay setup noop'd in lieu of form submit for preapproval.
	//$redirect_paypal_url=$Pay->takePreApprovalFromBacker($final_array);;
	// 

if(isset($_SESSION['msgType1']) && $_SESSION['msgType1']!='')
{
	$_SESSION['msgType'] =$_SESSION['msgType1'];
}
?>
<section id="container" class="backer_reward">
   <script type="text/javascript" src="Common/sdk_functions.js"></script>
   <div id="get_started_header_detail" class="head_content temp">
    	<a href="<?php echo SITE_URL.'browseproject/'.$projectBasic['projectId'].'/'.Slug($projectBasic['projectTitle']).'/'; ?>" >
	        <h3><?php echo unsanitize_string(ucfirst($projectBasic['projectTitle'])); ?></h3>
        </a>
        <p id="marginbottom30">by
        	<a href="<?php echo SITE_URL.'profile/'.$projectByUser['userId'].'/'.Slug($projectByUser['name']).'/'; ?>" >
        		<?php echo unsanitize_string(ucfirst(trim($projectByUser['name']))); ?>
        	</a>
        </p>
    </div>
   <div class="wrapper ">
        <div class="tabs_content_bg">
                <div class="tab_content">
                	<div class="tabs_left">
                    	<div class="tabs_left_pledge">
							<div class="tout_checkout">
							<h1>Check out with Paypal</h1>
							</div>
							<div class="pledges__checkout_summary">
								<dl>
									<dt>Pledge amount</dt>
									<dd>
										<strong class="pledge_amount">
											<span class="money usd ">$<?php echo $final_considered_amount;?></span>
											<a href="<?php echo $base_url;?>projectBacker/<?php echo sanitize_string($searchTerm).'/';?>" class="edit">Edit</a>
										</strong>
									</dd>
                                    <?php if($projectReward>0){?>
									<dt>Selected reward</dt>
									<dd class="reward">
										<h3 class="title">
										Pledge
										<span class="money usd ">$<?php print $final_considered_amount;?></span>
										</h3>
										<p class="description short">
										<?php print $rewardDetails['description'];?>
										
										</p>
										<?php /*?><p class="description full">Receive a limited edition "Like Clockwork" vinyl sticker only available to Kickstarter supporters and a public thank you on our Facebook and Website.</p><?php */?>
										<p class="delivery_date">
										Estimated delivery:
										<?php echo date("M", mktime(0, 0, 0, $rewardDetails['estimateDeliveryMonth'], 10));?> <?php echo $rewardDetails['estimateDeliveryYear'];?>
										</p>
										<?php /*?><p>
										Ships within the US only
										</p><?php */?>
										
										</dd>
                                        <?php } ?>
								</dl>	
							</div>
							
							<div class="checkout_actions">
							<div class="float-left"><img src="<?php print SITE_IMG;?>paypal.png" /></div>
							<?php
							 /* jwg - replace following, which would have done immediate payment
							  <a href="<?php print $redirect_paypal_url;?>" class="button button_green">Continue To Payment</a>
								Instead, take user back into projectBacker/index.php to do preapproval.
							 */
							?>
								<form id="projectBacker" name="projectBacker" method="post" action="<?php echo $base_url;?>projectBacker/">
									<input type="hidden" name="amount" value="<?php echo $final_array['amount']; ?>" />
									<input type="hidden" name="rewardId" value="<?php echo $final_array['rewardId'] ?>" />
									<input type="hidden" name="projectId" value="<?php echo $final_array['projectId']; ?>" />
									<input type="hidden" name="backerId" value="<?php echo $final_array['backer_id']; ?>" />
									<input type="hidden" name="preapprove_backing" value="1" />
									<input type="submit" name="submit" value="Pre-authorize Pledge" title = "Pre-authorize pledge amount. Payment will NOT occur until project end date, and only if funding goal reached." class="button button_green" />
								</form>
							</div>
							
						</div>
						
					</div>
					<!--
                    <div class="tab_right">
    					<div class="pledges_checkout_accountability">
							<h6><span>Important</span></h6>
							<p>Dynamically supply competitive core competencies via timely e-commerce. Dynamically syndicate principle-centered architectures with stand-alone collaboration and idea-sharing. Continually architect process-centric infrastructures whereas resource-leveling potentialities.</p>
							<p><a href="#">Learn more about accountability</a></p>
						</div>
					</div>
					-->
                    <div class="clear"></div>
                    	
                </div>
            </div>
   </div>  
</section>


<?php /*?>
<link type="text/css" href="<?php echo SITE_CSS; ?>jquery-ui-1.8.20.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo SITE_JAVA; ?>jquery-ui-1.8.20.custom.min.js"></script>
<script language="JavaScript">
	function generateCC(){
		var cc_number = new Array(16);
		var cc_len = 16;
		var start = 0;
		var rand_number = Math.random();

		switch(document.DoDirectPaymentForm.creditCardType.value)
        {
			case "Visa":
				cc_number[start++] = 4;
				break;
			case "Discover":
				cc_number[start++] = 6;
				cc_number[start++] = 0;
				cc_number[start++] = 1;
				cc_number[start++] = 1;
				break;
			case "MasterCard":
				cc_number[start++] = 5;
				cc_number[start++] = Math.floor(Math.random() * 5) + 1;
				break;
			case "Amex":
				cc_number[start++] = 3;
				cc_number[start++] = Math.round(Math.random()) ? 7 : 4 ;
				cc_len = 15;
				break;
        }

        for (var i = start; i < (cc_len - 1); i++) {
			cc_number[i] = Math.floor(Math.random() * 10);
        }

		var sum = 0;
		for (var j = 0; j < (cc_len - 1); j++) {
			var digit = cc_number[j];
			if ((j & 1) == (cc_len & 1)) digit *= 2;
			if (digit > 9) digit -= 9;
			sum += digit;
		}

		var check_digit = new Array(0, 9, 8, 7, 6, 5, 4, 3, 2, 1);
		cc_number[cc_len - 1] = check_digit[sum % 10];

		document.DoDirectPaymentForm.creditCardNumber.value = "";
		for (var k = 0; k < cc_len; k++) {
			document.DoDirectPaymentForm.creditCardNumber.value += cc_number[k];
		}
	}
	$(document).ready(function() {
		$('#tabs').tabs();
	$("#paypalProjectBacker").validate({
		rules: {
            firstName: { required: true},
			creditCardNumber: { required: true },
			cvv2Number :{required: true}
		},
		messages: {
			firstName: {
				required: "Please enter your name"
			},
			creditCardNumber: {
				required: "Please enter credit card number"
			},
			cvv2Number: {
				required: "Please enter credit card verification code"
			}
		}
	});
		});	
</script>
<div class="content-area-lsized1" id="popular" >
  <div class="content-area">
    <div class="staff-picks-main" style=" float:left; width:73%;">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Pay with PayPal</a></li>
          <li><a href="#tabs-2">Pay with WePay</a></li>
        </ul>
        <div id="tabs-1">
          <div>
            <form id="paypalProjectBacker" action="<?php echo $base_url;?>modules/projectBacker/DoDirectPaymentReceipt.php" name="DoDirectPaymentForm" method="post">
              <input type="hidden" name="paymentType" value="Sale" />
              <input type="hidden" name="projectId" value="<?php echo $searchTerm ;?>" />
              <input type="hidden" name="rewardId" value="<?php echo $projectReward ;?>" />
              <fieldset class="step">
                <div>
                  <div class="padtop10"></div>
                  <div class="blue-field">
                    <div class="grey-field-left1 fl">
                      <h6>Name</h6>
                    </div>
                    <div class="grey-field-right1 fr marginLeftZero">
                      <input type="text" size="30" maxlength="32" name="firstName" id="firstName" value="<?php echo $userDetails['name'];?>" class="inputClass" style="width: 188px;">
                      <input type="hidden" size="30" maxlength="32" name="lastName" id="lastName" value="<?php echo $userDetails['name'];?>" class="inputClass">
                    </div>
                    <div class="clear"></div>
                  </div>
                  <div class="blue-field">
                    <div class="grey-field-left1 fl">
                      <h6>Card Type</h6>
                    </div>
                    <div class="grey-field-right1 fr marginLeftZero">
                      <select name="creditCardType" onChange="javascript:generateCC(); return false;" class="inputClass" style="width: 200px;">
                        <option value="Visa" selected>Visa</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="Discover">Discover</option>
                        <option value="Amex">American Express</option>
                      </select>
                    </div>
                    <div class="clear"></div>
                  </div>
                  <div class="blue-field">
                    <div class="grey-field-left1 fl">
                      <h6>Card Number</h6>
                    </div>
                    <div class="grey-field-right1 fr marginLeftZero">
                      <input type="text" size="19" maxlength="19" name="creditCardNumber" class="inputClass" style="width: 188px;">
                    </div>
                    <div class="clear"></div>
                  </div>
                  <div class="blue-field">
                    <div class="grey-field-left1 fl">
                      <h6>Expiration Date</h6>
                    </div>
                    <div class="grey-field-right1 fr marginLeftZero">
                      <select name="expDateMonth" class="width98">
                        <option value=1>01</option>
                        <option value=2>02</option>
                        <option value=3>03</option>
                        <option value=4>04</option>
                        <option value=5>05</option>
                        <option value=6>06</option>
                        <option value=7>07</option>
                        <option value=8>08</option>
                        <option value=9>09</option>
                        <option value=10>10</option>
                        <option value=11>11</option>
                        <option value=12>12</option>
                      </select>
                      <select name="expDateYear" class="width98">
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2015">2016</option>
                        <option value="2015">2017</option>
                        <option value="2015">2018</option>
                        <option value="2015">2019</option>
                      </select>
                    </div>
                    <div class="clear"></div>
                  </div>
                  <div class="blue-field">
                    <div class="grey-field-left1 fl">
                      <h6>Card Verification Number</h6>
                    </div>
                    <div class="grey-field-right1 fr marginLeftZero">
                      <input type="text" size="3" maxlength="4" name="cvv2Number" id="cvv2Number" value="962" class="inputClass" style="width: 188px;">
                    </div>
                    <div class="clear"></div>
                  </div>
                  <!--<span><b>Billing Address:</b></span>
            <hr class="horizontalRule"/>
            <div class="blue-field">
              <div class="grey-field-left1 fl">
                <h6>Address 1:</h6>
              </div>
              <div class="grey-field-right1 fr">       
				<input type=text size=25 maxlength=100 name=address1 class="inputClass">                  
              </div>
              <div class="clear"></div>
            </div>
            <div class="blue-field">
              <div class="grey-field-left1 fl">
                <h6>Address 2:</h6>
              </div>
              <div class="grey-field-right1 fr">       
				<input type=text size="25" maxlength="100" name="address2" class="inputClass">                  
              </div>
              <div class="clear"></div>
            </div>
            <div class="blue-field">
              <div class="grey-field-left1 fl">
                <h6>City:</h6>
              </div>
              <div class="grey-field-right1 fr">       
				<input type=text size="25" maxlength="40" name="city" class="inputClass">                  
              </div>
              <div class="clear"></div>
            </div>
            <div class="blue-field">
              <div class="grey-field-left1 fl">
                <h6>State:</h6>
              </div>
              <div class="grey-field-right1 fr">       
				<select id=state name=state>
				<option value='' selected="selected"></option>
				<option value=AK>AK</option>
				<option value=AL>AL</option>
				<option value=AR>AR</option>
				<option value=AZ>AZ</option>
				<option value=CA>CA</option>
				<option value=CO>CO</option>
				<option value=CT>CT</option>
				<option value=DC>DC</option>
				<option value=DE>DE</option>
				<option value=FL>FL</option>
				<option value=GA>GA</option>
				<option value=HI>HI</option>
				<option value=IA>IA</option>
				<option value=ID>ID</option>
				<option value=IL>IL</option>
				<option value=IN>IN</option>
				<option value=KS>KS</option>
				<option value=KY>KY</option>
				<option value=LA>LA</option>
				<option value=MA>MA</option>
				<option value=MD>MD</option>
				<option value=ME>ME</option>
				<option value=MI>MI</option>
				<option value=MN>MN</option>
				<option value=MO>MO</option>
				<option value=MS>MS</option>
				<option value=MT>MT</option>
				<option value=NC>NC</option>
				<option value=ND>ND</option>
				<option value=NE>NE</option>
				<option value=NH>NH</option>
				<option value=NJ>NJ</option>
				<option value=NM>NM</option>
				<option value=NV>NV</option>
				<option value=NY>NY</option>
				<option value=OH>OH</option>
				<option value=OK>OK</option>
				<option value=OR>OR</option>
				<option value=PA>PA</option>
				<option value=RI>RI</option>
				<option value=SC>SC</option>
				<option value=SD>SD</option>
				<option value=TN>TN</option>
				<option value=TX>TX</option>
				<option value=UT>UT</option>
				<option value=VA>VA</option>
				<option value=VT>VT</option>
				<option value=WA>WA</option>
				<option value=WI>WI</option>
				<option value=WV>WV</option>
				<option value=WY>WY</option>
				<option value=AA>AA</option>
				<option value=AE>AE</option>
				<option value=AP>AP</option>
				<option value=AS>AS</option>
				<option value=FM>FM</option>
				<option value=GU>GU</option>
				<option value=MH>MH</option>
				<option value=MP>MP</option>
				<option value=PR>PR</option>
				<option value=PW>PW</option>
				<option value=VI>VI</option>
			</select>                 
              </div>
              <div class="clear"></div>
            </div>
            <div class="blue-field">
              <div class="grey-field-left1 fl">
                <h6>ZIP Code:</h6>
              </div>
              <div class="grey-field-right1 fr">       
				<input type=text size="10" maxlength="10" name="zip" class="inputClass">                  
              </div>
              <div class="clear"></div>
            </div>
            <div class="blue-field">
              <div class="grey-field-left1 fl">
                <h6>Country:</h6>
              </div>
              <div class="grey-field-right1 fr">       
					United States               
              </div>
              <div class="clear"></div>
            </div>-->
                  <div class="blue-field">
                    <div class="grey-field-left1 fl">
                      <h6>Amount</h6>
                    </div>
                    <div class="grey-field-right1 fr marginLeftZero" style="font-weight: bold; color: black; padding: 5px;">
                      <input type="hidden" size="4" maxlength="7" name="amount" value="<?php echo $final_considered_amount;?>" readonly="readonly">
                      $<?php echo $final_considered_amount;?> </div>
                    <div class="clear"></div>
                  </div>
                  <hr class="horizontalRule" />
                  <div>
                    <div class="grey-field-left1 fl">
                      <input type="image" src="<?php echo $base_url;?>images/back-project.png" value="Submit">
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
          <div style="clear:both;"></div>
        </div>
        
        <div id="tabs-2">
          <?php
$client_id = "169288";
$client_secret = "dc82477c2c";
$access_token = "0ca67498adb22bc3414b2583267fe38e1ad2204a33da3d9e4388afb2d7572c01";
$account_id = "1771720781"; // you can find your account ID via list_accounts.php which users the /account/find call

/** 
 * Initialize the WePay SDK object 
 /
require 'wepay.php';
Wepay::useProduction($client_id, $client_secret);
$wepay = new WePay($access_token);
try {
	$checkout = $wepay->request('/checkout/create', array(
			'account_id' => $account_id, // ID of the account that you want the money to go to
			'amount' => $rewardDetails['pledgeAmount'], // dollar amount you want to charge the user
			'short_description' => $rewardDetails['description'], // a short description of what the payment is for
			'type' => "SERVICE", // the type of the payment - choose from GOODS SERVICE DONATION or PERSONAL
			'mode' => "iframe", // put iframe here if you want the checkout to be in an iframe, regular if you want the user to be sent to WePay
			'callback_uri' => "http://demo.ncryptedprojects.com/fundraiser2/modules/projectBacker/notification.php?rewardId=".$projectReward."&projectId=".$searchTerm."&userId=".$_SESSION['userId'], // callback url for the applicaiton
			'redirect_uri' => "http://demo.ncryptedprojects.com/fundraiser2/modules/browse/browseproject.php?project=".$searchTerm,
		)
	);
} catch (WePayException $e) { // if the API call returns an error, get the error message for display later
	$error = $e->getMessage();
}
?>
          <?php if (isset($error)): ?>
          <h2 style="color:red">ERROR: <?php echo $error ?></h2>
          <?php else: ?>
          <div id="checkout_div"></div>
          <script type="text/javascript" src="http://clients.ncrypted.net/fundraiser/js/wepay.js">
			</script> 
          <script type="text/javascript">
		  <!--CDATA
			WePay.iframe_checkout("checkout_div", "<?php echo $checkout->checkout_uri ?>");
			-->
			</script>
          <?php endif; ?>
          <style type="text/css">
		  #if-footer
		  {
			  max-height:auto !important;
		  }
		  </style>
        </div>
      </div>
    </div>
    <div class="sidebar fl searchSidebar" style="width:240px;">
      <div class="padbot10"> <span>
        <h2>Project Details</h2>
        </span>
        <div> 
          <!--<a href="<?php //echo $base_url;?>modules/browse/browseproject.php?project=<?php //echo $rewardDetails['projectId'];?>">-->
          <a href="<?php echo $base_url;?>browseproject/project/<?php echo $rewardDetails['projectId'];?>">
          <?php if($sel_image['image100by80']!='' && file_exists(DIR_FS.$sel_image['image100by80']) && mysql_num_rows($sel_image_check)>0) { ?>
          <img src="<?php echo SITE_URL.$sel_image['image100by80']; ?>" width="200" height="160" alt="<?php echo ucfirst($projectBasic['projectTitle']); ?>" title="<?php echo ucfirst($projectBasic['projectTitle']); ?>" />
          <?php } else { ?>
          <img src="<?php echo NOIMG; ?>" width="200" height="160" alt="<?php echo ucfirst($projectBasic['projectTitle']); ?>" title="<?php echo ucfirst($projectBasic['projectTitle']); ?>" />
          <?php } ?>
          </a> </div>
        <div class="wordwrap">
        	<!--<a href="<?php //echo $base_url;?>modules/browse/browseproject.php?project=<?php //echo $rewardDetails['projectId'];?>"><?php //echo $projectBasic['projectTitle'];?>-->
            <a href="<?php echo $base_url;?>browseproject/project/<?php echo $rewardDetails['projectId'];?>"><?php echo $projectBasic['projectTitle'];?>
            </a>
        </div>
        <div class="padtop10"></div>
        <div>By <?php echo $projectByUser['name'];?></div>
        <div class="padtop10"></div>
        <div><strong>Funding Ends on <?php echo  date('l M d\, h:ia ', $projectBasic['projectEnd']);  ?></strong></div>
      </div>
      <div class="padbot10"> <span>
        <h2>Reward Details</h2>
        </span>
        <div class="backerLeft"><strong>Pledge:</strong></div>
        <div class="bakerRight">$<?php echo $rewardDetails['pledgeAmount'];?></div>
        <div class="padtop10">&nbsp;</div>
        <div class="backerLeft"><strong>Selected Reward:</strong></div>
        <div class="bakerRight wordwrap"> <?php echo $rewardDetails['description'];?></div>
        <div class="padtop10">&nbsp;</div>
        <div class="backerLeft"><strong>Est. Delivery:</strong> </div>
        <div class="bakerRight"><?php echo date("M",$rewardDetails['estimateDeliveryMonth']);?> <?php echo $rewardDetails['estimateDeliveryYear']; ?></div>
      </div>
    </div>
  </div>
  <!--.content-area-->
  <div class="clear"></div>
</div>
<!--.content-area-lsized--> 
<!-- End Popular this week  --> 
<script language="javascript">
	generateCC();
</script><?php */?>