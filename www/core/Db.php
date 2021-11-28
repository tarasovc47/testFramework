<?php
namespace core;
use PDO;
class Db
{
    private static $db = null;

    /**
     * @return PDO|null
     * паттерн singleton
     */
    public static function getConnection()
    {
        if (!self::$db)
        {
            $params = require ROOT . 'config/db.php';
            self::$db = new PDO(
                $params['dsn'],
                $params['user'],
                $params['password'],
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
            );
        }
        return self::$db;
    }

    /**
     * убираем возможность установки нового соединение
     */
    private function __clone(){}
    private function __wakeup(){}
}