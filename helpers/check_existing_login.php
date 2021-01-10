<?php

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