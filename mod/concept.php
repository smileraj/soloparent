<?php
	if (isset($_GET["lang"])&&$_GET["lang"]!="fr") {
		$qString="_$_GET[lang]";

	} else {
		$qString="";
	}
	// r&eacute;cup le texte de concept
	$query 	= "SELECT texte_fr"
	." FROM contenu$qString"
	." WHERE published = 1 AND footer = 1 AND id = 2";
echo $query;
	$concept = $db->loadResult($query);

	JL::makeSafe($concept, 'texte');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>

	<style type="text/css">

	h2 {
		font-size: 16px;
		font-weight: normal;
		color: #CC0066;
		padding: 0 0 0 27px;
		background: url(../parentsolo/images/flower.jpg) left no-repeat;
		text-transform: uppercase;
		margin: 15px 0 10px 0;
	}


	a:link, a:hover, a:active, a:visited {
		text-decoration: none;
		color:#ff5d00;
	}

	a:hover {
		text-decoration: underline;
		color:#ff5d00;
	}

	p {
		color:#fff;
	}

	body {
		margin:0;
		padding:0;
	}
	</style>
</head>

<body>

	<div style="background-color:#000; padding:0 10px;">
		<br>
		<?php 			echo $concept;
		?>
		<br><br>
		<form>
			<center><input type="image" src="../parentsolo/images/ok.jpg" onClick="javascript:window.close();"></center>
		</form>
		<br
	</div>

</body>