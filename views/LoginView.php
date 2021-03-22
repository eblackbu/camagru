<?php


namespace views;


require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/notification.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/redirect.php';

use base\View;
use base\ORMException;
use models\User;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class LoginView extends View
{
    public function get(array $kwargs)
    {
        require_once 'templates/login.php';
    }

    public function post(array $kwargs)
    {
        session_start();
        $_login = $_POST['login'];
        $_password = $_POST['password'];

        if (!$_POST['login'] || !$_POST['password']) {
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
}