<?php require_once 'components/header.php' ?>

<main>
    <div class="container py-5 px-4">
        <div class="row">

            <?php require_once 'components/menuLk.php' ?>

            <div class="col-xl-8 mt-sm-3 mt-xl-0">
                <h2 class="mb-sm-3 mb-xl-5">
                    <?php
                        if (isset($_GET['favorite'])) {
                            echo 'Избранное';
                        } elseif (isset($_GET['completed'])) {
                            echo 'Завершенные объявления';
                        } elseif (isset($_GET['rejected'])) {
                            echo 'Отклоненные объявления';
                        } elseif (isset($_GET['published'])) {
                            echo 'Опубликованные объявления';
                        } elseif (isset($_GET['send'])) {
                            echo 'Отправленные объявления';
                        } else {
                            echo 'Все объявления';
                        }
                    ?>
                </h2>
                <div class="msg">
                    <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                </div>
                <div class="row text-center">
                    <?php
                        if (count($props['ads']) > 0) {
                            foreach ($props['ads'] as $ad) {
                                $id = $ad['id_ad'];
                                $name = $ad['title_ad'];
                                $url = $ad['url_img'];
                                $status = isset($ad['name_status']) ? "<p class='card-text'>Статус: ".$ad['name_status']."</p>" : '';
                                $delete = isset($ad['id_creator_ad']) && $ad['id_creator_ad'] == $_SESSION['id_user'] ? "
                                    <form class='d-inline-block' action='/handlers/ad/delete.php' method='post'>
                                        <input type='hidden' name='idAd' value='$id'>
                                        <button class='btn'>Удалить</button>
                                    </form>
                                " : '';
                                $price = isset($ad['price']) ? "<p class='card-text'>Цена: ".$ad['price']." руб.</p>" : '';

                                echo "
                                        <div class='col-xl-6 col-lg-12 mb-3'>
                                            <div class='card'>
                                                <img src='$url' class='card-img-top' alt='adImg'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>$name</h5>
                                                    $price
                                                    $status
                                                    <a href='/ad/$id' class='btn'>Посмотреть</a>
                                                    $delete
                                                </div>
                                            </div>
                                        </div>
                                ";
                            }
                        } else {
                            echo "<div>Ничего не найдено</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'components/footer.php' ?>
