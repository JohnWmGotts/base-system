<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<script src="<?php echo SITE_JAVA; ?>redactor.js"></script>
<link rel="stylesheet" href="<?php echo SITE_CSS; ?>redactor.css" />

<script type="text/javascript">
	$(document).ready(function() {
		$("#frmnews").validate({
			errorLabelContainer: "#containerError",
            wrapper: "span",
            errorClass: "error",
			
			 rules: {
				"newsusers[]": { required: true},
            },
			 messages: {
                "newsusers[]": {
                    required: "Please check atleast one checkbox checked to send mail."
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
                <td>Newsletter Subscriber</td>
              </tr>
            </table>
        </td>
        <td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
    </tr>
    <tr>
        <td width="10" align="left" class="content-left-bg"></td>
        <td class="content">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            
            <?php if($_GET["msg"]=="DELREC" || $_GET["msg"]=="ADDREC" || $_GET["msg"]=="EDITREC" || $_GET["msg"]=="NEWSSUC"){ ?>
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
            <form action="<?php echo SITE_ADM; ?>newsletter.php?action=mail_send&newsId=<?php echo $newsId; ?>" method="post" name="frmnews" id="frmnews">
            <table width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder" id="insured_list">
            <thead>
                <tr class="trcolor">
                    <th width="10%" align="center" valign="middle" class="header1">Id</th>
                    <th width="40%" align="center" valign="middle" class="header1">User Name</th>
                    <th width="40%" align="center" valign="middle" class="header1">Email</th>
                    <th width="10%" align="center" >Operation</th>         
                </tr>
             </thead>
             <tbody>
                  <?php
                  if($_SESSION["msg"]!="")
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
			 $i=1;
             while ($selNewsLetter = mysql_fetch_assoc($sel_newsletter_subscriber)) { ?>     
             <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $selNewsLetter['name']; ?></td>
              <td><?php echo base64_decode($selNewsLetter['emailAddress']); ?></td> 
            <td class="icon">
            <ul>
                 <?php if($selNewsLetter['newsletter']==1) { ?>
               	 <li><input type="checkbox" checked="checked" value="<?php echo $selNewsLetter['userId'];?>" name="newsusers[]" id="newsusers_<?php echo $selNewsLetter['userId']; ?>" /></li>
                <?php } else { ?>
                	<li><input type="checkbox" value="<?php echo $selNewsLetter['userId'];?>" name="newsusers[]" id="newsusers_<?php echo $selNewsLetter['userId']; ?>"/></li>
                <?php } ?>
            </ul>
            </tr>
            <?php $i=$i+1; ?>
            <?php } ?>
            <center><div id="containerError"></div></center>
            <input type="submit" value="Send" />
            
            
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
            </form>
            </td>
            </tr>
            </table>
            
			<script defer="defer">
				$(document).ready(function(){ 
					$("#insured_list").tablesorter({widthFixed: true,
					 widgets: ['zebra'],
					 headers: {  4: {
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