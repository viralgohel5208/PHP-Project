<?php

//include connection file 
require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-list.php";
require_once "../functions-mysql.php";

// initilize all variable
$params = $columns = $totalRecords = $data = array();

$params = $_REQUEST;

//echo "<pre>";print_r($_REQUEST);exit;

//define index of column
$columns = array(
	0 => 'id',
	1 => 'first_name',
	2 => 'last_name',
	3 => 'email',
	4 => 'mobile',
	5 => 'status',
);

$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {   
	$where .=" WHERE ";
	$where .=" ( first_name LIKE '".$params['search']['value']."%' ";    
	$where .=" OR last_name LIKE '".$params['search']['value']."%' ";
	$where .=" OR email LIKE '".$params['search']['value']."%' ";
	$where .=" OR mobile LIKE '".$params['search']['value']."%' ";
	$where .=" )";
}

// getting total number records without any search
$sql = "SELECT id, first_name, last_name, email, mobile, status FROM `sales_executives` ";
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
	$column_name = 'id DESC';
}
else
{
	$column_name = $columns[$params['order'][0]['column']]." ".$params['order'][0]['dir'];
}

$sqlRec .=  " ORDER BY ". $column_name." LIMIT ".$params['start']." ,".$params['length']." ";

$queryTot = mysqli_query($link, $sqlTot) or die("database error:". mysqli_error($link));

$totalRecords = mysqli_num_rows($queryTot);

$queryRecords = mysqli_query($link, $sqlRec) or die("error to fetch data");

$k = $_REQUEST['start'] + 1;

//iterate on results row and create new index array of data
while( $row = mysqli_fetch_row($queryRecords) ) {
	$pri_id = $row[0];
	$row[0] = $k;
	$row[1] = $row[1];
	$row[5] = getUserStatus($row[5]);
	$row[6] = '<div style="text-align:center">';
	$row[6] .= '<a href="sales-executives-update.php?id='.$pri_id.'" class="btn btn-success btn-xs"> &nbsp;<i class="fa fa-pencil"></i></a>';
	$row[6] .= '<a onclick="delete_func(\''.$pri_id.'\')" class="btn btn-danger btn-xs next-btn"> &nbsp;<i class="fa fa-times"></i></a>';
	$row[6] .= '</div>';
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