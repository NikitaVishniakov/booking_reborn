<?php
require("header_old.php");
$date = date("d.m.Y");
$loading = new RoomLoading($date);
?>
<div class="container-fluid users-container">
    <?php include("controllers/statistics-menu.php"); ?>
    <div class="col-md-9 main-body">
        <div class="col-md-10 col-md-offset-1 ">
    <p class="header text-bold">Статистика номерного фонда</p>
    <table class="table ">
        <thead>
            <tr>
                <td>Номер</td>
                <td>Кол-во занятых за  месяц ночей</td>
                <td>Процент загрузки номера</td>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php 
        foreach($loading->loading_list as $room){

            echo "<tr><td>{$room->roomName}</td><td>{$room->bookedNights}</td><td>{$room->percents()} %</td></tr>";
        }
            ?>
        </tbody>
    </table>
</div>
        
    </div>
</div>
<?php 
require ("footer.php"); 
?>