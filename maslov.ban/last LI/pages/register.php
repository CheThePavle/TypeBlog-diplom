<?php require_once 'components/header.php' ?>

<main>
    <div class="container py-5 px-4">
        <div class="row py-5">
            <div class="loginRegisterForm mx-auto p-4">
                <h2 class="text-center mb-4">Регистрация</h2>
                <form action="/handlers/register.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Ivanov" required maxlength="100"
                        value="<?php
                        if (isset($_SESSION['reg_last_name'])) {
                            echo $_SESSION['reg_last_name'];
                            unset($_SESSION['reg_last_name']);
                        }
                        ?>">
                        <label for="last_name">Фамилия</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Ivan" required maxlength="100"
                        value="<?php
                        if (isset($_SESSION['reg_first_name'])) {
                            echo $_SESSION['reg_first_name'];
                            unset($_SESSION['reg_first_name']);
                        }
                        ?>">
                        <label for="first_name">Имя</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="tel" class="form-control tel" name="phone" id="phone" placeholder="88005553535" required maxlength="100"
                        value="<?php
                        if (isset($_SESSION['reg_phone'])) {
                            echo $_SESSION['reg_phone'];
                            unset($_SESSION['reg_phone']);
                        }
                        ?>">
                        <label for="phone">Телефон</label>
                        <div class="error text-center">
                            <?php
                                if (isset($_SESSION['phone'])) {
                                    echo $_SESSION['phone'];
                                    unset($_SESSION['phone']);
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="email@mail.ru" required maxlength="150"
                        value="<?php
                        if (isset($_SESSION['reg_email'])) {
                            echo $_SESSION['reg_email'];
                            unset($_SESSION['reg_email']);
                        }
                        ?>">
                        <label for="email">Email</label>
                        <div class="error text-center">
                            <?php
                                if (isset($_SESSION['email'])) {
                                    echo $_SESSION['email'];
                                    unset($_SESSION['email']);
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="qwerty" required maxlength="100">
                        <label for="password">Пароль</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password2" id="password2" placeholder="qwerty" required maxlength="100">
                        <label for="password2">Повторите пароль</label>
                    </div>
                    <div class="text-center mt-3">
                        <input type="submit" class="btn" value="Зарегистрироваться">
                        <div class="error text-center">
                            <?php
                                if (isset($_SESSION['error'])) {
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                }
                            ?>
                        </div>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <span>Вы уже зарегистрированы? <a href="/login">Авторизация</a></span>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'components/footer.php' ?>
