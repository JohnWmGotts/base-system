<?php global $theme; ?>
  <?php /*<div id="footer-wrap" class="span-24">
  <div id="footer">
   
                    All links in the footer should remain intact. 
                    These links are all family friendly and will not hurt your site in any way. 
                    Warning! Your site may stop working if these links are edited or deleted 
                    
                    You can buy this theme without footer links online at http://fthemes.com/buy/?theme=solid 
                */ ?>
    <?php /* ?><div id="credits">Powered by <a href="http://wordpress.org/"><strong>WordPress</strong></a> | Designed by: <a href="http://www.interacialdating.co.za">interacial dating</a> | Thanks to <a href="http://www.dogtrainingjobs.com">dog training jobs</a>, <a href="http://www.physiotherapyjobs.org">physiotherapy jobs</a> and <a href="http://www.italymatch.com">italy match</a></div><?php 
  </div>
  <!-- #footer --> 
</div>
<!-- #wrap-footer -->*/ ?>

</div>
<!-- #container -->
<footer>
  <div class="wrapper">
    <div class="footerbox">
      <ul>
        <li class="copyright">
			<p style="font-size:9px;" >Code by NCrypted, modified by CrowdedRocket</p>
		  <!--          
		  <div class="socialicon">
            <ul>
              <li><a href="https://plus.google.com/112633711767247619787" target="_blank" title="Google Plus" class="gplus">&nbsp;</a></li>
              <li><a href="http://www.linkedin.com/company/ncrypted-technologies" target="_blank" title="LinkedIn" class="linkdin">&nbsp;</a></li>
              <li><a href="https://www.facebook.com/ncryptedtechnologies" target="_blank" title="Facebook" class="fb">&nbsp;</a></li>
              <li><a href="https://twitter.com/NCrypted" target="_blank" title="Twitter" class="tw">&nbsp;</a></li>
            </ul>
          </div>
		  -->
          <div class="flclear"></div>
          <div class="socialicon">
            <ul>
			<?php 
				if (!preg_match('#emptyrocket#i', SITE_URL)) { // no analytics for emptyrocket.com {
			?>
              <li><a href="http://www.ncrypted.net/" class="nct" title="Website Design Company" target="_blank">&nbsp;</a></li>
            <?php 
				} else {
			?>	
			  <li>original code licensed from ncrypted.net - a Website Design Company</li>
			<?php	
				}
			?>
			</ul>
          </div>
        </li>
<!--
        <li class="linkdiv">
          <p class="textnormal">Company Info</p>
          <a href='<?php echo SITE_URL; ?>content/1/about-crowdedrocket/' title="About CrowdedRocket">About CrowdedRocket</a><br/>
          <a href='<?php echo SITE_URL; ?>content/2/jobs/' title="Jobs">Jobs</a><br/>
          <a href='<?php echo SITE_URL; ?>content/3/terms/' title="Terms">Terms</a><br/>
          <a href='<?php echo SITE_URL; ?>content/4/privacy/' title="Privacy">Privacy</a><br/>
          <a href='<?php echo SITE_URL; ?>content/5/legal/' title="Legal">Legal</a><br/>
          <a href='<?php echo SITE_URL; ?>content/6/site-map/' title="Site Map">Site Map</a><br/>
        </li>
        <li class="linkdiv">
          <p class="textnormal">Any Questions?</p>
          <a href='<?php echo SITE_URL; ?>content/7/safety-center/' title="Contact">Safety Center</a><br/>
          <a href='<?php echo SITE_URL; ?>content/8/contact/' title="Contact">Contact</a><br/>
          <a href='<?php echo SITE_URL; ?>content/9/how-it-works/' title="How It Works">How It Works</a><br/>
          <a href='<?php echo SITE_URL; ?>content/12/defining-your-project/' title="Defining Your Project">Defining Your Project</a><br/>
          <a href="<?php echo SITE_URL; ?>help/" title="FAQ">FAQ</a><br/>
          <a href="<?php echo SITE_URL; ?>/blog/" title="Blog" >Blog</a><br/> 
        </li>
-->
		<li>
		<?php
			require_once(DIR_FS.'includes/functions/dbconn.php');
			require_once(DIR_FS.'includes/functions/functions.php');
			$con = new DBconn();
			$con->connect(SITE_DB_HOST, SITE_DB_NAME, SITE_DB_USER, SITE_DB_PASS);
			
			if (!isset($links1)) $links1 = '';
			if (!isset($links2)) $links2 = '';
            $selectQuery = $con->recordselect("SELECT * from content");
            if(mysql_num_rows($selectQuery)>0){
                while($cms_arr = mysql_fetch_assoc($selectQuery)){
                    $column = $cms_arr['column'];
                    if($column == 1){ 
                        $href = SITE_URL.'content/'.$cms_arr['id'].'/'.Slug($cms_arr['title']).'/';
                        $links1 .= "<a title='".ucfirst($cms_arr['title'])."' href='".$href."'><span class='footerblack'>".$cms_arr['title']."</span></a><br/>";
                    }elseif($column == 2){
                        $href = SITE_URL.'content/'.$cms_arr['id'].'/'.Slug($cms_arr['title']).'/';
                        $links2 .= "<a title='".ucfirst($cms_arr['title'])."' href='".$href."'><span class='footerblack'>".$cms_arr['title']."</span></a><br/>";
                    }
                }
            }
        ?>
        </li>
        <li class="linkdiv hovereffect">
          <p class="textnormal">Company Info</p>
          <?php echo $links1; ?>
          <a title="SITEMAP" href="<?php echo $base_url;?>sitemap/"><span class='footerblack'>Site Map</span></a><br/> 
          
        </li>
        <li class="linkdiv hovereffect">
          <p class="textnormal">Any Questions?</p>
          <?php echo $links2; ?>
          <a title="FAQ" href="<?php echo $base_url;?>help/"><span class='footerblack'>FAQ</span></a><br/> 
          <a title="Blog" href="<?php echo $base_url;?>blog/" target="_blank" ><span class='footerblack'>Blog</span></a><br/> 
        </li>
      </ul>
      
    </div>
    <div class="flclear"></div>
  </div>
</footer>
</div>
<!-- #wrapper -->

<?php wp_footer(); ?>
<?php $theme->hook('html_after'); ?>
</body></html>