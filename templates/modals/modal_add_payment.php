<div class="modal-header">
    <div class="modal-header-text">Внесение платежа</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
</div>
<form class="form form-horizontal" method="post" action="<?=$PARAMS['ACTION']?>">
    <input type="hidden" name="bookingId" value="<?=$PARAMS['BOOKING_ID']?>">
    <input type="hidden" name="status" value="<?= $PARAMS['STATUS']?>">
    <input type="hidden" name="whoAdd" value="<?= $_SESSION['id']?>">
    <input type="hidden" name="whoPay" value="<?= $PARAMS['WHO_PAY']?>">
<div class="modal-content">
        <div class="row">
            <div class="label">
                <label class="">Сумма:</label>
            </div>
            <div class="input-wrapper">
                <input required class="input" name="amount" type="text" value="<?=$PARAMS['AMOUNT']?>">
            </div>
            <div class="clear"></div>
        </div>
        <div class='<?=$VISIBILITY['payment_name']?> row'>
            <div class="label">
                <label class="">Тип платежа:</label>
            </div>
            <div class="input-wrapper">
                <select  class="input select" name="name" type="text">
                    <?php selectPaymentName($PARAMS['STATUS'], $PARAMS['PAYMENT_NAME']) ?>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <div class="<?=$VISIBILITY['payment_type']?> row">
            <div class="label">
                <label class="">Способ оплаты:</label>
            </div>
            <div class="input-wrapper">
                <select class="input select" name="type" type="text">
                    <?php selectPaymentType($PARAMS['PAYMENT_TYPE'])?>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Комментарий:</label>
            </div>
            <div class="input-wrapper">
                <input class="input" name="comment" type="text">
            </div>
            <div class="clear"></div>
        </div>
</div>
<div class="modal-footer">
    <div id="cancel" class="btn btn-big btn-default">Отмена</div>
    <input type="submit" name="submit" class="btn btn-big btn-green" value="Сохранить" />
</div>
</form>

