<?php


namespace models;


use base\Model;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class Comment extends Model
{
    public ?int $id = null;
    public ?string $text = null;
    public ?int $created_by = null;
    public ?int $image = null;
    public ?string $created_at = null;

    public array $_fields = [
        'id',
        'text',
        'created_by',
        'image',
        'created_at'
    ];
}