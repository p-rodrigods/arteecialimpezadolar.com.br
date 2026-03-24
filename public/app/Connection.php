<?php 

namespace app;

class Connection
{
    public static function getDb()
    {
        try {
            $conn = new \PDO("mysql:host=localhost;dbname=", "root", "");
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }
}
