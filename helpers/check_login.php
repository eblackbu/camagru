<?php

use base\ORMException;
use models\Confirmation;
use models\User;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

function check_existing_login(string $login): bool
{
    try {
        $user = User::getOne(array('login' => $login));
        return False;
    } catch (ORMException $e) {
    }
    try {
        $conf = Confirmation::getOne(array('login' => $login));
        return False;
    } catch (ORMException $e) {
        return True;
    }
}

function check_password_strength(string $password): bool
{
    return !(strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password));
}

function check_email(string $email): bool
{
    return True; // TODO
}