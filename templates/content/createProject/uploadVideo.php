<?php
	/* Note: This thumbnail creation script requires the GD PHP Extension.  
		If GD is not installed correctly PHP does not render this page correctly
		and SWFUpload will get "stuck" never calling uploadSuccess or uploadError
	 */
require_once("../../../includes/config.php");
require_once("../../../includes/cimage.php");

ini_set('upload_max_filesize', '500M');
ini_set('post_max_size', '500M');
ini_set('memory_limit', '500M');
ini_set('max_input_time', 259200);
ini_set('max_execution_time', 259200);

if($_POST['userId']=='') {
	$_SESSION['msg'] = "Please login to start new project.";
	$_SESSION['RedirectUrl'] = get_url();
	header("location:".$login_url);
}
// Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
if (isset($_POST["PHPSESSID"])) {
	session_id($_POST["PHPSESSID"]);
}

//session_start();
// jwg
if (version_compare(phpversion(), '5.4.0', '<')) { 
	if(session_id() == '') session_start(); 
} else { 
	if (session_status() == PHP_SESSION_NONE) session_start(); 
}
	
ini_set("html_errors", "0");

$extension = "ffmpeg";
$extension_soname = $extension . "." . PHP_SHLIB_SUFFIX;
$extension_fullname = PHP_EXTENSION_DIR . "/" . $extension_soname;

// load extension
if (!extension_loaded($extension)) {
	wrtlog("AT uploadVideo line 34 - loading $extension_fullname");
	@dl($extension_soname) or die("Can't load extension $extension_fullname\n");
	wrtlog("At uploadVideo line 36");
}

/***********************************************************/
/*****************Get the path to Extention ****************/
$array_path = explode("/",$_SERVER['SCRIPT_FILENAME']);
$dynamic_path = "";

for ($i=0;$i<sizeof($array_path)-1;$i++) {
	if($array_path[$i]!="") {
		$dynamic_path =$dynamic_path."/".$array_path[$i];
	}
}

/**********************************************************/
/******************set folders*****************************/
$dynamic_path = substr($dynamic_path,1);
$flvpath = DIR_IMG."site/projectVideos/convertedVideo/";
$imagepath = DIR_IMG."site/projectImages/photos/";
$moviepath = DIR_IMG."site/projectVideos/originalVideo/";
/*********************************************************/
/******************Upload and convert video *****************************/
if(isset($_FILES["Filedata"])) {
	
	$fileName = $_FILES["Filedata"]["name"];
	$fileNameParts = explode( ".", $fileName );
	$fileExtension = end( $fileNameParts );
	$fileExtension = strtolower( $fileExtension );
	
	if($fileExtension=="avi" || $fileExtension=="wmv" || $fileExtension=="mpeg"  || $fileExtension=="mpg" || $fileExtension=="mov" ) {
		if ( move_uploaded_file($_FILES["Filedata"]["tmp_name"], $moviepath.$_FILES["Filedata"]["name"])) {
			$ext = 'flv';
			$projectVideo = rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$projVideo = "site/projectVideos/convertedVideo/".$projectVideo;
			$projectVideo =  $flvpath.$projectVideo;
			
			if( $fileExtension == "wmv" ) {
				//echo "/usr/lib/php5/20060613+lfs/ffmpeg -i ".$moviepath."".$fileName." -f flv -s 400x300 ".$projectVideo;
				//ffmpeg -i my-video.avi -f flv -b 768 -ar 22050 -ab 96 -s 720x576 my-video.flv
				$command = "/usr/lib/php5/20060613+lfs/ffmpeg -i ".$moviepath.$fileName." -f flv -b 768 -ar 22050 -ab 96 -s 400x300 ".$projectVideo;
				//exec($command);
				exec("ffmpeg -i ".$moviepath.$fileName." -ar 22050 -ab 32 -f flv -s 400x300 ".$projectVideo);
				//exec("/usr/lib/php5/20060613+lfs/ffmpeg -i ".$moviepath.$fileName." -f flv -s 400x300 ".$projectVideo);
				//exec("/usr/lib/php5/20060613+lfs/ffmpeg -i ".$moviepath.$fileName." -f flv -b 768 -ar 22050 -ab 96 -s 400x300 ".$projectVideo);
			}
			if( $fileExtension == "avi" || $fileExtension=="mpg" || $fileExtension=="mpeg" || $fileExtension=="mov" || $fileExtension=="flv") {
				//echo "ffmpeg -i ".$dynamic_path."/".$moviepath."".$fileName."  ".$dynamic_path."/".$flvpath."myflv.flv";
				//echo '<-->'."/usr/lib/php5/20060613+lfs/ffmpeg -i ".$moviepath."".$fileName."  ".$projectVideo;
				$command = "/usr/lib/php5/20060613+lfs/ffmpeg -i ".$moviepath.$fileName." -f flv -b 768 -ar 22050 -ab 96 -s 400x300 ".$projectVideo;
				//ffmpeg -i video.avi -ar 22050 -ab 32 -f flv -s 320×240 video.flv
				exec("ffmpeg -i ".$moviepath.$fileName." -ar 22050 -ab 32 -f flv -s 400x300 ".$projectVideo);
				//exec("/usr/lib/php5/20060613+lfs/ffmpeg -i ".$moviepath.$fileName." -f flv -b 768 -ar 22050 -ab 96 -s 400x300 ".$projectVideo);
				//exec("/usr/lib/php5/20060613+lfs/ffmpeg -i ".$moviepath.$fileName."  ".$projectVideo);
			}
			
			/******************create thumbnail***************/
			$ext = 'jpg';
			$filename700_370 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename640_480 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename340_250 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;	
			$filename223_169 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;	
			$filename200_156 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename100_80 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename65_50 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			$filename16_16 = $img->dir."/".rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;
			
			
			//exec("ffmpeg -y -i ".$moviepath."".$fileName."  ".$flvpath."myflv1.jpg");
			//ffmpeg -i foo.avi -r 1 -s WxH -f image2 foo-%03d.jpeg
			exec("ffmpeg -y -i ".$moviepath.$fileName." -r 1 -s 700x370 -f image2 ".$imagepath.$filename700_370);
			exec("ffmpeg -y -i ".$moviepath.$fileName." -r 1 -s 640x480 -f image2 ".$imagepath.$filename640_480);
			exec("ffmpeg -y -i ".$moviepath.$fileName." -r 1 -s 340x250 -f image2 ".$imagepath.$filename340_250);
			exec("ffmpeg -y -i ".$moviepath.$fileName." -r 1 -s 223x169 -f image2 ".$imagepath.$filename223_169);
			exec("ffmpeg -y -i ".$moviepath.$fileName." -r 1 -s 200x156 -f image2 ".$imagepath.$filename200_156);
			exec("ffmpeg -y -i ".$moviepath.$fileName." -r 1 -s 100x80 -f image2 ".$imagepath.$filename100_80);
			exec("ffmpeg -y -i ".$moviepath.$fileName." -r 1 -s 65x50 -f image2 ".$imagepath.$filename65_50);
			exec("ffmpeg -y -i ".$moviepath.$fileName." -r 1 -s 16x16 -f image2 ".$imagepath.$filename16_16);
			
			
			/*exec("ffmpeg -i ".$moviepath."".$fileName." -s 640x480 ".$imagepath."/".$filename100_80);
			exec("ffmpeg -i ".$moviepath."".$fileName." -s 400x300 ".$imagepath."/".$filename400_300);
			exec("ffmpeg -y -i ".$moviepath."".$fileName." -s 100x80 ".$imagepath."/".$filename640_480);*/
			
			$prodId = $_POST['proId'];
			$now = time();
			$userId = $_POST['userId'];
			$selectQuery = $con->recordselect("SELECT * from productimages where projectId=".$prodId. " AND isVideo=1");
			if(mysql_num_rows($selectQuery)>0) {
				$imageDetails = mysql_fetch_array($selectQuery);
				if (!empty($imageDetails['image700by370'])) @unlink(DIR_FS.$imageDetails['image700by370']);
				if (!empty($imageDetails['image640by480'])) @unlink(DIR_FS.$imageDetails['image640by480']);
				if (!empty($imageDetails['image340by250'])) @unlink(DIR_FS.$imageDetails['image340by250']);
				if (!empty($imageDetails['image100by80'])) @unlink(DIR_FS.$imageDetails['image100by80']);
				if (!empty($imageDetails['image16by16'])) @unlink(DIR_FS.$imageDetails['image16by16']);
				if (!empty($imageDetails['image65by50'])) @unlink(DIR_FS.$imageDetails['image65by50']);
				if (!empty($imageDetails['image200by156'])) @unlink(DIR_FS.$imageDetails['image200by156']);
				if (!empty($imageDetails['image223by169'])) @unlink(DIR_FS.$imageDetails['image223by169']);
				
				$filename700_370 = "images/site/projectImages/photos".$filename700_370;
				$filename640_480 = "images/site/projectImages/photos".$filename640_480;
				$filename340_250 = "images/site/projectImages/photos".$filename340_250;
				$filename223_169 = "images/site/projectImages/photos".$filename223_169;
				$filename200_156 = "images/site/projectImages/photos".$filename200_156;
				$filename100_80 = "images/site/projectImages/photos".$filename100_80;
				$filename65_50 = "images/site/projectImages/photos".$filename65_50;
				$filename16_16 = "images/site/projectImages/photos".$filename16_16;
				
				$update = "UPDATE productimages SET `image223by169`='".$filename223_169."' , `image200by156`='".$filename200_156."', `image700by370`='".$filename700_370."', `image640by480`='".$filename640_480."',
							`image340by250` ='".$filename340_250."' ,`image65by50` ='".$filename65_50."', `image100by80` = '".$filename100_80."' WHERE projectId=".$prodId. " AND isVideo=1 AND userId =". $userId;
				
				$con->update($update);
			}
			else
			{
				$filename700_370 = "images/site/projectImages/photos".$filename700_370;
				$filename640_480 = "images/site/projectImages/photos".$filename640_480;
				$filename340_250 = "images/site/projectImages/photos".$filename340_250;
				$filename223_169 = "images/site/projectImages/photos".$filename223_169;
				$filename200_156 = "images/site/projectImages/photos".$filename200_156;
				$filename100_80 = "images/site/projectImages/photos".$filename100_80;
				$filename65_50 = "images/site/projectImages/photos".$filename65_50;
				$filename16_16 = "images/site/projectImages/photos".$filename16_16;
				
				$ins = "INSERT INTO `productimages` (`image700by370` , `image640by480`, `image340by250`, `image223by169`,`image200by156`,`image65by50`,`projectId`, `approved`,`createTime`,`userId`,`isVideo`) 
				VALUES ('".$filename700_370."' , '".$filename640_480."' , '".$filename340_250."' , '".$filename223_169."' , '".$filename200_156."' , '".$filename65_50."' , ".$prodId.",1,".$now.",".$userId.",1)";
				
				$image_result = $con->insert($ins);				
				$con->add_file(8,'Project Images');
			}
			$selectQuery = $con->recordselect("SELECT * from projectstory where projectId=".$prodId);
			if(mysql_num_rows($selectQuery)>0)
			{
				$imageDetails = mysql_fetch_array($selectQuery);
				if(file_exists($imageDetails['projectVideo']))
				@unlink(DIR_FS.$imageDetails['projectVideo']);
			}
			$update = "update projectstory set projectVideo='".$projVideo."' where projectId=".$prodId. " LIMIT 1";
			$con->update($update);
		}
	
		else
		{
			die("The file was not uploaded");
		}
	
	}
	else
	{
		die("Please upload file only with avi, wmv, mov or mpg extension!");
	}
}
else
{
	die("File not found");
}
	echo "FILEID:".$base_url."".$filename100_480;// .$dynamic_path."/".$flvpath."myflv.jpg";	// Return the file id to the script
?>
