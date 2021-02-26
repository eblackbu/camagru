<?php

require_once __DIR__ . '/../models/User.php';

function search($search_string)
{
    header('Content-type: application/json');
    if (!$search_string)
        echo json_encode(array());
    $users = User::getUsersBySearch($search_string);
    echo json_encode(array_map(function ($user) {
        return $user->toJson();
    }, $users));
}