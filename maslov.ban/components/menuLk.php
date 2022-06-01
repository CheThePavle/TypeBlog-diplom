<div class="col-xl-4">
    <div class="text-center">
        <img src="/public/img/user.png" alt="avatar">
    </div>
    <div class="text-center">
        <h3><?= $_SESSION['last_name'] ?> <?= $_SESSION['first_name'] ?></h3>
    </div>
    <hr>
    <div>
        <a href="/lk">Мои объявления</a>
    </div>
    <div>
        <a href="/lk?favorite=true">Избранное</a>
    </div>
    <div>
        <a href="/lk?completed=true">Мои завершенные объявления</a>
    </div>
    <?php
    if ($_SESSION['id_role'] == 2) {
        echo "
            <div>
                <a href='/ad/list'>Отправленные посты</a>
            </div>
        ";
    }
    ?>
</div>