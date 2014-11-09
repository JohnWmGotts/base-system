<?php
	require_once("../includes/config.php");

	$categoryname=$_REQUEST['categoryname'];
	$categoryname = addslashes($categoryname);	
	$category_name_old=mysql_fetch_array($con->recordselect("SELECT `categoryName` FROM `categories` WHERE categoryId = '".$_GET['id']."'"));
	$old=$category_name_old['categoryName'];		
	$category_name=$con->recordselect("SELECT categoryName FROM `categories` WHERE `categoryName` = '".$categoryname."'");
	$new_nm=mysql_fetch_array($category_name);
	$new=$new_nm['categoryName'];		
   
	if($_GET['action']=='edit')
	{				
		if($old!=$new && $old!=$categoryname)
		{
			$category_valid=mysql_num_rows($category_name);			
			if($category_valid > 0)
			{			
				echo "false";
			}
			else
			{
				echo "true";
			}
		}
		else
		{
			echo "true";
		}
	}
	
	if($_GET['action']=='add')
	{			
		$category_valid=mysql_num_rows($category_name);			
		if($category_valid > 0)
		{			
			echo "false";
		}
		else
		{
			echo "true";
		}
	}	
	
	/* $categoryname_valid1=mysql_num_rows($categoryname_valid);
	if($categoryname_valid1>0)
	{		
		echo "false";
	}
	else
	{
		echo "true";
	}*/
?>