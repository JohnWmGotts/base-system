<script language="javascript">
$(document).ready(function() {
	
	$(".sandbox_div").hide();
	$(".live_div").hide();
	
	if($("#sandbox_radio").attr('data-value') == 'y'){
		$(".sandbox_div").show();
	}else{
		$(".live_div").show();
	}	
	
	$("#live_radio").change(function(){
		$("#semail").attr("disabled","disabled");
		$("#data").val('live');
		$(".sandbox_div").hide();
		$(".live_div").show();
		
	});
	$("#sandbox_radio").change(function(){
		$("#semail").removeAttr("disabled");
		$("#data").val('sandbox');
		$(".sandbox_div").show();
		$(".live_div").hide();
	});
		
	$("#frmPC").validate({
		rules: {
			semail: { required: true, email: true },
			lemail: { required: true, email: true },
			sappid: { required: true },
			lappid: { required: true },
			sapiusernm: { required: true },
			lapiusernm: { required: true },
			sapipsw: { required: true },
			lapipsw: { required: true },
			sapisgn: { required: true },
			lapisgn: { required: true },
		},
		messages: {
			semail: { required: "Developer Email Address is Require.",  email: "Please Enter Valid Email Address." },
			lemail: { required: "Developer Email Address is Require.",  email: "Please Enter Valid Email Address." },
			sappid: { required: "SandBox Application ID is Require." },
			lappid: { required: "Live Application ID is Require." },
			sapiusernm: { required: "SandBox API Username is Require." },
			lapiusernm: { required: "Live API Username is Require." },
			sapipsw: { required: "SandBox API Password is Require." },
			lapipsw: { required: "Live API Password is Require." },
			sapisgn: { required: "SandBox API Signature is Require." },
			lapisgn: { required: "Live API Signature is Require." },
		}
	});
	
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">Payment Credential</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
  </tr>
  <tr>
	<td width="10" align="left" class="content-left-bg"></td>
    
	<td class="content">
		<form action="payment_credential.php" method="post" name="frmPC" id="frmPC">
			<input type="hidden" name="data" id="data" value="" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <?php if(isset($error) && ($error!="")){ ?>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td align="left" class="error_msg"><?php print $error; ?></td>
                </tr>
                  <tr>
                    <td height="10" colspan="3"></td>
                  </tr>
              <?php } ?>
              <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="CHNGPC")){ ?>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td align="left" class="success"><?php echo "Your credentials change Successfully"; ?></td>
                </tr>
                  <tr>
                    <td height="10" colspan="3"></td>
                  </tr>
              <?php } ?>
              <tr>
                <td width="250" align="right"><strong>Environment :</strong></td>
                <td width="10">&nbsp;</td>
                <td colspan="2">SandBox
                <input name="env_radio" id="sandbox_radio" type="radio" value="sandbox" data-value="<?php if($rsw['sandbox'] == 'y'){echo 'y';}else{echo 'n';} ?>" <?php if($rsw['sandbox'] == 'y'){echo 'checked';} ?> />
                Live
                <input name="env_radio" id="live_radio" type="radio" value="live" <?php if($rsw['live'] == 'y'){echo 'checked';} ?> /></td>
              </tr>
              <tr>
                <td height="10" colspan="3"></td>
              </tr>
              
                    <tr class="sandbox_div">
                        <td width="250" align="right"><strong>SandBox Developer Email :</strong></td>
                        <td width="10">&nbsp;</td>
                        <td><input name="semail" id="semail" type="text" class="logintextbox-bg" value="<?php echo base64_decode($rsw['sandbox_developer_account_email']); ?>" size="15" /></td>
                    </tr>
                    <tr class="sandbox_div">
                   	 <td height="10" colspan="3"></td>
                    </tr>
                    <tr class="sandbox_div">
                        <td width="250" align="right"><strong>SandBox Application ID :</strong></td>
                        <td width="10">&nbsp;</td>
                        <td><input name="sappid" id="sappid" type="text" class="logintextbox-bg" value="<?php echo $rsw['sandbox_application_id']; ?>" size="15" /></td>
                    </tr>
                    <tr class="sandbox_div">
                   		<td height="10" colspan="3"></td>
                    </tr>
                    <tr class="sandbox_div">
                        <td width="250" align="right"><strong>SandBox API Username :</strong></td>
                        <td width="10">&nbsp;</td>
                        <td><input name="sapiusernm" id="sapiusernm" type="text" class="logintextbox-bg" value="<?php echo base64_decode($rsw['sandbox_api_username']); ?>" size="15" /></td>
                    </tr>
                    <tr class="sandbox_div">
                    	<td height="10" colspan="3"></td>
                    </tr>
                    <tr class="sandbox_div">
                    	<td width="250" align="right"><strong>SandBox API Password :</strong></td>
                        <td width="10">&nbsp;</td>
                        <td><input name="sapipsw" id="sapipsw" type="text" class="logintextbox-bg" value="<?php echo $rsw['sandbox_api_password']; ?>" size="15" /></td>
                    </tr>
                    <tr class="sandbox_div">
                    	<td height="10" colspan="3"></td>
                    </tr>
                    <tr class="sandbox_div">
                        <td width="250" align="right"><strong>SandBox API Signature :</strong></td>
                        <td width="10">&nbsp;</td>
                        <td><input name="sapisgn" id="sapisgn" type="text" class="logintextbox-bg" value="<?php echo $rsw['sandbox_api_signature']; ?>" size="15" /></td>
                    </tr>
                    <tr >
                        <td height="10" colspan="3"></td>
                      </tr>
              		
                 <tr class="live_div">
                    <td width="250" align="right"><strong>Live Admin Email :</strong></td>
                    <td width="10">&nbsp;</td>
                    <td><input name="lemail" id="lemail" type="text" class="logintextbox-bg" value="<?php echo base64_decode($rsw['live_admin_account_email']); ?>" size="15" /></td>
                </tr>
                <tr class="live_div">
                 <td height="10" colspan="3"></td>
                </tr>
                      
                  <tr class="live_div">
                    <td width="250" align="right"><strong>Live Application ID :</strong></td>
                    <td width="10">&nbsp;</td>
                    <td><input name="lappid" id="lappid" type="text" class="logintextbox-bg" value="<?php echo $rsw['live_application_id']; ?>" size="15" /></td>
                  </tr>
                  <tr class="live_div">
                    <td height="10" colspan="3"></td>
                  </tr>
                  <tr class="live_div">
                    <td width="250" align="right"><strong>Live API Username :</strong></td>
                    <td width="10">&nbsp;</td>
                    <td><input name="lapiusernm" id="lapiusernm" type="text" class="logintextbox-bg" value="<?php echo base64_decode($rsw['live_api_username']); ?>" size="15" /></td>
                  </tr>
                  <tr class="live_div">
                    <td height="10" colspan="3"></td>
                  </tr>
                  <tr class="live_div">
                    <td width="250" align="right"><strong>Live API Password :</strong></td>
                    <td width="10">&nbsp;</td>
                    <td><input name="lapipsw" id="lapipsw" type="text" class="logintextbox-bg" value="<?php echo $rsw['live_api_password']; ?>" size="15" /></td>
                  </tr>
                  <tr class="live_div">
                    <td height="10" colspan="3"></td>
                  </tr>
                  <tr class="live_div">
                    <td width="250" align="right"><strong>Live API Signature :</strong></td>
                    <td width="10">&nbsp;</td>
                    <td><input name="lapisgn" id="lapisgn" type="text" class="logintextbox-bg" value="<?php echo $rsw['live_api_signature']; ?>" size="15" /></td>
                  </tr>
             
              
              <tr>
                <td height="10" colspan="3"></td>
              </tr>
                <td width="250" align="right">&nbsp;</td>
                <td width="10">&nbsp;</td>
                <td>
                    <input name="" type="image" src="<?php echo SITE_ADM_IMG;?>bt_change.gif" title="Change" /> &nbsp; <a href="<?php echo SITE_ADM;?>home.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
                </td>
              </tr>
              <tr>
                <td height="10" colspan="3"></td>
              </tr>
		</table>
		</form>
	</td>
	<td width="10" align="right" class="content-right-bg"></td>
  </tr>
  <tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>content-main-box-bottom-left.gif" alt="img" /></td>
	<td class="content-bottom-bg"></td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>content-main-box-bottom-right.gif" alt="img" /></td>
  </tr>
</table>