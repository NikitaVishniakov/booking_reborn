    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" action="actions.php" method="post">
          <div class="modal-header">
            <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Выбор типа продления</h4>
          </div>
          <div class="modal-body">
              <p></p>
              <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                      <a href="javascript:void(0)" class="btn-prolongation btn-hours">Почасовое продление
                      </a>  
                      <a href="javascript:void(0)" class="btn-prolongation btn-days">Посуточное продление
                      </a>
                  </div>
              </div>
          </div>
      </form>
      </div>
    </div>
<script>
    $(document).ready(function(){
        $('.layout, .close').click(function(){
                $('.layout').addClass('hidden');
                $('.modal-box').addClass('hidden');
        });
        $('.btn-hours').click(function(){
            $.ajax({
                  url: "actions.php",
                  type: "GET",
                  data: {
                    action: "hours-prolongation-modal"
                  },
                    success: function(data){
                       $('.modal-prolongation').html(data);
                    }
            });
        });
    });
</script>