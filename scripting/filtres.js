function afficheFiltres() {
  document.getElementById('filtres').style.display='block';
  document.getElementById('filt_Open').style.display='none';

  var myClasses = document.querySelectorAll('.leaflet-control-attribution'),
    i = 0,
    l = myClasses.length;

  for (i; i < l; i++) {
    myClasses[i].style.display = 'none';
  }
}

function masqueFiltres() {
  document.getElementById('filtres').style.display='none';
  document.getElementById('filt_Open').style.display='block';

  var myClasses = document.querySelectorAll('.leaflet-control-attribution'),
    i = 0,
    l = myClasses.length;

  for (i; i < l; i++) {
    myClasses[i].style.display = 'block';
  }
}
