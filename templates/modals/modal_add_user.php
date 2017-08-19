<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 14.08.17
 * Time: 21:10
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Добавить пользователя</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
    <?php if($action == 'edit'):?>
    <div data-action="users/delete_user" data-id="<?=$user['id'] ?? ''?>" class="btn need-confirm btn-small btn-red">Удалить</div>
    <?php endif; ?>
</div>
<form method="post" action="/admin/users/<?=$action?>_user" class="form form-horizontal">
    <?php if($action == 'edit'):?>
        <input type="hidden" name="user[id]" value="<?=$user['id']?>">
    <?php endif; ?>

    <div class="modal-content">
        <div class="row">
            <div class="label">
                <label class="">ФИО</label>
            </div>
            <div class="input-wrapper">
                <input required name="user[name]" class="input" value="<?= $user['name'] ?? ''?>" type="text">
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Роль в системе</label>
            </div>
            <div class="input-wrapper">
                <select required name="user[status]" class="input select">
                  <?php foreach ($status_options  as $option):?>
                        <?= $option ?>
                  <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Логин (для входа в систему)</label>
            </div>
            <div class="input-wrapper">
                <input required name="user[login]" class="input" value="<?= $user['login'] ?? ''?>" type="text">
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Пароль</label>
            </div>
            <div class="input-wrapper">
                <input <?php if($action == 'add'):?> required <?php endif; ?> name="user[password]" class="input" type="text" placeholder="<?= $placeholder ?? ''?>">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div id="cancel" class="btn btn-big btn-default">Отмена</div>
        <input name="user[submit]" type="submit" value="Сохранить" class="btn btn-big btn-green" />
    </div>
</form>

