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
		<li>
		<?php
			if (!isset($links1)) $links1 = '';
			if (!isset($links2)) $links2 = '';
            $selectQuery = $con->recordselect("SELECT * from content");
            if(mysql_num_rows($selectQuery)>0){
                while($cms_arr = mysql_fetch_assoc($selectQuery)){
                    $column = $cms_arr['column'];
                    if($column == 1){ 
                        $href = $base_url.'content/'.$cms_arr['id'].'/'.Slug($cms_arr['title']).'/';
                        $links1 .= "<a title='".ucfirst($cms_arr['title'])."' href='".$href."'><span class='footerblack'>".$cms_arr['title']."</span></a><br/>";
                    }elseif($column == 2){
                        $href = $base_url.'content/'.$cms_arr['id'].'/'.Slug($cms_arr['title']).'/';
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


