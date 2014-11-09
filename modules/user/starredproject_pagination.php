<?php 
	require_once("../../includes/config.php");
	//$tbl_name=$tbl_nm;		//your table name
	//$target_page = $target_file2;
	
	// How many adjacent pages should be shown on each side?
	$adjacents = 1;
		
	/* First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	
	//$query = "SELECT COUNT(DISTINCT `projectId`) as num FROM `projectbacking` WHERE `projectId` = '".$_GET['project']."'";
	if(!isset($_GET['user']) && $_GET['user']=='')
	{
		$count_starredproject="SELECT  COUNT(`projectremindId`) as num1 FROM `projectremind` WHERE `userId` ='".$_SESSION['userId']."'";
		$target_page = SITE_URL."profile/".$_SESSION['userId'];
	}
	else
	{
		$count_starredproject="SELECT  COUNT(`projectremindId`) as num1 FROM `projectremind` WHERE `userId` ='".$_GET['user']."'";
		$target_page = SITE_URL."profile/".$_GET['user'];
	}
	$total_pages = mysql_fetch_assoc(mysql_query($count_starredproject));
	$total_pages = $total_pages[num1];
	
	/* Setup vars for query. */
	$targetpage = $target_page; 	//your file name  (the name of this file)
	$limitpro = 10; 								//how many items to show per page
	$page = (int) ($_GET['pages']);
	$lastpage1 = ceil($total_pages/$limitpro);
	if($page > $lastpage1)
	{
		$page = 1;
	}
	if($page) 
		$startpro = ($page - 1) * $limitpro; 			//first item to display on this page
	else
		$startpro = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	
	//$sql = "SELECT DISTINCT `userId` FROM `projectbacking` WHERE `projectId` = '".$_GET['project']."' LIMIT  $startpro, $limitpro";
	//$sel_backeruser = mysql_query($sql);
	
	/* Setup page vars for display. */
	
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limitpro);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$starredproject_pagination = "";
	if($lastpage > 1)
	{	
		$starredproject_pagination .= "<ul>";
				
		//previous button
		if ($page > 1){
			$starredproject_pagination.= "<li><a href=\"$targetpage/pages/1/#d\">&lsaquo;&lsaquo;</a></li>";
			$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$prev/#d\">&lsaquo;</a></li>";
		}
		else{
			$starredproject_pagination.= "<li class=\"disabled\">&lsaquo;&lsaquo;</li>";	
			$starredproject_pagination.= "<li class=\"disabled\">&lsaquo;</li>";	
		}
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$starredproject_pagination.= "<li class=\"current\">$counter</li>";
				else
					$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$counter/#d\">$counter</a></li>";				
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
						$starredproject_pagination.= "<li class=\"current\">$counter</li>";
					else
						$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$counter/#d\">$counter</a></li>";					
				}
				$starredproject_pagination.= "...";
				$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$lpm1/#d\">$lpm1</a></li>";
				$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$lastpage/#d\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$starredproject_pagination.= "<li><a href=\"$targetpage/pages/1/#d\">1</a></li>";
				$starredproject_pagination.= "<li><a href=\"$targetpage/pages/2/#d\">2</a></li>";
				$starredproject_pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$starredproject_pagination.= "<li class=\"current\">$counter</li>";
					else
						$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$counter/#d\">$counter</a></li>";					
				}
				$starredproject_pagination.= "...";
				$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$lpm1/#d\">$lpm1</a></li>";
				$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$lastpage/#d\">$lastpage</a></li>";
			}
			//close to end; only hide early pages
			else
			{
				$starredproject_pagination.= "<li><a href=\"$targetpage/pages/1/#d\">1</a></li>";
				$starredproject_pagination.= "<li><a href=\"$targetpage/pages/2/#d\">2</a></li>";
				$starredproject_pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$starredproject_pagination.= "<li class=\"current\">$counter</li>";
					else
						$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$counter/#d\">$counter</a></li>";
				}
			}
		}
		
		//next button
		if ($page < $counter - 1){
			$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$next/#d\">&rsaquo;</a></li>";
			$starredproject_pagination.= "<li><a href=\"$targetpage/pages/$lastpage/#d\">&rsaquo;&rsaquo;</a></li>";
		}
		else{
			$starredproject_pagination.= "<li class=\"disabled\">&rsaquo;</li>";
			$starredproject_pagination.= "<li class=\"disabled\">&rsaquo;&rsaquo;</li>";
		}
		$starredproject_pagination.= "</ul>";		
	}
?>