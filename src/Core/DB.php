<?php
namespace Core;

class DB
{
    private $pdo;
    private static $DBInstance;

    /** @var string */
    private static $dbName;
    private static $host;
    private static $user;
    private static $password;

    private function __construct()
    {
        $this->pdo = new \PDO(
            'mysql:dbname=' . self::$dbName . ';host=' . self::$host,
            self::$user,
            self::$password, [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public static function initConf(string $dbName, string $host, string $user, string $password)
    {
        self::$dbName = $dbName;
        self::$host = $host;
        self::$user = $user;
        self::$password = $password;
    }

    public static function connect()
    {
        if(is_null(self::$DBInstance))
        {
            self::$DBInstance = new DB();
        }
        return self::$DBInstance;
    }

    public function instance(): \PDO
    {
        return $this->pdo;
    }
}