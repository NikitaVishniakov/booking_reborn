
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
        <table class="table table-costs table-users">
            <thead>
            <th class="id">ID</th>
            <th class="login">Логин</th>
            <th class="name">Имя</th>
            <th class="status">Статус</th>
            <th class="date-login">Дата последнего входа</th>
            </thead>

            <tbody>
            <?php foreach ($arrUsers as $user): ?>
                <tr class="btn-modal" data-action="edit_user" data-modal="modal" data-id="<?=$user['id']?>">
                    <td class="id"><?=$user['id']?></td>
                    <td class="login"><?=$user['login']?></td>
                    <td class="name"><?=$user['name']?></td>
                    <td class="status"><?=$user['status']?></td>
                    <td class="date-login"><?=$user['dateSignUp']?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>
