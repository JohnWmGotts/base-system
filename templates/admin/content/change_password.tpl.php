<script language="javascript">
$(document).ready(function() {
	$.validator.addMethod("AlphaNumRegex", function(value, element) {
		return this.optional(element) || /^[a-z0-9\_-]+$/i.test(value);
	}, "This must contain only letters, numbers, underscore or dashes.");
	
	$("#frmCP").validate({
		rules: {
			opasswd: { 
				required: true,
				equalTo: "#passvalue" 
			},
			passwd: { required: true, minlength: 6,maxlength: 25 },
			cpasswd: {
				required: true,
				equalTo: "#passwd"
			}
		},
		messages: {
			opasswd: {
				required: "<?php echo ER_OPSW;?>",
				equalTo: "<?php echo ER_OPSWINC;?>"
			},
			passwd: {
				required: "<?php echo ER_PSW;?>",
				minlength: "<?php echo '<br>Password should be atleast 6 characters long';?>",
				maxlength: "<?php echo '<br>Password should not be more than 25 characters long';?>"
			},
			cpasswd: {
				required: "<?php echo ER_CPSW;?>",
				equalTo: "<?php echo ER_SAMEPSW;?>"
			}
		}
	});
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">Change Password</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
  </tr>
  <tr>
	<td width="10" align="left" class="content-left-bg"></td>
    
	<td class="content">
		<form action="change_password.php" method="post" name="frmCP" id="frmCP">
		<input type="hidden" name="passvalue" id="passvalue" value="<?php print base64_decode($passwd); ?>" />
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
		  <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="CHNGPSW")){ ?>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td align="left" class="success"><?php echo "Your password change Successfully"; ?></td>
			</tr>
			  <tr>
				<td height="10" colspan="3"></td>
			  </tr>
          <?php } ?>
		  <tr>
			<td width="250" align="right"><strong>Old Password <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="opasswd" id="opasswd" type="password" class="logintextbox-bg" value="" size="15" onblur="checkpasswd()" /></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>New Password <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="passwd" id="passwd" type="password" class="logintextbox-bg" value="" size="15" /></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Confirmed Password <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="cpasswd" id="cpasswd" type="password" class="logintextbox-bg" value="" size="15" /></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
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