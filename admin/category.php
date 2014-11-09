<?php
	require_once("../includes/config.php");
	$pagetitle="Manage Category";
	require_once(DIR_FUN.'validation.class.php');
	$tbl_nm = "categories";
	$id	=	"categoryId";
	$target_file = "category.php";
	if(!isset($_GET) || !isset($_GET['page']) || ($_GET['page']<1)) {
		$_GET['page'] = 1;
	}
	require_once("pagination.php");		
			
	if($_SESSION["admin_user"]=="")
	{
		header('location: login.php');
	}
	if($_SESSION["admin_role"]==1)
	{
		header('location: home.php');
	}
	if(isset($_POST['action']))
	{
		extract($_POST);
		$obj = new validation();
		
		$obj->add_fields($categoryname, 'req', 'Please enter Category Name');
		$obj->add_fields($categoryname, 'min=4', 'Category Name should be atleast 4 characters long');
        $obj->add_fields($categoryname, 'max=25', 'Category Name should not be more than 25 characters long');
		$obj->add_fields($categorycolor, 'req', 'Please enter Category color');
		$obj->add_fields($description, 'req', 'Please enter Description');
		$obj->add_fields($description, 'max=250', 'Description should not be more than 250 characters long');
		$error = $obj->validate();
		
		$description = addslashes($description);
		$categoryname = addslashes($categoryname);
		$categorycolor = addslashes($categorycolor);
			
		$category_name_old=mysql_fetch_array($con->recordselect("SELECT `categoryName` FROM `categories` WHERE categoryId = '".$_GET['id']."'"));
		$old=$category_name_old['categoryName'];
        $category_name=$con->recordselect("SELECT `categoryName` FROM `categories` WHERE `categoryName` = '".$categoryname."'");
		$new_nm=mysql_fetch_array($category_name);
		$new=$new_nm['categoryName'];
		
		if($_POST['action']=='edit')
		{				
			if($old!=$new && $old!=$categoryname)
			{
				$category_valid=mysql_num_rows($category_name);			
				if($category_valid > 0)
				{			
					$error .= 'Name already Exist! <br>';
				}	
			}
		}
		
		if($_POST['action']=='add')
		{			
			$category_valid=mysql_num_rows($category_name);			
			if($category_valid > 0)
			{			
				$error .= 'Name already Exist! <br>';
			}		
		}	
		
	}
	// Delete category code start
	if(isset($_GET['action']) && $_GET['action']=='delete') 
	{
		/*$sel_cat1=$con->recordselect("SELECT * FROM `projectbasics` WHERE projectCategory='".$_GET['id']."'");
		if(mysql_num_rows($sel_cat1)>0)
		{
			while($selCat = mysql_fetch_assoc($sel_cat1))
			{
					$sel_projectimg=$con->recordselect("SELECT * FROM `productimages` WHERE projectId='".$selCat['projectId']."'");
					if(mysql_num_rows($sel_projectimg)>0)
					{
						while($selProjectimgDelete = mysql_fetch_assoc($sel_projectimg))
						{
							@unlink(DIR_FS.$selProjectimgDelete['image640by480']);
							@unlink(DIR_FS.$selProjectimgDelete['image400by300']);
							@unlink(DIR_FS.$selProjectimgDelete['image100by80']);
							@unlink(DIR_FS.$selProjectimgDelete['image16by16']);				
						}
					}
				$con->delete("DELETE FROM `productimages` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `projectbacking` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `projectcomments` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `projecthit` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `projectremind` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `projectrewards` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `projects` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `projectstory` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `projectupdate` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `projectupdatecomment` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `staffpicks` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM `usermessages` WHERE `projectId` = '".$selCat['projectId']."'");
				$con->delete("DELETE FROM paypaltransaction WHERE projectId='".$selCat['projectId']."'");
			}
		}*/
		// Delete Query HERE		
		//$con->delete("DELETE FROM `projectbasics` WHERE `projectCategory` = '".$_GET['id']."'");
		//$con->delete("DELETE FROM `categories` WHERE `categoryId` = '".$_GET['id']."'");
		
		$page2=$_GET['page'];
		if($page2=='' || $page2==0)
		{
			$page2=1;
		}
		header('location: category.php?msg=DELREC&page='.$page2);		
	}
	// Delete category code end
	
	// Form Post code start
	$page1 = 1; // insure it is defined for later ref
	if(isset($_POST['action']) && ($_POST['action']=='add' || $_POST['action']=='edit')) {	
		extract($_POST);
		
		$description = addslashes($description);
		$categoryname = addslashes($categoryname);
		$categorycolor = addslashes($categorycolor);
		
		if($_POST['action']=='add' && $error=='')
		{	
			$con->insert("INSERT INTO categories (categoryId, categoryName, categoryDescription, categoryColor) VALUES (NULL, '$categoryname', '$description','$categorycolor')");
			header('location: category.php?msg=ADDREC');
		}
		if($_POST['action']=='edit' && $error=='') 
		{
			$con->update("UPDATE categories SET categoryName='$categoryname', categoryDescription='$description', categoryColor = '$categorycolor' WHERE categoryId='".$_GET['id']."'");
			$page1=(isset($_GET) && isset($_GET['page'])) ? $_GET['page'] : 1;
			if($page1=='' || $page1==0)
			{
				$page1=1;
			}
			header('location: category.php?msg=EDITREC&page='.$page1);
		}
	}
	// Form Post code end
	
	// User Edit select query code start
	if(isset($_GET['action']) && $_GET['action']=='edit') {
		$sel_category_edit_qry=mysql_fetch_array($con->recordselect("SELECT * FROM categories WHERE categoryId = '".$_GET['id']."'"));		
	}
	// User Edit select query code end
	
	if(isset($_GET['action']) && $_GET['action']=='inactive') {
		
		$sel_cat1=$con->recordselect("SELECT * FROM `projectbasics`
			LEFT JOIN projects ON projects.projectId = projectbasics.projectId
			WHERE projects.published =1 AND projectbasics.projectCategory = ".$_GET['id']."
			AND projectbasics.fundingStatus = 'r' AND projects.accepted =1");
										
		/*while($selCat = mysql_fetch_assoc($sel_cat1))
			{
		//$projects = mysql_fetch_assoc($sel_cat1);
		echo '<pre>';
		print_r($selCat);
		echo '</pre>';
			}
		exit;*/
		
		//$sel_cat1=$con->recordselect("SELECT * FROM `projectbasics` WHERE projectCategory='".$_GET['id']."'");
		//$sel_project=$con->recordselect("SELECT * FROM `projects` WHERE projectId='".$project['projectId']."' AND accepted=1 AND published=1 ");
		
		$flag = false;
		if(mysql_num_rows($sel_cat1)>0)
		{
			$current = time();
			while($selCat = mysql_fetch_assoc($sel_cat1))
			{
				if($selCat['projectEnd'] >= $current || $selCat['fundingStatus'] == 'r')
				{
					$flag = true;
				}
				
			}
		}
		if($flag == false){
			$con->recordselect("UPDATE categories SET isActive = 0 WHERE categoryId='".$_GET['id']."'");
			redirect(SITE_ADM."category.php?msg=SUCBLO&page=".$page1);		
		}else{
			redirect(SITE_ADM."category.php?msg=NOTACT&page=".$page1);		
		}
	}
	if(isset($_GET['action']) && $_GET['action']=='active') {
		$con->recordselect("UPDATE categories SET isActive = 1 WHERE categoryId='".$_GET['id']."'");		
		redirect(SITE_ADM."category.php?msg=SUCACT&page=".$page1);
	}
	
	$content="category";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>