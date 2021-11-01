<?php
//header("Content-Type: application/json");
//echo "<pre>";
//print_r($_REQUEST);
//echo "</pre>";

//echo $_REQUEST['serialize'];

require_once "../db.php";
require_once "../define.php";

if(isset($_POST['serialize']))
{
	$j_decode 	= json_decode($_REQUEST['serialize']);
	
	/*echo "<pre>";
	print_r($j_decode);
	echo "</pre>";*/
	
	$array_sort = [];
	$i = 0;
	foreach($j_decode as $value)
	{
		$array_sort[$i] = $value->id;
		$i++;
	}
	
	//	print_r($array_sort);
	//$up_query = [];
	foreach($array_sort as $key=>$value)
	{
		$up_query = "UPDATE locations SET display_order = $key WHERE id = $value";
		$res_query = mysqli_query($link, $up_query);
	}
	
	//$imp_query = implode(";", $up_query);
	
	//$res_query = mysqli_query($link, $imp_query);
	
	echo 'saved';
}