<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<?php if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')) {?>
	<script language="javascript">
    $(document).ready(function() {
    $("#f1").validate({
            rules: {
                adminname: { required: true,minlength: 4,maxlength: 25 },
                adminemail: { rquired: true, email: true },           
                password: { required: true,minlength: 6,maxlength: 25 },
                cpassword: { required: true,equalTo: "#password" }
            },
            messages: {
                adminname: {
                    required: "<?php echo '<br>'.ER_USER;?>",
                    minlength: "<?php echo '<br>Name should be atleast 4 characters long';?>",
                    maxlength: "<?php echo '<br>Name should not be more than 25 characters long';?>"
                },
                adminemail: {
                    required: "<?php echo '<br>'.ER_EMAIL;?>",
                    email: "<?php echo '<br>Please Enter Valid Email Address'; ?>"	
                },
                password: {
                    required: "<?php echo '<br>'.ER_PSW;?>",
                    minlength: "<?php echo '<br>Password should be atleast 6 characters long';?>",
                    maxlength: "<?php echo '<br>Password should not be more than 25 characters long';?>"
                },
                cpassword: {
                    required: "<?php echo '<br>'.ER_CPSW;?>",
                    equalTo: "<?php echo '<br>'.ER_SAMEPSW;?>"
                }
            }
            });
    });	
    </script>
    <script type="text/javascript">
    
    function onchangeusername(adminname)
    {
        var adminid = document.getElementById('admin_id').value;
    
            if (adminname)
            {
                url = document.location.href;
                xend = url.lastIndexOf("/") + 1;
                var base_url = url.substring(0, xend);
                url="admin_ajax.php?adminname="+adminname+"&id="+adminid;			
                if (url.substring(0, 4) != 'http')
                {
                    url = base_url + url;
                }
                var strSubmit="adminname="+adminname;
                var strURL = url;
                var strResultFunc = "adminavable";
                xmlhttpPost(strURL, strSubmit, strResultFunc)
                return true;
            }
    }
    function onchangeemail(adminemail)
    {
        var adminid = document.getElementById('admin_id').value;
    
            if (adminemail)
            {
                url = document.location.href;
                xend = url.lastIndexOf("/") + 1;
                var base_url = url.substring(0, xend);
                url="admin_ajax.php?adminemail="+adminemail+"&id="+adminid;			
                if (url.substring(0, 4) != 'http')
                {
                    url = base_url + url;
                }
                var strSubmit="adminemail="+adminemail;
                var strURL = url;
                var strResultFunc = "adminavable1";
                xmlhttpPost(strURL, strSubmit, strResultFunc)
                return true;
            }
    }
    function adminavable1(strIn)
    {
        if(strIn=='1')
        {		
            document.getElementById("admin_valid_email").innerHTML="Email already Exist!";    	
            return false;
        }
        else
        {
            document.getElementById("admin_valid_email").innerHTML="";
        }
    }
    function adminavable(strIn)
    {
        if(strIn=='1')
        {		
            document.getElementById("admin_valid").innerHTML="Name already Exist!";    	
            return false;
        }
        else
        {
            document.getElementById("admin_valid").innerHTML="";
        }
    }
    </script>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
        <td class="title-bg"><?php echo ucfirst($_GET['action']);?> Staff</td>
        <td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
    </tr>
    <tr>
        <td width="10" align="left" class="content-left-bg"></td>
        <td class="content">		
            <form action="admin.php?id=<?php echo (isset($_GET) && isset($_GET['id'])) ? $_GET['id'] : ''; ?>&amp;page=<?php echo (isset($_GET) && isset($_GET['page'])) ? $_GET['page'] : ''; ?>&amp;action=<?php echo (isset($_GET) && isset($_GET['action'])) ? $_GET['action'] : '';?>" method="post" name="f1" id="f1">
            <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET) && isset($_GET['action'])) ? $_GET['action'] : '';?>" />
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
                <td height="10" colspan="3"><input name="admin_id" id="admin_id" type="hidden"  value="<?php echo (isset($_GET) && isset($_GET['id'])) ? $_GET['id'] : ''; ?>" /></td>
              </tr>
              <tr>
                <td width="250" align="right"><strong>Username <span class="redcolor">*</span> :</strong></td>
                <td width="10">&nbsp;</td>
                <td><input name="adminname" id="adminname" type="text" class="logintextbox-bg" value="<?php echo stripslashes($sel_user_edit_qry['username']); ?>" onblur="return onchangeusername(this.value);" /><br><label id="admin_valid" style="text-transform: none; color: red;"></label></td>
              </tr>
              <tr>
                <td height="10" colspan="3"></td>
              </tr>
              <tr>
                <td width="250" align="right"><strong>Email <span class="redcolor">*</span> :</strong></td>
                <td width="10">&nbsp;</td>
                <td><input name="adminemail" id="adminemail" type="text" class="logintextbox-bg" value="<?php echo base64_decode($sel_user_edit_qry['email']); ?>" onblur="return onchangeemail(this.value);" /><br><label id="admin_valid_email" style="text-transform: none; color: red;"></label></td>
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
                <td height="10" colspan="3"></td>
              </tr>
              <tr>
                <td width="250" align="right"><strong>Confirm Password <span class="redcolor">*</span> :</strong></td>
                <td width="10">&nbsp;</td>
                <td><input name="cpassword" id="cpassword" type="password" class="logintextbox-bg" value="<?php echo base64_decode($sel_user_edit_qry['password']); ?>" /></td>
              </tr>
              <tr>
                <td height="10" colspan="3"></td>
              </tr>
              <tr>
                <td width="250" align="right">&nbsp;</td>
                <td width="10">&nbsp;</td>
                <td>
                    <?php $btn_img=($_GET['action']=='add')?'add-btn.gif':'bt_change.gif';
                            $btn_tit=($_GET['action']=='add')?'Add':'Change';				
                    ?>
                    <input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>admin.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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
<?php } else { 
//Not Action ADD?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
        <td class="title-bg">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>Manage Staff</td>
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
             <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="DELREC" || $_GET["msg"]=="ADDREC" || $_GET["msg"]=="EDITREC")){ ?>
                <tr align="center">
                    
                    <?php if($_GET["msg"]=="DELREC") { ?>
                    <td align="center" class="success"><?php echo DEL; ?></td>
                    <?php } else if($_GET["msg"]=="ADDREC") { ?>
                    <td align="center" class="success"><?php echo ADD; ?></td>
                    <?php } else if($_GET["msg"]=="EDITREC") { ?>
                    <td align="center" class="success"><?php echo EDIT; ?></td>
                    <?php } ?>
                </tr>
                 
              <?php } ?>
            <tr>
                <td align="right"><a href="<?php echo SITE_ADM;?>admin.php?action=add" title="Add New Staff" class="link"><strong>Add New Staff</strong></a></td>
            </tr>
            <tr>
                <td height="10"></td>
              </tr>
            <tr>
            <td>
            <table id="insured_list" width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder">
            <thead> 
            <tr class="trcolor">
   
                <th width="30%" align="center" class="header1">User Name</th>
                <th width="30%" align="center" class="header1">Email Address</th>
                <th width="15%" align="center" >Operation</th>
              </tr>
              </thead>
              <tbody> 
                <?php	
                    $results =$con->recordselect("SELECT * FROM admin WHERE role=1 ORDER BY id DESC LIMIT $start, $limit");				
                    if(mysql_num_rows($results)>0){
					while ($sel_user_all = mysql_fetch_assoc($results))
                    {
                ?>
              <tr>
  
                <td ><?php echo stripslashes($sel_user_all['username']); ?></td>
                <td ><?php echo base64_decode($sel_user_all['email']); ?></td>
                <td class="icon">
                    <ul>
                        <li><a href="<?php echo SITE_ADM;?>admin.php?action=edit&amp;id=<?php echo $sel_user_all['id']; ?>&amp;page=<?php echo $_GET['page']; ?>" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a></li>
    					<?php if($_SESSION["admin_role"] == -1){ ?>
                        	<li><a href="#" onclick="return confirm('You dont have privileges to do this action.')" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
                        <?php }else{ ?>
                        	<li><a href="admin.php?action=delete&amp;id=<?php echo $sel_user_all['id']; ?>" onclick="return confirm('Are you sure you want to delete?')" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
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
            <tr id="pager" class="pager" >
            <td colspan="7">
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
            <script defer="defer">
                $(document).ready(function() 
                { 
                    $("#insured_list")
                    .tablesorter({widthFixed: true, widgets: ['zebra'],
                        headers: {  
                                2: {
                                        sorter: false 
                                    }
                                }
                    })
                    .tablesorterPager({container: $("#pager")}); 
                } 
                ); 
            </script>
            
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