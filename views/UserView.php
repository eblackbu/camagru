<?php


namespace views;


use base\View;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class UserView extends View
{
    public function get($kwargs)
    {
        if (!isset($kwargs['login']))
            require_once $this->_bad_template;
        else
            require_once 'templates/user.php';
    }
}