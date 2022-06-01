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
                    <input type="submit" class="btn" value="<?= isset($props['ad']['favorite']) ? 'Удалить из избранного' : 'В избранное' ?>">
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
                                    <img src='$mainUrlImg' class='d-block' alt='slide1'>
                                </div>
                            ";
                            if (count($props['ad']['imgs']) > 0) {
                                foreach ($props['ad']['imgs'] as $img) {
                                    $countSlide = 2;
                                    $url = $img['url_img'];
                                    echo "
                                        <div class='carousel-item slide'>
                                            <img src='$url' class='d-block' alt='slide$countSlide'>
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
                <h4 class="metaRightAd">Цена: <span><?= $props['ad']['body_ad']['price'] ?> руб.</span></h4>
                <h4 class="metaRightAd">Телефон: <span><?= $props['ad']['phone'] ?></span></h4>
                <h4 class="metaRightAd">Email: <span><?= $props['ad']['email'] ?></span></h4>
                <h4 class="metaRightAd">Адрес: <span><?= isset($props['ad']['body_ad']['address']) ? $props['ad']['body_ad']['address'] : 'не указан' ?></span></h4>
                <h4 class="metaRightAd">Автор: <span><?= $props['ad']['first_name'].' '.$props['ad']['last_name'] ?></span></h4>
                <h4 class="metaRightAd">Добавлено: <span><?= $props['ad']['updated_at_ad'] ?></span></h4>
            </div>
        </div>

        <h2 class="mt-4">Основное</h2>
        <div class="row">
            <?php
                if (isset($props['ad']['body_ad']['vin'])) {
                ?>
                    <div class="col-sm-12 col-lg-6">
                        <h4 class="metaMainAd">Вин-код: <span><?= $props['ad']['body_ad']['vin'] ?></span></h4>
                    </div>
                <?php
                }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['certificate'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Свидетельство о регистрации ТС: <span><?= $props['ad']['body_ad']['certificate'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <div class="col-sm-12 col-lg-6">
                <h4 class="metaMainAd">Марка: <span><?= $props['ad']['name_object'] ?></span></h4>
            </div>

            <div class="col-sm-12 col-lg-6">
                <h4 class="metaMainAd">Модель: <span><?= $props['ad']['name_model'] ?></span></h4>
            </div>

            <?php
            if (isset($props['ad']['body_ad']['carcase'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Кузов: <span><?= $props['ad']['body_ad']['carcase'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['color'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Цвет: <span><?= $props['ad']['body_ad']['color'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['transmission'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Коробка передач: <span><?= $props['ad']['body_ad']['transmission'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['engineType'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Тип двигателя: <span><?= $props['ad']['body_ad']['engineType'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['drive'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Привод: <span><?= $props['ad']['body_ad']['drive'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['rudder'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Руль: <span><?= $props['ad']['body_ad']['rudder'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['state'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Состояние: <span><?= $props['ad']['body_ad']['state'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['year'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Год: <span><?= $props['ad']['body_ad']['year'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['run'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Пробег: <span><?= $props['ad']['body_ad']['run'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['engineCapacity'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Объем двигателя: <span><?= $props['ad']['body_ad']['engineCapacity'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['enginePower'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Мощность двигателя л.с.: <span><?= $props['ad']['body_ad']['enginePower'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['holders'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Владельцев по ПТС: <span><?= $props['ad']['body_ad']['holders'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['doors'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Количество дверей: <span><?= $props['ad']['body_ad']['doors'] ?></span></h4>
                </div>
                <?php
            }
            ?>

        </div>

        <h2 class="mt-4">Дополнительная информация</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="metaMainBlockAd">
                    <h4 class="metaMainAd">Текст объявления: <span><?= $props['ad']['description_ad'] ?></span></h4>
                </div>
            </div>

            <?php
            if (isset($props['ad']['body_ad']['auction'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Возможен торг: <span><?= $props['ad']['body_ad']['auction'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['swap'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Возможен обмен: <span><?= $props['ad']['body_ad']['swap'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['hbo'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Установлено газобаллонное оборудование: <span><?= $props['ad']['body_ad']['hbo'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['powerSteering'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Усилитель руля: <span><?= $props['ad']['body_ad']['powerSteering'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['powerWindows'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Электростеклоподъемники: <span><?= $props['ad']['body_ad']['powerWindows'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['audioSystem'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Аудиосистема: <span><?= $props['ad']['body_ad']['audioSystem'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['subwoofer'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Сабвуфер: <span><?= $props['ad']['body_ad']['subwoofer'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['tiresWheels'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Шины и диски ("): <span><?= $props['ad']['body_ad']['tiresWheels'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['winterTires'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Зимние шины в комплекте: <span><?= $props['ad']['body_ad']['winterTires'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['salon'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Салон: <span><?= $props['ad']['body_ad']['salon'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['leatherSteering'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Кожаный руль: <span><?= $props['ad']['body_ad']['leatherSteering'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['luke'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Люк: <span><?= $props['ad']['body_ad']['luke'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['climateControl'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Управление климатом: <span><?= $props['ad']['body_ad']['climateControl'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['steeringControl'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Управление на руле: <span><?= $props['ad']['body_ad']['steeringControl'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['athermalGlazing'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Атермальное остекление: <span><?= $props['ad']['body_ad']['athermalGlazing'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['memoryFrontSeats']) ||
                isset($props['ad']['body_ad']['memoryRrearSeats']) ||
                isset($props['ad']['body_ad']['memoryMirrors']) ||
                isset($props['ad']['body_ad']['memorySteeringColumn'])
            ) {
                ?>
                <hr>
                <h4>Память настроек:</h4>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['memoryFrontSeats'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Передних сидений: <span><?= $props['ad']['body_ad']['memoryFrontSeats'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['memoryRrearSeats'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Задних сидений: <span><?= $props['ad']['body_ad']['memoryRrearSeats'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['memoryMirrors'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Зеркал: <span><?= $props['ad']['body_ad']['memoryMirrors'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['memorySteeringColumn'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Рулевой колонки: <span><?= $props['ad']['body_ad']['memorySteeringColumn'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
                if (isset($props['ad']['body_ad']['electroFrontSeats']) ||
                    isset($props['ad']['body_ad']['electroRrearSeats']) ||
                    isset($props['ad']['body_ad']['electroMirrors']) ||
                    isset($props['ad']['body_ad']['electroSteeringColumn']) ||
                    isset($props['ad']['body_ad']['electroFoldingMirrors'])
                ) {
                    ?>
                    <hr>
                    <h4>Электропривод:</h4>
                    <?php
                }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['electroFrontSeats'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Передних сидений: <span><?= $props['ad']['body_ad']['electroFrontSeats'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['electroRrearSeats'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Задних сидений: <span><?= $props['ad']['body_ad']['electroRrearSeats'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['electroMirrors'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Зеркал: <span><?= $props['ad']['body_ad']['electroMirrors'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['electroSteeringColumn'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Рулевой колонки: <span><?= $props['ad']['body_ad']['electroSteeringColumn'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['electroFoldingMirrors'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Складывания зеркал: <span><?= $props['ad']['body_ad']['electroFoldingMirrors'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['heatingFrontSeats']) ||
                isset($props['ad']['body_ad']['heatingRrearSeats']) ||
                isset($props['ad']['body_ad']['heatingMirrors']) ||
                isset($props['ad']['body_ad']['heatingRearWindow']) ||
                isset($props['ad']['body_ad']['heatingHelm'])
            ) {
                ?>
                <hr>
                <h4>Обогрев:</h4>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['heatingFrontSeats'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Передних сидений: <span><?= $props['ad']['body_ad']['heatingFrontSeats'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['heatingRrearSeats'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Задних сидений: <span><?= $props['ad']['body_ad']['heatingRrearSeats'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['heatingMirrors'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Зеркал: <span><?= $props['ad']['body_ad']['heatingMirrors'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['heatingRearWindow'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Заднего стекла: <span><?= $props['ad']['body_ad']['heatingRearWindow'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['heatingHelm'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Руля: <span><?= $props['ad']['body_ad']['heatingHelm'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['headlights']) ||
                isset($props['ad']['body_ad']['headlightsFog']) ||
                isset($props['ad']['body_ad']['headlightsWashers']) ||
                isset($props['ad']['body_ad']['headlightsAdaptiveLighting'])
            ) {
                ?>
                <hr>
                <h4>Фары:</h4>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['headlights'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Фары: <span><?= $props['ad']['body_ad']['headlights'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['headlightsFog'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Противотуманные: <span><?= $props['ad']['body_ad']['headlightsFog'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['headlightsWashers'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Омыватели фар: <span><?= $props['ad']['body_ad']['headlightsWashers'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['headlightsAdaptiveLighting'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Адаптивное освещение: <span><?= $props['ad']['body_ad']['headlightsAdaptiveLighting'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['signaling']) ||
                isset($props['ad']['body_ad']['centralLocking']) ||
                isset($props['ad']['body_ad']['immobilizer']) ||
                isset($props['ad']['body_ad']['satellite'])
            ) {
                ?>
                <hr>
                <h4>Противоугонная система:</h4>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['signaling'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Сигнализация: <span><?= $props['ad']['body_ad']['signaling'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['centralLocking'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Центральный замок: <span><?= $props['ad']['body_ad']['centralLocking'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['immobilizer'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Иммобилайзер: <span><?= $props['ad']['body_ad']['immobilizer'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['satellite'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Спутник: <span><?= $props['ad']['body_ad']['satellite'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['frontal']) ||
                isset($props['ad']['body_ad']['knee']) ||
                isset($props['ad']['body_ad']['curtains']) ||
                isset($props['ad']['body_ad']['sideFront']) ||
                isset($props['ad']['body_ad']['sideRear'])
            ) {
                ?>
                <hr>
                <h4>Подушки безопасности:</h4>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['frontal'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Фронтальные: <span><?= $props['ad']['body_ad']['frontal'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['knee'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Коленные: <span><?= $props['ad']['body_ad']['knee'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['curtains'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Шторки: <span><?= $props['ad']['body_ad']['curtains'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['sideFront'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Боковые передние: <span><?= $props['ad']['body_ad']['sideFront'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['sideRear'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Боковые задние: <span><?= $props['ad']['body_ad']['sideRear'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['antiLockBrakes']) ||
                isset($props['ad']['body_ad']['antiSlip']) ||
                isset($props['ad']['body_ad']['distributionBrakingForce']) ||
                isset($props['ad']['body_ad']['emergencyBraking']) ||
                isset($props['ad']['body_ad']['blockDifferential']) ||
                isset($props['ad']['body_ad']['pedestrianDetection'])
            ) {
                ?>
                <hr>
                <h4>Активная безопасность:</h4>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['antiLockBrakes'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Антиблокировка тормозов: <span><?= $props['ad']['body_ad']['antiLockBrakes'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['antiSlip'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Антипробуксовка: <span><?= $props['ad']['body_ad']['antiSlip'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['distributionBrakingForce'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Распред. тормозных усилий: <span><?= $props['ad']['body_ad']['distributionBrakingForce'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['emergencyBraking'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Экстренное торможение: <span><?= $props['ad']['body_ad']['emergencyBraking'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['blockDifferential'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Блок. дифференциала: <span><?= $props['ad']['body_ad']['blockDifferential'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['pedestrianDetection'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Обнаружение пешеходов: <span><?= $props['ad']['body_ad']['pedestrianDetection'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['opticalDiscs']) ||
                isset($props['ad']['body_ad']['mp3']) ||
                isset($props['ad']['body_ad']['radio']) ||
                isset($props['ad']['body_ad']['tv']) ||
                isset($props['ad']['body_ad']['multimediaSteeringControls']) ||
                isset($props['ad']['body_ad']['usb']) ||
                isset($props['ad']['body_ad']['aux']) ||
                isset($props['ad']['body_ad']['bluetooth']) ||
                isset($props['ad']['body_ad']['gps'])
            ) {
                ?>
                <hr>
                <h4>Мультимедиа и навигация:</h4>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['opticalDiscs'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">CD/DVD/Blu-ray: <span><?= $props['ad']['body_ad']['opticalDiscs'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['mp3'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">MP3: <span><?= $props['ad']['body_ad']['mp3'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['radio'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Радио: <span><?= $props['ad']['body_ad']['radio'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['tv'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">TV: <span><?= $props['ad']['body_ad']['tv'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['multimediaSteeringControls'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Управление на руле: <span><?= $props['ad']['body_ad']['multimediaSteeringControls'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['usb'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">USB: <span><?= $props['ad']['body_ad']['usb'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['aux'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">AUX: <span><?= $props['ad']['body_ad']['aux'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['bluetooth'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Bluetooth: <span><?= $props['ad']['body_ad']['bluetooth'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['gps'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">GPS-навигатор: <span><?= $props['ad']['body_ad']['gps'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['automaticValet']) ||
                isset($props['ad']['body_ad']['rainSensor']) ||
                isset($props['ad']['body_ad']['lightSensor']) ||
                isset($props['ad']['body_ad']['rearParkingSensors']) ||
                isset($props['ad']['body_ad']['frontParkingSensors']) ||
                isset($props['ad']['body_ad']['blindSpotMonitor']) ||
                isset($props['ad']['body_ad']['rearViewCamera']) ||
                isset($props['ad']['body_ad']['cruiseControl']) ||
                isset($props['ad']['body_ad']['boardComputer'])
            ) {
                ?>
                <hr>
                <h4>Помощь при вождении:</h4>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['automaticValet'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Автоматический парковщик: <span><?= $props['ad']['body_ad']['automaticValet'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['rainSensor'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Датчик дождя: <span><?= $props['ad']['body_ad']['rainSensor'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['lightSensor'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Датчик света: <span><?= $props['ad']['body_ad']['lightSensor'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['rearParkingSensors'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Парктроник задний: <span><?= $props['ad']['body_ad']['rearParkingSensors'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['frontParkingSensors'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Парктроник передний: <span><?= $props['ad']['body_ad']['frontParkingSensors'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['blindSpotMonitor'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Система контроля слепых зон: <span><?= $props['ad']['body_ad']['blindSpotMonitor'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['rearViewCamera'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Камера заднего вида: <span><?= $props['ad']['body_ad']['rearViewCamera'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['cruiseControl'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Круиз-контроль: <span><?= $props['ad']['body_ad']['cruiseControl'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['boardComputer'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Бортовой компьютер: <span><?= $props['ad']['body_ad']['boardComputer'] ?></span></h4>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($props['ad']['body_ad']['serviceBook']) ||
                isset($props['ad']['body_ad']['servicedDealer']) ||
                isset($props['ad']['body_ad']['guarantee'])
            ) {
                ?>
                <hr>
                <h4>Данные о ТО:</h4>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['serviceBook'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Есть сервисная книжка: <span><?= $props['ad']['body_ad']['serviceBook'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['servicedDealer'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">Обслуживался у дилера: <span><?= $props['ad']['body_ad']['servicedDealer'] ?></span></h4>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($props['ad']['body_ad']['guarantee'])) {
                ?>
                <div class="col-sm-12 col-lg-6">
                    <h4 class="metaMainAd">На гарантии: <span><?= $props['ad']['body_ad']['guarantee'] ?></span></h4>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</main>

<?php require_once 'components/footer.php' ?>
