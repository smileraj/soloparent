<?php 
	require_once('http://www.parentsolo.ch/newdev/config.php');
	
	// framework joomlike
	require_once('http://www.parentsolo.ch/newdev/framework/joomlike.class.php');

	// framework base de données
	require_once('http://www.parentsolo.ch/newdev/framework/mysql.class.php');
	$db	= new DB();
if($_REQUEST['option']=='common'){
$date = date('d-m-Y');
$query='select max(start_date)as maxdate from events_creations';
 $usresult = mysql_query ($query);
 while($row=mysql_fetch_array($usresult)){
 $maxdate=date('d-m-Y',strtotime($row['maxdate']));
 }
 $query='select max(end_date)as emaxdate from events_creations';
 $usresult = mysql_query ($query);
 while($row=mysql_fetch_array($usresult)){
 $emaxdate=date('d-m-Y',strtotime($row['emaxdate']));
 }

 $finalvalue[]=array($maxdate,$emaxdate,$date);
echo json_encode($finalvalue);
}
 if($_REQUEST['option']=='save'){
 $name=mysql_real_escape_string($_REQUEST['name']);
 $desc=mysql_real_escape_string($_REQUEST['desc']);
 $sdate=date('Y-m-d',strtotime($_REQUEST['sdate']));
 $edate=date('Y-m-d',strtotime($_REQUEST['edate']));
 $userids=$_REQUEST['userid'];
 $usquery="select username from user where id=$userids";
 $usresult = mysql_query ($usquery);
 while($row=mysql_fetch_array($usresult)){
 $useranme=$row['username'];
 }
 $query1="INSERT INTO events_creations(event_name,event_desc,start_date,end_date,uservalue,username)VALUES('$name','$desc','$sdate','$edate',$userids,'$useranme')";
 $result1 = mysql_query ($query1);
 if($result1!=mysql_query){
 echo '0';
 }
 else
 {
 echo '1';
 }
 }
if($_REQUEST['option']=='edit'){
$id=$_REQUEST['editid'];
$editquery="select id,event_name,event_desc,start_date,end_date from events_creations where id=$id";
$result1=mysql_query($editquery);
while($row=mysql_fetch_array($result1)){
$id=$row['id'];
$evtname=mysql_real_escape_string($row['event_name']);
$evtdesc=mysql_real_escape_string($row['event_desc']);
$sdate=date('d-m-Y',strtotime($row['start_date']));
$edate=date('d-m-Y',strtotime($row['end_date']));
}
$finalvalue[]=array($id,$evtname,$evtdesc,$sdate,$edate);
echo json_encode($finalvalue);
}
if($_REQUEST['option']=='update'){
$id=$_REQUEST['editid'];
 $name=mysql_real_escape_string($_REQUEST['name']);
 $desc=mysql_real_escape_string($_REQUEST['desc']);
 $sdate=date('Y-m-d',strtotime($_REQUEST['sdate']));
 $edate=date('Y-m-d',strtotime($_REQUEST['edate']));

 $update="UPDATE events_creations SET event_name='$name',event_desc='$desc',start_date='$sdate',end_date='$edate' where id=$id ";
 $getvalue= mysql_query ($update);
 if($getvalue!=mysql_query){
 echo '0';
 }
 else
 {
 echo '1';
 }
 }
 if($_REQUEST['option']=='delete'){
 $id=$_REQUEST['delid'];
 $delete="DELETE FROM events_creations where id=$id ";
 $delvalue= mysql_query ($delete);
 if($delvalue!=mysql_query){
 echo '0';
 }
 else
 {
 echo '1';
 }
 }
?>