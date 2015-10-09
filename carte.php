<!doctype html>
<html>
<head>
  <title>Polymap de tests</title>
  <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.css" />
  <!--[if lte IE 8]>
     <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.ie.css" />
  <![endif]-->
  <link rel="stylesheet" href="polymap.css" />
  <script src="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="scripting/cluster.js"></script>
  <link rel="stylesheet" href="scripting/cluster.css" />
  <script src="scripting/filtres.js"></script>
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
        <div id="filt_FormContent">
          <label>
            <input type="radio" name="section" value="all" checked />
            <img src="files/picto/POLY.png" width="64px" height="64px" />
          </label>
          <label>
            <input type="radio" name="section" value="IG" />
            <img src="files/picto/IG.png" width="64px" height="64px" />
          </label>
          <label>
            <input type="radio" name="section" value="EGC" />
            <img src="files/picto/EGC.png" width="64px" height="64px" />
          </label>
          <label>
            <input type="radio" name="section" value="MAT" />
            <img src="files/picto/MAT.png" width="64px" height="64px" />
          </label>
          <label>
            <input type="radio" name="section" value="MEA" />
            <img src="files/picto/MEA.png" width="64px" height="64px" />
          </label>
          <label>
            <input type="radio" name="section" value="MI" />
            <img src="files/picto/MI.png" width="64px" height="64px" />
          </label>
          <label>
            <input type="radio" name="section" value="MSI" />
            <img src="files/picto/MSI.png" width="64px" height="64px" />
          </label>
          <label>
            <input type="radio" name="section" value="SE" />
            <img src="files/picto/SE.png" width="64px" height="64px" />
          </label>
          <label>
            <input type="radio" name="section" value="STE" />
            <img src="files/picto/STE.png" width="64px" height="64px" />
          </label>
          <label>
            <input type="radio" name="section" value="STIA" />
            <img src="files/picto/STIA.png" width="64px" height="64px" />
          </label>
        </div>

        <div id="filt_FormSpaceButton">
          <img src="files/gotowork.png" alt="Appliquer" width="110" height="110" onclick="appliquerFiltres();" />
        </div>
      </form>


  </div>

	<script>
    // Définition des icônes des sections
    var icones = new Array();
		icones["EGC"] = L.icon({
			iconUrl: 'files/picto/EGC.png',
			shadowUrl: null, iconSize: [26, 26],
      iconAnchor: [13, 13], popupAnchor:  [0, -10]
		});
		icones["IG"] = L.icon({
			iconUrl: 'files/picto/IG.png',
			shadowUrl: null, iconSize: [26, 26],
      iconAnchor: [13, 13], popupAnchor:  [0, -10]
		});
		icones["MAT"] = L.icon({
			iconUrl: 'files/picto/MAT.png',
			shadowUrl: null, iconSize: [26, 26],
      iconAnchor: [13, 13], popupAnchor:  [0, -10]
		});
    icones["MEA"] = L.icon({
			iconUrl: 'files/picto/MEA.png',
			shadowUrl: null, iconSize: [26, 26],
      iconAnchor: [13, 13], popupAnchor:  [0, -10]
		});
    icones["MI"] = L.icon({
			iconUrl: 'files/picto/MI.png',
			shadowUrl: null, iconSize: [26, 26],
      iconAnchor: [13, 13], popupAnchor:  [0, -10]
		});
    icones["MSI"] = L.icon({
			iconUrl: 'files/picto/MSI.png',
			shadowUrl: null, iconSize: [26, 26],
      iconAnchor: [13, 13], popupAnchor:  [0, -10]
		});
    icones["SE"] = L.icon({
			iconUrl: 'files/picto/SE.png',
			shadowUrl: null, iconSize: [26, 26],
      iconAnchor: [13, 13], popupAnchor:  [0, -10]
		});
    icones["STE"] = L.icon({
			iconUrl: 'files/picto/STE.png',
			shadowUrl: null, iconSize: [26, 26],
      iconAnchor: [13, 13], popupAnchor:  [0, -10]
		});
    icones["STIA"] = L.icon({
			iconUrl: 'files/picto/STIA.png',
			shadowUrl: null, iconSize: [26, 26],
      iconAnchor: [13, 13], popupAnchor:  [0, -10]
		});

    // Imagerie Mapbox
    var mapboxTiles =  L.tileLayer('http://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    	attribution: 'Tuiles depuis <a href="http://mapbox.com/about/maps/">MapBox</a> &mdash; Données cartographiques &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    	subdomains: 'abcd',
    	id: 'kevinse.cifidxh3100woucknrdf98z2y',
    	accessToken: 'pk.eyJ1Ijoia2V2aW5zZSIsImEiOiJjaWZpZHhoOWkwMHdndGNseGRxc3A0d3U1In0.N5FbDKd9BQlcYh8bwsLVCA'
    });

    var map = L.map('mapP', {
        twoFingerZoom: true,
        maxZoom: 18
     });
     var overlays = L.layerGroup().addTo(map);

    // Les markers peuveur être rassemblés quand on est en dézoomé
    var markers = new L.MarkerClusterGroup({
      iconCreateFunction: function(cluster) {
          return new L.DivIcon({ html: '<b>' + cluster.getChildCount() + '</b>', className: 'mycluster', iconSize: L.point(40, 40)});
      }
    }).addTo(overlays);
    var geojson;
    // Parcours du fichier geojson pour ajouter les points
		$.getJSON("files/students.geojson", function(data) {
			geojson = L.geoJson(data, {
				pointToLayer: function(feature, latlng) {
          return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: icones[feature.properties.section]}).bindPopup(feature.properties.nom));
				}
			});

      // Création de la carte et ajout des points
      map.fitBounds(markers.getBounds());
      mapboxTiles.addTo(map);
      map.addLayer(markers);

		});

    function appliquerFiltres() {
      var checkedSection = $('input[name=section]:checked', '#filt_Form').val();
      overlays.clearLayers();
      markers = new L.MarkerClusterGroup({
        iconCreateFunction: function(cluster) {
            return new L.DivIcon({ html: '<b>' + cluster.getChildCount() + '</b>', className: 'mycluster', iconSize: L.point(40, 40)});
        }
      }).addTo(overlays);

      $.getJSON("files/students.geojson", function(data) {
  			geojson = L.geoJson(data, {
  				pointToLayer: function(feature, latlng) {
            return markers.addLayer(new L.Marker(new L.LatLng(feature.geometry.coordinates[1],feature.geometry.coordinates[0]),{icon: icones[feature.properties.section]}).bindPopup(feature.properties.nom));
  				},
          filter: function(feature, layer) {
            return (feature.properties.section == checkedSection) || checkedSection == "all";
          }
  			})
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
