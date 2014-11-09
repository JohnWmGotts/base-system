<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<script src="<?php echo SITE_JAVA; ?>redactor.js"></script>
<link rel="stylesheet" href="<?php echo SITE_CSS; ?>redactor.css" />

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
                <td>Newsletter Subscribers</td>
              </tr>
            </table>
        </td>
        <td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
    </tr>
    <tr>
        <td width="10" align="left" class="content-left-bg"></td>
        <td class="content">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            
            <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="DELREC" || $_GET["msg"]=="ADDREC" || $_GET["msg"]=="EDITREC" || $_GET["msg"]=="NEWSSUC")){ ?>
                <tr align="center">
                    
                    <?php if($_GET["msg"]=="SUCDEL") { ?>
                    <td align="center" class="success"><?php echo "Newsletter Subscriber Deleted Successfully"; ?></td>
                    <?php } else if($_GET["msg"]=="SUCBLO") { ?>
                    <td align="center" class="success"><?php echo "Newsletter Subscriber Blocked Successfully"; ?></td>
                    <?php } else if($_GET["msg"]=="SUCACT") { ?>
                    <td align="center" class="success"><?php echo "Newsletter Subscriber Activated Successfully"; ?></td>
                    <?php } ?>
                </tr>
                 
              <?php } ?>
           
            <tr>
            <tr>
                <td>&nbsp;</td>
              </tr>
            <tr>
            <td>
            <table width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder" id="insured_list">
            <thead>
                <tr class="trcolor">
                    <th width="40%" align="center" valign="middle" class="header1">User Name</th>
                    <th width="50%" align="center" valign="middle" class="header1">Email</th>
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
			 if(mysql_num_rows($sel_newsletter_subscriber)) {
             while ($selNewsLetter = mysql_fetch_assoc($sel_newsletter_subscriber)) { ?>     
             <tr>
              <td><?php echo $selNewsLetter['name']; ?></td>
              <td><?php echo base64_decode($selNewsLetter['emailAddress']); ?></td> 
            <td class="icon">
            <ul>
                <?php if($selNewsLetter['newsletter']==1) { ?>
               	 <li><a href="<?php echo SITE_ADM;?>newsletter_subscriber.php?action=block&amp;id=<?php echo $selNewsLetter['userId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to Block this user?')" title="Click here to block"><img src="<?php echo SITE_ADM_IMG;?>active.gif" border="0" alt="Active" /></a></li>
                <?php } else { ?>
                	<li><a href="<?php echo SITE_ADM;?>newsletter_subscriber.php?action=active&amp;id=<?php echo $selNewsLetter['userId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to Activate this user?')" title="Click here to activate"><img src="<?php echo SITE_ADM_IMG;?>block.png" border="0" alt="Block" /></a></li>
                <?php } ?>
                <?php if($_SESSION["admin_role"] == -1){ ?>
                	<li><a href="#" onclick="return confirm('You dont have privileges to do this action.')" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
                <?php }else{ ?>
                	<li><a href="<?php echo SITE_ADM;?>newsletter_subscriber.php?action=delete&amp;id=<?php echo $selNewsLetter['userId']; ?>" onclick="return confirm('Are you sure you want to delete?')" title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
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
					 headers: {  2: {
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