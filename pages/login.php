<?php
$info = array();
$login = isset($_POST['login']) ? $_POST['login'] : null;
$passwd = isset($_POST['passwd']) ? $_POST['passwd'] : null;

if (isset($_POST['ok'])) // Если кнопка Отправить была нажата
{
    if ($login=="")
        $info[] = 'Не введен логин.';

    if ($passwd=="")
        $info[] = 'Не введен пароль.';

    if (count($info) == 0) // Если замечаний нет и все поля заполнены
    {
        $login = substr($login, 0, 50);
        $login = mysqli_real_escape_string($link, $login);
        $passwd = md5($passwd);
        $sql = mysqli_query($link, "SELECT id, surname, first_name, patronymic, group_id from users WHERE login='{$login}' and password='{$passwd}'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql); 
            $current_time = time();
            $_SESSION['user_token'] = md5($row["id"].$current_time.$_SERVER['REMOTE_ADDR']);
            $_SESSION['token_time']  = $current_time;
            $_SESSION['user_id'] = $row["id"];
            header('Location:?p=list');
            exit;
        } else {
            $info[] = 'Неверный логин или пароль';
        }
    }
}
?>
<div class = "login-form">
<h1>Авторизация</h1>
<?php
if (count($info)>0) {
    echo '<p class="errors">'.implode(' ',$info).'</p>';
}
?>
<form method="post" action="">
  <div class="mb-3">
    <label for="InputLogin" class="form-label">Имя пользователя</label>
    <input type="text" class="form-control" id="InputLogin" name="login">
  </div>
  <div class="mb-3">
    <label for="InputPassword" class="form-label">Пароль</label>
    <input type="password" class="form-control" id="InputPassword" name="passwd">
  </div>
  <button type="submit" class="btn btn-primary" name="ok">Войти</button>
</form>
</div>