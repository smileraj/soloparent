<?php
	ini_set('error_reporting', '');
	ini_set('display_errors', 'off');
	echo $site = getenv("HTTP_HOST");
?>
<frameset>
<frame src="http://start.infomaniak.ch/welcome/<?=$site?>"/>
</frameset>