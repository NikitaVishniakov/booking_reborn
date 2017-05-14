<?php 
include("header.php");
onlyAdmin();
if(isset($_GET['month'])){
    $month_num = $_GET['month'];
}
else{
    if(date("d") < 11){
        $month_num = date("m") - 1;
    }
    else{
        $month_num = date("m");
    }
}
$costs_sorted = getSortedCosts($month_num);
$totals_all = 0;
foreach($costs_sorted as $category => $elements){
    foreach($elements as $element){
        foreach($element as $value){
            $totals_all += $value['AMOUNT'];
        }
    }
}
?>
    <div class="show_booked hidden"></div>
<div class="container-fluid users-container">
<div class="modal-add-cat hidden">
</div>
<div id="show-costs" class="modal-cost hidden">
</div>
<?php include("components/finance-menu.php"); ?>
    <div class="col-md-9 main-body">
        <div class="top-block">
            <form class="costs-form" action="actions.php" method="post">
                <div class="row">
                    <div class="form-group">
                        <label id="cost-category-label" for="cost-category">Выберите категорию</label>
                        <select id="cost-category" class="form-control" name="cost_category">
                            <option value=""> Не выбрано</option>
                           <?php selectCostCategories(); ?>
                        </select>
                        <a href="javascript:void(0)" id="modal-add-cat" class="btn-add-item">+ Добавить категорию</a>
                    </div>                
                    <div class="form-group cost-sub-category">
                        <label for="cost-sub-category">Выберите подкатегорию:</label>
                        <select id="cost-sub-category" class="form-control" name="cost_sub_category">
                            <option value=""> Не выбрано</option>
                        </select>
                        <a href="javascript:void(0)" id="modal-add-subcat" class="btn-add-item" >+ Добавить подкатегорию</a>
                    </div>
                    <div class="form-group">
                        <label for="payment-type">Способ оплаты:</label>
                        <select class="form-control" id="payment-type" name="PAYMENT_TYPE">
                            <option>Наличные</option>
                            <option>Безналичный расчет</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="cost-name">Наименование: </label>
                        <input required type="text" id="cost-name" name="cost_name" class="form-control">
                    </div>  
                    <div class="form-group">
                        <label for="cost-amount">Сумма:</label>
                        <input required type="text" class="form-control" name="cost_amount" id="cost-amount">
                    </div>
                    <div class="form-group">
                        <label id="costs-units-label" for="costs-units">Единица измерения:</label>
                        <select class="form-control" id="costs-units" name="costs-units">
                            <option value=""> Не выбрано</option>
                            <?php selectGetUnity(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cost-quantity">Количество:</label>
                        <input type="text" class="form-control" name="cost-quantity" id="cost-quantity">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <input type="submit" name="ADD_COST" id="send-form" class="btn btn-success" value="Добавить">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row costs-row">
        <h1>Список расходов</h1>
         <form class="month-select-flex" action="#" method="get" id="month_select">
            <select name="month"class="income_month_select">
            <?php selectMonth($month_num); ?>
            </select>
             <input type="submit" class="btn btn-info btn-small" value="Подтвердить">
        </form>
        <div class="total-all"><p class="total-all-text">Итого: <?php echo money($totals_all); ?> </p></div>
        <div class="clear"></div>
        <div class="costs-container">
            
            <?php
            foreach($costs_sorted as $category => $elements){
                if(is_array($elements)){
                    $totals_cat = 0;
                    foreach($elements as $element){
                            foreach($element as $value){
                                $totals_cat += $value['AMOUNT'];
                            }
                    }
                    $totals_cat = money($totals_cat);
                    echo "<div class='category'><h2>$category<span class='totals float-left'>$totals_cat</span></h2></div><div class='category-elements'>";
 
                    foreach($elements as $subcategory => $element){
                        if(is_array($element)){
                            $totals = 0;
                            foreach($element as $value){
                                $totals += $value['AMOUNT'];
                            }
                            $totals = money($totals);
                            echo "<div class='category'><h3>$subcategory <span class='totals float-left'>$totals</span></h3></div><div class='category-elements'>";
            ?>
<table class="table table-costs">
    <thead>
        <tr>
            <th>ID</th>
            <th>Наименование</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Количество</th>
        </tr>
    </thead>
    <tbody>
            <?php
            foreach($element as $value){
//                   if(){
//                       
//                   }
                $quantity = '';
                if($value['QUANTITY'] != 0){
                    $quantity = $value['QUANTITY']." ".$value['UNIT'];
                }
                $date = date_format(date_create($value['DATE']), 'd.m.Y');
                $amount = money($value['AMOUNT']);
               echo "<tr class='cost-item' id='{$value['ID']}'><td>{$value['ID']}</td> <td>{$value['NAME']}</td><td>{$date}</td><td>{$amount}</td><td>{$quantity}</td><tr>"; 
            }
            ?>
    </tbody>
</table>
</div>
            <?php
            }
        }
        ?>
    </div>
        <?php
    }
}
            ?>
        </div>
    </div>
</div>
<div class="margin-top"></div>
<script>
    $(document).ready(function(){
        $('.btn-add-item').click(function(){
            var modal = $(this).attr('id');
            var parent_id_modal = 0;
            if(modal == 'modal-add-subcat'){
                parent_id_modal = $('#cost-category').val();
            }
            $.ajax({
              url: "modals/" + modal + ".php",
              type: 'GET',
              data: {
                  parent_id_modal: parent_id_modal
              },
              success: function(data){
//                    prompt(data);
                   $('.modal-add-cat').html(data);
                   $('.modal-add-cat').removeClass('hidden'); 
                   $('.layout').removeClass('hidden'); 
                }
            });
        });
        $('#cost-category').on("change", function(){
             var parent_id = $('#cost-category').val();
             $.ajax({
                url: "actions.php",
                type: 'GET',
                data:{
                    action: 'get_subcategories',
                    parent_id: parent_id
                },
                success: function(data){
                   $('#cost-sub-category').html(data);
                }
            });
        });
        $('.costs-form').submit(function(){
            var parent_val = $('#cost-category').val();
            var quantity = $('#cost-quantity').val();
            var units = $('#costs-units').val()
            var error = false;
            if(parent_val == ''){
                $('#cost-category').addClass('error-input');
                $('#cost-category-label').addClass('red');
                error = true;
            }
            else{
                $('#cost-category').removeClass('error-input');
                $('#cost-category-label').removeClass('red');
            }
            if(quantity != ''){
                if(units == ''){
                    $('#costs-units').addClass('error-input');
                    $('#cost-units-label').addClass('red');
                    error = true;
                }
                else{
                    $('#costs-units').removeClass('error-input');
                    $('#cost-units-label').removeClass('red');
                }
            }
            
            if(error){
                return false;
            }
        });
    
        $('.cost-item').click(function(){
        var id = $(this).attr("id");
        var action = "showCostItem";
            $.ajax({
                  url: "actions.php",
                  type: "GET",
                  data: {
                    action: action,
                    id: id
                  },
                  success: function(data){
                        $('#show-costs, .layout').removeClass('hidden');
                        $('#show-costs').html(data);
                    }

            });
        });
        $('div.category').click(function(){
           $(this).next().toggle("slow");
        });
    });
</script>
<?php include("footer.php"); ?>