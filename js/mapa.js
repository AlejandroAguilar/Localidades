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

$(function() {
  //  findCity('Tlaxcala');
    ciudad();
  //    ciudad('Tlaxcala');
});

//function createMap(center) {
  function hazMap(center) {
    var opts = {
        zoom: 10,
        center: center,     
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    return new google.maps.Map(document.getElementById('map'), opts);
}

//function findCity(city) {
  function ciudad() {
  //function ciudad(city) {
  //  var gc = new google.maps.Geocoder();
  //  gc.geocode({address: city}, function(results, status) {
   //     if (status == google.maps.GeocoderStatus.OK) {
         //   var pos = results[0].geometry.location;
            var pos = new google.maps.LatLng(19.425154,-98.168764); 
         //   map = createMap(pos);
            map = hazMap(pos);


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

            localidades  = new google.maps.FusionTablesLayer({
              query: {
                select: 'Localidad',
                  // 1928 municipios
              from: '1Y_JMPbool_hSODXyKDbtWNeeZTES3w8LajOmfr0',
              //ID de mi Tabla
                //where: 'Municipio = \'Chiautempan\''
                where: 'ClaveMunicipio = <?php echo $_SESSION['municipio']; ?>'   
                //where: 'Municipio = \'<?php echo $_SESSION['municipio']; ?>\''
              }/*,
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
                from: '1miirQAOgEYQgFL0Wy5aCvLgGMqxHX141lkAz5A8',
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
              }] 
            });
            //servicioAgua.setMap(map);     

            servicioAguaAdeudo = new google.maps.FusionTablesLayer({
                query: {
                  select: 'Agua',
                    // Puntos Azar
                from: '1miirQAOgEYQgFL0Wy5aCvLgGMqxHX141lkAz5A8',
                where: 'Agua = 0'
                },
              styles: [{
                where: 'Agua = 0',
                markerOptions: {
                     iconName: "a"
                }
              }] 
            }); 

            servicioAguaCorriente = new google.maps.FusionTablesLayer({
                query: {
                  select: 'Agua',
                    // Puntos Azar
                from: '1miirQAOgEYQgFL0Wy5aCvLgGMqxHX141lkAz5A8',
                where: 'Agua = 1'
                },
              styles: [{
                where: 'Agua = 1',
                markerOptions: {
                     iconName: "a_blue"
                }
              }] 
            }); 

            servicioPredial = new google.maps.FusionTablesLayer({
                query: {
                  select: 'Predial',
                    // Puntos Azar
                from: '1miirQAOgEYQgFL0Wy5aCvLgGMqxHX141lkAz5A8',
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
              }]  
            });
          //  servicioPredial.setMap(map);   

          servicioPredialAdeudo = new google.maps.FusionTablesLayer({
                query: {
                  select: 'Predial',
                    // Puntos Azar
                from: '1miirQAOgEYQgFL0Wy5aCvLgGMqxHX141lkAz5A8',
                //from: '<?php echo "Municipio:".$_SESSION['tabla']; ?>',
                where: 'Predial = 0'   
                },
              styles: [{
                where: 'Predial = 0',
                markerOptions: {
                     iconName: "p"
                }
              }]  
            });

          servicioPredialCorriente = new google.maps.FusionTablesLayer({
                query: {
                  select: 'Predial',
                    // Puntos Azar
                from: '1miirQAOgEYQgFL0Wy5aCvLgGMqxHX141lkAz5A8',
                //from: '<?php echo "Municipio:".$_SESSION['tabla']; ?>',
                where: 'Predial = 1'   
                },
              styles: [{
                where: 'Predial = 1',
                markerOptions: {
                     iconName: "p_blue"
                }
              }]  
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

    //        $('#servicioAguaAdeudo_radio').click(function(){
    //            servicioAguaAdeudo.setMap($(this).is(':checked') ? map : null);
    //        });
            $('#servicioAguaAdeudo_radio').click(function(){
                    borraPredial();
                    servicioAguaCorriente.setMap(null);
                    servicioAgua.setMap(null);
                    servicioAguaAdeudo.setMap(map);
            });

     //       $('#servicioAguaCorriente_radio').click(function(){
     //           servicioAguaCorriente.setMap($(this).is(':checked') ? map : null);
     //       });
            $('#servicioAguaCorriente_radio').click(function(){     
                    borraPredial();               
                    servicioAgua.setMap(null);
                    servicioAguaAdeudo.setMap(null);
                    servicioAguaCorriente.setMap(map);
            });

            //$('#servicioPredial_radio').click(function(){
            //    servicioPredial.setMap($(this).is(':checked') ? map : null);
            //});

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

   //     } // if
 //   }); // geocode
}