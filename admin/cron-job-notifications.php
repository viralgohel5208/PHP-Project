<?php

//error_reporting('E_ALL');

require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

$current_time = date('Y-m-d H:i:s');

$query = "SELECT * FROM `notifications` WHERE notification_date <= '$current_time' AND notification_flag = '0'";

$res_fetch = mysqli_query($link, $query);

if(!$res_fetch)
{
	$error_code = 1; $error_string = $sww;
}
else
{
	while($row = mysqli_fetch_assoc($res_fetch))
	{
		$item_id 		= $row['id'];
		$language 		= $row['language'];
		$msg_head 		= $row['msg_head'];		
		$msg_body 		= $row['msg_body'];
		
		require_once "functions-notification.php";
		sendNotifications($item_id, $msg_head, $msg_body, $language);
	}
	
	$query2 = "UPDATE `notifications` SET notification_flag = '1' WHERE notification_date <= '$current_time' AND notification_flag = '0'";
	
	$res_fetch2 = mysqli_query($link, $query2);

	if(!$res_fetch2)
	{
		$error_code = 2; $error_string = $sww;
	}
}

if($error_code == 0)
{
	$query = "SELECT id, agenda_title, agenda_title_ar, start_time FROM `agenda` WHERE notification_at <= '$current_time' AND notification_flag = 0";

	$res_fetch = mysqli_query($link, $query);

	if(!$res_fetch)
	{
		$error_code = 1; $error_string = $sww;
	}
	else
	{
		while($row = mysqli_fetch_assoc($res_fetch))
		{
			$item_id 				= $row['id'];
			$agenda_title 			= $row['agenda_title'];
			$start_time 			= date("d-m-Y h:i A", strtotime($row['start_time']));

			$msg_head = "Agenda alert : ".$agenda_title;
			//$msg_body = "Next agenda is at : ".$start_time;
			$msg_body = "At : ".$start_time;
			$language = 0;
			require_once "functions-notification.php";
			sendNotifications($item_id, $msg_head, $msg_body, 'CRON');
		}

		$query2 = "UPDATE `agenda` SET notification_flag = '1' WHERE notification_at <= '$current_time' AND notification_flag = '0'";

		$res_fetch2 = mysqli_query($link, $query2);

		if(!$res_fetch2)
		{
			$error_code = 2; $error_string = $sww;
		}
	}
}

if($error_code == 0)
{
	$result = 'SUCCESS';
}

$return = [ 'error_code' => $error_code, 'error_string' => $error_string, 'data' => $result ];
print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
exit;