<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

	</div><!-- #main -->
	<div style="clear:both;"></div>
 <div class="footer-lsized">
    	<div class="footer" style="margin:0 auto;">
        	<div class="footer-left float-left">
            	
<div class="float-left"><span class="title">Terms Of Use</span>
				<ul>
                <li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=1">Terms</a></li>
				<li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=2">Privacy Policy</a></li>
				<li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=3">Distribution</a></li>				
				<li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=4">Contact Us</a></li>
				</ul>            	
            </div><!--.footer-left .float-left-->
            <div class="footer-center float-left">
            	<div class="float-left"><span class="title">Learn More</span>
                <ul>
                	<li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=5">Why NCrypted Crowdfunding Clone?</a></li>
					<li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=6">Features</a></li>
					<li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=7">Pricing</a></li>
					<li><a href="<?php echo SITE_MOD; ?>help/">FAQ</a></li>				
                	<li><a href="<?php echo SITE_MOD; ?>help/">Help</a></li>
                </ul> </div>
                <div class="marleft130 float-left"><span class="title">Customer Happiness</span>
                <ul>
                	<li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=10">Campaigner</a></li>
					<li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=11">Contributor</a></li>					
                	<li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=12">About Us</a></li>					
                	<li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=13">Press</a></li>
                    <li><a href="<?php echo SITE_MOD;?>staticPages/index.php?id=14">Careers</a></li>
                </ul> </div>    
                
            </div><!--.footer-center .float-left-->
            <div class="footer-right float-left">
            	<span class="title">NCrypted Crowdfunding Clone Newsletter</span>
                
                <p class="martop50">Sign up for NCrypted Crowdfunding Clone Newsletter</p>
                <form name="newsletter" id="newsletter" method="post" action="<?php echo SITE_MOD.'newsletter/index.php'; ?>" enctype="multipart/form-data">
                <div class="float-left newsletteremailvalid"><input name="newsletteremail" id="newsletteremail" type="text" class="footer-right-search-box" size="10" /></div>
          		<div class="float-right"><input type="submit" value="" class="search-button" /></div>
                
                </form>
                <div class="float-right padding-top15"><p>© 2012 NCrypted Crowdfunding Clone.
				All Rights Reserved
                <br /><br /><a href="http://www.ncrypted.net/" title="Web Development Company" target="_blank"><img src="http://nct15/NCrypted_Crowdfunding_Clone/images/site/nct-logo.png" alt="Web Development Company" title="Web Development Company" border="0" /></a>
                </p></div>
            </div><!--.footer-right .float-right-->
        </div><!--.footer-->
    </div><!--.footer-lsized-->
</div><!--.footer-lsized--><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>