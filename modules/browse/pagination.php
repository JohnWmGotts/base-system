<?php 
	require_once("../../includes/config.php");
	//$tbl_name=$tbl_nm;
	//your table name
	//$target_file = "browseproject.php?project=".$_GET['project'];
	//$target_page = $target_file;
	
	// How many adjacent pages should be shown on each side?
	$adjacents = 1;
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(DISTINCT `userId`) as num FROM `projectbacking` WHERE `projectId` = '".$_GET['project']."'";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	
	$targetpage = SITE_URL."browseproject/".$_GET['project']; 	//your file name  (the name of this file)
	$limit = 5; 								//how many items to show per page
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
	$sql = "SELECT DISTINCT `userId` FROM `projectbacking` WHERE `projectId` = '".$_GET['project']."' LIMIT  $start, $limit";
	$sel_backeruser = mysql_query($sql);
	
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
	$pagination = "";
	if($lastpage > 1)
	{
		$pagination .= "<ul>";
		//previous button
		if ($page > 1){ 
			$pagination.= "<li><a href=\"$targetpage/page/1/#c\">&lsaquo;&lsaquo; </a></li>";
			$pagination.= "<li><a href=\"$targetpage/page/$prev/#c\">&lsaquo; </a></li>";
		}
		else{
			$pagination.= "<li class=\"disabled\">&lsaquo;&lsaquo; </li>";
			$pagination.= "<li class=\"disabled\">&lsaquo;</li>";
		}
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class=\"current\">$counter</li>";
				else
					$pagination.= "<li><a href=\"$targetpage/page/$counter/#c\">$counter</a></li>";
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
						$pagination.= "<li class=\"current\">$counter</li>";
					else
						$pagination.= "<li><a href=\"$targetpage/page/$counter/#c\">$counter</a></li>";
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$targetpage/page/$lpm1/#c\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage/page/$lastpage/#c\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"$targetpage/page/1/#c\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage/page/2/#c\">2</a></li>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"current\">$counter</li>";
					else
						$pagination.= "<li><a href=\"$targetpage/page/$counter/#c\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$targetpage/page/$lpm1/#c\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage/page/$lastpage/#c\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"$targetpage/page/1/#c\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage/page/2/#c\">2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"current\">$counter</li>";
					else
						$pagination.= "<li><a href=\"$targetpage/page/$counter/#c\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1){ 
			$pagination.= "<li><a href=\"$targetpage&page=$next#c\">&rsaquo;</a></li>";
			$pagination.= "<li><a href=\"$targetpage&page=$next#c\">&rsaquo;&rsaquo;</a></li>";
		}
		else{
			$pagination.= "<li class=\"disabled\">&rsaquo;</li>";
			$pagination.= "<li class=\"disabled\">&rsaquo;&rsaquo;</li>";
		}
		$pagination.= "</ul>";		
	}
?>