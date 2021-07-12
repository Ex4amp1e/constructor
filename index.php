<?php
session_start();
$sys = [];
$draw = true;
$sys["content"] = "";
$sys['user_role_id'] = 0;
$sys['fio'] = '';
include 'pages/engine/bd.php';   
if (isset($_GET["p"])) {
    $sys["page"] = str_replace("../","",$_GET["p"]);
    $filepatch = $_SERVER["DOCUMENT_ROOT"]."/pages/".$sys["page"].".php";
    if (!file_exists($filepatch)) {
        $sys["page"] = "404";
    }
} else {
    $sys["page"] = "404";
}
$token = md5($_SESSION['user_id'].$_SESSION['token_time'].$_SERVER['REMOTE_ADDR']);
if ($token == $_SESSION['user_token']) {
    $sql = mysqli_query($link, "SELECT group_id, surname, first_name, patronymic from users WHERE id = {$_SESSION['user_id']}");
    if (mysqli_num_rows($sql) > 0) {
        $data = mysqli_fetch_assoc($sql);
        $sys['user_role_id'] = (int)$data['group_id'];   
        $sys['fio'] = $data['surname'].' '.$data['first_name'].' '.$data['patronymic'];
    } 
} else {
    $sys["page"] = "login";
}
ob_start();
require($_SERVER["DOCUMENT_ROOT"]."/pages/".$sys["page"].".php");
$sys["content"] = ob_get_contents();
ob_end_clean();
if ($draw) {
    require($_SERVER["DOCUMENT_ROOT"]."/templates/template.php");
} else {
    echo $sys['content'];
}
?>