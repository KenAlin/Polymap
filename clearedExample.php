<?php

echo "<pre>";
// FGC en UTF 8
function file_get_contents_utf8($fn) {
	 $content = file_get_contents($fn);
	  return mb_convert_encoding($content, 'UTF-8',
		  mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}

setlocale (LC_TIME, 'fr_FR.utf8','fra');
$fichier = "files/students.geojson";
$content = file_get_contents($fichier);

$contentFile = trim($content);
$decoded = json_decode($contentFile, true);

print_r($decoded);
//var_dump(json_encode($sauvegardeResultats));


?>
