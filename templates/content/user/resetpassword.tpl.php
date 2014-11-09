<script language="javascript">
$(document).ready(function() {	
	$.validator.addMethod("validpassword", function(value, element) {
	    return value.match(new RegExp(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).*$/g));
		}, 
		"The password must contain a minimum of one lower case character," + " one upper case character and one digit");

	$("#frmCP").validate({
		rules: {
            newpass: { required: true,validpassword: true, minlength: 6 },
			cnewpass: { required: true,equalTo: "#user_pass" }
		},
		messages: {

			newpass: {
                required: "<?php echo ER_PSW;?>",
				validpassword: "The password must contain a minimum of one lower case character. one upper case character and one digit",
				minlength: "Enter Password atleast 6 characters long"

			},
			cnewpass: {
				required: "<?php echo ER_CPSW;?>",
                equalTo: "<?php echo ER_SAMEPSW;?>"
			}
		}
	});
});
</script>

<div id="inbox" class="head_content temp">
       <h3>Reset Password</h3>
</div>
<div id="container">
	<div class="wrapper">
		<div class="reset-pass-box">
            <!--LogIN div start-->
            <form action="<?php echo SITE_URL; ?>resetpassword/email/<?php echo $_GET['email']; ?>/actCode/<?php echo $_GET['actCode']; ?>/" method="post" name="frmCP" id="frmCP">
                <div class="fieldset-errors">
                    <?php if(isset($error) && ($error!="")){ ?>
                    <?php print $error; ?>
                    <?php } ?>
                    <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]!="")){ ?>
                    <?php echo constant($_GET['msg']); ?>
                    <?php } ?>
                </div>
                <div class="fieldset-errors"></div>
                <div class="inputfield1">
                    <p>Your New Password</p>
                    <input class="input-text password" id="user_pass" size="30" name="newpass" tabindex="1" type="password" />
                </div>
                <div class="inputfield1">
                    <p>Confirm Your New Password</p>
                    <input class="input-text password" id="user_cpassword" size="30" name="cnewpass" tabindex="2" type="password" />
                </div>
				
                <div class="inputfield1">
					<p>&nbsp;</p>
					<div class="margin-left10 float-left">
                    <input name="submitResetpass" tabindex="3" type="submit" value="Save">
					</div>
                </div>   
            </form>                
		</div>
	</div>
</div>