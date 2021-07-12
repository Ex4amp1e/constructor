<?php
if (!isset($sys)) exit;
header('Content-Type: application/json');
session_start();
if ($_SESSION["token"] == $_POST["token"]) {
    //include 'bd.php';
    $msg = '';
    $success = false;
    $draw = false;
    if (isset($_POST["id"])) {
        $id = (int)$_POST["id"];
        if (!$link) {
            $msg = 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
            exit;
        } else {
            if ($sys['user_role_id'] == 1) {
                $sql = mysqli_query($link, "DELETE FROM schem WHERE id={$id}");
            } elseif ($sys['user_role_id'] == 2) {
                $sql = mysqli_query($link, "DELETE FROM schem WHERE id={$id} AND creator_id = {$_SESSION['user_id']}");
            }
            if ($sql) {
                $msg = 'Удалено';
                $success = true;
            }
        }
    } else {
        $msg = 'Ошибка';
    }
    echo json_encode([
        'success' => $success,
        'message' => $msg,
    ]);
}
?>