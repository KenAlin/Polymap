<?php
header('Content-Type: application/json; charset=utf-8');
setlocale(LC_ALL, 'fr', 'fr_FR', 'fr_FR.UTF-8');

// FGC en UTF 8
function file_get_contents_utf8($fn) {
	 $content = file_get_contents($fn);
	  return mb_convert_encoding($content, 'UTF-8',
		  mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}

// Ouvre notre fichier JSON, et jette un oeil au contenu
$fichier = "../files/studentsPolytech2.geojson";
$f = fopen($fichier, "r");
$contentFile = fgets($f);
fclose ($f);

$decoded = json_decode(trim($contentFile), true);

$i = 0;
$sauvegardeResultats = array(
  "features" => array()
);

// Traitement cas par cas
foreach ($decoded["polyMap"] as $stagiaire) {
	$stagiaireTraite["type"] = "Feature";

	// Traitement Dates du stage
	$stagiaireTraite["properties"]["date_deb"] = strtotime($stagiaire[7]);
	$stagiaireTraite["properties"]["date_fin"] = strtotime($stagiaire[8]);

	// Traitement Nom du stage (anonymisé)
	$dateDebutStage = strftime("%A %d %B %Y", $stagiaireTraite["properties"]["date_deb"]);
	$dateFinStage = strftime("%A %d %B %Y", $stagiaireTraite["properties"]["date_fin"]);
	$texteDates = "Du {$dateDebutStage}<br />Au {$dateFinStage}";

	// Traitement Promotion du stagiaire = Année Stage + 5 ans de formation - Année étudiant lors du stage
	$stagiaireTraite["properties"]["promo"] = strval($stagiaire[3]);

	// Traitement Section du stagiaire
	$stagiaireTraite["properties"]["section"] = $stagiaire[4];

	$nom = "<b>&Eacute;tudiant {$stagiaire[4]} de {$stagiaire[5]}&egrave; ann&eacute;e</b><br />";
	$nom = $nom . "Promotion {$stagiaire[3]}<br /><br />{$texteDates}";
	$stagiaireTraite["properties"]["nom"] = utf8_encode($nom);

	// Transformation en coordonnées GPS
	if (isset($stagiaire[12])) {
		// Il y a des coordonnées à récupérer dans le JSON
		$stagiaireTraite["geometry"]["type"] = "Point";
		$stagiaireTraite["geometry"]["coordinates"] = Array(
			$stagiaire[12][0],
			$stagiaire[12][1]
		);
		$sauvegardeResultats["features"][] = $stagiaireTraite;
	}
}

print_r($sauvegardeResultats);
//echo json_encode($sauvegardeResultats);

$fichierSauvegarde = "../files/mappingAnonyme.geojson";
file_put_contents($fichierSauvegarde, json_encode($sauvegardeResultats));

?>
