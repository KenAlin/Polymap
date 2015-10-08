<?php 
setlocale (LC_TIME, 'fr_FR.utf8','fra');

// FGC en UTF 8
function file_get_contents_utf8($fn) { 
	 $content = file_get_contents($fn); 
	  return mb_convert_encoding($content, 'UTF-8', 
		  mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true)); 
} 

// Sanitizer
$fichier = "files/arrets_transports_points.geojson";
$f= fopen($fichier, "r");
$ln= 0;

$renvoiSain.= "{
\"type\": \"FeatureCollection\",
\"crs\": { \"type\": \"name\", \"properties\": { \"name\": \"urn:ogc:def:crs:OGC:1.3:CRS84\" } },
                                                                                
\"features\": [
";

while ($line= fgets($f)) {
	++$ln;
	if (preg_match("/(Hérault Transport|Herault Transport)/i",$line))
		$renvoiSain.= $line;
}
fclose ($f);

$renvoiSain.= "
]
}";

file_put_contents('files/mapHT.geojson', $renvoiSain);

?>