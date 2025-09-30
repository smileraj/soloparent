<?php
$upload_dir=$_POST['upload_dir'];
$site_url=$_POST['site_url'];
$img_width=$_POST['img_width'];
$img_height=$_POST['img_height'];
$varval=$_POST['imgval'];

if($varval!=''){
	if($upload_dir!=''){
$img = preg_replace('#^data:image/[^;]+;base64,#', '', (string) $varval);
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
$context = stream_context_create([   'gs' =>[
        'acl'=> 'public-read', 
        'Content-Type' => 'image/jpeg', 
        'enable_cache' => true, 
        'enable_optimistic_cache' => true,
        'read_cache_expiry_seconds' => 300,
    ]]);
//end resize
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-35-'.$site_url.'.jpg', $data, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-89-'.$site_url.'.jpg', $data2, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-109-'.$site_url.'.jpg', $data3, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-220-'.$site_url.'.jpg', $data4, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-'.$site_url.'.jpg', $data5, false, $context);
echo "1";
}}
else{
	echo "no data";
}  

?>