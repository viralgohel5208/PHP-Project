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
	1 => 'sku_number',
	2 => 'product_name',
	3 => 'brand_name',
	//4 => 'offer',
	4 => 'status',
);

$where = $sqlTot = $sqlRec = "";

$where = " WHERE app_id = $app_id ";
if(isset($_REQUEST['id']) && $_REQUEST['id'] != "")
{
	$where .= "AND category_id = ".$_REQUEST['id'];
}

// check search value exist
if( !empty($params['search']['value']) ) {   
	//$where .=" WHERE ";
	$where .=" AND ";
	$where .=" ( sku_number LIKE '".$params['search']['value']."%' ";    
	$where .=" OR product_name LIKE '".$params['search']['value']."%' ";
	$where .=" OR brand_name LIKE '".$params['search']['value']."%' ";
	$where .=" )";
}

// getting total number records without any search
$sql = "SELECT id, sku_number, product_name, brand_name, status, category_id, offer_type FROM `products` ";
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
	$column_name = 'product_name ASC';
}
else
{
	$column_name = $columns[$params['order'][0]['column']]." ".$params['order'][0]['dir'];
}

$sqlRec .=  " ORDER BY ". $column_name." LIMIT ".$params['start']." ,".$params['length']." ";

$queryTot = mysqli_query($link, $sqlTot) or die("database error:". mysqli_error($link));

$totalRecords = mysqli_num_rows($queryTot);

//echo $sqlRec;

$queryRecords = mysqli_query($link, $sqlRec) or die("error to fetch data");

$k = $_REQUEST['start'] + 1;

//iterate on results row and create new index array of data
while( $row = mysqli_fetch_row($queryRecords) ) {
	$category_id = $row[5];
	$pri_id = $row[0];
	$row[0] = $k;
	
	//$row[4] = '<a href="products-offers.php?id='.$pri_id.'" alt="View Offers"> View Offers</a>';
	//$row[4] = '<a href="products-offers.php?id='.$pri_id.'" alt="View Offers"> View/Edit </a>';
	/*$row[4] = '<a href="products-offers.php?id='.$pri_id.'" alt="View Offers">';
	if($row[6] == 0) { $row[4] .= "No Offer"; } else if($row[4] == 1) { $row[6] .= "% off"; } else { $row[4] .= "Free Product"; }
	$row[4] .= '</a>';*/
	$row[4] = getActInactStatus($row[4]);
	$row[5] = '<td>
					<a href="products-update.php?id='.$pri_id.'" class="btn btn-success btn-xs"> &nbsp;<i class="fa fa-pencil"></i></a>
					<a href="products-variants.php?cid='.$category_id.'&id='.$pri_id.'" class="btn btn-warning btn-xs" alt="View Variants"> &nbsp;<i class="fa fa-eye"></i></a>
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