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
  <title>A propos de Polymap</title>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <style>
    body{
    	margin:0;
    	color:#444;
    	font:400 16px/18px Roboto, sans-serif;
    }
    *,:after,:before{box-sizing:border-box}
    .pull-left{float:left}
    .pull-right{float:right}
    .clearfix:after,.clearfix:before{content:'';display:table}
    .clearfix:after{clear:both;display:block}

    .accordion-wrap{
    	top:0;
    	left:0;
    	right:0;
    	bottom:0;
    	padding:15px;
    	position:fixed;
    	background: url('files/about.png') no-repeat;
      background-size: cover;
    }
    .accordion{
    	width:95%;
    	margin:auto;
    	max-width:320px;
    	overflow:hidden;
    	border-radius:3px;
    	background:#B7AFA3;
    	box-shadow:0 17px 50px 0 rgba(0,0,0,.19),0 12px 15px 0 rgba(0,0,0,.24);
    }
    .accordion>a{
    	color:#374046;
    	padding:15px;
    	display:block;
    	text-decoration:none;
    	transition:all .3s ease-in-out 0s;
    }
    .accordion>a:not(:last-child){
    	border-bottom:1px solid rgba(0,0,0,.2);
    }
    .accordion>a:hover,
    .accordion>a.active{
    	background:#E8D0A9;
    }
    .accordion>a.active{
    	color:#B77F24;
    }
    .accordion>a>.alert-numb,
    .accordion>.sub-nav>a>.alert-numb{
    	color:#eee;
    	right:10px;
    	height:22px;
    	min-width:40px;
    	font-size:12px;
    	font-weight:600;
    	line-height:22px;
    	border-radius:15px;
    	text-align:center;
    	background:#665e51;
    }
    .accordion>a.active>.alert-numb,
    .accordion>.sub-nav>a.active>.alert-numb{
    	background:#d0a051;
    }
    .accordion .sub-nav{
    	color:#374046;
    	overflow:hidden;
    	background:#ecf0f1;
    }
    .accordion .sub-nav.open{
    	display:block;
    }
    .accordion .sub-nav a{
    	display:block;
    	color:inherit;
    	font-weight:300;
    	padding:10px 15px;
    	text-decoration:none;
    	transition:all .2s ease-in-out 0s;
    }
    .accordion .sub-nav a{
    	border:2px solid rgba(0,0,0,.1);
      font-weight: bold;
      margin: 2px 0;
    }
    .accordion .sub-nav a:hover{
    	background:#c2ced1;
    	box-shadow:5px 0 0 #8ca3a8 inset;
    }

    .accordion .html{
    	padding:15px;
    }
    .accordion .about-me{
    	text-align:center;
    	position:relative;
    }
    .accordion .about-me h4{
    	margin-bottom:10px;
      padding-bottom: 15px;
      font-size: 135%;
      border-bottom: dashed 1px #bbb;
    }
    .accordion .about-me p{
    	font-size:14px;
    	font-weight:300;
    	margin-bottom:0;
    }
  </style>
</head>
<body>
  <div class="accordion-wrap">
  	<div class="accordion">
  		<div class="sub-nav active">
  			<div class="html about-me">
  				<h4>Polymap</h4>
  				<p>La Polymap vous permet de situer partout dans le monde les stagiaires passés et présents de l'école Polytech  Montpellier.<br /><br />
            Sur la base d'un projet de Hugo Vautrin et Alexandre Lafaille.<br /><br />
            Repris par Benjamin Teisseyre, Dylan Levy, Ouassim Ben-Mosbah et Kévin Servigé, étudiants en Informatique et Gestion à Polytech Montpellier.
            </p>
          <br />
          <a href="https://github.com/KenAlin/Polymap" target="_blank"><i class="fa fa-github"></i> Github</a>
          <a href="http://polytech-montpellier.fr" target="_blank">Polytech Montpellier</a>
          <p style="font-style: italic;">Façonné en octobre 2015.</p>
  			</div>
  		</div>
  	</div>
  </div>
</body>
</html>
