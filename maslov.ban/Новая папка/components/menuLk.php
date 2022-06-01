<div class="col-xl-4">
    <div class="text-center">
        <img src="/public/img/user.png" alt="avatar">
    </div>
    <div class="text-center">
        <h3><?= $_SESSION['last_name'] ?> <?= $_SESSION['first_name'] ?></h3>
    </div>
    <hr>
    <?php
        if ($_SESSION['id_role'] == 2) {
            $active = $_GET['q'] == 'ad/list' ? 'activeLk' : '';
            echo "
                    <div>
                        <a class='$active' href='/ad/list'>Отправленные объявления пользователей</a>
                    </div>
                ";
        }
    ?>
    <div>
        <a class="<?= isset($_GET['favorite']) ? 'activeLk' : '' ?>" href="/lk?favorite=true">Избранное</a>
    </div>
    <div>
        <a class="<?= count($_GET) < 2 && $_GET['q'] != 'ad/list' ? 'activeLk' : '' ?>" href="/lk">Все объявления</a>
    </div>
    <div>
        <a class="<?= isset($_GET['send']) ? 'activeLk' : '' ?>" href="/lk?send=true">Отправленные объявления</a>
    </div>
    <div>
        <a class="<?= isset($_GET['published']) ? 'activeLk' : '' ?>" href="/lk?published=true">Опубликованные объявления</a>
    </div>
    <div>
        <a class="<?= isset($_GET['rejected']) ? 'activeLk' : '' ?>" href="/lk?rejected=true">Отклоненные объявления</a>
    </div>
    <div>
        <a class="<?= isset($_GET['completed']) ? 'activeLk' : '' ?>" href="/lk?completed=true">Завершенные объявления</a>
    </div>
</div>