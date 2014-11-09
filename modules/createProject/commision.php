<?php
	require_once("../../includes/config.php");
		
  	$cost=sanitize_string($_POST['cost']);
	$prjId = sanitize_string($_POST['projectId']);
	$manage_commision_cost = mysql_fetch_array($con->recordselect("SELECT value from commision WHERE start =0 AND end >0 AND type = 'p'"));	
	if($cost!='' && is_numeric($cost))
	{
		$commision = get_commission($prjId,$cost,'0','p');
		if($commision==""){
			$sel_re_projectcommission=mysql_fetch_array($con->recordselect("SELECT * FROM smallprojectamount"));
			echo $sel_re_projectcommission['std_cat_commission'];			 
		}
		else {
		if($commision<=0){
			echo $manage_commision_cost['value'];
		}else{
			echo $commision;
		}
		}
	}else{
		echo $manage_commision_cost['value'];
	}
	
	
?>