<div id="sidebarright" class="inner-sidebarright">
	<div class="staff-picks-right searchSidebar">
    	<div class="padbot10">
            <span><img src="<?php echo $base_url;?>images/star.png" style="float:left;padding-right: 5px;padding-left: 10px;" /><h2>Featured</h2></span>
            <div class="flclear"></div>
            <ul>
            	<li><a href="<?php echo $base_url; ?>comingsoon/" <?php if($page == "comming_soon"){
					echo "class='active'";
					} ?>>Upcoming Projects</a></li>
					
                <li><a href="<?php echo $base_url; ?>staffpicks/" <?php if($page == "staffpicks"){
					echo "class='active'";
					} ?>>Staff Picks</a></li>
				<?php 
				/* fixup sql select in modules/browse/popular.php before showing this
                <li><a href="<?php echo $base_url; ?>popular/"  <?php if($page == "popular"){
					echo "class='active'";
					}?>>Popular</a></li>
                */
				?>
                <li><a href="<?php echo $base_url; ?>recentlaunch/"  <?php if($page == "recent_launch"){
					echo "class='active'";
					}?>>Recently Launched</a></li>
                
                <li><a href="<?php echo $base_url; ?>smallproject/" <?php if($page == "small_project"){
					echo "class='active'";
					}?> >Small Projects</a></li>
				<?php 
				/* fixup sql select in modules/browse/mostfunded.php before showing this  
                <li><a href="<?php echo $base_url; ?>mostfunded/" <?php if($page == "mostfunded"){
					echo "class='active'";
					}?>>Most Funded</a></li>
                */
				?>
				<?php 
				/* fixup sql select in modules/browse/recent_success.php before showing this
                <li><a href="<?php echo $base_url; ?>recentsuccess/" <?php if($page == "recent_success"){
					echo "class='active'";
					}?>>Recently Successful</a></li>
				*/
				?>
            </ul>
		</div>
    
    
    <!-- Catagory Listing Start-->
		<?php
		$selCategory = $con->recordselect("SELECT * FROM categories WHERE isActive='1' ORDER BY categoryName ASC");
        if(mysql_num_rows($selCategory)>0) {
        ?>
        <div class="padbot10">
            <span><img src="<?php echo $base_url;?>images/category.png" style="float:left;padding-right: 5px;padding-left: 10px;" /><h2>Categories</h2></span>
            <div class="flclear"></div>
            <ul>
                <?php
                while($row = mysql_fetch_assoc($selCategory)) { ?>
                    <li><a title="<?php echo ucfirst(unsanitize_string($row['categoryName']));?>" href="<?php echo SITE_URL; ?>category/<?php echo $row['categoryId'].'/'.Slug($row['categoryName']).'/';?>" 
					<?php if(isset($_GET['catId']) && ($_GET['catId'] != NULL && !isset($titlename)) && ($_GET['catId'] == $row['categoryId'])){
                    echo "class='active'";}?>><?php echo ucfirst(unsanitize_string($row['categoryName']));?></a></li>
                <?php } ?>
            </ul>
        </div>
        <?php
        }
        ?>	
    <!-- Catagory Listing End-->
    
    <!-- Location Listing End-->
        <div class="padbot10">
            <span><img src="<?php echo $base_url;?>images/location.png" style="float:left;padding-right: 5px;padding-left: 10px;" /><h2>Locations</h2></span>
            <div class="flclear"></div>
            <ul>
                <?php
				$chktime_cur=strtotime(date("Y-m-d H:i:s",time())); 
				$chktime_cur=time();
				$selCitie = $con->recordselect("SELECT pb.projectLocation, pb.projectId FROM `projectbasics` as pb,`projects` as pr WHERE pb.fundingStatus='y' OR (pb.projectEnd >'".$chktime_cur."' AND pb.fundingStatus='r') AND pb.projectId=pr.projectId AND pr.published='1' AND pr.accepted='1' GROUP BY projectLocation ");
				//$selCitie = $con->recordselect("SELECT projectLocation, projectId FROM projectbasics WHERE fundingStatus='y' OR (projectEnd >'".$chktime_cur."' AND fundingStatus='r') GROUP BY projectLocation ");
                while($row = mysql_fetch_assoc($selCitie)) {
                    if($row['projectLocation']!='') { ?>
                    <li>
                    <a title="<?php echo ucfirst(unsanitize_string($row['projectLocation']));?>" href="<?php echo SITE_URL; ?>city/<?php echo $row['projectId'].'/'.Slug($row['projectLocation']).'/';?>" <?php 
					if(isset($titlename) && $titlename == $row['projectLocation']){echo "class='active'";} ?>>
						<?php $unsanaprotit = unsanitize_string(ucfirst($row['projectLocation']));
							$protit_len=strlen($unsanaprotit);
							if($protit_len>35) {echo substr($unsanaprotit, 0, 35).'...'; } 
							else { echo substr($unsanaprotit, 0, 35); } ?>
                    </a></li>
                <?php 
                    }
                } ?>   
            </ul>
        </div>
    </div>
</div>