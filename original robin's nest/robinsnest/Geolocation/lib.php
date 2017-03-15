<?php

  $dbhost  = 'mudfoot.doc.stu.mmu.ac.uk';    // Unlikely to require changing
  $dbname  = 'buckingj';   // Modify these...
  $dbuser  = 'buckingj';   // ...variables according
  $dbpass  = 'Nossgool9';   // ...to your installation
  $appname = "Robin's Nest"; // ...and preference

 if (mysql_connect	(
				$dbhost,
				$dbuser,
				$dbpass
			)) {
			    mysql_select_db(
				$dbname
			    );
			} else {
			    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
			    echo "Could not connect to the database.";
			    exit;
			}
			
 // Function to retrieve all the stored location within the database
    function getPreviousLocations() {
	
	// Create a $points array, which we will use later
	$points = array();
        
	
	
	// Select all the stored location in the database
	$query = "select `latitude`, `longitude`, `time` from `points` order by `time` asc";
        
        
        
    
 ////////////////////// If I were to select all the users friends and anonymous/not following and following back, information from the 'friends' php file. //////////////////////////////
        
        
//$followers = array();
//$following = array();

//$result = queryMysql("SELECT * FROM friends WHERE user='$view'");
//$num    = mysql_num_rows($result); 

//for ($j = 0 ; $j < $num ; ++$j)
//{
  //  $row           = mysql_fetch_row($result);
//    $followers[$j] = $row[1];
//}

//$result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
//$num    = mysql_num_rows($result);

//for ($j = 0 ; $j < $num ; ++$j)
//{
//    $row           = mysql_fetch_row($result);
//    $following[$j] = $row[0];
//}

//$mutual    = array_intersect($followers, $following);
//$followers = array_diff($followers, $mutual);
//$following = array_diff($following, $mutual);
//$friends   = FALSE;
        
        // Create a mutual array like the points, ready to be returned and shown as markers on the map
        // $mutual = array();
        
        
        
        
        
        
        
	
	// If there are location points stored in the database, store them in the previously defined $points array
	if ($result = mysql_query($query)) {
	    while ($row = mysql_fetch_object($result)) {
		$points[] = $row;
            // $mutual[] = $row;
	    }
	} else {
	    echo mysql_error();
	}
	
	// Return the $points array
	return $points;
        //	return $mutual;
	
    }