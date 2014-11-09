<?php 
	require_once("../../includes/config.php");
	//$tbl_name=$tbl_nm;		//your table name
	//$target_page = $target_file2;
	
	// How many adjacent pages should be shown on each side?
	$adjacents = 1;
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	if(!isset($_GET['user']) && $_GET['user']=='')
	{
		$count_backedproject="SELECT  COUNT(DISTINCT `projectId`) as num1 FROM `projectbacking` WHERE `userId` ='".$_SESSION['userId']."'";
		$target_page = SITE_URL."profile/".$_SESSION['userId'];
	}
	else
	{
		$count_backedproject="SELECT  COUNT(DISTINCT `projectId`) as num1 FROM `projectbacking` WHERE `userId` ='".$_GET['user']."'";
		$target_page = SITE_URL."profile/".$_GET['user'];
	}
	$total_pages = mysql_fetch_assoc(mysql_query($count_backedproject));
	$total_pages = $total_pages[num1];
	
	/* Setup vars for query. */
	$targetpage = $target_page; 	//your file name  (the name of this file)
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
	$backedproject_pagination = "";
	if($lastpage > 1)
	{	
		$backedproject_pagination .= "<ul>";
		
		//previous button
		if ($page > 1){
			$backedproject_pagination.= "<li><a href=\"$targetpage/page/1/#c\">&lsaquo;&lsaquo;</a></li>";
			$backedproject_pagination.= "<li><a href=\"$targetpage/page/$prev/#c\">&lsaquo;</a></li>";
		}
		else{
			$backedproject_pagination.= "<li class=\"disabled\">&lsaquo;&lsaquo;</li>";	
			$backedproject_pagination.= "<li class=\"disabled\">&lsaquo;</li>";	
		}
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$backedproject_pagination.= "<li class=\"current\">$counter&nbsp;</li>";
				else
					$backedproject_pagination.= "<li><a href=\"$targetpage/page/$counter/#c\">$counter</a></li>";										
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
						$backedproject_pagination.= "<li class=\"current\">$counter</li>";
					else
						$backedproject_pagination.= "<li><a href=\"$targetpage/page/$counter/#c\">$counter</a></li>";					
				}
				$backedproject_pagination.= "...";
				$backedproject_pagination.= "<li><a href=\"$targetpage/page/$lpm1/#c\">$lpm1</a></li>";
				$backedproject_pagination.= "<li><a href=\"$targetpage/page/$lastpage/#c\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$backedproject_pagination.= "<li><a href=\"$targetpage/page/1/#c\">1</a></li>";
				$backedproject_pagination.= "<li><a href=\"$targetpage/page/2/#c\">2</a></li>";
				$backedproject_pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$backedproject_pagination.= "<li class=\"current\">$counter</li>";
					else
						$backedproject_pagination.= "<li><a href=\"$targetpage/page/$counter/#c\">$counter</a></li>";					
				}
				$backedproject_pagination.= "...";
				$backedproject_pagination.= "<li><a href=\"$targetpage/page/$lpm1/#c\">$lpm1</a><li>";
				$backedproject_pagination.= "<li><a href=\"$targetpage/page/$lastpage/#c\">$lastpage</a></li>";
			}
			//close to end; only hide early pages
			else
			{
				$backedproject_pagination.= "<li><a href=\"$targetpage/page/1/#c\">1</a></li>";
				$backedproject_pagination.= "<li><a href=\"$targetpage/page/2/#c\">2</a></li>";
				$backedproject_pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$backedproject_pagination.= "<li class=\"current\">$counter</li>";
					else
						$backedproject_pagination.= "<li><a href=\"$targetpage/page/$counter/#c\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) {
			$backedproject_pagination.= "<li><a href=\"$targetpage/page/$next/#c\">&rsaquo;</a></li>";
			$backedproject_pagination.= "<li><a href=\"$targetpage/page/$lastpage/#c\">&rsaquo;&rsaquo;</a></li>";
		}
		else{
			$backedproject_pagination.= "<li class=\"disabled\">&rsaquo;</li>";
			$backedproject_pagination.= "<li class=\"disabled\">&rsaquo;&rsaquo;</li>";
		}
		
		$backedproject_pagination.= "</ul>";		
	}
?>