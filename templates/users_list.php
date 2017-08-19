
<div class="main-container">
    <div class="page-header">
        <div class="left">
            Список пользователей
        </div>
        <div class="right">
            <span data-action="add_user" data-modal="modal" class="btn btn-small btn-default">Добавить пользователя</span>
        </div>
    </div>
    <div class="incomes-container">
        <table class="table table-costs">
            <thead>
            <th>ID</th>
            <th>Логин</th>
            <th>Имя</th>
            <th>Статус</th>
            <th>Дата последнего входа</th>
            </thead>

            <tbody>
            <?php foreach ($arrUsers as $user): ?>
                <tr class="btn-modal" data-action="edit_user" data-modal="modal" data-id="<?=$user['id']?>">
                    <td><?=$user['id']?></td>
                    <td><?=$user['login']?></td>
                    <td><?=$user['name']?></td>
                    <td><?=$user['status']?></td>
                    <td><?=$user['dateSignUp']?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>
