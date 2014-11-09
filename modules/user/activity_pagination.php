<?php 
	require_once("../../includes/config.php");
		
	// How many adjacent pages should be shown on each side?
	$adjacents = 1;
	if(isset($_GET['user']))
	{
	//$user='&user='.$_GET['user'];
	$user=$_GET['user'];
	}
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$total_pages = $total_count;
	/* Setup vars for query. */
	$targetpage = SITE_URL."profile"; 	//your file name  (the name of this file)
	$limit = 10; 								//how many items to show per page
	
	$page = (int) ($_GET['page']);
	
	$lastpage1 = ceil($total_pages/$limit);
	if($page > $lastpage1)
	{
		$page = 1;
	}
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
		
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	
	/* Setup page vars for display. */
	
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$activity_pagination = "";
	if($lastpage > 1)
	{	
		$activity_pagination .= "<ul>";
		
		//previous button
		if ($page > 1){
			$activity_pagination.= "<li><a href=\"$targetpage/$user/page/1/#a\">&lsaquo;&lsaquo;</a></li>";
			$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$prev/#a\">&lsaquo;</a></li>";
		}
		else{
			$activity_pagination.= "<li class=\"disabled\">&lsaquo;&lsaquo;</li>";		
			$activity_pagination.= "<li class=\"disabled\">&lsaquo;</li>";
		}
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$activity_pagination.= "<li class=\"current\">$counter</li>";
				else
					$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$counter/#a\">$counter</a></li>";
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$activity_pagination.= "<li class=\"current\">$counter</li>";
					else
						$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$counter/#a\">$counter</a></li>";
				}
				$activity_pagination.= "...";
				$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$lpm1/#a\">$lpm1</a></li>";
				
				$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$lastpage/#a\">$lastpage</a></li>";
				
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$activity_pagination.= "<li><a href=\"$targetpage/$user/page/1/#a\">1</a></li>";
				
				$activity_pagination.= "<li><a href=\"$targetpage/$user/page/2/#a\">2</a></li>";
				$activity_pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$activity_pagination.= "<li class=\"current\">$counter</li>";
					else
						$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$counter/#a\">$counter</a></li>";
				}
				$activity_pagination.= "...";
				$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$lpm1/#a\">$lpm1</a></li>";
				
				$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$lastpage/#a\">$lastpage</a></li>";
			}
			//close to end; only hide early pages
			else
			{
				$activity_pagination.= "<li><a href=\"$targetpage/$user/page/1/#a\">1</a></li>";
				
				$activity_pagination.= "<li><a href=\"$targetpage/$user/page/2/#a\">2</a></li>";
				$activity_pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$activity_pagination.= "<li class=\"current\">$counter</li>";
					else
						$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$counter/#a\">$counter</a></li>";
				}
			}
		}
		
		//next button
		if ($page < $counter - 1){
			$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$next/#a\">&rsaquo;</a></li>";
			$activity_pagination.= "<li><a href=\"$targetpage/$user/page/$lastpage/#a\">&rsaquo;&rsaquo;</a></li>";
		}
		else{
			$activity_pagination.= "<li class=\"disabled\">&rsaquo;</li>";
			$activity_pagination.= "<li class=\"disabled\">&rsaquo;&rsaquo;</li>";
		}

		$activity_pagination.= "</u>";		
	}
	
?>