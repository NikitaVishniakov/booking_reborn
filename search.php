<?php 
    include("header.php");
    if(isset($_POST['submit_search'])){
        $find = $_POST['input_search'];
        $search = $link->query("SELECT * FROM booking WHERE guestName LIKE '%{$find}%' OR booker LIKE '%{$find}%'");
//        echo "SELECT * FROM booking WHERE guestName LIKE '%{$find}%' OR booker LIKE '%{$find}%'";
        if(mysqli_num_rows($search) != 0){
            $table = "";
            $no_res = "hidden";
        }
        else{
            $table = "hidden";
            $no_res = "";
        }
    }

?>
<div class="container">
    <div class="row">
        <h2 class="header-search">Результаты  поиска: </h2>
    </div>
    <table class="table <?php echo $table ?>">
        <thead>
            <tr>
                <th>id</td>
                <th>Бронировал</th>
                <th>Имя гостя</th>
                <th>Дата въезда</th>
                <th>Дата выезда</th>
                <th>Номер</th>
                <th>Кем добавлена</th>
                <th>Дата добавления</th>
            </tr>
        </thead>
        <?php if($table == ""){
        while($row = $search->fetch_array()){
            $row['dateStart'] = date_format(date_create($row['dateStart']), "d.m.Y");
            $row['dateEnd'] = date_format(date_create($row['dateEnd']), "d.m.Y");
            $row['bookingDate'] = date_format(date_create($row['bookingDate']), "d.m.Y");
            
            if($row['canceled'] == 1){
                $canceled = "canceled";
            }
            else{
                $canceled = "";
            }
            echo 
                "
                <tr class='booked_pole {$canceled}' href='#' title='{$row['id']}'>
                <td>{$row['id']}</td>
                <td>{$row['booker']}</td>
                <td>{$row['guestName']}</td>
                <td>{$row['dateStart']}</td>
                <td>{$row['dateEnd']}</td>
                <td>{$row['roomNum']}</td>
                <td>{$row['whoAdd']}</td>
                <td>{$row['bookingDate']}</td>    
                </tr>
               ";
        }
    } ?>
    </table>
    <div class="no-results <?php echo $no_res; ?>">
        <p>К сожалению, по вашему запросу ничего не найдено :( <br> Попробуйте другой запрос</p>
        <form name="form_search" method="post" action="#" class="form col-md-4">
                <label>Поиск бронирования</label>
            <div class="form-group col-md-8">
                <input type="text" class="form-control" name="input_search" placeholder="Введите имя гостя..">
            </div>
            <div class="form-group col-md-4">
                <button name="submit_search" class="form-control btn btn-warning search_btn">Искать</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
            $('.booked_pole').click(function(){
                var id = $(this).attr("title");
                var url = $('.redirect').text() + id;
                $(location).attr('href',url);
            });
    });
</script>
<?php 
    include("footer.php");
?>