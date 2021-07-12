<?php
if (!isset($sys)) exit;
header('Content-Type: application/json');
include ('schem.php');
$schem = new Schem(['bd_link'=>$link]);
$draw = false;
$success = false;
$msg = '';
$schema_id = 0;
$user_id = $_SESSION['user_id'];
if (isset($_POST['data_block'])) {
    //include 'bd.php';
    if (isset($_POST["id"])) {
        $id = (int)$_POST["id"];
        $name = $_POST["name"];
    } else {
        $id = 0;
    }
    if (!$link) {
        $msg = 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    } else {
        $blocks = $_POST['data_block'];
        //$jdata = addslashes(json_encode($blocks));
        $sql = mysqli_query($link, "SELECT id from schem WHERE id = {$id}");
        if ($id == 0 && isset($_POST["id"])) {
            $sql = mysqli_query($link, "INSERT INTO schem (name, creator_id) VALUES ('{$name}', {$user_id})");
            $schema_id = (int)mysqli_insert_id($link);
            file_put_contents( 'data_4.txt', print_r($blocks, true));
            $schem->SaveBlocks([
                'blocks'    => $blocks,
                'schema_id' => $schema_id
            ]);
            $success = true;
            $msg = 'Новая запись';
        } elseif (mysqli_num_rows($sql) > 0) {
            $sql = mysqli_query($link, "UPDATE schem set name = '{$name}' WHERE id = {$id}");
            $sql = mysqli_query($link, "DELETE from blocks WHERE schem_id = {$id}");
            file_put_contents( 'data_4.txt', print_r($blocks, true));
            $schem->SaveBlocks([
                'blocks'    => $blocks,
                'schema_id' => $id
            ]);
            $success = true;
            $msg = 'Сохранено';
        }
    }
} else {
    $msg = 'Пустая схема';
}
echo json_encode([
    'success' => $success,
    'message' => $msg,
    'schema_id' => $schema_id,
   // 'sql' => "INSERT INTO schem (name, creator_id) VALUES ('{$name}', {$user_id})"
]); // file_put_contents( 'data_test1.txt', $id);
?>