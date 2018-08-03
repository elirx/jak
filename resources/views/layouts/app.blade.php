<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


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
        font-family: 'jazeera' !important;
      }
      table {
        border-collapse: collapse;
        border-spacing: 0px;
      }

      .card {
          border: 1px #fff solid;
          height: 80%;
          margin: 5px 20px;

          border-radius: 0px 40px 0px 40px !important;
          padding: 30px 10px;
          /* background-color: #272d36 !important; */
          color: #fff;
          background-image: url('{{ asset('img/cardbg.png') }}');
          background-position: left bottom;
          background-repeat: no-repeat;

      }
    </style>
    <link rel="stylesheet" type="text/css" href="http://www.fontstatic.com/f=jazeera" />

    <!-- Styles -->
    <link href="{{ asset('css/boot.css') }}" rel="stylesheet">
</head>
<body>

    @yield('content')

    <script>
      var map, heatmap;
      var markers = [];
      function initMap() {
        var myLatLng = {lat: 21.422510, lng: 39.826168};
        var myLatLng2 = {lat: 21.422310, lng: 39.826128};
        var image1 = "{{ asset('img/1.png') }}";
        var image2 = "{{ asset('img/2.png') }}";
        var image3 = "{{ asset('img/3.png') }}";
        var image4 = "{{ asset('img/4.png') }}";



        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: myLatLng,
          styles: [
            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#263c3f'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#6b9a76'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#38414e'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#212a37'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#9ca5b3'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#746855'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#1f2835'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#f3d19c'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#2f3948'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#17263c'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#17263c'}]
            }
          ]
        });

        // This event listener will call addMarker() when the map is clicked.
        map.addListener('click', function(event) {
            $('#send').attr('data-wm', event.latLng);
            $("#ll").text(event.latLng);
            $('#exampleModal').modal('show');

        });


        google.maps.event.addListener(map, 'click', find_closest_marker);


        function rad(x) {return x*Math.PI/180;}
        function find_closest_marker( event ) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            var R = 6371; // radius of earth in km
            var distances = [];
            var closest = -1;
            for( i=0;i<markers.length; i++ ) {
                if(markers[i].type !='medic') {
                    continue;
                }
                var mlat = markers[i].position.lat();
                var mlng = markers[i].position.lng();
                var dLat  = rad(mlat - lat);
                var dLong = rad(mlng - lng);
                var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                var d = R * c;
                distances[i] = d;
                if ( closest == -1 || d < distances[closest] ) {
                    closest = i;
                }
            }

            // alert(markers[closest].title);
            var fromLat = markers[closest].getPosition().lat();
            var fromLong = markers[closest].getPosition().lng();

            $("#send").attr('data-lat', fromLat);
            $("#send").attr('data-lng', fromLong);
            // console.log(fromLat);
            // console.log(fromLong);

        }

        // map.markers = map.markers || [];

        // Adds a marker to the map and push to the array.
        function addMarker(location, icon, type, typear) {
          var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: type + "  " + Math.random(),
            icon: icon,
            type: type,
            typear: typear
          });

          marker.addListener('click', function() {
              $('#info').modal('show');
              $(".user-info").text(typear);
          });
          markers.push(marker);
          // map.markers.push(marker);
        }

        var heatmap = new google.maps.visualization.HeatmapLayer({
          data: getPoints(),
          map: map
        });

        directionsDisplay.setMap(map);

        // Heatmap data: 500 Points
      function getPoints() {
        return [
          new google.maps.LatLng(21.422510, 39.826168),
          new google.maps.LatLng(21.422520, 39.826178),
          new google.maps.LatLng(21.422420, 39.824178),
          new google.maps.LatLng(21.422220, 39.820178),
          new google.maps.LatLng(21.422120, 39.824118),

        ];
      }

      function Route(a, b, c, d) {

          var start = new google.maps.LatLng(b, a);
          var end = new google.maps.LatLng(c, d);
          var request = {
              origin:start,
              destination:end,
              travelMode: google.maps.TravelMode.WALKING
           };
           directionsService.route(request, function(result, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
          }
          });
      }


      heatmap.set('radius', 100);

        // var markers = [];
        // for (var i = 0; i < 3; i++) {
        //   var markers + Math.random() = new google.maps.Marker({
        //     position: myLatLng,
        //     map: map,
        //     title: 'Hello World!',
        //     // icon: image
        //   });
        // }


// var t=setInterval(function(){



        for (var i = 0; i < 300; i++) {
          // new google.maps.Marker({
          //   position: ,
          //   map: map,
          //   title: 'Hello World!',
          //   icon: image
          // });
          addMarker({lat: 21.2531+Math.random(), lng: 39.5439+Math.random()}, image1, 'medic', 'المسعفين');
        }

        for (var i = 0; i < 300; i++) {
          // new google.maps.Marker({
          //   position: ,
          //   map: map,
          //   title: 'Hello World!',
          //   icon: image
          // });
          addMarker({lat: 21.2531+Math.random(), lng: 39.5439+Math.random()}, image2, 'fire', 'رجال الاطفاء');
        }

        for (var i = 0; i < 300; i++) {
          // new google.maps.Marker({
          //   position: ,
          //   map: map,
          //   title: 'Hello World!',
          //   icon: image
          // });
          addMarker({lat: 21.2531+Math.random(), lng: 39.5439+Math.random()}, image3, 'police', 'الشرطة');
        }

        for (var i = 0; i < 300; i++) {
          // new google.maps.Marker({
          //   position: ,
          //   map: map,
          //   title: 'Hello World!',
          //   icon: image
          // });
          addMarker({lat: 21.2531+Math.random(), lng: 39.5439+Math.random()}, image4, 'scout', 'الكشافة');
        }



        $("#send").click(function(){
            // wait aprrove or remove




            var a = $(this).attr('data-lng');
            var b = $(this).attr('data-lat');
            var ot2 = $(this).attr('data-wm');
            ot2 = ot2.substring(1, ot2.length-1);
            ot2 = ot2.split(',');
            var desc = $("#desc").val();

            $('#exampleModal').modal('hide');


            var idID = '';
            $.post( "{{ url('reports') }}", { lat_to: a, long_to: b, description: desc, lat_from:ot2[0], long_from:ot2[1]  })
              .done(function( data ) {
                // alert( "Data Loaded: " + data );
                // Route(a, b, ot2[0], ot2[1]);
                idID = data;
              });






        });
          
          var ss = setInterval(function(data){
                  $.get( "{{ url('reports') }}" )
                    .done(function( data ) {
                        if(data.status == 'accepted'){
                            Route(data.long_from, data.lat_from, data.long_to, data.lat_to);
                            clearInterval(ss);
                        }
                    });
              }, 2000);


// },1000);








      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn77UVHKscWuVp5TcOmUB6gqMfAEfe7z8&callback=initMap&libraries=visualization"
    async defer></script>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
