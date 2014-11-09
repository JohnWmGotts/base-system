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
<script language="JavaScript">  
function openPopup(proId)
{
	$.ajax({
		type: 'POST',
		url:'project_accept_ajax.php',
		dataType: 'html',
		data: { projId: proId},
		success: function(data) 
		{
			$( "#dialog" ).html(data);		
			$( "#dialog" ).dialog( "open" );
			return false;
		}
	});
}
$.fx.speeds._default = 1000;
	$(function() {		
		$( "#dialog" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "explode",
			title: "Project Description",
			width: 250
		});

		$( "#opener" ).click(function() {
			$( "#dialog" ).dialog( "open" );
			return false;
		});
	});
</script>
<div id="dialog" title="Basic dialog">
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>Manage Update Comments</td>
			<td align="right">
				<!--<select name="">
					<option>Test 01</option>
					<option>Test 02</option>
					<option>Test 03</option>
				</select>-->
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
        <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="DELSUS" || $_GET["msg"]=="ACCEPTREC" || $_GET["msg"]=="SUCBLO" || $_GET["msg"]=="SUCACT")){ ?>
			<tr align="center">
				
                <?php if($_GET["msg"]=="DELSUS") { ?>
				<td align="center" class="success"><?php echo DEL; ?></td>
				<?php } else if($_GET["msg"]=="ACCEPTREC") { ?>
                <td align="center" class="success"><?php echo "Project Accepted  Successfully"; ?></td>
                <?php } else if($_GET["msg"]=="SUCBLO") { ?>
                <td align="center" class="success"><?php echo "Comment Inactivated  Successfully"; ?></td>
                <?php } else if($_GET["msg"]=="SUCACT") { ?>
                <td align="center" class="success"><?php echo "Comment Activated  Successfully"; ?></td>
                <?php } ?>
                
            </tr>
			 
          <?php } ?>
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
		
			<th width="27%" align="center" class="header1" id="links">Project Title</th>
            <th width="12%" align="center" class="header1">Comment</th>
			<th width="12%" align="center" class="header1">Comment By</th>
			<th width="12%" align="center" class="header1">Comment Date</th>
			<th width="5%" align="center" >Operation</th>			
		  </tr>
		  </thead>
		  <tbody>
			<?php
			if(mysql_num_rows($results)>0){
				while ($checkedornot = mysql_fetch_assoc($results))
				{
					
			?>
		  <tr>
		  <?php		
			$sel_project_all=mysql_fetch_array($con->recordselect("SELECT * FROM `projectbasics` WHERE projectId = '".$checkedornot['projectId']."'"));
			
		  ?>
		
			<td ><div class="protit"><a title="Click here to view project detail" href="javascript:void(0);" onclick="javascript:openPopup('<?php echo $sel_project_all["projectId"]; ?>');"><?php echo unsanitize_string(ucfirst($sel_project_all['projectTitle'])); ?></a></div></td>
            	<td  ><div class="shrtblrb"><?php echo $checkedornot['updateComment']; ?></div></td>
			<td  ><div class="shrtblrb"><?php echo $checkedornot['name']; ?></div></td>
			<td ><div ><?php echo  date("m-d-Y H:i:s",$checkedornot['updateCommentTime']); ?></div></td><!--class="proloc"-->
			<td class="icon" width="7%">
				<ul>
					<?php if($checkedornot['updatecommentstatus']==1) { ?>
                    	<li><a href="<?php echo SITE_ADM;?>project_updatecomment.php?action=inactive&amp;id=<?php echo $checkedornot['updatecommentId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to Inactivate this comment ?')" title="Click here to Inactivate"><img src="<?php echo SITE_ADM_IMG;?>active.gif" border="0" alt="Inactivate" /></a></li>
                    <?php } else { ?>
                    	<li><a href="<?php echo SITE_ADM;?>project_updatecomment.php?action=active&amp;id=<?php echo $checkedornot['updatecommentId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to Activate this comment?')" title="Click here to Activate"><img src="<?php echo SITE_ADM_IMG;?>block.png" border="0" alt="Activate" /></a></li>
                    <?php } ?>
                    <?php if($_SESSION["admin_role"] == -1){ ?>
                    	<li><a href="#" onclick="return confirm('You dont have privileges to do this action.')"  title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
                    <?php }else{ ?>
                    	<li><a href="projectcommentupdate_del.php?id=<?php echo $checkedornot['updatecommentId']; ?>&&type='projectupdatecomment'" onclick="return confirm('Are you sure you want to Delete this Comment?')"  title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
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
				</form>
			
		</td>
		</tr>
        </tbody>
      
		</table>

		</td>		
		</table>
<script type="text/javascript">
	$(document).ready(function() 
	{ 
	
	// add parser through the tablesorter addParser method 
	$.tablesorter.addParser({
		// set a unique id 
		id: 'links',
		is: function(s)
		{
			// return false so this parser is not auto detected 
			return false;
		},
		format: function(s)
		{
			// format your data for normalization 
			return s.replace(new RegExp(/<.*?>/),"");
		},
		// set type, either numeric or text
		type: 'text'
	}); 

	$("#insured_list")
		.tablesorter({widthFixed: true, widgets: ['zebra'],
			headers: {  
				5: {
					sorter: false 
				},
				1: {
					sorter: 'links'
				}
			}
		})
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
