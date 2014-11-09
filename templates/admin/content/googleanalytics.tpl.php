<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>

<script language="javascript" type="text/javascript">
$(document).ready(function() {		   
$("#f1").validate({
		rules: {
            code: { required: true }
		},
		messages: {
            categoryName: {
				code: "<br>Please Enter Category Name"
			}
		}
		});
});	
</script>
<div id="dialog" title="Basic dialog">
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">Google Analytics Code</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">		
		<form action="<?php echo SITE_ADM;?>googleanalytics.php?action=edit" method="post" name="f1" id="f1">
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0" id="price_range_table">
		<?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=='SUCBLO')){ ?>
			
			<tr align="center">
				
  			<p style="padding-left:300px;" class="success">Record was Edited Successfully</p>
				
            </tr>			
		
	<?php } ?>
		  <tr>
			<td height="10" colspan="3"><input name="admin_id" id="admin_id" type="hidden"  value="<?php if (isset($_SESSION['admin_id'])) echo $_SESSION['admin_id']; ?>" /></td>
		  </tr>
		  <tr>
			<td width="250" align="right" valign="top"><strong>Google Analytics Code<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><textarea name="code" id="code" rows="4" cols="40" style="resize:none;" value="<?php echo $analyticsCode['analyticscode']; ?>"><?php echo $analyticsCode['analyticscode']; ?></textarea>
		  </tr>
           
		 
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php $btn_img=(isset($_GET) && isset($_GET['action']) && ($_GET['action']=='add'))?'add-btn.gif':'bt_change.gif'; $btn_tit=(isset($_GET) && isset($_GET['action']) && ($_GET['action']=='add'))?'Add':'Change'; ?>
				<input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" class='save_btn'/> &nbsp; <a href="<?php echo SITE_ADM;?>googleanalytics.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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


