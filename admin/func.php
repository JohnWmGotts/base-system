<?php
require_once("../includes/config.php");
//**************************************
//     Page load dropdown results     //
//**************************************
function getTierOne()
{
	$result = mysql_query("SELECT DISTINCT tier_one FROM two_drops") 
	or die(mysql_error());

	  while($tier = mysql_fetch_array( $result )) 
  
		{
		   echo '<option value="'.$tier['tier_one'].'">'.$tier['tier_one'].'</option>';
		}

}
//**************************************
//     First selection results     //
//**************************************
if($_GET['func'] == "drop_1" && isset($_GET['func'])) { 
   drop_1($_GET['drop_var'],$_GET['drop_var2']); 
}

function drop_1($drop_var,$drop_var2)
{  
   require_once("../includes/config.php"); 
	$result = mysql_query("SELECT * FROM faqcategory WHERE faqCategoryParentId='$drop_var'") 
	or die(mysql_error());
	
	echo '<select name="tier_two" id="tier_two">';
	if(isset($_GET['action']) && ($_GET['action']=='add'))
	{ 
	?>
	     <option value=" " disabled="disabled" selected="selected">Choose one</option>';
 <?php 
	}
		  while($drop_2 = mysql_fetch_array( $result )) 
			{ ?>
            <option <?php if($drop_2['faqCategoryId']==$drop_var2){ echo 'selected="selected"'; } ?> value="<?php echo $drop_2['faqCategoryId']; ?>"  ><?php echo $drop_2['faqcategoryName']; ?></option>
            <?php
			}
	
	echo '</select> ';
    
}
?>