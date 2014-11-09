<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo SITE_CSS.'colorpicker.css'; ?>" />
<script type="text/javascript" src="<?php echo SITE_JAVA.'colorpicker.js'; ?>"></script>
<?php if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')) {?>
<script language="javascript">
$(document).ready(function() {
$.validator.addMethod("lessThan", function(value, element, param) {
		return (this.optional(element) || parseInt(value) > parseInt($(param).val()) || parseInt(value)==0);
}, "The value {0} must be greater than {1}");
	

$.validator.addMethod('positiveNumber',
    function (value) { 
        return parseInt(value) >= 0;
    }, 'Enter a valid Amount');
	
$("#f1").validate({
		rules: {
            start: { required: true, number: true, positiveNumber:true, maxlength: 6,
					remote:{
						url: "<?php echo SITE_URL."admin/manage_commision_range_ajax.php?action=check_range&id=".$_GET['id']; ?>",
						data: {
								start: function () { return $('#start').val(); },
								end: function () { return $('#end').val(); }
							  }
					  }
					
				},
			end: { required: true, number: true, positiveNumber:true, maxlength: 6,lessThan:'#start',
					remote:{
						url: "<?php echo SITE_URL."admin/manage_commision_range_ajax.php?action=check_range&id=".$_GET['id']; ?>",
						data: {
								start: function () { return $('#start').val(); },
								end: function () { return $('#end').val(); }
							  }
					  }
					
			},            
            value: { required: true, number: true, positiveNumber:true, maxlength: 3 }
		},
		 errorPlacement: function(error, element) {
			//alert(error)
			  error.insertAfter(element.next());
			
		  },
		  
        onfocusout: function (element) {
            jQuery(element).valid()
        },
		messages: {
            start: {
				required: "Please Enter Start Range",
				number: "Please Enter Only number",
				positiveNumber: 'Enter a valid Price',
				maxlength: "Price should not be more than 6 characters long" ,
				remote:'Range or part of range already found.'
			},
			end: {
				required: "Please Enter End Range",
				number: "Please Enter Only number",
				positiveNumber: 'Enter a valid Price',
				maxlength: "Price should not be more than 6 characters long",
				lessThan:'This value must be greater than Start Range',
				remote:'Range or part of range already found.'
			},
			value: {
				required: "Please Enter Value",
				number: "Please Enter Only number",
				positiveNumber: 'Enter a valid Value',
				maxlength: "Value should not be more than 3 characters long" 
			}
		}
		});
		
});	
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg"><?php echo ucfirst($_GET['action']);?> Commission Price Range</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">		
		<form action="<?php echo SITE_ADM;?>manage_commision_range.php?id=<?php echo $_GET['id']; ?>&page=<?php echo (isset($_GET) && isset($_GET['page'])) ? $_GET['page'] : 1; ?>&action=<?php echo $_GET['action'];?>" method="post" name="f1" id="f1">
		<input type="hidden" name="action" id="action" value="<?php echo $_GET['action'];?>" />
         <input type="hidden" name="id" id="id" value="<?php print $_GET['id'];?>" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0" id="price_range_table">
		<tr>
			<td width="250"></td>
			<td width="10">&nbsp;</td>
			<td>
			<div class="fieldset-errors" style="color:red;">		
						<?php if($error!=""){ ?>						
						<?php print $error; ?>
						<?php } ?>
						<?php if($_GET["msg1"]=='REGSUS'){ ?>
						<?php echo constant($_GET['msg1']); ?>
						<?php } ?>
			</div>
			</td>
		</tr>
		  <tr>
			<td height="10" colspan="3"><input name="admin_id" id="admin_id" type="hidden"  value="<?php echo $_GET['id']; ?>" /></td>
		  </tr>
		  <tr>
			<td width="250" align="right" valign="top"><strong>Start Price<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="start" id="start" type="text" class="logintextbox-bg" value="<?php echo stripslashes($sel_category_edit_qry['start']); ?>" /><p class="note">Set 0 if you want to tends to less than end price.</p></td>
		  </tr>
           <tr>
			<td height="10" colspan="3"></td>
		  </tr>
          <tr>
			<td width="250" align="right" valign="top"><strong>End Price<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="end" id="end" type="text" class="logintextbox-bg" value="<?php echo stripslashes($sel_category_edit_qry['end']); ?>" /><p class="note">Set 0 if you want to tends to greater than start.</p></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Value<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="value" id="value" type="text" class="logintextbox-bg" value="<?php echo stripslashes($sel_category_edit_qry['value']); ?>"/> <p class="note">%</p></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php $btn_img=($_GET['action']=='add')?'add-btn.gif':'bt_change.gif'; $btn_tit=($_GET['action']=='add')?'Add':'Change'; ?>
				<input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" class='save_btn'/> &nbsp; <a href="<?php echo SITE_ADM;?>manage_commision_range.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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
			<td>Manage Commission Price Range</td>
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
        <?php if(isset($_GET) && isset($_GET['msg']) && (($_GET["msg"]=="DELREC") || ($_GET["msg"]=="ADDREC") || ($_GET["msg"]=="EDITREC") || ($_GET["msg"]=="SUCBLO") || ($_GET["msg"]=="SUCACT"))){ ?>
			<tr align="center">
				
                <?php if($_GET["msg"]=="DELREC") { ?>
				<td align="center" class="success"><?php echo DEL; ?></td>
				<?php } else if($_GET["msg"]=="ADDREC") { ?>
                <td align="center" class="success"><?php echo ADD; ?></td>
                <?php } else if($_GET["msg"]=="EDITREC") { ?>
                <td align="center" class="success"><?php echo EDIT; ?></td>
                <?php } else if($_GET["msg"]=="SUCBLO") { ?>
                <td align="center" class="success"><?php echo "Range Inactivated Successfully"; ?></td>
                <?php } else if($_GET["msg"]=="SUCACT") { ?>
                <td align="center" class="success"><?php echo "Range Activated Successfully"; ?></td>
                <?php } ?>
            </tr>
			 
          <?php } ?>
		<tr>
			<td align="right"><a href="<?php echo SITE_ADM;?>manage_commision_range.php?action=add" title="Add New Commission Price Range" class="link"><strong>Add New Commission Price Range</strong></a></td>
		</tr>
		<tr>
			<td height="10"></td>
		  </tr>
		<tr>
		<td>
		<table id="insured_list" width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder">
		<thead> 
		<tr class="trcolor">	 
			<th width="5%" align="center" class="header1">No.</th>
			<th width="20%" align="center" class="header1">Start Price</th>			
            <th width="20%" align="center" class="header1">End Price</th>
			<th width="20%" align="center" class="header1">Value</th>			
			<th width="10%" align="center">Operation</th>
		  </tr>
		  </thead>
		  <tbody> 
			<?php
				if(mysql_num_rows($result)>0){		
				$i=0;
				while ($sel_category = mysql_fetch_assoc($result))
				{
					$i++;
			?>
		  <tr>
			<td><?php echo $i; ?></td>
			<td><?php echo stripslashes(($sel_category['start']>'0')?$sel_category['start']:" (less than)"); ?></td>
            <td><?php echo stripslashes(($sel_category['end']>0)?$sel_category['end']:" (greater than)"); ?></td>
			<td ><?php echo stripslashes($sel_category['value']); ?>%</td>			
			<td class="icon">
				<ul>
					<li><a href="<?php echo SITE_ADM;?>manage_commision_range.php?action=edit&amp;id=<?php echo $sel_category['id']; ?>&amp;page=<?php echo $_GET['page']; ?>" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a></li>
                    <?php if(isset($_SESSION['admin_role']) && ($_SESSION["admin_role"] == -1)){ ?>
                    	<li><a href="#" onclick="return confirm('You dont have privileges to do this action.');" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
                    <?php }else{ ?>
                    	<li><a href="<?php echo SITE_ADM;?>manage_commision_range.php?id=<?php echo $sel_category['id']; ?>&action=delete&page=<?php echo $_GET['page']; ?>" onclick="return confirm('Are you sure you want to delete?');" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>				
                    <?php } ?>
				</ul>
			</td>
		  </tr>
			<?php } } else { ?>
			<tr><td colspan="5">No records found.</td></tr>
			<?php }
				?>
		</tbody>
        <tbody>
        <?php if(mysql_num_rows($result)>0){?>
		<tr id="pager" class="pager" >
		<td colspan="6"><!--<center><?php //echo $pagination; ?></center>-->
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
        <?php } ?>
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
    $(document).ready(function() { 
        $("#insured_list")
        .tablesorter({widthFixed: true, widgets: ['zebra']})
        .tablesorterPager({container: $("#pager")}); 
    }); 
</script> 
<?php } ?>