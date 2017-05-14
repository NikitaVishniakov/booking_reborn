<?php
    require_once("../funcs.php")
?>
<div class="modal-dialog" role="document">
        <form method="post" action="actions.php" class="modal-content">
          <div class="modal-header">
            <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Добавить подкатегорию</h4>
          </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <label for="cost-category_modal">Выберите родительскую категорию</label>
                        <select id="cost-category-modal" class="form-control" name="cost_category_modal">
                            <option> Не выбрано</option>
                            <?php selectCostCategories($_GET['parent_id_modal']); 
                            echo $_GET['parent_id_modal'];
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="cat-name">Название подкатегории:</label>
                        <input type="text" name="SUB_CAT_NAME"  id="cat-name" class="form-control" placeholder="Введите название категории">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">Отменить</button>
                <input required type="submit" class="btn btn-primary" name="add-sub-category" value="Добавить">
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