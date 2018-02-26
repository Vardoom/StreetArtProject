<?php

echo <<<END
</div>
    <div id="map"></div>

    <script>
      var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(48.8786193, 2.3188043000000107),
          zoom: 12,
          mapTypeId: 'hybrid',
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('utilities/XMLgenerator.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('nom');
              var utilisateur = markerElem.getAttribute('utilisateur');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent ='<i class="material-icons" size="50%">party_mode</i>'+'<p></p>'+'<strong style="text-transform:uppercase;font-family:Impact;font-size:30px">'+name+'     </strong>'+
                  '<a href="http://localhost/StreetArtProject2/StreetArtProject/index.php?page=description&todo='+name+id+'&iD='+id+'">'+'(Voir)'+'</a>'+
                  '<br>'+'<br>'+'<img src="miniatures/mini_'+ utilisateur + id + '.jpg">';    
              var marker = new google.maps.Marker({
                map: map,
                position: point,

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
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBBdxZ0rHyuuYMsy0CcuhqpwYKnvKQb8M&callback=initMap">
    </script>
    <div>
END;
