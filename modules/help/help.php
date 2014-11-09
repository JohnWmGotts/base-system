<?php
	require "../../includes/config.php";

	if(isset($_POST['queryString'])) 
	{
		//$queryString = preg_replace('/\s+/', '', $_POST['queryString']);
		$queryString=sanitize_string($_POST['queryString']);
		if(strlen($queryString) >0) 
		{
			
			$totalFaqQuestion = $con->recordselect("SELECT faqQuestion as value,faqCategoryParentId,faqCategoryId FROM faqquestionanswer WHERE faqQuestion LIKE '%$queryString%'");
			$total_faq_question=mysql_num_rows($totalFaqQuestion);
			//echo "SELECT faqque.faqQuestion as value,faqque.faqCategoryParentId,faqque.faqCategoryId,faqque.faqQuestionAnswerId,faqque.faqQuestionAnswerTime FROM `faqquestionanswer` as faqque, `faqcategory` as faqcat WHERE faqque.faqQuestion AND faqque.faqCategoryParentId=faqcat.faqCategoryId AND faqcat.faqStatus!='0' AND faqque.faqQuestion LIKE '%$queryString%' LIMIT 5";
			$query = $con->recordselect("SELECT faqque.faqQuestion as value,faqque.faqCategoryParentId,faqque.faqCategoryId,faqque.faqQuestionAnswerId,faqque.faqQuestionAnswerTime FROM `faqquestionanswer` as faqque, `faqcategory` as faqcat WHERE faqque.faqCategoryParentId=faqcat.faqCategoryId AND faqcat.faqStatus!='0' AND faqque.faqQuestion LIKE '%$queryString%' LIMIT 5");
			if(mysql_num_rows($query)>0) 
			{
				while ($result = mysql_fetch_assoc($query)) 
				{ 
					$main_cat = mysql_fetch_assoc($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$result['faqCategoryParentId']."'"));
					$sub_cat = mysql_fetch_assoc($con->recordselect("SELECT * FROM faqcategory WHERE faqCategoryId='".$result['faqCategoryId']."'"));
					
					echo '<li onclick="fill('.$main_cat['faqCategoryId'].','.addQuotes(Slug($result['value'])).');" class="">
							<h3 class="faq_questionlist">'.$result['value'].
							'</h3>
							<div class="faq-category">in '.$main_cat['faqcategoryName'].' / '.$sub_cat['faqcategoryName'].'</div>
						</li>';
				}
				echo '<a href="javascript:void(0)"><span class="faq-icon-arrow-search"></span> see all '. $total_faq_question .' results </a>';
			} 
			else 
			{
				echo 'Sorry, we couldn\'t find anything.';
			}
		} 
		else 
		{
		}
	
	} 
?>