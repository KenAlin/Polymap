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
  <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<body>
  <div id="mapP"></div>

  <div id="filt_Open">
    <a href="#" onclick="afficheFiltres();" id="filt_OpenLink">Afficher les filtres</a>
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

		var mapTiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			maxZoom: 18
		});

		$.getJSON("files/mapHT.geojson", function(data) {
			var geojson = L.geoJson(data, {
				onEachFeature: function (feature, layer) {
					layer.bindPopup(feature.properties.nom);
				},
				pointToLayer: function(feature, latlng) {
					if (feature.properties.acces_pmr == "oui") {
						return new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeIG}); }
					else if (feature.properties.abri == "oui") {
						return new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeSTE}); }
					else {
						return new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: iconeSTIA}); }
				}
			});
			var map = L.map('mapP').fitBounds(geojson.getBounds());
			mapTiles.addTo(map);
			geojson.addTo(map);
		});
	</script>
</body>
</html>
