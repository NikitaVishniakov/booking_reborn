<?php 
require_once("funcs.php");
require_once("table.php");
require_once("connection.php");
//session_start();
authCheck();
$permission = permissionControl();

?>
<!DOCTYPE html>
<html lang="RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <link rel="stylesheet" href="air-datepicker/dist/css/datepicker.min.css" type="text/css">
    <link rel="stylesheet" href="style/css/main.css?t=<?php echo(microtime(true)); ?>">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="air-datepicker/dist/js/datepicker.min.js"></script>
    <title>Система бронирования</title>
</head>
<body>
    <div class="layout hidden"></div>
    <nav class="navbar navbar-default">
        <div class="continer">
             <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li class="<?php if(preg_match('/index.php/', $_SERVER['REQUEST_URI'])){echo "active";}?>"><a href="index.php"><span class="glyphicon glyphicon-calendar"></span> Таблица бронирований</a></li>
                    <li class="<?php if(preg_match('/finance.php/', $_SERVER['REQUEST_URI'])){echo "active";}?>"><a href="finance.php"><span class="glyphicon glyphicon-ruble"></span> Финансы</a></li>
                    <li class="<?php if(preg_match('/statistics.php/', $_SERVER['REQUEST_URI'])){echo "active";}?> <?php echo $permission; ?>"><a href="statistics.php"><span class="glyphicon glyphicon glyphicon-info-sign"></span> Статистика</a></li>
                    <li class="<?php if(preg_match('/users.php/', $_SERVER['REQUEST_URI'])){echo "active";}?> <?php echo $permission; ?>"><a href="users.php"><span class="glyphicon glyphicon glyphicon-user"></span> Пользователи</a></li>
                    <li class="<?php if(preg_match('/settings.php/', $_SERVER['REQUEST_URI'])){echo "active";}?><?php echo $permission; ?>"><a href="settings.php"><span class="glyphicon glyphicon-cog"></span> Настройки</a></li>
                </ul>
                <div class="nav navbar-form navbar-right">
                    Вы вошли как <a class="login_name" href="#"><?php echo $_SESSION['id']; ?></a>
                    <a href="actions.php?action=exit" class="btn btn-default exit">Выйти</a>
                </div>
                 
            </div>
        </div>
    </nav>
    <p class="redirect hidden"><?php echo REDIRECT_JS;?></p>