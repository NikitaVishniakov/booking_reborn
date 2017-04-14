<?php  
    include("header.php");
    $select = $link->query("SELECT * FROM booking WHERE id=381");
    $profile = $select->fetch_array();
    $nights = getDaysCount($profile['dateStart'], $profile['dateEnd']);
    $price_per_night = $profile['amount'] / $nights;
    echo $price_per_night."<br>";
    $time1 = strtotime('08:00');
    $time2 = strtotime('09:30');
    $difference = round(abs($time2 - $time1) / 3600,2);
    echo $difference."<br>";
    $price_per_hour = $price_per_night / 24;
    echo round($price_per_hour)."<br>";
    echo money(round($price_per_hour*$difference))."<br>";
//    prolongationOptions()dcs
?>
<!--
<div class="modal">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form class="form" action="actions.php" method="post">
      <div class="modal-header">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Продление</h4>
      </div>
          <div class="modal-body">
          </div>
         <div class="modal-footer">
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">Отменить</button>
                <input type="submit" class="btn btn-primary" name="submit_prolongation
" value="Подтвердить">
                <input type="text" name="id" class="hidden" value="<?php echo $query['id']; ?>">
             
             
          </div>
  </form>
  </div>
</div>
<script>
    $(document).ready(function(){
    $('.modal').show();
    $('.layout, .close, .cancel').click(function(){
                $('.layout').addClass('hidden');
                $('.modal').addClass('hidden');
        });
    });
</script>
</div>
-->
<a href="javascript:void(0)" id="btn">Показать</a>
<div class="modal-box modal-prolongation">
</div>
<script>
    $(document).ready(function(){
        $('#btn').click(function(){
            $('.modal-prolongation').removeClass('hidden');
            $.ajax({
                  url: "actions.php",
                  type: "GET",
                  data: {
                    action: "modal-prolongation-options"
                  },
                    success: function(data){
                       $('.modal-prolongation').html(data);
                    }
            });
        });
    });
</script>
<?php
    include("footer.php");
?>
