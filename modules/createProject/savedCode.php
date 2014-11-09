<?php							
						// this code was attempted to be used in /modules/createProject/updateProject.php
						// to obtain and save an image associated with a youtube video.
						// But, only a partial image was able to be pulled from youtube -- 
						// So, we do not attempt to retrieve and store the image .. only save its remote url
						// in a new field of projectStory for use where needed in presentation to user/owner
						
						if (preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/watch\?v=((?:[a-zA-Z0-9._]|-)+)(?:\&|$)/i',$videourl,$match) ||				
							preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/(?:user\/)?(?:[a-z0-9\_\#\/]|-)*\/[a-z0-9]*\/[a-z0-9]*\/((?:[a-z0-9._]|-)+)(?:[\&\?\w;=\+_\#\%]|-)*/i',$videourl,$match) ||
							preg_match('/https?:\/\/[a-z0-9]*\.?youtube\.[a-z]*\/embed\/((?:[a-z0-9._]|-)+)(?:\?|$)/i',$videourl,$match)) {	  	

							$videoId = $match[1];
							$imageurl = 'https://img.youtube.com/vi/'.$videoId.'/0.jpg';
							//$thumburl = 'https://img.youtube.com/vi/'.$videoId.'/2.jpg';
							// don't override to embed format here .. do it where video will be used
							//$videourl = 'https://www.youtube.com/embed/'.$videoId; // override to acceptable format 
						
						
							$ext = 'jpg';
														
							##-- Get Image file --##
							$uploaddir = DIR_FS.'images/site/projectImages/photos';
							$fp = fopen($fileurl, "r");
							$imageFile = fread ($fp, 3000000);
							fclose($fp);
							##-- Create a temporary file on disk --##
							$tmpfname = rand(10000000,99999999)."_".rand(10000000,99999999)."_".rand(10000000,99999999).".".$ext;

							##-- Put image data into the temp file --##
							$fp = fopen($uploaddir."/".$tmpfname, "w");
							fwrite($fp, $imageFile);
							fclose($fp);

							require_once DIR_FS.'includes/cimage.php';
							$img=new Upload();
							$img->dir=$uploaddir;				
							$img->file_exetension = 'jpg';
							$img->file_new_name=$tmpfname;

							$temparr=$img->Gen_File_Dimension($img->dir."/".$img->file_new_name);
							$widthfull=$temparr[0];
							$heightfull=$temparr[1];	

							$ext = 'jpg';
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
								
							##-- Delete Temporary File --##
							unlink($tmpfname);

							$selectQuery = $con->recordselect("SELECT * from productimages where projectId=".$prodId. " AND isVideo=1");
							if(mysql_num_rows($selectQuery)>0) {
									$imageDetails = mysql_fetch_array($selectQuery);
									if (!empty($selProjectimgDelete['image700by370'])) @unlink(DIR_FS.$imageDetails['image700by370']);
									if (!empty($selProjectimgDelete['image640by480'])) @unlink(DIR_FS.$imageDetails['image640by480']);
									if (!empty($selProjectimgDelete['image340by250'])) @unlink(DIR_FS.$imageDetails['image340by250']);
									if (!empty($selProjectimgDelete['image100by80'])) @unlink(DIR_FS.$imageDetails['image100by80']);
									if (!empty($selProjectimgDelete['image16by16'])) @unlink(DIR_FS.$imageDetails['image16by16']);
									if (!empty($selProjectimgDelete['image65by50'])) @unlink(DIR_FS.$imageDetails['image65by50']);
									if (!empty($selProjectimgDelete['image200by156'])) @unlink(DIR_FS.$imageDetails['image200by156']);
									if (!empty($selProjectimgDelete['image223by169'])) @unlink(DIR_FS.$imageDetails['image223by169']);

									$filename700_370 = str_replace(DIR_FS,'',$filename700_370);
									$filename640_480 = str_replace(DIR_FS,'',$filename640_480);
									$filename340_250 = str_replace(DIR_FS,'',$filename340_250);
									$filename223_169 = str_replace(DIR_FS,'',$filename223_169);
									$filename200_156 = str_replace(DIR_FS,'',$filename200_156);
									$filename100_80 = str_replace(DIR_FS,'',$filename100_80);
									$filename65_50 = str_replace(DIR_FS,'',$filename65_50);
									$filename16_16 = str_replace(DIR_FS,'',$filename16_16);
									$update = "UPDATE productimages SET `image223by169`='".$filename223_169."' , `image200by156`='".$filename200_156."', `image700by370`='".$filename700_370."', `image640by480`='".$filename640_480."',
												`image340by250` ='".$filename340_250."' ,`image65by50` ='".$filename65_50."', `image100by80` = '".$filename100_80."' WHERE projectId=".$prodId. " AND isVideo=1 AND userId =". $userId;
									
									$con->update($update);
							}
								else
							{

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
						}