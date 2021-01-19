<?php

require_once __DIR__ . '/../orm/Model.php';

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

    public function _create(): bool
    {
        $this->password = self::__hash_password($this->password);
        return parent::_create();
    }

    private static function __hash_password(string $password): string
    {
        $salt = self::__get_password_salt();
        return self::__get_password_hash($salt, $password);
    }

    private static function __get_password_salt(): string
    {
        return substr(str_pad(dechex(mt_rand()), 8, '0', STR_PAD_LEFT), -8);
    }

    private static function __get_password_hash(string $salt, string $password): string
    {
        return $salt . ( hash( 'whirlpool', $salt . $password ) );
    }
}