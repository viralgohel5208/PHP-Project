<?php

//include connection file 
require_once "../db.php";
require_once "../universal.php";
require_once "../define.php";
require_once "login-required.php";
require_once "../functions.php";
require_once "../functions-mysql.php";

// initilize all variable
$params = $columns = $totalRecords = $data = array();

$params = $_REQUEST;

//echo "<pre>";print_r($_REQUEST);exit;

//define index of column
$columns = array(
	0 => 'id',
	1 => 'language',
	2 => 'msg_head',
	3 => 'msg_body',
	4 => 'notification_date',
	5 => 'created_at',
	6 => 'notification_flag',
);

$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {   
	$where .=" WHERE ";
	$where .=" ( language LIKE '".$params['search']['value']."%' ";    
	$where .=" OR msg_head LIKE '".$params['search']['value']."%' ";
	$where .=" OR msg_body LIKE '".$params['search']['value']."%' ";
	$where .=" )";
}

// getting total number records without any search
$sql = "SELECT id, language, msg_head, msg_body, notification_date, created_at, notification_flag FROM `notifications` ";
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
	$column_name = 'notification_date DESC';
}
else
{
	$column_name = $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir'];
}

$sqlRec .=  " ORDER BY ". $column_name."  LIMIT ".$params['start']." ,".$params['length']." ";

$queryTot = mysqli_query($link, $sqlTot) or die("database error:". mysqli_error($link));

$totalRecords = mysqli_num_rows($queryTot);

$queryRecords = mysqli_query($link, $sqlRec) or die("error to fetch data");

$k = $_REQUEST['start'] + 1;

//iterate on results row and create new index array of data
while( $row = mysqli_fetch_row($queryRecords) ) {
	$pri_id = $row[0];
	$language = $row[1];
	$msg_head = $row[2];
	$msg_body = $row[3];
	$notif_st = $row[5];
	$row[0] = $k;
	$row[1] = getNotifLanguage($row[1]);
	
	$row[2] = "";
	if($language == 1) { $row[2] .= '<div style="direction:rtl">'; }
	$row[2] .= stringCut($msg_head);
	if($language == 1) { $row[2] .= '</div>'; }
	
	$row[3] = "";
	if($language == 1) { $row[3] .= '<div style="direction:rtl">'; }
	$row[3] .= stringCut($msg_head);
	if($language == 1) { $row[3] .= '</div>'; }
	
	//$row[3] = stringCut($row[3]);
	$row[6] = getNotifStatus($row[6]);
	$row[7] = "";
	if($notif_st == 0) {
	//$row[7] .= '<a href="notifications-update.php?id='.$pri_id.'" class="btn btn-success btn-xs"> &nbsp;<i class="fa fa-pencil"></i></a>';
	}
	$row[7] .= '<a onclick="delete_func(\''.$pri_id.'\')" class="btn btn-danger btn-xs next-btn"> &nbsp;<i class="fa fa-times"></i></a>';
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