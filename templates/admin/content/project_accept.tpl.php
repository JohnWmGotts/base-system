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
function displayNote(projectId,projectEnd)
{
	if(projectEnd=='yes') {
		var endDays = $("#inp"+projectId).val();
		 $("#chk"+projectId).attr("checked", false);
		
		if(endDays==''){
			alert('Please add number of days for project ending');
			
		}
		else if(endDays >60){
			alert('Please add number of days for project ending upto 60days');
			
		}
		else {
		window.location = "project_accept_ajax.php?projectId="+projectId+"&endDays="+endDays+"&page=<?php echo $_GET['page']; ?>";
		}
	}
	else {
	window.location = "project_accept_ajax.php?projectId="+projectId+"&page=<?php echo $_GET['page']; ?>";
	}
}
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
	
  function playVideo(div_id,video_url) {
	var pic_width = $('#'+div_id).width();
	var pic_height = $('#'+div_id).height();
	// replace current image displayed in the div_id area with an embedded youtube video for given url - jwg
	document.getElementById(div_id).innerHTML = '<iframe src="'+ video_url +'" width="' + pic_width + '" height="' + pic_height + '" frameborder="0" allowfullscreen></iframe>';
  }	
</script>
<div id="dialog" title="Basic dialog">
</div>

<?php if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')) {?>
<script language="javascript">
$(document).ready(function() {
$("#f1").validate({
		rules: {
            project_title: { required: true,minlength: 4,maxlength: 25 },
			short_blurb: { required: true,minlength: 4,maxlength: 50 },
			project_location: { required: true },
			project_description: { required: true,minlength: 4,maxlength: 250 }
		},
		messages: {
            project_title: {
				required: "<?php echo "<br>Please Enter Project Title";?>",
				minlength: "<?php echo "<br>Project Title should be atleast 4 characters long";?>",
				maxlength: "<?php echo "<br>Project Title should not be more than 25 characters long";?>"
			},
			short_blurb: {
				required: "<?php echo "<br>Please Enter Short Blurb";?>",
				minlength: "<?php echo "<br>Short Blurb should be atleast 4 characters long";?>",
				maxlength: "<?php echo "<br>Short Blurb should not be more than 25 characters long";?>"
			},
			project_location: {
				required: "<?php echo "<br>Please Enter Location";?>"
			},
			project_description: {
				required: "<?php echo "<br>Please Enter Project Description";?>",
				minlength: "<?php echo "<br>Project Description should be atleast 4 characters long";?>",
				maxlength: "<?php echo "<br>Project Description should not be more than 25 characters long";?>"
			}
		}
		});
});	
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg"><?php echo ucfirst($_GET['action']);?> Admin</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">		
		<form action="project_accept.php?id=<?php echo $_GET['id']; ?>&amp;page=<?php echo $_GET['page']; ?>&amp;action=<?php echo $_GET['action'];?>" method="post" name="f1" id="f1">
		<input type="hidden" name="action" id="action" value="<?php echo $_GET['action'];?>" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="250"></td>
			<td width="10">&nbsp;</td>
			<td>
			<div class="fieldset-errors" style="color:red;">		
						<?php if($error!=""){ ?>						
						<?php print $error; ?>
						<?php } ?>
						<?php if($_GET["msg1"]=='REGSUS'){ echo constant($_GET['msg1']);  } ?>
                        
                        
			</div>
			</td>
		</tr>
		  <tr>
			<td width="250" align="right"><strong>Status <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td class="froms-selectbox-bg">
				<select name="project_status" class="froms-selectbox">
					<option value="0" <?php if($sel_editproject_pro['accepted']==0) { echo 'selected'; } ?> >Pending</option>
					<option value="1" <?php if($sel_editproject_pro['accepted']==1) { echo 'selected'; } ?> >Accepted</option>				
				</select>
			</td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"><input name="admin_id" id="admin_id" type="hidden"  value="<?php echo $_GET['id']; ?>" /></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Project Title <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="project_title" id="project_title" type="text" class="logintextbox-bg" value="<?php echo unsanitize_string(ucfirst($sel_editproject['projectTitle'])); ?>" onblur="return onchangeemail(this.value);" /><br><label id="admin_valid" style="text-transform: none; color: red;"></label></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Project Category <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td class="froms-selectbox-bg">
				<select class="froms-selectbox" name="project_category" id="project_category">
				<?php 
					$sel_project_category=$con->recordselect("SELECT * FROM categories WHERE isActive = 1");
					while($project_cat=mysql_fetch_assoc($sel_project_category))
					{
				?>
				  <option value="<?php echo $project_cat['categoryId']; ?>" <?php if($project_cat['categoryId']==$sel_editproject['projectCategory']) echo 'selected'; ?> ><?php echo $project_cat['categoryName']; ?></option>
				<?php } ?>
				</select>
			</td>
		  </tr> 
		  <!--<tr>
			<td width="250" align="right"><strong>Project Category <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="project_category" id="project_category" type="text" class="logintextbox-bg" value="<?php //echo $sel_editproject_cat['categoryName']; ?>" /></td>
		  </tr>-->
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Short Blurb <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="short_blurb" id="short_blurb" type="text" class="logintextbox-bg" value="<?php echo $sel_editproject['shortBlurb']; ?>" /></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Project Location <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="project_location" id="project_location" type="text" class="logintextbox-bg" value="<?php echo $sel_editproject['projectLocation']; ?>" onblur="return onchangeemail(this.value);" /><br><label id="admin_valid" style="text-transform: none; color: red;"></label></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Project Video <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="project_video" id="project_video" type="text" class="logintextbox-bg" value="<?php echo $sel_editproject_ps['projectVideo']; ?>" onblur="return onchangeemail(this.value);" /><br><label id="admin_valid" style="text-transform: none; color: red;"></label></td>
		  </tr>
		  <?php
						if (isset($sel_editproject_ps['projectVideo']) && isset($sel_editproject_ps['projectVideoImage']) && ($sel_editproject_ps['projectVideoImage']!='')) {
							$videourl = $sel_editproject_ps['projectVideo'];
							if (preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/watch\?v=((?:[a-zA-Z0-9._]|-)+)(?:\&|$)/i',$videourl,$match) ||				
								preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/(?:user\/)?(?:[a-z0-9\_\#\/]|-)*\/[a-z0-9]*\/[a-z0-9]*\/((?:[a-z0-9._]|-)+)(?:[\&\?\w;=\+_\#\%]|-)*/i',$videourl,$match) ||
								preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/embed\/((?:[a-z0-9._]|-)+)(?:\?|$)/i',$videourl,$match)) {	  	
								$videoId = $match[1];
								$imageurl = 'https://img.youtube.com/vi/'.$videoId.'/0.jpg';
								//$videourl = 'https://www.youtube.com/embed/'.$videoId; 
								$videourl = 'https://www.youtube-nocookie.com/embed/'.$videoId.'?hd=1&autohide=1&autoplay=1&fs=1&rel=0';
						?>	
				  <tr>
					<td colspan="3">
						Click image to watch video:
						<div id="videoArea">
							<a href="javascript:playVideo('videoArea','<?php echo $videourl; ?>')">
								<img src="<?php echo $imageurl; ?>" title="<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectTitle'])); ?>" alt="<?php echo unsanitize_string(ucfirst($sel_pro_basic['projectTitle'])); ?>" /> 
							</a>
						</div>
						<?php
							} else {
								echo "Click link to watch video: <a target='_blank' href='$videourl'>$videourl</a><br/>";
							}
							?>
					</td>
				  </tr>							
						<?php
						}
						?>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Project Description <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td><input name="project_description" id="project_description" type="text" class="logintextbox-bg" value="<?php echo $sel_editproject_ps['projectDescription']; ?>" onblur="return onchangeemail(this.value);" /><br><label id="admin_valid" style="text-transform: none; color: red;"></label></td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>		  
		  <!--<tr>
			<td width="250" align="right"><strong>Status <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
				<select name="status">
					<option value="0" <?php //if($sel_user_edit_qry['status']==0) { echo 'selected'; } ?> >Activate</option>
					<option value="1" <?php //if($sel_user_edit_qry['status']==1) { echo 'selected'; } ?> >Deactivate</option>
					<option value="2" <?php //if($sel_user_edit_qry['status']==2) { echo 'selected'; } ?> >Blocked</option>
				</select>
			</td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>	-->	
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php $btn_img=($_GET['action']=='add')?'add-btn.gif':'bt_change.gif'; $btn_tit=($_GET['action']=='add')?'Add':'Change'; ?>
				<input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>project_accept.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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
			<td>Project Accept</td>
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
        <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="DELSUS" || $_GET["msg"]=="ACCEPTREC" || $_GET["msg"]=="SUCBLO" || $_GET["msg"]=="SUCACT")){ ?>
			<tr align="center">
				
                <?php if($_GET["msg"]=="DELSUS") { ?>
				<td align="center" class="success"><?php echo DEL; ?></td>
				<?php } else if($_GET["msg"]=="ACCEPTREC") { ?>
                <td align="center" class="success"><?php echo "Project Accepted  Successfully"; ?></td>
                <?php } else if($_GET["msg"]=="SUCBLO") { ?>
                <td align="center" class="success"><?php echo "Project Inactivated  Successfully"; ?></td>
                <?php } else if($_GET["msg"]=="SUCACT") { ?>
                <td align="center" class="success"><?php echo "Project Activated  Successfully"; ?></td>
                <?php } ?>
                
            </tr>
			 
          <?php } ?>
              <tr>
                    <div align="right"><a href="<?php echo SITE_URL;?>admin/export/export.php" title="Export Projects">Export Projects WITH XLS</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo SITE_URL;?>admin/csv.php" title="Export Projects">Export Projects WITH CSV</a> 
                    </div>
                    <div align="right"> 
                    </div>
    </tr>

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
			<th width="13%" align="center" class="header1">Accepted?</th> 
			<th width="27%" align="center" class="header1" id="links">Project Title</th>
			<th width="12%" align="center" class="header1">Project Category</th>
			<th width="31%" align="center" class="header1">Short Blurb</th>
			<th width="12%" align="center" class="header1">Project Location</th>
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
			$project_category=mysql_fetch_array($con->recordselect("SELECT * FROM categories WHERE categoryId ='".$sel_project_all['projectCategory']."'"));
		  ?>
			<td ><center><?php if($checkedornot['accepted']==1) { echo "Accepted"; } else { 
			
			
			 ?><div class="checkboxcls">
			 
			 <?php $chktime_cur=time();
			  		if($checkedornot['projectEnd'] < $chktime_cur) { ?>
                    <input type="checkbox" id="chk<?php echo $sel_project_all['projectId']; ?>" onClick="displayNote('<?php echo $sel_project_all["projectId"]; ?>','yes')" class="checkBoxEnd" /> 
						<div class="textEnd" style="padding-top:15px;">Enter Days For Project End</div>
                        <div class="textboxcls">
                       
                     <input type="textbox" id="inp<?php echo $sel_project_all['projectId']; ?>" style="width:30px;" class="endDays" /></div>	
						
				<?php	}
				else { ?>
				<input type="checkbox" id="<?php echo $sel_project_all['projectId']; ?>" onClick="displayNote('<?php echo $sel_project_all["projectId"]; ?>','no')" /> 
			<?php 	}
			  ?>
			 
			 <?php } ?>
             
             
             
             </center></td>
			<td ><div class="protit"><a title="Click here to view project detail" href="javascript:void(0);" onclick="javascript:openPopup('<?php echo $sel_project_all["projectId"]; ?>');"><?php echo unsanitize_string(ucfirst($sel_project_all['projectTitle'])); ?></a></div></td>
			<td ><?php echo $project_category['categoryName']; ?></td>
			<td  ><div class="shrtblrb"><?php echo $sel_project_all['shortBlurb']; ?></div></td>
			<td ><div ><?php echo $sel_project_all['projectLocation']; ?></div></td><!--class="proloc"-->
			<td class="icon" width="7%">
				<ul>
					<?php if($checkedornot['accepted']==1) { ?>
                    	<li><a href="<?php echo SITE_ADM;?>project_accept.php?action=inactive&amp;id=<?php echo $sel_project_all['projectId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to Inactivate this project ?')" title="Click here to Inactivate"><img src="<?php echo SITE_ADM_IMG;?>active.gif" border="0" alt="Inactivate" /></a></li>
                    <?php } else { ?>
                    	<li><a href="<?php echo SITE_ADM;?>project_accept.php?action=active&amp;id=<?php echo $sel_project_all['projectId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to Activate this project?')" title="Click here to Activate"><img src="<?php echo SITE_ADM_IMG;?>block.png" border="0" alt="Activate" /></a></li>
                    <?php } ?>
                    <?php if($_SESSION["admin_role"] == -1){ ?>
                    	<li><a href="#" onclick="return confirm('You dont have privileges to do this action.')"  title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
                    <?php }else{ ?>
                    	<li><a href="project_del.php?id=<?php echo $sel_project_all['projectId']; ?>" onclick="return confirm('Are you sure you want to Delete this Project?')"  title="Delete"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
                    <?php } ?>
                    	<?php
						/*echo $checkedornot['accepted'];
						echo $checkedornot['comming_soon'];*/
						 if($checkedornot['comming_soon']==0 && $checkedornot['accepted']==0) { 
						 ?>
                    	<li><a href="<?php echo SITE_ADM;?>project_accept.php?action=addComing&amp;id=<?php echo $sel_project_all['projectId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to add this project to upcoming projects?')" title="Click here for adding into upcoming projects">Add To Upcoming Projects</a></li>
                    <?php } else if($checkedornot['comming_soon']==1 && $checkedornot['accepted']==0) { ?>
                    	<li><a href="<?php echo SITE_ADM;?>project_accept.php?action=removeComing&amp;id=<?php echo $sel_project_all['projectId']; ?>&amp;page=<?php echo $_GET['page']; ?>"onclick="return confirm('Are you sure you want to remove this project from upcoming projects?')" title="Click here for removing from upcoming projects">Remove From Upcoming Projects</a></li>
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
<?php } ?>