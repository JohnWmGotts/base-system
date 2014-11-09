<?php
	require_once('../includes/config.php');
	
/*function no_loop_combine($data1,$index)
{
    if($index == $data1)
    {
        return '';
    }
    else
    {
		$qry="INSERT INTO tamptbl (datetime) VALUES ('".date('Y-m-d H:i:s')."')";
		$result = mysql_query($qry);
        return no_loop_combine($data1,$index + 1);
    }
}
no_loop_combine(100,0);*/
//$arr=array(10);
$arr=array_fill(0,10,'Test');
echo '<br>'.$qry="INSERT INTO tamptbl (txtname) VALUES ('".implode("'),('",$arr)."')";	
$result = mysql_query($qry);
exit;	
if(isset($_POST['btnAdd']) && $_POST['btnAdd']!='') {
	$qry="INSERT INTO tamptbl (txtname) VALUES ('".implode("'),('",$_POST['txtname'])."')";	
	$result = mysql_query($qry);
	header("Location:test_db.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test INSERT</title>
</head>

<body>
<form name="frm" id="frm" method="post">
<?php for($i=0;$i<10;$i++) { ?>
<label for="txtname<?php echo $i;?>">Name<?php echo $i+1;?> :</label>
<input type="text" name="txtname[]" id="txtname<?php echo $i;?>" /><Br />
<?php } ?>
<input type="submit" value="Submit" name="btnAdd" />
</form>
</body>
</html>