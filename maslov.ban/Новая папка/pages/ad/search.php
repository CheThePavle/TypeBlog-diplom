<?php require_once 'components/header.php' ?>

<main>
    <div class="container py-5 px-4">
        <form class="d-flex flex-column mx-auto" action="/ad/search" method="get">
            <div class="searchResultForm">
                <select name="mark" id="mark" class="form-control selectMark">
                    <option value="0">Все марки</option>
                    <?php
                    if (count($props['marks']) > 0) {
                        foreach ($props['marks'] as $mark) {
                            $id = $mark['id_object'];
                            $name = $mark['name_object'];
                            $select = isset($_GET['mark']) && $_GET['mark'] == $id ? 'selected' : '';

                            echo "
                                <option value='$id' $select>$name</option>
                            ";
                        }
                    }
                    ?>
                </select>
                <input class="form-control me-2" type="search" placeholder="Введите название объявления" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>">
                <button class="btnSearch" type="submit">Найти</button>
            </div>

            <div class="row">
                <div class="col-xl-4 text-center">
                    <h2 class="mt-4">Сортировка</h2>
                    <div class="form-floating mt-4">
                        <select class="form-select" id="order" name="order">
                            <option value="0" <?= isset($_GET['order']) && $_GET['order'] == '0' ? 'selected' : '' ?>>Новые</option>
                            <option value="1" <?= isset($_GET['order']) && $_GET['order'] == '1' ? 'selected' : '' ?>>Старые</option>
                        </select>
                        <label for="order">Сначала</label>
                    </div>
                    <h2 class="mt-4">Фильтр</h2>
                    <h5 class="mt-4 text-start m-1">Цена</h5>
                    <div class="d-flex justify-content-center">
                        <div class="form-floating m-1">
                            <input type="number" class="form-control" id="priceStart" name="priceStart" placeholder="priceStart" min="0"
                            value="<?= isset($_GET['priceStart']) ? $_GET['priceStart'] : '' ?>">
                            <label for="priceStart">От</label>
                        </div>
                        <div class="form-floating m-1">
                            <input type="number" class="form-control" id="priceEnd" name="priceEnd" placeholder="priceEnd" min="0"
                            value="<?= isset($_GET['priceEnd']) ? $_GET['priceEnd'] : '' ?>">
                            <label for="priceEnd">До</label>
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
                                $price= $ads['price'] ? "<p class='card-text'>Цена: ".$ads['price']." руб.</p>" : '';

                                echo "
                                    <div class='col-xl-6 col-lg-12 mb-3'>
                                        <div class='card'>
                                            <img src='$url' class='card-img-top' alt='adImg'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>$title</h5>
                                                $price
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
        </form>
    </div>
</main>

<?php require_once 'components/footer.php' ?>
