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
	1 => 'package_name',
	2 => 'client_name',
	3 => 'email',
	4 => 'mobile',
	5 => 'sales_exec',
	6 => 'starting_date',
	7 => 'expiry_date',
	8 => 'status',
);

$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {   
	$where .=" WHERE ";
	$where .=" ( package_name LIKE '".$params['search']['value']."%' ";    
	$where .=" OR client_name LIKE '".$params['search']['value']."%' ";
	$where .=" OR email LIKE '".$params['search']['value']."%' ";
	$where .=" OR mobile LIKE '".$params['search']['value']."%' ";
	$where .=" OR sales_exec LIKE '".$params['search']['value']."%' ";
	$where .=" OR starting_date LIKE '".$params['search']['value']."%' ";
	$where .=" OR expiry_date LIKE '".$params['search']['value']."%' ";
	$where .=" )";
}

// getting total number records without any search
$sql = "SELECT SD.id, P.package_name, CONCAT(A.first_name, ' ', A.last_name) as client_name, A.email, A.mobile, CONCAT(SE.first_name, ' ', SE.last_name) as sales_exec, SD.starting_date, SD.expiry_date, SD.status, A.app_id, A.id FROM `subscription_details` AS SD INNER JOIN admin AS A ON A.app_id = SD.app_id AND A.role_id = 2 INNER JOIN packages AS P ON P.id = SD.package_id LEFT JOIN sales_executives AS SE ON SE.id = SD.se_id";

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
	$column_name = 'SD.id ASC';
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
	$app_id = $row[9];
	$adm_id = $row[10];
	$row[0] = $k;
	$row[8] = getSubscriptionStatus($row[8]);
	$row[9] = '<div style="text-align:center">';
	$row[9] .= '<a href="client-subscriptions-update.php?id='.$pri_id.'" class="btn btn-success btn-xs"> &nbsp;<i class="fa fa-pencil"></i></a>';
	$row[9] .= '<a href="client-subscriptions-settings.php?id='.$app_id.'" class="btn btn-warning btn-xs next-btn"><i class="fa fa-cog"></i></a>';
	$row[9] .= '<a href="subscription-history.php?id='.$adm_id.'" class="btn btn-info btn-xs next-btn"><i class="glyphicon glyphicon-backward"></i></a>';
	$row[9] .= '<a onclick="delete_func(\''.$pri_id.'\')" class="btn btn-danger btn-xs next-btn"> &nbsp;<i class="fa fa-times"></i></a>';
	$row[9] .= '</div>';
	
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