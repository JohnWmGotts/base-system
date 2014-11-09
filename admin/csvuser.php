<?php

require_once("../includes/config.php"); 
//$dbfun = new DBFun();
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=user_detail.csv");
header("Pragma: no-cache");
header("Expires: 0");

echo "User Name,User Email"."\n";



$query = "SELECT * FROM users";
$select_c = mysql_query($query) or die(mysql_error()); 


while ($row = mysql_fetch_assoc($select_c))
{
		$name=$row['name'];
		$emailAddress=base64_decode($row['emailAddress']);
		
		
   
			$rowCS['name'] = '"' . str_replace('"', '""', $name) . '"';
			$rowCS['emailAddress']  = '"' . str_replace('"', '""', $emailAddress) . '"';
			
       		 
		
		
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