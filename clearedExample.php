<?php

echo "<pre>";
// FGC en UTF 8
function file_get_contents_utf8($fn) {
	 $content = file_get_contents($fn);
	  return mb_convert_encoding($content, 'UTF-8',
		  mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}

setlocale (LC_TIME, 'fr_FR.utf8','fra');
$fichier = "https://api.mapbox.com/v4/geocode/mapbox.places/1600+pennsylvania+ave+nw.json?access_token=pk.eyJ1Ijoia2V2aW5zZSIsImEiOiJjaWZpZHhoOWkwMHdndGNseGRxc3A0d3U1In0.N5FbDKd9BQlcYh8bwsLVCA";
$content = file_get_contents_utf8($fichier);

$contentFile = trim($content);
$decoded = json_decode($contentFile, true);

print_r($decoded);
//var_dump(json_encode($sauvegardeResultats));


?>
