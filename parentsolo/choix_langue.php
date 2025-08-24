<?php
session_start(); 
 $_SESSION['lang'] = 'all' ;
 echo $_SESSION['lang'];
 echo $_SERVER['HTTP_HOST'] ;
 //echo $_SERVER['PHP_SELF'] ;
 header("Location: http://" .$_SERVER['HTTP_HOST']);
?>