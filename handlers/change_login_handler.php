<?php
session_start();

require_once __DIR__ . '/../helpers/redirect.php';
require_once __DIR__ . '/../models/User.php';

function change_login($new_login)
{
    if (!$new_login) {
        $_SESSION['notification'] = 'Не все поля введены';
        redirect_to('/');
    }

    try {
        $user = User::getOne(array('login' => $new_login));
        $_SESSION['notification'] = 'Уже существует пользователь с данным логином';
        redirect_to('/change_info');
    } catch (ORMException $e) {
        print($_SESSION['user']['id']);
        $user = User::getOne(array('id' => $_SESSION['user']['id']));
        $user->login = $new_login;
        $user->save();
        $_SESSION['user']['login'] = $new_login;
        $_SESSION['notification'] = 'Логин успешно сменён!';
        redirect_to('/');
    }
}