<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 21:07
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Внесение платежа</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
    <div class="header-actions">
        <div data-action="payments/delete_payment" data-id="<?=$payment['id']?>" class="btn need-confirm btn-small btn-red">Удалить</div>
    </div>
</div>
<form class="form form-horizontal" method="post" action="/admin/payments/edit_payment/<?=$payment['id']?>">
    <div class="modal-content">
        <div class="row">
            <div class="label">
                <label class="">Сумма:</label>
            </div>
            <div class="input-wrapper">
                <input class="input" name="amount" type="text" value="<?=$payment['amount']?>">
            </div>
            <div class="clear"></div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Тип платежа:</label>
            </div>
            <div class="input-wrapper">
                <select class="input select" name="name" type="text">
                    <?php selectPaymentName($payment['status'], $payment['name']) ?>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Способ оплаты:</label>
            </div>
            <div class="input-wrapper">
                <select class="input select" name="type" type="text">
                    <?php selectPaymentType($payment['type'])?>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Комментарий:</label>
            </div>
            <div class="input-wrapper">
                <input class="input" name="comment" type="text" value="<?=$payment['comment']?>">
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="modal-footer">
        <div id="cancel" class="btn btn-big btn-default">Отмена</div>
        <input type="submit" name="submit" class="btn btn-big btn-green" value="Сохранить" />
    </div>
</form>

