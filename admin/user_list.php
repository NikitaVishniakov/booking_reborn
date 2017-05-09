<?php 
    include("header.php"); 
    onlyAdmin();
    $users = $link->query("SELECT * FROM users");
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
<?php include("footer.php"); ?>