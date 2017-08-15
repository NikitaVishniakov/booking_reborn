<?php include("header_old.php"); ?>
    <div class="modal_services hidden"></div>
<div class="container-fluid users-container">
<?php include("controllers/finance-menu.php"); ?>
    <div class="col-md-9 main-body">
                                        <?php 
    if(isset($_POST['submit'])){
            for($counter = 0; $counter < count($_POST['id']); $counter++){
                $string = "";
                $n = 0;
                foreach($_POST as $key=>$row){
                    if(is_array($row) && $key != 'id'){
                        if($n == 2){
                            $comma = "";
                        }
                        else{
                            $comma = ", ";
                        }
                        $n++;
                        $string .= "$key = '$row[$counter]'$comma";
                    }
                }
                $id = $_POST['id'][$counter];
                $update = $link->query("UPDATE services_list SET $string WHERE id = $id");
                if($update){
                    $message = "изменения сохранены";
                }
                else{
                    $message = "Ошибка";
                }
            }
            unset($_POST);
            echo $message;
        }
    if(isset($_POST['submit_insert'])){
        $counter_keys = 1;
        $colomns = "(";
        $rows = 0;
        foreach($_POST as $key=>$row){
            if($counter_keys == count($_POST) -2 ){
                $separator = ")";
            }
            else{
                $separator = ", ";
            }
            $counter_keys++;
            if(is_array($row) && $key != 'id'){
                $colomns .= $key.$separator;
                $not_null = 0;
                foreach($row as $value){
                    if($value != ''){
                        $not_null++;
                    }
                }
                if($not_null > 0){
                    $rows++;
                }
            }

        }
        if($rows){
            for($i = 0; $i < 1; $i++){
                $values = "(";
                 $counter_keys = 1;
                foreach($_POST as $key=>$row){
                    if($counter_keys == count($_POST) -2 ){
                        $separator = ")";
                    }
                    else{
                        $separator = ", ";
                    }
                    $counter_keys++;
                    if(is_array($row) && $key != 'id'){
                        $values .= "'$row[$i]'"."$separator";
                    }
                }
            $link->query("INSERT INTO services_list $colomns VALUES $values");
            }
        }
    }
unset($_POST);
$services = listOfServices();
                ?>
            <form class="form" action="#" method="post">
                 <?php if($_SESSION['status'] == "main"){ ?>
                <a href="#" class="btn btn-success actions" id="addService" value="">Добавить</a>
                <a href="#" class="btn-info btn change-price actions">Редактировать</a>
                <?php } ?>
                  <table class="table services-table">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Продажная цена</th>
                            <th>Себестоимость</th>
                        </tr>
                    </thead>
                      <tbody>
                <?php 
                    foreach($services as $row) { ?>
                        <tr id="<?php echo $row['id']; ?>">
                            <td><span class="show"><?php echo $row['name']; ?></span>
                                <input type="text" class="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                                <input type="text" class="hidden edit form-control" name="name[]" value="<?php echo $row['name']; ?>">
                            </td>
                            <td><span class="show"><?php echo $row['price']; ?> рублей</span>
                                <input type="text" class="hidden edit form-control" name="price[]" value="<?php echo $row['price']; ?>">
                            </td>
                            <td><span class="show"><?php echo $row['cost_price']; ?> </span>
                                <input type="text" class="hidden edit form-control" name="cost_price[]" value="<?php echo $row['cost_price']; ?>">
                            </td>
                        </tr>
                <?php } ?>
                      </tbody>
                </table>
                <div class="save-panel hidden">
                    <input type='submit' name='submit' id='save_btn' value='Сохранить' class='btn btn-success'>                    
                    <a class='btn btn-default cancel'>Отмена</a>                   
                </div>
            </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.change-price').click(function(){
            $('.show').addClass('hidden');
            $('.actions').addClass('hidden');
            $('.edit').removeClass('hidden');
            $('.save-panel').removeClass('hidden');
        });
        $('.cancel').click(function(){
            $('.actions').removeClass('hidden');
            $('.show').removeClass('hidden');
            $('.edit').addClass('hidden');
            $('.save-panel').addClass('hidden');
            $('.new_row').addClass('hidden');
        });
        $('#addService').click(function(){
            $('#save_btn').attr('name', "submit_insert");
            $('.edit').attr('value', "");
            $('.save-panel').removeClass('hidden');
            $('.new_row').removeClass('hidden');
            $('.change-price').addClass('hidden');
            $('tbody').prepend('<tr class="new_row"> <td><input type="text" class="form-control" name="name[]"<td>' +
                               '<td><input type="text" class="form-control" name="price[]"<td>' +
                                '<td><input type="text" class="form-control" name="cost_price[]"<td></tr>');
        });
    });
</script>
<?php include("footer.php"); ?>