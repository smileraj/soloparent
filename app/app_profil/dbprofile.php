<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../config.php');
	
	// framework joomlike
	require_once('../../framework/joomlike.class.php');

	// framework base de donn&eacute;es
	require_once('../../framework/mysql.class.php');
	
	$db	= new DB();
	$connection = $db->getConnexion();

   $zipvalue=$_POST['id1'];
 //$query=  "SELECT nom FROM profil_canton_en INNER JOIN user_zipcode ON  profil_canton_en.id = user_zipcode.zipcode_id WHERE postalcode = $ff";
/*
$query = mysqli_query($connection,"SELECT nom,id FROM profil_canton_en");
while ($row = mysqli_fetch_array($query))
	{
	            $id[]=$row['id'];
	            $nom[]=$row['nom'];
 }
$finalarray=array($id,$nom);
 echo json_encode($finalarray);
*/
if($zipvalue!='')
{
$query = "SELECT zipcode_id,area_code FROM user_zipcode WHERE postal_code = $zipvalue";
  $result = mysqli_query($connection,$query) or die (mysql_error ());
		while ($row = mysqli_fetch_array($result))
	{
	            $zipid=$row['zipcode_id'];
	            $arearcode=$row['area_code'];
 }
 }else{
 echo '';
 }
 if(isset($zipid) && $zipid!=''){
$query1 = "SELECT id,nom FROM profil_canton_en WHERE id = $zipid";
  $result1 = mysqli_query($connection,$query1) or die (mysql_error ());
		while ($row = mysqli_fetch_array($result1))
	{
	            $state=$row['nom'];
	            $id=$row['id'];
				echo $arearcode.'<br>'."<option value=".$id." selected>".$state."</option>";
 }
 }
 else
 {
 echo '';
 }
?>