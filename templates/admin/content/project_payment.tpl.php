<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<script src="<?php echo SITE_JAVA; ?>jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<link rel="stylesheet" href="<?php echo SITE_CSS; ?>ui-lightness/jquery.ui.all.css">
<script type="text/JavaScript" src="<?php echo $base_url; ?>js/curvycorners.js"></script>
<script src="<?php echo SITE_JAVA; ?>ui/jquery.ui.core.js"></script>
<script src="<?php echo SITE_JAVA; ?>ui/jquery.ui.widget.js"></script>
<script src="<?php echo SITE_JAVA; ?>ui/jquery.ui.position.js"></script>
<script src="<?php echo SITE_JAVA; ?>ui/jquery.ui.dialog.js"></script>

<div id="dialog" title="Basic dialog">	
</div>
<?php if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')) {?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg"><?php echo ucfirst($_GET['action']);?> Admin</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">					
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
			<td>Project Payments</td>
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
		<tr>
			<td align="right"></td>
		</tr>
		<tr>
			<td height="10"></td>
		  </tr>
		<tr>
		<tr>			
			<td colspan="11">
			<center>
			<div class="fieldset-errors" style="color:red;">		
						<?php //if($error!=""){ ?>						
						<?php //print $error; ?>
						<?php //} ?>
						<?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=='DELSUS')){ ?>
						<?php echo "Project deleted successfully"; ?>
						<?php } ?>
			</div>
			</center>
			</td>
		</tr>
		<td>
		<table id="insured_list" width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder">
		<thead> 
		<tr class="trcolor">			
			<!--<th width="2%"><div><a href="#" title="Ascending"><img src="<?php echo SITE_ADM_IMG;?>top-arrow.png" border="0" alt="Ascending" /></a></div><div><a href="#" title="Descending"><img src="<?php echo SITE_ADM_IMG;?>bottom-arrow.png" border="0" alt="Descending" /></a></div></th>-->
			<th width="29%" align="center" class="header1">Project Title</th>
			<th width="12%" align="center" class="header1">Project Category</th>
            <th width="12%" align="center" class="header1">Project Creator</th>
			<th width="10%" align="center" class="header1">Project Goal</th>
            <th width="10%" align="center" class="header1">Total Reward</th>
            <th width="10%" align="center" class="header1">Status</th>
            <th width="20%" align="center" class="header1">Payment Detail</th>
			<th width="12%" align="center" class="header1">Project Location</th>
			<th width="7%" align="center">Operation</th>			
		  </tr>
		  </thead>
		  <tbody>
			<?php
			//echo mysql_num_rows($results);
			if(mysql_num_rows($results)>0){
				while ($checkedornot = mysql_fetch_assoc($results))
				{	
				$project_detail=mysql_fetch_assoc($con->recordselect("select fundingStatus,fundingGoal,rewardedAmount,commission_paid_id from projectbasics where projectId='".$checkedornot['projectId']."'"));
				
				$sqlQuery1 = "select sum(amount) as total,sum(commission) as total_commission,status from paypaltransaction where projectId='".$checkedornot['projectId']."' group by status";
				
				//$results = $con->select($sqlQuery,$page,$perpage,15,2,0);
				$results1 = $con->recordselect($sqlQuery1);	
				if(mysql_num_rows($results1)>0)
				{
					$final_array=array();
					$paymeny_label='';
					while($row1=mysql_fetch_assoc($results1))
					{
						
						$final_array[$row1['status']]['amount']=$row1['total'];
						$final_array[$row1['status']]['commission']=$row1['total_commission'];
						$paymeny_label.="<b>Total ".(($row1['status']=='REFUNDED')?"REFUNDED":"FUNDED")." Amount</b>:$".$row1['total']."<br/>";
						$commission_t=$row1['total_commission'];
						if($project_detail['commission_paid_id']>0)
						{
							$sqlQuery1 = mysql_fetch_assoc($con->recordselect("select commission from commision_transaction where paypalId='".$project_detail['commission_paid_id']."'"));
							$commission_t=$sqlQuery1['commission'];
						}
						
						$paymeny_label.="<b>Total ".(($row1['status']=='REFUNDED')?"REFUNDED":"FUNDED")." Commission</b>:$".$commission_t;
						$paymeny_label.="<hr/>";
						
					}
				}
				else
				{
					$paymeny_label="No Payments";
				}
				$fundingStatus='r';
				if($project_detail['fundingStatus']!='')
				{
					$fundingStatus=$project_detail['fundingStatus'];
				}
				$status_arr['y']['color']='#007e40';
				$status_arr['y']['text']='Successful';
				$status_arr['n']['color']='#ff3232';
				$status_arr['n']['text']='Unsuccessful';
				$status_arr['r']['color']='#FF3D0D';
				$status_arr['r']['text']='Running';
			?>
		  <tr>
		  <?php		
			$sel_project_all=mysql_fetch_array($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId = '".$checkedornot['projectId']."'"));
			$project_category=mysql_fetch_array($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_project_all['projectCategory']."'"));
		 	$sel_project_creator=mysql_fetch_array($con->recordselect("SELECT * FROM `users` as us,`projects` as pr WHERE us.userId=pr.userId AND pr.projectId = '".$checkedornot['projectId']."'"));
			
		  ?>			
			<td ><?php echo unsanitize_string(ucfirst($sel_project_all['projectTitle'])); ?></td>
			<td ><?php echo $project_category['categoryName']; ?></td>
            <td ><?php echo $sel_project_creator['name']; ?></td>
            <td ><?php print ( "$".$project_detail['fundingGoal'])?></td>
			<td ><?php print ( "$".$project_detail['rewardedAmount'])?></td>
            <td align="center"><span style="padding:2px;background-color:<?php print $status_arr[$fundingStatus]['color'];?>;color:#fff;"><?php print $status_arr[$fundingStatus]['text'];?></span></td>
            <td ><?php echo $paymeny_label; ?></td>
			<td ><?php echo $sel_project_all['projectLocation']; ?></td>
			<td class="icon">
				<ul>
					<!--<li><a href="#" title="Send Message"><img src="<?php //echo SITE_ADM_IMG; ?>message.png" border="0" alt="Send Message" /></a></li>-->					
					<!--<li><a href="#" title="Block"><img src="<?php //echo SITE_ADM_IMG; ?>block.png" border="0" alt="Block" /></a></li>-->
					<li><a href="project_payment_details.php?id=<?php echo $sel_project_all['projectId']; ?>" title="View Payment Details"><img src="<?php echo SITE_ADM_IMG;?>view.png" height="16" width="16" border="0" alt="View" /></a></li>
				</ul>
			</td>
		  </tr>
          <?php } ?>
           <tr>
		
			
            <?php 
			}	else{ echo '<tbody><tr><td colspan="11" align="center">'.RNF.'</td></tr></tbody>';	}
		?>
        </tr>
		
			
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
		<script defer="defer">
            $(document).ready(function() 
            { 
                $("#insured_list").tablesorter({widthFixed: true, widgets: ['zebra'],headers: {  8: { sorter: false } }})
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