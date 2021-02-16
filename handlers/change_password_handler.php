<?php
session_start();

require_once __DIR__ . '/../helpers/redirect.php';
require_once __DIR__ . '/../helpers/check_login.php';
require_once __DIR__ . '/../models/User.php';

function change_password($old_password, $new_password)
{
    if (!$old_password || !$new_password) {
        $_SESSION['notification'] = 'Не все поля введены';
        redirect_to('/change_info');
    }

    if (!check_password_strength($new_password))
    {
        $_SESSION['notification'] = 'Ваш пароль не удовлетворяет требованиям безопасности';
        redirect_to('/change_info');
    }

    $user = User::getOne(array('id' => $_SESSION['user']['id']));
    if (!$user->checkPassword($old_password))
    {
        $_SESSION['notification'] = 'Старый пароль неверен';
        redirect_to('/change_info');
    }

    $user->changePassword($new_password);
    $_SESSION['notification'] = 'Пароль успешно заменен!';
    redirect_to('/');
}