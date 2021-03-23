<?php


namespace views;


use base\AuthorizedView;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class MainView extends AuthorizedView
{
    public function get($kwargs)
    {
        require_once 'templates/main.php';
    }
}