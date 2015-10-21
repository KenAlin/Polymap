<!doctype html>
<html>
<head>
  <title>Polymap de tests</title>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script>
  <!--[if lte IE 8]>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.ie.css" />
  <![endif]-->
  <script src="scripting/cluster.js"></script>
  <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.css" />
  <link rel="stylesheet" href="polymap.css" />
  <link rel="stylesheet" href="scripting/cluster.css" />
  <script src="scripting/filtres.js"></script>
  <!-- <script src="scripting/touch.js"></script> -->
</head>
<body>
  <div id="mapP"></div>

  <div id="filt_Open">
    <a href="#" onclick="afficheFiltres();" id="filt_OpenLink"><img src="files/gear.png" width="65px" height="65px" /></a>
  </div>

  <div id="filtres">
    <div id="filt_Close">
      <a href="#" onclick="masqueFiltres();" id="filt_CloseLink">[X]</a>
    </div>

      <form enctype="multipart/form-data" name="filt_Form" id="filt_Form" action="" method="post">
        <div class="filt_FormContent">
          <label>
            <input type="radio" name="section" value="all" checked />
            <img src="files/picto/POLY.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="PeiP" />
            <img src="files/picto/PEIP.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="IG" />
            <img src="files/picto/IG.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="EGC" />
            <img src="files/picto/EGC.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="ENR" />
            <img src="files/picto/ENR.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="MAT" />
            <img src="files/picto/MAT.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="MEA" />
            <img src="files/picto/MEA.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="MI" />
            <img src="files/picto/MI.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="MSI" />
            <img src="files/picto/MSI.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="SE" />
            <img src="files/picto/SE.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="STE" />
            <img src="files/picto/STE.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
          <label>
            <input type="radio" name="section" value="GBA" />
            <img src="files/picto/GBA.png" width="64px" height="64px" onclick="setTimeout(function() {appliquerFiltres();}, 50);" />
          </label>
        </div>

        <div class="filt_FormContent">

        </div>

        <div id="filt_FormSpaceButton" style="display: none;">
          <img src="files/gotowork.png" alt="Appliquer" width="110" height="110" onclick="appliquerFiltres();" />
        </div>
      </form>


  </div>

	<script>
    // Définition des icônes des sections
    var icones = new Array();
		icones["EGC"] = L.icon({
			iconUrl: 'files/picto2/EGC.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
		icones["IG"] = L.icon({
			iconUrl: 'files/picto2/IG.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
		icones["MAT"] = L.icon({
			iconUrl: 'files/picto2/MAT.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["MEA"] = L.icon({
			iconUrl: 'files/picto2/MEA.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["MI"] = L.icon({
			iconUrl: 'files/picto2/MI.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["MSI"] = L.icon({
			iconUrl: 'files/picto2/MSI.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["SE"] = L.icon({
			iconUrl: 'files/picto2/SE.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["STE"] = L.icon({
			iconUrl: 'files/picto2/STE.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["GBA"] = L.icon({
			iconUrl: 'files/picto2/GBA.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["STIA"] = L.icon({
			iconUrl: 'files/picto2/GBA.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["ENR"] = L.icon({
			iconUrl: 'files/picto2/ENR.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
		});
    icones["PeiP"] = L.icon({
			iconUrl: 'files/picto2/PEIP.png',
			shadowUrl: null, iconSize: [52, 52],
      iconAnchor: [26, 52], popupAnchor:  [0, -50]
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
    /* var markers = new L.MarkerClusterGroup({
      iconCreateFunction: function(cluster) {
        return new L.DivIcon({ html: '<b>' + cluster.getChildCount() + '</b>', className: 'polyCluster', iconSize: L.point(40, 40)});
      }
    }).addTo(overlays); */
    var markers = new L.MarkerClusterGroup().addTo(overlays);

    var geojson;
    var getJsonData;

    // Parcours du fichier geojson pour ajouter les points
		$.getJSON("files/mappingAnonyme.geojson", function(data) {
			getJsonData = data;
      setTimeout(function() {appliquerFiltres();}, 550);

		});

    function appliquerFiltres() {
      // Fonction appelée à chaque clic sur un filtre, avec un délai de 50ms (propriété onclick)
      var checkedSection = $('input[name=section]:checked', '#filt_Form').val();
      var checkedDebut = $('input[name=dateDebut]:checked', '#filt_Form').val();
      var checkedFin = $('input[name=dateFin]:checked', '#filt_Form').val();
      var checkedPromo = $('input[name=promo]:checked', '#filt_Form').val();

      // Nettoyage des filtres : on enlève tout !
      overlays.clearLayers();

      // Et on recrée une couche markers, comme avant
      /* markers = new L.MarkerClusterGroup({
        iconCreateFunction: function(cluster) {
          return new L.DivIcon({ html: '<b>' + cluster.getChildCount() + '</b>', className: 'polyCluster', iconSize: L.point(40, 40)});
        }
      }).addTo(overlays); */
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
          // var filtreDebut = (feature.properties.dateDebut == checkedDebut) || checkedDebut == "all";
          // var filtreFin = (feature.properties.dateFin == checkedFin) || checkedFin == "all";
          // var filtrePromo = (feature.properties.promo == checkedPromo) || checkedPromo == "all";
          var filtreDebut = true;
          var filtreFin = true;
          var filtrePromo = true;
          var filtreCoordValide = (feature.geometry.coordinates[0] == null || feature.geometry.coordinates[0] == 19000 );

          // Sélectionne seulement les évènements qui correspondent dimultanément à tous les critères.
          return !filtreCoordValide && filtreSection && filtreDebut && filtreFin && filtrePromo;
        }
      });

      // Création de la carte et ajout des points
      map.fitBounds(markers.getBounds());
      mapboxTiles.addTo(map);
      map.addLayer(markers);

      return false;
    }
	</script>
</body>
</html>
