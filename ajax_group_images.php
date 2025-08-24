<?php

 
 $varval=$_FILES['file']['name'];
 $upload_dir=$_GET['upload_dir'];
if($varval!=''){
 if((isset($_FILES['file']['name'])!='') && $upload_dir=='0'){

        $file_name = $_FILES['file']['tmp_name'];
 $image = imagecreatefromstring( file_get_contents( $file_name ));
 $image_110 = imagecreatefromstring( file_get_contents( $file_name ));
 list($width_org, $height_org, $type, $attr) = getimagesize( $file_name );
$width = 35; 
$height = 35;
$width_110 = 110; 
$height_110 = 110;
$width_orig = $width_org;
$height_orig = $height_org;
 //echo $image = imagecreatefromstring($varval);
// Resample
$image_p = imagecreatetruecolor($width, $height);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
$image_p_110 = imagecreatetruecolor($width_110, $height_110);
imagecopyresampled($image_p_110, $image_110, 0, 0, 0, 0, $width_110, $height_110, $width_orig, $height_orig);
// Buffering
ob_start();
imagepng($image_p);
$data = ob_get_contents();
ob_end_clean();
ob_start();
imagepng($image_p_110);
$data2 = ob_get_contents();
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
$maxvalue=time();
file_put_contents('images/groupe/temp/'.$maxvalue.'-mini.jpg', $data, false, $context);
file_put_contents('images/groupe/temp/'.$maxvalue.'.jpg', $data2, false, $context);
echo 'images/groupe/temp/'.$maxvalue.'.jpg';
}
if((isset($_FILES['file']['name'])!='') && $upload_dir!='0'){

        $file_name = $_FILES['file']['tmp_name'];
 $image = imagecreatefromstring( file_get_contents( $file_name ));
 $image_110 = imagecreatefromstring( file_get_contents( $file_name ));
 list($width_org, $height_org, $type, $attr) = getimagesize( $file_name );
$width = 35; 
$height = 35;
$width_110 = 110; 
$height_110 = 110;
$width_orig = $width_org;
$height_orig = $height_org;
 //echo $image = imagecreatefromstring($varval);
// Resample
$image_p = imagecreatetruecolor($width, $height);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
$image_p_110 = imagecreatetruecolor($width_110, $height_110);
imagecopyresampled($image_p_110, $image_110, 0, 0, 0, 0, $width_110, $height_110, $width_orig, $height_orig);
// Buffering
ob_start();
imagepng($image_p);
$data = ob_get_contents();
ob_end_clean();
ob_start();
imagepng($image_p_110);
$data2 = ob_get_contents();
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
file_put_contents('images/groupe/pending/'.$upload_dir.'-mini.jpg', $data, false, $context);
file_put_contents('images/groupe/pending/'.$upload_dir.'.jpg', $data2, false, $context);
echo 'images/groupe/pending/'.$upload_dir.'.jpg';



} 
} 
else{
	echo "New Register";
} 
?>
