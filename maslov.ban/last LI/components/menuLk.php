<div class="col-xl-4">
    <div class="text-center">
        <img src="<?= isset($props['urlAva']) ? $props['urlAva'] : '' ?>" alt="avatar" class="avatar">
    </div>
    <div class="my-4">
        <form action="/handlers/user/avatar.php" method="post" enctype="multipart/form-data">
            <label for="ava" class="form-label">Выберите аватар</label>
            <input class="form-control required" type="file" id="ava" name="ava" accept=".jpg, .jpeg, .png, .gif">
            <div class="error text-center">
                <?php
                if (isset($_SESSION['errorAva'])) {
                    echo $_SESSION['errorAva'];
                    unset($_SESSION['errorAva']);
                }
                ?>
            </div>
            <div class="msg text-center">
                <?php
                if (isset($_SESSION['msgAva'])) {
                    echo $_SESSION['msgAva'];
                    unset($_SESSION['msgAva']);
                }
                ?>
            </div>
            <input type="submit" class="btn mt-2" value="Установить">
        </form>
    </div>
    <div class="text-center">
        <h3><?= $_SESSION['last_name'] ?> <?= $_SESSION['first_name'] ?></h3>
    </div>
    <hr>
    <?php
        if ($_SESSION['id_role'] == 2) {
            $activeAll = $_GET['q'] == 'ad/all' ? 'activeLk' : '';
            $activeList = $_GET['q'] == 'ad/list' ? 'activeLk' : '';
            echo "
                    <div>
                        <a class='$activeAll' href='/ad/all'>Все объявления пользователей</a>
                    </div>
                    <div>
                        <a class='$activeList' href='/ad/list'>Отправленные объявления пользователей</a>
                    </div>
                ";
        }
    ?>
    <div>
        <a class="<?= isset($_GET['favorite']) ? 'activeLk' : '' ?>" href="/lk?favorite=true">Избранное</a>
    </div>
    <div>
        <a class="<?= count($_GET) < 2 && $_GET['q'] != 'ad/list' && $_GET['q'] != 'ad/all' ? 'activeLk' : '' ?>" href="/lk">Все объявления</a>
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