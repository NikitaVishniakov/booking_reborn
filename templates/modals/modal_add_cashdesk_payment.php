
<div class="modal-header">
    <div class="modal-header-text">Внесение платежа</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
    <div class="<?=$hidden?> header-actions">
        <div data-action="payments/delete_payment" data-id="<?=$payment['id']?>" class="btn need-confirm btn-small btn-red">Удалить</div>
    </div>
</div>
<form class="form form-horizontal" method="post" action="<?=$action?>">
    <input type="hidden" name="bookingId" value="">
    <input type="hidden" name="status" value="+">
    <input type="hidden" name="whoAdd" value="<?= $_SESSION['id']?>">
    <input type="hidden" name="whoPay" value="<?= $_SESSION['id']?>">
    <input type="hidden" name="name" value="внесение в кассу">
    <input type="hidden" <?=$disabled?> name="date" value="<?=$date?>">
    <input type="hidden" name="type" value="Наличные">
    <div class="modal-content">
        <div class="row">
            <div class="label">
                <label class="">Сумма:</label>
            </div>
            <div class="input-wrapper">
                <input required class="input" name="amount" type="text" value="<?=$value?>">
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="modal-footer">
        <div id="cancel" class="btn btn-big btn-default">Отмена</div>
        <input type="submit" name="submit" class="btn btn-big btn-green" value="Сохранить" />
    </div>
</form>

