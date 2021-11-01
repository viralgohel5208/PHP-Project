<?php

ob_start();
//include connection file 
require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

if(isset($_REQUEST['s']) && isset($_REQUEST['d']))
{
	$selected_users = $_REQUEST['s'];
	$de_selected_users = $_REQUEST['d'];
	
	$selected_users = trim($selected_users, ",");
	$selected_users = preg_replace("/,+/", ",", $selected_users);
	
	//if($selected_users == "")
	{
		//echo $error = "Please select users to send notification";
		//exit;
	}
	//else
	{
		$selected_users = explode(",", $selected_users);
		$selected_users = array_unique($selected_users);

		$de_selected_users = trim($de_selected_users, ",");
		$de_selected_users = preg_replace("/,+/", ",", $de_selected_users);
		$de_selected_users = explode(",", $de_selected_users);
		$de_selected_users = array_filter(array_unique($de_selected_users));
	}
	
	/*echo "<pre>"; 
	print_r($selected_users);
	print_r($de_selected_users);*/
	
	//if($error == "")
	{
		if(in_array(0, $selected_users))
		{
			if(empty($de_selected_users))
			{
				if(isset($selected_users[0]) && $selected_users[0] == "")
				{
					$_SESSION['selected_users'] = [];
				}
				else
				{
					$_SESSION['selected_users'] = [0];
				}
				$_SESSION['de_selected_users'] = [];
				//$user_ids = 0;
			}
			else
			{
				$_SESSION['de_selected_users'] = $de_selected_users;
				$_SESSION['selected_users'] = $selected_users;
			}
		}
		else
		{
			echo 2;
			if(isset($selected_users[0]) && $selected_users[0] == "")
			{
				$_SESSION['selected_users'] = [];
			}
			else
			{
				$_SESSION['selected_users'] = $selected_users;
			}
			
			$_SESSION['de_selected_users'] = $de_selected_users;
		}
	}
}