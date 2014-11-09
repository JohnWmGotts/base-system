<?php if(isset($_REQUEST['action'])) {?>
<script type="text/javascript">
$(document).ready(function() {
	$('#file_img').bind('change', function() {
	  itype='<?php echo str_replace('jpg','jpeg',IMGEXT);?>';
	  type_arr=(this.files[0].type).split('/');	  
	  if(itype.search(type_arr[1])<0) {
		$('#img_lbl').html('<?php echo ER_IMGTYPE;?>');
		return false;
	  } else {
	  	$('#img_lbl').html('');
	  }
	  // Image Size Validation
	  def_size=this.files[0].size;
	  size=parseInt(def_size)/1024;//alert(def_size+'=='+parseFloat(size));
	  if(parseFloat(size)>300) {
	  	$('#img_lbl').html('<?php echo ER_IMGSIZE;?>');
		return false;
	  } else {
	  	$('#img_lbl').html('');
	  }	  
	});	
	$("#frmImg").validate({
		rules: {
			file_img: {required:true}
		},
		message: {
			file_img: {required:'<?php echo ER_IMG;?>'}
		}
	});
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg"><?php echo ucfirst($_GET['action']);?> Image</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">
		<form action="image.php" method="post" name="frmImg" id="frmImg" enctype="multipart/form-data">
		<input type="hidden" name="action" id="action" value="<?php echo $_GET['action'];?>" />
		<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <?php if($error!=""){ ?>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td align="left" class="error_msg"><?php print $error; ?></td>
			</tr>
			  <tr>
				<td height="10" colspan="3"></td>
			  </tr>
          <?php } ?>
		  <tr>
			<td width="250" align="right"><strong>Image <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
				<input type="file" name="file_img" id="file_img" title="<?php echo ER_IMG;?>" />
				<label class="error" id="img_lbl"></label>
			</td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right"><strong>Status <span class="redcolor">*</span> :</strong></td>
			<td width="10">&nbsp;</td>
			<td>
				Active <input type="radio" name="status" id="status1" value="1" <?php echo ($status==1)?'checked="checked"':'';?> /> &nbsp; Deactive <input type="radio" name="status" id="status0" value="0" <?php echo ($status==0)?'checked="checked"':'';?> />
			</td>
		  </tr>
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="250" align="right">&nbsp;</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php $btn_img=($_GET['action']=='add')?'add-btn.gif':'bt_change.gif';?>
				<input name="" type="image" src="<?php echo SITE_ADM_IMG.$btn_img;?>" /> &nbsp; <a href="<?php echo SITE_ADM;?>image.php" title="Cancel"><img src="<?php echo SITE_ADM_IMG;?>cancel-btn.gif" alt="Cancel" /></a>
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
			<td>Manage Image</td>
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
			<td align="right"><a href="<?php echo SITE_ADM;?>image.php?action=add" title="Add" class="link"><strong>Add New Image</strong></a></td>
		</tr>
		<?php if($_GET["msg"]!=""){ ?>
			<tr>
				<td align="center" class="success"><?php echo constant($_GET['msg']); ?></td>
			</tr>
        <?php } ?>
		<tr>
			<td height="10"></td>
		</tr>
		<tr>
			<td>
			<form method="get" name="frmPage" id="frmPage">
				<?php dispPageDropDown('View Records Per Page :',$_GET['ppage']);?>
				<?php if($_GET['page']!=""){ ?>
				<input type="hidden" value="<?php echo $_GET['page']?>" name="page" id="page" />
				<?php } ?>
				<?php if($_GET['sort']!=""){ ?>
				<input type="hidden" value="<?php echo $_GET['sort']?>" name="sort" id="sort" />
				<?php } ?>
				<?php if($_GET['field']!=""){ ?>
				<input type="hidden" value="<?php echo $_GET['field']?>" name="field" id="field" />
				<?php } ?>
			</form>
			</td>
		</tr>
		<tr>
			<td height="10"></td>
		</tr>
		<tr>
		<td>
		<table width="100%" border="0"  cellspacing="0" cellpadding="5" class="tabeleborder">
		  <tr class="trcolor">
			<td width="3%" align="center">ID</td>
			<td width="2%"><div><a href="<?php echo SITE_ADM;?>image.php?sort=asc&field=id" title="Ascending"><img src="<?php echo SITE_ADM_IMG;?>top-arrow.png" border="0" alt="Ascending" /></a></div><div><a href="<?php echo SITE_ADM;?>image.php?sort=desc&field=id" title="Descending"><img src="<?php echo SITE_ADM_IMG;?>bottom-arrow.png" border="0" alt="Descending" /></a></div></td>
			<td width="15%" align="center">KEY</td>
			<td width="2%"><div><a href="<?php echo SITE_ADM;?>image.php?sort=asc&field=con_key" title="Ascending"><img src="<?php echo SITE_ADM_IMG;?>top-arrow.png" border="0" alt="Ascending" /></a></div><div><a href="<?php echo SITE_ADM;?>image.php?sort=desc&field=con_key" title="Descending"><img src="<?php echo SITE_ADM_IMG;?>bottom-arrow.png" border="0" alt="Descending" /></a></div></td>
			<td width="15%" align="center">VALUE</td>
			<td width="2%"><div><a href="<?php echo SITE_ADM;?>image.php?sort=asc&field=con_value" title="Ascending"><img src="<?php echo SITE_ADM_IMG;?>top-arrow.png" border="0" alt="Ascending" /></a></div><div><a href="<?php echo SITE_ADM;?>image.php?sort=desc&field=con_value" title="Descending"><img src="<?php echo SITE_ADM_IMG;?>bottom-arrow.png" border="0" alt="Descending" /></a></div></td>
			<td width="8%" align="center">STATUS</td>
			<td width="2%"><div><a href="<?php echo SITE_ADM;?>image.php?sort=asc&field=status" title="Ascending"><img src="<?php echo SITE_ADM_IMG;?>top-arrow.png" border="0" alt="Ascending" /></a></div><div><a href="<?php echo SITE_ADM;?>image.php?sort=desc&field=status" title="Descending"><img src="<?php echo SITE_ADM_IMG;?>bottom-arrow.png" border="0" alt="Descending" /></a></div></td>
			<td width="13%" align="center">OPERATION</td>
		  </tr>
	  <?php if($tot>0) {
		while($row=mysql_fetch_array($arr_rs[1])) { ?>
		  <tr>
			<td colspan="2"><?php echo $row['id'];?></td>
			<td colspan="2"><?php echo $row['con_key'];?></td>
			<td colspan="2"><?php echo $row['con_value'];?></td>
			<td colspan="2"><?php echo $row['status'];?></td>
			<td class="icon" align="center">
				<ul>
					<li><a href="<?php echo SITE_ADM;?>image.php?action=edit&id=<?php echo $row['id'];?>" title="Edit"><img src="<?php echo SITE_ADM_IMG;?>edit.png" border="0" alt="Edit" /></a></li>
					<li><a href="<?php echo SITE_ADM;?>image.php?action=delete&id=<?php echo $row['id'];?>" title="Delete" onClick="return delete_record();"><img src="<?php echo SITE_ADM_IMG;?>delete.png" border="0" alt="Delete" /></a></li>
				</ul>
			</td>
		  </tr>	
	<?php }
		  echo '<tr><td colspan="9" align="center">';
		  	$con->onlyPagging($page,$per_page,8,2,0,1,$extra);
		  echo '</td></tr>';
		} else {
			echo '<tr><td colspan="9" align="center">'.RNF.'</td></tr>';
		}
	?>		  	  
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
<?php } ?>