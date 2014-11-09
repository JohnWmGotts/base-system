<!--<link rel="stylesheet" href="<?php //echo SITE_CSS; ?>redactor.css" />
<script src="<?php //echo SITE_JAVA; ?>redactor.js"></script>-->

<script type="text/javascript" src="<?php echo $base_url;?>includes/ckeditor/ckeditor.js"></script>
<!--<script type="text/javascript">
$(document).ready(
	function()
	{
		$('#redactor_content').redactor({ 	
			imageUpload: application_path+'includes/scripts/image_upload.php',
			fileUpload: application_path+'includes/scripts/file_upload.php',
			imageGetJson: application_path+'includes/json/data.json'
		});
	}
);
</script>-->
<script type="text/javascript">
$(document).ready(function() {
	$("#frm_projectupdate").validate({
		rules: {
			updateTitle: { required: true }
		},
		messages: {
			updateTitle: {
				required: 'Please Enter Title Of Update'
			}
		}
	});
});
</script>

<section id="container">
   <div id="inbox" class="head_content temp">
   <?php if($_GET['type']!='edit') { ?>
       <h3>Make update on <?php echo unsanitize_string($sel_project_detail['projectTitle']); ?></h3>
   <?php } else {
	$sel_project_id=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectupdate WHERE projectupdateId='".$_GET['projectId']."'"));
		$sel_project_name=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectbasics WHERE projectId='".$sel_project_id['projectId']."'"));  ?> 
          <h3>Edit update on <?php echo unsanitize_string($sel_project_name['projectTitle']); ?></h3>
   <?php }?>
   </div>
   <div class="wrapper">
        <div class="tabs_content_bg">
            <div class="tab_content">
            <?php if($_GET['type']='edit'){
				$sel_projectupdateinfo=mysql_fetch_assoc($con->recordselect("SELECT * FROM projectupdate WHERE projectupdateId='".$_GET['projectId']."'"));
				
				} ?>
            <form action="<?php echo SITE_URL; ?>projectupdate/<?php echo $_GET['projectId'];?>/" method="post" enctype="multipart/form-data" id="frm_projectupdate" name="frm_projectupdate">
                <div class="updatebox-erroe">
					<?php if(isset($error) && ($error!="")){ ?>
                    <?php print $error; ?>
                    <?php } ?>                       
                </div>
                <div class="updatebox">
                    <div class="updatebox_left">Title Of Update</div>
                    <div class="updatebox_right">
                        <input type="text" name="updateTitle"  size="45" value="<?php if($_GET["type"]=='edit'){ echo $sel_projectupdateinfo['updateTitle'];} else { echo '';} ?>"/>
                    	 <input type="hidden" name="operation" value="<?php if($_GET["type"]=='edit'){ echo $sel_projectupdateinfo['updateTitle'];} else { echo '';} ?>"/>
                    </div>
                </div>
                <div class="updatebox">
                    <textarea id="redactor_content" name="content" class="height400"><?php if($_GET["type"]=='edit'){ echo $sel_projectupdateinfo['updateDescription'];} else { echo '';} ?></textarea>
                   
                   
                </div>
                <div class="updatebox_btn">
                	<input type="submit" name="submitUpdate" value="Submit Update" />
                </div>
                <div class="clear"></div>
                </form>
            </div>
        </div>
        <div class="space20"></div>
   </div>
</section>
<script type="text/javascript">
//<![CDATA[
	CKEDITOR.replace( 'redactor_content',
		{
		toolbar :
			[
				{ name: 'clipboard', items : ['Undo','Redo' ] },
				{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },
				{ name: 'insert', items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar','Iframe' ] },
						'/',
				{ name: 'styles', items : [ 'Styles','Format' ] },
				{ name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
				{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
				{ name: 'tools', items : [ 'Maximize','-','About' ] }
			]
		});	
//]]>
</script>