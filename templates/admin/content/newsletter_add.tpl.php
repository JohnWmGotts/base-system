<script type="text/javascript" language="javascript">
var path = '<?php echo  APPLICATION_PATH; ?>/includes';
</script>
<script type="text/javascript" src="<?php echo APPLICATION_PATH; ?>/includes/wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="<?php echo APPLICATION_PATH; ?>/icludes/wysiwyg/scripts/wysiwyg-settings.js"></script>
<script type="text/javascript">WYSIWYG.attach('mailBody', path);</script>

<script type="text/javascript" src="<?php echo APPLICATION_PATH; ?>/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo APPLICATION_PATH; ?>/js/jquery.validate.js"></script>
<script type="text/javascript" language="javascript">
	
	function deleteit(i)
	{	
		truth1 = confirm("Are you sure you want to delete this Newsletter?")
		if (truth1)
		{
			document.deletetab.tid.value=i;
			document.deletetab.submit();
		}
	}
	function editit(i)
	{	//truth1 = confirm("Are you sure you want to delete this theme?")
		//if (truth1)
		//{
			document.edittab.tid.value=i;
			document.edittab.submit();
		//}
	}
	
</script>
<script language="javascript" type="text/javascript">

$.validator.setDefaults(
{
	errorClass:"error_msg"
});

$(document).ready(function()
{  
	$("#newsletter").validate(
	{
		rules:
		{
			txtTemplateName:
			{
				required : true,
				maxlength : 100
			},
			
			mailBody:
			{
				required : true
			}
			
		},
		messages:
		{
			txtTemplateName:
			{
				required:"&nbsp;&nbsp;Enter Newsletter name",
				maxlength:"&nbsp;&nbsp;Maximum 100 char allowed"
			},
			
			mailBody:
			{
				required:"<br><br>Enter Description"
			}
		}
	});
});

maxL=100;
var bName = navigator.appName;
function taLimit(taObj) {
	if (taObj.value.length==maxL) return false;
	return true;
}

function taCount(taObj,Cnt) { 
	objCnt=createObject(Cnt);
	objVal=taObj.value;
	if (objVal.length>maxL) objVal=objVal.substring(0,maxL);
	if (objCnt) {
		if(bName == "Netscape"){	
			objCnt.textContent=maxL-objVal.length;}
		else{objCnt.innerText=maxL-objVal.length;}
	}
	return true;
}
function createObject(objId) {
	if (document.getElementById) return document.getElementById(objId);
	else if (document.layers) return eval("document." + objId);
	else if (document.all) return eval("document.all." + objId);
	else return eval("document." + objId);
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>Manage Users</td>
		  </tr>
		</table>
	</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
</tr>
<tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">
		<form name="newsletter" id="newsletter" action="newsletter_add.php" method="post" >                
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
      
                    <tr>
						<td width="18%" align="center"><div align="right"><strong>Newsletter Name: </strong></div></td>
						<td width="82%" colspan="2" align="center"  bgcolor="#FFFFFF" ><div align="left">
                        <input type="text" id="txtTemplateName" name="txtTemplateName" size="40" /></div>
                        </td>         
					</tr>
                    
                    <tr>
						<td width="18%" align="center"><div align="right"><strong>Newsletter Content : </strong></div></td>
						<td colspan="2" align="center"  bgcolor="#FFFFFF"><div align="left">
                        <textarea cols="70" rows="5" id="mailBody" name="mailBody"><?php echo $_REQUEST['mailBody']; ?></textarea></div>
                        </td>           
					</tr>
					
                    <tr>
						<td width="18%" align="center"  bgcolor="" class="whiteBold_text"><div align="right"><strong>&nbsp; </strong></div></td>
						<td colspan="2" align="center"  bgcolor="#FFFFFF" class="whiteBold_text">
                        
                        <div align="left"><input type="submit" name="sendMail" id="sendMail" value="Add"/> 
                        <input type="button" value="Cancel" onclick="Javascript:history.go(-1);" />
                        </div></td>         
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