<?php
class Upload
{
	var $img_name;	
	var $dir;
	var $dir_ok;
	var $max_filesize=1024;		
	var $error=0;
	var $error_message="";
	var $file_type;
	var $file_name="";
	var $file_size;
	var $file_new_prefix="";
	var $file_new_name="";
	var $file_exetension="jpg";
	
	function Upload()
	{
		
	}
	
	function UploadImageDimension($file,$w,$h)
	{
		$temparr=$this->Gen_File_Dimension($_FILES[$file]['tmp_name']);
		if($w>$temparr[0] or $h>$temparr[1])
		{
			$this->error_message="File Dimension should be ".$w." x ".$h;
			echo "<table width='100%' border=0>";
			echo "<tr>";
			echo "<td align='center' valgin=top height=230>&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td align='center' valgin=top>".$this->error_message."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td align='center' valgin=top><a href='add_photo.php'>back</a></td>";
			echo "</tr>";
			echo "</table>";
			exit;
		}
		else
		{
			
		}
	}
	
	function UploadImage($file)
	{
		$dir_ok=true;
		$this->file_name = strtolower($_FILES[$file]['name']);
		$this->file_type = strtolower(substr($this->file_name,strlen($this->file_name)-3));
        $this->dir;
		if(!file_exists($this->dir))
		{
			mkdir($this->dir);
			chmod($this->dir,0777);
		}
		if(!file_exists($this->dir))
		{
			$dir_ok=false;
		}
		if($dir_ok==true)
		{
			
			if(($_FILES[$file]['size']/1024)>$this->max_filesize)
			{
				$this->error_message="File Size Error. File Size should be below ".$this->max_filesize." Kbs";
				echo "<table width='100%' border=0>";
				echo "<tr>";
				echo "<td align='center' valgin=top height=230>&nbsp;</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td align='center' valgin=top>".$this->error_message."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td align='center' valgin=top><a href='#' onclick='javascript:history.back(-1);'>back</a></td>";
				echo "</tr>";
				echo "</table>";
				exit;
			}
			$this->Gen_Name();
			
			if(move_uploaded_file($_FILES[$file]['tmp_name'],$this->dir."/".$this->file_new_name))
			{
			}
		}
		else
		{
			$this->error_message="Directory Error. Cannot Create Directory ".$this->dir;
			echo "<table width='100%' border=0>";
			echo "<tr>";
			echo "<td align='center' valgin=top height=230>&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td align='center' valgin=top>".$this->error_message."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td align='center' valgin=top><a href='#' onclick='javascript:history.back(-1);'>back</a></td>";
			echo "</tr>";
			echo "</table>";
			exit;
		}	
	}
	
	function Gen_Name()
	{
		$this->file_new_name="";
		if($this->file_new_prefix!="")
		{
			$this->file_new_name=$this->file_new_prefix."_";	
		}
		$this->file_new_name.=rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".substr($this->file_name,strlen($this->file_name)-3);
	}
	
	function Gen_File_Dimension($temp_filename)
	{
		list($width, $height) = getimagesize($temp_filename);
		$rarr[0]=$width;
		$rarr[1]=$height;
		
		return $rarr;
	}
	
	function Gen_standard_Name($file_exetension)
	{
		$testfile_new_name="";
		if($this->file_new_prefix!="")
		{
			$testfile_new_name=$this->file_new_prefix."_";	
		}
		$testfile_new_name.=rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$file_exetension;
		return $testfile_new_name;
	}
	
	function Aspect_Size($width, $height, $target)
	{
		// USE :
		// $mysock = getimagesize("images/sock001.jpg");
		//<img src="images/sock001.jpg" Aspect_Size($mysock[0], $mysock[1], 150);
				
		//takes the larger size of the width and height and applies the  
		if($width>=$target and $height>=$target)
		{
			if($height==$width)
			{
				if($target>$width)
				{
					$ar=$width*100/$target;
				}
				else
				{
					$ar=$target*100/$width;
				}
				//$ar=$target*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;						
			}
			elseif($height>$width)
			{
				if($target>$height)
				{
					$ar=$height*100/$target;
				}
				else
				{
					$ar=$target*100/$height;
				}
				//$ar=$target*100/$height;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
			elseif($height<$width)
			{
				if($target>$width)
				{
					$ar=$width*100/$target;
				}
				else
				{
					$ar=$target*100/$width;
				}
				//$ar=$target*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
		}
		else
		{
			//$newwidth=$width;
			//$newheight=$height;
			if($height==$width)
			{
				if($target>$width)
				{
					$ar=$width*100/$target;
				}
				else
				{
					$ar=$target*100/$width;
				}
				$newwidth=($width*$ar)/100;
				$newheight=($height*$ar)/100;						
			}
			elseif($height>$width)
			{
				if($target>$height)
				{
					$ar=$height*100/$target;
				}
				else
				{
					$ar=$target*100/$height;
				}
				//$ar=$target*100/$height;
				$newwidth=($width*$ar)/100;
				$newheight=($height*$ar)/100;
			}
			elseif($height<$width)
			{
				if($target>$width)
				{
					$ar=$width*100/$target;
				}
				else
				{
					$ar=$target*100/$width;
				}
				//$ar=$target*100/$width;
				$newwidth=($width*$ar)/100;
				$newheight=($height*$ar)/100;
			}
		}
		
		//gets the new value and applies the percentage, then rounds the value 
		//$width = round($width * $percentage);
		//$height = round($height * $percentage);
		
		return "width=\"$newwidth\" height=\"$newheight\"";

	}	
	
	function resizeImage($filename,$max_width,$newfilename="",$max_height='',$withSampling=true) 
	{ 
		if($newfilename=="") 
			$newfilename=$filename; 
		// Get new sizes 
		list($width, $height) = getimagesize($filename); 
		
		if($width>=$max_width and $height>=$max_width)
		{
			if($height==$width)
			{
				if($max_width>$width)
				{
					$ar=$width*100/$max_width;
				}
				else
				{
					$ar=$max_width*100/$width;
				}
				//$ar=$max_width*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;						
			}
			elseif($height>$width)
			{
				if($max_width>$height)
				{
					$ar=$height*100/$max_width;
				}
				else
				{
					$ar=$max_width*100/$height;
				}
				//$ar=$max_width*100/$height;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
			elseif($height<$width)
			{
				if($max_width>$width)
				{
					$ar=$width*100/$max_width;
				}
				else
				{
					$ar=$max_width*100/$width;
				}
				//$ar=$max_width*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
		}
		else
		{
			if($height==$width)
			{
				if($max_width>$width)
				{
					$ar=$width*100/$max_width;
				}
				else
				{
					$ar=$max_width*100/$width;
				}
				//$ar=$max_width*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;						
			}
			elseif($height>$width)
			{
				if($max_width>$height)
				{
					$ar=$height*100/$max_width;
				}
				else
				{
					$ar=$max_width*100/$height;
				}
				//$ar=$max_width*100/$height;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
			elseif($height<$width)
			{
				if($max_width>$width)
				{
					$ar=$width*100/$max_width;
				}
				else
				{
					$ar=$max_width*100/$width;
				}
				//$ar=$max_width*100/$width;
				$newwidth=$width*$ar/100;
				$newheight=$height*$ar/100;
			}
			//$newwidth=$width;
			//$newheight=$height;
		}
		
		//-- dont resize if the width of the image is smaller or equal than the new size. 
		/*if($width<=$max_width) 
			$max_width=$width;
			
		$percent = $max_width/$width; 
		
		$newwidth = $width * $percent; 
		if($max_height=='') { 
			$newheight = $height * $percent;
		} else 
			$newheight = $max_height; */
		
		 // my changes
		/*$newwidth =150;
		$newheight =150;*/
		
		// Load 
		$thumb = imagecreatetruecolor($newwidth, $newheight); 
		$ext = strtolower(substr($filename,strlen($filename)-3)); 
		
		if($ext=='jpg' || $ext=='jpeg') 
			$source = imagecreatefromjpeg($filename); 
		if($ext=='gif') 
			$source = imagecreatefromgif($filename); 
		if($ext=='png') 
			$source = imagecreatefrompng($filename); 
		
		// Resize 
		if($withSampling) 
			imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		else    
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			
		// Output 
		if($ext=='jpg' || $ext=='jpeg') 
			return imagejpeg($thumb,$newfilename); 
		if($ext=='gif') 
			return imagegif($thumb,$newfilename); 
		if($ext=='png') 
			return imagepng($thumb,$newfilename); 
	} 
	
	function rotateImage($sourceFile,$destImageName,$degreeOfRotation)
	{
	  //function to rotate an image in PHP
	  //developed by Roshan Bhattara (http://roshanbh.com.np)
	
	  //get the detail of the image
	  $imageinfo=getimagesize($sourceFile);
	  switch($imageinfo['mime'])
	  {
	   //create the image according to the content type
	   case "image/jpg":
	   case "image/jpeg":
	   case "image/pjpeg": //for IE
			$src_img=imagecreatefromjpeg($sourceFile);
					break;
		case "image/gif":
			$src_img = imagecreatefromgif($sourceFile);
					break;
		case "image/png":
			case "image/x-png": //for IE
			$src_img = imagecreatefrompng($sourceFile);
					break;
	  }
	  //rotate the image according to the spcified degree
	  $src_img = imagerotate($src_img, $degreeOfRotation, 0);
	  //output the image to a file
	  imagejpeg ($src_img,$destImageName);
	}
	
	
function resizeImageNew($filename,$newfilename="",$max_width,$max_height='',$withSampling=true,$widthFlag=false) 
{
		if($newfilename=="") 
				$newfilename=$filename; 
	$image_info = getimagesize($filename);
     $image_ext = $image_info[2];
		// Get new sizes 
		list($width, $height) = getimagesize($filename); 
		//echo $width;
		//echo $height;
		if($widthFlag==true) {
			if($max_width>$width)
			{
				$ar=$width*100/$max_width;
			}
			else
			{
				$ar=$max_width*100/$width;
			}
			$newwidth=$width*$ar/100;
			$newheight=$height*$ar/100;	
		} else {
			if($width>=$max_width && $height>=$max_height)
			{
				if($height==$width)
				{
					if($max_width>$max_height) {
						if($max_height>$height)
						{
							$ar=$height*100/$max_height;
						}
						else
						{
							$ar=$max_height*100/$height;
						}
		
					} else {
						if($max_width>$width)
						{
							$ar=$width*100/$max_width;
						}
						else
						{
							$ar=$max_width*100/$width;
						}
					}
					$newwidth=$width*$ar/100;
					$newheight=$height*$ar/100;						
				}
				else
				{
					if($max_height>$height)
					{
						$ar=$height*100/$max_height;
					}
					else
					{
						$ar=$max_height*100/$height;
					}
					$newwidth=$width*$ar/100;
					$newheight=$height*$ar/100;
					if($newheight>$max_height || $newwidth>$max_width) {
						if($max_width>$width)
						{
							$ar=$width*100/$max_width;
						}
						else
						{
							$ar=$max_width*100/$width;
						}
						$newwidth=$width*$ar/100;
						$newheight=$height*$ar/100;
					}
				}
			}
			else
			{
				if($height==$width)
				{
					if($max_width>$max_height) {
						if($max_height>$height)
						{
							$ar=$height*100/$max_height;
						}
						else
						{
							$ar=$max_height*100/$height;
						}
		
					} else {
						if($max_width>$width)
						{
							$ar=$width*100/$max_width;
						}
						else
						{
							$ar=$max_width*100/$width;
						}
					}
					$newwidth=$width*$ar/100;
					$newheight=$height*$ar/100;						
				}
				else
				{				
					if($max_height>$height)
					{
						$ar=$height*100/$max_height;
					}
					else
					{
						$ar=$max_height*100/$height;
					}
					$newwidth=$width*$ar/100;
					$newheight=$height*$ar/100;
					if($newheight>$max_height || $newwidth>$max_width) {
						if($max_width>$width)
						{
							$ar=$width*100/$max_width;
						}
						else
						{
							$ar=$max_width*100/$width;
						}
						$newwidth=$width*$ar/100;
						$newheight=$height*$ar/100;
					}
				}
			}
		}
		
		$newwidth =round($newwidth);
		$newheight =round($newheight);
		
		// Load
		 if(  $image_ext == IMAGETYPE_JPEG ) { 
         $source = imagecreatefromjpeg($filename);
      } elseif(  $image_ext == IMAGETYPE_GIF ) { 
         $source = imagecreatefromgif($filename);
      } elseif(  $image_ext  == IMAGETYPE_PNG ) { 
         $source = imagecreatefrompng($filename);
      }
//echo '133=>thumb=>'.$thumb.' Source=>'. $source.' newwidth=>'.$newwidth.'newheight=>'. $newheight.' width=>'. $width.' height=>'. $height;
//exit;	
		$thumb = imagecreatetruecolor($newwidth, $newheight); 	
		// Resize 
		if($withSampling) 
			imagecopyresampled($thumb,  $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
		else    
			imagecopyresized($thumb,   $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
		
		$thumb = $thumb;
			
		// Output 
		if(  $image_ext  == IMAGETYPE_JPEG ) 
			return imagejpeg($thumb,$newfilename,75);
		if(  $image_ext  == IMAGETYPE_GIF ) 
			return imagegif($thumb,$newfilename); 
		 elseif(  $image_ext  == IMAGETYPE_PNG )
			return imagepng($thumb,$newfilename,9); 
	}
}
?>
