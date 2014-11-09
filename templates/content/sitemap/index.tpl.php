<div id="cms_content">
	<h1><?php echo 'SITEMAP';?></h1><br/>
   <ul style="float:left; padding:10px 15px 5px 25px;">
      <li class="onelink"> <a href="<?php echo $base_url;?>staffpicks/"><span>Discover Great Projects</span>
        	</a> </li>
        <li class="onelink"> <a href="<?php echo $base_url;?>createproject/"><span>Start Your Projects</span>
        	</a> </li>
            <li><a href="<?php echo SITE_URL; ?>help/" title="Help">Help</a></li>
           <li><a href="<?php echo $base_url;?>login/" title="Log in">Log in</a></li>
            	<li><a href="<?php echo $base_url;?>signup/" title="Sign Up">Sign up</a></li>
		       
		
        </li>
        </ul>
        <?php
            $selectQuery = $con->recordselect("SELECT * from content");
			if (!isset($lins1forsitemap)) $links1forsitemap = '';
			if (!isset($lins2forsitemap)) $links2forsitemap = '';
            if(mysql_num_rows($selectQuery)>0){
                while($cms_arr = mysql_fetch_assoc($selectQuery)){
                    $column = $cms_arr['column'];
                    if($column == 1){ 
                        $href = $base_url.'content/'.$cms_arr['id'].'/'.Slug($cms_arr['title']).'/';
                        $links1forsitemap .= "<a title='".ucfirst($cms_arr['title'])."' href='".$href."'><span>".$cms_arr['title']."</span></a><br/>";
                    }elseif($column == 2){
                        $href = $base_url.'content/'.$cms_arr['id'].'/'.Slug($cms_arr['title']).'/';
                        $links2forsitemap .= "<a title='".ucfirst($cms_arr['title'])."' href='".$href."'><span>".$cms_arr['title']."</span></a><br/>";
                    }
                }
            }
        ?>
        <ul style="float:left; padding:10px 15px 5px 25px;">
        <li class="linkdiv">
       <!-- <span><img src="<?php echo $base_url;?>images/category.png" style="float:left;padding-right: 5px;padding-left: 10px;" /><h2>Company Info</h2></span><br/>-->
          <p class="textnormal"><img src="<?php echo $base_url;?>images/category.png" style="float:left;padding-right: 5px;padding-left: 10px;" />Company Info</p>
          <?php echo $links1forsitemap; ?>
        </li>
        </ul>
        
        <ul style="float:left; padding:10px 15px 5px 25px;">
        <li class="linkdiv">
       <!-- <span><img src="<?php echo $base_url;?>images/category.png" style="float:left;padding-right: 5px;padding-left: 10px;" /><h2>Any Questions?</h2></span><br/>
        --> 
         <p class="textnormal"><img src="<?php echo $base_url;?>images/category.png" style="float:left;padding-right: 5px;padding-left: 10px;" />Any Questions?</p>
          <?php echo $links2forsitemap; ?>
          <a title="FAQ" href="<?php echo $base_url;?>help/">FAQ</a><br/> 
          <a title="Blog" href="<?php echo $base_url;?>blog/">Blog</a><br/> 
        </li>
        </ul>
        
        <ul style="float:left; padding:10px 15px 5px 25px;">
		<?php
		$selCategory = $con->recordselect("SELECT * FROM categories WHERE isActive='1' ORDER BY categoryName ASC");
        if(mysql_num_rows($selCategory)>0) {
        ?>
        <div class="padbot10">
            <span><img src="<?php echo $base_url;?>images/category.png" style="float:left;padding-right: 5px;padding-left: 10px;" /><h2>Categories</h2></span><br/>
            <div class="flclear"></div>
            
                <?php
                while($row = mysql_fetch_assoc($selCategory)) { ?>
                    <li><a title="<?php echo ucfirst(unsanitize_string($row['categoryName']));?>" href="<?php echo SITE_URL; ?>category/<?php echo $row['categoryId'].'/'.Slug($row['categoryName']).'/';?>" 
					<?php if(isset($_GET['catId']) && ($_GET['catId'] != NULL && !isset($titlename)) && ($_GET['catId'] == $row['categoryId'])){
                    echo "class='active'";}?>><?php echo ucfirst(unsanitize_string($row['categoryName']));?></a></li>
                <?php } ?>
            
        </div>
        <?php
        }
        ?>	
      </ul>
</div>