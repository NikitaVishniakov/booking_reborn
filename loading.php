<?php
    require("header.php");
    $current_date = "01.".date("m.Y");
    $prev_month = date_format(date_modify(date_create($current_date), "-1 month"), "d.m.Y");
    $prev_prev_month = date_format(date_modify(date_create($prev_month), "-1 month"), "d.m.Y");
    $loading_1 = new RoomLoading($current_date);
    $loading_2 = new RoomLoading($prev_month);
    $loading_3 = new RoomLoading($prev_prev_month);
?>
<div class="container-fluid users-container">
    <?php include("statistics-menu.php"); ?>
    <div class="col-md-9">
        <div class="col-md-10 col-md-offset-1">
                <p class="header text-bold">Общая загрузка номерного фонда:</p>
                <table class="table">
                        <tr>
                            <td>Загрузка за январь:</td>
                            <td><?php echo $loading_3->percents(); ?> %</td>
                        </tr>
                        <tr>
                            <td>Загрузка за февраль:</td>
                            <td><?php echo $loading_2->percents(); ?> %</td>
                        </tr>
                        <tr>
                            <td>Загрузка за текущий месяц(март):</td>
                            <td><?php echo $loading_1->percents(); ?> %</td>
                        </tr>
                </table>    
        </div>
    </div>
</div>
<?php 
require ("footer.php"); 
?>