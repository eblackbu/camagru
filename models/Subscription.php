<?php


namespace models;


use base\Model;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class Subscription extends Model
{
    public ?int $id = null;
    public ?int $user_where = null;
    public ?int $user_from = null;

    public array $_fields = [
        'id',
        'user_where',
        'user_from'
    ];
}