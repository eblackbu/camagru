<?php
session_start();

require_once __DIR__ . '/../helpers/redirect.php';
require_once __DIR__ . '/../models/User.php';

function login($_login, $_password)
{
    if (!$_login || !$_password) {
        $_SESSION['notification'] = 'Не все поля введены';
        redirect_to('/');
    }

    try {
        $user = User::getOne(array('login' => $_login));
    } catch (ORMException $e) {
        $_SESSION['notification'] = 'Пользователя с данным логином не существует. Вы можете зарегистрироваться';
        redirect_to('/');
    }

    if (!$user->checkPassword($_password))
        $_SESSION['notification'] .= 'Введенный пароль неверен';
    else
    {
        $_SESSION['user']['id'] = $user->id;
        $_SESSION['user']['login'] = $user->login;
        $_SESSION['user']['is_admin'] = $user->is_admin;
    }
    redirect_to('/');
}