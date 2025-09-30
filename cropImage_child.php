<?php

//include('config.php');	
//include(SITE_PATH.'/framework/joomlike.class.php');
//include(SITE_PATH.'/framework/mysql.class.php');
//$db	= new DB();

//define('DB_SERVER','localhost');
//define('DB_USERNAME','root');
//define('DB_PASSWORD','');
//define('DB_DATABASE','parentsolos_fr');
error_reporting (0);
class CropAvatar {
  private $src;
  private $data;
  //private $dst;
  private $type;
  private $extension;
  private $msg;

  function __construct($src, $data, $file) {
    $this -> setSrc($src);
    $this -> setData($data);
    $this -> setFile($file);
    $this -> crop($this -> src, $this -> data);
  }

  private function setSrc($src) {
    if (!empty($src)) {
      $type = exif_imagetype($src);

      if ($type) {
        $this -> src = $src;
        $this -> type = $type;
        $this -> extension = image_type_to_extension($type);
        //$this -> setDst();
      }
    }
  }

  private function setData($data) {
    if (!empty($data)) {
      $this -> data = json_decode(stripslashes((string) $data));
    }
  }

  private function setFile($file) {
    $errorCode = $file['error'];

    if ($errorCode === UPLOAD_ERR_OK) {
      $type = exif_imagetype($file['tmp_name']);

      if ($type) {
        $extension = image_type_to_extension($type);
        $src = 'images/profil/'.$upload_dir.'/'. date('YmdHis') . '.original' . $extension;

        if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {

          if (file_exists($src)) {
            unlink($src);
          }

          $result = move_uploaded_file($file['tmp_name'], $src);

          if ($result) {
            $this -> src = $src;
            $this -> type = $type;
            $this -> extension = $extension;
            //$this -> setDst();
          } else {
             $this -> msg = 'Failed to save file';
          }
        } else {
          $this -> msg = 'Please upload image with the following types: JPG, PNG, GIF';
        }
      } else {
        $this -> msg = 'Please upload image file';
      }
    } else {
      $this -> msg = $this -> codeToMessage($errorCode);
    }
  }

  /* private function setDst() {
   $this -> dst = 'images/' . date('YmdHis') . '.png';
  } */

  private function crop($src, $data) {
    if (!empty($src) && !empty($data)) {
      switch ($this -> type) {
        case IMAGETYPE_GIF:
          $src_img = imagecreatefromgif($src);
          break;

        case IMAGETYPE_JPEG:
          $src_img = imagecreatefromjpeg($src);
          break;

        case IMAGETYPE_PNG:
          $src_img = imagecreatefrompng($src);
          break;
      }

      if (!$src_img) {
        $this -> msg = "Failed to read the image file";
        return;
      }

      $size = getimagesize($src);
      $size_w = $size[0]; // natural width
      $size_h = $size[1]; // natural height

      $src_img_w = $size_w;
      $src_img_h = $size_h;

      $degrees = $data -> rotate;

      // Rotate the source image
      if (is_numeric($degrees) && $degrees != 0) {
        // PHP's degrees is opposite to CSS's degrees
        $new_img = imagerotate( $src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127) );

        imagedestroy($src_img);
        $src_img = $new_img;

        $deg = abs($degrees) % 180;
        $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

        $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
        $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);

        // Fix rotated image miss 1px issue when degrees < 0
        $src_img_w -= 1;
        $src_img_h -= 1;
      }

      $tmp_img_w = $data -> width;
      $tmp_img_h = $data -> height;
     $dst_img_w = 220;
     $dst_img_h = 220;

      $src_x = $data -> x;
      $src_y = $data -> y;

      if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
        $src_x = $src_w = $dst_x = $dst_w = 0;
      } else if ($src_x <= 0) {
        $dst_x = -$src_x;
        $src_x = 0;
        $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
      } else if ($src_x <= $src_img_w) {
        $dst_x = 0;
        $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
      }

      if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
        $src_y = $src_h = $dst_y = $dst_h = 0;
      } else if ($src_y <= 0) {
        $dst_y = -$src_y;
        $src_y = 0;
        $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
      } else if ($src_y <= $src_img_h) {
        $dst_y = 0;
        $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
      }

      // Scale to destination position and size
      $ratio = $tmp_img_w / $dst_img_w;
      $dst_x /= $ratio;
      $dst_y /= $ratio;
      $dst_w /= $ratio;
      $dst_h /= $ratio;

      $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);

      // Add transparent background to destination image
      imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
      imagesavealpha($dst_img, true);

      $result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

      if ($result) {
        if (!imagepng($dst_img)) {
          $this -> msg = "Failed to save the cropped image file";
        }
      } else {
        $this -> msg = "Failed to crop the image file";
      }
//php file
//$upload_dir="12929";
$upload_dir=$_POST['upload_dir'];
$but_hid=$_POST['but_hid'];
$searchString ='109-enfant';
$files = glob('images/profil/'.$upload_dir.'/*.*');
if($files[0] =='images/profil/'.$upload_dir.'/Thumbs.db')
{
unset($files[0]);
}
else{
$files=$files;
}
$filesFound = [];
	  
	  
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
 return preg_match("/pending/i", (string) $var);
 }
 $pendingfiltered = array_filter($filesFound,'filterpending');
 $pendingcount=count($pendingfiltered);
 //tempfiltercount
 
 function filtertemp($var) 
 { 
 return preg_match("/temp/i", (string) $var);
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
$profilenumber=[];
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

if($initialcount<=8){
	  
$width = 35; $height = 35;
$width_89 = 89; $height_89 = 89;
$width_109 = 109; $height_109 = 109;
$width_220 = 220; $height_220 = 220;
$width_270 = 220; $height_270 = 270;
$width_orig = $src_w;
$height_orig = $src_h;
$image = $src_img;
// Resample
$image_p = imagecreatetruecolor($width, $height);
imagecopyresampled($image_p, $image, $dst_x, $dst_y, $src_x, $src_y, $width, $height, $width_orig, $height_orig);
$image_p_89 = imagecreatetruecolor($width_89, $height_89);
imagecopyresampled($image_p_89, $image, $dst_x, $dst_y, $src_x, $src_y, $width_89, $height_89, $width_orig, $height_orig);
$image_p_109 = imagecreatetruecolor($width_109, $height_109);
imagecopyresampled($image_p_109, $image, $dst_x, $dst_y, $src_x, $src_y, $width_109, $height_109, $width_orig, $height_orig);
$image_p_220 = imagecreatetruecolor($width_220, $height_220);
imagecopyresampled($image_p_220, $image, $dst_x, $dst_y, $src_x, $src_y, $width_220, $height_220, $width_orig, $height_orig);
$image_p_270 = imagecreatetruecolor($width_270, $height_270);
imagecopyresampled($image_p_270, $image, $dst_x, $dst_y, $src_x, $src_y, $width_270, $height_270, $width_orig, $height_orig);
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
$context = stream_context_create(['gs' =>[
        'acl'=> 'public-read', 
        'Content-Type' => 'image/jpeg', 
        'enable_cache' => true, 
        'enable_optimistic_cache' => true,
        'read_cache_expiry_seconds' => 300,
    ]]);

//end resize
//mysqli_query($connection, 'UPDATE user_stats SET photo_a_valider = photo_a_valider+1 WHERE user_id = '.$upload_dir.'');
//$sql = "UPDATE user_stats SET photo_a_valider = 1 WHERE user_id = ".$upload_dir."";
//$query = mysql_query($conn,$sql);
//$db->query($query);

$servername = "blatmedi.mysql.db.internal";
$username = "blatmedi_soloch";
$password = "parentsoloch@dev";
$database = "blatmedi_parentsoloch1";

$con = mysqli_connect($servername, $username, $password, $database);

$sql = "UPDATE user_stats SET photo_a_valider = photo_a_valider+1 WHERE user_id = ".$upload_dir."";
$result = mysqli_query($con,$sql) or die(mysql_error());

file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-35-enfant-'.$but_hid.'.jpg', $data, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-89-enfant-'.$but_hid.'.jpg', $data2, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-109-enfant-'.$but_hid.'.jpg', $data3, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-220-enfant-'.$but_hid.'.jpg', $data4, false, $context);
file_put_contents('images/profil/'.$upload_dir.'/pending-parent-solo-enfant-'.$but_hid.'.jpg', $data5, false, $context);
echo "1";
}
	else{
	?>
	<script type="text/javascript">
	document.getElementById('imgsave').style.display = 'none';
	</script>
	<?php 	//echo "Limited Images";
	}
	  //php file
	  imagedestroy($src_img);
      imagedestroy($dst_img);
    }
  }

  private function codeToMessage($code) {
    $errors = [
      UPLOAD_ERR_INI_SIZE =>'The uploaded file exceeds the upload_max_filesize directive in php.ini',
      UPLOAD_ERR_FORM_SIZE =>'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
      UPLOAD_ERR_PARTIAL =>'The uploaded file was only partially uploaded',
      UPLOAD_ERR_NO_FILE =>'No file was uploaded',
      UPLOAD_ERR_NO_TMP_DIR =>'Missing a temporary folder',
      UPLOAD_ERR_CANT_WRITE =>'Failed to write file to disk',
      UPLOAD_ERR_EXTENSION =>'File upload stopped by extension',
    ];

    if (array_key_exists($code, $errors)) {
      return $errors[$code];
    }

    return 'Unknown upload error';
  }

  public function getResult() {
    return !empty($this -> data) ? $this -> dst : $this -> src;
  }

  public function getMsg() {
    return $this -> msg;
  }
}

$crop = new CropAvatar(
  $_POST['avatar_src'] ?? null,
  $_POST['avatar_data'] ?? null,
  $_FILES['avatar_file'] ?? null
);

$response = [
  'state'  => 200,
  'message' => $crop -> getMsg(),
  'result' => $crop -> getResult()
];

echo json_encode($response);

