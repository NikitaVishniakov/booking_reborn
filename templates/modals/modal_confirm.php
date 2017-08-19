<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 04.07.17
 * Time: 21:00
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Подтвердите действие</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
</div>
<div class="modal-footer">
    <div id="cancel" class="btn btn-big btn-default">Отмена</div>
    <a href="/admin/<?=$_GET['ACTION']?>/<?=$_GET['ID']?>" id="confirm" class="btn btn-big btn-red">Подтвердить</a>
</div>
