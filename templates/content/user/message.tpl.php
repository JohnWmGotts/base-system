<script type="text/javascript">
	function deletemessage(id,sid,pid)
	{
		//alert(pid);
		var r = confirm('Are you sure you want to delete this message?');
		if(r==true) {
		window.location=application_path+"message/"+ sid + "/" + pid + "/" + id + "/";
		}
	}
</script>
<script language="javascript">
$(document).ready(function() {
$(function(){
    $("#cng_pass_hide").hide();
    $('.show_hide').click(function(){
    	$("#cng_pass_hide").slideToggle();
    });
});
	
$("#frm_reply_form").validate({
		rules: {
            replymessage: { required: true, maxlength:255 }
		},
		messages: {
            replymessage: {
				required: "<?php echo 'Please Enter message';?>",
				maxlength: "Accepted only 255 characters"
			}
		}
	});
});
</script>

<section id="container">
   <div class="wrapper">
   		<div class="message_board_inner_header">
            <a title="Inbox" href="<?php echo SITE_URL; ?>inbox/" >Inbox</a> / <?php echo unsanitize_string($sel_project_detail['projectTitle']); ?>
        </div>
        <div class="message_board_inner_left">
            <div class="message_board_top">
            	<H6><a title="Reply" href="javascript:void(0)" class="show_hide" >Reply</a></H6>
            </div>
            
            <div class="" id="cng_pass_hide" >
                <form method="post" name="frm_reply_form" id="frm_reply_form" action="<?php echo SITE_URL; ?>message/<?php echo $_GET['id']; ?>/<?php echo $_GET['projectId']; ?>/" accept-charset="UTF-8">
                    <label for="message_to">TO:&nbsp;<?php echo $sel_project_user['name']; ?></label>
                    <textarea rows="20" name="replymessage" id="replymessage" cols="40" class="input-textarea-replymessage"></textarea>
					<div class="space10"></div>
                    <div>
                        <input type="submit" value="Send message" name="submitReplymessage" class="button-neutral submit float-right" />
                    </div>
                </form>
            </div>
            <?php 
				$sel_message_all=$con->recordselect("SELECT * FROM usermessages WHERE ((receiverId='".$_GET['id']."' AND senderId='".$_SESSION['userId']."') OR (receiverId='".$_SESSION['userId']."' AND senderId='".$_GET['id']."')) AND projectId='".$_GET['projectId']."' ORDER BY messageTime DESC");
				if(mysql_num_rows($sel_message_all)>0)
				{
					while ($sel_message = mysql_fetch_assoc($sel_message_all))
					{								
						$sel_user_detail23=$con->recordselect("SELECT * FROM `users` WHERE `userId`='".$sel_message['senderId']."'");
						$sel_user_detail=mysql_fetch_assoc($sel_user_detail23);
			?>
                <div class="message_board_bottom">
                    <div class="message_board_bottom_left">
                    <a href="<?php echo SITE_URL; ?>profile/<?php echo $sel_user_detail['userId'].'/'.Slug($sel_user_detail['name']).'/'; ?>">
						<?php 
                        $check_imgusrs=str_split($sel_user_detail['profilePicture100_100'], 4);
                        if($sel_user_detail['profilePicture100_100']!='' && $sel_user_detail['profilePicture100_100']!=NULL  && file_exists(DIR_FS.$sel_user_detail['profilePicture100_100']) && $check_imgusrs[0]=='imag') { ?>
                            <img src="<?php echo SITE_URL.$sel_user_detail['profilePicture100_100']; ?>" alt="<?php echo $sel_user_detail['name']; ?>" title="<?php echo $sel_user_detail['name']; ?>" />
                        <?php } else if($sel_user_detail['profilePicture100_100']!='' && $sel_user_detail['profilePicture100_100']!=NULL && $check_imgusrs[0]=='http') { ?>
                            <img src="<?php echo $sel_user_detail['profilePicture100_100']; ?>" alt="<?php echo $sel_user_detail['name']; ?>" title="<?php echo $sel_user_detail['name']; ?>" />
                        <?php } else { ?>
                            <img src="<?php echo NOIMG; ?>" alt="<?php echo $sel_user_detail['name']; ?>" title="<?php echo $sel_user_detail['name']; ?>" />
                        <?php } ?>
                    </a>
					</div>
                    <div class="message_board_bottom_right">
                    <a title="<?php echo $sel_user_detail['name']; ?>" href="<?php echo SITE_URL; ?>profile/<?php echo $sel_user_detail['userId'].'/'.Slug($sel_user_detail['name']).'/'; ?>">
						<?php echo $sel_user_detail['name']; ?>
                    </a>    
                    
                    <h6><?php echo date('l M d\, h:ia ', $sel_message['messageTime']);  ?> EDT</h6>
                    <p><?php echo unsanitize_string($sel_message['message']);
					// echo $sel_message['messageId'];?></p>
                    <a href="javascript:void(0);" title="Delete Message" onclick="deletemessage(<?php echo $sel_message['messageId']; ?>,<?php echo $_GET['id']; ?>,<?php echo $_GET['projectId']; ?>);">Delete</a>
					</div>
                    <div class="clear"></div>
                </div>
            <?php } } else { redirect( SITE_URL."index.php"); } ?>
        </div>
        
        <div class="message_board_inner_right">
        	<div class="project_profile">
            	<div class="project_profile_left1">
				<a href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_project_detail['projectId'].'/'.Slug($sel_project_detail['projectTitle']).'/'; ?>">
					<?php if($sel_project_image['image100by80']!='' && file_exists(DIR_FS.$sel_project_image['image100by80'])) { ?>
                    	<img src="<?php echo SITE_URL.$sel_project_image['image100by80']; ?>" alt="<?php echo unsanitize_string($sel_project_detail['projectTitle']) ?>" title="<?php echo unsanitize_string($sel_project_detail['projectTitle']) ?>"/></a>
                    <?php } else { ?>
                    	<img src="<?php echo NOIMG; ?>" alt="<?php echo unsanitize_string($sel_project_detail['projectTitle']) ?>" title="<?php echo unsanitize_string($sel_project_detail['projectTitle']) ?>"/>
                    <?php } ?>
                </a>
				</div>
                <div class="project_profile_right1">
                <a title="<?php echo unsanitize_string($sel_project_detail['projectTitle']) ?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $sel_project_detail['projectId'].'/'.Slug($sel_project_detail['projectTitle']).'/'; ?>">
                	<?php echo unsanitize_string($sel_project_detail['projectTitle']) ?>
                </a>
                
                <?php /*?><h6>By <?php echo $sel_project_user['name'] ?></h6><?php */?>
                <h6>By <?php echo $sel_creator_name1['name'] ?></h6>
                
                <p>Funding ends <?php echo date('l M d\, h:ia ', $sel_project_detail['projectEnd']); ?> EDT</p>
				</div>
                <div class="clear"></div>
            </div>
        </div>
   </div>
</section>