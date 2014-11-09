<? 
	mysql_connect("localhost","root",""); 
	mysql_select_db("beatbuggy");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Temp</title>
</head>

<body>
<?
	$qy="select id,username,the_pass from members LIMIT 0,20";
	$rs=mysql_query($qy);
	while($rsw=mysql_fetch_array($rs)){
		print "<br>".$rsw["id"]."&nbsp;&nbsp;&nbsp;&nbsp;".$rsw["username"]."&nbsp;&nbsp;&nbsp;&nbsp;".$rsw["the_pass"];
	}
?>
</body>
</html>
