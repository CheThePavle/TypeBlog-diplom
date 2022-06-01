<?php require_once 'components/header.php' ?>

<main>
    <div class="container py-5 px-4">
        <div class="row">

            <?php require_once 'components/menuLk.php' ?>

            <div class="col-xl-8 mt-sm-3 mt-xl-0">
                <h2 class="mb-sm-3 mb-xl-5">Отправленные объявления</h2>
                <span class="msg">
                    <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                </span>
                <div class="row text-center">
                    <?php
                        if (count($props['ads']) > 0) {
                            foreach ($props['ads'] as $ads) {
                                $idAd = $ads['id_ad'];
                                $urlMainImg = $ads['url_img'];
                                $title = $ads['title_ad'];
                                $nameUser = $ads['last_name'] . ' ' . $ads['first_name'];
                                $phone = $ads['phone'];
                                $email = $ads['email'];
                                $price = isset($ads['body_ad']['price']) ? $ads['body_ad']['price'] : '';

                                echo "
                                    <div class='card col-12 mb-3'>
                                        <div class='row g-0'>
                                            <div class='col-md-4 col-sm-12 p-2'>
                                                <img src='$urlMainImg' class='img-fluid rounded-start' alt='imgAd'>
                                            </div>
                                            <div class='col-md-8'>
                                                <div class='card-body position-relative'>
                                                    <h5 class='card-title'>$title</h5>
                                                    <div class='row text-start'>
                                                        <div class='col-6'>
                                                            <p class='card-text'>Автор: $nameUser</p>
                                                            <p class='card-text'>Телефон: $phone</p>
                                                        </div>
                                                        <div class='col-6'>
                                                            <p class='card-text'>Email: $email</p>
                                                            <p class='card-text'>Цена: $price руб.</p>
                                                        </div>
                                                    </div>
                                                    <a href='/ad/$idAd' class='btn mt-1'>Посмотреть</a>
                                                    <form class='d-inline-block' action='/handlers/ad/published.php' method='post'>
                                                        <input type='hidden' name='idAd' value='$idAd'>
                                                        <button class='btn mt-1'>Опубликовать</button>
                                                    </form>
                                                    <form class='d-inline-block' action='/handlers/ad/rejected.php' method='post'>
                                                        <input type='hidden' name='idAd' value='$idAd'>
                                                        <button class='btn mt-1'>Отклонить</button>
                                                    </form>
                                                    <form class='d-inline-block' action='/handlers/ad/delete.php' method='post'>
                                                        <input type='hidden' name='idAd' value='$idAd'>
                                                        <button class='btn mt-1'>Удалить</button>
                                                    </form>
                                                    <small class='text-muted dateAd'>2018.12.20</small>
                                                </div>
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
