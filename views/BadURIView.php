<?php


namespace views;


use base\View;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class BadURIView extends View
{
    public function get($kwargs)
    {
        http_response_code(404);
        require_once 'templates/404.php';
    }
}