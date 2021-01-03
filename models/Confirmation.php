<?php


class Confirmation extends Model
{
    public ?int $id = null;
    public ?string $login = null;
    public ?string $password = null;
    public ?string $email = null;

    public array $_fields = [
        'id',
        'login',
        'password',
        'email'
    ];
}