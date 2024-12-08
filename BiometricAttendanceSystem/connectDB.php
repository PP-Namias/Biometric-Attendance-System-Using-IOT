<?php
/* Database connection settings */
	$servername = "localhost";
    $username = "u779691448_BioAttendanceS";		//put your phpmyadmin username.(default is "root")
    $dbname = "u779691448_BAS";
    $password = "Namias99";		   //if your phpmyadmin has a password put it here.(default is "root")
    
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
?>