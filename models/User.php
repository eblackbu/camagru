<?php


namespace models;


use base\Model;
use base\ORMException;
use setup\DB;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class User extends Model
{
    public ?int $id = null;
    public ?string $login = null;
    public ?string $password = null;
    public ?string $email = null;
    public ?bool $is_admin = null;
    public ?int $avatar_path = null;

    public array $_fields = [
        'id',
        'login',
        'password',
        'email',
        'is_admin',
        'avatar_path',
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

    public static function getSubscribersCount(int $id): int
    {
        try {
            $res = Subscription::getCount(array('user_where' => $id));
        } catch (ORMException $e) {
            session_start();
            $_SESSION['notification'] .= 'Что то пошло не так при вычислении количества ваших подписчиков :с</br>';
            return 0;
        }
        return $res;
    }

    public static function getSubscriptionsCount(int $id): int
    {
        if (!$id)
            return 0;
        try {
            $res = Subscription::getCount(array('user_from' => $id));
        } catch (ORMException $e) {
            session_start();
            $_SESSION['notification'] .= 'Что то пошло не так при вычислении количества ваших подписок :с</br>';
            return 0;
        }
        return $res;
    }

    public function checkPassword(string $password): bool
    {
        $salt = substr($this->password, 0, 8);
        return $this->password == self::__get_password_hash($salt, $password);
    }

    public function changePassword(string $new_password)
    {
        $this->password = self::__hash_password($new_password);
        $this->save();
    }

    public function setAvatar($image)
    {
        // TODO
    }

    public static function getUsersBySearch($search_string): array
    {
        $prepared_string = 'SELECT * FROM `User` WHERE `User`.`login` LIKE :search_string';
        self::$pdo = DB::getInstance();
        $query = self::$pdo->prepare($prepared_string);
        $login = '%' . $search_string . '%';
        $query->bindParam(':search_string', $login);
        $result = $query->execute();
        $data = $query->fetchaLl();
        $query->closeCursor();
        return array_map(function ($row) {
            return new User($row);
        }, $data);
    }
}