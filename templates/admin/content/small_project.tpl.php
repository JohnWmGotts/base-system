<script language="javascript">
$(document).ready(function() {
	$.validator.addMethod('positiveNumber',
    function (value) { 
        return Number(value) > 0;
    }, 'Enter a valid Amount');

$("#f1").validate({
		rules: {
            amount: { required: true, number: true, positiveNumber:true, maxlength: 6 }
		},
		messages: {
            amount: {
				required: "<?php echo "<br>Please Enter Small Project Amount"; ?>",
				number: "<?php echo "<br>Please Enter Only number"; ?>",
				positiveNumber: '<br>Enter a valid Amount',
				maxlength: "<br>Amount should not be more than 6 characters long" }
		}
		});
});	
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">Small Project Amount</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">		
		<form action="small_project.php" method="post" name="f1" id="f1">
		<input type="hidden" name="action" id="action" value="edit" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="250"></td>
			<td width="10">&nbsp;</td>
			<td>
			<div class="success">		
						<?php if(isset($error) && ($error!="")){ ?>						
						<?php print $error; ?>
						<?php } ?>
						<?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=='RECSUC')){ ?>
						<?php echo "Small Project Amount Updated Successfully"; ?>
						<?php } ?>
			</div>
			</td>
		</tr>
		  <tr>
			<td height="10" colspan="3"><input name="admin_id" id="admin_id" type="hidden"  value="<?php echo (isset($_GET) && isset($_GET['id'])) ? $_GET['id'] : ''; ?>" /></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Small Project Amount <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            	<input name="amount" id="amount" type="text" class="logintextbox-bg dollarSign" maxlength="6" size="6" value="<?php echo (isset($sel_small_project_amount) && isset($sel_small_project_amount['amount'])) ? (int)$sel_small_project_amount['amount']: ''; ?>"  />
                
            </td>
		  </tr>
		 
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php $btn_img=(isset($_GET) && isset($_GET['action']) && ($_GET['action']=='add'))?'add-btn.gif':'bt_change.gif';?>
				<input name="" title="Change" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" />
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