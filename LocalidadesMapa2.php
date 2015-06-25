<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Google Maps + Fusion Tables</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>
var map;
var Municipio;
var Agua;

$(function() {
      iniciar();
});

function iniciar() {

  var tlax = new google.maps.LatLng(19.425154,-98.168764); 
  map = new google.maps.Map(document.getElementById('map-canvas'), {
    center: tlax,
    zoom: 11
  });
  
 var estado = <?php echo $_SESSION['estado']; ?>;
 var municipio = <?php echo $_SESSION['municipio']; ?>;
  
  municipios = new google.maps.FusionTablesLayer({
    query: {
      select: 'geometry',
	  // 6o Municipios
	  from: '1u4g-v_dGjxynq5J9FECdG-Iz7ffEHPQv2wnOndY',
	  where: 'idINEGI = <?php echo $_SESSION['municipio']; ?>'
    },
    styles: [{
      polygonOptions: {
        fillColor: '#080844',
        fillOpacity: 0.3
      }
    }, {
      where: 'idINEGI > 0 and idINEGI < 14',
      polygonOptions: {
      fillColor: '#66FF33'  
      }
    }, {
      where: 'idINEGI > 13 and idINEGI < 26',
      polygonOptions: {
      fillColor: '#FFFFCC'  
      }
    }, {
      where: 'idINEGI > 25 and idINEGI < 38',
      polygonOptions: {
      fillColor: '#9999FF'  
      }
    }, {
      where: 'idINEGI > 37 and idINEGI < 49',
      polygonOptions: {
      fillColor: '#FF6600'   
      }
    }]  
  });
  municipios.setMap(map);
  
  var consulta = new google.maps.FusionTablesLayer({
    query: {
      select: 'Localidad',
	  	  // 1928 municipios
	  from: '1Y_JMPbool_hSODXyKDbtWNeeZTES3w8LajOmfr0',
	  //ID de mi Tabla
      //where: 'Municipio = \'Chiautempan\''
      where: 'ClaveMunicipio = <?php echo $_SESSION['municipio']; ?>'	  
      //where: 'Municipio = \'<?php echo $_SESSION['municipio']; ?>\''
    }
  });
  consulta.setMap(map);


    $('#municipios_box').click(function(){
        municipios.setMap($(this).is(':checked') ? map : null);
    });

    $('#localidades_box').click(function(){
        consulta.setMap($(this).is(':checked') ? map : null);
    });

}
//google.maps.event.addDomListener(window, 'load', iniciar);

    </script>
  </head>
  <body>
 
  <h1>Tlaxcala</h1>
  <p>
  <label><input type="checkbox" id="municipios_box" enabled="true" checked>Municipio</label>
  <label><input type="checkbox" id="localidades_box" enabled="true" checked>Localidades</label>
  </p> 
 
    <div id="map-canvas"></div>
  </body>
</html>