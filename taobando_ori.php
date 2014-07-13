<!DOCTYPE html>  
 <html>   
 <head>   
   <meta http-equiv="content-type" content="text/html; charset=UTF-8" />   
   <title>Google Maps Multiple Markers</title>   
   <script src="http://maps.google.com/maps/api/js?sensor=false"   
   type="text/javascript"></script>  
 </head>   
 <body>  
   <div id="map" style="width: 500px; height: 400px;"></div>  
   <script type="text/javascript">  
   var locations = [  
   ['Ths. Đ&agrave;o Quang Huy, 0903 265 033, hoclaptrinhonline.com', 21.00945, 105.81083, 1],  
   ['def', 21.00955, 105.81142, 2],  
   ['xyz', 21.00930, 105.81093, 3]  
   ];  
   var map = new google.maps.Map(document.getElementById('map'), {  
     zoom: 17,  
     center: new google.maps.LatLng(21.00945, 105.81083),  
     mapTypeId: google.maps.MapTypeId.ROADMAP  
   });

   var infowindow = new google.maps.InfoWindow();  
   var marker, i;  
   for (i = 0; i < locations.length; i++) {   
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
   </script>  
 </body>  
 </html>