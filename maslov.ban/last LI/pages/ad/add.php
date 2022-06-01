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
                <div class="row mt-2">
                    <span class="titleSectionAd">VIN и Свидетельство о регистрации ТС:</span>
                    <div class="col-sm-12 col-xl-6">
                        <div class="form-floating m-1">
                            <input type="text" class="form-control" name="vin" id="vin" placeholder="vin">
                            <label for="vin">Вин-код</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="form-floating m-1">
                            <input type="text" class="form-control" name="certificate" id="certificate" placeholder="certificate">
                            <label for="certificate">Свидетельство о регистрации ТС</label>
                        </div>
                    </div>

                    <span class="titleSectionAd">Ваш адрес:</span>
                    <div class="col-12">
                        <div class="form-floating m-1">
                            <input type="text" class="form-control" name="address" id="address" placeholder="address">
                            <label for="address">Адрес</label>
                        </div>
                    </div>

                    <span class="titleSectionAd">Информация об автомобиле:</span>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating mt-1">
                            <select class="form-select required" name="mark" id="mark" oninput="this.classList.remove('invalid')">
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
                            <label for="mark">Марка <span class="requiredStar">*</span></label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating mt-1">
                            <select class="form-select required" name="idModel" id="model" oninput="this.classList.remove('invalid')">
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
                            <label for="model">Модель <span class="requiredStar">*</span></label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="carcase" name="carcase">
                                <option value='седан'>седан</option>
                                <option value='хэтчбек'>хэтчбек</option>
                                <option value='универсал'>универсал</option>
                            </select>
                            <label for="carcase">Кузов</label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="color" name="color">
                                <option value='бежевый'>бежевый</option>
                                <option value='белый'>белый</option>
                                <option value='голубой'>голубой</option>
                            </select>
                            <label for="color">Цвет</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="transmission" name="transmission">
                                <option value='автомат'>автомат</option>
                                <option value='механика'>механика</option>
                            </select>
                            <label for="transmission">Коробка передач</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="engineType" name="engineType">
                                <option value='бензиновый'>бензиновый</option>
                                <option value='инжектор'>инжектор</option>
                            </select>
                            <label for="engineType">Тип двигателя</label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="drive" name="drive">
                                <option value='задний'>задний</option>
                                <option value='передний'>передний</option>
                                <option value='полный'>полный</option>
                            </select>
                            <label for="drive">Привод</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="rudder" name="rudder">
                                <option value='левый'>левый</option>
                                <option value='правый'>правый</option>
                            </select>
                            <label for="rudder">Руль</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="state" name="state">
                                <option value='новое'>новое</option>
                                <option value='отличное'>отличное</option>
                                <option value='хорошее'>хорошее</option>
                            </select>
                            <label for="state">Состояние</label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating m-1">
                            <input type="text" class="form-control" name="year" id="year" placeholder="year">
                            <label for="year">Год</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating m-1">
                            <input type="number" class="form-control" name="run" id="run" placeholder="run" min="0">
                            <label for="run">Пробег</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating m-1">
                            <input type="number" class="form-control" name="engineCapacity" id="engineCapacity" placeholder="engineCapacity" min="0">
                            <label for="engineCapacity">Объем двигателя</label>
                        </div>
                    </div>


                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating m-1">
                            <input type="number" class="form-control" name="enginePower" id="enginePower" placeholder="enginePower" min="0">
                            <label for="enginePower">Мощность двигателя л.с.</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating m-1">
                            <input type="number" class="form-control" name="holders" id="holders" placeholder="holders" min="0">
                            <label for="holders">Владельцев по ПТС</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-floating m-1">
                            <input type="number" class="form-control" name="doors" id="doors" placeholder="doors" min="0">
                            <label for="doors">Количество дверей</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab">
                <h3>Шаг 2 «Цена и пр.»</h3>
                <div class="row mt-2">
                    <span class="titleSectionAd">Заголовок объявления:</span>
                    <div class="col-12">
                        <div class="form-floating m-1">
                            <input type="text" class="form-control required" name="title_ad" id="title_ad" placeholder="title_ad" oninput="this.classList.remove('invalid')">
                            <label for="title_ad">Заголовок <span class="requiredStar">*</span></label>
                        </div>
                    </div>

                    <span class="titleSectionAd">Текст объявления:</span>
                    <div class="col-12">
                        <div class="form-floating m-1">
                            <textarea class="form-control required" placeholder="description_ad" name="description_ad" id="description_ad" oninput="this.classList.remove('invalid')"></textarea>
                            <label for="description_ad">Описание <span class="requiredStar">*</span></label>
                        </div>
                    </div>

                    <span class="titleSectionAd">Цена:</span>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-floating m-1">
                            <input type="number" class="form-control required" name="price" id="price" placeholder="price" min="0" oninput="this.classList.remove('invalid')">
                            <label for="price">Цена руб.  <span class="requiredStar">*</span></label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 d-flex flex-column justify-content-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="auction" id="auction">
                            <label class="form-check-label" for="auction">
                                возможен торг
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="swap" id="swap">
                            <label class="form-check-label" for="swap">
                                возможен обмен
                            </label>
                        </div>
                    </div>

                    <span class="titleSectionAd">ГБО:</span>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hbo" id="hbo">
                            <label class="form-check-label" for="hbo">
                                установлено газобаллонное оборудование
                            </label>
                        </div>
                    </div>

                    <span class="titleSectionAd">Укажите дополнительные параметры и опции:</span>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="powerSteering" name="powerSteering">
                                <option value='гидро-'>гидро-</option>
                                <option value='электро-'>электро-</option>
                                <option value='электрогидро-'>электрогидро-</option>
                            </select>
                            <label for="powerSteering">Усилитель руля</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="powerWindows" name="powerWindows">
                                <option value='только передние'>только передние</option>
                                <option value='передние и задние'>передние и задние</option>
                            </select>
                            <label for="powerWindows">Электростеклоподъемники</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="audioSystem" name="audioSystem">
                                <option value='1 колонка'>1 колонка</option>
                                <option value='2 колонки'>2 колонки</option>
                                <option value='3 колонки'>3 колонки</option>
                                <option value='4 колонки'>4 колонки</option>
                                <option value='4 и более колонок'>4 и более колонок</option>
                            </select>
                            <label for="audioSystem">Аудиосистема</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subwoofer" id="subwoofer">
                            <label class="form-check-label" for="subwoofer">
                                Сабвуфер
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-floating m-1">
                            <input type="number" class="form-control" name="tiresWheels" id="tiresWheels" placeholder="tiresWheels" min="0">
                            <label for="tiresWheels">Шины и диски (")</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="winterTires" id="winterTires">
                            <label class="form-check-label" for="winterTires">
                                Зимние шины в комплекте
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="salon" name="salon">
                                <option value='кожа'>кожа</option>
                                <option value='ткань'>ткань</option>
                                <option value='велюр'>велюр</option>
                                <option value='комбинированный'>комбинированный</option>
                            </select>
                            <label for="salon">Салон</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="leatherSteering" id="leatherSteering">
                            <label class="form-check-label" for="leatherSteering">
                                Кожаный руль
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="luke" id="luke">
                            <label class="form-check-label" for="luke">
                                Люк
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-floating mt-1">
                            <select class="form-select" id="climateControl" name="climateControl">
                                <option value='кондиционер'>кондиционер</option>
                                <option value='климат-контроль однозонный'>климат-контроль однозонный</option>
                                <option value='климат-контроль многозонный'>климат-контроль многозонный</option>
                            </select>
                            <label for="climateControl">Управление климатом</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="steeringControl" id="steeringControl">
                            <label class="form-check-label" for="steeringControl">
                                Управление на руле
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="athermalGlazing" id="athermalGlazing">
                            <label class="form-check-label" for="athermalGlazing">
                                Атермальное остекление
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <span class="titleSectionAd">Память настроек:</span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="memoryFrontSeats" id="memoryFrontSeats">
                            <label class="form-check-label" for="memoryFrontSeats">
                                Передних сидений
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="memoryRrearSeats" id="memoryRrearSeats">
                            <label class="form-check-label" for="memoryRrearSeats">
                                Задних сидений
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="memoryMirrors" id="memoryMirrors">
                            <label class="form-check-label" for="memoryMirrors">
                                Зеркал
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="memorySteeringColumn" id="memorySteeringColumn">
                            <label class="form-check-label" for="memorySteeringColumn">
                                Рулевой колонки
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <span class="titleSectionAd">Электропривод:</span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="electroFrontSeats" id="electroFrontSeats">
                            <label class="form-check-label" for="electroFrontSeats">
                                Передних сидений
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="electroRrearSeats" id="electroRrearSeats">
                            <label class="form-check-label" for="electroRrearSeats">
                                Задних сидений
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="electroMirrors" id="electroMirrors">
                            <label class="form-check-label" for="electroMirrors">
                                Зеркал
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="electroSteeringColumn" id="electroSteeringColumn">
                            <label class="form-check-label" for="electroSteeringColumn">
                                Рулевой колонки
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="electroFoldingMirrors" id="electroFoldingMirrors">
                            <label class="form-check-label" for="electroFoldingMirrors">
                                Складывания зеркал
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <span class="titleSectionAd">Обогрев:</span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="heatingFrontSeats" id="heatingFrontSeats">
                            <label class="form-check-label" for="heatingFrontSeats">
                                Передних сидений
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="heatingRrearSeats" id="heatingRrearSeats">
                            <label class="form-check-label" for="heatingRrearSeats">
                                Задних сидений
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="heatingMirrors" id="heatingMirrors">
                            <label class="form-check-label" for="heatingMirrors">
                                Зеркал
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="heatingRearWindow" id="heatingRearWindow">
                            <label class="form-check-label" for="heatingRearWindow">
                                Заднего стекла
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="heatingHelm" id="heatingHelm">
                            <label class="form-check-label" for="heatingHelm">
                                Руля
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <span class="titleSectionAd">Фары:</span>
                        <div class="form-floating mt-1">
                            <select class="form-select" id="headlights" name="headlights">
                                <option value='галогенные'>галогенные</option>
                                <option value='ксеноновые'>ксеноновые</option>
                                <option value='светодиодные'>светодиодные</option>
                            </select>
                            <label for="headlights">Фары</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="headlightsFog" id="headlightsFog">
                            <label class="form-check-label" for="headlightsFog">
                                Противотуманные
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="headlightsWashers" id="headlightsWashers">
                            <label class="form-check-label" for="headlightsWashers">
                                Омыватели фар
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="headlightsAdaptiveLighting" id="headlightsAdaptiveLighting">
                            <label class="form-check-label" for="headlightsAdaptiveLighting">
                                Адаптивное освещение
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <span class="titleSectionAd">Противоугонная система:</span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="signaling" id="signaling">
                            <label class="form-check-label" for="signaling">
                                Сигнализация
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="centralLocking" id="centralLocking">
                            <label class="form-check-label" for="centralLocking">
                                Центральный замок
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="immobilizer" id="immobilizer">
                            <label class="form-check-label" for="immobilizer">
                                Иммобилайзер
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="satellite" id="satellite">
                            <label class="form-check-label" for="satellite">
                                Спутник
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <span class="titleSectionAd">Подушки безопасности:</span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="frontal" id="frontal">
                            <label class="form-check-label" for="frontal">
                                Фронтальные
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="knee" id="knee">
                            <label class="form-check-label" for="knee">
                                Коленные
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="curtains" id="curtains">
                            <label class="form-check-label" for="curtains">
                                Шторки
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sideFront" id="sideFront">
                            <label class="form-check-label" for="sideFront">
                                Боковые передние
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sideRear" id="sideRear">
                            <label class="form-check-label" for="sideRear">
                                Боковые задние
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <span class="titleSectionAd">Активная безопасность:</span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="antiLockBrakes" id="antiLockBrakes">
                            <label class="form-check-label" for="antiLockBrakes">
                                Антиблокировка тормозов
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="antiSlip" id="antiSlip">
                            <label class="form-check-label" for="antiSlip">
                                Антипробуксовка
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="distributionBrakingForce" id="distributionBrakingForce">
                            <label class="form-check-label" for="distributionBrakingForce">
                                Распред. тормозных усилий
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="emergencyBraking" id="emergencyBraking">
                            <label class="form-check-label" for="emergencyBraking">
                                Экстренное торможение
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="blockDifferential" id="blockDifferential">
                            <label class="form-check-label" for="blockDifferential">
                                Блок. дифференциала
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pedestrianDetection" id="pedestrianDetection">
                            <label class="form-check-label" for="pedestrianDetection">
                                Обнаружение пешеходов
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <span class="titleSectionAd">Мультимедиа и навигация:</span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="opticalDiscs" id="opticalDiscs">
                            <label class="form-check-label" for="opticalDiscs">
                                CD/DVD/Blu-ray
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="mp3" id="mp3">
                            <label class="form-check-label" for="mp3">
                                MP3
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="radio" id="radio">
                            <label class="form-check-label" for="radio">
                                Радио
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tv" id="tv">
                            <label class="form-check-label" for="tv">
                                TV
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="multimediaSteeringControls" id="multimediaSteeringControls">
                            <label class="form-check-label" for="multimediaSteeringControls">
                                Управление на руле
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="usb" id="usb">
                            <label class="form-check-label" for="usb">
                                USB
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="aux" id="aux">
                            <label class="form-check-label" for="aux">
                                AUX
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="bluetooth" id="bluetooth">
                            <label class="form-check-label" for="bluetooth">
                                Bluetooth
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="gps" id="gps">
                            <label class="form-check-label" for="gps">
                                GPS-навигатор
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <span class="titleSectionAd">Помощь при вождении:</span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="automaticValet" id="automaticValet">
                            <label class="form-check-label" for="automaticValet">
                                Автоматический парковщик
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rainSensor" id="rainSensor">
                            <label class="form-check-label" for="rainSensor">
                                Датчик дождя
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="lightSensor" id="lightSensor">
                            <label class="form-check-label" for="lightSensor">
                                Датчик света
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rearParkingSensors" id="rearParkingSensors">
                            <label class="form-check-label" for="rearParkingSensors">
                                Парктроник задний
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="frontParkingSensors" id="frontParkingSensors">
                            <label class="form-check-label" for="frontParkingSensors">
                                Парктроник передний
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="blindSpotMonitor" id="blindSpotMonitor">
                            <label class="form-check-label" for="blindSpotMonitor">
                                Система контроля слепых зон
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rearViewCamera" id="rearViewCamera">
                            <label class="form-check-label" for="rearViewCamera">
                                Камера заднего вида
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="cruiseControl" id="cruiseControl">
                            <label class="form-check-label" for="cruiseControl">
                                Круиз-контроль
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="boardComputer" id="boardComputer">
                            <label class="form-check-label" for="boardComputer">
                                Бортовой компьютер
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <span class="titleSectionAd">Данные о ТО:</span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="serviceBook" id="serviceBook">
                            <label class="form-check-label" for="serviceBook">
                                Есть сервисная книжка
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="servicedDealer" id="servicedDealer">
                            <label class="form-check-label" for="servicedDealer">
                                Обслуживался у дилера
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="guarantee" id="guarantee">
                            <label class="form-check-label" for="guarantee">
                                На гарантии
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab">
                <h3>Шаг 3 «Красивые фотографии автомобиля»</h3>
                <span class="titleSectionAd"><b>Добавьте фотографии, чтобы ваше объявление смотрели чаще!</b></span>
                <p>Каждая фотография не должна превышать 10 МБайт и быть в формате jpeg, jpg, png или gif </p>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="img" class="form-label">Главное изображение для вашего объявления <span class="requiredStar">*</span></label>
                            <input class="form-control required" type="file" id="img" name="img" accept=".jpg, .jpeg, .png, .gif" oninput="this.classList.remove('invalid')">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="imgs" class="form-label">Дополнительные изображения для вашего объявления</label>
                            <input class="form-control" type="file" id="imgs" name="imgs[]" accept=".jpg, .jpeg, .png, .gif" multiple>
                        </div>
                    </div>
                </div>
            </div>

            <div style="overflow:auto;" class="mt-4">
                <div style="float:right;">
                    <button type="button" class="btn" id="prevBtn" onclick="nextPrev(-1)">Назад</button>
                    <button type="button" class="btn" id="nextBtn" onclick="nextPrev(1)">Вперед</button>
                </div>
            </div>
        </form>
    </div>
</main>

<?php require_once 'components/footer.php' ?>
