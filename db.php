<?php

date_default_timezone_set("Asia/Kolkata");

$link = mysqli_connect("localhost", "root", "Dinku#30", "ecom_demo");

if ( mysqli_connect_errno() )
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit;
}

mysqli_query ($link, "set character_set_client='utf8'"); 
mysqli_query ($link, "set character_set_results='utf8'"); 
mysqli_query ($link, "set collation_connection='utf8_general_ci'");