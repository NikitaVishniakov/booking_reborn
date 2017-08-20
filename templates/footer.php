<?php
?>
<div class="layout"></div>
<div class="modal">
    <div class="modal-header">
        <div class="modal-header-text">Это заголовок модального окна</div>
        <div class="header-actions">
            <div class="btn btn-small btn-blue">Действие</div>
            <div class="btn btn-small btn-yellow">Действие</div>
            <div class="btn btn-small btn-red">Действие</div>
        </div>
        <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
    </div>
    <div class="modal-content">

    </div>
    <div class="modal-footer">
        <div id="cancel" class="btn btn-big btn-default">Отмена</div>
        <div class="btn btn-big btn-green">Сохранить</div>
    </div>
</div>
<div class="modal-small">
    <div class="modal-header">
        <div class="modal-header-text">Это заголовок модального окна</div>
        <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
    </div>
    <div class="modal-content">
        <form class="form form-vertical form-add-cat">
            <div class="row">
                <div class="label">
                    <label class="">Введите название категории</label>
                </div>
                <div class="input-wrapper">
                    <input class="input" type="text">
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <div id="cancel" class="btn btn-big btn-default">Отмена</div>
        <div class="btn btn-big btn-green">Сохранить</div>
    </div>
</div>
<div class="layout-small"></div>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="../libs/air-datepicker/dist/js/datepicker.min.js"></script>
<script src="../js/script.js?<?php echo(microtime(true)); ?>"></script>
<script src="../js/add_booking.js?<?php echo(microtime(true)); ?>"></script>
</body>
</html>
