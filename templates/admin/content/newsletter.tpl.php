<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<script src="<?php echo SITE_JAVA; ?>redactor.js"></script>
<link rel="stylesheet" href="<?php echo SITE_CSS; ?>redactor.css" />
<script type="text/javascript">
$(document).ready(
	function()
	{
		$('#content').redactor({ 	
			imageUpload: '<?php echo SITE_URL; ?>admin/scripts/image_upload.php',
			fileUpload: '<?php echo SITE_URL; ?>admin/scripts/file_upload.php',
			imageGetJson: '<?php echo SITE_URL; ?>admin/json/data.json'
		});
		
	});
</script>
<?php if (isset($_GET) && isset($_GET['action']) && ($_GET['action'] == 'add')) { ?>
	<script language="javascript">
    $(document).ready(function() {
    $("#newsletter").validate({
            rules: {
                txtNewsLetterName: { required: true }
            },
            messages: {
                txtNewsLetterName: {
                    required: '<br>Please Enter Newsletter Name'
                }
            }
            });
    });	
    </script>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
        <td class="title-bg">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>Add Newsletter</td>
              </tr>
            </table>
        </td>
        <td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
    </tr>
    <tr>
        <td width="10" align="left" class="content-left-bg"></td>
        <td class="content">
            <form name="newsletter" id="newsletter" action="newsletter.php?action=add" method="post" >
            <input type="hidden" name="action" id="action" value="save" />
            <?php if($_GET['page']=="") { $page_no='1'; } else { $page_no=$_GET['page']; } ?>   
            <input type="hidden" name="page" id="page" value="<?php echo $page_no;?>" />             
                        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
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
                            <td width="22%" align="center" valign="top"><div align="right"><strong>Newsletter Name <span class="redcolor">*</span> : </strong></div></td>
                            <td width="82%" colspan="2" align="center"  bgcolor="#FFFFFF" ><div align="left">
                            <input type="text" id="txtNewsLetterName" name="txtNewsLetterName" size="40" class="logintextbox-bg" /></div>
                            </td>         
                        </tr>
                        
                        <tr>
                            <td width="22%" align="center" valign="top"><div align="right"><strong>Newsletter Content <span class="redcolor">*</span> : </strong></div></td>
                            <td colspan="2" align="center"  bgcolor="#FFFFFF">
                            <textarea id="content" name="content_newsletter" style="height:200px;" class="height400"></textarea>
                            <!--<textarea cols="70" rows="5" id="mailBody" name="mailBody"><?php// echo $_REQUEST['mailBody']; ?></textarea></div>-->
                            </td>           
                        </tr>
                        
                        <tr>
                            <td width="22%" align="center"  bgcolor="" class="whiteBold_text"><div align="right"><strong>&nbsp; </strong></div></td>
                            <td colspan="2" align="center"  bgcolor="#FFFFFF" class="whiteBold_text">
                            
                            <div align="left">
                            <input type="image" name="sendMail" value="Add" title="Add" src="<?php echo SITE_ADM_IMG;?>add-btn.gif"/>
                            <img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" title="Cancel" onclick="Javascript:window.location = 'newsletter.php';" style="cursor:pointer;"/>
                            
                            </div></td>         
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

 <?php } else if (isset($_GET) && isset($_GET['action']) && (($_GET['action'] == 'view') || ($_GET['action'] == 'edit'))) { ?>
	<script language="javascript">
    $(document).ready(function() {
    $("#mailingForm").validate({
            rules: {
                txtNewsLetterName: { required: true }
            },
            messages: {
                txtNewsLetterName: {
                    required: '<br>Please Enter Newsletter Name'
                }
            }
            });
    });	
    </script>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
        <td class="title-bg">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><?php echo ucfirst($_GET['action']); ?> Newsletter</td>
              </tr>
            </table>
        </td>
        <td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
    </tr>
    <tr>
        <td width="10" align="left" class="content-left-bg"></td>
        <td class="content">
     
            <form name="mailingForm" id="mailingForm" action="newsletter.php?action=<?php if($_GET['action'] == 'view') { echo "view&newsId=".$_GET['newsId']; } else { echo "edit&newsId=".$_GET['newsId']; } ?>" method="post" > 
             <?php if($_REQUEST['action'] == 'view') { ?> 
             <input type="hidden" name="action" id="action" value="send_mail" />
             <?php } else {  ?>
             <input type="hidden" name="action" id="action" value="edit_news" />
             <input type="hidden" name="news_Id" id="news_Id" value="<?php echo $_REQUEST['newsId']; ?>" />
             <?php } ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="5"> 
                  <tr>
                            <td width="250"></td>
                            <td width="10">&nbsp;</td>
                            <td>
                            <div class="fieldset-errors" style="color:red;">		
                                        <?php if(isset($error) && ($error!="")){ ?>						
                                        <?php print $error; ?>
                                        <?php } ?>
                                        <?php if(isset($_GET) && isset($_GET['msg1']) && ($_GET["msg1"]=='REGSUS')){ ?>
                                        <?php echo constant($_GET['msg1']); ?>
                                        <?php } ?>
                            </div>
                            </td>
                        </tr> 
                        <tr>
                            <td width="22%" align="center" valign="top"><div align="right"><strong>Newsletter Name: </strong></div></td>
                            <td width="82%" colspan="2" align="center"  bgcolor="#FFFFFF" ><div align="left"><input type="text" id="txtNewsLetterName" name="txtNewsLetterName" size="40" value="<?php echo $sel_EditNewsLetter['name']; ?>" class="logintextbox-bg" /></div></td>         
                        </tr>
                        
                        <tr>
                            <td width="22%" align="center" valign="top"><div align="right"><strong>Newsletter Content : </strong></div></td>
                            <td colspan="2" align="center"  bgcolor="#FFFFFF"><div align="left"><textarea id="content" name="content_newsletter" style="height:200px;" class="height400"><?php echo unsanitize_string($sel_EditNewsLetter['content']); ?></textarea></div></td>         
                        </tr>
                        
                        <tr>
                            <td width="22%" align="center"  bgcolor="" class="whiteBold_text"><div align="right"><strong>&nbsp; </strong></div></td>
                            <td colspan="2" align="center"  bgcolor="#FFFFFF" class="whiteBold_text">
                            
                            <div align="left">
                            <?php if($_REQUEST['action'] == 'view') { ?>
                             <input type="image" name="sendMail" title="Send" value="Send Email" src="<?php echo SITE_ADM_IMG;?>send.gif"/>
                            
                            <?php } else {  ?>
                            <input type="image" name="edit" value="Save" title="Change" src="<?php echo SITE_ADM_IMG;?>bt_change.gif"/>                   
                             <?php }  ?>
                             <img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" title="Cancel" onclick="Javascript:window.location = 'newsletter.php';" style="cursor:pointer;"/>                        
                            </div></td>         
                        </tr> 
    </table></form>
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

<script type="text/javascript">
	$(document).ready(function () {
	$(".modal_dialog").hide();
	$('.modal_show').click(function () {
	$(".modal_dialog").fadeToggle(10);
	});
});
</script>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
        <td class="title-bg">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>Manage Newsletter</td>
              </tr>
            </table>
        </td>
        <td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
    </tr>
    <tr>
        <td width="10" align="left" class="content-left-bg"></td>
        <td class="content">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <div class="modal_dialog dark">
                <div class="modal_dialog_outer">
                    <div class="modal_dialog_sizer">
                        <div class="modal_dialog_inner">
                            <div class="modal_dialog_content overflow">
                                <div class="modal_dialog_head">
                                    <a class="modal_dialog_close modal_show" href="#"><span class="ss-icon ss-delete"></span></a>
                                </div>
                                <div class="modal_dialog_body">
                                <div id="profile-bio-full">
                                    <h2>Email Details</h2>
                                    <?php 
										echo '<h3>Total Success Mail: '.$_SESSION['TOTAL_SUCCESS_MAIL'].'</h3>';
										echo '<h3>Total Fail Mail: '.$_SESSION['TOTAL_FAIL_MAIL'].'</h3>';
										echo '<h3>Success: </h3>';
										echo '<ul>';
										foreach($_SESSION['SUCCESS_MAIL_SEND'] as $value){
											if(isset($value)){
												echo '<li>'.$value.'</li>';
											}
										} 
										echo '</ul>';
										echo '<h3>Fail: </h3>';
										echo '<ul>';
										foreach($_SESSION['FAIL_MAIL_SEND'] as $value){
											if(isset($value)){
												echo '<li>'.$value.'</li>';
											}
										} 
										echo '</ul>';
									?>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="DELREC" || $_GET["msg"]=="ADDREC" || $_GET["msg"]=="EDITREC" || $_GET["msg"]=="NEWSSUC")){ ?>
                <tr align="center">
                    
                    <?php if($_GET["msg"]=="DELREC") { ?>
                    <td align="center" class="success"><?php echo "Newsletter Deleted Successfully"; ?></td>
                    <?php } else if($_GET["msg"]=="ADDREC") { ?>
                    <td align="center" class="success"><?php echo "Newsletter Added Successfully"; ?></td>
                    <?php } else if($_GET["msg"]=="EDITREC") { ?>
                    <td align="center" class="success"><?php echo "Newsletter Edited Successfully"; ?></td>
                    <?php } else if($_GET["msg"]=="NEWSSUC") { ?>
                    <td align="center" class="success">
						<?php echo "Newsletter Send Successfully "; ?>
                        <a href="javascript:void(0)" class="modal_show" >Show Details</a>
                    </td>
                    <?php } ?>
                </tr>
                 
              <?php } ?>
           
            <tr>
                <td height="10" align="right" >
                	<a href="newsletter.php?action=add" class="link" title="Add Newsletter"><strong>Add Newsletter</strong><!--<img src="../images/admin/add_icon.gif" border="0" alt="Add Newsletter" title="Add Newsletter" />--></a>
                </td>
            </tr>
            <tr>
            <tr>
                <td>&nbsp;</td>
              </tr>
            <tr>
            <td>
            <table width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder" id="insured_list">
            <thead>
                <tr class="trcolor">
                    <th width="80%" align="center" valign="middle" class="header1">Newsletter Name</th>
                    <th width="10%" align="center" valign="middle" >Send Email</th>
                    <th width="10%" align="center" >Operation</th>         
                </tr>
             </thead>
             <tbody>
                  <?php
                  if(isset($_SESSION['msg']) && ($_SESSION["msg"]!=""))
                  {
                  ?>
                   <tr>
                    <td colspan="8" align="center" bgcolor="#f3f3f3"><?php echo $_SESSION["msg"];?></td>
                  </tr>
                  <?php
                  $_SESSION["msg"]="";
                  }
                  ?>			  
             <?php 
			 if(mysql_num_rows($result)>0){
             while ($selNewsLetter = mysql_fetch_assoc($result)) { ?>     
             <tr>
              <td><?php echo $selNewsLetter['name']; ?></td>
                <!--<td><a href="<?php echo SITE_ADM; ?>newsletter.php?action=mail_send&newsId=<?php echo $selNewsLetter['id'] ?>"><img src="<?php echo SITE_ADM_IMG ?>send.gif" alt="Send" title="Send"></a></td>-->
                <td><a href="<?php echo SITE_ADM; ?>newsletter_send.php?action=mail_send&newsId=<?php echo $selNewsLetter['id'] ?>"><img src="<?php echo SITE_ADM_IMG ?>send.gif" alt="Send" title="Send"></a></td>			
                <td class="icon">
                    <ul>
                        <li><a href="<?php echo SITE_ADM; ?>newsletter.php?action=edit&newsId=<?php echo $selNewsLetter['id'] ?>"><img src="<?php echo SITE_ADM_IMG ?>edit.png" border="none" alt="Edit" title="Edit"/></a></li>
                        <?php if($_SESSION["admin_role"] == -1){ ?>
                        	<li><a href="#" onclick="return confirm('You dont have privileges to do this action.')" title="Delete"><img src="<?php echo SITE_ADM_IMG ?>delete.png" border="0" alt="Delete" /></a></li>
                        <?php }else{ ?>
                        	<li><a href="<?php echo SITE_ADM; ?>newsletter.php?action=delete&newsId=<?php echo $selNewsLetter['id'] ?>" onclick="return confirm('Are you sure to delete this newsletter?')" title="Delete"><img src="<?php echo SITE_ADM_IMG ?>delete.png" border="0" alt="Delete" /></a></li>
                        <?php } ?>
                    </ul>
            </tr>
            <?php }} else { ?>
			<tr><td colspan="5">No records found.</td></tr>
			<?php }
				?>
            </tbody>
            <tbody>
            <tr id="pager" class="pager" >
            <td colspan="7"><!--<center><?php //echo $pagination; ?>--></center>
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
            </tr>
            </table>
            
			<script defer="defer">
				$(document).ready(function(){ 
					$("#insured_list").tablesorter({widthFixed: true,
					 widgets: ['zebra'],
					 headers: {  1: {
						  				sorter: false 
						  			}
							  }
				})	
					.tablesorterPager({container: $("#pager")}); 
				}); 
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