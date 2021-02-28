<?php

require_once __DIR__ . '../models/User.php';
require_once __DIR__ . '../helpers/redirect.php';

function delete_user($user_id)
{
    try {
        $user = User::getOne(array('id' => $user_id));
    } catch (ORMException $e) {
        $_SESSION['notification'] = 'Что то непонятное случилось, сообщите разработчикам';
        redirect_to('/404');
    }
    $user->delete();
    redirect_to('/logout');
}