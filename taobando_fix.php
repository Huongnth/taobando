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
    <script type="text/javascript">
      function toRad(degree) {
        return (degree * Math.PI)/180;
      }
      function calDistance(lat1,lng1,lat2,lng2){      
        var R = 6371; // km
        var dLat = toRad(lat2-lat1);
        var dLng = toRad(lng2-lng1);
        var lat1 = toRad(lat1);
        var lat2 = toRad(lat2);

        var a = Math.sin(dLat/2)*Math.sin(dLat/2) + Math.sin(dLng/2)*Math.sin(dLng/2)* Math.cos(lat1)* Math.cos(lat2); 
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        var d = R * c;
        return d;
      }
      function getRadius(){
        var tmpRad = document.getElementById("radius");
        var rad = tmpRad.elements[0].value;
        document.getElementById("out").innerHTML = rad;
        return rad;
      }
      function getZoom(rad){
        if(rad <= 1){
          return 17;
        }
        else if(rad <=2){
          return 16;
        }
        else if(rad <=4){
          return 15;
        }
        else if(rad <=7){
          return 14;
        }
        else if(rad <=10){
          return 13;
        }
        else if(rad <=15){
          return 12;
        }
        else return 11;
      }
    </script>



<!DOCTYPE html>  
 <html>   
 <head>   
   <meta http-equiv="content-type" content="text/html; charset=UTF-8" />   
   <title>Google Maps Multiple Markers</title> 
    <link href="css/main.css" rel="stylesheet">
    <link href="css/demo.css" rel="stylesheet">  
   <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>  
 </head>   
 <body>  
  <div class= "header">
    <script>getMap();</script>
    <div id = "out">AA</div>
    <form id="radius"> 
      Radius: <input type="number" name="fname" value="1">
    </form>
    <script type="text/javascript">getMap();</script>
    <button onclick="getMap()">Get map</button>
  </div>
   <div id="google_canvas"></div>  

 </body>  
 </html>











<script type="text/javascript">
  
  var locations = <?php echo json_encode($positions); ?>;          //parse possition from PHP to locations to JS 
  //var z = getZoom(t= getRadius());
   var map = new google.maps.Map(document.getElementById('google_canvas'), {  
     zoom: 8,  
     mapTypeId: google.maps.MapTypeId.ROADMAP  
   });

    var geolocate;
    navigator.geolocation.getCurrentPosition(function(position) {         
      geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
      map.setCenter(geolocate);

      var marker = new google.maps.Marker({
          position: geolocate,
          map: map
        });
      var infowindow = new google.maps.InfoWindow();  
      var i= 0;
      var radius = getRadius();
      var zoo = getZoom(radius);
      map.setZoom(zoo);
      for (i = 0; i < locations.length; i++) {
        
        var distance = calDistance(geolocate.lat(),geolocate.lng(), locations[i][1], locations[i][2]);
        if(distance < radius) {
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

function getMap(){
   var locations = <?php echo json_encode($positions); ?>;          //parse possition from PHP to locations to JS 
   var map = new google.maps.Map(document.getElementById('google_canvas'), {  
     zoom: 8,  
     mapTypeId: google.maps.MapTypeId.ROADMAP  
   });

    var geolocate;
    navigator.geolocation.getCurrentPosition(function(position) {         
      geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
      map.setCenter(geolocate);;

      var marker = new google.maps.Marker({
          position: geolocate,
          map: map
        });
      var infowindow = new google.maps.InfoWindow(); 
      var radius = getRadius();
      var zoo = getZoom(radius);
      map.setZoom(zoo); 
      var i= 0;
      for (i = 0; i < locations.length; i++) {
        var distance = calDistance(geolocate.lat(),geolocate.lng(), locations[i][1], locations[i][2]);
        if(distance < radius) {
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

}

   </script> 
