<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo SITE_CSS.'colorpicker.css'; ?>" />
<script type="text/javascript" src="<?php echo SITE_JAVA.'colorpicker.js'; ?>"></script>
<?php if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')) {?>
<script language="javascript">
$(document).ready(function() {
$("#f1").validate({
		rules: {
            categoryname: { required: true,minlength: 4,maxlength: 25,
			   remote:{
						url: "<?php echo SITE_URL."admin/categoryname_ajax.php?action=".$_GET['action']."&id=".$_GET['id']; ?>",
						data: {	type:"post",
								categoryname: function () { return $('#categoryname').val(); }
							  }
					  }
				},
			categorycolor: { required: true },            
            description: { required: true,minlength: 6, maxlength: 250 }
		},
		messages: {
            categoryname: {
				required: "<?php echo "<br>Please Enter Category Name"; ?>",
				minlength: "<?php echo "<br>Category Name should be atleast 4 characters long";?>",
				maxlength: "<?php echo "<br>Category Name should not be more than 25 characters long";?>",
				remote: "<?php echo "<br>Category Name Already exist!"; ?>"
			},
			categorycolor: {
				required: "<?php echo "<br>Please Enter Category Color"; ?>"
			},
			description: {
				required: "<?php echo "<br>Please Enter Description"; ?>",
				minlength: "<?php echo "<br>Description should be atleast 6 characters long";?>",
				maxlength: "<?php echo "<br>Description should not be more than 250 characters long";?>"
			}
		}
		});
		$('#categorycolor').ColorPicker({
			color: '#0000ff',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				document.getElementById("categorycolor").value='#' + hex;
			}
		});
});	
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg"><?php echo ucfirst($_GET['action']);?> Category</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">		
		<form action="category.php?id=<?php echo $_GET['id']; ?>&amp;page=<?php echo $_GET['page']; ?>&amp;action=<?php echo $_GET['action'];?>" method="post" name="f1" id="f1">
		<input type="hidden" name="action" id="action" value="<?php echo $_GET['action'];?>" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="250"></td>
			<td width="10">&nbsp;</td>
			<td>
			<div class="fieldset-errors" style="color:red;">		
						<?php if(isset($error) && ($error!="")){ ?>						
						<?php print $error; ?>
						<?php } ?>
						<?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg1"]=='REGSUS')){ ?>
						<?php echo constant($_GET['msg1']); ?>
						<?php } ?>
			</div>
			</td>
		</tr>
		  <tr>
			<td height="10" colspan="3"><input name="admin_id" id="admin_id" type="hidden"  value="<?php echo $_GET['id']; ?>" /></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Category Name <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="categoryname" id="categoryname" type="text" class="logintextbox-bg" value="<?php echo stripslashes($sel_category_edit_qry['categoryName']); ?>" /></td>
		  </tr>
           <tr>
			<td height="10" colspan="3"></td>
		  </tr>
          <!--<tr>
			<td width="250" align="right"><strong>Category Color Code <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="categorycolor" id="categorycolor" type="text" class="logintextbox-bg" value="<?php echo stripslashes($sel_category_edit_qry['categoryColor']); ?>" maxlength="7" readonly="readonly"/></td>
		  </tr>-->
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Category Description <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><textarea name="description" id="description" class="textarea-bg"><?php echo stripslashes($sel_category_edit_qry['categoryDescription']); ?></textarea></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php $btn_img=($_GET['action']=='add')?'add-btn.gif':'bt_change.gif'; $btn_tit=($_GET['action']=='add')?'Add':'Change'; ?>
				<input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>category.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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
			<td>Manage Category</td>
			<td align="right">
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
        <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="DELREC" || $_GET["msg"]=="ADDREC" || $_GET["msg"]=="EDITREC" || $_GET["msg"]=="SUCBLO" || $_GET["msg"]=="SUCACT" || $_GET["msg"]=="NOTACT")){ ?>
			<tr align="center">
				
                <?php if($_GET["msg"]=="DELREC") { ?>
				<td align="center" class="success"><?php echo DEL; ?></td>
				<?php } else if($_GET["msg"]=="ADDREC") { ?>
                <td align="center" class="success"><?php echo ADD; ?></td>
                <?php } else if($_GET["msg"]=="EDITREC") { ?>
                <td align="center" class="success"><?php echo EDIT; ?></td>
                <?php } else if($_GET["msg"]=="SUCBLO") { ?>
                <td align="center" class="success"><?php echo "Category Inactivated Successfully"; ?></td>
                <?php } else if($_GET["msg"]=="SUCACT") { ?>
                <td align="center" class="success"><?php echo "Category Activated Successfully"; ?></td>
                <?php }else if($_GET["msg"]=="NOTACT") {?>
                <td align="center" class="error"><?php echo "Category can not Inactivated because projects of these category is Running."; ?></td>
                <?php } ?>
            </tr>
			 
          <?php } ?>
           <tr>
                    <div align="right"><a href="<?php echo SITE_URL;?>admin/export/exportcategory.php" title="Export Users">Export Categories WITH XLS</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo SITE_URL;?>admin/csvcategory.php" title="Export Users">Export Categories WITH CSV</a> 
                    </div>
                    <div align="right"> 
                    </div>
    </tr>
		<tr>
			<td align="right"><a href="<?php echo SITE_ADM;?>category.php?action=add" title="Add New Category" class="link"><strong>Add New Category</strong></a></td>
		</tr>
		<tr>
			<td height="10"></td>
		  </tr>
		<tr>
		<td>
		<table id="insured_list" width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder">
		<thead> 
		<tr class="trcolor">
		<th width="22%" align="center" class="header1">Category Name</th>			
            <!--<th width="17%" align="center" class="header1">Category Color</th>-->
			<th width="54%" align="center" class="header1">Category Description</th>			
			<th width="7%" align="center">Operation</th>
		  </tr>
		  </thead>
		  <tbody> 
			<?php	
			if(mysql_num_rows($result)>0){			
				while ($sel_category = mysql_fetch_assoc($result)) { ?>
		  <tr>
			<td><?php echo stripslashes($sel_category['categoryName']); ?></td>
           <!-- <td><?php echo stripslashes($sel_category['categoryColor']); ?></td>-->
			<td ><?php echo stripslashes($sel_category['categoryDescription']); ?></td>			
			<td class="icon">
				<ul>
					<li><a href="<?php echo SITE_ADM;?>category.php?action=edit&amp;id=<?php echo $sel_category['categoryId']; ?>&amp;page=<?php echo $_GET['page']; ?>" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a></li>
                    
                    <?php if($sel_category['isActive']==1) { ?>
                    	<li><a href="<?php echo SITE_ADM;?>category.php?action=inactive&amp;id=<?php echo $sel_category['categoryId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to Inactivate this category ? It will not Inactivate projects of this category. If you want to change go to project accept page and make change. Please confirm.')" title="Click here to Inactivate"><img src="<?php echo SITE_ADM_IMG;?>active.gif" border="0" alt="Inactivate" /></a></li>
                    <?php } else { ?>
                    	<li><a href="<?php echo SITE_ADM;?>category.php?action=active&amp;id=<?php echo $sel_category['categoryId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to Activate this category?')" title="Click here to Activate"><img src="<?php echo SITE_ADM_IMG;?>block.png" border="0" alt="Activate" /></a></li>
                    <?php } ?>
                    
				</ul>
			</td>
		  </tr>
			<?php }} else { ?>
			<tr><td colspan="5">No records found.</td></tr>
			<?php }
				?>
		</tbody>
        <tbody>
		<tr id="pager" class="pager" >
		<td colspan="6"><!--<center><?php //echo $pagination; ?>--></center>
				<form>
                <img src="<?php echo SITE_IMG_SITE.'first.png';?>" class="first">
                <img src="<?php echo SITE_IMG_SITE.'prev.png';?>" class="prev">
                <input type="text" class="pagedisplay" readonly="readonly" >
                <img src="<?php echo SITE_IMG_SITE.'next.png';?>" class="next">
                <img src="<?php echo SITE_IMG_SITE.'last.png';?>" class="last">					
                <input type="hidden" class="pagesize" value="10"/>
					
				</form>
			
		</td>
		</tr>
        </tbody>
		</table>
		</td>		
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
<script type="text/javascript">
$(document).ready(function() 
{ 
	$("#insured_list")
	.tablesorter({widthFixed: true, widgets: ['zebra']})
	.tablesorterPager({container: $("#pager")}); 
} 
); 
</script> 
<?php } ?>