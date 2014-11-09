<?php
	/* Note: This thumbnail creation script requires the GD PHP Extension.  
		If GD is not installed correctly PHP does not render this page correctly
		and SWFUpload will get "stuck" never calling uploadSuccess or uploadError
	 */
require_once("../../../includes/config.php");
require_once("../../../includes/cimage.php");
	if($_POST['userId']=='')
	{
		$_SESSION['msg'] = "Please login to start new project.";
		$_SESSION['RedirectUrl'] = get_url();
		header("location:".$login_url);
	}
	// Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}

	//session_start(); // jwg fixup
	if (version_compare(phpversion(), '5.4.0', '<')) { if(session_id() == '') session_start(); } 
	else { if (session_status() == PHP_SESSION_NONE) session_start(); }
	
	ini_set("html_errors", "0");

	// Check the upload
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
		echo "ERROR:invalid upload";
		exit(0);
	}

	// Get the image and create a thumbnail
	//$img = @imagecreatefromjpeg($_FILES["Filedata"]["tmp_name"]);
	// jwg fix
	$imgfile = $_FILES["Filedata"]["tmp_name"];
	list($width_orig, $height_orig, $image_type) = getimagesize($imgfile);		
	switch ($image_type) {
		        case 1: $img = imagecreatefromgif($imgfile); break;
		        case 2: $img = imagecreatefromjpeg($imgfile);  break;
		        case 3: $img = imagecreatefrompng($imgfile); break;
		        default:  $img = false;
	}

	if (!$img) {
		echo "ERROR:could not create image handle ". $_FILES["Filedata"]["tmp_name"];
		exit(0);
	}

	$width = imageSX($img);
	$height = imageSY($img);

	if (!$width || !$height) {
		echo "ERROR:Invalid width or height";
		exit(0);
	}

	// Build the thumbnail
	$target_width = 200;
	$target_height = 150;
	$target_ratio = $target_width / $target_height;

	$img_ratio = $width / $height;

	if ($target_ratio > $img_ratio) {
		$new_height = $target_height;
		$new_width = $img_ratio * $target_height;
	} else {
		$new_height = $target_width / $img_ratio;
		$new_width = $target_width;
	}

	if ($new_height > $target_height) {
		$new_height = $target_height;
	}
	if ($new_width > $target_width) {
		$new_height = $target_width;
	}

	$new_img = ImageCreateTrueColor(200, 150);
	if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, 0)) {	// Fill the image black
		echo "ERROR:Could not fill new image";
		exit(0);
	}

	if (!@imagecopyresampled($new_img, $img, ($target_width-$new_width)/2, ($target_height-$new_height)/2, 0, 0, $new_width, $new_height, $width, $height)) {
		echo "ERROR:Could not resize image";
		exit(0);
	}

	if (!isset($_SESSION["file_info"])) {
		$_SESSION["file_info"] = array();
	}
function save($path) {    
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }
	// Use a output buffering to load the image into a variable
	ob_start();
	imagejpeg($new_img);
	$imagevariable = ob_get_contents();
	ob_end_clean();
	$pathinfo = pathinfo($_FILES["Filedata"]["tmp_name"]);
        $filename = $_FILES["Filedata"]["name"];//$pathinfo['filename'];
        //$filename = md5(uniqid());		
        $ext = substr(strrchr($filename, '.'), 1);
	 $qy3="SELECT * FROM photo_dir where dir_type='Project Images'";	
		//image_upload code starts here.	
		$rs3=mysql_query($qy3);
		$uploaddir = DIR_IMG."site/projectImages/photos";
		if(mysql_num_rows($rs3)>0)
		{
			while($rsw3=mysql_fetch_array($rs3))
			{
				$rsw3["files"];
				if($rsw3["files"]>=620)
				{
					$n=1;
					$n=$rsw3["no"]+1;
					mkdir("photos".$n,0770);
					$sql="update photo_dir set currentdir='photos".$n."',files=0,no=".$n." where dir_type='project Images'";					
					mysql_query($sql);				
					$uploaddir =DIR_IMG."site/projectImages/photos".$n;
				}
				else
				{
					$uploaddir = DIR_IMG."site/projectImages/".$rsw3["currentdir"];
				}	
			}
		}
		else
		{
			$uploaddir = DIR_IMG."site/projectImage/photos";
			$sql="insert into photo_dir(currentdir,files,no,dir_type) values('".$uploaddir."',0,0,'Project Images')";
			mysql_query($sql);
		}
		$uploadDirectory = $uploaddir;		
		$img=new Upload();
		$img->dir=$uploaddir;
		//$img->file_new_prefix=$ext;
		$img->file_exetension = $ext;
		$img->file_new_name=$filename;
		$tempPath = $_FILES['Filedata']['tmp_name'];		
		 if (move_uploaded_file($tempPath,$uploadDirectory ."/". $filename)){
            //return array('success'=>true);
			$flag = 1;
        } else {
			$flag=0;
            
        }			
		if($flag==1)
		{
			$temparr=$img->Gen_File_Dimension($img->dir."/".$img->file_new_name);
			$widthfull=$temparr[0];
			$heightfull=$temparr[1];		
			
			$filename700_370 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename640_480 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename340_250 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;	
			$filename223_169 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;	
			$filename200_156 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename100_80 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename65_50 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename16_16 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename700_370,700,370);
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename640_480,640,480);
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename340_250,340,250);
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename223_169,223,169);
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename200_156,200,156);
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename100_80,100,80);
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename65_50,65,50);
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename16_16,16,16);
			
						
			unlink($img->dir."/".$img->file_new_name);
			$filename700_370 = str_replace(DIR_FS,"",$filename700_370);
			$filename640_480 = str_replace(DIR_FS,"",$filename640_480);
			$filename340_250 = str_replace(DIR_FS,"",$filename340_250);
			$filename223_169 = str_replace(DIR_FS,"",$filename223_169);
			$filename200_156 = str_replace(DIR_FS,"",$filename200_156);
			$filename100_80 = str_replace(DIR_FS,"",$filename100_80);
			$filename65_50 = str_replace(DIR_FS,"",$filename65_50);
			$filename16_16 = str_replace(DIR_FS,"",$filename16_16);
			
			if(isset($_POST['proId'])){
				$prodId =$_POST['proId'];	
			}else if(isset($_SESSION['projectId'])){
				$prodId = $_SESSION['projectId'];	
			}
			//$prodId = $_POST['proId'];
			//$prodId = $_SESSION['projectId'];
			$now = time();
			$userId = $_POST['userId'];
			$selectQuery = $con->recordselect("SELECT * from productimages where projectId=".$prodId);
			if(mysql_num_rows($selectQuery)>0)
			{
				$imageDetails = mysql_fetch_array($selectQuery);
				if (!empty($imageDetails['image700by370'])) @unlink(DIR_FS.$imageDetails['image700by370']);
				if (!empty($imageDetails['image640by480'])) @unlink(DIR_FS.$imageDetails['image640by480']);
				if (!empty($imageDetails['image340by250'])) @unlink(DIR_FS.$imageDetails['image340by250']);
				if (!empty($imageDetails['image223by169'])) @unlink(DIR_FS.$imageDetails['image223by169']);
				if (!empty($imageDetails['image200by156'])) @unlink(DIR_FS.$imageDetails['image200by156']);
				if (!empty($imageDetails['image100by80'])) @unlink(DIR_FS.$imageDetails['image100by80']);
				if (!empty($imageDetails['image65by50'])) @unlink(DIR_FS.$imageDetails['image65by50']);
				if (!empty($imageDetails['image16by16'])) @unlink(DIR_FS.$imageDetails['image16by16']);
				
							
				$update = "UPDATE productimages SET `image700by370`='".$filename700_370."' , `image640by480`='".$filename640_480."' , `image200by156`='".$filename200_156."', `image223by169`='".$filename223_169."' ,
							`image340by250` ='".$filename340_250."',`image65by50` ='".$filename65_50."', `image100by80` = '".$filename100_80."' WHERE projectId=".$prodId. " AND isVideo=0 AND userId =". $userId;			
				
				$con->update($update);
			}
			else
			{
				$ins = "INSERT INTO `productimages` (`image700by370` , `image640by480`, `image340by250`, `image223by169` , `image200by156`, `image100by80` ,`image65by50`, `projectId`, `approved`,`createTime`,`userId`,`isVideo`) 
				VALUES ('".$filename700_370."' , '".$filename640_480."' , '".$filename340_250."' , '".$filename223_169."' , '".$filename200_156."' , '".$filename100_80."' , '".$filename65_50."' , ".$prodId.",1,".$now.",".$userId.",0)";
				$image_result = $con->insert($ins);				
				$con->add_file(1,'Project Images');		
			}
					
			//return array('success'=>true);
		}
	$file_id = md5($_FILES["Filedata"]["tmp_name"] + rand()*100000);
	
	// ADD TMP START
	/*define('DIR_FS',$_SERVER['DOCUMENT_ROOT'].'/test/SWFUpload2201/demos/applicationdemo/upload/');
	//define('DIR_FS',$_SERVER['DOCUMENT_ROOT'].'/kobragaming/test/SWFUpload2201/demos/applicationdemo/upload/');
	$file_temp_name=$file_id.'.jpg';
	if(move_uploaded_file($_FILES["Filedata"]["tmp_name"],DIR_FS.$file_temp_name)){
		$_SESSION['category_temp_img']=$file_temp_name;
	}*/
	// ADD TMP END
	$_SESSION["file_info"][$file_id] = $imagevariable;

	echo "FILEID:" . $file_id;	// Return the file id to the script
	
?>