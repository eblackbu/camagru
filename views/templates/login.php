<?php
// Страница для входа в аккаунт
// echo 'login page';
require_once __DIR__ . '/../template_blocks/header.php';
?>

<div class="auth">
    <h1 class="auth__title">Login</h1>
    <form action="/" method="post" class="auth__form">
        <div class="auth__form-item">
            <label for="login">Login:</label>
            <input type="text" id="login" name="login">
        </div>
        <div class="auth__form-item">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <button  class="auth__form-btn">login</button>
    </form>
    <div class="auth__options">
        <div class="auth__options-item">
            <a href="/register">Registration</a>
        </div>
        <div class="auth__options-item">
            <a href='/change_password'>Forgot password?</a>
        </div>
    </div>

</div>

<?php

require_once __DIR__ . '/../template_blocks/footer.php';