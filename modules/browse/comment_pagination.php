<?php 
	require_once("../../includes/config.php");
		
	// How many adjacent pages should be shown on each side?
	$adjacents = 1;
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(DISTINCT `commentId`) as num FROM `projectcomments` WHERE `projectId` = ".$_GET['project']." ORDER BY `commentTime` DESC";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	//$targetpage = SITE_MOD."browse/browseproject.php?project=".$_GET['project'];
	$targetpage = SITE_URL."browseproject/".$_GET['project'];
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
	$sql = "SELECT * FROM `projectcomments` WHERE `projectId` = ".$_GET['project']." ORDER BY `commentTime` DESC LIMIT  $start, $limit";
	$sel_usercomment = mysql_query($sql);
	
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
	$comment_pagination = "";
	if($lastpage > 1)
	{	
		
		$comment_pagination .= "<ul>";
		//previous button
		if ($page > 1){ 
			$comment_pagination.= "<li><a href=\"$targetpage/page/1/#d\">&lsaquo;&lsaquo; </a></li>";
			$comment_pagination.= "<li><a href=\"$targetpage/page/$prev/#d\">&lsaquo; </a></li>";
		}
		else{
			$comment_pagination.= "<li class=\"disabled\">&lsaquo;&lsaquo; </li>";
			$comment_pagination.= "<li class=\"disabled\">&lsaquo;</li>";
		}
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$comment_pagination.= "<li class=\"current\">$counter</li>";
				else
					$comment_pagination.= "<li><a href=\"$targetpage/page/$counter/#d\">$counter</a></li>";
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
						$comment_pagination.= "<li class=\"current\">$counter</li>";
					else
						$comment_pagination.= "<li><a href=\"$targetpage/page/$counter/#d\">$counter</a></li>";
				}
				$comment_pagination.= "...";
				$comment_pagination.= "<li><a href=\"$targetpage/page/$lpm1/#d\">$lpm1</a></li>";
				$comment_pagination.= "<li><a href=\"$targetpage/page/$lastpage/#d\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$comment_pagination.= "<li><a href=\"$targetpage/page/1/#d\">1</a></li>";
				$comment_pagination.= "<li><a href=\"$targetpage/page/2/#d\">2</a></li>";
				$comment_pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$comment_pagination.= "<li class=\"current\">$counter</li>";
					else
						$comment_pagination.= "<li><a href=\"$targetpage/page/$counter/#d\">$counter</a></li>";					
				}
				$comment_pagination.= "...";
				$comment_pagination.= "<li><a href=\"$targetpage/page/$lpm1/#d\">$lpm1</a></li>";
				$comment_pagination.= "<li><a href=\"$targetpage/page/$lastpage/#d\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$comment_pagination.= "<li><a href=\"$targetpage/page/1/#d\">1</a></li>";
				$comment_pagination.= "<li><a href=\"$targetpage/page/2/#d\">2</a></li>";
				$comment_pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$comment_pagination.= "<li class=\"current\">$counter</li>";
					else
						$comment_pagination.= "<li><a href=\"$targetpage/page/$counter/#d\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1){ 
			$comment_pagination.= "<li><a href=\"$targetpage/page/$next/#d\">&rsaquo;</a></li>";
			$comment_pagination.= "<li><a href=\"$targetpage/page/$next/#d\">&rsaquo;&rsaquo;</a></li>";
		}
		else{
			$comment_pagination.= "<li class=\"disabled\">&rsaquo;</li>";
			$comment_pagination.= "<li class=\"disabled\">&rsaquo;&rsaquo;</li>";
		}
		$comment_pagination.= "</ul>";		
	}
?>