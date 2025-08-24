<?php

	$parentsolo = isset($_REQUEST['parentsolo']) ? $_REQUEST['parentsolo'] : false;
	
	if($parentsolo == 'vb3t4d3m01') {
		$_SESSION['accesdemo'] = 'azkzerkjpfgfd';
	}
	
	if(!isset($_SESSION['accesdemo']) || (isset($_SESSION['accesdemo']) && $_SESSION['accesdemo'] != 'azkzerkjpfgfd')) {
		
		// envoi du header 404
		header('HTTP/1.0 404 Not Found');
		?>
		<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
		<html>
		  <head>
			<title>404 Not Found</title>
		  </head>
		  <body>
			<!--
			  Error documents (pages) under 512 bytes
			  are ignored by the IE5+ browser, this
			  comment is used to bypass this size
			  ......................................
			  ......................................
			  ......................................
			-->
			<h1>Not Found</h1>
			<p>The requested URL was not found on this server.</p>

			<hr/>
		  </body>
		</html>
		<?
		exit;
		
	}
	
?>