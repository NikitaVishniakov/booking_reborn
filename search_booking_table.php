
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Просмотр брони</h4>
      </div>
<!--      <form class="form" method="get" action="#">-->
          <div class="modal-body">
              <div class="col-md-10 col-md-offset-1">
                  <table class="table">
                  <?php 
                        if(isset($query)){
                            while($row = $query->fetch_array()){
                    ?>
                    <tr id="<?php echo $row['id']; ?>">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['roomNum']; ?></td>
                        <td><?php echo $row['guestName']; ?></td>
                        <td><?php echo $row['dateStart']; ?></td>
                        <td><?php echo $row['dateEnd']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                    </tr>
                  <?php
                            }
                        }
                    ?>
                  </table>
              </div>
          </div>
    </div>
</div>

