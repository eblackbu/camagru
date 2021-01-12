<?php
require_once __DIR__ . '/../blocks/header.php';
?>

<div class="change home">
    <div class="home__sidebar change__sidebar">
        <?php
            require __DIR__ . '/../blocks/sidebar.php';
        ?>
    </div>
    <div class="home__main change__main">
        <h1 class="change__main-title">
            Настройки
        </h1>
        <div class="change__main-rename">
            <form action="" method="" class="change__form">
                <div class="auth__form-item change__form-item">
                    <label for="nickname">Новый никнейм:</label>
                    <input type="text" id="nickname" name="nickname">
                </div>
                <button  class="auth__form-btn">Изменить никнейм</button>
            </form>
        </div>
        <div class="change__main-repass">
            <form action="" method="" class="change__form">
                <div class="auth__form-item change__form-item">
                    <label for="password">Старый пароль:</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="auth__form-item change__form-item">
                    <label for="password_new">Новый пароль:</label>
                    <input type="password" id="password_new" name="password_new">
                </div>
                <button  class="auth__form-btn">Изменить пароль</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../blocks/footer.php';
