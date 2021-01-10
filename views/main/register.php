<?php
// Страница для регистрации аккаунта
// echo 'register page';
require_once __DIR__ . '/../blocks/header.php';
?>

<div class="auth">
    <h1 class="auth__title">Sign in</h1>
    <form action="/?action=register" method="post" class="form">
        <div class="auth__form-item">
            <label for="login">Login:</label>
            <input type="text" id="login" name="login">
        </div>
        <div class="auth__form-item">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="auth__form-item">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email">
        </div>
        <button  class="auth__form-btn">sign in</button>
    </form>
    <div class="auth__options">
        <div class="auth__options-item">
            <a href="/login">Already registered?</a>
        </div>
    </div>

</div>

<?php 
require_once __DIR__ . '/../blocks/footer.php';