<script type="text/javascript">
	function deletemessage(id)
	{
		 
		var r = confirm('Are you sure you want to delete this conversation?');
		if(r==true) {
		window.location=application_path+"inbox/"+ id +"/";
		}
		/*else {
		window.location=application_path+"inbox/"; 
		}*/
	}
</script>
<script type="text/javascript">
	function openmessage(id,projectId)
	{
		window.location=application_path+"message/"+ id +"/"+ projectId +"/";
	}
</script>
<section id="container">
   <div id="inbox" class="head_content temp">
       <h3>Inbox</h3>
   </div>
   <div class="wrapper">
		<?php $sel_message_all_1=$con->recordselect("SELECT DISTINCT `projectId` FROM usermessages WHERE receiverId='".$_SESSION['userId']."' ORDER BY messageTime DESC");							
        if(mysql_num_rows($sel_message_all_1)>0)
        { ?>
            <div class="message_heading">
                <h2 class="clm1">Name</h2>
                <h2 class="clm2">Message</h2>
                <h2 class="clm3">Replies</h2>
            </div>
        
            <?php 
				while ($sel_message_1 = mysql_fetch_assoc($sel_message_all_1)) {
					$sel_message_all=$con->recordselect("SELECT * FROM usermessages WHERE projectId='".$sel_message_1['projectId']."' AND receiverId='".$_SESSION['userId']."' GROUP BY senderId ORDER BY messageTime DESC");								
					while ($sel_message = mysql_fetch_assoc($sel_message_all)) {
						$sel_user_detail=mysql_fetch_assoc($con->recordselect("SELECT * FROM `users` WHERE `userId`='".$sel_message['senderId']."'"));
						$sel_project_detail1=mysql_fetch_assoc($con->recordselect("SELECT * FROM `projectbasics` WHERE `projectId`='".$sel_message['projectId']."'"));
						$sel_message_count=mysql_fetch_assoc($con->recordselect("SELECT count(messageId) as countreply FROM usermessages WHERE ((receiverId='".$sel_message['senderId']."' AND senderId='".$_SESSION['userId']."') OR (receiverId='".$_SESSION['userId']."' AND senderId='".$sel_message['senderId']."')) AND projectId='".$sel_message['projectId']."'"));
			?>
            	<div class="message_box" onClick="return openmessage(<?php echo $sel_message['senderId']; ?>,<?php echo $sel_message['projectId']; ?>)">
                        <div class="clm1">
                            <?php 
							$check_imgusrs12=str_split($sel_user_detail['profilePicture100_100'], 4);
							if($sel_user_detail['profilePicture100_100']!='' && $sel_user_detail['profilePicture100_100']!=NULL  && file_exists(DIR_FS.$sel_user_detail['profilePicture100_100']) && $check_imgusrs12[0]=='imag') { ?>
								<img title="<?php echo ucfirst($sel_user_detail['name']); ?>" alt="<?php echo ucfirst($sel_user_detail['name']); ?>" src="<?php echo SITE_URL.$sel_user_detail['profilePicture100_100']; ?>">							
							<?php } else if($sel_user_detail['profilePicture']!='' && $sel_user_detail['profilePicture']!=NULL && $check_imgusrs12[0]=='http') { ?>
								<img title="<?php echo ucfirst($sel_user_detail['name']); ?>" alt="<?php echo ucfirst($sel_user_detail['name']); ?>" src="<?php echo $sel_user_detail['profilePicture100_100']; ?>" >							
							<?php } else { ?>
								<img title="<?php echo ucfirst($sel_user_detail['name']); ?>" alt="<?php echo ucfirst($sel_user_detail['name']); ?>" src="<?php echo NOIMG; ?>" >							
							<?php } ?>
                            
                            <a title="<?php echo ucfirst($sel_user_detail['name']); ?>" href="<?php echo SITE_URL.'message/'.$sel_message['senderId'].'/'.$sel_message['projectId']; ?>/">
								<?php echo ucfirst($sel_user_detail['name']); ?>
                            </a>
                            
                            <h6><?php echo date('M d', $sel_message['messageTime']); ?></h6>
                            
                            <div class="clear"></div>
                        </div>
                        <div class="clm2">
                            <h5><?php echo unsanitize_string(ucfirst($sel_project_detail1['projectTitle'])); ?></h5>
                            <p><?php echo unsanitize_string($sel_message['message']); ?></p>
                        </div>
                         <div class="clm3">
                            <h4><?php echo $sel_message_count['countreply'];
							// echo $sel_message['messageId'];?></h4>
                        </div>
                     
                       
                	<div class="clear"></div>
                     
            	</div>
                	<div class="clear"></div>
                <div style="margin-left: 92%; position: relative; top: -34px; z-index: 5555555;">
                   <a href="javascript:void(0);" title="Delete Message" onclick="deletemessage(<?php echo $sel_message['messageId']; ?>);" >Delete</a>
            </div>
			<?php } } ?>
            <br /><br /><br />
		<?php } else {  ?>
        		<br /><br />
        		<p class="center">You have no message yet.</p>
        <?php }  ?>            
   </div><!--wrapper-->
</section>