<table class="table schem-list table-bordered table-striped" style="min-width: 50%;">
<tr><th>#</th><th>Название схемы</th><th>Количество блоков</th><th>Дата создания</th>
<?php if ($sys['user_role_id'] == 1) : ?>
<th>Создатель</th>
        <?php endif; ?>
        </tr>
<tr><td></td>

<?php if ($sys['user_role_id'] == 1) : ?>        
<td colspan="4"><a href="/?p=schema&id=0 ">+ Добавить новую схему</a></td>
<?php else: ?>
<td colspan="3"><a href="/?p=schema&id=0 ">+ Добавить новую схему</a></td>
<?php endif; ?>
</tr>
<?php

use function PHPSTORM_META\type;

$sys["header"] = "Список схем";
//include 'engine/bd.php';
file_put_contents( 'data_user_role.txt', $sys['user_role_id']);
file_put_contents( 'gettype.txt', gettype($sys['user_role_id'])); 
if ($sys['user_role_id'] == 1) {
    $sql = mysqli_query($link, "SELECT s.id, s.name, u.login, s.date_create, count(*) AS block_count from schem s LEFT JOIN users u on s.creator_id = u.id LEFT JOIN blocks b ON b.schem_id=s.id GROUP BY s.id, s.name, u.login, s.date_create ORDER BY s.date_create DESC");
    } elseif ($sys['user_role_id'] == 2) {
        $sql = mysqli_query($link, "SELECT s.id, s.name, s.date_create, count(*) AS block_count from schem s LEFT JOIN blocks b ON b.schem_id=s.id WHERE creator_id = {$_SESSION['user_id']} GROUP BY s.id, s.name, s.date_create ORDER BY s.date_create DESC");
    } else {
        //$sql = NULL;
        mysqli_free_result($sql);
    }
if (mysqli_num_rows($sql) > 0) {
    while( $row = mysqli_fetch_assoc($sql) )
    {
        if ($sys['user_role_id'] == 1) {
            echo '<tr><td>'.$row["id"].'</td><td><a href="/?p=schema&id='.$row["id"].'">'.$row["name"].'</a></td><td>'.$row["block_count"].'</td><td>'.$row["date_create"].'</td><td>'.$row["login"].'</td></tr>';
    	//echo '<li><a href="/?p=schema&id='.$row["id"].'">'.$row["name"]."</a>".' ('.$row["login"].')'."</li>";
        } else {
            echo '<tr><td>'.$row["id"].'</td><td><a href="/?p=schema&id='.$row["id"].'">'.$row["name"].'</a></td><td>'.$row["block_count"].'</td><td>'.$row["date_create"].'</td></tr>';
        }
    }
} 
?>
</table>