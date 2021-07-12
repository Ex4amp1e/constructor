<?php
if (!isset($sys)) exit;
$draw = false;
header('Content-Type: application/json');


//$sql = mysqli_query($link, "SELECT DISTINCT type FROM equipment ORDER BY name");
$sql = mysqli_query($link, "SELECT id,name FROM equipment_type ORDER BY name");

$data = [];
if (mysqli_num_rows($sql) > 0) {
    while( $row = mysqli_fetch_assoc($sql) )
    {
    	$data[] = $row;
    }
} else {
    echo "0 results";
}
echo json_encode([
	'eq_types'	=> $data
]);
?>