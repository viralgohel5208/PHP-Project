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

$category_id = $_REQUEST['cid'];

// initilize all variable
$params = $columns = $totalRecords = $data = array();

$params = $_REQUEST;

//echo "<pre>";print_r($_REQUEST);exit;

//define index of column
$columns = array(
	0 => 'id',
	1 => 'net_measure',
	2 => 'measure_type',
	3 => 'price_finale',
	4 => 'offer_type',
	5 => 'stock_amount',
	6 => 'status',
);

$where = $sqlTot = $sqlRec = "";

$where = " WHERE app_id = $app_id";
if(isset($_REQUEST['cid']) && $_REQUEST['cid'] != "")
{
	//$where .= " AND category_id = ".$_REQUEST['cid'];
}
if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
{
	$where .= " AND product_id = ".$_REQUEST['id'];
}

// check search value exist
if( !empty($params['search']['value']) ) {   
	//$where .=" WHERE ";
	$where .=" AND ";
	$where .=" ( net_measure LIKE '".$params['search']['value']."%' ";    
	$where .=" OR measure_type LIKE '".$params['search']['value']."%' ";
	$where .=" OR price_finale LIKE '".$params['search']['value']."%' ";
	$where .=" OR stock_amount LIKE '".$params['search']['value']."%' ";
	$where .=" )";
}

// getting total number records without any search
$sql = "SELECT id, net_measure, measure_type, price_finale, offer_type, stock_amount, status FROM `products_variant` ";
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
	$column_name = 'net_measure, measure_type ASC';
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
	
	if($row[4] == 0) { $row[4] = "-"; } else if($row[4] == 1) { $row[4] = "% off"; } else { $row[4] = "Free Product"; }
	$row[6] = getActInactStatus($row[6]);
	$row[7] = '<td>
					<a href="products-variants-update.php?cid='.$category_id.'&id='.$pri_id.'" class="btn btn-success btn-xs"> &nbsp;<i class="fa fa-pencil"></i></a>
					<a onclick="delete_func(\''.$pri_id.'\')" class="btn btn-danger btn-xs next-btn"> &nbsp;<i class="fa fa-times"></i></a>
				</td>';
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