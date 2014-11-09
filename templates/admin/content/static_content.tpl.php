<script src="<?php echo SITE_JAVA; ?>jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<?php if(isset($_REQUEST['action'])) {?>
<?php if($action!='view') { ?>
<script type="text/javascript" language="javascript">
	var path = '<?php echo  APPLICATION_PATH; ?>/includes';
</script>
<script type="text/javascript" src="<?php echo SITE_CKE;?>ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	$("#frmCms").validate({
		rules: {
			title: { required:true},
			meta_author: { required:true},
			meta_keyword: { required:true},
			meta_desc: { required:true},
		},
		message: {
			title: { required:"<?php echo ER_PAGETIT;?>"},
			meta_author: { required:'<?php echo ER_METAAU;?>'},
			meta_keyword: { required:'<?php echo ER_METAKEY;?>'},
			meta_desc: { required:'<?php echo ER_METADESC;?>'},
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.insertAfter( element.next() );
			else
				error.insertAfter( element );
		}
	});
	
});
</script>
<?php } ?>
<?php $req_span=($action!='view')?'<span class="redcolor">*</span>':''; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg"><?php echo ucfirst($_GET['action']).' '.ucfirst(stripslashes($get_content_detail['page'])) ;?>  Content</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">
    <?php if($action!='view') { ?>
		<form action="static_content.php" method="post" name="frmCms" id="frmCms">
		<input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
		<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
        <input name="status" id="statusa" type="hidden" value="1"/>
    <?php } ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php if(isset($error) && $error!=""){ ?>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td align="left" class="error_msg"><?php print $error; ?></td>
			</tr>
			  <tr>
				<td height="10" colspan="3"></td>
			  </tr>
          <?php } ?>
		  <?php if(isset($_GET["msg"]) && $_GET["msg"]!=""){ ?>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td align="left" class="success"><?php echo constant($_GET['msg']); ?></td>
			</tr>
			  <tr>
				<td height="10" colspan="3"></td>
			  </tr>
          <?php } ?>
		           
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Page Name <?php echo $req_span;?> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            <?php if($action=='view') { 
					echo stripslashes($get_content_detail['page']);
				  }  else {
			?>
            	<input name="page" id="page" type="text" class="logintextbox-bg" value="<?php echo stripslashes($get_content_detail['page']);?>" readonly="true" disabled="disabled" />
           <?php } ?>     
           </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Page Title <?php echo $req_span;?> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            <?php if($action=='view') { 
					echo stripslashes($get_content_detail['title']);
				  }  else {
			?>
            	<input name="title" id="title" type="text" class="logintextbox-bg" value="<?php echo stripslashes($get_content_detail['title']); ?>" />
            <?php } ?>    
            </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Meta Author <?php echo $req_span;?> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            <?php if($action=='view') { 
					echo stripslashes($get_content_detail['meta_author']);
				  }  else {
			?>
            	<input name="meta_author" id="meta_author" type="text" class="logintextbox-bg" value="<?php echo stripslashes($get_content_detail['meta_author']);?>" />
             <?php } ?>   
             </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Meta Keyword <?php echo $req_span;?> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            <?php if($action=='view') { 
					echo stripslashes($get_content_detail['meta_keyword']);
				  }  else {
			?>
            	<input name="meta_keyword" id="meta_keyword" type="text" class="logintextbox-bg" value="<?php echo stripslashes($get_content_detail['meta_keyword']);?>" />
            <?php } ?>    
            </td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Meta Description <?php echo $req_span;?> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            <?php if($action=='view') { 
					echo stripslashes($get_content_detail['meta_desc']);
				  }  else {
			?>
            	<textarea name="meta_desc" id="meta_desc" class="textarea-bg"><?php echo stripslashes($get_content_detail['meta_desc']);?></textarea>
            <?php } ?>    
            </td>
		  </tr>
		  <?php if(strtolower($get_content_detail['module'])=='cms') { ?>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Description <?php //echo $req_span;?> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
            <?php if($action=='view') { 
					echo stripslashes($get_content_detail['description']);
				  }  else {
			?>            	
				<textarea name="description" id="description" class="ck_req"><?php echo stripslashes($get_content_detail['description']);?></textarea>
				<script type="text/javascript">
				//<![CDATA[
				CKEDITOR.replace( 'description',
				{
					removePlugins: 'elementspath' ,
					skin : 'kama',
					attributes : { 'class' : 'ck_req' }/*,
					toolbar :
					[
						[ 'Bold', 'Underline', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Cut', 'Copy', 'Paste', '-', 'SpellChecker']									
					]*/
				});			
			  //]]>
			  </script>
			  </script>
			  <label id="er_desc" class="error" style="display:none;"><?php echo ER_PAGEDESC;?></label>
              <?php } ?>
			</td>
		  </tr>
		  <?php } ?>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>		  
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
		     <?php if($action=='view') { ?>
                <a href="<?php echo SITE_ADM;?>static_content.php" title="Back">Back</a>
             <?php } else { ?>
				<?php $btn_img=($_GET['action']=='add')?'add-btn.gif':'bt_change.gif'; $btn_tit=($_GET['action']=='add')?'Add':'Change'; ?>
				<input name="" alt="<?php echo $btn_tit; ?>" title="<?php echo $btn_tit; ?>" id="btnCms" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>static_content.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
            <?php } ?>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>Manage Contents</td>
			<td align="right">&nbsp;</td>
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
			<td align="right">&nbsp;</td>
		</tr>
        <?php if(isset($_GET["msg"]) && $_GET["msg"]!=""){ ?>
			<tr>
				<td align="center" class="success"><?php echo ucfirst(strtolower(constant($_GET['msg']))); ?></td>
			</tr>
        <?php } ?>
		<tr>
			<td height="10"></td>
		  </tr>
		<tr>
		<td>
		<table width="100%" border="1"  cellspacing="0" cellpadding="5" class="tabeleborder" id="insured_list">
        <thead>
		  <tr class="trcolor">
			<!--<th width="9%" align="center" class="header1">Id</th>-->
			<th width="9%" align="center" class="">Id</th>
            <th width="84%" align="center" class="header1">Title</th>
			<th width="7%" align="center">Operation</th>
		  </tr>
          </thead>
          <tbody>
		 <?php if(mysql_num_rows($arr_rs)>0) {
			 $i=1;
			while($row=mysql_fetch_array($arr_rs)) { ?>
              <tr>
                <td >
                	<!--<a href="<?php //echo SITE_ADM;?>static_content.php?action=view&id=<?php //echo $row['id'];?>" title="View" class="link">-->
						<?php // echo $row['id']; ?>
                        <?php  echo $i; ?>
                        <?php $i++; ?>
                    <!--</a>-->
                </td>
                
                <td ><?php echo stripslashes($row['title']);?></td>
                
                <td class="icon">
                    <ul>
                        <li><a href="<?php echo SITE_ADM;?>static_content.php?action=edit&id=<?php echo $row['id'];?>" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a>&nbsp;&nbsp;<a href="<?php echo SITE_ADM;?>static_content.php?action=view&id=<?php echo $row['id'];?>" title="View" class="link"><img src="<?php echo SITE_ADM_IMG;?>view.png" border="0" alt="View" height="16" width="16" /></a></li>
                        <!--<li><a href="<?php //echo SITE_ADM;?>content.php?action=delete&id=<?php //echo $row['id'];?>" title="Delete" onClick="return delete_record();"><img src="<?php //echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>-->
                    </ul>
                </td>
              </tr>
    <?php }   ?>
          </tbody>
          <tbody>
	<tr id="pager" class="pager" >
		<td colspan="10"><!--<center><?php //echo $pagination; ?></center>-->
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
		  
		<?php } else {
			echo '<tr><td colspan="11" align="center">'.RNF.'</td></tr>';
		}
	?></tbody>
		</table>
		</td>
		</tr>
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
 <script type="text/javascript">
	$(document).ready(function() 
	{ 
		$("#insured_list")
		.tablesorter({widthFixed: true, widgets: ['zebra'],
			headers: {  2: {
			  sorter: false 
						},
						 0: {
			  sorter: false 
						}
				  }
				  
				  })
		.tablesorterPager({container: $("#pager")}); 
	} 
	); 
</script>
<?php } ?>