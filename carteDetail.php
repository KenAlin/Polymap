<!doctype html>
<html>
<!--
  POLYMAP - Un projet pour la Fontaine Numérique de l'Université Montpellier
  Par des étudiants de Polytech Montpellier en Informatique et Gestion (IG)
  Benjamin Teisseyre, Dylan Levy, Ouassim Ben-Mosbah, Kévin Servigé
  Depuis un projet de Hugo Vautrin et Alexandre Lafaille
  Github / contact : https://github.com/KenAlin/Polymap
-->
<head>
  <title>Polymap</title>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script>
  <!--[if lte IE 8]>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.ie.css" />
  <![endif]-->
  <script src="scripting/cluster.js"></script>
  <link rel="stylesheet" href="scripting/leaflet.css" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="scripting/touch.js"></script>
  <link rel="stylesheet" href="polymap.css" />
  <link rel="stylesheet" href="scripting/cluster.css" />
  <script src="scripting/filtres.js"></script>
  <link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
</head>
<body>
  <div id="mapP"></div>

  <div id="filt_Open">
    <a href="#" onclick="afficheFiltres();" id="filt_OpenLink"><img src="files/gear.png" width="65px" height="65px" /></a>
  </div>

  <div id="filtres">
    <div id="filt_Close">
      <span id="filt_NumberMarkers"></span>
      <span> </span>
      <a href="#" onclick="masqueFiltres();" id="filt_CloseLink">[X]</a>
    </div>

      <form enctype="multipart/form-data" name="filt_Form" id="filt_Form" action="" method="post">
        <div class="filt_FormContent filt_FormChoixSection">
          <label>
            <input type="radio" name="section" value="all" checked />
            <div class="filt_TextSection">Tout</div>
            <img src="files/picto/POLY.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="PeiP" />
            <div class="filt_TextSection">PeiP</div>
            <img src="files/picto/PEIP.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="IG" />
            <div class="filt_TextSection">IG</div>
            <img src="files/picto/IG.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <!-- <label>
            <input type="radio" name="section" value="EGC" />
            <div class="filt_TextSection">EGC</div>
            <img src="files/picto/EGC.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label> -->
          <label>
            <input type="radio" name="section" value="ENR" />
            <div class="filt_TextSection">ENR</div>
            <img src="files/picto/ENR.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="MAT" />
            <div class="filt_TextSection">MAT</div>
            <img src="files/picto/MAT.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="MEA" />
            <div class="filt_TextSection">MEA</div>
            <img src="files/picto/MEA.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="MI" />
            <div class="filt_TextSection">MI</div>
            <img src="files/picto/MI.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <!-- <label>
            <input type="radio" name="section" value="MSI" />
            <div class="filt_TextSection">MSI</div>
            <img src="files/picto/MSI.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label> -->
          <!-- <label>
            <input type="radio" name="section" value="SE" />
            <div class="filt_TextSection">SE</div>
            <img src="files/picto/SE.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label> -->
          <label>
            <input type="radio" name="section" value="STE" />
            <div class="filt_TextSection">STE</div>
            <img src="files/picto/STE.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="GBA" />
            <div class="filt_TextSection">GBA</div>
            <img src="files/picto/GBA.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
        </div>

        <div class="filt_FormContent">
          <p>
            <label for="rangeDateTexte"><b>Date du stage :</b></label>
            <input type="text" class="output" id="rangeDateTexte" readonly style="border:0; color: rgb(0,74,117); font-weight:bold;">
          </p>
          <div id="rangeDateSlider"></div>
        </div>
      </form>

      <div id="filt_About">
        <p>
          Polymap 2015 - <a href="about" target="_blank">En savoir plus</a>
        </p>
      </div>

  </div>

	<script>
    // Définition des icônes des sections
    var icones = new Array();
		icones["EGC"] = L.icon({
			iconUrl: 'files/picto2/EGC.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
		icones["IG"] = L.icon({
			iconUrl: 'files/picto2/IG.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
		icones["MAT"] = L.icon({
			iconUrl: 'files/picto2/MAT.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["MEA"] = L.icon({
			iconUrl: 'files/picto2/MEA.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["MI"] = L.icon({
			iconUrl: 'files/picto2/MI.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["MSI"] = L.icon({
			iconUrl: 'files/picto2/MSI.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["SE"] = L.icon({
			iconUrl: 'files/picto2/SE.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["STE"] = L.icon({
			iconUrl: 'files/picto2/STE.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["GBA"] = L.icon({
			iconUrl: 'files/picto2/GBA.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["STIA"] = L.icon({
			iconUrl: 'files/picto2/GBA.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["ENR"] = L.icon({
			iconUrl: 'files/picto2/ENR.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["PeiP"] = L.icon({
			iconUrl: 'files/picto2/PEIP.png', shadowUrl: null, iconSize: [52, 52], iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});

    // Imagerie Mapbox
    var mapboxTiles =  L.tileLayer('http://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    	attribution: 'Tuiles &copy;<a href="http://mapbox.com/about/maps/">MapBox</a> &mdash; Données cartographiques <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    	subdomains: 'abcd',
    	id: 'kevinse.cifidxh3100woucknrdf98z2y',
    	accessToken: 'pk.eyJ1Ijoia2V2aW5zZSIsImEiOiJjaWZpZHhoOWkwMHdndGNseGRxc3A0d3U1In0.N5FbDKd9BQlcYh8bwsLVCA',
      continuousWorld: false,
      //noWrap: true,
      unloadInvisibleTiles: true
    });

    // Définition de la map (lien sur le div d'id #mapP)
    var map = L.map('mapP', {
      maxZoom: 18,
      minZoom: 2
     });

    // Overlays est un groupe de couches, on y ajoutera les markers plus tard
    var overlays = L.layerGroup().addTo(map);

    // Les markers peuveur être rassemblés quand on est en dézoomé
    var markers = new L.MarkerClusterGroup().addTo(overlays);

    // Initialisations diverses
    var geojson;
    var getJsonData;
    var numberMarkers = 0;
    var dateDebFromRange = 2011;
    var dateFinFromRange = <?php echo date("Y"); ?>;

    // Parcours du fichier geojson pour ajouter les points
		$.getJSON("files/mappingDetaille.geojson", function(data) {
			getJsonData = data;
      setTimeout(function() {appliquerFiltres();}, 550);

		});

    function appliquerFiltres() {
      // Fonction appelée à chaque clic sur un filtre, avec un délai de 50ms (propriété onclick)
      var checkedSection = $('input[name=section]:checked', '#filt_Form').val();
      var checkedDebut = (dateDebFromRange - 1970) * 31557600;
      var checkedFin = (dateFinFromRange - 1970 + 1) * 31557600;
      var checkedPromo = $('input[name=promo]:checked', '#filt_Form').val();

      // Nettoyage des filtres : on enlève tout !
      overlays.clearLayers();
      numberMarkers = 0;

      // Et on recrée une couche markers, comme avant
      markers = new L.MarkerClusterGroup().addTo(overlays);

      // Et on applique les filtres !!
      geojson = L.geoJson(getJsonData, {
        pointToLayer: function(feature, latlng) {
          return markers.addLayer(
              new L.Marker(new L.LatLng(
                feature.geometry.coordinates[1],
                feature.geometry.coordinates[0]),{
                  icon: icones[feature.properties.section]
                }).bindPopup(feature.properties.nom)
              );
        },
        filter: function(feature, layer) {
          // Définition des filtres (true forcé pour les non développés)
          var filtreSection = (feature.properties.section == checkedSection) || checkedSection == "all";
          var filtreDateDeb = (feature.properties.date_deb > checkedDebut);
          var filtreDateFin = (feature.properties.date_fin < checkedFin);
          var filtrePromo = true;

          var filtreCoordValide = (feature.geometry.coordinates[0] == null || feature.geometry.coordinates[0] == 19000 );

          // Sélectionne seulement les évènements qui correspondent dimultanément à tous les critères.
          var condition = !filtreCoordValide && filtreSection && filtreDateDeb && filtreDateFin && filtrePromo;
          if (condition) {
            numberMarkers++;
          }
          return condition;
        }
      });

      // Création de la carte et ajout des points
      map.fitBounds(markers.getBounds());
      mapboxTiles.addTo(map);
      map.addLayer(markers);

      // Affichage du nombre de markers
      if (numberMarkers == 0) {
        document.getElementById('filt_NumberMarkers').innerHTML = "Aucun étudiant trouvé";
      }
      else if (numberMarkers == 1) {
        document.getElementById('filt_NumberMarkers').innerHTML = "<span class=\"highlightNumber\">1</span> étudiant trouvé";
      } else {
        document.getElementById('filt_NumberMarkers').innerHTML = "<span class=\"highlightNumber\">" + numberMarkers + "</span> étudiants trouvés";
      }

      return false;
    }

    // Taitement du slider
    $(function() {
      $( "#rangeDateSlider" ).slider({
        range: true,
        min: 2011,
        max: <?php echo date("Y"); ?>,
        values: [2011, <?php echo date("Y"); ?>],
        slide: function( event, ui ) {
          $( "#rangeDateTexte" ).val( "entre " + ui.values[ 0 ] + " et " + ui.values[ 1 ] );
          dateDebFromRange = ui.values[ 0 ];
          dateFinFromRange = ui.values[ 1 ];
          setTimeout(function() {appliquerFiltres();}, 50);
        }
      });
      $( "#rangeDateTexte" ).val( "entre " + $( "#rangeDateSlider" ).slider( "values", 0 ) +
        " et " + $( "#rangeDateSlider" ).slider( "values", 1 ) );
    });

	</script>
</body>
</html>
