<?php if(isset($_GET['action'])) {?>
<script type="text/javascript" src="<?php echo SITE_CKE;?>ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	$("#frmCms").validate({
		rules: {
			title: {required:true}
		},
		message: {
			title: {required:'<?php echo ER_TIT;?>'}
		}
	});
	
	$('#btnCms').click(function(){
		if($("#cke_description iframe").contents().find("body").text()=='') {
			$('#er_desc').show();
			return false;
		} else {
			$('#er_desc').hide();
		}
	});
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg"><?php echo ucfirst($_GET['action']);?> Content</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">
		<form action="content.php" method="post" name="frmCms" id="frmCms">
		<input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
		<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="250" align="right"><strong>Module <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="module" id="module" type="text" class="logintextbox-bg" value="<?php echo stripslashes($module);?>" readonly="true" disabled="disabled" /></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Page Name <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="page" id="page" type="text" class="logintextbox-bg" value="<?php echo stripslashes($page);?>" readonly="true" disabled="disabled" /></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Page Title <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="title" id="title" type="text" class="logintextbox-bg required" value="<?php echo stripslashes($title);?>" /></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Meta Author <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="meta_author" id="meta_author" type="text" class="logintextbox-bg" value="<?php echo stripslashes($meta_author);?>" /></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Meta Keyword :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="meta_keyword" id="meta_keyword" type="text" class="logintextbox-bg" value="<?php echo stripslashes($meta_keyword);?>" /></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Meta Description :</strong></td>
			<td width="10">&nbsp;</td>
			<td><textarea name="meta_desc" id="meta_desc" class="textarea-bg"><?php echo stripslashes($meta_desc);?></textarea></td>
		  </tr>
		  <?php if(strtolower($module)=='cms') { ?>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Description <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
				<textarea name="description" id="description" class="ck_req"><?php echo stripslashes($description);?></textarea>
				<script type="text/javascript">
				//<![CDATA[
				CKEDITOR.replace( 'description',
				{
					removePlugins: 'elementspath' ,
					skin : 'kama',
					attributes : { 'class' : 'ck_req' }/*,
					toolbar :
					[
						[ 'Bold', 'Underline', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Cut', 'Copy', 'Paste', '-', 'SpellChecker']									
					]*/
				});			
			  //]]>
			  </script>
			  <label id="er_desc" class="error" style="display:none;"><?php echo ER_CONT;?></label>
			</td>
		  </tr>
		  <?php } ?>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php $btn_img=($_GET['action']=='add')?'add-btn.gif':'bt_change.gif';?>
				<input name="" id="btnCms" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>content.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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
<?php } else { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>Manage Contents</td>
			<td align="right">
				<select name="">
					<option>Test 01</option>
					<option>Test 02</option>
					<option>Test 03</option>
				</select>
			</td>
		  </tr>
		</table>
	</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td height="10"></td>
		  </tr>
		<tr>
		<td>
		<table width="100%" border="0"  cellspacing="0" cellpadding="5" class="tabeleborder">
		  <tr class="trcolor">
			<td width="3%" align="center">ID</td>
			<td width="2%"><div><a href="#" title="Ascending"><img src="<?php echo SITE_ADM_IMG;?>top-arrow.png" border="0" alt="Ascending" /></a></div><div><a href="#" title="Descending"><img src="<?php echo SITE_ADM_IMG;?>bottom-arrow.png" border="0" alt="Descending" /></a></div></td>
			<td width="15%" align="center">MODULE</td>
			<td width="2%"><div><a href="#" title="Ascending"><img src="<?php echo SITE_ADM_IMG;?>top-arrow.png" border="0" alt="Ascending" /></a></div><div><a href="#" title="Descending"><img src="<?php echo SITE_ADM_IMG;?>bottom-arrow.png" border="0" alt="Descending" /></a></div></td>
			<td width="15%" align="center">PAGE</td>
			<td width="2%"><div><a href="#" title="Ascending"><img src="<?php echo SITE_ADM_IMG;?>top-arrow.png" border="0" alt="Ascending" /></a></div><div><a href="#" title="Descending"><img src="<?php echo SITE_ADM_IMG;?>bottom-arrow.png" border="0" alt="Descending" /></a></div></td>
			<td width="15%" align="center">TITLE</td>
			<td width="2%"><div><a href="#" title="Ascending"><img src="<?php echo SITE_ADM_IMG;?>top-arrow.png" border="0" alt="Ascending" /></a></div><div><a href="#" title="Descending"><img src="<?php echo SITE_ADM_IMG;?>bottom-arrow.png" border="0" alt="Descending" /></a></div></td>
			<td width="8%" align="center">STATUS</td>
			<td width="2%"><div><a href="#" title="Ascending"><img src="<?php echo SITE_ADM_IMG;?>top-arrow.png" border="0" alt="Ascending" /></a></div><div><a href="#" title="Descending"><img src="<?php echo SITE_ADM_IMG;?>bottom-arrow.png" border="0" alt="Descending" /></a></div></td>
			<td width="13%" align="center">OPERATION</td>
		  </tr>
		  <tr>
			<td colspan="2"><a href="#" class="link">1</a></td>
			<td colspan="2">CMS</td>
			<td colspan="2">aboutus</td>
			<td colspan="2">About Us</td>
			<td colspan="2">Active</td>
			<td class="icon" align="center">
				<ul>
					<li><a href="<?php echo SITE_ADM;?>content.php?action=edit&id=1" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a></li>
					<li><a href="#" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
				</ul>
			</td>
		  </tr>
		  <tr>
			<td colspan="2"><a href="#" class="link">2</a></td>
			<td colspan="2">CMS</td>
			<td colspan="2">contactus</td>
			<td colspan="2">Contact Us</td>
			<td colspan="2">Active</td>
			<td class="icon">
				<ul>
					<li><a href="#"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="img" /></a></li>
					<li><a href="#"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="img" /></a></li>
				</ul>
			</td>
		  </tr>
		</table>
		</td>
		</tr>
		</table>
	</td>
	<td width="10" align="right" class="content-right-bg"></td>
</tr>
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>content-main-box-bottom-left.gif" alt="img" /></td>
	<td class="content-bottom-bg"></td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>content-main-box-bottom-right.gif" alt="img" /></td>
</tr>
</table>
<?php } ?>