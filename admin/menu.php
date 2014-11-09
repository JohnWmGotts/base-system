<ul class="admin_menu">
	<li><a title="Home" href="<?php echo SITE_ADM;?>home.php" id="home">Home</a></li>
	<li><a title="Change Password" href="<?php echo SITE_ADM;?>change_password.php" id="change_password">Change Password</a></li>
    <?php if($_SESSION["admin_role"]==0 or $_SESSION["admin_role"]==-1) { ?>
        <!--<li class="lfmenu-section">Commission Management</li>
        <li><a title="Manage Commission Range" href="<?php echo SITE_ADM;?>manage_commision_range.php" id="manage_commision_range">Manage Commission Range</a></li>
       <li><a title="Manage Default Commission" href="<?php echo SITE_ADM;?>standardlimit.php" id="manage_default_commision">Set Default Commission</a></li>-->
        <li class="lfmenu-section">Commission Management</li>
        <li><a title="Manage Commission Range" href="<?php echo SITE_ADM;?>manage_commission_range.php" id="manage_commision_range">Manage Commission Range</a></li>
        <li><a title="Manage Default Commission" href="<?php echo SITE_ADM;?>standardlimit.php" id="standardlimit">Set Default Commission</a></li>
        <?php /*?><li><a title="Manage Commission for Backers" href="<?php echo SITE_ADM;?>manage_commision_backers.php" id="manage_commision_backers">Manage Commission for Backers</a></li><?php */?>
	<?php } ?>
    
    <?php // if($_SESSION["admin_role"]==0) {
		if($_SESSION["admin_role"]==0 or $_SESSION["admin_role"]==-1) { ?>
        <li class="lfmenu-section">Payment Credentials</li>
        <li><a title="Manage Payment Credentials" href="<?php echo SITE_ADM;?>payment_credential.php" id="manage_payment_credentials">Manage Payment Credentials</a></li>
	<?php } ?>
	<?php if($_SESSION["admin_role"]==0 or $_SESSION["admin_role"]==-1) { ?>
        <li class="lfmenu-section">Staff Management</li>
        <li><a title="Staff Users" href="<?php echo SITE_ADM;?>admin.php" id="admin">Staff Users</a></li>
        <?php //if($_SESSION["admin_role"] != -1) { ?>
            <li class="lfmenu-section">User Management</li>
            <li><a title="Manage Users" href="<?php echo SITE_ADM;?>user.php" id="user">Manage Users</a></li>
        <?php //} ?>
	<?php } ?>
	<?php if($_SESSION["admin_role"]==1 or $_SESSION["admin_role"]==0 or $_SESSION["admin_role"]==-1) { ?>
        <li class="lfmenu-section">Project Management</li>
        <li><a title="Staff Project list" href="<?php echo SITE_ADM;?>project.php" id="project">Staff Project list</a></li>
		<?php if($_SESSION["admin_role"]==0 or $_SESSION["admin_role"]==-1) { ?>
            <li><a title="Project Accept" href="<?php echo SITE_ADM;?>project_accept.php" id="project_accept">Project Accept</a></li>
            <li><a title="Project Payments" href="<?php echo SITE_ADM;?>project_payment.php" id="project_payment">Project Payments</a></li>
            <li><a title="Small Project Amount" href="<?php echo SITE_ADM;?>small_project.php" id="small_project">Small Project Amount</a></li>
             <li><a title="Project Reviews" href="<?php echo SITE_ADM;?>project_review.php" id="project_review">Project Reviews</a></li>
             <li><a title="Project Updates" href="<?php echo SITE_ADM;?>project_update.php" id="project_update">Project Updates</a></li>
             <li><a title="Project Comments" href="<?php echo SITE_ADM;?>project_comment.php" id="project_comment">Project Comments</a></li>
              <li><a title="Project Update Comments" href="<?php echo SITE_ADM;?>project_updatecomment.php" id="project_updatecomment">Project Update Comments</a></li>
              
              
	<?php } }?>
	<?php if($_SESSION["admin_role"]==0 or $_SESSION["admin_role"]==-1) {?>
        <li class="lfmenu-section">Category Management</li>
        <li><a title="Category list" href="<?php echo SITE_ADM;?>category.php" id="category">Category list</a></li>
        <li class="lfmenu-section">FAQ</li>
        <li><a title="Faq Category" href="<?php echo SITE_ADM;?>faq.php" id="faq">Faq Category</a></li>
        <li><a title="Faq Question" href="<?php echo SITE_ADM;?>faq_question.php" id="faq_question">Faq Question</a></li>
        <li class="lfmenu-section">Management</li>
        <li><a title="Newsletter Subscribers" href="<?php echo SITE_ADM;?>newsletter_subscriber.php" id="newsletter_subscriber">Newsletter Subscribers</a></li>
        <li><a title="Manage Newsletter" href="<?php echo SITE_ADM;?>newsletter.php" id="newsletter">Manage Newsletter</a></li>
        <li><a title="Static Pages" href="<?php echo SITE_ADM;?>static_content.php" id="static_content">Static Pages</a></li>
           <li><a title="Invite History" href="<?php echo SITE_ADM;?>invitehistory.php" id="invitehistory">Invite User History</a></li>
             <li><a title="Google Analytics Code" href="<?php echo SITE_ADM;?>googleanalytics.php" id="googleanalytics">Google Analytics Code</a></li>
          
	<?php } ?>
	
</ul>
<script type="text/javascript">
cur_page='<?php echo $file;?>';
$('.admin_menu li a').each(function(i,e){
	page_id=$(this).attr('id');
	if((page_id+'.php')==cur_page) {
		$(this).addClass('lfmenu-select');
	} else {
		$(this).removeClass('lfmenu-select');
	}
});
</script>