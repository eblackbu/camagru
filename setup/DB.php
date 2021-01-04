<?php

/**
 * Класс Singleton'а для подключения к бд. Возвращает обьект PDO
 */
class DB
{
    private static ?PDO $_instance = null;
    private static array $connection_options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    private function __construct() {
    }

    public static function getInstance(): PDO
    {
        require_once __DIR__ . '/database.php';
        if (self::$_instance === null) {
            try {
                self::$_instance = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, self::$connection_options);
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$_instance;
    }

    private function __clone() {
    }

    private function __wakeup() {
    }
}