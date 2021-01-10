<?php

session_start();
require_once('helpers/redirect.php');
require_once('helpers/check_existing_login.php');
require_once('models/User.php');
require_once('models/Confirmation.php');

function register($login, $password, $email)
{
    if (!$login || !$password || !$email) {
        $_SESSION['notification'] = 'Не все поля введены';
        redirect_to('/register');
    }

    if (!check_existing_login($login))
    {
        $_SESSION['notification'] = 'Данный логин уже занят. Попробуйте выбрать другой';
        redirect_to('/register');
    }

    $confirmation = new Confirmation(array(
        'login' => $login,
        'password' => $password,
        'email' => $email
    )); //TODO удаление заявки по истечению определенного таймера

    $confirmation->save();
    $hash = hash( 'whirlpool', $confirmation->login . $confirmation->password);

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "To: <$email>\r\n";
    $headers .= "From: <test@email.com>\r\n";
    $message = '
                <html>
                <head>
                <title>Подтвердите Email</title>
                </head>
                <body>
                <p>Что бы подтвердить Email, перейдите по <a href="http://localhost:8000/submit_register.php?login=' . $login . '&hash=' . $hash . '">ссылке</a></p>
                </body>
                </html>
                ';
    if (mail($email, "Подтвердите Email на сайте", $message, $headers))
        $_SESSION['notification'] = 'Подтвердите на почте';
    else
        $_SESSION['notification'] = 'Не получилось отправить письмо';
    redirect_to('/');
}