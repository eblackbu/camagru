<?php

session_start();
require_once 'models/User.php';

function submit_register($login, $hash)
{
    if ($login && $hash)
    {
        try {
            $confirmation = Confirmation::getOne(array('login' => $login));
        } catch (ORMException $e) {
            $_SESSION['notification'] = 'Произошла ошибка при подтверждении создания аккаунта';
            redirect_to('/');
        }
        if (hash( 'whirlpool', $confirmation->login . $confirmation->password) == $hash)
        {
            $user = new User(array(
                'login' => $confirmation->login,
                'password' => $confirmation->password,
                'email' => $confirmation->email,
                'is_admin' => false
            ));
            $user->save();
            $confirmation->delete();
            $_SESSION['notification'] = 'Вы успешно зарегистрировались! Теперь вы можете войти в свой аккаунт';
        }
        else
            $_SESSION['notification'] = 'Произошла ошибка при подтверждении создания аккаунта';
    }
    else
        $_SESSION['notification'] = 'Произошла ошибка при подтверждении создания аккаунта';
    redirect_to('/');
}
