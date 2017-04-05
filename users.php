<?php 
    include("header.php"); 
    onlyAdmin();
    $users = $link->query("SELECT * FROM users");
//SELECT whoAdd, source, guestName, amount*0.1 as b_sum from booking where (dateStart BETWEEN '2017-03-01' AND '2017-03-31') AND (canceled = 0) AND (checkIn = 1) AND (NOT source = 'постоянщик') AND (NOT source = 'Booking')

?>
<div class="container-fluid users-container">
    <div class="col-md-3 left-block">
        <ul class="left-menu">
            <a href="users.php?section=add"><li><span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-user"></span> Добавить пользователя</li></a>
            <a href="users.php?section=list"><li><span class="glyphicon glyphicon-list"></span> Список пользователей</li></a>
        </ul>
    </div>
    <div class="col-md-9 main-body">                        
        <div class="col-md-10 col-md-offset-1">
            <table class="table">
                    <thead>
                        <th></th>
                        <th>ID</th>
                        <th>Логин</th>
                        <th>Имя</th>
                        <th>Статус</th>
                        <th>Дата последнего входа</th>
                    </thead>
                    <tbody>
                        <form>
                        <?php 
                                while($row = $users->fetch_array()){
                                    echo "<tr>
                                                <td><input type='checkbox' name='{$row['id']}' id='{$row['id']}'></td>
                                                <td>{$row['id']}</td>
                                                <td>{$row['login']}</td>
                                                <td>{$row['name']}</td>
                                                <td>{$row['status']}</td>
                                                <td>{$row['dateSignUp']}</td>
                                               
                                          </tr>";
                                }
                        ?>
                        </form>
                    </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal add_user hidden">
            <form class="form col-md-8 col-md-offset-2" action="actions.php?action=addUser" method="post" >
                <legend>Добавить пользователя</legend>
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input class="form-control" type="text" name="login" id="login" placeholder="Придумайте логин."
                </div> 
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Введите имя."
                </div>
                <div class="form-group">
                    <label for="password">Введите пароль</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="password_repeat">Повторите пароль</label>
                    <input class="form-control" type="password" name="password_repeat" id="password_repeat">
                </div>
                <div class="form-group col-md-6 col-md-offset-6">
                    <input type="submit" name="add_user" value="Добавить пользователя" class="btn btn-success">    
                </div>
            </form>
        </div>
<?php include("footer.php"); ?>
