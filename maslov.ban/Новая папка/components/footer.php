<footer>
    <div class="container text-center py-4">
        <div class="row">
            <?php
                if (isset($_SESSION['id_user'])) {
                    echo "
                        <a href='/lk'>Личный кабинет</a>
                    ";
                } else {
                    echo "
                        <div>
                            <a href='/login'>Вход</a>
                            <a href='/register'>Регистрация</a>
                        </div>
                    ";
                }
            ?>
            <div>
                <a href="/ad/add">Разместить объявление</a>
            </div>
        </div>
    </div>
</footer>

<?= isset($props['footerScripts']) ? $props['footerScripts'] : '' ?>

</body>
</html>
