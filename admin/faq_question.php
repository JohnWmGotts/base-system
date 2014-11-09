<?php
	require_once("../includes/config.php");
	$pagetitle="FAQ Question";
	require_once(DIR_FUN.'validation.class.php');
		
	if($_SESSION["admin_user"]=="")
	{
		redirect(SITE_ADM."login.php");
	}
	if($_SESSION["admin_role"]==1)
	{
		redirect(SITE_ADM."home.php");
	}
		
if(isset($_POST['action']) && ($_POST['action']=='add' || $_POST['action']=='edit'))
{
	extract($_POST);
	$obj = new validation();		
	$obj->add_fields($faqQuestion, 'req', 'Please Enter Question');
	$obj->add_fields($faqAnswer, 'req', 'Please Enter Answer');
	$error = $obj->validate();
	if($error=='')
	{
		// question add edit code start
		if($_POST['action']=='add')
		{
			extract($_POST);
			$cur_time=time();
			$sel_faq_questionanswer=$con->recordselect("SELECT * FROM faqquestionanswer WHERE faqQuestion = '".sanitize_string($faqQuestion)."'");
			if(mysql_num_rows($sel_faq_questionanswer)>0)
			{
				redirect(SITE_ADM."faq_question.php?msg=ALREADYADD");	
			}else{
				$con->insert("INSERT INTO faqquestionanswer (`faqQuestionAnswerId`, `faqCategoryParentId`, `faqCategoryId`, `faqQuestion`, `faqAnswer`, `faqQuestionStatus`, faqQuestionAnswerTime) VALUES 
					(NULL, '$drop_1', '$tier_two', '".sanitize_string($faqQuestion)."', '".sanitize_string($faqAnswer)."', '1', '$cur_time')");
				redirect(SITE_ADM."faq_question.php?msg=ADDREC");
			}
		}
		if($_POST['action']=='edit')
		{
			extract($_POST);		
			$con->update("UPDATE faqquestionanswer SET faqCategoryParentId='$drop_1', faqCategoryId='$tier_two', faqQuestion='".sanitize_string($faqQuestion)."', faqAnswer='".sanitize_string($faqAnswer)."' WHERE faqQuestionAnswerId='".$_POST['faqQuestionAnswerId']."'");
			redirect(SITE_ADM."faq_question.php?msg=EDITREC");
		}
		
	}
	
}
	if(isset($_GET['action']) && $_GET['action']=='edit')
		{
			$sel_faq_questionanswer=mysql_fetch_array($con->recordselect("SELECT * FROM faqquestionanswer WHERE faqQuestionAnswerId='".$_GET['id']."'"));		
			$sel_faq_sub_cat1=mysql_fetch_array($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$sel_faq_questionanswer['faqCategoryId']."'"));		
			
			$sel_faq_main_cat1=mysql_fetch_array($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$sel_faq_questionanswer['faqCategoryParentId']."'"));		
			
			$sel_qry_sel123456=mysql_fetch_assoc(mysql_query("SELECT *
												FROM  faqquestionanswer AS fqa, faqcategory AS fq
												WHERE fqa.faqQuestionAnswerId ='".$_GET['id']."'
												AND fq.faqCategoryId = fqa.faqCategoryId"));
			
		}
	// question add edit code ends
		
	// question delete code start
	if(isset($_GET['action']) && $_GET['action']=='delete') 
	{	
		
		
			$con->delete("DELETE FROM faqquestionanswer WHERE faqQuestionAnswerId ='".$_GET['id']."'");
			redirect(SITE_ADM."faq_question.php?msg=DELREC");

	}
	// question delete code end
	
	//select query code start
	/*$sqlQuery = "SELECT * FROM faqquestionanswer";
	$sel_faq_question = $con->select($sqlQuery,$page,$perpage,15,2,0);*/
		//$sel_faq_question=$con->recordselect("SELECT * FROM faqquestionanswer");		
	
	//select query code end
	$sel_faq_question=$con->recordselect("SELECT * FROM faqquestionanswer ORDER BY `faqQuestionAnswerId` DESC ");
	
	$content="faq_question";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>