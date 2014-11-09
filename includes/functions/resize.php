<?php
//a resize script
$width=(isset($_GET['w']))?$_GET['w']:0;
$height=(isset($_GET['h']))?$_GET['h']:0;
$ffile=(isset($_GET['f']))?$_GET['f']:"";

// Content type
header('(anti-spam-content-type:) image/jpeg');

// Get new dimensions
list($widthorig, $heightorig) = getimagesize($ffile);
if(!$width && !height){
 $width=$widthorig;
 $height=$heightorig;
}
if($width && !$height){
 $width=($width > $widthorig) ? $widthorig : $width;
 $height =($width > $widthorig) ? $heightorig : ($heightorig / $widthorig) * $width;
}
if($height && !$width){
 $height=($height > $heightorig) ? $heightorig : $height;
 $width = ($height > $heightorig) ? $widthorig : ($widthorig / $heightorig) * $height;
}
  $extn=explode(".",$ffile);
  $i=count($extn);
  $ext=strtolower($extn[$i-1]);

// Resample
$imagep = imagecreatetruecolor($width, $height);
  if($ext=="jpg")$image=imagecreatefromjpeg($ffile);
  if($ext=="png")$image=imagecreatefrompng($ffile);
  if($ext=="gif")$image=imagecreatefromgif($ffile);
imagecopyresampled($imagep, $image, 0, 0, 0, 0, $width, $height, $widthorig, $heightorig);

// Output
imagejpeg($imagep, null, 100);
?>