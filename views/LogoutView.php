<?php


namespace views;


require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/notification.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/redirect.php';

use base\View;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class LogoutView extends View
{
    public function get($kwargs)
    {
        session_start();
        unset($_SESSION['user']);
        session_destroy();
        redirect_to('/');
    }
}