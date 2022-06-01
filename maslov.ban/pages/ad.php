<?php require_once 'components/header.php' ?>

<main>
    <div class="container py-5 px-4">
        <div class="row">
            <div class="col-sm-12 col-lg-10">
                <h1 class="text-center mb-4"><?= $props['ad']['title_ad'] ?></h1>
            </div>
            <div class="col-sm-12 col-lg-2 text-end">
                <form action="/handlers/favorite.php" method="post" class="favoriteForm">
                    <input type="hidden" name="idAd" value="<?= $urls[1] ?>">
                    <input type="submit" class="btn" value="<?= $props['ad']['favorite'] ? 'Удалить из избранного' : 'В избранное' ?>">
                    <div class="msg">
                        <?php
                            if (isset($_SESSION['favorite'])) {
                                echo $_SESSION['favorite'];
                                unset($_SESSION['favorite']);
                            }
                        ?>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 mt-sm-3 mt-xl-0 d-flex align-items-center justify-content-center">
                <div id="sliders" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#sliders" data-bs-slide-to="0" class="active"></button>
                        <?php
                            if (count($props['ad']['imgs']) > 0) {
                                $count = 1;
                                foreach ($props['ad']['imgs'] as $img) {
                                    echo "
                                        <button type='button' data-bs-target='#sliders' data-bs-slide-to='$count'></button>
                                    ";
                                    $count++;
                                }
                            }
                        ?>
                    </div>
                    <div class="carousel-inner">
                        <?php
                            $mainUrlImg = $props['ad']['url_img'];
                            echo "
                                <div class='carousel-item slide active'>
                                    <img src='$mainUrlImg' class='d-block w-100' alt='slide1'>
                                </div>
                            ";
                            if (count($props['ad']['imgs']) > 0) {
                                foreach ($props['ad']['imgs'] as $img) {
                                    $countSlide = 2;
                                    $url = $img['url_img'];
                                    echo "
                                        <div class='carousel-item slide'>
                                            <img src='$url' class='d-block w-100' alt='slide$countSlide'>
                                        </div>
                                    ";
                                    $countSlide++;
                                }
                            }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#sliders" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Назад</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#sliders" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Вперед</span>
                    </button>
                </div>
            </div>
            <div class="col-xl-4 mt-sm-3 mt-xl-0">
                <h4 class="metaRightAd">Цена: <span>das</span></h4>
                <h4 class="metaRightAd">Телефон: <span>das</span></h4>
                <h4 class="metaRightAd">Email: <span>das</span></h4>
                <h4 class="metaRightAd">Адрес: <span>das</span></h4>
                <h4 class="metaRightAd">Автор: <span>das</span></h4>
                <h4 class="metaRightAd">Добавлено: <span>das</span></h4>
            </div>
        </div>

        <h2 class="mt-4">Основное</h2>
        <div class="row">
            <div class="col-lg-12 col-xl-6 metaBlockMain">
                <div class="metaMainBlockAd">
                    <h4 class="metaMainAd">Модель: <span>BMW</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                </div>
            </div>
            <div class="col-lg-12 col-xl-6 metaBlockMain">
                <div class="metaMainBlockAd">
                    <h4 class="metaMainAd">Марка: <span><?= $props['ad']['name_object'] ?></span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                </div>
            </div>
        </div>

        <h2 class="mt-4">Цена и пр.</h2>
        <div class="row">
            <div class="col-lg-12 metaBlockMain">
                <div class="metaMainBlockAd">
                    <h4 class="metaMainAd">Текст объявления: <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda aut autem commodi eveniet harum id inventore ipsa maxime minus, neque quidem, quos suscipit tempore temporibus, totam ut voluptate voluptatum.</span></h4>
                </div>
            </div>
            <div class="col-lg-12 col-xl-6 metaBlockMain">
                <div class="metaMainBlockAd">
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                </div>
            </div>
            <div class="col-lg-12 col-xl-6 metaBlockMain">
                <div class="metaMainBlockAd">
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                    <h4 class="metaMainAd">Параметр: <span>значение</span></h4>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'components/footer.php' ?>
