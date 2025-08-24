<?php

$lang_apptemoignage = array(

	//View
	"MessagesParentsolo" => "Parentsolo.ch messages",
	
	
	//*Listes de tous les témoignages
	"TousLesTemoignages" => "All the stories",
	
	"LireLeTemoignage" => "Read the story",
	"Publicite" => "Advertising",
	"PagePrecedente" => "Previous page",
	"Pages" => "Pages",
	"Page" => "Page",
	"Debut" => "Start",
	"Temoignage" => "story",
	"Temoignages" => "stories",
	"Fin" => "End",
	"PageSuivante" => "Next page",
	"AucunTemoignage" => "No story available at this time",
	"CodeDeVerification" => "Verification code",
	"VeuillezRecopierCodeVerification" => "Please copy below this verification code:",
	"WarningCodeVerifIncorrect" => "Verification code entered is invalid",
	//*Affichage d'un témoignage en partculier
	"TemoignagePublieLePar" => "Story published on  ".date("d.m.Y",strtotime($temoignage->date_add))." by ".$temoignage->username,
	
	//*Je désire témoigner
	"VotreTemoignage" => "Your story",
	
	"Titre" => "Title:",
	"Texte" => "Text:",
	
	"LesChampsMarques" => "Fields marked with an asterisk * are mandatory.",
	
	"Envoyer" => "Send",
	
	
	

	//Model

	//*Je désire témoigner
	"VousDevezEtreConnecte" => "You must be logged in to leave a story",
	
	"VeuillezIndiquerTitre" => "Please enter the title of your story",
	"VeuillezIndiquerTexte" => "Please enter the text of your story",

	"TemoignageEnvoye" => "Your story has been sent!<br /> A ParentSolo.ch moderator will check it in order to publish it or not, in either case you'll be notified by email.",
	
	
	


	

);
?>
