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
	1 => 'store_name',
	2 => 'city_name',
	3 => 'email',
	4 => 'mobile',
	5 => 'address',
	6 => 'status',
);

$where = $sqlTot = $sqlRec = "";

$where .=" WHERE S.app_id = $app_id ";

// check search value exist
if( !empty($params['search']['value']) ) {   
	$where .=" AND ";
	$where .=" ( store_name LIKE '".$params['search']['value']."%' ";    
	$where .=" OR C.city_name LIKE '".$params['search']['value']."%' ";
	$where .=" OR email LIKE '".$params['search']['value']."%' ";
	$where .=" OR mobile_1 LIKE '".$params['search']['value']."%' ";
	$where .=" OR address LIKE '".$params['search']['value']."%' ";
	//$where .=" OR added_datetime LIKE '".$params['search']['value']."%' )";
	$where .=" )";
}

// getting total number records without any search
$sql = "SELECT S.id, store_name, C.city_name, email, mobile_1, S.address, S.status FROM stores AS S INNER JOIN cities AS C ON C.id = S.city_id";
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
	$column_name = 'store_name ASC';
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
	$row[6] = getActInactStatus($row[6]);
	$row[7] = '<td>';
	$row[7] .= '<a href="stores-update.php?id='.$pri_id.'" class="btn btn-success btn-xs" title="Edit Details"> &nbsp;<i class="fa fa-pencil"></i> &nbsp;</a>';
	$row[7] .= '<a href="stores-localities.php?id='.$pri_id.'" class="btn btn-info btn-xs" title="Add Locality"> &nbsp;<i class="fa fa-location-arrow"></i> &nbsp;</a>';
	
	//$row[7] .= '<a onclick="delete_func(\''.$pri_id.'\')" class="btn btn-danger btn-xs next-btn"> &nbsp;<i class="fa fa-times"></i></a>
	$row[7] .= '</td>';
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