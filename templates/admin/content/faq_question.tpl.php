<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<link rel="stylesheet" href="<?php echo SITE_CSS; ?>redactor.css" />
<script src="<?php echo SITE_JAVA; ?>redactor.js"></script>
<?php if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')) {?>
<script type="text/javascript">
$(document).ready(function() {
	$('#wait_1').hide();
	$('#drop_1').change(function(){
	  $('#wait_1').show();
	  $('#result_1').hide();	  
      $.get("func.php", {
		func: "drop_1",
		drop_var: $('#drop_1').val()
      }, function(response){
        $('#result_1').fadeOut();
        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
      });
    	return false;
	});
	<?php if($_GET['action']=='edit') { ?>
	$.get("func.php", {
		func: "drop_1",
		drop_var: $('#drop_1').val(),
		drop_var2: $('#faqCategoryId1').val()
      }, function(response){
        $('#result_1').fadeOut();
        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
      });
	  <?php } ?>
});
function finishAjax(id, response) {
  $('#wait_1').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
</script>
<script type="text/javascript">
			$(document).ready(
				function()
				{
					$('#redactor_content').redactor({ 	
						imageUpload: application_path1+'includes/scripts/image_upload.php',
						fileUpload: application_path1+'includes/scripts/file_upload.php',
						imageGetJson: application_path1+'includes/json/data.json'
					});
					
					$("#f1").validate({
						rules: {
							faqQuestion: { required: true },
							drop_1: { required: true }
						},
						messages: {
							faqQuestion: {
								required: "<br>Please Enter Question"
							},
							drop_1: {
								required: "<br>Please Select Main Category"
							}
						}
					});
				});
</script>
<!--<script type="text/javascript">
function checkcategory()
{
	if(document.getElementById("drop_1").value=NULL)
	{
		document.getElementById("error_cat").innerHTML="Please select any main category";
	}
}
</script>-->
<!--FAQ question add and edit html Start-->

<?php // jwg fixups
	$page = 1;
	if(isset($_GET) && isset($_GET['page']) && ($_GET['page']>1)) {
		$page = $_GET['page'];
	}
	if (!isset($limit)) $limit = 10; 
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg"><?php echo ucfirst($_GET['action']);?> FAQ Question</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">		
		<form action="faq_question.php?id=<?php echo $_GET['id']; ?>&amp;page=<?php echo $page; ?>&amp;action=<?php echo $_GET['action'];?>" method="post" name="f1" id="f1">
		<input type="hidden" name="action" id="action" value="<?php echo $_GET['action'];?>" />
        <input type="hidden" name="faqQuestionAnswerId" id="faqQuestionAnswerId" value="<?php echo $sel_faq_questionanswer['faqQuestionAnswerId']; ?>" />
		<input type="hidden" name="faqCategoryId1" id="faqCategoryId1" value="<?php echo $sel_faq_questionanswer['faqCategoryId']; ?>" />
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="200"></td>
			<td width="10">&nbsp;</td>
			<td>
			<div class="fieldset-errors" style="color:red;">
            			<div id="msgPart"> <?php if (isset($_SESSION['msgType'])) echo disMessage($_SESSION['msgType']); ?> </div>
                        		
						<?php if(isset($error) && ($error!="")){ ?>						
						<?php print $error; ?>
						<?php } ?>
						<?php if(isset($_GET['msg1']) && ($_GET["msg1"]=='REGSUS')){ ?>
						<?php echo constant($_GET['msg1']); ?>
						<?php } ?>
			</div>
			</td>
		</tr>
		  <tr>
			<td height="10" colspan="3"><input name="admin_id" id="admin_id" type="hidden"  value="<?php echo $_GET['id']; ?>" /></td>
		  </tr>
		  <tr>
			<td width="200" align="right"><strong>Main Category<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            	<select  name="drop_1" id="drop_1">
                <?php
                if($_GET['action']=='add')
				{
				?>
                <option value="" disabled="disabled" selected="selected">Choose one</option>                            	
            	<?php
				}
				$selCategory=$con->recordselect("SELECT * FROM faqcategory WHERE `faqCategoryParentId` =0 AND faqStatus!='0'");
				while($selCategoryName=mysql_fetch_assoc($selCategory))
				{
					$selCategory1=$con->recordselect("SELECT * FROM faqcategory WHERE `faqCategoryParentId` ='".$selCategoryName['faqCategoryId']."'");
					if(mysql_num_rows($selCategory1)>0)
					{
				?>
                	<option <?php if($selCategoryName['faqCategoryId']==$sel_faq_main_cat1['faqCategoryId']) { echo 'selected="selected"'; } ?> value="<?php echo $selCategoryName['faqCategoryId']; ?>"  ><?php echo $selCategoryName['faqcategoryName']; ?></option>
                <?php 
				} }
				?>
                </select>
                <label id="error_cat" ></label>
            </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>          
		  <tr>
			<td width="200" align="right"><strong>Sub Category<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            	<span id="wait_1" style="display: none;">
                <img alt="Please Wait" src="ajax-loader.gif"/>
                </span>
                <span id="result_1" style="display: none;"></span>            	
            </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
          <tr>
			<td width="200" align="right"><strong>Question<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            	<input type="text" class="logintextbox-bg" name="faqQuestion" value="<?php echo $sel_faq_questionanswer['faqQuestion']; ?>" />
            </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
          <tr>
			<td width="200" align="right" valign="top"><strong>Answer<span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            	 <textarea id="redactor_content" name="faqAnswer" style="height:200px;" class="height400"><?php echo $sel_faq_questionanswer['faqAnswer']; ?></textarea>
            	<!--<input type="text" class="logintextbox-bg" name="faqAnswer" value="<?php //echo $sel_faq_questionanswer['faqAnswer']; ?>" />-->
            </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  
		  <tr>
			<td width="200" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php $btn_img=($_GET['action']=='add')?'add-btn.gif':'bt_change.gif'; $btn_tit=($_GET['action']=='add')?'Add':'Change'; ?>
				<input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>faq_question.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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
<!--FAQ question add and edit html Ends-->
<?php } else { ?>
<!-- Display FAQ question starts-->
<?php
	$page = 1;
	if(isset($_GET) && isset($_GET['page']) && ($_GET['page']>1)) {
		$page = $_GET['page'];
	}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>FAQ Question And Answers</td>
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
        <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="DELREC" || $_GET["msg"]=="ADDREC" || $_GET["msg"]=="EDITREC" || $_GET["msg"]=="ALREADYADD")){ ?>
			<tr align="center">
				
                <?php if($_GET["msg"]=="DELREC") { ?>
				<td align="center" class="success"><?php echo DEL; ?></td>
				<?php } else if($_GET["msg"]=="ADDREC") { ?>
                <td align="center" class="success"><?php echo ADD; ?></td>
                <?php } else if($_GET["msg"]=="EDITREC") { ?>
                <td align="center" class="success"><?php echo EDIT; ?></td>
                <?php }elseif($_GET["msg"]=="ALREADYADD"){ ?>
                <td align="center" class="error"><?php echo 'Already Exists Question'; ?></td>
                <?php } ?>
            </tr>
			 
          <?php } ?>
		<tr>
			<td align="right"><a href="<?php echo SITE_ADM;?>faq_question.php?action=add" title="Add New FAQ Question" class="link"><strong>Add New FAQ Question</strong></a></td>
		</tr>
		<tr>
			<td height="10"></td>
		  </tr>
		<tr>
		<td>
		<table id="insured_list" width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder">
		<thead> 
		<tr class="trcolor">           
			<th width="22%" align="center" class="header1">Main Category</th>
			<th width="22%" align="center" class="header1">Sub Category</th>
			<th width="49%" align="center" class="header1">Question</th>
            <th width="7%" align="center">Operation</th>
		</tr>
		</thead>
		  <tbody> 
			<?php	
				//$results =$con->recordselect("SELECT * FROM categories WHERE role=1 LIMIT $start, $limit");				
				if(mysql_num_rows($sel_faq_question)) {
				while ($selFaqQuestion = mysql_fetch_assoc($sel_faq_question))
				{
					$sel_faq_sub_cat=mysql_fetch_array($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$selFaqQuestion['faqCategoryId']."'"));		
					$sel_faq_main_cat=mysql_fetch_array($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$selFaqQuestion['faqCategoryParentId']."'"));		
			?>
		  <tr>
			<td><?php echo stripslashes($sel_faq_main_cat['faqcategoryName']); ?></td>
			<td><?php echo stripslashes($sel_faq_sub_cat['faqcategoryName']); ?></td>
			<td><?php echo stripslashes($selFaqQuestion['faqQuestion']); ?></td>	
			<td class="icon">
				<ul>
					<li><a href="<?php echo SITE_ADM;?>faq_question.php?action=edit&amp;id=<?php echo $selFaqQuestion['faqQuestionAnswerId']; ?>&amp;page=<?php echo $page; ?>" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a></li>
					<?php if($_SESSION["admin_role"] == -1){ ?>
                    	<li><a href="#" onclick="return confirm('You dont have privileges to do this action.')" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
					<?php }else{ ?>
                    	<li><a href="faq_question.php?action=delete&amp;id=<?php echo $selFaqQuestion['faqQuestionAnswerId']; ?>&amp;page=<?php echo $page; ?>" onclick="return confirm('Are you sure you want to delete?')" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
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
					<!--<select class="pagesize" disabled="disabled">
						<option value="<?php //echo 10; ?>">20</option>									
					</select>-->
				</form>
			
		</td>
		</tr>
        </tbody>
        
		<tr>
		<td colspan="9"><center><?php echo (isset($pagination)) ? $pagination : ''; ?></center>
			<div id="pager" class="pager" style="display:none;">
				<form>					
					<select class="pagesize">
						<option value="<?php echo (isset($limit)) ? $limit : 10; ?>">LIMIT</option>									
					</select>
				</form>
			</div>
			<script defer="defer">
				$(document).ready(function() 
				{ 
					$("#insured_list")
					.tablesorter({widthFixed: true, widgets: ['zebra'],
					headers: {  
								3: {
						  				sorter: false 
						  			}
							  }
					})
					.tablesorterPager({container: $("#pager")}); 
				} 
				); 
			</script>
		</td>
		</tr>
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
<!-- Display FAQ question ends-->
<?php } ?>