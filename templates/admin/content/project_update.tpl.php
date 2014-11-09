
<script src="<?php echo SITE_JAVA; ?>ajax.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<?php if(isset($_REQUEST['action'])) {?>

<script type="text/javascript" language="javascript">
	var path = '<?php echo  APPLICATION_PATH; ?>/includes';
</script>
<script type="text/javascript" src="<?php echo SITE_CKE;?>ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	//alert('hi');		 
	
$("#frmUpd").validate({
		rules: {
           description: { required: true }
		},
		messages: {
           description: "<br>Please Enter Description"
			
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.insertAfter( element.next() );
			else
				error.insertAfter( element );
		}
		});
});	

</script>
<?php $req_span=($action!='view')?'<span class="redcolor">*</span>':''; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg"><?php echo ucfirst($_GET['action']).' '.ucfirst(stripslashes($get_content_detail['page'])) ;?>  Content</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">
   
		<form action="<?php echo SITE_ADM;?>project_update.php?action=edit" method="post" name="frmUpd" id="frmUpd">
		<input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
		<input type="hidden" name="id" id="id" value="<?php echo $get_update_detail['projectupdateId'];?>" />
        <input name="status" id="statusa" type="hidden" value="1"/>
  
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php if(isset($error) && $error!=""){ ?>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td align="left" class="error_msg"><?php print $error; ?></td>
			</tr>
			  <tr>
				<td height="10" colspan="3"></td>
			  </tr>
          <?php } ?>
		  <?php if(isset($_GET["msg"]) && $_GET["msg"]!=""){ ?>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td align="left" class="success"><?php echo constant($_GET['msg']); ?></td>
			</tr>
			  <tr>
				<td height="10" colspan="3"></td>
			  </tr>
          <?php } ?>
		           
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Update Title :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
           
            	<input name="title" id="title" type="text" class="logintextbox-bg" value="<?php echo $get_update_detail['updateTitle'];?>" readonly="readonly" disabled="disabled" />
          
           </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		 
		 
		 
		 
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Description <?php echo $req_span;?> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
                 	
				<textarea name="description" id="description" class="ck_req"><?php echo stripslashes($get_update_detail['updateDescription']);?></textarea>
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
			  </script>
			  <label id="er_desc" class="error" style="display:none;"><?php echo ER_PAGEDESC;?></label>
            
			</td>
		  </tr>
		
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>		  
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
		 
				<?php $btn_img='bt_change.gif'; $btn_tit='Change'; ?>
				<input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" id="btnCms" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>project_update.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
            
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
			<td>Manage Updates</td>
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
        <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="EDIT" || $_GET["msg"]=="EDITEMPTY" || $_GET["msg"]=="SUCBLO" || $_GET["msg"]=="SUCACT" || $_GET["msg"]=="DELSUS")){ ?>
			<tr align="center">
				
                <?php if($_GET["msg"]=="EDITEMPTY") { ?>
				<td align="center" class="success"><?php echo "Please Enter Update Description"; ?></td>
				<?php } else if($_GET["msg"]=="EDIT") { ?>
                <td align="center" class="success"><?php echo "Update Edited Successfully"; ?></td>
                <?php } else if($_GET["msg"]=="SUCBLO") { ?>
                <td align="center" class="success"><?php echo "Update Inactivated  Successfully"; ?></td>
                <?php } else if($_GET["msg"]=="SUCACT") { ?>
                <td align="center" class="success"><?php echo "Update Activated  Successfully"; ?></td>
				<?php } else if($_GET["msg"]=="DELSUS") { ?>
                <td align="center" class="success"><?php echo "Update Deleted  Successfully"; ?></td>
                <?php } ?>                
            </tr>
			 
          <?php } ?>
		<tr>
			<td align="right"></td>
		</tr>
		<tr>
			<td height="10"></td>
		  </tr>
		<tr>
		
		<td>
		<table id="insured_list" width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder">
		<thead> 
		<tr class="trcolor">
		
			<th width="27%" align="center" class="header1" id="links">Project Title</th>
            <th width="12%" align="center" class="header1">Creator</th>
			 <th width="27%" align="center" class="header1" id="links">Update Title</th>
            <th width="12%" align="center" class="header1">Update Description</th>
			<th width="12%" align="center" class="header1">Update Date</th>
			<th width="5%" align="center" >Operation</th>			
		  </tr>
		  </thead>
		  <tbody>
			<?php
			if(mysql_num_rows($results)>0){
				while ($checkedornot = mysql_fetch_assoc($results))
				{
					
			?>
		  <tr>
		  <?php		
			$sel_project_all=mysql_fetch_array($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId = '".$checkedornot['projectId']."'"));
			
		  ?>
		
			<td ><div class="protit"><a title="Click here to view project detail" href="javascript:void(0);" onclick="javascript:openPopup('<?php echo $sel_project_all["projectId"]; ?>');"><?php echo unsanitize_string(ucfirst($sel_project_all['projectTitle'])); ?></a></div></td>
            <td  ><div class="shrtblrb"><?php echo $checkedornot['name']; ?></div></td>
            <td  ><div class="shrtblrb"><?php echo $checkedornot['updateTitle']; ?></div></td>
           <?php  if(strlen($checkedornot['updateDescription'])>35){ 
		   			$textcontent= strip_tags($checkedornot['updateDescription']); ?>
            	<td  ><div class="shrtblrb"><?php echo substr($textcontent,0,35); ?>..</div></td>
			<?php } else {  ?>
            <td  ><div class="shrtblrb"><?php echo $checkedornot['updateDescription']; ?></div></td>
            <?php } ?>
			<td ><div ><?php echo  date ("m-d-Y H:i:s",$checkedornot['updateTime']); ?></div></td><!--class="proloc"-->
			<td class="icon" width="7%">
				<ul>
                
                 <li><a href="<?php echo SITE_ADM;?>project_update.php?action=edit&id=<?php echo $checkedornot['projectupdateId']; ?>" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a></li>
                 
					<?php if($checkedornot['updatestatus']==1) { ?>
                    	<li><a href="<?php echo SITE_ADM;?>project_update.php?action=inactive&amp;id=<?php echo $checkedornot['projectupdateId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to Inactivate this update ?')" title="Click here to Inactivate"><img src="<?php echo SITE_ADM_IMG;?>active.gif" border="0" alt="Inactivate" /></a></li>
                    <?php } else { ?>
                    	<li><a href="<?php echo SITE_ADM;?>project_update.php?action=active&amp;id=<?php echo $checkedornot['projectupdateId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to Activate this update?')" title="Click here to Activate"><img src="<?php echo SITE_ADM_IMG;?>block.png" border="0" alt="Activate" /></a></li>
                    <?php } ?>
                    <?php if($_SESSION["admin_role"] == -1){ ?>
                    
                    	<li><a href="#" onclick="return confirm('You dont have privileges to do this action.')"  title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
                    <?php }else{ ?>
                    	<li><a href="projectupdate_del.php?id=<?php echo $checkedornot['projectupdateId']; ?>&&type='projectupdate'" onclick="return confirm('Are you sure you want to Delete this Update?')"  title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
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
		<td colspan="10"><!--<center><?php //echo $pagination; ?>--></center>
				<form>
                <img src="<?php echo SITE_IMG_SITE.'first.png';?>" class="first">
                <img src="<?php echo SITE_IMG_SITE.'prev.png';?>" class="prev">
                <input type="text" class="pagedisplay" readonly="readonly">
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
<script type="text/javascript">
	$(document).ready(function() 
	{ 
	
	// add parser through the tablesorter addParser method 
	$.tablesorter.addParser({
		// set a unique id 
		id: 'links',
		is: function(s)
		{
			// return false so this parser is not auto detected 
			return false;
		},
		format: function(s)
		{
			// format your data for normalization 
			return s.replace(new RegExp(/<.*?>/),"");
		},
		// set type, either numeric or text
		type: 'text'
	}); 

	$("#insured_list")
		.tablesorter({widthFixed: true, widgets: ['zebra'],
			headers: {  
				5: {
					sorter: false 
				},
				1: {
					sorter: 'links'
				}
			}
		})
		.tablesorterPager({container: $("#pager")}); 
		} 
	); 
</script>   
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