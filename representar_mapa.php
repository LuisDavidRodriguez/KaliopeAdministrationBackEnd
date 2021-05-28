<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Using MySQL and PHP with Google Maps</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>

<html>
  <body>
  <?php
  //Recibimos las variables enviadas por get.
  $zona = $_GET['zona'];
  $fecha = $_GET['fecha'];
  $vehiculo = $_GET['vehiculo'];

   //creamos la coneccion a la base de datos
   try{
    $conexion = new PDO('mysql:host=localhost;dbname=kaliopec_kaliope', 'kaliopec_kaliope', '2408922007');
    }catch(PDOException $e){
    echo "Error".$e->getMessage();;
    }

    $polilinea = $conexion->prepare(
      "SELECT coordenadas FROM zonificacion WHERE zona = '$zona'"
    );
    $polilinea->execute();
    $polilinea = $polilinea->fetchAll();
    $coordenadas = $polilinea[0][0];
    $coordenadas = explode(' ', $coordenadas);
    $resultado = array();

    $i = 0;
    foreach ($coordenadas as $coordenada) {
      $datos = explode(',', $coordenadas[$i]);
      $resultado = array_merge($resultado, $datos);
      $i++;
      
    }

    $resultado = array_chunk($resultado, 3);
    


  ?>

    <div id="map"></div>

    <script>
      
      var image = 'http://maps.google.com/mapfiles/kml/pushpin/blue-pushpin.png';

      
        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(19.7968, -99.8765),
          zoom: 8
        });

        

        var flightPlanCoordinates = [
        {lat: <?php echo $resultado[0][1]?>, lng: <?php echo $resultado[0][0]?>},
        {lat: <?php echo $resultado[1][1]?>, lng: <?php echo $resultado[1][0]?>},
        {lat: <?php echo $resultado[2][1]?>, lng: <?php echo $resultado[2][0]?>},
        {lat: <?php echo $resultado[3][1]?>, lng: <?php echo $resultado[3][0]?>},
        {lat: <?php echo $resultado[4][1]?>, lng: <?php echo $resultado[4][0]?>},
        {lat: <?php if(empty($resultado[5][1])){echo $resultado[0][1];}else{echo $resultado[5][1];}?>, lng: <?php if(empty($resultado[5][0])){echo $resultado[0][0];}else{echo $resultado[5][0];}?>},
        {lat: <?php if(empty($resultado[6][1])){echo $resultado[0][1];}else{echo $resultado[6][1];}?>, lng: <?php if(empty($resultado[6][0])){echo $resultado[0][0];}else{echo $resultado[6][0];}?>},
        {lat: <?php if(empty($resultado[7][1])){echo $resultado[0][1];}else{echo $resultado[7][1];}?>, lng: <?php if(empty($resultado[7][0])){echo $resultado[0][0];}else{echo $resultado[7][0];}?>},
        {lat: <?php if(empty($resultado[8][1])){echo $resultado[0][1];}else{echo $resultado[8][1];}?>, lng: <?php if(empty($resultado[8][0])){echo $resultado[0][0];}else{echo $resultado[8][0];}?>},
        {lat: <?php if(empty($resultado[9][1])){echo $resultado[0][1];}else{echo $resultado[9][1];}?>, lng: <?php if(empty($resultado[9][0])){echo $resultado[0][0];}else{echo $resultado[9][0];}?>},
        {lat: <?php if(empty($resultado[10][1])){echo $resultado[0][1];}else{echo $resultado[10][1];}?>, lng: <?php if(empty($resultado[10][0])){echo $resultado[0][0];}else{echo $resultado[10][0];}?>},
        {lat: <?php if(empty($resultado[11][1])){echo $resultado[0][1];}else{echo $resultado[11][1];}?>, lng: <?php if(empty($resultado[11][0])){echo $resultado[0][0];}else{echo $resultado[11][0];}?>},
        {lat: <?php if(empty($resultado[12][1])){echo $resultado[0][1];}else{echo $resultado[12][1];}?>, lng: <?php if(empty($resultado[12][0])){echo $resultado[0][0];}else{echo $resultado[12][0];}?>},
        {lat: <?php if(empty($resultado[13][1])){echo $resultado[0][1];}else{echo $resultado[13][1];}?>, lng: <?php if(empty($resultado[13][0])){echo $resultado[0][0];}else{echo $resultado[13][0];}?>},
        {lat: <?php if(empty($resultado[14][1])){echo $resultado[0][1];}else{echo $resultado[14][1];}?>, lng: <?php if(empty($resultado[14][0])){echo $resultado[0][0];}else{echo $resultado[14][0];}?>},
        {lat: <?php if(empty($resultado[15][1])){echo $resultado[0][1];}else{echo $resultado[15][1];}?>, lng: <?php if(empty($resultado[15][0])){echo $resultado[0][0];}else{echo $resultado[15][0];}?>},
        {lat: <?php if(empty($resultado[16][1])){echo $resultado[0][1];}else{echo $resultado[16][1];}?>, lng: <?php if(empty($resultado[16][0])){echo $resultado[0][0];}else{echo $resultado[16][0];}?>},
        {lat: <?php if(empty($resultado[17][1])){echo $resultado[0][1];}else{echo $resultado[17][1];}?>, lng: <?php if(empty($resultado[17][0])){echo $resultado[0][0];}else{echo $resultado[17][0];}?>},
        {lat: <?php if(empty($resultado[18][1])){echo $resultado[0][1];}else{echo $resultado[18][1];}?>, lng: <?php if(empty($resultado[18][0])){echo $resultado[0][0];}else{echo $resultado[18][0];}?>},
        {lat: <?php if(empty($resultado[19][1])){echo $resultado[0][1];}else{echo $resultado[19][1];}?>, lng: <?php if(empty($resultado[19][0])){echo $resultado[0][0];}else{echo $resultado[19][0];}?>},
        {lat: <?php if(empty($resultado[20][1])){echo $resultado[0][1];}else{echo $resultado[20][1];}?>, lng: <?php if(empty($resultado[20][0])){echo $resultado[0][0];}else{echo $resultado[20][0];}?>},
        ];
        var flightPath = new google.maps.Polyline({
        path: flightPlanCoordinates,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
        });

        flightPath.setMap(map);


        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('http://localhost/kaliope/coordenadas_clientes.php?zona=<?php echo $zona?>&fecha=<?php echo $fecha?>&vehiculo=<?php echo $vehiculo?>', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = 'Estado:' + address + '     Hora:' + id + '     Velocidad:' + type;
              infowincontent.appendChild(text);

                if (address == 'LIO') {
                    image = 'http://maps.google.com/mapfiles/kml/pushpin/red-pushpin.png';
                }

                if (address == 'ACTIVO') {
                    image = 'http://maps.google.com/mapfiles/kml/pushpin/blue-pushpin.png';
                }

                if (address == 'REACTIVAR') {
                    image = 'http://maps.google.com/mapfiles/kml/pushpin/ylw-pushpin.png';
                }

                if (address == 1) {
                    image = 'http://maps.google.com/mapfiles/kml/shapes/placemark_circle.png';
                    name = '';
                }

                if (address == 0) {
                    image = 'http://maps.google.com/mapfiles/kml/shapes/cross-hairs.png';
                    name = '';
                }

              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: name,
                icon: image
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAs8lk-9vH8GRYfvBzWxqqhUGnJE2gSji8&callback=initMap">
    </script>
  </body>
</html>