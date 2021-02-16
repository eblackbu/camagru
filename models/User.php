<?php

require_once __DIR__ . '/../orm/Model.php';
require_once __DIR__ . '/Subscription.php';

class User extends Model
{
    public ?int $id = null;
    public ?string $login = null;
    public ?string $password = null;
    public ?string $email = null;
    public ?bool $is_admin = null;
    // TODO avatar_path

    public array $_fields = [
        'id',
        'login',
        'password',
        'email',
        'is_admin'
    ];

    protected function _create(): bool # TODO убрать когда будет двухуровневая регистрация
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
        return $salt . hash('whirlpool', $salt . $password);
    }

    public static function getSubscribersCount($id): int
    {
        try {
            $res = count(Subscription::getMany(array('user_where' => $id)));
        } catch (ORMException $e) {
            session_start();
            $_SESSION['notification'] .= 'Что то пошло не так при вычислении количества ваших подписчиков :с</br>';
            return 0;
        }
        return $res;
    }

    public static function getSubscriptionsCount($id): int
    {
        try {
            $res = count(Subscription::getMany(array('user_from' => $id)));
        } catch (ORMException $e) {
            session_start();
            $_SESSION['notification'] .= 'Что то пошло не так при вычислении количества ваших подписок :с</br>';
            return 0;
        }
        return $res;
    }

    public function checkPassword($password): bool
    {
        $salt = substr($this->password, 0, 8);
        return $this->password == self::__get_password_hash($salt, $password);
    }

    public function changePassword($new_password)
    {
        $this->password = self::__hash_password($new_password);
        $this->save();
    }
}