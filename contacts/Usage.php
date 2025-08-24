<?php

	// Ferdjaoui Sahid <sahid@funraill.org>
	// Contacts classe
	// Usage


require ('Contacts.php');

@header ('Content-Type: text/html; charset=utf-8');

try 
{
	if (!function_exists ('curl_version'))
		throw new Exception ("Curl n'est pas install");

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$user = '';
			$pass = '';
			$type = ''; // Gmail, Yahoo, Lycos, MSN, AOL
			
			$o = Contacts::factory (@$_POST['user'], @$_POST['pass'], @$_POST['type']);
			$result = $o->getContacts ();
	 }
} 
catch (Exception $e)
{
	echo $e->getMessage ();
}


?>

<html>
<head>
	<title>Contact Gmail, Yahoo, MSN, AOL, Lycos en PHP</title>
	
	<style type="text/css">
		body, table, label {font-size:small}
		h1 {font-size:medium}
	</style>

</head>
<body>
	<h1>Contact Gmail, Yahoo, MSN, AOL, Lycos en PHP</h1>
	<p>
		Aucune information n'est enregistré sur le serveur. <br/>
		Pour lire les source de se script utilisez Usage.txt.
	</p>
	<p>
		Piur télécharger le paquetages : <a href="http://labs.funraill.org/pub/PHP/contacts/">
			http://labs.funraill.org/pub/PHP/contacts/</a>
	</p>
	<form method="POST">
		<table>
			<tr>
				<td><label for="user">Identifiant : </label></td>
				<td><input type="text" name="user" id="user"/></td>
			</tr>
			<tr>
				<td><label for="pass">Mot de passe : </label></td>
				<td><input type="password" name="pass" id="pass"/></td>
				</tr>
			<tr>
				<td><label for="type">Type : </label></td>
				<td>
					<select name="type" id="type">
						<option value="Gmail">Gmail</option>
						<option value="Yahoo">Yahoo</option>
						<option value="MSN">MSN</option>
						<option value="Lycos">Lycos</option>
						<option value="AOL">AOL</option>
					</select>
				</td>
				</tr>
			<tr>
				<td></td>
				<td><input type="submit"></td>
			</tr>
		</table>
	</form>
	<hr/>
	<pre>
		<?php print_r (@$result); ?>
	</pre>

</body>
</html>
