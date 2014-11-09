<?php

require_once("../includes/config.php"); 
//$dbfun = new DBFun();
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=category_detail.csv");
header("Pragma: no-cache");
header("Expires: 0");

echo "Category Name,Category Description"."\n";



$query = "SELECT * FROM categories";
$select_c = mysql_query($query) or die(mysql_error()); 


while ($row = mysql_fetch_assoc($select_c))
{
		$categoryName=$row['categoryName'];
		$categoryDescription=$row['categoryDescription'];
		
		
   
			$rowCS['categoryName'] = '"' . str_replace('"', '""', $categoryName) . '"';
			$rowCS['categoryDescription']  = '"' . str_replace('"', '""', $categoryDescription) . '"';
			
       		 
		
		
		/*else{
            //there may be separator (here I have used comma) inside data. So need to put double quote around such data.
        if(strpos($value, ',') !== false || strpos($value, '"') !== false || strpos($value, "\n") !== false) {
			$row[$key] ='"' .str_replace('"', '""',$value) . '"';
        }
		if($value=='')
		{
			$row[$key] ='"' .str_replace('"', '""',$value) . '"';
		}
		}*/
    
	//}
    echo stripslashes(implode(",",$rowCS))."\n";
	
}



?>