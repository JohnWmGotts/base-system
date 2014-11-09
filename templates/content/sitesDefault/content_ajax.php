<?php
require "../../../includes/config.php"; 
header('Content-Type: text/html');
 $category_id = "";
 $selected = (isset($_POST) && isset($_POST["type"])) ? $_POST['type'] : null; // jwg fixup

if(isset($_POST["type"]) && $_POST["type"]!= "" && is_numeric($_POST["type"])){ 
	$type = mysql_real_escape_string($_POST["type"]);
	$chktime_cur=time();
	$staffPicProjectData = $con->recordselect("SELECT * FROM `projectbasics` as p,`staffpicks` as s  WHERE  p.projectCategory='".$type."' AND p.projectId = s.projectId AND s.status != '0' 
		AND p.projectEnd > ".$chktime_cur." ORDER BY RAND() LIMIT 0, 1 ");
	if(mysql_num_rows($staffPicProjectData)>0){
		$project_detail = mysql_fetch_assoc($staffPicProjectData);
	}
}else {
	$type= "";
	$staffPicProjectData = $con->recordselect("SELECT `projectId` FROM `staffpicks` WHERE status !='0'  ORDER BY RAND() LIMIT 0, 1");
	if(mysql_num_rows($staffPicProjectData)>0){
		$staff_project = mysql_fetch_assoc($staffPicProjectData);
		$staff_pic_pro = $con->recordselect("SELECT * FROM `projectbasics` WHERE  `projectId` =".$staff_project['projectId']."");
		if(mysql_num_rows($staff_pic_pro)>0){		
			$project_detail = mysql_fetch_assoc($staff_pic_pro);
		}
	}
}
if(isset($project_detail) && ($project_detail != NULL)){
	$category_id = $project_detail["projectCategory"];
	$chktime_cur=time();
	$total_cat_record = $con->recordselect("SELECT	* FROM `projectbasics` as pb, `projects` as p , `staffpicks` as s WHERE  pb.projectCategory =".$project_detail['projectCategory']." 
		AND p.accepted = '1' AND pb.projectId = p.projectId AND p.projectId = s.projectId AND s.status != '0' AND (pb.projectEnd > ".$chktime_cur." OR pb.fundingStatus = 'y')");
	if(mysql_num_rows($total_cat_record)>0){
		$total_project = mysql_num_rows($total_cat_record);
	}else{
		$total_project = "0";
	}
	$categoryName = $con->recordselect("SELECT * FROM `categories` WHERE `categoryId`='".$project_detail['projectCategory']."'");
	if(mysql_num_rows($categoryName)>0){
		$staff_pic_category = mysql_fetch_assoc($categoryName);?>					
	<div class="float-left textbig-b">Staff Picks: <span class="textbig-g"><?php echo $staff_pic_category["categoryName"] ?></span></div>
	<div class="float-right textnormal-b">
    	<a class="black" href="<?php echo SITE_URL; ?>category/<?php echo $staff_pic_category['categoryId'].'/'.Slug($staff_pic_category["categoryName"]).'/';?>">
        	<?php if($total_project == 1) {?>
	            <strong>See <?php echo $total_project ?> <?php echo $staff_pic_category["categoryName"]; ?> Project</strong>
            <?php }else if($total_project == 2){ ?>
            	<strong>See both <?php echo $total_project ?> <?php echo $staff_pic_category["categoryName"]; ?> Projects</strong>
            <?php }else{ ?>
            	<strong>See All <?php echo $total_project ?> <?php echo $staff_pic_category["categoryName"]; ?> Projects</strong>
            <?php } ?>
        </a>
    </div>
	<div class="flclear spaser3"></div>
	<?php 
		$project_image= $con->recordselect("SELECT image340by250 FROM productimages WHERE projectId='".$project_detail['projectId']."'");
		$disp_project_image	= mysql_fetch_assoc($project_image);
	?>
   <div class="staff-image">
        <a href="<?php echo SITE_URL; ?>browseproject/<?php echo $project_detail['projectId'].'/'.Slug($project_detail['projectTitle']).'/'; ?>">
		<?php if(($disp_project_image['image340by250']!=NULL || $disp_project_image['image340by250']!='') && mysql_num_rows($project_image) > 0 ) {
			if(file_exists(DIR_FS.$disp_project_image['image340by250'])) { ?>
				<img src="<?php echo SITE_URL.$disp_project_image['image340by250']; ?>" alt="<?php echo ucwords($project_detail['projectTitle']); ?>" title="<?php echo ucwords($project_detail['projectTitle']); ?>"/>
			<?php } else { ?>
				<img src="<?php echo NOIMG; ?>" alt="<?php echo ucwords($project_detail['projectTitle']); ?>" title="<?php echo ucwords($project_detail['projectTitle']); ?>"/>
			<?php	}
		} else { ?>
			<img src="<?php echo NOIMG; ?>" alt="<?php echo ucwords($project_detail['projectTitle']); ?>" title="<?php echo ucwords($project_detail['projectTitle']); ?>"/>
		<?php } ?>
		</a>
  </div>
  <div class="staff-text">
	<div class="textsmall-b">
        <a title="<?php echo ucfirst($project_detail["projectTitle"]); ?>" href="<?php echo SITE_URL; ?>browseproject/<?php echo $project_detail['projectId'].'/'.Slug($project_detail["projectTitle"]).'/';?>">
        	<strong><?php echo ucfirst($project_detail["projectTitle"]); ?></strong>
        </a>
    </div>
	<div class="spaser1"></div>
	<?php 
	$user_name = $con->recordselect("SELECT p.userId,u.name FROM `projects` as p ,`users` as u WHERE  p.projectId =".$project_detail['projectId']." AND p.userId = u.userId AND p.accepted='1'");
	if(mysql_num_rows($user_name)>0){
		 $project_by=mysql_fetch_assoc($user_name);
 	}else{
		$project_by = "Not set";
	}
	?>
	<div class="textnormal-b">by <?php echo $project_by["name"]; ?> in <?php echo $project_detail["projectLocation"]?></div>
	<?php
	$fundingAmount = (isset($project_detail['fundingGoal']) OR !empty($project_detail['fundingGoal'])) ? $project_detail['fundingGoal'] : 0;
    	if($fundingAmount != NULL && $fundingAmount > 0){
            $value = $project_detail['rewardedAmount'];
            $max = $project_detail['fundingGoal'];
        }
        $scale = 1.0;
        if ( !empty($max) && $max!=0 ) { $percent = ($value * 100) / $max; }
        else { $percent = 0; }
        if ( $percent > 100 ) { $percent = 100; }
    ?>
	<p class="textnormal-b"> <?php echo unsanitize_string(ucfirst($project_detail["shortBlurb"])); ?>
	<div class="spaser3"></div>
	<p><div class="percentbar content-slider-percentbar">
    	<div style="width:<?php echo round($percent * $scale); ?>%;"></div>
    </div></p>
   <div class="staffpicks-rating textnormal-b">
	  <ul>
		<?php
			if($fundingAmount != NULL && $fundingAmount > 0){
				$value1 = $project_detail['rewardedAmount'];
				$max1 = $project_detail['fundingGoal'];
			}
			$scale = 1.0;
			if ( !empty($max1) && $max1!=0 ) { $percent1 = ($value1 * 100) / $max1; }
			else { $percent1 = 0; }
        ?>
		<li> <?php echo (int) $percent1."%"; ?><br />Funded </li>
        <li> $<?php echo number_format($project_detail['rewardedAmount']); ?><br />Pledged </li>
        
		<?php if($project_detail['projectEnd']>time() && $project_detail['fundingStatus']!='n') {
				$end_date=(int) $project_detail['projectEnd'];
				$cur_time=time();
				$total = $end_date - $cur_time;
				$left_days=$total/(24 * 60 * 60);
			}else{
                $left_days=0;
			}?>
		<li class="last"> <?php echo roundDays($left_days);?><br />
		  Days to Go </li>
	  </ul>
	</div>
 </div>
</div>				
<?php }
}else{
	$categoryName = $con->recordselect("SELECT * FROM `categories` WHERE `categoryId`='".$type."'");
	$staff_pic_category = mysql_fetch_assoc($categoryName)
	?>
 <div class="float-left textbig-b">Staff Picks: <span class="textbig-g"> <?php echo ucfirst($staff_pic_category["categoryName"]); ?></span></div>
  <div class="float-right textnormal-b"><a class="black" href="#"><strong>See All 0</strong></a></div>
  <div class="flclear spaser3"></div>
  <div class="staff-image"></div>
  <div class="staff-text">
	<div class="textsmall-b"><a href="#"><strong></strong></a></div>
	<div class="spaser2"></div>
	<div class="textnormal-b"></div>
	<div class="spaser2"></div>
	<p class="textnormal-b">No Staff Picks are available for this category.</p>
	<div class="spaser3"></div>
	<p></p>
	<div class="staffpicks-rating textnormal-b">
	</div>
  </div>
</div>
<?php } ?>