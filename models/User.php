<?php


class User extends Model
{
    public ?int $id = null;
    public ?string $login = null;
    public ?string $password = null;
    public ?string $username = null;
    public ?string $email = null;
    public ?bool $is_admin = null;

    public array $_fields = [
        'id',
        'login',
        'password',
        'username',
        'email',
        'is_admin'
    ];
}