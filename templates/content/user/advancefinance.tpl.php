<script type="text/javascript">
	function openproject(projectId)
	{
		window.location = application_path+"browseproject/"+projectId;		
	}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS;?>transaction_history.css"/>
<!--<link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS;?>dashboard.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS;?>dashboard_v2.css"/>-->
<section id="container">
   
   <div id="inbox" class="head_content temp">
       <h3>My Financials</h3>
   </div>
   
  
    <div class="clear"></div>
	<div class="table-main">
		<div class="table1" style="margin-bottom:50px;">
   	    <table width="955" border="0" align="center" cellpadding="0" cellspacing="0"> 
        	  <tr>
              	 <table width="955" border="0" cellpadding="0" cellspacing="0">
                      <tr class="table-title" style="background-color:#65ac2c">
                        <td class="table-title1">Total Amount Funded (In Other Projects)</td>
                        <td><?php echo $totalBacking; ?> USD To <?php echo $totalprojectBacker; ?> Projects</td>
                      </tr>
                      
                </table>

              </tr>
              <tr class="table-title2">
              	<table width="940" border="0" cellpadding="0" cellspacing="0" style="margin:15px;">
              		<tr class="table-title3" style="background-color:#FFF;">
                        <td width="180">Project</td>
                        <td width="120">Category</td>
                        <td width="120">Creator</td>
                        <td width="130">Amount($)</td>
                        <td width="120">Status</td>
                        <td width="150">Transaction Id</td>
                          <td width="80">Date</td>
                   </tr>
                   <tr>
                   	<td></td>
                   </tr>
                 </table>
              <tr>
              	<table width="940" border="0"  cellpadding="0" cellspacing="0" class="table" >
                 <?php if(mysql_num_rows($sqlResBacker) > 0) { ?>
         <?php while($resBacking = mysql_fetch_array($sqlResBacker)) { 
	  ?>
                <tr>
                    <td width="190" height="40" style="padding-left:15px;" title="<?php echo $resBacking['projectTitle']; ?>"><?php echo  substr($resBacking['projectTitle'], 0, 15) . "..."; ?></td>
                    <td width="85"><?php echo  $resBacking['categoryName']; ?></td>
                    <?php $project_creator=mysql_fetch_array($con->recordselect("SELECT * FROM users as us, projects as pr WHERE pr.userId=us.userId AND pr.projectId ='".$resBacking['projectId']."'")); ?>
                    <td width="155"><?php echo  $project_creator['name']; ?></td>
                    <td width="125">$<?php echo $resBacking['amount']; ?></td>
                    <td width="125"><?php echo $resBacking['status']; ?></td>
                    <td width="135"><?php echo $resBacking['transactionId']; ?></td>
                    <td width="95"><?php echo date("m-d-Y H:i:s",$resBacking['dateTime']); ?></td>
               </tr>
               
                
                
               
               
               
               

                <?php } 
				}
				else { ?>
					 <tr>
                    <td style="padding-left:350px; font-size:22px;">No Record Found</td>
               </tr>
			<?php	}
				 ?>



                              
              </table>
              </tr>
            </table>
		
        </div>
        
		<div class="table1">
   	    <table width="955" border="0" align="center" cellpadding="0" cellspacing="0"> 
        	  <tr>
              	 <table width="955" border="0" cellpadding="0" cellspacing="0">
                      <tr class="table-title" style="background-color:#65ac2c">
                        <td class="table-title1">Total Fund Received (To My Projects)</td>
                        <td><?php echo $totalCreate; ?> USD From <?php echo $totalprojectCreator; ?> Projects</td>
                      </tr>
                      
                </table>

              </tr>
              <tr class="table-title2">
              	<table width="940" border="0" cellpadding="0" cellspacing="0" style="margin:15px;">
              		<tr class="table-title3" style="background-color:#FFF;">
                        <td width="180">Project</td>
                        <td width="120">Category</td>
                        <td width="120">Backer</td>
                        <td width="130">Amount($)</td>
                        <td width="120">Status</td>
                   	  <td width="150">Transaction Id</td>
                       <td width="80">Date</td>
                   </tr>
                   <tr>
                   	<td></td>
                   </tr>
                 </table>
              <tr>
              	<table width="940" border="0"  cellpadding="0" cellspacing="0" class="table" >
                 <?php if(mysql_num_rows($sqlResCreator) > 0) { ?>
         <?php while($resCreator = mysql_fetch_array($sqlResCreator)) { 
	  ?>
                <tr>
                    <td width="190" height="40" style="padding-left:15px;" title="<?php echo $resCreator['projectTitle']; ?>"><?php echo  substr($resCreator['projectTitle'], 0, 15) . "..."; ?></td>
                    <td width="85"><?php echo  $resCreator['categoryName']; ?></td>
                    <?php
		//echo "SELECT * FROM users as us, paypaltransaction as pt WHERE pt.userId=us.userId AND pt.projectId ='".$resCreator['projectId']."'";
		 $project_Backer=mysql_fetch_array($con->recordselect("SELECT * FROM users as us, paypaltransaction as pt WHERE pt.userId=us.userId AND pt.projectId ='".$resCreator['projectId']."'")); ?>
                    <td width="155"><?php echo  $project_Backer['name']; ?></td>
                    <td width="125">$<?php echo $resCreator['amount']; ?></td>
                    <td width="125"><?php echo  $resCreator['status']; ?></td>
                    <td width="135"><?php echo  $resCreator['transactionId']; ?></td>
                    <td width="95"><?php echo  date("m-d-Y H:i:s",$resCreator['dateTime']); ?></td>
               </tr>
                 <?php } 
				}
				else { ?>
					 <tr>
                    <td style="padding-left:350px; font-size:22px;">No Record Found</td>
               </tr>
			<?php	}
				 ?>         
              </table>
              </tr>
            </table>
		
        </div>        
        
        
        
        
    </div>

    <p>&nbsp;</p>
    
    
    
    
    
</section>