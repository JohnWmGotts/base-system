<?php
function userIdtoUsername($userIdVal)
{
	$qr = mysql_fetch_assoc(mysql_query("SELECT name FROM users WHERE userId=".$userIdVal));
	return $qr['name'];
}
?>
<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">Project Payment Details</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="right">
            	<a href="<?php echo SITE_ADM;?>project_payment.php" title="Project Payment" class="link"><strong>Back</strong></a>
            </td>
        </tr>
		<tr>
			<td height="10"></td>
		</tr>
		<tr>
		<tr>			
        	<td colspan="11">			
        </td>
		</tr>
		<td>
		<table id="insured_list" width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder">
		<thead> 
		<tr class="trcolor">						
			<td width="20%" align="center">Project Title</td>			
			<td width="10%" align="center">Project Category</td>			
			<td width="8%" align="center">Amount</td>	
            <td width="8%" align="center">Commission</td>			
			<td width="10%" align="center">Transaction Id</td>			
            <td width="10%" align="center">Correlation Id</td>			
            <td width="12%" align="center">User Name</td>	
            <td width="8%" align="center">Status</td>			
            <td width="18%" align="center">Date</td>							
		  </tr>
		  </thead>
		  <tbody>
			<?php
			if($query[0]>0)
			{
				while ($checkedornot = mysql_fetch_assoc($query[1]))
				{					
				
			?>
		  <tr>
		  <?php					
			$project_category=mysql_fetch_array($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$checkedornot['projectCategory']."'"));
		  ?>			
			<td><?php echo unsanitize_string(ucfirst($checkedornot['projectTitle'])); ?></td>
			<td><?php echo $project_category['categoryName']; ?></td>
			<td><?php echo '$'.$checkedornot['amount']; ?></td>
            <td><?php echo '$'.$checkedornot['commission']; ?></td>
			<td><?php echo $checkedornot['transactionId']; ?></td>
            <td><?php echo $checkedornot['correlationId']; ?></td>
            <td><?php echo userIdtoUsername($checkedornot['userId']); ?></td>
            <td><?php echo $checkedornot['status']; ?></td>
            <td><?php echo date ("m-d-Y H:i:s",$checkedornot['dateTime']); ?></td>			
		  </tr>
			<?php } 
			}else
			{?>
				<tr><td colspan="10" align="center"><h2><strong>No record found.</strong></h2></td></tr>
			<?php }?>
		</tbody>
        <?php
		if($query[0]>$perpage)
					  {
						  $extraPara = "&id=".$_GET['id'];
					  ?>
		 <tr>
        
        <td bgcolor="#FFFFFF" height="25" align="center" valign="middle" colspan="15"><?php $con->onlyPagging($page,$perpage,10,2,0,1,$extraPara); ?></td>
<div id="pager" class="pager" style="display:none;">
				<form>					
					<select class="pagesize">
						<option value="<?php echo $limit; ?>">LIMIT</option>									
					</select>
				</form>
			</div>
			<script defer="defer">
				$(document).ready(function() 
				{ 
					$("#insured_list")
					.tablesorter({widthFixed: true, widgets: ['zebra']})
					.tablesorterPager({container: $("#pager")}); 
				} 
				); 
			</script>
      </tr>
      <?php } ?>
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