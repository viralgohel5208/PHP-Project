<?php

require_once "db.php";
require_once "universal.php";
require_once "define.php";
//require_once "functions.php";
require_once "functions-mysql.php";

function checkValidUsername($string)
{
	if(!preg_match("/^[a-zA-Z]+[a-zA-Z0-9_]*$/i", $string))
	{
		//echo 1;
		return false;
	}
	else
	{
		//echo 0;
		return true;
	}
}

$string = "MshirishS";
return checkValidUsername($string);