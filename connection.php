<?php 
	$conn=mysqli_connect("localhost", "root", "mysql", "bank");
	if(!$conn) {
		echo "Connection Error: " . mysqli_connect_error();
	}
?>
