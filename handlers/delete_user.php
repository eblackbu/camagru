<?php
session_start();

require_once __DIR__ . '../models/User.php';
require_once __DIR__ . '../helpers/redirect.php';

function delete_user($user_id)
{
    if ($_SESSION['user']['id'] != $user_id and !$_SESSION['user']['is_admin'])
    {
        http_response_code('403');
        redirect_to('/');
    }

    try {
        $user = User::getOne(array('id' => $user_id));
    } catch (ORMException $e) {
        $_SESSION['notification'] = 'Что то непонятное случилось, сообщите разработчикам';
        redirect_to('/404');
    }
    $user->delete();
    http_response_code('204');
    redirect_to('/logout');
}