<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 24.06.17
 * Time: 20:16
 */ ?>
<!DOCTYPE html>
<html lang="RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в административную панель</title>
    <link rel="stylesheet" href="/style/style.css">
</head>
    <body>
        <div class="auth-container">
            <form method="post" action="/admin/Users/auth" class="auth-form form-vertical">
                <div class="row">
                    <h1 class="auth-title">Вход в систему</h1>
                </div>
                <div class="row">
                    <div class="label">
                        <label class="">Логин:</label>
                    </div>
                    <div class="input-wrapper">
                        <input class="input" name="login" type="text">
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="row">
                    <div class="label">
                        <label class="">Пароль:</label>
                    </div>
                    <div class="input-wrapper">
                        <input class="input" name="pass" type="password">
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="button-wrapper">
                    <input type="submit" name="submit" value="Войти" class="btn btn-big btn-blue">
                </div>
            </form>
        </div>
    </body>
</html>