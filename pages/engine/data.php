<?php
if (!isset($sys)) exit;
$draw = false;
$msg = '';
header('Content-Type: application/json');
include ('schem.php');
$schem = new Schem(['bd_link'=>$link]);
$data = [];
if (isset($_POST["id"])) {
    $id = (int)$_POST["id"];
} else {
    $id = 0;
}
//file_put_contents( 'data_test1.txt', "sdfsdf55ss3215");
if (!$link) {
    $msg = 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
    exit;
} else {
    $blocks = $schem->GetBlocks([
        'schema_id' => $id,
        'role_id'   => $sys['user_role_id']
    ]);
    echo json_encode([
        'blocks' => $blocks
    ]);
}
    /*
    $sql = mysqli_query($link, "SELECT value FROM schemes WHERE id={$id}");
    if (mysqli_num_rows($sql) > 0) {
        $data = mysqli_fetch_assoc($sql);
        echo stripslashes($data['value']);
    } else {
        //echo "0 results";
    } 
    //echo print_r($data, true);
}*/
//file_put_contents( 'data_test1.txt', 'dfgdfgdfgdfd!!!sdfsssssssssssssssssss!!!!!g');
//echo json_encode($data[0]['value']);
?>