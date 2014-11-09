<?php

require_once("../includes/config.php"); 
//$dbfun = new DBFun();
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=project_detail.csv");
header("Pragma: no-cache");
header("Expires: 0");

echo "Project Name,Project Category,Project Creator,Project Description,Project Location"."\n";



$query = "select * from projects as p, projectbasics as pbs, categories as cat, users as us where p.published=1 and p.accepted!=3 and p.projectId=pbs.projectId and pbs.projectCategory=cat.categoryId and p.userId=us.userId order by pbs.projectStart DESC";
$select_c = mysql_query($query) or die(mysql_error()); 


while ($row = mysql_fetch_assoc($select_c))
{
		$projectTitle=$row['projectTitle'];
		$categoryName=$row['categoryName'];
		$name=$row['name'];
		$shortBlurb=$row['shortBlurb'];
		$projectLocation=$row['projectLocation'];
	
		
   
			$rowCS['projectTitle'] = '"' . str_replace('"', '""', $projectTitle) . '"';
			$rowCS['categoryName']  = '"' . str_replace('"', '""', $categoryName) . '"';
			$rowCS['name']  = '"' . str_replace('"', '""', $name) . '"';
			$rowCS['shortBlurb']  = '"' . str_replace('"', '""', $shortBlurb) . '"';
			$rowCS['projectLocation']  = '"' . str_replace('"', '""', $projectLocation) . '"';
			
       		 
		
		
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