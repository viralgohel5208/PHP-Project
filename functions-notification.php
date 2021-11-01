<?php

// Using FCM - Firebase Cloud Messaging
function actionApn($data)
{
	$api_access_key		= 'AIzaSyCjnlqpmxulK6aJCxf7haLZFaweX_3c6h8';
	
	$registrationIds 	= $data['registrationIds'];
	$item_id			= $data['item_id'];
	$notif_title		= $data['notif_title'];
	$notif_message 		= $data['notif_message'];

	$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';

	$fields = array(
		'to' => $registrationIds,
		'notification' => array('title' => $notif_title, 'body' => $notif_message),
		'data' => array('item_id' => $item_id, 'notif_title' => $notif_title, 'notif_message' => $notif_message, 'alert' => $notif_title ."\n\r".$notif_message )
	);

	$headers = array(
		'Authorization:key=' . $api_access_key,
		'Content-Type:application/json'
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	$result = curl_exec($ch);
	curl_close($ch);

	/* echo '<pre>'; print($result); exit;*/
	return $result;
}

function actionIpn($data)
{
	$registrationIds 	= $data['registrationIds'];
	$item_id			= $data['item_id'];
	$notif_title		= $data['notif_title'];
	$notif_message 		= $data['notif_message'];
	$language 			= $data['language'];
	
	$final_message = $item_id . ':::::' . $notif_title . ':::::' . $notif_message;
	// set time limit to zero in order to avoid timeout
	set_time_limit(0);
	
	// charset header for output
	//header('content-type: text/html; charset: utf-8');
	
	// this is the pass phrase you defined when creating the key
	$passphrase = '30091988';
	
	// load your device ids to an array
	//$registrationIds = array('689ee47dd628208f7c873ccc11b7f701d0f24241c780775cc4e3b7f20ddd2bff');
	
	// this is where you can customize your notification
	$payload = '{"aps" : {"alert" : {"body" : "'.$notif_title.". ".$notif_message.'",	"action-loc-key" : "'.$notif_title . ':' . $notif_message.'"} } }';

	$result = 'Start' . '<br />';
	
	////////////////////////////////////////////////////////////////////////////////
	// start to create connection
	$ctx = stream_context_create();
	
	$upOne = realpath(__DIR__); 
	$certi_path = $upOne.'/NewPeakNotification.pem';
	//stream_context_set_option($ctx, 'ssl', 'local_cert', "NewPeakNotification.pem"); 
	stream_context_set_option($ctx, 'ssl', 'local_cert', $certi_path); 
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	
	$s1 = "";
	$s1 .= count($registrationIds) . ' devices will receive notifications.<br />';
	foreach ($registrationIds as $item) {
		
		// wait for some time
		sleep(1);
		
		// Open a connection to the APNS server
		//$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 120, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);		
		$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 120, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);	
		
		//	echo $err; echo "</br> ab"; echo $errstr;exit;
		if (!$fp) {
			exit("Failed to connect: $err $errstr" . '<br />');
		} else {
			$s1 .= 'Apple service is online. ' . '<br />';
		}
		
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $item) . pack('n', strlen($payload)) . $payload;
		
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		if (!$result) {
			$s1 .= 'Undelivered message count: ' . $item . '<br />';
		} else {
			$s1 .= 'Delivered message count: ' . $item . '<br />';
		}
		
		if ($fp) {
			fclose($fp);
			$s1 .= 'The connection has been closed by the client' . '<br />';
		}
	}
	$s1 .= count($registrationIds) . ' devices have received notifications.<br />';
	
	// set time limit back to a normal value
	set_time_limit(30);
	
	//echo $s1;
	//return $s1;
}

function sendNotifications($item_id, $notif_title, $notif_message, $language)
{
	global $link;
	
	$query = "SELECT `type`, `notif_id` FROM users WHERE notif_id != ''";
	$res_devices = mysqli_query($link, $query);

	$APNids = array();
	$IPNids = array();

	while($row_device = mysqli_fetch_assoc($res_devices))
	{
		if ($row_device['type'] == 1)
		{
			$IPNids[] = $row_device['notif_id'];
		}
		else if ($row_device['type'] == 2)
		{
			$APNids[] = $row_device['notif_id'];
		}
	}

	/*echo "<pre>";
	print_r($APNids);
	print_r($IPNids);*/
	//exit;
	
	if(!empty($APNids))
	{
		foreach($APNids as $ap)
		{
			actionApn(
				array(
					//'registrationIds' 	=> $APNids, 
					'registrationIds' 	=> $ap, 
					'item_id' 			=> $item_id,
					'notif_title' 		=> $notif_title,
					'notif_message'		=> $notif_message,
				)
			);
		}
	}
	
	if(!empty($IPNids))
	{
		/*foreach($IPNids as $ip) {*/
			actionIpn(
				array(
					'registrationIds' 	=> $IPNids,
					'item_id' 			=> $item_id,
					'notif_title' 		=> $notif_title,
					'notif_message'		=> $notif_message,
					//'language'			=> $language,
				)
			);
		//echo 1;//exit;
		//}
	}
}

function registerDevice($device_id, $notif_id, $type)
{
	global $link, $sww;
	
	$error_code 	= 0;
	$error_string 	= "";
	$result 		= [];
	$status			= 1;

	$current_datetime = currentTime();
	
	$query_1 = "SELECT * FROM users WHERE device_id = '$device_id' and type = '$type'";

	$check_device = mysqli_query($link, $query_1);

	if(!$check_device)
	{
		$error_code = 1;
		$error_string = $sww;
	}
	else
	{
		if(mysqli_num_rows($check_device) > 0)
		{
			$fetch = mysqli_fetch_assoc($check_device);

			$user_id 		= $fetch['id'];

			if($fetch['notif_id'] != $notif_id)
			{
				$query_2 = "UPDATE users SET notif_id = '$notif_id', `updated_at` = '$current_datetime' WHERE id = $user_id";
				$up_device = mysqli_query($link, $query_2);

				if(!$up_device)
				{
					$error_code = 2;
					$error_string = $sww;
				}
			}
		}
		else
		{
			$sql = "INSERT INTO `users`(`device_id`, `notif_id`, `type`, `created_at`, `updated_at`, `status`) VALUES ('$device_id', '$notif_id', '$type', '$current_datetime', '$current_datetime', '$status')";

			if(!mysqli_query($link, $sql))
			{
				$error_code = 3;
				$error_string = $sww;
			}
			else
			{
				$user_id = mysqli_insert_id($link);
			}
		}
	}
	
	if($error_code == 0)
	{
		$result = ['user_id' => (int)$user_id];
	}
	
	$return = ["error_code" => $error_code, "error_string" => $error_string, "result" => $result];
	return $return;
}