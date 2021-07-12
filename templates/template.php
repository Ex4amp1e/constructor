<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Построитель</title>
    <style>
        @import url(../css/site.css);
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/site.js"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body>
    <?php if ($sys['page'] != 'login') : ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <?php if ($sys['page'] != 'list') : ?>
                    <a class="navbar-brand mb-0 h1" href="/?p=list" style="margin-left:50px;">Список схем</a>
                <?php endif; ?>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                    <?php if ($sys['fio'] != '') : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $sys['fio'] ?></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/?p=exit">Выход</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <div class="content">
        <h1 style="margin:5px;"><?= $sys["header"] ?></h1>
        <?= $sys["content"] ?>
    </div>
</body>

</html>