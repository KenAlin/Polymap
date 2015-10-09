<!doctype html>
<html>
<head>
  <title>Polymap de tests</title>
  <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.css" />
  <!--[if lte IE 8]>
     <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.ie.css" />
  <![endif]-->
  <link rel="stylesheet" href="polymap.css" />
  <script src="scripting/filtres.js"></script>

  <script src="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="scripting/cluster.js"></script>
  <link rel="stylesheet" href="scripting/cluster.css" />
</head>
<body>
  <div id="mapP"></div>

  <div id="filt_Open">
    <a href="#" onclick="afficheFiltres();" id="filt_OpenLink"><img src="files/gear.png" width="65px" height="65px" /></a>
  </div>

  <div id="filtres">
    <div id="filt_Close">
      <a href="#" onclick="masqueFiltres();" id="filt_CloseLink">[X]</a>

      <form onsubmit="" action="#">
        <div id="filt_FormContent">
          
        </div>

        <div id="filt_FormSpaceButton">
          <button type="submit" value="Submit">Appliquer</button>
        </div>
      </form>

    </div>
  </div>

	<script>
    // Définition des icônes des sections
		var iconeEGC = L.icon({
			iconUrl: 'files/picto/EGC.png',
			shadowUrl: null, iconSize: [26, 26],
      shadowSize: [0, 0], iconAnchor: [6, 6], shadowAnchor: [6, -6], popupAnchor:  [6, -6]
		});
		var iconeIG = L.icon({
			iconUrl: 'files/picto/IG.png',
			shadowUrl: null, iconSize: [26, 26],
      shadowSize: [0, 0], iconAnchor: [6, 6], shadowAnchor: [6, -6], popupAnchor:  [6, -6]
		});
		var iconeMAT = L.icon({
			iconUrl: 'files/picto/MAT.png',
			shadowUrl: null, iconSize: [26, 26],
      shadowSize: [0, 0], iconAnchor: [6, 6], shadowAnchor: [6, -6], popupAnchor:  [6, -6]
		});
    var iconeMEA = L.icon({
			iconUrl: 'files/picto/MEA.png',
			shadowUrl: null, iconSize: [26, 26],
      shadowSize: [0, 0], iconAnchor: [6, 6], shadowAnchor: [6, -6], popupAnchor:  [6, -6]
		});
    var iconeMI = L.icon({
			iconUrl: 'files/picto/MI.png',
			shadowUrl: null, iconSize: [26, 26],
      shadowSize: [0, 0], iconAnchor: [6, 6], shadowAnchor: [6, -6], popupAnchor:  [6, -6]
		});
    var iconeMSI = L.icon({
			iconUrl: 'files/picto/MSI.png',
			shadowUrl: null, iconSize: [26, 26],
      shadowSize: [0, 0], iconAnchor: [6, 6], shadowAnchor: [6, -6], popupAnchor:  [6, -6]
		});
    var iconeSE = L.icon({
			iconUrl: 'files/picto/SE.png',
			shadowUrl: null, iconSize: [26, 26],
      shadowSize: [0, 0], iconAnchor: [6, 6], shadowAnchor: [6, -6], popupAnchor:  [6, -6]
		});
    var iconeSTE = L.icon({
			iconUrl: 'files/picto/STE.png',
			shadowUrl: null, iconSize: [26, 26],
      shadowSize: [0, 0], iconAnchor: [6, 6], shadowAnchor: [6, -6], popupAnchor:  [6, -6]
		});
    var iconeSTIA = L.icon({
			iconUrl: 'files/picto/STIA.png',
			shadowUrl: null, iconSize: [26, 26],
      shadowSize: [0, 0], iconAnchor: [6, 6], shadowAnchor: [6, -6], popupAnchor:  [6, -6]
		});

    // Imagerie Mapbox
    var mapboxTiles =  L.tileLayer('http://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    	attribution: 'Imagery from <a href="http://mapbox.com/about/maps/">MapBox</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    	subdomains: 'abcd',
    	id: 'kevinse.cifidxh3100woucknrdf98z2y',
    	accessToken: 'pk.eyJ1Ijoia2V2aW5zZSIsImEiOiJjaWZpZHhoOWkwMHdndGNseGRxc3A0d3U1In0.N5FbDKd9BQlcYh8bwsLVCA'
    });

    // Les merkers peuveur être rassemblés quand on est en dézoomé
    var markers = new L.MarkerClusterGroup({
      iconCreateFunction: function(cluster) {
          return new L.DivIcon({ html: '<b>' + cluster.getChildCount() + '</b>', className: 'mycluster', iconSize: L.point(40, 40)});
      }
    });

    // Parcours du fichier geojson pour ajouter les points
		$.getJSON("files/students.geojson", function(data) {
			var geojson = L.geoJson(data, {
				pointToLayer: function(feature, latlng) {
					if (feature.properties.section == "IG") {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeIG}).bindPopup(feature.properties.nom)); }
					else if (feature.properties.section == "STE") {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeSTE}).bindPopup(feature.properties.nom)); }
          else if (feature.properties.section == "STIA") {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeSTIA}).bindPopup(feature.properties.nom)); }
          else if (feature.properties.section == "MAT") {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeMAT}).bindPopup(feature.properties.nom)); }
          else if (feature.properties.section == "MEA") {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeMEA}).bindPopup(feature.properties.nom)); }
          else if (feature.properties.section == "SE") {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeSE}).bindPopup(feature.properties.nom)); }
          else if (feature.properties.section == "ENR") {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeENR}).bindPopup(feature.properties.nom)); }
          else if (feature.properties.section == "MI") {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeMI}).bindPopup(feature.properties.nom)); }
          else if (feature.properties.section == "MSI") {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeMSI}).bindPopup(feature.properties.nom)); }
          else if (feature.properties.section == "EGC") {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeEGC}).bindPopup(feature.properties.nom)); }

          // Sinon, pas de section (weird)
					else {
						return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeIG}).bindPopup(feature.properties.nom)); }
				}
			});

      // Création de la carte et ajout des points
      var map = L.map('mapP', {
          twoFingerZoom: true
       }).fitBounds(markers.getBounds());
      mapboxTiles.addTo(map);
      map.addLayer(markers);
		});
	</script>
</body>
</html>
