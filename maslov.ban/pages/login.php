<?php require_once 'components/header.php' ?>

<main>
    <div class="container py-5 px-4">
        <div class="row py-5">
            <div class="loginRegisterForm mx-auto p-4">
                <h2 class="text-center mb-4">Авторизация</h2>
                <form action="/handlers/login.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="text-center mt-3">
                        <input type="submit" class="btn" value="Войти">
                    </div>
                </form>
                <div class="msg">
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                </div>
                <div class="error">
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }
                    ?>
                </div>
                <div class="text-center mt-3">
                    <span>Вы еще не зарегистрированы? <a href="/register">Регистрация</a></span>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'components/footer.php' ?>
