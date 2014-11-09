<?php
	require_once("../includes/config.php");
	$pagetitle="FAQ Category";
	require_once(DIR_FUN.'validation.class.php');
		
	if($_SESSION["admin_user"]=="")
	{
		redirect(SITE_ADM."login.php");
	}
	if($_SESSION["admin_role"]==1)
	{
		redirect(SITE_ADM."home.php");
	}
	if(!isset($_GET) || !isset($_GET['page']) || ($_GET['page']<1)) {
		$_GET['page'] = 1;
		$page = 1;
	} else {
		$page = $_GET['page'];
	}
	if(isset($_POST['action']) && ($_POST['action']=='add' || $_POST['action']=='edit'))
	{
		extract($_POST);
		$obj = new validation();		
		$obj->add_fields($categoryName, 'req', 'Please Enter Category Name');
		$error = $obj->validate();
		
		//$categoryName = addslashes($categoryName);
			
		if($error=='')
		{
			// category add code start
			if(isset($_POST['action']) && $_POST['action']=='add')
			{
				extract($_POST);
				$cur_time=time();	
				$categoryName =addslashes($categoryName);
				$editFaqCategorySel = $con->recordselect("SELECT * FROM faqcategory WHERE faqcategoryName='".$categoryName."'");
				if(mysql_num_rows($editFaqCategorySel)>0)
				{
					redirect(SITE_ADM."faq.php?msg=ALREADYADD");	
				}else{
					$con->insert("INSERT INTO faqcategory (faqCategoryId, faqCategoryParentId, faqcategoryName, faqStatus, faqCategoryTime) VALUES (NULL, '$typeOfCategory', '$categoryName', 1, '$cur_time')");
					redirect(SITE_ADM."faq.php?msg=ADDREC");
				}
			}
			// category add code ends
			
			// category edit code start
			if(isset($_POST['action']) && $_POST['action']=='edit')
			{
				extract($_POST);
				$categoryName =addslashes($categoryName);
				$editFaqCategorySel=mysql_fetch_assoc($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$_POST['faqCategoryId']."'"));
				if($editFaqCategorySel['faqCategoryParentId']==0)
				{
					$con->update("UPDATE faqcategory SET faqcategoryName='$categoryName' WHERE faqCategoryId='".$_POST['faqCategoryId']."'");	
					redirect(SITE_ADM."faq.php?msg=EDITREC");
				}
				else
				{
					$con->update("UPDATE faqcategory SET faqcategoryName='$categoryName', faqCategoryParentId='$typeOfCategory' WHERE faqCategoryId='".$_POST['faqCategoryId']."'");
					redirect(SITE_ADM."faq.php?msg=EDITREC");
				}
			}
			// category edit code ends
		}
	}		
			// category edit select code start
			if(isset($_GET['action']) && ($_GET['action']=='edit'))
			{
				$editFaqCategorysel=mysql_fetch_assoc($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$_GET['id']."'"));
			}
			// category edit code ends
	
			// category activate code start
			if(isset($_GET['action']) && ($_GET['action']=='activate'))
			{
				//echo "SELECT * FROM faqcategory WHERE faqCategoryId='".$_GET['id']."'";
				//print_r($_POST);exit;
				//print_r($_POST);
				extract($_POST);
				$con->update("UPDATE faqcategory SET faqStatus='1' WHERE faqCategoryId='".$_GET['id']."'");	
				/*$deleteFaqCategory=mysql_fetch_assoc($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$_GET['id']."'"));
				if($deleteFaqCategory['faqCategoryParentId']==0)
				{
					$con->delete("DELETE FROM faqquestionanswer WHERE faqCategoryParentId='".$_GET['id']."'");
					$con->delete("DELETE FROM faqcategory WHERE faqCategoryParentId='".$_GET['id']."'");
				}
				else
				{
					$con->delete("DELETE FROM faqquestionanswer WHERE faqCategoryId='".$_GET['id']."'");
				}
				
					$con->delete("DELETE FROM faqcategory WHERE faqCategoryId='".$_GET['id']."'");*/
				redirect(SITE_ADM."faq.php?msg=SUCACT&page=".$page);	
			}
			// category deactivate code start
			if(isset($_GET['action']) && ($_GET['action']=='deactivate'))
			{
				//echo "SELECT * FROM faqcategory WHERE faqCategoryId='".$_GET['id']."'";
				//print_r($_POST);exit;
				//print_r($_POST);
				extract($_POST);
				$con->update("UPDATE faqcategory SET faqStatus='0' WHERE faqCategoryId='".$_GET['id']."'");	
				/*$deleteFaqCategory=mysql_fetch_assoc($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$_GET['id']."'"));
				if($deleteFaqCategory['faqCategoryParentId']==0)
				{
					$con->delete("DELETE FROM faqquestionanswer WHERE faqCategoryParentId='".$_GET['id']."'");
					$con->delete("DELETE FROM faqcategory WHERE faqCategoryParentId='".$_GET['id']."'");
				}
				else
				{
					$con->delete("DELETE FROM faqquestionanswer WHERE faqCategoryId='".$_GET['id']."'");
				}
				
					$con->delete("DELETE FROM faqcategory WHERE faqCategoryId='".$_GET['id']."'");*/
				redirect(SITE_ADM."faq.php?msg=SUCBLO&page=".$page);	
			}
			// category delete code ends
	// category delete code start
			if(isset($_GET['action']) && ($_GET['action']=='delete'))
			{
				extract($_POST);
				$deleteFaqCategory=mysql_fetch_assoc($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$_GET['id']."'"));
				if($deleteFaqCategory['faqCategoryParentId']==0)
				{
					$con->delete("DELETE FROM faqquestionanswer WHERE faqCategoryParentId='".$_GET['id']."'");
					$con->delete("DELETE FROM faqcategory WHERE faqCategoryParentId='".$_GET['id']."'");
				}
				else
				{
					$con->delete("DELETE FROM faqquestionanswer WHERE faqCategoryId='".$_GET['id']."'");
				}
				
					$con->delete("DELETE FROM faqcategory WHERE faqCategoryId='".$_GET['id']."'");
				redirect(SITE_ADM."faq.php?msg=DELREC");	
			}
			// category delete code ends

	
	$content="faq";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>