<?php
if (!isset($sys)) exit;
$draw = false;
if ( !isset( $_POST[ 'eq_type' ]) ) exit;

header('Content-Type: application/json');
//include 'bd.php';   

$type = addslashes( $_POST[ 'eq_type' ] );
$sql = mysqli_query($link, "SELECT id,name FROM equipment where type_id={$type} ORDER BY name" );

$data = [];
if (mysqli_num_rows($sql) > 0) {
    while( $row = mysqli_fetch_assoc($sql) )
    {
    	$data[] = $row;
    }
} 
echo json_encode([
	'eq_names'	=> $data
]);
?>