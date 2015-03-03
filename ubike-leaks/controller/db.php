<?php
//ini_set("display_errors", 1);

$conn = mysql_connect('localhost','root','22471899');
mysql_query("SET NAMES 'utf8'");
mysql_select_db('ubike');
date_default_timezone_set("Asia/Taipei");
if($_POST['eng']!=""){$_SESSION['eng']=$_POST['eng'];}

function video_id($url) {
$parse_url = parse_url($url);
$query = array();
parse_str($parse_url["query"], $query);
if(!empty($query["v"])) return $query["v"];
$t = explode("/", trim($parse_url["path"], "/"));
foreach($t as $k => $v) if($v == "v") if(!empty($t[$k + 1])) return $t[$k+1];
return $url;
}

//縮圖建立
function create_thumbnail($file_name,$file_dir,$thumb_dir,$mW,$mH) {
	 	$thumbnail_max_width=$mW;
		$thumbnail_max_height=$mH;
		
       /* $file_path = "background/".$file_name;
        $thumbnail_path = "back_thumbnails/".$file_name;*/
		$file_path = $file_dir."/".$file_name;
		$thumbnail_path = $thumb_dir."/".$file_name;
		
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
            $thumbnail_max_width / $img_width,
            $thumbnail_max_height / $img_height
        );
        if ($scale > 1) {
            $scale = 1;
        }
        $thumbnail_width = $img_width * $scale;
        $thumbnail_height = $img_height * $scale;
        $thumbnail_img = @imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                $write_thumbnail = 'imagejpeg';
                break;
            case 'gif':
                $src_img = @imagecreatefromgif($file_path);
                $write_thumbnail = 'imagegif';
                break;
            case 'png':
                $src_img = @imagecreatefrompng($file_path);
                $write_thumbnail = 'imagepng';
                break;
            default:
                $src_img = $write_thumbnail = null;
        }
        $success = $src_img && @imagecopyresampled(
            $thumbnail_img,
            $src_img,
            0, 0, 0, 0,
            $thumbnail_width,
            $thumbnail_height,
            $img_width,
            $img_height
        ) && $write_thumbnail($thumbnail_img, $thumbnail_path);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        @imagedestroy($thumbnail_img);
        return $success;
    }
	
	


function getJS($msg)
{
	$js = "<script>";
	$js.="alert('".$msg."');";
	$js.="</script>";
	return $js;
}
function redirectUrl($path)
{
	echo "<script>";
	echo "window.location.href='$path'";
	echo "</script>";
}

function addData($table,$info)
{
	$fld="";
	$val="";
	$sql = "insert into ".$table."(`id`,";
	foreach($info as $k => $v)
	{
		$prefix = substr($k,0,3);
		if($prefix!="fm_")
		{
			$v=str_replace("'","\'",$v);
			$v=str_replace("\"","\\\"",$v);
			$k=str_replace("'","\'",$k);
			$k=str_replace("\"","\\\"",$k);
			if($fld!=""){$fld.=",";}
			$fld.="`".$k."`";
			if($val!=""){$val.=",";}
			$val.="'".$v."'";
			
		}
	}
	$sql.=$fld.") values(NULL,".$val.")";
	//echo $sql."<br>";
	$cmd = mysql_query($sql);
	//if(!$cmd){ echo mysql_error();}

	$id = mysql_insert_id();
	return $id;
	
}


function updateData($table,$info,$type='')
{
	
	$fld="";
	$val="";
	$sql = "update ".$table." set ";
	foreach($info as $k => $v)
	{
		$prefix = substr($k,0,3);
		if($prefix!="fm_")
		{
		
			$v=str_replace("'","\'",$v);
			$v=str_replace("\"","\\\"",$v);
			$k=str_replace("'","\'",$k);
			$k=str_replace("\"","\\\"",$k);
			
			if($val!=""){$val.=",";}
			$val.="`".$k."`='".$v."'";
			
		}
	}
	$sql.=$val;
	if($type=='station'){
		$sql.=" where `sno`='".$info['sno']."'";		
	}else{
		$sql.=" where `id`='".$info['fm_id']."'";
	}
	
	$cmd = mysql_query($sql);
	//if(!$cmd){ echo mysql_error();}
	return $cmd;
}







function qry($sql)
{
	$cmd = mysql_query($sql);	
	if($cmd){ return true;}
		else{ return false;}
}

function getNum($sql)
{
	$num=0;
	$result = mysql_query($sql);
	if($result)
	{
		if(mysql_num_rows($result)>0)
		{
			$num = mysql_result($result,0);
		}
	}
	return $num;
		
}

function getRow($sql)
{
	$data = array();
	$result = mysql_query($sql);
	if($result)
	{
		if(mysql_num_rows($result)>0)
		{
			while($row=mysql_fetch_array($result))
			{
				$data=$row;
			}	
		}
	}
		return $data;
	
}

function getData($sql)
{
	$data = array();
	$result = mysql_query($sql);
	if($result)
	{
	if(mysql_num_rows($result)>0)
	{
		while($row=mysql_fetch_array($result))
		{
			$data[]=$row;	
		}	
	}
	}
	return $data;
}

function getTotalRows($table,$filter,$limit)
{
	$totalRows=getNum("select count(*) from ".$table.$filter.$limit);
	return $totalRows;
}


 function delTree($dir) {  
    $files = glob( $dir . '*', GLOB_MARK );  
    foreach( $files as $file ){  
         if( substr( $file, -1 ) == '/' )  
          delTree( $file );  
       else  
           unlink( $file );  
    }   
  
     if (is_dir($dir)) rmdir( $dir );   
  
 }
 
function deleteDirectory($dir) {  
       if (!file_exists($dir)) return true;  
        if (!is_dir($dir) || is_link($dir)) return unlink($dir);  
            foreach (scandir($dir) as $item) {  
                if ($item == '.' || $item == '..') continue;  
                if (!deleteDirectory($dir . "/" . $item)) {  
                    chmod($dir . "/" . $item, 0777);  
                    if (!deleteDirectory($dir . "/" . $item)) return false;  
                };  
          }  
   return rmdir($dir);  
}  



function unzip($file, $path) {
		$zip = zip_open($file);
		if ($zip) {
			while ($zip_entry = zip_read($zip)) {
			if (zip_entry_filesize($zip_entry) > 0) {
			// str_replace must be used under windows to convert "/" into "\"
				$complete_path = $path.str_replace('/','\\',dirname(zip_entry_name($zip_entry)));
				$complete_name = $path.str_replace ('/','\\',zip_entry_name($zip_entry));
				 if(!file_exists($complete_path)) {
					$tmp = '';
					foreach(explode('\\',$complete_path) AS $k) {
						$tmp .= $k.'\\';
					if(!file_exists($tmp)) {
						mkdir($tmp, 0777);
					}
			 	}
		       }
			 if (zip_entry_open($zip, $zip_entry, "r")) {
				$fd = fopen($complete_name, 'w');
				fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
				fclose($fd);
				zip_entry_close($zip_entry);
			  }
		    }
		  }
			zip_close($zip);
		}
	}





function mail_utf8_html($to,$subject='(No subject)',$message='',$header=''){

  $header  = "From: uBike <Ubike@midtech>";
  $header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
  mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $header);
  return true;
} 

function mail_utf8($to, $subject = '(No subject)', $message = '', $header = '') {
  $header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";
  mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header_ . $header);
  return true;
} 





function sortmddata($array, $by, $order, $type){

$order = strtoupper($order);

		//$array: the array you want to sort
		//$by: the associative array name that is one level deep
		////example: name
		//$order: ASC or DESC
		//$type: num or str
			   
		$sortby = "sort$by"; //This sets up what you are sorting by
		
		$firstval = current($array); //Pulls over the first array
		
		$vals = array_keys($firstval); //Grabs the associate Arrays
		
		foreach ($vals as $init){
		   $keyname = "sort$init";
		   $$keyname = array();
		}
		//This was strange because I had problems adding
		//Multiple arrays into a variable variable
		//I got it to work by initializing the variable variables as arrays
		//Before I went any further
		
		foreach ($array as $key => $row) {
		   
			foreach ($vals as $names){
			   $keyname = "sort$names";
			   $test = array();
			   $test[$key] = $row[$names];
			   $$keyname = array_merge($$keyname,$test);
			   
			}
		
		}
		
		//This will create dynamic mini arrays so that I can perform
		//the array multisort with no problem
		//Notice the temp array... I had to do that because I 
		//cannot assign additional array elements to a 
		//varaiable variable            
		
		if ($order == "DESC"){    
			if ($type == "num"){
				array_multisort($$sortby,SORT_DESC, SORT_NUMERIC,$array);
			} 
			else {
				array_multisort($$sortby,SORT_DESC, SORT_STRING,$array);
			}
		} 
		else 
		{
			if ($type == "num"){
				array_multisort($$sortby,SORT_ASC, SORT_NUMERIC,$array);
			} 
			else 
			{
				
				array_multisort($$sortby,SORT_ASC, SORT_STRING,$array);
			}
		}
		
		//This just goed through and asks the additional arguments
		//What they are doing and are doing variations of
		//the multisort
		
		return $array;
}
?>