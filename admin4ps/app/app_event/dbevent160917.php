<?php 
	require_once('../../../config.php');
	
	// framework joomlike
	require_once('../../../framework/joomlike.class.php');

	// framework base de données
	require_once('../../../framework/mysql.class.php');
	$db	= new DB();
 $SAVE=$_REQUEST['save'];
 $update=$_REQUEST['update'];
	if($_REQUEST['option']=='common'){
$date = date('d-m-Y');
$query='select max(start_date)as maxdate from events_creations';
 $usresult = mysql_query ($query);
 while($row=mysql_fetch_array($usresult)){
 $maxdate=date('d-m-Y',strtotime((string) $row['maxdate']));
 }
 $query='select max(end_date)as emaxdate from events_creations';
 $usresult = mysql_query ($query);
 while($row=mysql_fetch_array($usresult)){
 $emaxdate=date('d-m-Y',strtotime((string) $row['emaxdate']));
 }

 $finalvalue[]=[$maxdate,$emaxdate,$date];
echo json_encode($finalvalue);
}
 if($SAVE=='Save'){
$name=$db->escape($_REQUEST['txt_evt_name']);
 $desc=$db->escape($_REQUEST['txt_evt_desc']);
 $sdate=date('Y-m-d',strtotime((string) $_REQUEST['txt_evt_sdate']));
 $edate=date('Y-m-d',strtotime((string) $_REQUEST['txt_evt_edate']));
  $userid=$_REQUEST['userid'];
  $random=random_int(1, 1000000);
 $imgidentity=$userid.'_'.$random;
   $usquery="select username from user where id=$userid";
 $usresult = mysql_query ($usquery);
 while($row=mysql_fetch_array($usresult)){
 $useranme=$row['username'];
 }
 //logoname
  $target_dir = "../../../images/events/";
$target_file = $target_dir .$imgidentity.'_'.basename((string) $_FILES["txt_evt_logo"]["name"]);
$filename=$imgidentity.'_'.basename((string) $_FILES["txt_evt_logo"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
/* echo '<script>
	alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
         document.location= "../../../admin4ps/index.php?app=event&action=default&lang=en";
		 
</script>'; */
}
else{
 $query1="INSERT INTO events_creations(event_name,event_desc,start_date,end_date,uservalue,username,filename)VALUES('$name','$desc','$sdate','$edate',$userid,'$useranme','$filename')";
 $result1 = mysql_query ($query1);
 if($result1!=\MYSQL_QUERY){
 }
 else
 {
  //if (move_uploaded_file($_FILES["txt_evt_logo"]["tmp_name"],$target_file)) {
  function compress_image($target_dir, $destination_url, $quality) {
		$info = getimagesize($target_dir);
    		if ($info['mime'] == 'image/jpeg')
        			$image = imagecreatefromjpeg($target_dir);
    		elseif ($info['mime'] == 'image/gif')
        			$image = imagecreatefromgif($target_dir);

   		elseif ($info['mime'] == 'image/png')
        			$image = imagecreatefrompng($target_dir);
    		 imagejpeg($image, $destination_url, $quality);
		return $destination_url;
		
	}
	if ($_POST) {

    		if ($_FILES["txt_evt_logo"]["error"] > 0) {
			echo '<script>
alert("Sorry, there was an error uploading your file.");
         document.location= "../../../admin4ps/index.php?app=event&action=default&lang=en";
</script>';
$error = $_FILES["txt_evt_logo"]["error"];
    		} 
    		else if (($_FILES["txt_evt_logo"]["type"] == "image/gif") || 
			($_FILES["txt_evt_logo"]["type"] == "image/jpeg") || 
			($_FILES["txt_evt_logo"]["type"] == "image/png") || 
			($_FILES["txt_evt_logo"]["type"] == "image/pjpeg")) {

        			$url = $target_file;

        			$getdata = compress_image($_FILES["txt_evt_logo"]["tmp_name"], $target_file, 30);
        		echo '<script>
alert("Saved Successfully.");
         document.location= "../../../admin4ps/index.php?app=event&action=default&lang=en";
</script>';
        			
    		}else {
    		}
	}
 }
 }
 }
if($_REQUEST['option']=='edit'){
$id=$_REQUEST['editid'];
$editquery="select id,event_name,event_desc,start_date,end_date,filename from events_creations where id=$id";
$result1=mysql_query($editquery);
while($row=mysql_fetch_array($result1)){
$id=$row['id'];
$photoname=$row['filename'];
$evtname=stripslashes((string) $row['event_name']);
$evtdesc=stripslashes((string) $row['event_desc']);
$sdate=date('d-m-Y',strtotime((string) $row['start_date']));
$edate=date('d-m-Y',strtotime((string) $row['end_date']));
}
$target_dir = "../images/events/";
$target_file = $target_dir .$photoname;
$finalvalue[]=[$id,mb_convert_encoding((string) $evtname, 'UTF-8', 'ISO-8859-1'),mb_convert_encoding((string) $evtdesc, 'UTF-8', 'ISO-8859-1'),$sdate,$edate,$target_file,$photoname];
echo json_encode($finalvalue);
}
if($update=='Update'){
$id=$_REQUEST['rowid'];
 $name=$db->escape($_REQUEST['txt_evt_name']);
 $desc=$db->escape($_REQUEST['txt_evt_desc']);
 $sdate=date('Y-m-d',strtotime((string) $_REQUEST['txt_evt_sdate']));
 $edate=date('Y-m-d',strtotime((string) $_REQUEST['txt_evt_edate']));
 $userid=$_REQUEST['userid'];
  $random=random_int(1, 1000000);
 $imgidentity=$userid.'_'.$random;
$imagename=basename((string) $_FILES["txt_evt_logo"]["name"]);
 if($imagename==''){
 $filename=$_REQUEST['imageid'];
  $imageFileType = pathinfo((string) $filename,PATHINFO_EXTENSION);

 }
 else{
$target_dir = "../../../images/events/";
$target_file = $target_dir .$imgidentity.'_'.basename((string) $_FILES["txt_evt_logo"]["name"]);
$filename=$imgidentity.'_'.basename((string) $_FILES["txt_evt_logo"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

}
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    
	/* echo '<script>
	alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
         document.location= "../../../admin4ps/index.php?app=event&action=default&lang=en";
</script>'; */
}
else{
 $update="UPDATE events_creations SET event_name='$name',event_desc='$desc',start_date='$sdate',end_date='$edate',filename='$filename' where id=$id ";
 $getvalue= mysql_query ($update);
 if($getvalue!=\MYSQL_QUERY){
 
 }
 else
 {
 //if (move_uploaded_file($_FILES["txt_evt_logo"]["tmp_name"],$target_file)) {
function compress_image($target_dir, $destination_url, $quality) {
		$info = getimagesize($target_dir);
    		if ($info['mime'] == 'image/jpeg')
        			$image = imagecreatefromjpeg($target_dir);
    		elseif ($info['mime'] == 'image/gif')
        			$image = imagecreatefromgif($target_dir);

   		elseif ($info['mime'] == 'image/png')
        			$image = imagecreatefrompng($target_dir);
    		 imagejpeg($image, $destination_url, $quality);
		return $destination_url;
		
	}

	if ($_POST) {

    		if ($_FILES["txt_evt_logo"]["error"] > 0) {
			echo '<script>
         document.location= "../../../admin4ps/index.php?app=event&action=default&lang=en";
</script>';
$error = $_FILES["txt_evt_logo"]["error"];
    		} 
    		else if (($_FILES["txt_evt_logo"]["type"] == "image/gif") || 
			($_FILES["txt_evt_logo"]["type"] == "image/jpeg") || 
			($_FILES["txt_evt_logo"]["type"] == "image/png") || 
			($_FILES["txt_evt_logo"]["type"] == "image/pjpeg")) {

        			$url = $target_file;

        			$getdata = compress_image($_FILES["txt_evt_logo"]["tmp_name"], $target_file, 30);
        		echo '<script>
	alert("Updated Successfully");

         document.location= "../../../admin4ps/index.php?app=event&action=default&lang=en";
</script>';
        			
    		}else {
    		}
	}
		
    //} else {
	
        
    //}
 }
 }
 }
 if($_REQUEST['option']=='delete'){
 $id=$_REQUEST['delid'];
 $delete="DELETE FROM events_creations where id=$id ";
 $delvalue= mysql_query ($delete);
 if($delvalue!=\MYSQL_QUERY){
 echo '0';
 }
 else
 {
 echo '1';
 }
 }
?>