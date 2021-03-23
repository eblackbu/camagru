<?php


namespace api;

use base\AuthorizedView;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class UserAPIView extends AuthorizedView
{

}