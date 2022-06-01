<?php require_once 'components/header.php' ?>

<main>
    <div class="container py-5 px-4">
        <div class="row">

            <?php require_once 'components/menuLk.php' ?>

            <div class="col-xl-8 mt-sm-3 mt-xl-0">
                <h2 class="mb-sm-3 mb-xl-5">Все объявления пользователей</h2>
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
                            $phone = strval($ads['phone']);
                            $phone = '+'.substr($phone, 0, 1).'('.substr($phone, 1, 3).')'.substr($phone, 4, 3).'-'.substr($phone, 7, 2).'-'.substr($phone, 9, 2);
                            $status = $ads['name_status'];
                            $price = isset($ads['body_ad']['price']) ? $ads['body_ad']['price'] : '';

                            echo "
                                    <div class='card col-12 mb-3'>
                                        <div class='row g-0'>
                                            <div class='col-md-4 col-sm-12 p-2'>
                                                <img src='$urlMainImg' class='img-fluid rounded-start h-100' alt='imgAd' style='object-fit: cover; height: 160px !important;'>
                                            </div>
                                            <div class='col-md-8 text-start'>
                                                <div class='card-body position-relative'>
                                                    <h5 class='card-title'>$title</h5>
                                                    <div class='row'>
                                                        <div class='col-6'>
                                                            <p class='card-text my-0'>Автор: $nameUser</p>
                                                             <p class='card-text my-0'>Статус: $status</p>
                                                        </div>
                                                        <div class='col-6'>
                                                            <p class='card-text my-0'>Телефон: $phone</p>
                                                            <p class='card-text my-0'>Цена: $price руб.</p>
                                                        </div>
                                                    </div>
                                                    <a href='/ad/$idAd' class='btn mt-2'>Посмотреть</a>
                                                    <form class='d-inline-block' action='/handlers/ad/delete.php' method='post'>
                                                        <input type='hidden' name='idAd' value='$idAd'>
                                                        <button class='btn mt-2'>Удалить</button>
                                                    </form>
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
