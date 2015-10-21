<?php
header('Content-Type: application/json; charset=utf-8');
setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.UTF-8');

/*
  Ce script va essayer d'assigner des coordonnées GPS à chacun des étudiants.
  Il modifie le gros fichier JSON récupéré depuis la base de données.
*/

// FGC en UTF 8
function file_get_contents_utf8($fn) {
	 $content = file_get_contents($fn);
	  return mb_convert_encoding($content, 'UTF-8',
		  mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}

// Ouverture du fichier, et récupération du contenu
$fichier = "../files/studentsPolytech2.geojson";
$f = fopen($fichier, "r");
$contentFile = fgets($f);
fclose ($f);

// Décodage du contenu
$decoded = json_decode(trim($contentFile), true);

// Initialisations diverses
$i = 0;
$sauvegardeResultats = Array();
$detectSimilar = Array(
  "mail" => NULL,
  "dateDebut" => NULL,
  "dateFin" => NULL
);

// DEBUG - LIMITES POUR LES ADRESSES (API LIMITEES !!)
$limiteTest = 25;

// Traitement cas par cas
foreach ($decoded["polyMap"] as $stagiaire) {
  $stagiaireTraite = $stagiaire; // On recopie tout

  // Traitement Dates du stage (pour calcul de la promo)
  $dateDebutStage = strftime("%A %d %B %Y", strtotime($stagiaire[7]));
  $dateFinStage = strftime("%A %d %B %Y", strtotime($stagiaire[8]));

  // Traitement Promotion du stagiaire = Année Stage + 5 ans de formation - Année étudiant lors du stage (correction par rapport à ce qui est renvoyé par la BD)
  $stagiaire[3] = intval(substr($dateDebutStage, -4)) + 5 - intval($stagiaire[5]);
  $stagiaireTraite[3] = strval($stagiaire[3]);

  // Traitement Section du stagiaire (on harmonise directement)
  $stagiaire[4] = preg_replace("#[0-9]([a-z]*)#", "", $stagiaire[4]);
  if ($stagiaire[5] < 3) {
    // Si l'année est 1 ou 2, alors c'est forcément un PeiP (merci Dylan !)
    // Si le stagiaire n'est pas encore diplomé
    $stagiaire[4] = "PeiP";
  }
  else if ($stagiaire[4] == "PEIP") {
  	// Cas étrange
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
  $stagiaireTraite[4] = $stagiaire[4];

  // Transformation en coordonnées GPS
  $concatAdresse = trim($stagiaire[9])." ".trim($stagiaire[11]);
  $adressePourUrl = urlencode($concatAdresse);
  $adresseGoogle = "http://maps.google.com/maps/api/geocode/json?address={$adressePourUrl}&sensor=false";
  print_r($stagiaireTraite);
  if ($i < $limiteTest && count($stagiaireTraite) < 13) {
    $moissonGoogle = file_get_contents_utf8($adresseGoogle);
    $decodeGoogle = json_decode($moissonGoogle, true);
  	if ($decodeGoogle[results][0]["geometry"]["location"]["lat"]) {
  		$stagiaireTraite[] = Array(
        $decodeGoogle[results][0]["geometry"]["location"]["lng"],
        $decodeGoogle[results][0]["geometry"]["location"]["lat"]
      );
  		$i++; usleep(120);
  	}
  	else {
  		$adresseMapbox = "https://api.mapbox.com/v4/geocode/mapbox.places/{$adressePourUrl}.json?access_token=pk.eyJ1Ijoia2V2aW5zZSIsImEiOiJjaWZpZHhoOWkwMHdndGNseGRxc3A0d3U1In0.N5FbDKd9BQlcYh8bwsLVCA";
  		$moissonMapbox = file_get_contents_utf8($adresseMapbox);
      $decodeMapbox = json_decode($moissonMapbox, true);
  		if ($decodeMapbox[features][0]["geometry"]) {
        $stagiaireTraite[] = Array(
          $decodeMapbox[features][0]["geometry"]["coordinates"][0],
          $decodeMapbox[features][0]["geometry"]["coordinates"][1]
        );
  			$i++; usleep(120);
  		}
      else {
        $stagiaireTraite[] = false; // Aucune API n'a réussi à convertir l'adresse (RIP)
      }
  	}
  }
  $sauvegardeResultats[] = $stagiaireTraite;
}

$renvoi["polyMap"] = $sauvegardeResultats;

$fichier = "../files/studentsPolytech2.geojson";
file_put_contents($fichier, json_encode($renvoi));

?>
