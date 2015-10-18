<?php

echo "<pre>";
// FGC en UTF 8
function file_get_contents_utf8($fn) {
	 $content = file_get_contents($fn);
	  return mb_convert_encoding($content, 'UTF-8',
		  mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}

setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
$fichier = "files/studentsPolytech.geojson";
$f = fopen($fichier, "r");
$contentFile = fgets($f);
fclose ($f);

$contentFile = trim($contentFile);
$decoded = json_decode($contentFile, true);

$i = 0;

$sauvegardeResultats = array(
  "features" => array()
);

$detectSimilar = Array(
  "mail" => NULL,
  "dateDebut" => NULL,
  "dateFin" => NULL
);

// Traitement cas par cas
foreach ($decoded["polyMap"] as $stagiaire) {
  // On veut détecter et supprimer les stages identiques. Postulat simple : un même étudiant, identifié par son adresse mail, ne peut pas avoir deux stages avec les mêmes date de début et date de fin.
  if ($i > 559 || $stagiaire[2] == $detectSimilar["mail"] && $stagiaire[7] == $detectSimilar["dateDebut"] && $stagiaire[8] == $detectSimilar["dateFin"]) {
    // C'est le même stage que celui du haut : ON DELETE !
    unset($stagiaire);
  }
  else {
    // Ok, ce n'est pas le même stage que précédemment ! On continue.
    $detectSimilar = Array(
      "mail" => $stagiaire[2],
      "dateDebut" => $stagiaire[7],
      "dateFin" => $stagiaire[8]
    );

    $stagiaireTraite["type"] = "Feature";

    // Traitement Section du stagiaire
    $stagiaire[4] = preg_replace("#[0-9]([a-z]*)#", "", $stagiaire[4]);
    if ($stagiaire[5]<3) {
      // Si l'année est 1 ou 2, alors c'est forcément un PeiP (merci Dylan !)
      $stagiaire[4] = "PeiP";
    }
		else if ($stagiaire[4] == "STIA" || $stagiaire[4] == "STIAEC") {
			// STIA n'existe plus ... à la place : GBA
			$stagiaire[4] = "GBA";
		}
		else if ($stagiaire[4] == "INFO") {
			$stagiaire[4] = "IG";
		}
		else if ($stagiaire[4] == "EII" || $stagiaire[4] == "ERII" || $stagiaire[4] == "MEAEC") {
			$stagiaire[4] = "MEA";
		}
		else if ($stagiaire[4] == "MATEC") {
			$stagiaire[4] = "MAT";
		}
		else if ($stagiaire[4] == "STEEC") {
			$stagiaire[4] = "STE";
		}
    $stagiaireTraite["properties"]["section"] = $stagiaire[4];

		// Traitement Promotion du stagiaire (!! ne pas faire confiance à cette valeur !!)
		$stagiaireTraite["properties"]["promo"] = $stagiaire[3];

    // Traitement Dates du stage
    $stagiaireTraite["properties"]["date_deb"] = strtotime($stagiaire[7]);
    $stagiaireTraite["properties"]["date_fin"] = strtotime($stagiaire[8]);

    // Traitement Nom du stage (anonymisé)
    $dateDebutStage = strftime("%A %d %B %Y", $stagiaireTraite["properties"]["date_deb"]);
    $dateFinStage = strftime("%A %d %B %Y", $stagiaireTraite["properties"]["date_fin"]);
    $texteDates = utf8_encode("Du {$dateDebutStage}<br />Au {$dateFinStage}");
    $nom = "<b>Étudiant {$stagiaire[4]} de {$stagiaire[5]}è année</b><br />Promotion {$stagiaire[3]}<br /><br />{$texteDates}";
    $stagiaireTraite["properties"]["nom"] = htmlentities($nom);

    // Transformation en coordonnées GPS
    $concatAdresse = trim($stagiaire[9])." ".trim($stagiaire[11]);
    $adressePourUrl = urlencode($concatAdresse);
    $adresseGoogle = "http://maps.google.com/maps/api/geocode/json?address={$adressePourUrl}&sensor=false";

    if ($i<560) {
      $moissonGoogle = file_get_contents_utf8($adresseGoogle);
      $decodeGoogle = json_decode($moissonGoogle, true);
      $stagiaireTraite["geometry"]["type"] = "Point";
			if ($decodeGoogle[results][0]["geometry"]["location"]["lat"]) {
				$stagiaireTraite["geometry"]["coordinates"] = Array(
	        $decodeGoogle[results][0]["geometry"]["location"]["lng"],
	        $decodeGoogle[results][0]["geometry"]["location"]["lat"]
	      );
				$sauvegardeResultats["features"][] = $stagiaireTraite;
				$i++;
			}
			else {
				$adresseMapbox = "https://api.mapbox.com/v4/geocode/mapbox.places/{$adressePourUrl}.json?access_token=pk.eyJ1Ijoia2V2aW5zZSIsImEiOiJjaWZpZHhoOWkwMHdndGNseGRxc3A0d3U1In0.N5FbDKd9BQlcYh8bwsLVCA";
				$moissonMapbox = file_get_contents_utf8($adresseMapbox);
	      $decodeMapbox = json_decode($moissonMapbox, true);
				if ($decodeMapbox[features][0]["geometry"]) {
					$stagiaireTraite["geometry"] = $decodeMapbox[features][0]["geometry"];
					$sauvegardeResultats["features"][] = $stagiaireTraite;
					$i++;
				}
			}
    }
  }
}

//print_r($sauvegardeResultats);
echo json_encode($sauvegardeResultats);


?>
