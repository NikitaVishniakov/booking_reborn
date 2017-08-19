<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Base template</title>
    <link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/libs/air-datepicker/dist/css/datepicker.min.css">
    <link rel="stylesheet" href="/style/style.css?<?php echo(microtime(true)); ?>">
</head>
<body>
    <div class="header">
        <nav>
            <ul class="menu">
                <li>
                    <form class="form-vertical search-form">
                            <div class="input-wrapper">
                                <input type="text" class="input input-search">
                                <span class="search-pad">
                                    <input type="submit" class="btn-seatch" value="" >
                                </span>
                            </div>
                    </form>
                </li>
                <li>
                    <a class="active" href="booking_table.php">Таблица бронирований</a>
                </li>
                <li>
                    <a href="cashdesk.php">Касса</a>
                    <ul class="dropdown">
                        <li>
                            <a href="cashdesk.php">Операции и остаток в кассе</a>
                        </li>
                        <li>
                            <a href="deposits.php">Залоги</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="incomes.php">Финансы и отчеты</a>
                    <ul class="dropdown">
                        <li>
                            <a href="incomes.php">Доходы и прибыль</a>
                        </li>
                        <li>
                            <a href="costs.php">Издержки</a>
                        </li>
                        <li>
                            <a href="loading.php">Загрузка отеля</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Пользователи</a>
                </li>
                <li>
                    <a href="#">Настройки</a>
                </li>
            </ul>
            <span class="mobile-open">
                <div class="burger-wrapper">
                    <span class="bugrer-line"></span>
                    <span class="bugrer-line"></span>
                    <span class="bugrer-line"></span>
                </div>
            </span>
            <div class="messenger">
                <i class="fa fa-bell-o fa-2x" aria-hidden="true"></i>
                <span class="msg-cnt">0</span>
            </div>
            <div class="auth-user">
                <a class="user-name" href="#">Admin</a>
                <div class="user-menu">
                    <div class="user-info">
                        Вы вошли как: <span class="user-name">Никита Вишняков</span>
                    </div>
                    <div class="user-actions">
                        <a class="user-settings">Настройки</a>
                    </div>
                    <div class="exit-wrapper">
                        <a href="#">Выход</a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </nav>
    </div>