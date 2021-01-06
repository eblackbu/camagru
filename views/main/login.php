<?php
// Страница для входа в аккаунт
// echo 'login page';
require_once __DIR__ . '/../blocks/header.php';
?>

<div class="auth">
    <h1 class="auth__title">Login</h1>
    <form action="" class="form">
        <div class="auth__form-item">
            <label for="login">Email:</label>
            <input type="text" id="login">
        </div>
        <div class="auth__form-item">
            <label for="password">Password:</label>
            <input type="password" id="password">
        </div>
        <button  class="auth__form-btn">login</button>
    </form>
    <div class="auth__options">
        <div class="auth__options-item">
            <a href="/register">Registration</a>
        </div>
        <div class="auth__options-item">
            <a href="">Forgot password?</a>
        </div>
    </div>

</div>

<?php 
require_once __DIR__ . '/../blocks/footer.php';