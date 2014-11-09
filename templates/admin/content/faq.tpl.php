<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<?php if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')) {?>
<script language="javascript">
$(document).ready(function() {		   
$("#f1").validate({
		rules: {
            categoryName: { required: true }
		},
		messages: {
            categoryName: {
				required: "<br>Please Enter Category Name"
			}
		}
		});
});	
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg"><?php echo ucfirst($_GET['action']);?> FAQ Category</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">		
		<form action="faq.php?id=<?php echo $_GET['id']; ?>&amp;page=<?php echo $_GET['page']; ?>&amp;action=<?php echo $_GET['action'];?>" method="post" name="f1" id="f1">
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
			<td height="10" colspan="3"><input name="faqCategoryId" id="admin_id" type="hidden"  value="<?php echo $editFaqCategorysel['faqCategoryId']; ?>" /></td>
		  </tr>
          <?php		  
		  if($editFaqCategorysel['faqCategoryParentId']!=0 || $_GET['action']=='add')
		  {
		?>
			<tr>
			<td width="250" align="right"><strong>Category :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            	<select name="typeOfCategory">
                <?php 
				if($_GET['action']!='edit')
				{ 
				 ?>
                <option value="0">Select Parent category</option>                	
            	<?php
				}
				$selCategory=$con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryParentId =0 AND faqStatus!='0'");
				while($selCategoryName=mysql_fetch_assoc($selCategory))
				{
				?>
                	<option  <?php if($selCategoryName['faqCategoryId']==$editFaqCategorysel['faqCategoryParentId']) { echo 'selected'; } ?> value="<?php echo $selCategoryName['faqCategoryId']; ?>" ><?php echo $selCategoryName['faqcategoryName']; ?></option>
                <?php 
				}
				?>
                </select>
            </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
          <?php
		  }	
		  else{}	  
		  ?>		  
		  <tr>
			<td width="250" align="right"><strong>Category Name<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            	<input type="text" class="logintextbox-bg" name="categoryName" value="<?php echo htmlentities(stripslashes($editFaqCategorysel['faqcategoryName'])); ?>" />
            </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>		 
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php $btn_img=($_GET['action']=='add')?'add-btn.gif':'bt_change.gif'; $btn_tit=($_GET['action']=='add')?'Add':'Change'; ?>
				<input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>faq.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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
<link href="<?php echo SITE_CSS;?>jquery-ui-1.8.20.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function(){

	// Accordion
	$("#accordion").accordion({ header: "h3", autoHeight: false });
	});
function maincategoryedit(id)
{
	window.location = "<?php echo SITE_ADM; ?>faq.php?action=edit&id="+id;
}
function maincategorydeactivate(id)
{
	//alert(id);
	var r=confirm("Are you sure you want to deactivate ? It will also deactivate related data. Please confirm.");
	if (r==true)
	  {
		window.location = "<?php echo SITE_ADM; ?>faq.php?action=deactivate&id="+id;
	  }
	else
	  {
	  }
}
function maincategoryactivate(id)
{
	//alert(id);
	var r=confirm("Are you sure you want to activate ?");
	if (r==true)
	  {
		window.location = "<?php echo SITE_ADM; ?>faq.php?action=activate&id="+id;
	  }
	else
	  {
	  }
}

				
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>FAQ Category</td>
			
		  </tr>
		</table>
	</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="DELREC" || $_GET["msg"]=="ADDREC" || $_GET["msg"]=="EDITREC" || $_GET["msg"]=="ALREADYADD" || $_GET["msg"]=="SUCACT" || $_GET["msg"]=="SUCBLO")){ ?>
			<tr align="center">
				
                <?php if($_GET["msg"]=="DELREC") { ?>
				<td align="center" class="success"><?php echo DEL; ?></td>
				<?php } else if($_GET["msg"]=="ADDREC") { ?>
                <td align="center" class="success"><?php echo ADD; ?></td>
                <?php } else if($_GET["msg"]=="EDITREC") { ?>
                <td align="center" class="success"><?php echo EDIT; ?></td>
                <?php }elseif($_GET["msg"]=="ALREADYADD"){ ?>
                <td align="center" class="error"><?php echo 'Already Exists Category Name'; ?></td>
                <?php } else if($_GET["msg"]=="SUCACT") { ?>
                <td align="center" class="success"><?php echo 'Category Activated Successfully'; ?></td>
                <?php } else if($_GET["msg"]=="SUCBLO") { ?>
                <td align="center" class="success"><?php echo 'Category Inactivated Successfully'; ?></td>
                <?php } ?>
            </tr>
			 
          <?php } ?>
		<tr>
			<td align="right"><a href="<?php echo SITE_ADM;?>faq.php?action=add" title="Add New FAQ Category" class="link"><strong>Add New FAQ Category</strong></a></td>
		</tr>
		<tr>
			<td height="10"></td>
		  </tr>
          </table>
    
    <div id="accordion">
	   <?php  
       $faqresults =$con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryParentId = 0");				
		while ($sel_faqcategory = mysql_fetch_assoc($faqresults))
		{ 
		?>
        <div>
            <h3 class="main-category-header">
            	<a href="javascript:void(0)" class="main-category-name"><?php echo $sel_faqcategory['faqcategoryName']; ?></a>
                <div class="main-category-operation">
              	<a href="javascript:void(0)" onclick="return maincategoryedit(<?php echo $sel_faqcategory['faqCategoryId']; ?>)" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a>
				<?php if($_SESSION["admin_role"] == -1){ ?>
                 <?php if($sel_faqcategory['faqStatus']==1) { ?>
                    <?php // replcd to avoid unrefd & unneede var by jwg
						/* 	<a href="<?php echo SITE_ADM;?>project_accept.php?action=inactive&amp;id=<?php echo $sel_project_all['projectId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('You dont have privileges to do this action.')" title="Click here to Inactivate"><img src="<?php echo SITE_ADM_IMG;?>active.gif" border="0" alt="Inactivate" /></a> */ 
					?>
							<a href="#" onclick="return confirm('You dont have privileges to do this action.')" title="Click here to Inactivate"><img src="<?php echo SITE_ADM_IMG;?>active.gif" border="0" alt="Inactivate" /></a>
                    <?php } else { ?>
					<?php // replcd to avoid unrefd & unneede var by jwg 
                    	/* <a href="<?php echo SITE_ADM;?>project_accept.php?action=active&amp;id=<?php echo $sel_project_all['projectId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('You dont have privileges to do this action.')" title="Click here to Activate"><img src="<?php echo SITE_ADM_IMG;?>block.png" border="0" alt="Activate" /></a> */
					?>
							<a href="#" onclick="return confirm('You dont have privileges to do this action.')" title="Click here to Activate"><img src="<?php echo SITE_ADM_IMG;?>block.png" border="0" alt="Activate" /></a>
                    <?php } ?>
                	<!--<a href="javascript:void(0)" onclick="return confirm('You dont have privileges to do this action.')" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a>-->
                <?php }else{ 
				?>
                    <?php if($sel_faqcategory['faqStatus']==1) { 
						// replaced unnec copied code in following two hrefs (as above) ... jwg
					?>
                    	<a href="#" onclick="return maincategorydeactivate(<?php echo $sel_faqcategory['faqCategoryId']; ?>)" title="Click here to Inactivate"><img src="<?php echo SITE_ADM_IMG;?>active.gif" border="0" alt="Inactivate" /></a>
                    <?php } else { ?>
                    	<a href="#" onclick="return maincategoryactivate(<?php echo $sel_faqcategory['faqCategoryId']; ?>)" title="Click here to Activate"><img src="<?php echo SITE_ADM_IMG;?>block.png" border="0" alt="Activate" /></a>
                    <?php } ?>
                   <!-- <a href="javascript:void(0)" onclick="return maincategorydelete(<?php echo $sel_faqcategory['faqCategoryId']; ?>)" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a>-->
                <?php } ?>
            	</div>
            </h3>
            <div>
		<?php 
			
			$faqresults1 =$con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryParentId='".$sel_faqcategory['faqCategoryId']."'");
        	while ($sel_faqcategory1 = mysql_fetch_assoc($faqresults1))
			{
				
				if($_SESSION["admin_role"] == -1){
				$subAdmin = '<a href="#" onclick="return confirm(\'You dont have privileges to do this action.\')" title="Delete"><img src="'.SITE_ADM_IMG.'delete.png" border="0" alt="Delete" /></a>';
			}else{
			 $sel_faqcategory1['faqCategoryId'];
				$subAdmin = '<a href="faq.php?action=delete&amp;id='.$sel_faqcategory1['faqCategoryId'].'&amp;page='.$_GET['page'].'" onclick="return confirm(\'Are you sure you want to delete ? It will also delete related data. Please confirm.\')" title="Delete"><img src="'.SITE_ADM_IMG.'delete.png" border="0" alt="Delete" /></a>';
			} 
                 echo '<h2>'.$sel_faqcategory1['faqcategoryName'].
				 		'<span>
							<a href="'.SITE_ADM.'faq.php?action=edit&id='.$sel_faqcategory1['faqCategoryId'].'&amp;page='.$_GET['page'].'"title="Edit"><img src="'.SITE_ADM_IMG.'edit.png" border="0" alt="Edit" /></a>
							'.$subAdmin.'
						 </span></h2>';
			}
		?>
        	</div>
        </div>			
        <?php
		}
		?>
    </div>
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