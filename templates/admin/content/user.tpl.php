<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<?php if(isset($_GET['action'])) {?>
	<script language="javascript">
    $(document).ready(function() {
        $.validator.addMethod("validpassword", function(value, element) {
            return value.match(new RegExp(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).*$/g));
            }, 
            "The password must contain a minimum of one lower case character," + " one upper case character and one digit");	   
    $("#f1").validate({
            rules: {
                uname: { required: true,minlength: 4,maxlength: 25 },
                biography: { maxlength: 300 },
                password: { required: true,minlength: 6,validpassword:true, maxlength: 25 },
                email: { required: true,email: true }
            },
            messages: {
                uname: {
                    required: "<?php echo '<br>'.ER_FULLNAME; ?>",
                    minlength: "<?php echo ER_UNAME_MIN; ?>",
                    maxlength: "<?php echo ER_UNAME_MAX; ?>"
                },
                biography: {
                    maxlength: "<?php echo ER_UBIOGRAPHY_MAX;?>"
                },
                password: {
                    required: "<?php echo '<br>'.ER_PSW;?>",
                    minlength: "<?php echo ER_UPWD_MIN;?>",
                    validpassword: "<?php echo ER_UPWD_VALID;?>",
                    maxlength: "<?php echo '<br>Password should not be more than 25 characters long'; ?>"
                },
                email: {
                    required: "<?php echo '<br>'.ER_EMAIL;?>",
                    email: "<?php echo ER_UEMAIL;?>"
                }
            }
            });
    });	
    </script>
    <script type="text/javascript">
    function onchangeemail(email)
    {
    var id = document.getElementById('user_id').value;
    
            if (email)
            {
                url = document.location.href;
                xend = url.lastIndexOf("/") + 1;
                var base_url = url.substring(0, xend);
                url="user_ajax.php?user_email="+email+"&id="+id;
                if (url.substring(0, 4) != 'http')
                {
                    url = base_url + url;
                }
                var strSubmit="user_email1="+email;
                var strURL = url;
                var strResultFunc = "emailavable";
                xmlhttpPost(strURL, strSubmit, strResultFunc)
                return true;
            }
    }
    
    function emailavable(strIn)
    {
        if(strIn=='1')
        {
            document.getElementById("email_valid").innerHTML="That email address is already registered.";
            return false;
        }
        else
        {
            document.getElementById("email_valid").innerHTML="";
            return true;
        }
    }
    </script>
 <?php
	$page = 1;
	if(isset($_GET) && isset($_GET['page']) && ($_GET['page']>1)) {
		$page = $_GET['page'];
	}
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
        <td class="title-bg"><?php echo ucfirst($_GET['action']);?> User</td>
        <td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
    </tr>
    <tr>
        <td width="10" align="left" class="content-left-bg"></td>
        <td class="content">
			<?php
				$id = (isset($_GET['id'])) ? $_GET['id'] : 0; // jwg
			?>
            <form action="user.php?id=<?php echo $id; ?>&amp;page=<?php echo $page; ?>&amp;action=<?php echo $_GET['action'];?>" method="post" name="f1" id="f1">
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
                            <?php if(isset($_GET) && isset($_GET['msg1']) && ($_GET["msg1"]=='REGSUS')){ ?>
                            <?php echo constant($_GET['msg1']); ?>
                            <?php } ?>
                </div>
                </td>
            </tr>
              <tr>
                <td width="250" align="right"><strong>Full Name <span class="redcolor">*</span> :</strong></td>
                <td width="10">&nbsp;</td>
                <td><input name="uname" id="uname" type="text" class="logintextbox-bg" value="<?php echo $sel_user_edit_qry['name']; ?>" /></td>
              </tr>
              <tr>
                <td height="10" colspan="3"></td>
              </tr>
              <tr>
                <td width="250" align="right"><strong>Password <span class="redcolor">*</span> :</strong></td>
                <td width="10">&nbsp;</td>
                <td><input name="password" id="password" type="password" class="logintextbox-bg" value="<?php echo base64_decode($sel_user_edit_qry['password']); ?>" /></td>
              </tr>
              <tr>
                <td height="10" colspan="3"><input name="user_id" id="user_id" type="hidden"  value="<?php echo $id; ?>" /></td>
              </tr>
              <tr>
                <td width="250" align="right"><strong>Email <span class="redcolor">*</span> :</strong></td>
                <td width="10">&nbsp;</td>
                <td><input name="email" id="email" type="text" class="logintextbox-bg" value="<?php echo base64_decode($sel_user_edit_qry['emailAddress']); ?>" onblur="return onchangeemail(this.value);" /><br><label id="email_valid" style="text-transform: none; color: red;"></label></td>
              </tr>
              <tr>
                <td height="10" colspan="3"></td>
              </tr>
              <tr>
                <td width="250" align="right"><strong>Biography  :</strong></td>
                <td width="10">&nbsp;</td>
                <td><textarea name="biography" id="biography" class="textarea-bg"><?php echo stripslashes($sel_user_edit_qry['biography']);?></textarea></td>
              </tr>
              <tr>
                <td height="10" colspan="3"></td>
              </tr>
              <tr>
                <td width="250" align="right"><strong>Status :</strong></td>
                <td width="10">&nbsp;</td>
                <td>
                    <select name="status">
                        <option value="1" <?php if($sel_user_edit_qry['activated']==1) { echo 'selected'; } ?> >Activate</option>
                        <option value="0" <?php if($sel_user_edit_qry['activated']==0) { echo 'selected'; } ?> >Inactivate</option>
                        <option value="2" <?php if($sel_user_edit_qry['activated']==2) { echo 'selected'; } ?> >Blocked</option>
                    </select>
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
                    <input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>user.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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
                <td>Manage Users</td>
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
             <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="DELREC" || $_GET["msg"]=="ADDREC" || $_GET["msg"]=="EDITREC" || $_GET["msg"]=="SUCBLO" || $_GET["msg"]=="SUCACT")){ ?>
                <tr align="center">
                    
                    <?php if($_GET["msg"]=="DELREC") { ?>
                    <td align="center" class="success"><?php echo DEL; ?></td>
                    <?php } else if($_GET["msg"]=="ADDREC") { ?>
                    <td align="center" class="success"><?php echo ADD; ?></td>
                    <?php } else if($_GET["msg"]=="EDITREC") { ?>
                    <td align="center" class="success"><?php echo EDIT; ?></td>
                     <?php } else if($_GET["msg"]=="SUCBLO") { ?>
                    <td align="center" class="success"><?php echo "User Blocked Successfully"; ?></td>
                    <?php } else if($_GET["msg"]=="SUCACT") { ?>
                    <td align="center" class="success"><?php echo "User Activated Successfully"; ?></td>
                    <?php }  ?>
                </tr>
                 
              <?php } ?>
               <tr>
                    <div align="right"><a href="<?php echo SITE_URL;?>admin/export/exportuser.php" title="Export Users">Export Users WITH XLS</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo SITE_URL;?>admin/csvuser.php" title="Export Users">Export Users WITH CSV</a> 
                    </div>
                    <div align="right"> 
                    </div>
    </tr>
            <tr>
                <td align="right"><a href="<?php echo SITE_ADM;?>user.php?action=add" title="Add New User" class="link"><strong>Add New User</strong></a></td>
            </tr>
            <tr>
                <td height="10"></td>
              </tr>
            <tr>
            <td>
            <table id="insured_list" width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder">
            <thead> 
            <tr class="trcolor">
    			<th width="32%" align="center" class="header1">Name</th>
                
                <th width="44%" align="center" class="header1">Email</th>
                
                <th width="12%" align="center" class="header1">Status</th>
                
                <th width="15%" align="center" >Operation</th>
              </tr>
              </thead>
              <tbody> 
                <?php	
				if(mysql_num_rows($result)>0){			
                    while ($sel_user_all = mysql_fetch_assoc($result))
                    {
                ?>
              <tr>
    
                <td colspan=""><?php echo $sel_user_all['name']; ?></td>
                <td colspan=""><?php echo base64_decode($sel_user_all['emailAddress']); ?></td>
                <td colspan=""><?php if($sel_user_all['activated']==1){ echo "Activated"; } else if($sel_user_all['activated']==0){ echo "Inactivated"; } else if($sel_user_all['activated']==2){ echo "Blocked"; }  ?></td>
                <td class="icon">
                    <ul>
                        <li><a href="<?php echo SITE_ADM;?>user.php?action=edit&amp;id=<?php echo $sel_user_all['userId']; ?>&amp;page=<?php echo $page; ?>" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a></li>
                        
						<?php if($sel_user_all['activated']==1) { ?>
                        <li><a href="<?php echo SITE_ADM;?>user.php?action=block&amp;id=<?php echo $sel_user_all['userId']; ?>&amp;page=<?php echo $page; ?>"onclick="return confirm('Are you sure you want to Block this user?')" title="Click here to block"><img src="<?php echo SITE_ADM_IMG;?>active.gif" border="0" alt="Active" /></a></li>
                        <?php } else { ?>
                        <li><a href="<?php echo SITE_ADM;?>user.php?action=active&amp;id=<?php echo $sel_user_all['userId']; ?>&amp;page=<?php echo $page; ?>"onclick="return confirm('Are you sure you want to Activate this user?')" title="Click here to activate"><img src="<?php echo SITE_ADM_IMG;?>block.png" border="0" alt="Block" /></a></li>
                        <?php } ?>
                        <?php if($_SESSION["admin_role"] == -1){ ?>
                        	<li><a href="#" onclick="return confirm('You dont have privileges to do this action.')" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
                        <?php }else{ ?>
                        	<li><a href="<?php echo SITE_ADM;?>user_del.php?id=<?php echo $sel_user_all['userId']; ?>" onclick="return confirm('Are you sure you want to delete?')" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
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
            </table>
            <script defer="defer">
                    $(document).ready(function(){ 
                        $("#insured_list").tablesorter({widthFixed: true,
                         widgets: ['zebra'],
                         headers: {  3: {
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