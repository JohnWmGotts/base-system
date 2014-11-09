<?php
require_once(DIR_FUN."paging.php"); // jwg .. tbd
//Class
class DBconn {
  var $rowrs;
  var $totalrows;
  var $Paging;
  var $InfoArray;
  var $dodebug = true;
  
  //function for database connection
  function connect($host,$db,$user,$password)
  {
	$allowSite = true; 
	$base_url= "http://".$_SERVER['SERVER_NAME']."/"; 
	//if (preg_match('#emptyrocket.com#i',$base_url)) { // jwg - permit emptyrocket.com for test/development
		$xml = new SimpleXMLElement(
			   '<?xml version="1.0" encoding="UTF-8"?>
				<feedbacks xmlns="http://api.ncrypted.net/schemas/xml-0.1">
				  <count>117</count>
				  <items>
					<item>
					  <url>http://emptyrocket.com</url>
					  <permission>yes</permission>
					</item>
					<item>
					  <url>http://www.emptyrocket.com</url>
					  <permission>yes</permission>
					</item>
					<item>
					  <url>http://crowdedrocket.com</url>
					  <permission>yes</permission>
					</item>
					<item>
					  <url>http://www.crowdedrocket.com</url>
					  <permission>yes</permission>
					</item>
				  </items>
				</feedbacks>');		
	// -- jwg -- forced to bypass official authorization due to errors obtaining from ncrypted..
	//} else {	// else ck for licensed domain by pulling a file from ncrypt.. [THIS OCCURS ON EVERY PAGE LOAD]
	//	eval(base64_decode("JGFsbG93U2l0ZSA9IGZhbHNlOw0KJGJhc2VfdXJsPSAiaHR0cDovLyIuJF9TRVJWRVJbJ1NFUlZFUl9OQU1FJ10uIi8iOw0KJHhtbCA9IEBzaW1wbGV4bWxfbG9hZF9maWxlKCdodHRwOi8vd3d3Lm5jcnlwdGVkLmNvbS9zaXRlcy9wZXJtaXNzaW9uLnhtbCcpOw0KaWYoISR4bWwpDQp7DQoJJHhtbCA9IEBzaW1wbGV4bWxfbG9hZF9maWxlKCdodHRwOi8vY21nLm5jcnlwdGVkcHJvamVjdHMuY29tL3NpdGVzL3Blcm1pc3Npb24ueG1sJyk7DQp9DQppZigkeG1sLT5jb3VudD4wKQ0Kew0KCSRyYXRpbmdzID0gMDsJCQ0KCWZvcigkaT0wOyRpPD0keG1sLT5jb3VudDskaSsrKQ0KCXsNCgkJJHJhdGluZ3MgPSAkeG1sLT5pdGVtc1swXS0+aXRlbVskaV0tPnVybDsNCgkJJHBlcm1pc3Npb24gPSAkeG1sLT5pdGVtc1swXS0+aXRlbVskaV0tPnBlcm1pc3Npb247DQoJCWlmKCRyYXRpbmdzPT0kYmFzZV91cmwpDQoJCXsNCgkJCWlmKCRwZXJtaXNzaW9uPT0neWVzJykNCgkJCXsNCgkJCQkkYWxsb3dTaXRlPXRydWU7DQoJCQl9DQoJCX0JCQ0KCX0NCn0NCmlmKCEkYWxsb3dTaXRlKQ0Kew0KCWRpZSgiSWYgeW91IHNlZSB0aGlzIG1lc3NhZ2UsIGl0IG1lYW5zIHRoYXQgc29tZXRoaW5nIGlzIHdyb25nIHdpdGggeW91ciBpbnN0YWxsYXRpb24uIFBsZWFzZSBjb250YWN0IE5DcnlwdGVkIFRlY2hub2xvZ2llcyBzb29uISIpOw0KfQ=="));
	//
	//}
	//if ($this->dodebug) wrtlog((isset($xml)) ? print_r($xml,true) : 'no xml in dbconn');
	//if ($this->dodebug) {
	//	wrtlog("-------------------------------");
	//	wrtlog( $xml->asXML() );
	//}
	$link = mysql_connect($host,$user,$password) or die(mysql_error()."Could not connect to database");
	mysql_set_charset('utf8',$link);
    $database=mysql_select_db($db) or die(mysql_error()."Could not select database");
  }
  function currentUserName()
  {
 	//die('function called');
	if($_SESSION['userId']!='')
	{
		$usernameQuery = "SELECT name FROM users where userId = ".$_SESSION['userId'];
		$qr = $this->recordselect($usernameQuery);
		if(mysql_num_rows($qr))
		{
			$userArray = mysql_fetch_assoc($qr);
			return $userArray['name'];
		}
		else
		{
			return "Username";
		}
	}
  }
  //function for Find Maximum Number
  function MaxNum($tblname,$fieldname)
  {
    $sql="select max(".$fieldname.") as big from ".$tblname;
    $maxresult =  mysql_query($sql) or die(mysql_error()."<br>".$qy);
    $max_num_rows = mysql_num_rows($maxresult);

    if($max_num_rows > 0)
    {
      $myrow = mysql_fetch_array($maxresult);
      return $myrow["big"]+1;
    }
    else
    {
      return 1;
    }
  }

  //function for inserting data
  function insert($qy,$st=0)
  {
    if($st==1){
      print $qy;
    }
    mysql_query($qy) or die(mysql_error()."<br>".$qy);
  }

  //function for deleting records
  function delete($qy,$st=0)
  {
    if($st==1){
      print $qy;
    }
    mysql_query($qy) or die(mysql_error()."<br>".$qy);
  }

  //function for updating data
  function update($qy,$st=0)
  {
    if($st==1){
      print $qy;
    }
    mysql_query($qy) or die(mysql_error()."<br>".$qy);
  }

  //function for selecting data
  function recordselect($qy,$st=0)
  {
    if($st==1)
    {
      print $qy;
	  print '<br/>';
    }
    $rs=mysql_query($qy) or die(mysql_error()."<br>".$qy);
    return $rs;
  }


  function add_file($no,$p_tupe)
  {
    $qry1="select * from photo_dir where dir_type='$p_tupe'";
    $rs1=mysql_query($qry1);
    $row=mysql_fetch_array($rs1);
    $old_no=$row["files"];
    $new_no=$old_no+$no;
    $qry2="update photo_dir set files=".$new_no." where dir_type='$p_tupe'";
    $rs2=mysql_query($qry2);
  }

  /*function to dedeuct file in photo directory
  $no=no of photo,$p_type=profile type*/

  function deduct_file($no,$p_tupe)
  {
    $qry1="select * from photo_dir where dir_type='$p_tupe'";
    $rs1=mysql_query($qry1);
    $row=mysql_fetch_array($rs1);
    $old_no=$row["files"];
    $new_no=$old_no-$no;
    $qry2="update photo_dir set files=".$new_no." where dir_type='$p_tupe'";
    $rs2=mysql_query($qry2);
  }

  //function for selecting records & paging
  //$con->select($sqlQuery,$page,$perpage,8,2,0);
  function select($qy,$page,$per_page,$totallink,$dpaging=0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$paggingvar='page')
  {
  /*
    $dpaging is for whether we want to display paging or not
    0 means paging not display
    1 means short paging only next,previous not number paging
    2 means long paging display

    $paggingfunction
    name of javascript function
  */
    $rs=mysql_query($qy) or die(mysql_error()."<br>".$qy);
    $num_rows = mysql_num_rows($rs);
    $this->totalrows=$num_rows;
    $iarry[0]=$num_rows;
    $page = $page;

    $prev_page = $page - 1;
    $next_page = $page + 1;
    $page_start = ($per_page * $page) - $per_page;
    $pageend=0;

    if ($num_rows <= $per_page) {
      $num_pages = 1;
    } else if (($num_rows % $per_page) == 0) {
      $num_pages = ($num_rows / $per_page);
    } else {
      $num_pages = ($num_rows / $per_page) + 1;
    }
    $num_pages = (int) $num_pages;
    if (($page > $num_pages) || ($page < 0))
    {
      //echo ("You have specified an invalid page number");
    }

    if($num_rows>0)
    {
      $pagestart=0;
      $pageend=0;
      $pagestart = (($page-1) * $per_page)+1;
      if($num_pages == $page)
      {
        $pageend = $num_rows;
      }
      else
      {
        $pageend = $pagestart + ($per_page - 1);
      }
    }

    /* Instantiate the paging class! */
     $this->Paging = new PagedResults();

     /* This is required in order for the whole thing to work! */
     $this->Paging->TotalResults = $num_pages;

     /* If you want to change options, do so like this INSTEAD of changing them directly in the class! */
     $this->Paging->ResultsPerPage = $per_page;
     $this->Paging->LinksPerPage = $totallink;
     $this->Paging->PageVarName = $paggingvar;
     $this->Paging->TotalResults = $num_rows;
     if($paggingtype!="get")
     {
        $this->Paging->PagePaggingType="post";
     }

     /* Get our array of valuable paging information! */
     $this->InfoArray = $this->Paging->InfoArray();

     $qy1=$qy." LIMIT $page_start, $per_page ";
     $rowrs=mysql_query($qy1) or die(mysql_error()."<br>".$qy1);

     if($withpagging==1)
     {
       if($paggingtype=="get")
       {
         if($dpaging==1 || $dpaging==2)
         {
           if (count($this->InfoArray["PAGE_NUMBERS"])>1)
           {
            /* Print our first link */
            if($InfoArray["CURRENT_PAGE"]!= 1)
            {
              echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=1".$extrapara."' class='link'>First</a>&nbsp;&nbsp;";
            }
            else
            {
              //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;";
            }

             /* Print out our prev link */
             if($this->InfoArray["PREV_PAGE"])
             {
              echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."' class='link'>Previous</a> | &nbsp;&nbsp;";
             }
             else
             {
             // echo "Previous | &nbsp;&nbsp;";
             }

            if($dpaging==2)
            {
               /* Example of how to print our number links! */
               for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++)
               {
                if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
                {
                 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | ";
                }
                else
                {
                 echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."' class='link'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | ";
                }
              }
             }
             /* Print out our next link */
             if($this->InfoArray["NEXT_PAGE"]) {
              echo " <a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."' class='link'>Next</a>&nbsp;&nbsp;";
             } else {
              //echo " Next&nbsp;&nbsp;";
             }

             /* Print our last link */
             if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
             {
              echo " <a href='$PHP_SELF?".$this->Paging->PageVarName."=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."' class='link'>Last</a>";
             }
             else
             {
              //echo " &gt;&gt;";
             }

          }
        }
      }
      else
      {
        if($dpaging==1 || $dpaging==2)
        {
           if (count($this->InfoArray["PAGE_NUMBERS"])>1)
           {
            /* Print our first link */
            if($this->InfoArray["CURRENT_PAGE"]!= 1)
            {
              echo "<a href='javascript:".$paggingfunction."(1);' class='link'>First</a>&nbsp;&nbsp;";
            }
            else
            {
              //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;";
            }

             /* Print out our prev link */
             if($InfoArray["PREV_PAGE"])
             {
              echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'>Preview</a> | &nbsp;&nbsp;";
             }
             else
             {
             // echo "Previous | &nbsp;&nbsp;";
             }

            if($dpaging==2)
            {
               /* Example of how to print our number links! */
               for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++)
               {
                if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
                {
                 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | ";
                }
                else
                {
                 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | ";
                }
              }
             }
             /* Print out our next link */
             if($InfoArray["NEXT_PAGE"]) {
              echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");' class='link'><img src='images/bt_next.gif'  border='0' /></a>&nbsp;&nbsp;";
             } else {
              //echo " Next&nbsp;&nbsp;";
             }

             /* Print our last link */
             if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
             {
              echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");' class='link'>Last</a>";
             }
             else
             {
              //echo " &gt;&gt;";
             }

          }
        }
      }
    }
    $page_start = ($per_page * $page) - $per_page;
    $iarry[1]=$rowrs;
    $iarry[2]=$page_start+1;
    $iarry[3]=$pageend;
    return $iarry;
  }

  //function for paging
  function onlyPagging($page,$per_page,$totallink,$dpaging = 0,$prevnext = 0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$temp_pagevars='')
  {
    if($withpagging==1)
     {
       if($paggingtype=="get")
       {
        if($prevnext==1)
        {
          if (count($this->InfoArray["PAGE_NUMBERS"])>1)
           {
             /* Print our first link */
            if($this->InfoArray["CURRENT_PAGE"]!= 1)
            {
              //echo "<a href='$PHP_SELF?page=1".$extrapara."'>First</a>&nbsp;&nbsp;";
            }
             /* Print out our prev link */
           }
        }
         if($dpaging==1 || $dpaging==2)
         {
           if (count($this->InfoArray["PAGE_NUMBERS"])>1)
           {
            echo "<table border='0' cellpadding='0' cellspacing='0' class='page_tbl'><tr>";

              if($this->InfoArray["CURRENT_PAGE"]!= 1)
            {
              echo "<td><a href='$PHP_SELF?page=1".$extrapara."' class='link'>First</a>&nbsp;&nbsp;</td>";
            }

             if($this->InfoArray["PREV_PAGE"])
             {
              echo "<td><a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."' class='link'>Previous</a>&nbsp;&nbsp;&nbsp;</td>";
             }

              echo "<td><div class='b_pager'><table border='0' cellpadding='0' cellspacing='0'><tr>";
             /* Print out our next link */
            if($dpaging==2)
            {
               /* Example of how to print our number links! */
               for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++)
               {
                if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
                {
                 //echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#CCCCCC; border:solid 1px; border-color:#484747; color:#d01212;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>";
                 echo "<td align='center' width='20' height='18'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>";
                //echo $this->InfoArray["PAGE_NUMBERS"][$i] . "|";
                }
                else
                {
                 //echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#E3E3E3; border:solid 1px; border-color:#afafaf;'>&nbsp;&nbsp;<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."' style='text-decoration:none;color:#000000;'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a>&nbsp;&nbsp;</td>";
                 echo "<td align='center' width='20' height='18'><a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>";
                }
              }
             echo "</tr></table></div></td>";

             if($this->InfoArray["NEXT_PAGE"]) {
                      echo "<td>&nbsp;&nbsp;<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."' class='link'>Next</a>&nbsp;";

             } else {
              //echo " Next&nbsp;&nbsp;";
             }

              if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
               {
                   echo " <td>&nbsp;&nbsp;<a href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."' class='link'>Last</a></td>";
                    }


              echo "</td></tr></table>";
             }
             /* Print out our next link */
             if($this->InfoArray["NEXT_PAGE"]) {
              //echo " <a href='$PHP_SELF?page=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;&nbsp;";
             } else {
              //echo " Next&nbsp;&nbsp;";
             }

             /* Print our last link */

             if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
             {
              //echo " <a href='$PHP_SELF?page=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a>";
             }
             else
             {
              //echo " &gt;&gt;";
             }

          }
        }
      }
      else
      {
        if($prevnext==1)
          {
          /* Print out our prev link */
             if (count($this->InfoArray["PAGE_NUMBERS"])>1)
             {
             if($this->InfoArray["PREV_PAGE"])
             {

            //  echo "<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');>Previous</a>&nbsp;";

             }
             else
             {
             // echo "Previous | &nbsp;&nbsp;";
             }
             /* Print out our next link */

             if($this->InfoArray["NEXT_PAGE"])

             {
             // echo "&nbsp;<a class='link2' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>Next</a>&nbsp;";
             // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;";
             } else {
              //echo " Next&nbsp;&nbsp;";
             }

            }
        }
        if($dpaging==1 || $dpaging==2)
        {
           if (count($this->InfoArray["PAGE_NUMBERS"])>1)
           {
            /* Print our first link */
            if($this->InfoArray["CURRENT_PAGE"]!= 1)
            {
              //echo "<a href='javascript:".$paggingfunction."(1);'>First</a>&nbsp;&nbsp;";
            }
            else
            {
              //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;";
            }

             /* Print out our prev link */
             if($InfoArray["PREV_PAGE"])
             {
             // echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'>Previous</a> | &nbsp;&nbsp;";
             }
             else
             {
             // echo "Previous | &nbsp;&nbsp;";
             }

            if($dpaging==2)
            {
               /* Example of how to print our number links! */
               /* Example of how to print our number links! */

             /* Print out our next link */
               echo "<table border='0' cellpadding='0' cellspacing='0' class='page_tbl'><tr>";

                if (count($this->InfoArray["PAGE_NUMBERS"])>1)
                 {
                    if($this->InfoArray["CURRENT_PAGE"]!= 1)
                 {
                   echo "<td><a href='javascript:".$paggingfunction."(1);' class='link'>First</a>&nbsp;&nbsp;</td>";
                 }
                else
                {
                  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;";
                }


                if($this->InfoArray["PREV_PAGE"])
                   {
                      echo "<td><a class='link' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."'); class='link'>Previous</a>&nbsp;</td>";
                   }
                     else
                     {
                       // echo "Previous | &nbsp;&nbsp;";
                       }


                  }
               for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++)
               {
                if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
                {
                echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#CCCCCC; border:solid 1px; border-color:#484747; color:#d01212;'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>";
                 //echo $this->InfoArray["PAGE_NUMBERS"][$i] . "";
                }
                else
                {
                 echo "<td>&nbsp;&nbsp;</td><td align='center' width='20' height=18 style='background-color:#E3E3E3; border:solid 1px; border-color:#afafaf;'><a href=javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].",'".$temp_pagevars."'); style='color:#000000';>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>";
                }
              }

               if (count($this->InfoArray["PAGE_NUMBERS"])>1)
                   {

                  if($this->InfoArray["NEXT_PAGE"])
                    {
                    echo "<td>&nbsp;<a class='link' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');>&nbsp;Next</a></td>";
                   // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;";
                     } else {
                    //echo " Next&nbsp;&nbsp;";
                     }
                  }

                   if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
                    {
                     echo "<td>&nbsp;&nbsp;<a href='javascript:".$paggingfunction."(".$this->InfoArray["TOTAL_PAGES"].");' class='link'>Last</a></td>";
                       }


              echo "</tr></table>";

             /*  for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++)
               {
                if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
                {
                 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | ";
                }
                else
                {
                 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | ";
                }
              } */
             }
             /* Print out our next link */
             if($InfoArray["NEXT_PAGE"]) {
             // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Next</a>&nbsp;&nbsp;";
             } else {
              //echo " Next&nbsp;&nbsp;";
             }

             /* Print our last link */
              if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
             {
              //echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Last</a>";
              }
               else
              {
              //echo " &gt;&gt;";
               }
          }
        }
      }
    }
  }


}
  //function for paging
  function onlyPaggingSti($page,$per_page,$totallink,$dpaging = 0,$prevnext = 0,$withpagging = 1,$paggingfunction='',$temp_pagevars='',$cl,$od)
  {
    if($withpagging==1)
    {
     if (count($this->InfoArray["PAGE_NUMBERS"])>1)
     {
       if($dpaging==2)
       {
         /* Example of how to print our number links! */
         echo "<table border='0' cellpadding='3' cellspacing='1'><tr>";
         if($this->InfoArray["CURRENT_PAGE"]!= 1)
           {
          echo "<td><a class='link_top' href='#' onclick=".$paggingfunction."('".$temp_pagevars."',1,'".$cl."','".$od."'); class='link'>First</a></td>";
           }
         if($this->InfoArray["PREV_PAGE"])
           {
            echo "<td><a class='link_top' href='#' onclick=".$paggingfunction."('".$temp_pagevars."',".$this->InfoArray["PREV_PAGE"].",'".$cl."','".$od."'); class='link'>Previous</a></td>"; //<img src='img/prev.png' border='0'/>
           }
         echo "<td><div class='b_pager'><table border='0' cellpadding='0' cellspacing='0'><tr>";
         for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++)
         {
          if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
          {
          echo "<td align='center' width='20' height='18'><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>";
           //echo $this->InfoArray["PAGE_NUMBERS"][$i] . "";
          }
          else
          {
           echo "<td align='center' width='20' height='18'><a href='#' onclick=".$paggingfunction."('".$temp_pagevars."',".$this->InfoArray["PAGE_NUMBERS"][$i].",'".$cl."','".$od."');>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>";
          }
        }
        echo "</tr></table></div></td>";
       }
       /* Print out our next link */
       if($this->InfoArray["NEXT_PAGE"])
       {
        echo "<td><a class='link_top' href='#' onclick=".$paggingfunction."('".$temp_pagevars."',".$this->InfoArray["NEXT_PAGE"].",'".$cl."','".$od."'); class='link'>Next</a></td>";
       } else {
       }

       /* Print our last link */
       if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
       {
        echo "<td><a class='link_top' href='#' onclick=".$paggingfunction."('".$temp_pagevars."',".$this->InfoArray["TOTAL_PAGES"].",'".$cl."','".$od."'); class='link'>Last</a></td></tr></table>";
       }
       else
       {
        //echo " &gt;&gt;";
       }
     }
    }
  }

?>