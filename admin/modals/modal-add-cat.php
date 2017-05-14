<div class="modal-dialog" role="document">
        <form  action="actions.php" method="post" class="modal-content">
          <div class="modal-header">
            <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Добавить категорию</h4>
          </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <label for="cat-name">Название категории:</label>
                        <input type="text" name="CAT_NAME"  id="cat-name" class="form-control" placeholder="Введите название категории">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">Отменить</button>
                <input required type="submit" class="btn btn-primary" name="add-category" value="Добавить">
            </div>
        </form>
</div>
<script>
$(document).ready(function(){
    $('.close, .cancel').click(function(){
        $('.layout').addClass('hidden');
        $('.modal-add-cat').addClass('hidden');
    });
});
</script>