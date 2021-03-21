<?php
require_once __DIR__ . '/../template_blocks/header.php';
?>

<div class="change home">
    <div class="home__sidebar change__sidebar">
        <?php
            require __DIR__ . '/../template_blocks/sidebar.php';
        ?>
    </div>
    <div class="home__main change__main">
        <h1 class="change__main-title">
            Настройки
        </h1>
        <div class="change__main-rename">
            <form action="/settings" method="post" class="form">
                <div class="auth__form-item change__form-item">
                    <label for="new_login" >Новый никнейм:</label>
                    <input type="text" id="new_login" name="new_login">
                </div>
                <button  class="auth__form-btn">Изменить никнейм</button>
            </form>
        </div>
        <div class="change__main-repass">
            <form action="/settings" method="post" class="form">
                <div class="auth__form-item change__form-item">
                    <label for="old_password">Старый пароль:</label>
                    <input type="password" id="old_password" name="old_password">
                </div>
                <div class="auth__form-item change__form-item">
                    <label for="new_password">Новый пароль:</label>
                    <input type="password" id="new_password" name="new_password">
                </div>
                <button  class="auth__form-btn">Изменить пароль</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../template_blocks/footer.php';
