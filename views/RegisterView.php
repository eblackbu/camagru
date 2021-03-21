<?php


namespace views;

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/notification.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/redirect.php';

use base\View;
use models\User;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class RegisterView extends View
{
    public function get($kwargs)
    {
        require_once 'templates/register.php';
    }

    public function post($kwargs)
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        if (!$login || !$password || !$email) {
            $_SESSION['notification'] = 'Не все поля введены';
            redirect_to('/register');
        }

        if (!check_existing_login($login))
        {
            $_SESSION['notification'] = 'Данный логин уже занят. Попробуйте выбрать другой';
            redirect_to('/register');
        }

        if (!check_password_strength($password))
        {
            $_SESSION['notification'] = 'Ваш пароль не удовлетворяет требованиям безопасности';
            redirect_to('/register');
        }

        if (!check_email($email))
        {
            $_SESSION['notification'] = 'Email введен неверно';
            redirect_to('/register');
        }

        $user = new User(array(
            'login' => $login,
            'password' => $password,
            'email' => $email,
            'is_admin' => false
        ));
        $user->save();
        $_SESSION['notification'] = 'Регистрация завершена';

//    $confirmation = new Confirmation(array(
//        'login' => $login,
//        'password' => $password,
//        'email' => $email
//    )); //TODO удаление заявки по истечению определенного таймера
//
//    $confirmation->save();
//    $hash = hash( 'whirlpool', $confirmation->login . $confirmation->password);
//
//    $headers  = "MIME-Version: 1.0\r\n";
//    $headers .= "Content-type: text/html; charset=utf-8\r\n";
//    $headers .= "To: <$email>\r\n";
//    $headers .= "From: <camaagru_test@gmail.com>\r\n";
//    $message = '
//                <html>
//                <head>
//                <title>Подтвердите Email</title>
//                </head>
//                <body>
//                <p>Что бы подтвердить Email, перейдите по <a href="http://localhost:8000/submit_register.php?login=' . $login . '&hash=' . $hash . '">ссылке</a></p>
//                </body>
//                </html>
//                ';
//    if (mail($email, "Подтвердите Email на сайте", $message, $headers))
//        $_SESSION['notification'] = 'Подтвердите на почте';
//    else
//        $_SESSION['notification'] = 'Не получилось отправить письмо';
        redirect_to('/');
    }
}