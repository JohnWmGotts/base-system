<script type="text/javascript" src="<?php echo SITE_JAVA; ?>ajax.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<script language="JavaScript">   
function displayNote(projectId)
	{
		url = document.location.href;
		xend = url.lastIndexOf("/") + 1;
		var base_url = url.substring(0, xend);
		url="staffpicks_ajax.php?projectId="+projectId+"&adminid=<?php echo $_SESSION['admin_id']; ?>";			
		if (url.substring(0, 4) != 'http')
		{
			url = base_url + url;
		}
		var strSubmit="projectId="+projectId;		
		var strURL = url;		
		var strResultFunc = "adminavable";
		xmlhttpPost(strURL, strSubmit, strResultFunc)
		return true;	
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>Staff Project list</td>
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
		<td>
		<table id="insured_list" width="100%" border="1" bordercolor="#c7c7c7" cellspacing="0" cellpadding="5" class="tabeleborder">
		<thead> 
		<tr class="trcolor">
			<th width="5%" align="center" >Mark</th>
			
			<th width="21%" align="center" class="header1">Project Title</th>
			<th width="24%" align="center" class="header1">Project Category</th>
			<th width="36%" align="center" class="header1">Short Blurb</th>
			<th width="14%" align="center" class="header1">Project Location</th>
		  </tr>
		  </thead>
		  <tbody>
			<?php	
			if(mysql_num_rows($result)>0){	
				while ($sel_user_all12 = mysql_fetch_assoc($result))
				{
					/*echo '<pre>';
					print_r($sel_user_all12);
					echo '</pre>';*/
					$sel_user_all=mysql_fetch_array($con->recordselect("SELECT * FROM projectbasics WHERE projectId ='".$sel_user_all12['projectId']."'"));
					$project_category=mysql_fetch_array($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_user_all['projectCategory']."'"));
			?>
		  <tr >
		  <?php
			$checkedornot=mysql_fetch_array($con->recordselect("SELECT * FROM `staffpicks` WHERE projectId = '".$sel_user_all['projectId']."'"));
			//$checkedornot=mysql_fetch_array($con->recordselect("SELECT status FROM `staffpicks` WHERE projectId = '".$sel_user_all['projectId']."' and adminId='".$_SESSION['admin_id']."'"));
		  ?>
          	<td width="5%"><input type="checkbox" <?php
			if($_SESSION['admin_role'] == 0){
			 	if($checkedornot['status']== 1) {
					echo "checked=checked";
				}
			}else{
				if($checkedornot['adminId'] !=$_SESSION['admin_id'] && $checkedornot['status']== 1){				
					echo "checked=checked"." ";
					echo "disabled='disabled'";
				}elseif($checkedornot['adminId'] =$_SESSION['admin_id'] && $checkedornot['status']== 1){
					echo "checked=checked"." ";
				}
			} ?> id="<?php echo $sel_user_all['projectId']; ?>"  onClick="displayNote('<?php echo $sel_user_all["projectId"]; ?>')" /></td>
			<?php /*?><td width="5%"><input type="checkbox" <?php if($sel_user_all12['status']==1) { echo "checked=checked"; } else { } ?> id="<?php echo $sel_user_all['projectId']; ?>" onClick="displayNote('<?php echo $sel_user_all["projectId"]; ?>')" /></td><?php */?>
			<td width="21%"><div class="shrtblrb"><?php echo unsanitize_string(ucfirst($sel_user_all['projectTitle'])); ?></div></td>
			<td width="24%"><?php echo $project_category['categoryName']; ?></td>
			<td width="36%"><div class="shrtblrb"><?php echo $sel_user_all['shortBlurb']; ?></div></td>
			<td width="14%"><div class="shrtblrb"><?php echo $sel_user_all['projectLocation']; ?></div></td>			
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
				</form>
			
		</td>
		</tr>
        </tbody>
			<script defer="defer">
				$(document).ready(function() 
				{ 
					$("#insured_list")
					.tablesorter({widthFixed: true, widgets: ['zebra'],
					 headers: {  0: {
						  sorter: false 
						  			}
							  }})
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