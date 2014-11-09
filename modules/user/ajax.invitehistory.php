<?php

require "../../includes/config.php";

if($_REQUEST) {
	extract($_REQUEST);
	//$per_page
	//$search_txt
	//$load_rec
	
	

	
	$limit = " LIMIT ".$load_rec.",".$per_page;
	//print "SELECT * FROM ".$tbl." WHERE ".$condition." ORDER BY ct.categoryName ASC,pb.projectId DESC".$limit;
	$sqlQuery = 'SELECT * from tbl_invitefriends WHERE senderId="'.$_SESSION["userId"].'" ORDER BY createdDate DESC '.$limit.'';
	$sqlRes = $con->recordselect($sqlQuery);
	
	$content = NULL;
	
	
	$total_rec = mysql_num_rows($sqlRes);
	if($total_rec > 0) {
		while ($sel_project2 = mysql_fetch_assoc($sqlRes)) {					
			
			$content .= ' <div class="prctname">
                    <h6>'.$sel_project2['mailAddress'].'</h6>
                        </div>
                   <div class="prctname">
                        <h6>'.date("m-d-Y H:i:s",$sel_project2['createdDate']).'</h6>
                        
                    
                    <div class="clear"></div>
                </div>';
	
			}
	}
	
	$arr["html"] = $content;
	$arr["total_rec"] = $total_rec;
	
	echo json_encode_html($arr);
	exit;
	
}
?>