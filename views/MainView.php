<?php


namespace views;


use base\View;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class MainView extends View
{
    public function get($kwargs)
    {
        require_once 'templates/main.php';
    }
}