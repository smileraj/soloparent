<?php

//traitement pour savoir quel type de mail HOTMAIL GMAIL...
	
	$type = $_GET['type'];
	
	// etape 3
	$url 			= 'http://www.helveticamedia.ch/contact/ajax.php?mail='.$mail.'&mdp='.$mdp.'&type='.$type;
	$ch 			= curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$ajax_return	= curl_exec($ch); // etape 4
	//echo $ajax_return;
	
	// etape 5
	// TODO: traiter $ajax_return
	
		if($type=="hotmail"){
			$tab = explode("\n",$ajax_return);
			
			//recupere les noms et les emails dans le tableau contact
			$j=0;
			for($i=0; $i<sizeof($tab);$i++){
				if(ereg("Array",$tab[$i]) == false){
					if(ereg("=>",$tab[$i])){
						$tmp = explode("=> ",$tab[$i]);
						$contact[$j] = $tmp[1];	
						$j++;
					}
				}
			}
			
			if(isset($contact)){
				//transformer le tableau en chaine de caractere
				$ajax_return = implode("00babybook",$contact);
				// etape 6
				// retour au script AJAX
				echo $ajax_return;
			}else{
				$ajax_return = "Erreur";
				echo $ajax_return;
			}
		}
	
		if($type=="gmail" || $type=="yahoo"){
			echo $ajax_return;
			
		}
	
?>