<?php require_once 'components/header.php' ?>

<main>
    <div class="container py-5 px-4">
        <form class="d-flex searchForm mx-auto" action="/ad/search" method="get">
            <input class="form-control me-2" type="search" placeholder="Введите название объявления" name="s">
            <button class="btnSearch" type="submit">Найти</button>
        </form>

        <div class="row mt-5 text-center marks marksBody">
            <?php
                if (count($props['marks']) > 0) {
                    foreach ($props['marks'] as $mark) {
                        $id = $mark['id_object'];
                        $name = $mark['name_object'];
                        $url = $mark['url_img'];

                        echo "
                            <div class='col-sm-6 col-xl-3 mb-3 d-flex align-items-center justify-content-center'>
                                <a href='/ad/search?mark=$id' class='markBtn'>
                                    <img src='$url' alt='mark'>
                                    <span>$name</span>
                                </a>
                            </div>
                        ";
                    }
                }
            ?>
        </div>

        <div class="mt-5 text-center marks">
            <h2 class="mb-5">Все объявления</h2>
            <div class="row">
                <?php
                    if (count($props['ads']) > 0) {
                        foreach ($props['ads'] as $ad) {
                            $id = $ad['id_ad'];
                            $name = $ad['title_ad'];
                            $url = $ad['url_img'];
                            $price= $ad['price'] ? "<p class='card-text'>Цена: ".$ad['price']." руб.</p>" : '';

                            echo "
                                <div class='col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-3'>
                                    <div class='card h-100'>
                                        <img src='$url' class='card-img-top imgAd' alt='adImg'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>$name</h5>
                                            $price
                                        </div>
                                        <div class='card-footer'><a href='ad/$id' class='btn'>Посмотреть</a></div>
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
</main>

<?php require_once 'components/footer.php' ?>
