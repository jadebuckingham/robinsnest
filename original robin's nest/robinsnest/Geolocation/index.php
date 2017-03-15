<?php 

    // Load library file
    require_once('lib.php');
?>



<!-- Libraries and API's defined here --> 

<!doctype html>
<html>
    <head>
	<link rel='stylesheet' href="../styles.css" type='text/css'/>
	<title>
		Location detector
	</title>
	<div class='appname'>Robins Nest Geolocation</div>
	<p class="backRob">Click <a href="../index.php">here</a> to go back to Robins Nest Home Page</p>
        
        
	<title>
	    Geolocation
	</title>
	
	<!-- Using a hosted Google Maps jQuery library to simplify the JavaScript DOM-handling code -->
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
        
        
        </script>
    
        
        <!-- Using a gePosition fallback -->
<script src="geoPosition.js"></script>	
        
    
        
	<!-- Using the Google Maps API v3, using a sensor for geolocation -->
	<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
        
        
        
        
        
        
<!-- Task 1, saving the position --> 
        
	
	<script language="javascript">
	    
	    // When the users location is successfully retrieved from the HTML 5 geolocation, this function is called to save the posisition in the database
	    function savePosition(point) {
		
		// Create a window object and save the the current latitude and longitude
		window.latitude = point.coords.latitude;
		window.longitude = point.coords.longitude;
            
            // Use ajax request to send the current latitude and longitude to callback.php via the POST method, once it is saved succesfully echo "Location saved" or fail
		$.ajax({
		    url: 'callback.php',
		    type: 'POST',
		    data:   {
				latitude: window.latitude,
				longitude: window.longitude
			    },
		    statusCode: {
				500: function() {
				    $('#location_pane').html('<p>We couldn\'t save your location.</p>');
				}
			    }
			    
		}).done(function() {
		    // Let the user know the location's been saved to the database
		    $('#location_pane').html('<p>Location saved.</p>');
		    
		    // Once the users location has been determined, center the map on that location
		    var currentLocation = new google.maps.LatLng(window.latitude, window.longitude);
		    window.googleMap.setCenter(currentLocation);
            
            // Initialise a info window, get the currentLocation coordinates and convert to a readble string
             var infowindow = new google.maps.InfoWindow({
          content: currentLocation.toString() 
        });

        
            
		    
		    // Create a marker at the users current position on the map
		     var marker = new google.maps.Marker({
			position: currentLocation,
			map: window.googleMap,
			title: 'Current location'
		    });
            
            
            // When the marker is clicked on, open an info window
            
            marker.addListener('click', function Two() {
          infowindow.open(window.googleMap, marker);
        });
      
        
        
          
            // If the function fails, tell the user
            
		}).fail(function() {
		    $('#location_pane').html('<p>We couldn\'t save your location.</p>');
		});
		
	    }
	    
	    // This switch function is called when there is an error retrieving the current position. Each case shows the error and the echo to the user. Geolocation in the browser is supported
        
	    function errorPosition(error) {
		switch(error.code) {
		    
		    // Error code 1: permission to access the user's location was denied by user
		    case 1:	$('#location_pane').html('<p>No location was retrieved.</p>');
				break;
				
		    // Error code 2: the user's location could not be determined
		    case 2:	$('#location_pane').html('<p>We couldn\'t find you.</p>');
				break;
				
		    // Error code 3: the Geolocation API timed out and took to long
		    case 3:	$('#location_pane').html('<p>We took too long trying to find your location.</p>');
				break;
				
		}
	    }
	    
        
        
        
        
        // This error function is triggered when there is an error with the high accuracy position. Instead of failing, the function will attempt the low accuracy
	    // getCurrentPosition function will tell errorPosition if there is an error
        
	    function highAccuracyErrorPosition(error) {
		
		navigator.geolocation.getCurrentPosition(savePosition, errorPosition, {enableHighAccuracy: false});
		
	    }
	    
	</script>
	
    </head>
    <body>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <!-- Task 2, creating the map, showing the stored location --> 
        
        <!-- Default text, 'waiting for location'. If the user declined location doesnt respond to the location share, this will remain -->
	
	<div id="location_pane">
	    
	    <p>
		Waiting for location ...
	    </p>
	    
	</div>
        
     <div class="centered">
	<div id="map_pane" style="width: 100%; height: 550px;"></div>
	
	</div>   
        
        

	
	<!-- Page content would have loaded first before the HTML 5 geolocation section -->
	<script language="javascript">
	
	    // Initialise the map, customise the center, zoom and map type
	    var mapOptions = {
            center: {lat: 53.4641, lng: -2.24692},

		zoom: 8,
		mapTypeId: google.maps.MapTypeId.satellite
	    };
	
	    // Create googleMap property and place it on the window object to create the map and options
	    window.googleMap = new google.maps.Map(document.getElementById('map_pane'), mapOptions);

	    // Create a json array, load any previous locations that is stored into the database using the 'previouslocations' function from lib.php into the array, written using PHP
        
	   var jsonPoints = <?=json_encode(getPreviousLocations());?>;
	    
       
       // If not empty, iterate through the points and plot them on the map using markers. Position them using the latitude and longitude, use a blue icon for the markers to differ from the users current location.
	      if (jsonPoints.length > 0) {
		window.points = new Array();
		jsonPoints.forEach(function(point) {
            var markertwo = new google.maps.Marker;
		   window.points.push(markertwo = new google.maps.Marker({
			position: new google.maps.LatLng(point.latitude, point.longitude),
			map: window.googleMap,
               icon: 'blue.png'
		    }))
         
            
            // Create a content string for the markers, this is for the infomation window
           var loc = new google.maps.LatLng(point.latitude, point.longitude);
            
            
            // Create new info window, get the 'loc' variable defined above and convert it to a readable string
           var infowindowtwo = new google.maps.InfoWindow({
    content: loc.toString()
});
            
            
            // When the user clicks the marker, info window pop up
google.maps.event.addListener(markertwo, 'click', function Two() {
  infowindowtwo.open(window.googleMap,markertwo);
});
            
		});
            

   
        }
        
        

	    // Check if geolocation support is available firstly
	    if (navigator.geolocation) {

		// If it is supported, get the current location. Use the savePosition function if it was successful, or highAccuracyErrorPosition if it was not.
		navigator.geolocation.getCurrentPosition(savePosition, highAccuracyErrorPosition, {enableHighAccuracy: true});

	    } else {
            
     // Geo position fallback
		if(geoPosition.init())
            {
            geoPosition.getCurrentPosition(savePosition, update, error, {enableHighAccuracy:true});
            }
            else
                {
                    
                    $('#location_pane').html('<p>No geolocation support is available.</p>');
                }

        };
        
        
        
        function update (position)
{
    $('#location_pane').html('Your current location is: (' + poistion.coords.latitude + ', ' + position.coords.longitude + ').');
}
        function error (err)
        {
                                $('#location_pane').html(err.message);
        }
        

	</script>
	
    </body>
</html>