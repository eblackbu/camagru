<?php


namespace views;


require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/notification.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/redirect.php';

use base\AuthorizedView;
use base\ORMException;
use models\User;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class SettingsView extends AuthorizedView
{
    public function get($kwargs)
    {
        require_once 'templates/settings.php';
    }

    public function post($kwargs)
    {
        $new_login = $_POST['new_login'];
        $new_password = $_POST['new_password'];
        $old_password = $_POST['old_password'];
        //is_comment_notificate = $_POST['is_comment_notificate'] -> для кнопки "отправлять уведомление о комменте на почту"

        if ($new_login)
        {
            try {
                $user = User::getOne(array('login' => $new_login));
                $_SESSION['notification'] = 'Уже существует пользователь с данным логином';
                redirect_to('/settings');
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
        else if ($new_password and $old_password)
        {
            if (!check_password_strength($new_password))
            {
                $_SESSION['notification'] = 'Ваш пароль не удовлетворяет требованиям безопасности';
                redirect_to('/settings');
            }

            $user = User::getOne(array('id' => $_SESSION['user']['id']));
            if (!$user->checkPassword($old_password))
            {
                $_SESSION['notification'] = 'Старый пароль неверен';
                redirect_to('/settings');
            }

            $user->changePassword($new_password);
            $_SESSION['notification'] = 'Пароль успешно заменен!';
            redirect_to('/');
        }
        else
            redirect_to('/404');
    }
}