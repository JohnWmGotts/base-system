<script language="javascript">
$(document).ready(function() {
$("#uname").focus();
	$("#frmLogin").validate({
		rules: {
			uname: { 
				required: true
			},
			passwd: {
				required: true
			}
		},
		messages: {
			uname: {
				required: "<?php echo ER_USER;?>"
			},
			passwd: {
				required: "<?php echo ER_PSW;?>"
			}
		}
	});
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr style="height:520px;">
  <td class="content-left-bg"></td>
  <td valign="top" class="content-login" align="center"><table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td colspan="3" height="70px"></td>
	  </tr>
	  <tr>
	<?php if(isset($error) && ($error!="")){ ?>
    <tr>
    	<td colspan="2" align="center" class="error_msg"><?php print $error; ?></td>
    </tr>
    <?php } ?>
		<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>login-left.gif" alt="img" /></td>
		<td valign="top" class="content-login-bg">
			<form action="login.php" method="post" name="frmLogin" id="frmLogin">
			<table width="80%" border="0" cellspacing="0" align="center" cellpadding="0">
			<tr>
			  <td height="20" colspan="2">&nbsp;</td>
			</tr>
			
			<tr>
			  <td height="10" colspan="2">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="2" class="login-heding" align="center">Administrator Login</td>
			</tr>
			<tr>
			  <td height="25" colspan="2">&nbsp;</td>
			</tr>
			<tr>
			  <td width="22%" class="loginusername" valign="top"><strong>Username :&nbsp;</strong></td>
			  <td width="78%" class="float-left"><input name="uname" id="uname" type="text" value="<?php echo (isset($_POST) && isset($_POST['uname'])) ? $_POST['uname'] : '';?>" class="logintextbox-bg float-left" tabindex="1" /><label for="uname" generated="true" class="error login_msg"></label></td>
               
			</tr>
          
            <tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td class="loginusername" valign="top"><strong>Password :&nbsp;</strong></td>
			  <td class="float-left"><input name="passwd" id="passwd" type="password" class="logintextbox-bg float-left" tabindex="2" />
			  <div class="clear"></div>
              <label for="passwd" generated="true" class="error login_msg"></label></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left"><input type="image" name="login2" tabindex="3" src="<?php echo SITE_ADM_IMG;?>bt_login.gif"/></td>
			</tr>
		  </table>
		  </form>
		</td>
		<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>login-right.gif" alt="img" /></td>
	  </tr>
	  <tr>
		<td colspan="3" height="70px"></td>
	  </tr>
	</table></td>
  <td width="10" class="content-right-bg"></td>
</tr>
<tr>
  <td width="10px"><img src="<?php echo SITE_ADM_IMG;?>content-left-bottom.gif" alt="img" /></td>
  <td class="content-bottom-bg"></td>
  <td width="10px"><img src="<?php echo SITE_ADM_IMG;?>content-right-bottom.gif" alt="img" /></td>
</tr>
</table>