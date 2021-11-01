<?php

/*
*	Dont Delete This File
*	It has all the coniguration to run the application
*/

header("Content-type: text/plain");	//Convert to plain text

$result = [
	'current_datetime' => date('d-m-Y H:i:s'),
	
	// Application url
	'application_url' => 'http://www.lucsoninfotech.com/ecom/',
	
	// TRUE = Server is runnig
	// FALSE = Server is in maintenance
	'server_status' => TRUE,
	
	// Maintenance mode message
	//'maintenance_msg_en' => "Unfortunately application is down for a bit of maintenance right now. We will return shortly",
	//'maintenance_msg_ar' => 'للأسف التطبيق هو أسفل قليلا من الصيانة في الوقت الحالي. سنعود قريبا',	

];

print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
exit;

?>