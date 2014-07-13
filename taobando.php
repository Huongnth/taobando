<?php    //connect database
  mysql_connect("localhost", "root", "") or die ("Faile to connect!");
  mysql_select_db("mydb") or die ("Can't not find this database!");
  
  ?>
 <?php
     $temp = array();
     $positions = array();
     $i=0;
     $list = mysql_query("SELECT * FROM place ");
     while($row = mysql_fetch_array($list, MYSQL_NUM)) {
        $temp = $row;
        $positions[$i] = $temp;
        $i++;
        }
    mysql_free_result($list);
 ?>


<!DOCTYPE html>  
 <html>   
 <head>
   <meta http-equiv="content-type" content="text/html; charset=UTF-8" />   
   <title>Google Maps Multiple Markers</title>   
   <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

    <script type="text/javascript">  
   var map = new google.maps.Map(document.getElementById('map'), {  
     zoom: 17,  
     center: new google.maps.LatLng(21.00945, 105.81083),  
     mapTypeId: google.maps.MapTypeId.ROADMAP  
   });
   var locations = <?php echo json_encode($positions); ?>;          //parse possition from PHP to locations to JS
   var geolocate;
   var templat= 0.0 , templng= 0.0;
   navigator.geolocation.getCurrentPosition(function(position) {         
      geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
      map.setCenter(geolocate);

      var marker = new google.maps.Marker({
          position: geolocate,
          map: map
        });
      templat = geolocate.lat();
      templng = geolocate.lng();
      var infowindow = new google.maps.InfoWindow();  
   var marker, i= 0;  
   for (i = 0; i < locations.length; i++) {
      if(((geolocate.lat()-locations[i][1])*(geolocate.lat()-locations[i][1]) + (geolocate.lng()-locations[i][2])*(geolocate.lng()-locations[i][2])) < 0.7) {
       marker = new google.maps.Marker({
         position: new google.maps.LatLng(locations[i][1], locations[i][2]),
         map: map  
       });  
       google.maps.event.addListener(marker, 'click', (function(marker, i) {  
         return function() {  
           infowindow.setContent(locations[i][0]);  
           infowindow.open(map, marker);  
         }  
       })(marker, i));
       }
    }
    });
      


   //------------------------------------------------------------------------------------------------------------
   

   

   </script>    
 </head>   
 <body>  
   <div id="map" style="width: 400px; height: 500px;"></div>
 </body>  
 </html>  