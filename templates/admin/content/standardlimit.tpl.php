<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>

<link rel="stylesheet" media="screen" type="text/css" href="<?php echo SITE_CSS.'colorpicker.css'; ?>" />
<script type="text/javascript" src="<?php echo SITE_JAVA.'colorpicker.js'; ?>"></script>
<?php if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')) {?>
<script language="javascript">
$(document).ready(function() {
	
	$("#categoryname").focus();
	
	$("#f1").validate({
		rules: {
			//standardaffiliated:{required: true,digits: true, min:1, maxlength: 3,max:100},
			standardcommission:{required: true,digits: true, min:1, maxlength: 3,max:100},
			//standardwithdrawl:{required: true,digits: true, min:1, maxlength: 3,max:100}
			
		},
		messages: {
			
			/*standardaffiliated:{
				required:"<br >This field is required.",
				digits: "<?php echo "<br>Please enter valid number"; ?>",
				min: "<?php echo "<br>Please enter valid number"; ?>",
				maxlength: "<?php echo "<br>Amount should not be more than 3 characters long" ;?>",
				max:"<br>Amount should not be more than 100%."
				},*/
			standardcommission:{
				required:"<br >This field is required.",
				digits: "<?php echo "<br>Please enter valid number"; ?>",
				min: "<?php echo "<br>Please enter valid number"; ?>",
				maxlength: "<?php echo "<br>Amount should not be more than 3 characters long" ;?>",
				max:"<br>Amount should not be more than 100%."
				}
				//,
			/*standardwithdrawl:{
				required:"<br >This field is required.",
				digits: "<?php echo "<br>Please enter valid number"; ?>",
				min: "<?php echo "<br>Please enter valid number"; ?>",
				maxlength: "<?php echo "<br>Amount should not be more than 3 characters long" ;?>",
				max:"<br>Amount should not be more than 100%."
				},*/
			}
		});
		
});	
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">Edit Standard Commission </td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">		
		<form action="standardlimit.php" method="post" name="f1" id="f1">
		<input type="hidden" name="action" id="action" value="<?php echo $_GET['action'];?>" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
		  
          <!--<tr>
			<td width="250" align="right"><strong>standard affiliated commission (IN %)<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="standardaffiliated" id="standardaffiliated" type="text" maxlength="3" class="logintextbox-bg" value="<?php echo $std_edit_qry['std_cat_affiliated_commission']; ?>" /></td>
		  </tr>-->
          
          <tr>
			<td height="10" colspan="3"></td>
		  </tr>
          
          <tr>
			<td width="250" align="right"><strong>standard category commission  (IN %)<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="standardcommission" id="standardcommission" type="text" class="logintextbox-bg" value="<?php echo $std_edit_qry['std_cat_commission']; ?>" maxlength="3" /></td>
		  </tr>
		  
          <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  
         <!-- <tr>
			<td width="250" align="right"><strong>standard withdrawal limit (IN %)<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="standardwithdrawl" id="standardwithdrawl" type="text" class="logintextbox-bg" value="<?php echo $std_edit_qry['std_withdrawl_limit']; ?>" maxlength="3" /></td>
		  </tr>-->
		  
          <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php $btn_img=($_GET['action']=='add')?'add-btn.gif':'bt_change.gif'; $btn_tit=($_GET['action']=='add')?'Add':'Change'; ?>
				<input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>standardlimit.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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
			<td>Manage default commission</td>
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
			<td height="10"></td>
		  </tr>
		<tr>
		<td>
		<table id="insured_list" width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder">
		<thead> 
		<tr class="trcolor">
		<!--<th width="30%" align="center" >standard affiliated commission (IN %)</th>-->			
            <th width="30%" align="center" >default commission (IN %)</th>
			<!--<th width="30%" align="center" >standard withdrawal limit (IN %)</th>-->			
			<th width="10%" align="center">Operation</th>
		  </tr>
		  </thead>
		  
       <tbody> 
          <?php				
				while ($std_limit = mysql_fetch_assoc($result)) { ?>
          <tr>
			<!--<td align="center">
				<?php 
						//echo stripslashes($std_limit['std_cat_affiliated_commission']);	
				  ?>
                  
            </td>-->
            
            <td align="center">
            	<?php 
						echo stripslashes($std_limit['std_cat_commission']);	
				  ?>
             </td>
             
             <!--<td align="center">	
             		<?php 
					//	echo stripslashes($std_limit['std_withdrawl_limit']);
				  ?>
             	
              </td>-->
            	
                <td class="icon">
                    <ul>
                        <li><a href="<?php echo SITE_ADM;?>standardlimit.php?action=edit" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a></li>
                    </ul>
				</td>
		  
            </tr>
          <?php } ?>  
		</tbody>
        
        <tbody>
        
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
<?php } ?>