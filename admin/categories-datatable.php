<?php

//include connection file 
require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

$app_id = $_SESSION['app_id'];

// initilize all variable
$params = $columns = $totalRecords = $data = array();

$params = $_REQUEST;

//echo "<pre>";print_r($_REQUEST);exit;

//define index of column
$columns = array(
	0 => 'id',
	1 => 'parent_id',
	2 => 'category_name',
	3 => 'status',
	//5 => 'status'
);

$where = $sqlTot = $sqlRec = "";

$where = " WHERE C.app_id = $app_id ";

// check search value exist
if( !empty($params['search']['value']) ) {   
	//$where .=" WHERE ";
	$where .=" AND ";
	$where .=" ( C.category_name LIKE '".$params['search']['value']."%' ";    
	//$where .=" OR email LIKE '".$params['search']['value']."%' ";
	//$where .=" OR mobile LIKE '".$params['search']['value']."%' ";
	//$where .=" OR added_datetime LIKE '".$params['search']['value']."%' )";
	$where .=" )";
}

// getting total number records without any search
$sql = "SELECT C.id, P.category_name as main_category, C.category_name, C.status FROM `categories` AS C LEFT JOIN categories AS P ON C.parent_id = P.id ";
$sqlTot .= $sql;
$sqlRec .= $sql;
//concatenate search sql if value exist
if(isset($where) && $where != '')
{
	$sqlTot .= $where;
	$sqlRec .= $where;
}

if($params['order'][0]['column'] == 0)
{
	$column_name = 'C.parent_id, C.category_name ASC';
}
else
{
	$column_name = $columns[$params['order'][0]['column']]." ".$params['order'][0]['dir'];
}

$sqlRec .=  " ORDER BY ". $column_name." LIMIT ".$params['start']." ,".$params['length']." ";
//echo $sqlRec;
$queryTot = mysqli_query($link, $sqlTot) or die("database error:". mysqli_error($link));

$totalRecords = mysqli_num_rows($queryTot);

$queryRecords = mysqli_query($link, $sqlRec) or die("error to fetch data");

$k = $_REQUEST['start'] + 1;

//iterate on results row and create new index array of data
while( $row = mysqli_fetch_row($queryRecords) ) {
	$pri_id = $row[0];
	$row[0] = $k;
	
	$main_cat = $row[1];
	$sub_cat = $row[2];
	
	if($main_cat == NULL) {
		$row[1] = $sub_cat;
		$row[2] = "-";
	} else {
		$row[1] = $main_cat;
		$row[2] = $sub_cat;
	}
	
	$row[3] = getActInactStatus($row[3]);
	$row[4] = '<td>
					<a href="categories-update.php?id='.$pri_id.'" class="btn btn-success btn-xs"> &nbsp;<i class="fa fa-pencil"></i></a>
					<a onclick="delete_func(\''.$pri_id.'\')" class="btn btn-danger btn-xs next-btn"> &nbsp;<i class="fa fa-times"></i></a>
				</td>
				';
	$data[] = $row;
	$k++;
}	

$json_data = array(
		"draw"            => intval( $params['draw'] ),   
		"recordsTotal"    => intval( $totalRecords ),  
		"recordsFiltered" => intval($totalRecords),
		"data"            => $data   // total data array
		);

echo json_encode($json_data);  // send data as json format

?>