<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Tlaxcala: Google Maps + Fusion Tables</title>
<style>
    h1,h3,h4,p { 
        text-align: center; 
        font-family: Tahoma; 
    }

    html, body, #map { 
        height: 100%;
        height: 90%; 
        margin: 0px;
        padding: 0px 
    }
</style>

<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
-->
<script src="js/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<!--
  https://developers.google.com/speed/libraries/devguide
  http://jsfiddle.net/EeVUr/2/
  https://developers.google.com/maps/documentation/javascript/libraries

<script type="text/javascript" src="js/mapa.js"></script>
-->
<script>

var map;

function borraAgua(){
      municipios.setMap(null);
      servicioAguaCorriente.setMap(null);
      servicioAgua.setMap(null);
      servicioAguaAdeudo.setMap(null);
}

function borraPredial(){
      municipios.setMap(null);
      servicioPredialCorriente.setMap(null);
      servicioPredial.setMap(null);
      servicioPredialAdeudo.setMap(null);
}

function separa(cadena){
 //     alert(cadena);
      var res = cadena.split("</b>");
      res.splice(0, 1);

      for (var i=0;i<res.length-1;i++){ 
        aux = res[i].split("<br>");
        res[i] = aux[0];
      }
      
      aux = res[5].split("</div>");
      res[5] = aux[0];

      return res;
      // 0 : ID
      // 1 : idEstadoMunicipio
      // 2 : Agua(0/1)
      // 3 : Predial(0/1)
      // 4 : latitud
      // 5 : longitud
}

// Saco la información de cada marca
function windowControl(e, infoWindow, map) {   
        var cadena = e.infoWindowHtml;
        var info = separa(cadena);

  //      for (var i=0;i<info.length;i++)
  //      { 
  //        alert(info[i]);
  //      }

}

// Open the info window at the clicked location
function infoWindowControl(e, infoWindow, map) {

        var cadena = e.infoWindowHtml;
        var info = separa(cadena);
 //       for (i=0;i<info.length;i++)
 //           alert(info[i]);

        var lugar = new google.maps.LatLng(info[4],info[5]); 

        final = cambiaTexto(info);

        infoWindow.setOptions({
          content: final,
          position: lugar,
          maxWidth: 250
        });
        infoWindow.open(map);

}

function cambiaTexto(textoArray){
//'<div class='googft-info-window'>'+
//'<div style='width: 130px; height: 220px; overflow: auto;'>'+

if (textoArray[2] == 1){
              aux1 = '<b>Agua:</b> Pago al corriente<br>';
}else{
              aux1 = '<b>Agua:</b> Pago atrasado<br>';
}
if (textoArray[3] == 1){
              aux2 ='<b>Predial:</b> Pago al corriente<br>';
}else{
              aux2 ='<b>Predial:</b> Pago atrasado<br>';
}             

var text1 = '<h4 style="color: Red" >Propiedad: '+textoArray[0]+'</h4>'+
            '<b>id Estado Municipio:</b>'+textoArray[1]+'<br>'+
            aux1+aux2+'</div>';

return text1;

}

$(function() {
    ciudad();
});

function hazMap(center) {
    var opts = {
        zoom: 10,
        center: center,     
        mapTypeId: google.maps.MapTypeId.ROADMAP
      //  mapTypeId: google.maps.MapTypeId.HYBRID
    };
    return new google.maps.Map(document.getElementById('map'), opts);
}

var infoWindow = new google.maps.InfoWindow();

  function ciudad() {

            var pos = new google.maps.LatLng(19.425154,-98.168764); 
            var tableIdGeometria = '1u4g-v_dGjxynq5J9FECdG-Iz7ffEHPQv2wnOndY';
            var tableIdLocalidades = '1Y_JMPbool_hSODXyKDbtWNeeZTES3w8LajOmfr0';
            var tableIdAzar = '1KjV93dsSsNrvg3GIyE15i69-EbuTbTP9s2ZMTxY';
            map = hazMap(pos);

            var infoWindow = new google.maps.InfoWindow();

            municipios = new google.maps.FusionTablesLayer({
              query: {
                select: 'geometry',
              // 6o Municipios
              from: tableIdGeometria,
              //where: 'idINEGI = <?php echo $_SESSION['municipio']; ?>'
              where: 'idEstadoMunicipio = <?php echo $_SESSION['municipio']; ?>'
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
              }],
              styleId: 2,
              templateId: 2,
              suppressInfoWindows: true   
            });
            municipios.setMap(map);

            localidades  = new google.maps.FusionTablesLayer({
              query: {
                select: 'Localidad',
                  // 1928 localidades
                from: tableIdLocalidades,
                where: 'idEstadoMunicipio = <?php echo $_SESSION['municipio']; ?>'   
                //where: 'Municipio = \'<?php echo $_SESSION['municipio']; ?>\''
              },
              styleId: 2,
              templateId: 2,
              suppressInfoWindows: true  
              /*,
              styles: [{
                markerOptions: {
                     iconName: "buildings"
                }
              }] */
            });
            localidades.setMap(map); 

            servicioAgua = new google.maps.FusionTablesLayer({
                query: {
                  select: 'Agua',
                    // Puntos Azar
                    // Se debe cambiar de acuerdo al municipio !
                from: tableIdAzar,
                },
              styles: [{
                where: 'Agua = 1',
                markerOptions: {
                     iconName: "a_blue"
                }
              }, {
                where: 'Agua = 0',
                markerOptions: {
                     iconName: "a"
                }
              }],
              templateId: 2,
              suppressInfoWindows: true   
            });
            //servicioAgua.setMap(map);     

            servicioAguaAdeudo = new google.maps.FusionTablesLayer({
                query: {
                  select: 'Agua',
                    // Puntos Azar
                from: tableIdAzar,
                where: 'Agua = 0'
                },
              styles: [{
                where: 'Agua = 0',
                markerOptions: {
                     iconName: "a"                  
                }
              }],
              templateId: 2,
              suppressInfoWindows: true   
            }); 

            servicioAguaCorriente = new google.maps.FusionTablesLayer({
                query: {
                  select: 'Agua',
                    // Puntos Azar
                 from: tableIdAzar,
                 where: 'Agua = 1'
                 },
                 styles: [{
                 where: 'Agua = 1',
                 markerOptions: {
                 iconName: "a_blue"
                }
              }],
              templateId: 2,
              suppressInfoWindows: true   
            }); 

            servicioPredial = new google.maps.FusionTablesLayer({
                query: {
                  select: 'Predial',
                    // Puntos Azar
                from: tableIdAzar,
                //from: '<?php echo "Municipio:".$_SESSION['tabla']; ?>',
               // where: 'Predial = 1'   
                },
              styles: [{
                where: 'Predial = 1',
                markerOptions: {
                     iconName: "p_blue"
                }
              }, {
                where: 'Predial = 0',
                markerOptions: {
                     iconName: "p"
                }
              }],
              templateId: 2,
              suppressInfoWindows: true    
            });
          //  servicioPredial.setMap(map);   

          servicioPredialAdeudo = new google.maps.FusionTablesLayer({
                query: {
                  select: 'Predial',
                    // Puntos Azar
                from: tableIdAzar,
                //from: '<?php echo "Municipio:".$_SESSION['tabla']; ?>',
                where: 'Predial = 0'   
                },
              styles: [{
                where: 'Predial = 0',
                markerOptions: {
                iconName: "p"
                }
              }],
              templateId: 2,
              suppressInfoWindows: true    
            });

          servicioPredialCorriente = new google.maps.FusionTablesLayer({
                query: {
                select: 'Predial',
                    // Puntos Azar
                from: tableIdAzar,
                //from: '<?php echo "Municipio:".$_SESSION['tabla']; ?>',
                where: 'Predial = 1'   
                },
              styles: [{
                where: 'Predial = 1',
                markerOptions: {
                iconName: "p_blue"
                }
              }],
              templateId: 2,
              suppressInfoWindows: true   
            });

            google.maps.event.addListener(servicioAgua, 'click', function(e) {
             //      windowControl(e, infoWindow, map);
                   infoWindowControl(e, infoWindow, map);
            });
            google.maps.event.addListener(servicioAguaAdeudo, 'click', function(e) {
            //       windowControl(e, infoWindow, map);
                   infoWindowControl(e, infoWindow, map);
            });
            google.maps.event.addListener(servicioAguaCorriente, 'click', function(e) {
             //      windowControl(e, infoWindow, map);
                   infoWindowControl(e, infoWindow, map);
            });
            google.maps.event.addListener(servicioPredial, 'click', function(e) {
            //       windowControl(e, infoWindow, map);
                   infoWindowControl(e, infoWindow, map);
            });
            google.maps.event.addListener(servicioPredialAdeudo, 'click', function(e) {
             //      windowControl(e, infoWindow, map);
                   infoWindowControl(e, infoWindow, map);
            });
            google.maps.event.addListener(servicioPredialCorriente, 'click', function(e) {
              //     windowControl(e, infoWindow, map);
                   infoWindowControl(e, infoWindow, map);
            });


            $('#localidades_box').click(function(){
                localidades.setMap($(this).is(':checked') ? map : null);
            });
          //  $('#localidades_box').click(function(){
         //       if ( $(this).is(':checked') ) {
          //          localidades.setMap(map);
          //      }else{
          //          servicioAgua.setMap(null);
          //      }
          //  });
              
           // $('#municipios_box').click(function(){
           //     municipios.setMap($(this).is(':checked') ? map : null);
           // });            

            $('#municipios_box').click(function(){
                if ( $(this).is(':checked') ) {
                    borraPredial();
                    borraAgua();
                    municipios.setMap(map);
                }else{
                    municipios.setMap(null);
                }
            });

            $('#servicioAgua_radio').click(function(){
                    borraPredial();
                    servicioAguaCorriente.setMap(null);
                    servicioAguaAdeudo.setMap(null);
                    servicioAgua.setMap(map);
            });

            $('#servicioAguaAdeudo_radio').click(function(){
                    borraPredial();
                    servicioAguaCorriente.setMap(null);
                    servicioAgua.setMap(null);
                    servicioAguaAdeudo.setMap(map);
            });

            $('#servicioAguaCorriente_radio').click(function(){     
                    borraPredial();               
                    servicioAgua.setMap(null);
                    servicioAguaAdeudo.setMap(null);
                    servicioAguaCorriente.setMap(map);
            });

            $('#servicioPredial_radio').click(function(){     
                    borraAgua();                                   
                    servicioPredialAdeudo.setMap(null);
                    servicioPredialCorriente.setMap(null);
                    servicioPredial.setMap(map);
            });

            $('#servicioPredialAdeudo_radio').click(function(){     
                    borraAgua();               
                    servicioPredial.setMap(null);                    
                    servicioPredialCorriente.setMap(null);
                    servicioPredialAdeudo.setMap(map);
            });

            $('#servicioPredialCorriente_radio').click(function(){     
                    borraAgua();              
                    servicioPredial.setMap(null);
                    servicioPredialAdeudo.setMap(null);
                    servicioPredialCorriente.setMap(map);
            });
}
      
      google.maps.event.addDomListener(window, 'load', initialize);

</script>

</head>
<body>
<!--
  <?php
    echo "Estado :".$_SESSION['estado'];
    echo "<br>";
    echo "Municipio:".$_SESSION['municipio'];
    echo "<br>";
    echo "Municipio:".$_SESSION['tabla'];
  ?>
-->
<h1>Tlaxcala</h1>
<h3>Propiedades</h3>
<p>
  <label><input type="checkbox" id="municipios_box"  enabled="true" checked>Municipio</label>
  <label><input type="checkbox" id="localidades_box" enabled="true" checked >Localidades</label>
</p>
   
<table border="1" align="center">
<tr>
<th>Agua</th>
<th>Predial</th>
</tr>
<tr>
<td><label><input type="radio" id="servicioAgua_radio" name="grupo1" enabled="true" >Todas</label></td>
<td><label><input type="radio" id="servicioPredial_radio" name="grupo1" enabled="true" >Todas</label></td>
</tr>
<tr>
<td><label><input type="radio" id="servicioAguaAdeudo_radio" name="grupo1" enabled="true" >Adeudo</label></td>
<td><label><input type="radio" id="servicioPredialAdeudo_radio" name="grupo1" enabled="true" >Adeudo</label></td>
</tr>
<tr>
<td><label><input type="radio" id="servicioAguaCorriente_radio" name="grupo1" enabled="true" >Corriente</label> </td>
<td><label><input type="radio" id="servicioPredialCorriente_radio" name="grupo1" enabled="true" >Corriente</label></td>
</tr>
</table>
<br/>

<div id="map"></div>
</body>
</html>