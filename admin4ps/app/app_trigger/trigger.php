<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('trigger.html.php');
	
	global $action;
	

	
	// variables
	$messages = [];

	
	
	switch($action) {
		
		case 'save':
		save();
		
		case 'edit':

		editer();
		break;
		
		case 'list':
		lister();
		break;
		
		default:
		initialload();
		break;
		
	}
	
	
	function initialload() {
		
		mail_HTML::initialload();
		
	}