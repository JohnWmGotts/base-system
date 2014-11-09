<?php
require_once("../includes/config.php");

	$start=$_REQUEST['start'];
	$end=$_REQUEST['end'];
	
	if(isset($_REQUEST['id']) && is_numeric($_REQUEST["id"]) && $_REQUEST["id"]!=''){
		$fld=' and id!="'.mysql_real_escape_string($_REQUEST["id"]).'"';
	}
	if($start!=0 && $end!=0)
	{
		//echo 'start'.$start; echo 'end'.$end;
		//echo "SELECT * FROM `commision` WHERE ((start>='".$start."' and  start<='".$end."' and end>0) or (end>='".$start."' and  end<='".$end."' and start>0) or (start<='".$start."' and  end>='".$start."' and start<='".$end."' and end>='".$end."' and start>0 and end>0)) and type='p' $fld";
		//$category_name=$con->recordselect("SELECT * FROM `commision` WHERE ((start>='".$start."' and  start<='".$end."' and end>0) or (end>='".$start."' and  end<='".$end."' and start>0) or (start<='".$start."' and  end>='".$start."' and start<='".$end."' and end>='".$end."' and start>0 and end>0)) and type='p' $fld");
		
		//here query is changed as required..
		$category_name=$con->recordselect("SELECT * FROM `commision` WHERE ((start>='".$start."' and  start<='".$end."' and end>0) or (end>'".$start."' and  end<='".$end."' and start>0) or (start<='".$start."' and  end>='".$start."' and start<='".$end."' and end>='".$end."' and start>0 and end>0)) and type='p' $fld");
		
	}
	else
	{
		$category_name=$con->recordselect("SELECT * FROM `commision` WHERE start='".$start."' and end='".$end."' and type='p' $fld");
	}
	
	$new_nm=mysql_fetch_array($category_name);
	$new=$new_nm['categoryName'];		
   
	
	$category_valid=mysql_num_rows($category_name);			
	if($category_valid > 0)
	{			
		echo "false";
	}
	else
	{
		echo "true";
	}

	
?>