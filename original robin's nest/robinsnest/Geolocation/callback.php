<?php

    // Load library
    require_once('lib.php');
	
    // In the POST request check for the existence of longitude and latitude, continue attempting to save
    if (isset($_POST['longitude']) && isset($_POST['latitude'])) {
	
        
        
        
	// Not using unsanitized input, declaring the longitude and latitude as floats
	$longitude = (float) $_POST['longitude'];
	$latitude = (float) $_POST['latitude'];
	
        
        
        
        
        
	// Hardcoded user that corresponds to the user_id in the 'points' table. The user_id also corresponds to a manually put username, which is taken from the members.php file
	$user = 1;
	
        
        
        
	// Set the timestamp from the current system time
	$time = time();
	
        
        
	// UPDATE the database where the user equals the user_id set above, and their new location
	$query =    "update points set `longitude` = {$longitude}, 
					    `latitude` = {$latitude},
					    `user_id` = {$user},
					    `time` = {$time}
                        WHERE user_id = {$user}";
					    
	// Make sure the query works, if not, produce an error
	if (!($result = mysql_query($query))) {
	    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	    echo "Could not save point.";
	    exit;
	}
	
    }
    