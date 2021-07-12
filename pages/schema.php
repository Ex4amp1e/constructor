<?php
$_SESSION["token"] = rand(1, 10000);
if ($sys['user_role_id'] == 0) exit; 
if (isset($_GET["id"])) {
    $id = (int)$_GET["id"];
} else {
    header("Location:/?p=list");
    exit;
}
if ($id!=0) {
if ($sys['user_role_id'] == 1) {
    $sql = mysqli_query($link, "SELECT id,name from schem WHERE id = {$id}");
} elseif ($sys['user_role_id'] == 2) {
    $sql = mysqli_query($link, "SELECT id,name from schem WHERE id = {$id} and creator_id = {$_SESSION['user_id']}");
} else {
    header('Location:?p=list');
}
if ($data = mysqli_fetch_assoc($sql)) {
    $name = $data["name"];
} else {
    header('Location:?p=schema&id=0');
}
} else {
    $name = "Новая схема";
}
$sys["header"] = '<span class="iconify" data-icon="fa-pencil" data-inline="false"></span><span class="schema-name">' . $name . '</span><input class="schema-name-input" type="text" style="display:none" value="' . $name . '">';
?>
<div class="tools">
    <button class="btn btn-primary" onclick="tools.addBlock({id:id});">Создать блок</button>
    <button class="btn btn-primary" onclick="tools.delBlock({id:id});">Удалить блок</button>
    <button class="btn btn-success" onclick="tools.makeData({id:<?= $id ?>});">Сохранить схему</button>
    <button class="btn btn-success" onclick="tools.makeData({id:0});">Дублировать схему</button>
    <button class="btn btn-danger" onclick="tools.delSchema({id:<?= $id ?>,token:<?= $_SESSION['token'] ?>});">Удалить схему</button>
</div>
<div style="display: flex;">
    <div class="shema">
    </div>
    <div class="settings">
        <h2>Название блока</h2>
        <span>Тип оборудования:</span>
        <select class="equipment_type form-select">
            <option value="0">Не выбрано</option>
        </select>
        <span>Название оборудования:</span>
        <br>
        <select class="equipment_name form-select">
            <option value="0">Не выбрано</option>
        </select>
        <br>
        <span>Входной поток:</span>
        <input type="text" class="border_value form-control">
        <span>Производительность:</span>
        <input type="number" class="productivity form-control">
        <span>Уровень возврата:</span>
        <input type="number" class="return_level form-control" min=0>
    </div>
</div>
<script>
    id = <?= $id ?>;
    tools.loadEqTypes();
    getData({
        id: id
    });

</script>