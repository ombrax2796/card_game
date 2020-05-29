<?php

	$servername="localhost";
	$username="root";
	$password="arthur";
	$dbname="jeumulti";
	// Create the connection
	$conn= new mysqli($servername,$username,$password,$dbname);
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	echo "Connection Succes";
?>