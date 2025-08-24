<?php
require_once('config.php');	
require_once(SITE_PATH.'/framework/joomlike.class.php');
require_once(SITE_PATH.'/framework/mysql.class.php');
$db	= new DB();
$varval=$_POST['imgval'];
$upload_dir=$_POST['upload_dir'];
$child_img=$_POST['child_img'];
$img_width=$_POST['img_width'];
$img_height=$_POST['img_height'];
$searchString ='109-enfant';
$files = glob('images/profil/'.$upload_dir.'/*.*');
if($files[0] =='images/profil/'.$upload_dir.'/Thumbs.db')
{
unset($files[0]);
}
else{
$files=$files;
}
$filesFound = array();
//initial data
foreach($files as $file) {
    $name = pathinfo($file, PATHINFO_FILENAME);
    if(strpos(strtolower($name), strtolower($searchString))) {
       $filesFound[] = $name;
		     } 
	
}
// output the results.
$initialcount= count($filesFound);
//pending count//;
 function filterpending($var) 
 { 
 return preg_match("/pending/i", $var);
 }
 $pendingfiltered = array_filter($filesFound,'filterpending');
 $pendingcount=count($pendingfiltered);
 //tempfiltercount
 
 function filtertemp($var) 
 { 
 return preg_match("/temp/i", $var);
 }
 $tempfiltered = array_filter($filesFound,'filtertemp');
$tempcount=count($tempfiltered);
///to get the max value///
$searchvalue="solo";
$files=glob('images/profil/'.$upload_dir.'/*.*');
if($files[0] =='images/profil/'.$upload_dir.'/Thumbs.db')
{
unset($files[0]);
}
else{
$files=$files;
}
$profilenumber=array();
$maxodend=0;
foreach($files as $files)
{
$name = pathinfo($files, PATHINFO_FILENAME);
 if(strpos(strtolower($name), strtolower($searchString))) {
       $filesFound[] = $name;
	   //print_r($profilenumber);
	   $profilenumber=explode('-',$name);
$endposition[]=end($profilenumber);
$maxodend=max($endposition);
		     } 
			 }

$maxvalue=$maxodend+1;
/*echo $maxvalue;  */
if($initialcount<=6){
if($varval!=''){if($upload_dir!=''){
$img = preg_replace('#^data:image/[^;]+;base64,#', '', $varval);
 $bin = base64_decode($img);
//resize
// Set a maximum height and width
$width = 35; $height = 35;
$width_89 = 89; $height_89 = 89;
$width_109 = 109; $height_109 = 109;
$width_220 = 220; $height_220 = 220;
$width_270 = 220; $height_270 = 270;
$width_orig = $img_width;
$height_orig = $img_height;
$image = imagecreatefromstring($bin);
// Resample
$image_p = imagecreatetruecolor($width, $height);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
$image_p_89 = imagecreatetruecolor($width_89, $height_89);
imagecopyresampled($image_p_89, $image, 0, 0, 0, 0, $width_89, $height_89, $width_orig, $height_orig);
$image_p_109 = imagecreatetruecolor($width_109, $height_109);
imagecopyresampled($image_p_109, $image, 0, 0, 0, 0, $width_109, $height_109, $width_orig, $height_orig);
$image_p_220 = imagecreatetruecolor($width_220, $height_220);
imagecopyresampled($image_p_220, $image, 0, 0, 0, 0, $width_220, $height_220, $width_orig, $height_orig);
$image_p_270 = imagecreatetruecolor($width_270, $height_270);
imagecopyresampled($image_p_270, $image, 0, 0, 0, 0, $width_270, $height_270, $width_orig, $height_orig);
// Buffering
ob_start();
imagepng($image_p);
$data = ob_get_contents();
ob_end_clean();
ob_start();
imagepng($image_p_89);
$data2 = ob_get_contents();
ob_end_clean();
ob_start();
imagepng($image_p_109);
$data3 = ob_get_contents();
ob_end_clean();
ob_start();
imagepng($image_p_220);
$data4 = ob_get_contents();
ob_end_clean();
ob_start();
imagepng($image_p_270);
$data5 = ob_get_contents();
ob_end_clean();
//Store & Display
$context = stream_context_create(array(   'gs' =>array(
        'acl'=> 'public-read', 
        'Content-Type' => 'image/jpeg', 
        'enable_cache' => true, 
        'enable_optimistic_cache' => true,
        'read_cache_expiry_seconds' => 300,
    )));
//end resize
$query = "UPDATE user_stats SET photo_a_valider = photo_a_valider+1 WHERE user_id = ".$upload_dir."";
$db->query($query);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-35-enfant-'.$child_img.'.jpg', $data, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-89-enfant-'.$child_img.'.jpg', $data2, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-109-enfant-'.$child_img.'.jpg', $data3, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-220-enfant-'.$child_img.'.jpg', $data4, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-enfant-'.$child_img.'.jpg', $data5, false, $context);
echo "1";
}

else{
	echo "New Register";
}
}
else{
	echo "Please Select Images";
}
	}
	else{
	
	echo "Limited Images";
	}
?>