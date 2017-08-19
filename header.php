<?php
authCheck();
//debug($this->route['controller']);
$permission = permissionControl();
if($_SESSION['status'] == 'main'){
    $_SESSION['status_name'] = 'Управляющий';
}
else{
    $_SESSION['status_name'] = 'Администратор';
}
?>
<!DOCTYPE html>
<html lang="RU">
<head>
    <meta charset="UTF-8">
    <title>Система управления отелем</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/libs/air-datepicker/dist/css/datepicker.min.css">
    <link rel="stylesheet" href="/templates/style/style.css">
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
                    <a class="<?=getActiveTab($this, 'BookingTable')?>" href="/admin/booking_table">Таблица бронирований</a>
                </li>
                <li>
                    <a class="<?=getActiveTab($this, 'Cashdesk')?>" href="/admin/cashdesk">Касса</a>
                    <ul class="dropdown">
                        <li>
                            <a href="/admin/cashdesk">Операции и остаток в кассе</a>
                        </li>
                        <li>
                            <a href="/admin/cashdesk/deposits">Залоги</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="<?=getActiveTab($this, 'Finance')?> <?=$permission?>" href="/admin/finance/incomes">Финансы и отчеты</a>
                    <ul class="dropdown">
                        <li>
                            <a href="/admin/finance/incomes">Доходы и прибыль</a>
                        </li>
                        <li>
                            <a href="/admin/finance/costs">Издержки</a>
                        </li>
                        <li>
                            <a href="/admin/finance/loading">Загрузка отеля</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="<?=getActiveTab($this, 'Users')?> <?=$permission?>" href="/admin/users/users_list">Пользователи</a>
                </li>
                <li>
                    <a class="<?=getActiveTab($this, 'Settings')?> <?=$permission?>" href="/admin/settings">Настройки</a>
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
                <a class="user-name" href="#"><?=$_SESSION['id']?></a>
                <div class="user-menu">
                    <div class="user-info">
                        Вы вошли как: <span class="user-name"><?=$_SESSION['status_name']?></span>
                    </div>
                    <div class="user-actions">
                        <a class="user-settings">Настройки</a>
                    </div>
                    <div class="exit-wrapper">
                        <a href="/admin/users/logout">Выход</a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </nav>
    </div>