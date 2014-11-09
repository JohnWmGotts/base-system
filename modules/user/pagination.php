<?php 
	require_once("../../includes/config.php");
	//$tbl_name=$tbl_nm;		//your table name
	//$target_page = $target_file;
	
	// How many adjacent pages should be shown on each side?
	$adjacents = 1;
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	if(isset($_SESSION['userId']) && $_SESSION['userId']!='' && !isset($_GET['user']) || $_GET['user']=='' || $_SESSION['userId']==$_GET['user'])
	{
		$query = "SELECT COUNT(projectId) as num FROM `projects` WHERE `userId` ='".$_SESSION['userId']."'";
		$total_pages = mysql_fetch_array(mysql_query($query));
		$total_pages = $total_pages[num];
		$user=$_SESSION['userId'];
	}
	else
	{
		$query = "SELECT COUNT(projectId) as num FROM `projects` WHERE `userId` ='".$_GET['user']."' AND published=1 AND accepted=1";
		$total_pages = mysql_fetch_array(mysql_query($query));
		$total_pages = $total_pages[num];
		//$user='&user='.$_GET['user'];
		$user=$_GET['user'];
	}
	
	/* Setup vars for query. */
	//$targetpage = SITE_URL."profile"; 	//your file name  (the name of this file)
	if(isset($user)){
		$targetpage = SITE_URL."profile/".$user;
	}else{
		$targetpage = SITE_URL."profile";
	}
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
	if(isset($_SESSION['userId']) && $_SESSION['userId']!='' && !isset($_GET['user']) || $_GET['user']=='' || $_SESSION['userId']==$_GET['user'])
	{
		$sql = "SELECT * FROM `projects` WHERE `userId` ='".$_SESSION['userId']."' ORDER BY `projectId` DESC LIMIT  $start, $limit";
		$sel_created = mysql_query($sql);
	}
	else
	{
		$sql = "SELECT * FROM `projects` WHERE `userId` ='".$_GET['user']."' AND published=1 AND accepted=1 ORDER BY `projectId` DESC LIMIT  $start, $limit";
		$sel_created = mysql_query($sql);
	}
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
			$pagination.= "<li><a href=\"$targetpage/page/1/#b\">&lsaquo;&lsaquo;</a></li>";
			$pagination.= "<li><a href=\"$targetpage/page/$prev/#b\">&lsaquo;</a></li>";
		}
		else{
			$pagination.= "<li class=\"disabled\">&lsaquo;&lsaquo;</li>";		
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
					$pagination.= "<li><a href=\"$targetpage/page/$counter/#b\">$counter</a></li>";
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
						$pagination.= "<li><a href=\"$targetpage/page/$counter/#b\">$counter</a></li>";										
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$targetpage/page/$lpm1/#b\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage/page/$lastpage/#b\">$lastpage</a></li>";				
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"$targetpage/page/1/#b\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage/page/2/#b\">2</a></li>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"current\">$counter</li>";
					else
						$pagination.= "<li><a href=\"$targetpage/page/$counter/#b\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$targetpage/page/$lpm1/#b\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage/page/$lastpage/#b\">$lastpage</a></li>";				
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"$targetpage/page/1/#b\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage/page/2/#b\">2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"current\">$counter</li>";
					else
						$pagination.= "<li><a href=\"$targetpage/page/$counter/#b\">$counter</a></li>";
				}
			}
		}
		//next button
		if ($page < $counter - 1){
			$pagination.= "<li><a href=\"$targetpage/page/$next/#b\">&rsaquo;</a></li>";
			$pagination.= "<li><a href=\"$targetpage/page/$lastpage/#b\">&rsaquo;&rsaquo;</a></li>";
		}
		else{
			$pagination.= "<li class=\"disabled\">&rsaquo;</li>";
			$pagination.= "<li class=\"disabled\">&rsaquo;&rsaquo;</li>";
		}
		$pagination.= "</ul>";		
	}
?>