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
			$uploaddir = DIR_IMG."site/projectImages/photos"; // jwg - correct typo
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
			
			$filename220_220=$img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;	
			$filename40_30=$img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;	
			$filename80_60=$img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename80_80=$img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename100_100=$img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
		
			/*$img->resizeImage($img->dir."/".$img->file_new_name,250,$filename220_380);
			$img->resizeImage($img->dir."/".$img->file_new_name,40,$filename40_30);*/	
			
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename220_220,220,220);
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename100_100,100,100);	
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename80_60,80,60);	
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename80_80,80,80);	
			$img->resizeImageNew($img->dir."/".$img->file_new_name,$filename40_30,40,30);	
									
			unlink($img->dir."/".$img->file_new_name);
			$filename220_220 = str_replace(DIR_FS,"",$filename220_220);
			$filename100_100 = str_replace(DIR_FS,"",$filename100_100);
			$filename80_60 = str_replace(DIR_FS,"",$filename80_60);
			$filename80_80 = str_replace(DIR_FS,"",$filename80_80);
			$filename40_30 = str_replace(DIR_FS,"",$filename40_30);
			$prodId = (isset($_POST) && (isset($_POST['proId']))) ? $_POST['proId'] : '';
			$now = time();
			$userId = (isset($_POST) && (isset($_POST['userId']))) ? $_POST['userId'] : '';
			$selectQuery = $con->recordselect("SELECT * from users where userId=".$userId);
			if(mysql_num_rows($selectQuery)>0)
			{
				$imageDetails = mysql_fetch_array($selectQuery);
				if (!empty($imageDetails['profilePicture'])) @unlink(DIR_FS.$imageDetails['profilePicture']);
				if (!empty($imageDetails['profilePicture40_40'])) @unlink(DIR_FS.$imageDetails['profilePicture40_40']);
				if (!empty($imageDetails['profilePicture80_60'])) @unlink(DIR_FS.$imageDetails['profilePicture80_60']);
				if (!empty($imageDetails['profilePicture80_80'])) @unlink(DIR_FS.$imageDetails['profilePicture80_80']);
				if (!empty($imageDetails['profilePicture100_100'])) @unlink(DIR_FS.$imageDetails['profilePicture100_100']);
			}			
			$update = "UPDATE users SET profilePicture='".$filename220_220."', profilePicture80_60='".$filename80_60."', profilePicture80_80='".$filename80_80."',
				 profilePicture100_100='".$filename100_100."', profilePicture40_40='".$filename40_30."' WHERE userId=".$userId. " LIMIT 1";
			$con->update($update);		
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