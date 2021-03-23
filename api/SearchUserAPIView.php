<?php


namespace api;

use base\AuthorizedView;
use models\User;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class SearchUserAPIView extends AuthorizedView
{
    public function get($kwargs)
    {
        $search_string = $_GET['search_string'];
        header('Content-type: application/json');

        if (!$search_string)
            echo json_encode(array());
        $users = User::getUsersBySearch($search_string);
        echo json_encode(array_map(function ($user) {
            return $user->to_json();
        }, $users));
    }
}