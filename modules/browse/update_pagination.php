<?php 
	require_once("../../includes/config.php");
	//$tbl_name=$tbl_nm;		//your table name
	//$target_file = "browseproject/project/".$_GET['project'];
	//$target_page = $target_file;
	
	// How many adjacent pages should be shown on each side?
	$adjacents = 1;
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT count(*) as num FROM `projectupdate` WHERE projectId='".$_GET['project']."' ORDER BY updateTime DESC";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	//$targetpage = SITE_MOD."browse/browseproject.php?project=".$_GET['project'];
	$targetpage = SITE_URL."browseproject/".$_GET['project'];
	$limit = 5; 				//how many items to show per page
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
	
	$sql = "SELECT * FROM `projectupdate` WHERE projectId='".$_GET['project']."' ORDER BY updateTime DESC LIMIT  $start, $limit";
	$sel_updates = mysql_query($sql);
	
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
	$update_pagination = "";
	if($lastpage > 1)
	{
		$update_pagination .= "<ul>";
		//previous button
		if ($page > 1) {
			$update_pagination.= "<li><a href=\"$targetpage/page/1/#b\">&lsaquo;&lsaquo;</a></li>";
			$update_pagination.= "<li><a href=\"$targetpage/page/$prev/#b\">&lsaquo;</a></li>";
		}
		else {
			$update_pagination.= "<li class=\"disabled\">&lsaquo;&lsaquo; </li>";	
			$update_pagination.= "<li class=\"disabled\">&lsaquo; </li>";
		}
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$update_pagination.= "<li class=\"current\">$counter&nbsp;</li>";
				else
					$update_pagination.= "<li><a href=\"$targetpage/page/$counter/#b\">$counter&nbsp;</a></li>";					
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
						$update_pagination.= "<li class=\"current\">$counter</li>";
					else
						$update_pagination.= "<li><a href=\"$targetpage/page/$counter/#b\">$counter</a></li>";					
				}
				$update_pagination.= "...";
				$update_pagination.= "<li><a href=\"$targetpage/page/$lpm1/#b\">$lpm1</a></li>";
				$update_pagination.= "<li><a href=\"$targetpage/page/$lastpage/#b\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$update_pagination.= "<li><a href=\"$targetpage/page/1/#b\">1</a></li>";
				$update_pagination.= "<li><a href=\"$targetpage/page/2/#b\">2</a></li>";
				$update_pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$update_pagination.= "<li class=\"current\">$counter</li>";
					else
						$update_pagination.= "<li><a href=\"$targetpage/page/$counter/#b\">$counter</a></li>";					
				}
				$update_pagination.= "...";
				$update_pagination.= "<li><a href=\"$targetpage/page/$lpm1/#b\">$lpm1</a></li>";
				$update_pagination.= "<li><a href=\"$targetpage/page/$lastpage/#b\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$update_pagination.= "<li><a href=\"$targetpage/page/1/#b\">1</a></li>";
				$update_pagination.= "<li><a href=\"$targetpage/page/2/#b\">2</a></li>";
				$update_pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$update_pagination.= "<li class=\"current\">$counter</li>";
					else
						$update_pagination.= "<li><a href=\"$targetpage/page/$counter/#b\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$update_pagination.= "<li><a href=\"$targetpage/page/$next/#b\">&rsaquo;&rsaquo;</a></li>";
		else
			$update_pagination.= "<li class=\"disabled\">&rsaquo;&rsaquo;</li>";
		$update_pagination.= "</ul>";		
	}
?>