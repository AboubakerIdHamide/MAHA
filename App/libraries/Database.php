<?php

namespace App\Libraries;

class Database
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection === null) {
            // Load Environment Variables (.env)
            $dotenv = \Dotenv\Dotenv::createImmutable(dirname(dirname(__DIR__)));
            $dotenv->load();

            try {
                self::$connection = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ";charset=utf8mb4", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                // Handle connection errors
                die('Connection failed: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
