<?php
// Get IP Address
function get_ip_address() {
	foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
		if (array_key_exists($key, $_SERVER) === true) {
			foreach (explode(',', $_SERVER[$key]) as $ip) {
				if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
					return $ip;
				}
			}
		}
	}
}

// Redirect Page 
function redirectPage($url) {
	if($url=='')
		$url=SITE_URL;
	header("Location:".$url);
}

// Get CMS related information of module & page wise
function getCmsArray($module,$page) {
	$con=new DBconn();
	if($page=='') {
		$module='home';
		$page='index';
	}
	$array=array();
	$desc_fl='';
	if($module=='cms')
		$desc_fl=',description';
	$qry="SELECT title,meta_author,meta_keyword,meta_desc".$desc_fl." FROM content WHERE module='".$module."' AND page='".$page."' AND status=1";
	$res=$con->recordselect($qry);
	if(mysql_num_rows($res)==1) {
		$row=mysql_fetch_array($res);
		$array['title']=stripslashes($row['title']);
		if($module=='cms')
			$array['description']=stripslashes($row['description']);
		$array['meta_author']=stripslashes($row['meta_author']);
		$array['meta_keyword']=stripslashes($row['meta_keyword']);
		$array['meta_desc']=stripslashes($row['meta_desc']);
	}
	else {
		$array['title']='Welcome to NCrypted';
		$array['meta_author']='';
		$array['meta_keyword']='';
		$array['meta_desc']='';
	}
	return $array;
}

// Display Page Drop Down
function dispPageDropDown($label,$ppage) {
	$con=new DBconn();
	echo '<label>'.$label.'</label>';
	echo '<select name="ppage" id="ppage" onchange="return perpage(this.form);">';
	$pag_query="select number,id from paging";
	$pag_sel=$con->recordselect($pag_query);
	while($pag_row=mysql_fetch_array($pag_sel))
	{
		echo '<option value="'.$pag_row['number'].'" '.(($ppage==$pag_row['number'])?'selected="selected"':'').'>'.$pag_row['number'].'</option>';
	}							
	echo '</select>';
}

// Resize Image Function
function resizeImage($filename,$newfilename="",$max_width,$max_height='',$withSampling=true) 
{
	if($newfilename=="") 
		$newfilename=$filename; 
	// Get new sizes 
	list($width, $height) = getimagesize($filename); //list() use to assign value to more variable at a time
	
	if($width>=$max_width and $height>=$max_width)
	{
		if($height==$width)
		{
			if($max_width>$width)
			{
				$ar=$width*100/$max_width;  //percentage to wrt max length
			}
			else
			{
				$ar=$max_width*100/$width;  //percentage wrt width
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
	
	
	$newwidth =round($newwidth);
	$newheight =round($newheight);
	
	// Load 
	$thumb = imagecreatetruecolor($newwidth, $newheight); 
	$ext = strtolower(substr($filename,strlen($filename)-3)); 
	
	if($ext=='jpg') 
		$source = imagecreatefromjpeg($filename); 
	if($ext=='jpeg')
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

?>