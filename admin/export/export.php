<?php
//documentation on the spreadsheet package is at:
//http://pear.php.net/manual/en/package.fileformats.spreadsheet-excel-writer.php

##########################################################
# Project :Fundraiser
# Developer : Drashti Nagrecha
# Date : 16th July 2014
###########################################################

chdir('phpxls');
require_once 'Writer.php';
chdir('..');
include('../../includes/config.php');
/*Display heading*/

$qury_lang=$con->recordselect("select * from projects as p, projectbasics as pbs, categories as cat, users as us where p.published=1 and p.accepted!=3 and p.projectId=pbs.projectId and pbs.projectCategory=cat.categoryId and p.userId=us.userId order by pbs.projectStart DESC");
$sheet1=array(array('Project Name','Project Category','Project Creator','Project Description','Project Location'));
$i=1;
while($fetch_Record= mysql_fetch_assoc($qury_lang))
{
	/*echo '<pre>';
	print_r($fetch_Record);
	echo '</pre>';*/
	$sheet3=array();
	array_push($sheet3,($fetch_Record["projectTitle"]));
	array_push($sheet3,($fetch_Record["categoryName"]));
	array_push($sheet3,($fetch_Record["name"]));
	array_push($sheet3,($fetch_Record["shortBlurb"]));
	array_push($sheet3,($fetch_Record["projectLocation"]));
	$sheet1[$i]=$sheet3;
	$i++;	
}
$workbook = new Spreadsheet_Excel_Writer();

$format_und =& $workbook->addFormat();
$format_und->setBottom(2);//thick
$format_und->setBold();
$format_und->setColor('black');
$format_und->setFontFamily('Arial');
$format_und->setSize(8);

$format_reg =& $workbook->addFormat();
$format_reg->setColor('black');
$format_reg->setFontFamily('Arial');
$format_reg->setSize(8);

$arr = array(
      'project_detail'=>$sheet1,
      );

foreach($arr as $wbname=>$rows)
{
    $rowcount = count($rows);
    $colcount = count($rows[0]);

    $worksheet =& $workbook->addWorksheet($wbname);

    $worksheet->setColumn(0,0, 6.14);//setColumn(startcol,endcol,float)
    $worksheet->setColumn(1,3,15.00);
    $worksheet->setColumn(4,4, 8.00);
    
    for( $j=0; $j<$rowcount; $j++ )
    {
        for($i=0; $i<$colcount;$i++)
        {
            $fmt  =& $format_reg;
            if ($j==0)
                $fmt =& $format_und;

            if (isset($rows[$j][$i]))
            {
                $data=$rows[$j][$i];
                $worksheet->write($j, $i, $data, $fmt);
            }
        }
    }
}

$workbook->send('project_detail.xls');
$workbook->close();

//-----------------------------------------------------------------------------
?>

