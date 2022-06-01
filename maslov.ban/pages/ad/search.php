<?php require_once 'components/header.php' ?>

<main>
    <div class="container py-5 px-4">
        <form class="d-flex searchResultForm mx-auto" action="/ad/search" method="get">
            <select name="mark" id="mark" class="form-control selectMark">
                <option value="false">Все марки</option>
                <?php
                    if (count($props['marks']) > 0) {
                        foreach ($props['marks'] as $mark) {
                            $id = $mark['id_object'];
                            $name = $mark['name_object'];

                            echo "
                                <option value='$id'>$name</option>
                            ";
                        }
                    }
                ?>
            </select>
            <input class="form-control me-2" type="search" placeholder="Введите название объявления" aria-label="Search" value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>">
            <button class="btnSearch" type="submit">Найти</button>
        </form>

        <div class="row">
            <div class="col-xl-4 text-center">
                <h2 class="mt-4">Сортировка</h2>
                <div class="form-floating mt-4">
                    <select class="form-select" id="order" name="order">
                        <option value="0" selected>Новые</option>
                        <option value="1">Старые</option>
                    </select>
                    <label for="order">Сначала</label>
                </div>
                <h2 class="mt-4">Фильтр</h2>
                <h5 class="mt-4 text-start m-1">Цена</h5>
                <div class="d-flex justify-content-center">
                    <div class="form-floating m-1">
                        <input type="email" class="form-control" id="priceStart" placeholder="0">
                        <label for="priceStart">От</label>
                    </div>
                    <div class="form-floating m-1">
                        <input type="email" class="form-control" id="priceEnd" placeholder="1">
                        <label for="priceEnd">До</label>
                    </div>
                </div>
                <h5 class="mt-4 text-start m-1">Пробег, км</h5>
                <div class="d-flex justify-content-center">
                    <div class="form-floating m-1">
                        <input type="email" class="form-control" id="runStart" placeholder="0">
                        <label for="runStart">От</label>
                    </div>
                    <div class="form-floating m-1">
                        <input type="email" class="form-control" id="runEnd" placeholder="1000">
                        <label for="runEnd">До</label>
                    </div>
                </div>
                <h5 class="mt-4 text-start m-1">Год выпуска</h5>
                <div class="d-flex justify-content-center">
                    <div class="form-floating m-1">
                        <input type="email" class="form-control" id="yearStart" placeholder="1900">
                        <label for="yearStart">От</label>
                    </div>
                    <div class="form-floating m-1">
                        <input type="email" class="form-control" id="yearEnd" placeholder="2022">
                        <label for="yearEnd">До</label>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 mt-sm-3 mt-xl-0">
                <h2 class="mb-sm-3 mb-xl-4 mt-4">Найденные объявления</h2>
                <div class="row text-center">
                    <?php
                        if (count($props['ads']) > 0) {
                            foreach ($props['ads'] as $ads) {
                                $id = $ads['id_ad'];
                                $title = $ads['title_ad'];
                                $url = $ads['url_img'];

                                echo "
                                    <div class='col-xl-6 col-lg-12 mb-3'>
                                        <div class='card'>
                                            <img src='$url' class='card-img-top' alt='adImg'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>$title</h5>
                                                <p class='card-text'>Цена: the best .руб</p>
                                                <a href='/ad/$id' class='btn'>Посмотреть</a>
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
