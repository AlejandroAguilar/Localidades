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
    <script>
var map;
var Municipio;
var Agua;

function initialize() {

  var tlax = new google.maps.LatLng(19.425154,-98.168764); 
  map = new google.maps.Map(document.getElementById('map-canvas'), {
    center: tlax,
    zoom: 11
	/*
	mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
    },
    zoomControl: true,
    zoomControlOptions: {
      style: google.maps.ZoomControlStyle.SMALL
    }
	*/
  });
  
 var estado = <?php echo $_SESSION['estado']; ?>;
 var municipio = <?php echo $_SESSION['municipio']; ?>;
// alert('Estado :  '+estado+' : Municipio'+municipio); 
  
  municipios = new google.maps.FusionTablesLayer({
    query: {
      select: 'geometry',
	  // 6o Municipios
	  from: '1u4g-v_dGjxynq5J9FECdG-Iz7ffEHPQv2wnOndY',
	  where: 'idINEGI = <?php echo $_SESSION['municipio']; ?>'
      //where: 'Municipio = \'<?php echo $_SESSION['municipio']; ?>\''
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

/*
  var agem = new google.maps.FusionTablesLayer({
    query: {
      select: 'CVE_MUN',
        // 97 div
    from: '1hI7do_OfebBcaK7l83Z5aFZrF8v0OchYSsGGaC4',
    where: 'CVE_MUN = <?php echo $_SESSION['municipio']; ?>'   
    }
  });
  agem.setMap(map);
  */

  agua = new google.maps.FusionTablesLayer({
    query: {
      select: 'Agua',
        // 97 div
    from: '1miirQAOgEYQgFL0Wy5aCvLgGMqxHX141lkAz5A8',
   // where: 'Agua = 1'   
    } 
  });
  agua.setMap(map);

}
google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
  
   <!--
    <?php
		//echo "<br>";
		echo "Estado :".$_SESSION['estado'];
		echo "<br>";
		echo "Municipio:".$_SESSION['municipio'];
	//	echo "<br>";
	//	echo "Resultado:".$_SESSION['resultado'];
	?>
  -->  
    <div id="map-canvas"></div>
  </body>
</html>