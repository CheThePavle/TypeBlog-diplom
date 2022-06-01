<?php require_once 'components/header.php' ?>

<main>
    <div class="container py-5 px-4">
        <h2 class="text-center mb-4">Создание объявления</h2>
        <div>
            <ul class="progressbar">
                <li class="active step">Шаг 1 «Основное»</li>
                <li class="step">Шаг 2 «Цена и пр.»</li>
                <li class="step">Шаг 3 «Красивые фотографии автомобиля»</li>
            </ul>
        </div>
        <br><br><br>
        <form id="adAddForm" class="mx-auto d-block" action="/handlers/ad/add.php" method="post" enctype="multipart/form-data">
            <div class="tab">
                <h3>Шаг 1 «Основное»</h3>
                <p><input class="required" placeholder="обязательное поле" oninput="this.className = ''"></p>
                <div class="row">
                    <div class="col-sm-12 col-xl-6">
                        <div class="form-floating mt-4">
                            <select class="form-select" name="mark" id="mark">
                                <?php
                                    if (count($props['marks']) > 0) {
                                        foreach ($props['marks'] as $mark) {
                                            $id = $mark['id_object'];
                                            $name = $mark['name_object'];
                                            echo "<option value='$id'>$name</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <label for="mark">Марка</label>
                        </div>
                        <div class="form-floating mt-1">
                            <select class="form-select" name="model" id="model">
                                <?php
                                    if (count($props['models']) > 0) {
                                        foreach ($props['models'] as $model) {
                                            $id = $model['id_object'];
                                            $parentId = $model['parent_id_object'];
                                            $name = $model['name_object'];
                                            echo "<option id='model$id' class='modelOption' data-parent-id='$parentId' value='$id'>$name</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <label for="model">Модель</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="form-floating mt-4">
                            <select class="form-select" id="test2" name="test2">
                                <option value="0" selected>Новые</option>
                                <option value="1">Старые</option>
                            </select>
                            <label for="test2">Сначала</label>
                        </div>
                        <div class="form-floating m-1">
                            <input type="email" class="form-control" id="test4" placeholder="1">
                            <label for="test4">До</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab">
                <h3>Шаг 2 «Цена и пр.»</h3>
                <p>Какие-то поля</p>
            </div>

            <div class="tab">
                <h3>Шаг 3 «Красивые фотографии автомобиля»</h3>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Default file input example</label>
                    <input class="form-control" type="file" id="formFile">
                </div>
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                    <input class="form-control" type="file" id="formFileMultiple" multiple>
                </div>
            </div>

            <div style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" class="btn" id="prevBtn" onclick="nextPrev(-1)">Назад</button>
                    <button type="button" class="btn" id="nextBtn" onclick="nextPrev(1)">Вперед</button>
                </div>
            </div>
        </form>
    </div>
</main>
<!---->
<!--<div class="content_caita">-->
<!--    <form action="/handlers/ad/add.php" method="post" enctype="multipart/form-data">-->
<!--        <div class="tabs">-->
<!--            <div class="tab">-->
<!--                <input type="radio" id="tab1" name="tab-group" checked>-->
<!--                <label for="tab1" class="tab-title">Основное</label>-->
<!--                <section class="tab-content">-->
<!--                    <h2>Шаг 1 «Основное»</h2>-->
<!--                    <h3>VIN и Свидетельство о регистрации ТС:</h3>-->
<!--                    <input type="text" name="vin" placeholder="Вин-код">-->
<!--                    <input type="text" name="certificate" placeholder="Свидетельство о регистрации ТС">-->
<!--                    <input type="text" name="address" placeholder="Ваш адрес">-->
<!--                    <input type="text" name="year" placeholder="Год">-->
<!--                    <input type="number" name="run" placeholder="Пробег" min="0">-->
<!--                    <div>-->
<!--                        <label for="carcase">Кузов</label>-->
<!--                        <br>-->
<!--                        <select name="carcase" id="carcase">-->
<!--                            <option value='седан'>седан</option>-->
<!--                            <option value='хэтчбек'>хэтчбек</option>-->
<!--                            <option value='универсал'>универсал</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <label for="color">Цвет</label>-->
<!--                        <br>-->
<!--                        <select name="color" id="color">-->
<!--                            <option value='бежевый'>бежевый</option>-->
<!--                            <option value='белый'>белый</option>-->
<!--                            <option value='голубой'>голубой</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <input type="number" name="engineCapacity" placeholder="Объем двигателя" min="0">-->
<!--                    <div>-->
<!--                        <label for="transmission">Коробка передач</label>-->
<!--                        <br>-->
<!--                        <select name="transmission" id="transmission">-->
<!--                            <option value='автомат'>автомат</option>-->
<!--                            <option value='механика'>механика</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <label for="engineType">Тип двигателя</label>-->
<!--                        <br>-->
<!--                        <select name="engineType" id="engineType">-->
<!--                            <option value='бензиновый'>бензиновый</option>-->
<!--                            <option value='инжектор'>инжектор</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <label for="drive">Привод</label>-->
<!--                        <br>-->
<!--                        <select name="drive" id="drive">-->
<!--                            <option value='задний'>задний</option>-->
<!--                            <option value='передний'>передний</option>-->
<!--                            <option value='полный'>полный</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <label for="rudder">Руль</label>-->
<!--                        <br>-->
<!--                        <select name="rudder" id="rudder">-->
<!--                            <option value='левый'>левый</option>-->
<!--                            <option value='правый'>правый</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <label for="state">Состояние</label>-->
<!--                        <br>-->
<!--                        <select name="state" id="state">-->
<!--                            <option value='новый'>новый</option>-->
<!--                            <option value='отличное'>отличное</option>-->
<!--                            <option value='хорошее'>хорошее</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <input type="number" name="enginePower" placeholder="Мощность двигателя л.с." min="0">-->
<!--                    <input type="number" name="holders" placeholder="Владельцев по ПТС" min="0">-->
<!--                    <input type="number" name="doors" placeholder="Количество дверей" min="0">-->
<!--                </section>-->
<!--            </div>-->
<!--            <div class="tab">-->
<!--                <input type="radio" id="tab2" name="tab-group">-->
<!--                <label for="tab2" class="tab-title">Цена и пр.</label>-->
<!--                <section class="tab-content">-->
<!--                    <h2>Шаг 2 «Цена и пр.»</h2>-->
<!--                    <input type="text" name="title_ad" placeholder="Заголовок объявления">-->
<!--                    <div>-->
<!--                        <textarea name="description_ad" id="description_ad" cols="30" rows="10" placeholder="Текст объявления"></textarea>-->
<!--                    </div>-->
<!--                    <input type="number" name="price" placeholder="Цена руб." min="0">-->
<!--                    <input type="checkbox" name="auction" id="auction">-->
<!--                    <label for="auction">возможен торг</label>-->
<!--                    <input type="checkbox" name="swap" id="swap">-->
<!--                    <label for="swap">возможен обмен</label>-->
<!---->
<!--                    <h3>Укажите дополнительные параметры и опции</h3>-->
<!--                </section>-->
<!--            </div>-->
<!--            <div class="tab">-->
<!--                <input type="radio" id="tab3" name="tab-group">-->
<!--                <label for="tab3" class="tab-title">Фотографии</label>-->
<!--                <section class="tab-content">-->
<!--                    <h2>Шаг 3 «Красивые фотографии автомобиля»</h2>-->
<!--                    <h3>Главное изображение для вашего объявления</h3>-->
<!--                    <input type="file" name="img" accept=".jpg, .jpeg, .png, .gif">-->
<!--                    <h3>Дополнительные изображения для вашего объявления</h3>-->
<!--                    <input type="file" name="imgs[]" multiple accept=".jpg, .jpeg, .png, .gif">-->
<!--                    <br><br><br>-->
<!--                    <input type="submit" value="Отправить на проверку">-->
<!--                </section>-->
<!--            </div>-->
<!--        </div>-->
<!--    </form>-->
<!--</div>-->

<?php require_once 'components/footer.php' ?>
