<?php

namespace App\Libraries;

class Database
{
    private static $connection = null;

    public static function getConnection()
    {
        require_once '../App/config/env.php';

        if (self::$connection === null) {
            try {
                self::$connection = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                // Handle connection errors
                die('Connection failed: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
